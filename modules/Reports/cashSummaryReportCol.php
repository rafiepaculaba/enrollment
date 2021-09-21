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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_CUR'], $mod_strings['LBL_MODULE_TITLE_CR_COL'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Cash Summary Report Col");
if ($access->check_access($current_user->id,$accessCode)) {
    
    // get all default setting from configs
    $config = new Config();

    /**
     * get the Cash Summary
     */
    //$db = new Database(3);
    $reportClass = new ReportClass();
    
    //Get default dates
    $fromdate = date("m/d/Y",time());
    $todate   = $fromdate;
    
        
    if($_POST['theForm']) {
    	
    	//Get values
	    $fromdate = trim($_POST['fromdate']);
	    $todate   = trim($_POST['todate']);
    	
    	// get all Accounting Users
        $user = new User2();
    	$where[0]['groupID']="=13";
    	$user_list = $user->retrieveAllUsers($where,'');
    	$result = array();
        $index=0;
        $ctr = 0;
        if ($user_list) {
            
            foreach ($user_list as $user_list) {
                $result[$index]=array();
                $result[$index]['user_name']=$user_list['first_name']." ".$user_list['last_name'];
                
                $fdate = date('Y-m-d', strtotime($fromdate));
                $tdate = date('Y-m-d', strtotime($todate));
                
                $id = $user_list['id'];
                
                $query1 = " SELECT sum( orheader.totalAmount ) AS total_amount FROM orheader WHERE orheader.dateCreated >= '$fdate' AND orheader.dateCreated <= '$tdate' AND orheader.cashier = '$id' AND orheader.rstatus=1 ";

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
        }
        $sugar_smarty->assign('RESULT', $reportClass->cashSummaryReportCollege($result));
    }

	$sugar_smarty->assign('fromdate', $fromdate);
	$sugar_smarty->assign('todate', $todate);
	$sugar_smarty->assign('schYear', $default_schYear);
	$sugar_smarty->assign('semCode', $default_semCode);
	$sugar_smarty->assign('term', $term);
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Reports/templates/cashSummaryReportCol.tpl');	
    calendarSetup('fromdate', 'jscal_trigger1');
    calendarSetup('todate', 'jscal_trigger2');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script>
addToValidate('frmCashSummaryReport','fromdate', '', true, 'From Date');
addToValidate('frmCashSummaryReport','todate', '', true, 'To Date');
</script>

<script language="javascript">

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=500,left = 0,top = 0');");
}

// set focus
$('fromdate').focus();

</script>

