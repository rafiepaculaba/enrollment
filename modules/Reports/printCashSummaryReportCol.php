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
require_once('modules/Config/ConfigCol.php');
require_once('modules/Reports/ReportCol.php');

global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

    $config = new Config();
        
    /**
     * get the Cash Summary
     */
    //$db = new Database(3);
    $reportClass = new ReportClass();

    //User list
	
	$fromdate = $_GET['fromdate'];
	$todate   = $_GET['todate'];

	// get all Accounting Users
    $user = new User2();
	$where[0]['groupID']="=13";
	$user_list = $user->retrieveAllUsers($where,'');
    
	if(trim($fromdate) != '' && trim($todate) != '') {
    	$result = array();
        $index=0;
        $ctr = 0;
        foreach ($user_list as $user_list) {
            $result[$index]=array();
            $result[$index]['user_name']= $user_list['first_name']." ".$user_list['last_name'];
            
            $fdate = date('Y-m-d', strtotime($fromdate));
            $tdate = date('Y-m-d', strtotime($todate));
    
            $id = $user_list['id'];           
            
            $query1 = "SELECT sum( ordetails.amount ) AS total_amount FROM orheader, ordetails WHERE orheader.dateCreated >= '$fdate' AND orheader.dateCreated <= '$tdate' AND orheader.cashier = '$id' AND orheader.orno = ordetails.orno";
            
            $records1 = $reportClass->adhocQuery($query1);
    	   
            $total = $records1[0]['total_amount'];
            
            if ($total) {
    	       $result[$index][$ctr] = $total;	
            } else {    
    	       $result[$index][$ctr] = 0;	
            }
                                
            $result['gtotal'] += $result[$index][$ctr];
            
            $index++;
            $ctr++;
        }
	} else {
	    $result = '';
	}
        
    $sugar_smarty->assign('RESULT', $reportClass->printCashSummaryReportCollege($result));
      
	$sugar_smarty->assign('fromdate', $fromdate );
	$sugar_smarty->assign('todate', $todate );
	
	$sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
	
    echo $sugar_smarty->fetch('modules/Reports/templates/printCashSummaryReportCol.tpl');	
?>

<script type='text/javascript'>
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}
</script>
