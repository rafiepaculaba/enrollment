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
echo "\n<p>\n";
echo get_module_title('collectionReports-college', $mod_strings['LBL_MODULE_TITLE_CR_COL'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Cashier Report Col");
if ($access->check_access($current_user->id,$accessCode)) {
    
    // get all default setting from configs
    $config = new Config();
    $accountMaster = new ChartAccountMaster();
    if ($_POST['theForm']) {
        // filter result
        // get the default school year
        $schYear = $default_schYear = $_POST['schYear'];
        
        // get the default semester
        $semCode = $default_semCode = $_POST['semCode'];
        
        $date    = $_POST['date'];
        $cashier = $_POST['cashier'];
        
        $paymentdate = date('Y-m-d', strtotime($date));
        
        /**
         * get the chashiers
         */
        // get all courses
        //$db = new Database(3);
        $reportClass = new ReportClass();
        
        $result = array();
        $index=0;
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
        $sugar_smarty->assign('RESULT', $reportClass->cashierReportCollege($data));
    
    } else {
        // get the default school year
        $default_schYear = $config->getConfig('School Year');
        // get the default semester
        $default_semCode = $config->getConfig('Semester');
        
        $sugar_smarty->assign('RESULT', "");
        
        $date = date('Y/m/d');
    }

    //User list (Accounting)
	$user = new User2($current_user->id);
	unset($where);

	if ($user->groupID==13) {
		// the current user is a cashier/accounting
		$where[0]['id'] = "='".$user->id."' "; // assuming 3-default groupID of Accounting
	    $sugar_smarty->assign('isCashierGroup', 1);
	    $cashier=$user->id;
	} else {
		//User list
		$where[0]['groupID']="=13";
		$sugar_smarty->assign('isCashierGroup', 0);
	}
	
	$user_list = $user->retrieveAllUsers($where,'');
	$sugar_smarty->assign('user_list', $user_list);
    
    $semesters='<select name="semCode" id="semCode" >'."\n";
    $semesters.='<option value="">-----------------------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$default_semCode) {
                $semesters .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    
    $semesters.='</select>';
    $sugar_smarty->assign('SEMESTERS', $semesters);
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear">'."\n";
	$schYear.='<option value="">-----------------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	        if ($value==$default_schYear) {
	           $schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$schYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);
	
	$sugar_smarty->assign('schYear', $default_schYear);
	$sugar_smarty->assign('semCode', $default_semCode);
	$sugar_smarty->assign('date', $date);
	$sugar_smarty->assign('cashier', $cashier);
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Reports/templates/cashierReportCol.tpl');	
    calendarSetup('date', 'jscal_trigger');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script>
addToValidate('frmCashierReportCol','schYear', '', true, 'School Year');
addToValidate('frmCashierReportCol','semCode', '', true, 'Semester');
addToValidate('frmCashierReportCol','date', '', true, 'Date');
addToValidate('frmCashierReportCol','cashier', '', true, 'Cashier');
</script>

<script language="javascript">

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=500,left = 0,top = 0');");
}


// set focus
$('cashier').focus();

</script>

