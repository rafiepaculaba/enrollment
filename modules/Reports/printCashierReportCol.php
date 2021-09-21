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
require_once('modules/Students/StudentCol.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Reports/ReportCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Account/ChartAccountMaster.php');

global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

        $config = new Config();
    
        // get the default school year
        $schYear = $_GET['schYear'];
        // get the default semester
        $semCode = $_GET['semCode'];
        $cashier = $_GET['cashier'];
        $paymentdate = date('Y-m-d', strtotime($_GET['date']));
        /**
         * get the collections
         */
        // get all courses
        //$db = new Database(3);
        $reportClass = new ReportClass();
        $accountMaster = new ChartAccountMaster();
        $result = array();
        $ctr=0;
        
        $query = "Select s.*, orh.totalAmount as amount, orh.orno, c.courseCode From students as s, orheader as orh, courses as c Where orh.schYear='$schYear' AND orh.semCode='$semCode' AND orh.dateCreated='$paymentdate' AND orh.cashier='$cashier' AND s.courseID=c.courseID AND orh.idno=s.idno AND orh.rstatus=1 ORDER BY orh.orno ASC";

	    //$query = "SELECT s.*, p.amount, p.ORno, c.courseCode FROM students as s, payments as p, courses as c WHERE p.schYear='$schYear' AND  p.semCode='$semCode' AND  p.date='$paymentdate' AND  p.encodedBy='$cashier' AND s.courseID=c.courseID AND  p.idno=s.idno ORDER BY p.ORno DESC ";
		//$query = "Select distinct s.*, sum(ord.amount) as amount, orh.orno, c.courseCode From students as s, orheader as orh, ordetails as ord, courses as c Where orh.orno=ord.orno AND orh.schYear='$schYear' AND orh.semCode='$semCode' AND orh.dateCreated='$paymentdate' AND orh.cashier='$cashier' AND s.courseID=c.courseID AND orh.idno=s.idno GROUP BY s.idno ORDER BY orh.orno ASC";
	    //echo $query = "Select distinct ord.amount, orh.orno, orh.idno From orheader as orh, ordetails as ord Where orh.orno=ord.orno AND orh.schYear='$schYear' AND orh.semCode='$semCode' AND orh.dateCreated='$paymentdate' AND orh.cashier='$cashier' ORDER BY orh.orno ASC";

        $records = $reportClass->adhocQuery($query);
        
        foreach ($records as $row) {
    		$data[$ctr]=$row;

    		$orno = $row['orno'];
			$query1 = "Select account_code From ordetails Where orno='$orno' ORDER BY ordno ASC LIMIT 1";
    		
    		$record1 = $reportClass->adhocQuery($query1);
    		
    		//display schoolfee item
            $account_code = $record1[0]['account_code'];
            unset($where);
            $where[0]['account_code'] = "='$account_code'";
            $particular = $accountMaster->retrieveAllChartAccountMaster($where);
            
            $data[$ctr]['type'] = $particular[0]['account_name'];

    		$ctr++;
    	}

        $sugar_smarty->assign('RESULT', $reportClass->cashierReportCollege($data,1));
      
	$sugar_smarty->assign('SCHYEAR', $schYear);
	if ($semCode==1) {
	   $sugar_smarty->assign('SEMCODE', "1<sup>st</sup>");
	} else if ($semCode==2) {
	   $sugar_smarty->assign('SEMCODE', "2<sup>nd</sup>");
	} else if ($semCode==2) {
	   $sugar_smarty->assign('SEMCODE', "3<sup>rd</sup>");
	} else {
	   $sugar_smarty->assign('SEMCODE', "Summer"); 
	}
	
	$sugar_smarty->assign('TERM', $term);
	
	// cashier
	$u = new User2($cashier);
	
	$sugar_smarty->assign('TERM', $term);
	$sugar_smarty->assign('date', $_GET['date']);
	$sugar_smarty->assign('cashier', htmlentities($u->last_name).", ".htmlentities($u->first_name));
	
	$sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
	
    echo $sugar_smarty->fetch('modules/Reports/templates/printCashierReportCol.tpl');	
?>

<script type='text/javascript'>
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}
</script>
