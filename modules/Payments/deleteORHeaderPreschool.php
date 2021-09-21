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
require_once('modules/Config/ConfigPreschool.php');
require_once('modules/Config/RecordLogPreschool.php');
require_once('modules/Subjects/SubjectPreschool.php');
require_once('modules/Students/StudentPreschool.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/SchedulePreschool.php');
require_once('modules/Schedules/BlockSectionPreschool.php');
require_once('modules/Schedules/BlockSectionSubjectPreschool.php');
require_once('modules/Enrollments/EnrollmentPreschool.php');
require_once('modules/Enrollments/EnrollmentDetailPreschool.php');
require_once('modules/Payments/ORSeries.php');
require_once('modules/Payments/ORHeaderPreschool.php');
require_once('modules/Payments/ORDetailsPreschool.php');
require_once('modules/SchoolFees/SchoolFeePreschool.php');
require_once('modules/Account/AccountDetailPreschool.php');
require_once('modules/Account/AccountPreschool.php');
require_once('modules/Account/AssessmentPreschool.php');
require_once('modules/Account/ChartAccountMaster.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Cancel Preschool OR Header");
if ($access->check_access($current_user->id,$accessCode)) {

    $paymentID 	= $_GET['paymentID'];
    $schYear   	= $_GET['schYear'];
    $idno      	= $_GET['idno'];
    $amount    	= $_GET['amount'];
    $orno		= $_GET['orno'];
    
    $orheader       = new ORHeader($paymentID);
    $ordetails      = new ORDetails();
    $orseries       = new ORSeries();
    $config         = new Config();
    $account 		= new Account();
    $enrollment 	= new Enrollment();
    
    $term               = $config->getConfig('Current Payment Term');
    $tuition            = $config->getConfig('Tuition Account Code Preschool');
    $registration       = $config->getConfig('Reg Account Code Preschool');
    $oldAccount         = $config->getConfig('Old Account Code Preschool');
    
//    $where[0]['cashier']="='$orheader->cashier'";
//    $result = $orseries->retrieveAllORSeries($where);
//    $orno = new ORSeries($result[0]['id']);
//    $orno->cancelledOR = $orno->cancelledOR + 1;
//    $orno->updateORSeries();
    
    //Delete ORDetails
    $where[0]['orno']="='$orno'";
    $resultDetails = $ordetails->retrieveAllORDetails($where);
    foreach ($resultDetails as $resultDetails) {
    	$ordetails->ordno = $resultDetails['ordno'];
    	$ordetails->deleteORDetails();
    }
    
    if ($orheader->paymentID) {
        // check if record is exist
        if ( !empty($orheader->paymentID) ) {
   		//create record log
		$recordLog = new RecordLog();
    
		$recordLog->docType 		= "Preschool Payment";
		$recordLog->recID 			= $paymentID;
		$recordLog->logDate 		= date("Y-m-d H:i:s", time());
		$recordLog->operation 		= "Delete";
		$recordLog->fields 			= "Amount = ".$amount;
		$recordLog->user_id 		= $current_user->id;
		$recordLog->createRecordPaymentLog();
        
    	// cancel  payment record
        if ($orheader->deleteORHeader()) {
            $msg = "Record successfully deleted!";
    		$sugar_smarty->assign('class', 'notificationbox');
        } else {
            $msg = "Record was not successfully deleted!";
    	    $sugar_smarty->assign('class', 'errorbox');
        }
        } else {
            $msg = "Payment ID does not exist!";
    	    $sugar_smarty->assign('class', 'errorbox');
        }
    } else {
        $msg = "Error: Payment ID not set!";
        $sugar_smarty->assign('class', 'errorbox');
    }

    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    } else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">
setTimeout("redirect('index.php?module=Payments&action=listORHeaderPreschool&paymentID=<?php echo $paymentID ?>')", 3000);
</script>