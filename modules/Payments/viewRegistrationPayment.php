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

require_once('modules/Config/ConfigCol.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');
require_once('modules/Schedules/Schedule.php');
require_once('modules/Schedules/BlockSectionCol.php');
require_once('modules/Schedules/BlockSectionSubjectCol.php');
require_once('modules/Enrollments/EnrollmentCol.php');
require_once('modules/Enrollments/EnrollmentDetailCol.php');
require_once('modules/Payments/RegistrationPayment.php');
require_once('modules/Account/AccountDetailCol.php');
require_once('modules/Account/Account.php');
require_once('modules/Config/RecordLog.php');

//require_once('common.php');
//require_once('modules/Config/ConfigCol.php');
//require_once('modules/Departments/Department.php');
//require_once('modules/Courses/Course.php');
//require_once('modules/Students/StudentCol.php');
//require_once('modules/Payments/PaymentType.php');
//require_once('modules/Payments/Payment.php');
//require_once('modules/Payments/RegistrationPayment.php');
//

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$config = new Config();
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Col Registration Payment");
if ($access->check_access($current_user->id,$accessCode)) {

	$enrollment = new Enrollment();
	
	$regPaymentID = $_GET['regPaymentID'];
	$regpayment = new RegistrationPayment($regPaymentID);

	
	if ( $regPaymentID ) {
	$date = date("m/d/Y",strtotime($regpayment->date));

	switch ($regpayment->semCode) {
		case 1:
			$semCode = "1st Sem";
			break;
		case 2:
			$semCode = "2nd Sem";
			break;
		case 4:
			$semCode = "Summer";
			break;
	}
	
	switch ($regpayment->type) {
		case 1:
			$dtype = " Registration ";
			break;
		case 2:
			$dtype = " Down Payment ";
			break;
	}
	$sugar_smarty->assign('regPaymentID', $regpayment->regPaymentID );
	$sugar_smarty->assign('schYear', $regpayment->schYear );
	$sugar_smarty->assign('semCode', $regpayment->semCode );
	$sugar_smarty->assign('semdCode', $semCode );
	$sugar_smarty->assign('idno', $regpayment->idno );
	$sugar_smarty->assign('ORno', $regpayment->ORno );
	$sugar_smarty->assign('type', $regpayment->type );
	$sugar_smarty->assign('dtype', $dtype );
	$sugar_smarty->assign('date', $date );
	$sugar_smarty->assign('amount', $regpayment->amount );
	$sugar_smarty->assign('encodedBy', $regpayment->encodedBy );
	$sugar_smarty->assign('rstatus', $regpayment->rstatus );

	$sugar_smarty->assign('studName', $regpayment->studName );
	
    
	unset($regpayment->where);
	if ($regpayment->schYear) {
		$where[0]['enrollments.schYear'] = "= '$regpayment->schYear' AND ";             	
    }
    if ($regpayment->semCode) {
	   $where[0]['enrollments.semCode'] = "= '$regpayment->semCode' AND ";
	}
    if ($regpayment->idno) {
	   $where[0]['enrollments.idno'] = "= '$regpayment->idno'";
	}
	$resulten 	= $enrollment->retrieveAllEnrollments($where);
	
	if ($regpayment->rstatus == 1 && $regpayment->schYear == $config->getConfig('School Year') && $regpayment->semCode == $config->getConfig('Semester')) {
		// to check if the user has an access in edit
	    $accessCode = $access->getAccessCode("Edit Col Registration Payment");
	    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
	    
	    // to check if the user has an access in delete
	    if (!$resulten) {
		    $accessCode = $access->getAccessCode("Cancel Col Registration Payment");
		    $sugar_smarty->assign('hasCancel', $access->check_access($current_user->id, $accessCode) );
	    }
	}
	
	echo $sugar_smarty->fetch('modules/Payments/templates/viewRegistrationPayment.tpl');
	} else {
	    $msg = "Payment ID not found!";
	    $sugar_smarty->assign('class', 'errorbox');
	    $sugar_smarty->assign('display', 'block');
	    $sugar_smarty->assign('msg', $msg );
	    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	}
	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script language="javascript">
function cancelRegistrationPayment(regPaymentID, schYear, semCode, idno, amount, type)
{
    reply=confirm("Do you really want to cancel the Payment?");

    if (reply==true)
        redirect('index.php?module=Payments&action=cancelRegistrationPayment&regPaymentID='+regPaymentID+'&schYear='+schYear+'&semCode='+semCode+'&idno='+idno+'&amount='+amount+'&type='+type);
}
</script>