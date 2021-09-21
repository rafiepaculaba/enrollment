<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version
 * 1.1.3 ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.  See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *    (i) the "Powered by SugarCRM" logo and
 *    (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * The Original Code is: SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) 2004-2006 SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/

global $current_user, $sugar_version, $sugar_config, $image_path;

require_once('include/Sugar_Smarty.php');


require_once('common.php');
require_once('modules/Config/ConfigCol.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Payments/PaymentType.php');
require_once('modules/Payments/Payment.php');
require_once('modules/Account/AccountDetailCol.php');
require_once('modules/Account/Account.php');
require_once('modules/Account/Assessment.php');
require_once('modules/Config/RecordLog.php');
require_once('modules/Reports/ReportCol.php');
require_once('modules/Account/ChartAccountMaster.php');

global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

        $config = new Config();
        $accountMaster  = new ChartAccountMaster();
        
        // excluding accounts
        $miscellaneous = $config->getConfig('Misc Account Code');
		$laboratory    = $config->getConfig('Lab Account Code');
		$compSubj      = $config->getConfig('Computer Subj Code');
    
        $cashier = $_GET['cashier'];
        $date = date("Y-m-d",strtotime($_GET['date']));
        $todate = date("Y-m-d",strtotime($_GET['todate']));
        $cashier = $_GET['cashier'];

        $reportClass = new ReportClass();
        
        $result = array();
        $index	= 0;
        $ctr	= 0;
        
	    $query = "SELECT
				    orheader.orno
				    , orheader.idno
				    , students.fname
				    , students.lname
				    , students.mname
				    , orheader.dateCreated
				    , orheader.totalAmount
				    , orheader.cashier
				FROM
				    orheader
				    INNER JOIN students 
				        ON (orheader.idno = students.idno)
				WHERE (orheader.dateCreated between '$date' and '$todate'
				    AND orheader.cashier = '$cashier')
				ORDER BY orheader.orno ASC";

        $records = $reportClass->adhocQuery($query);
        
         // get all school fees
		unset($where);
		$where[0]['account_code'] = "!='$miscellaneous' AND account_code != '$laboratory' AND account_code != '$compSubj'";
		$schoolfee_list     = $accountMaster->retrieveAllChartAccountMaster($where);

		$convertion_fees = array();
		$totals = array();
		$gtotal = 0;
		
		if ($schoolfee_list) {
			$s=0;
        	foreach ($schoolfee_list as $fee) {
        		$convertion_fees[$fee['account_name']]=$s;
        		$totals[$s] = 0;		
        		$s++;
        	}
        }
		
        foreach ($records as $row) {
    		$data[$ctr]=$row;
    		
    		if ($schoolfee_list) {
				$s=0;
	        	foreach ($schoolfee_list as $fee) {
	        		$data[$ctr]['fees'][$s] = "";		
	        		$s++;
	        	}
	        }

    		// get the or details
    		$orno = $row['orno'];
			$query1 = "SELECT
					    ordetails.orno
					    , ordetails.account_code
					    , chart_master.account_name
					    , ordetails.amount
					FROM
					    ordetails
					    INNER JOIN chart_master 
					        ON (ordetails.account_code = chart_master.account_code)
					WHERE (ordetails.orno ='$orno')";
    		$record1 = $reportClass->adhocQuery($query1);
    		
    		foreach ($record1 as $detail) {
    			$data[$ctr]['fees'][$convertion_fees[$detail['account_name']]] = number_format($detail['amount'],2);
    			$totals[$convertion_fees[$detail['account_name']]] += $detail['amount'];
    			$gtotal += $detail['amount'];
    		}
    		
    		
    		$ctr++;
    	}
    	
    	if ($data) {
    		$sugar_smarty->assign('RESULT', $data);	
    		$sugar_smarty->assign('TOTAL', $totals);	
    		$sugar_smarty->assign('GTOTAL', $gtotal);	
    	} else {
    		$sugar_smarty->assign('RESULT', "");
    	}
	
		// cashier
		$u = new User2($cashier);
		
		$sugar_smarty->assign('schoolfee_list', $schoolfee_list);
		$sugar_smarty->assign('date', $_GET['date']);
		$sugar_smarty->assign('todate', $_GET['todate']);
		$sugar_smarty->assign('cashier', htmlentities($u->last_name).", ".htmlentities($u->first_name));
		
		$sugar_smarty->assign('schName', $config->getConfig('School Name') );
		$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
		$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
		
	    echo $sugar_smarty->fetch('modules/Reports/templates/printAbstractReportCol.tpl');	
?>

<script type='text/javascript'>
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}
</script>
