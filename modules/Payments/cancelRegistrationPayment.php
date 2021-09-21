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
require_once('modules/Config/RecordLog.php');
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
require_once('modules/Payments/PaymentType.php');
require_once('modules/Payments/RegistrationPayment.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$recordLog = new RecordLog();

$regPaymentID = $_GET['regPaymentID'];
$schYear 	  = $_GET['schYear'];
$semCode 	  = $_GET['semCode'];
$idno 		  = $_GET['idno'];
$amount		  = $_GET['amount'];
$type		  = $_GET['type'];

$regPayment = new RegistrationPayment($regPaymentID);

if ($regPayment->regPaymentID) {
    // check if record is exist
    if ( !empty($regPayment->regPaymentID) ) {
        // cancel payment record
			
            //Account and enrollment instance
			$account 		= new Account();

			if ($schYear) {
				$where[0]['schYear'] = "= '$schYear' AND ";             	
            }
            if ($semCode) {
			   $where[0]['semCode'] = "= '$semCode' AND ";
			}
            if ($idno) {
			   $where[0]['idno'] = "= '$idno' AND ";
			}
			$where[0]['rstatus'] = "= 1";

			//retrieving for enrollment
			$result 	= $account->retrieveAllAccounts($where);

			//account instance where accID = $result [0][accID]
			$account1 = new Account($result[0][accID]);

			$account1->payment -= $_GET['amount']; 
			$account1->balance += $_GET['amount']; 
			$account1->rstatus = '1'; 
			$account1->updateAccount();

			//if payment is registration type devalidate the student enrollment
			if ($type == '1') {
				$enrollment 	= new Enrollment();
				unset($where);
				if ($schYear) {
					$where[0]['enrollments.schYear'] = "= '$schYear' AND ";             	
	            }
	            if ($semCode) {
				   $where[0]['enrollments.semCode'] = "= '$semCode' AND ";
				}
	            if ($idno) {
				   $where[0]['enrollments.idno'] = "= '$idno' AND ";
				}
				   $where[0]['enrollments.rstatus'] = "= 2";
				//retrieving for enrollment
	
				$resulten 	= $enrollment->retrieveAllEnrollments($where);
	
				//enrollment instance where enID = $resulten [0][enID]
				$enrollval = new Enrollment($resulten[0]['enID']);
				$enrollval->devalidateEnrollment();
			}
			//create record log
			$recordLog = new RecordLog();

			$recordLog->docType 		= "Col RegPayment";
			$recordLog->recID 			= $regPaymentID;
			$recordLog->logDate 		= date("Y-m-d H:i:s", time());
			$recordLog->operation 		= "Cancel";
			$recordLog->fields 			= "Amount = ".$_GET['amount'];
			$recordLog->user_id 		= $current_user->id;
			$recordLog->createRecordLog();

			if ($regPayment->cancelRegistrationPayment()) {
            $msg = "Record successfully cancelled!";
    		$sugar_smarty->assign('class', 'notificationbox');
        } else {
            $msg = "Record was not successfully cancelled!";
    	    $sugar_smarty->assign('class', 'errorbox');
        }
    } else {
        $msg = "Registration Payment ID does not exist!";
	    $sugar_smarty->assign('class', 'errorbox');
    }
} else {
    $msg = "Error: Registration Payment ID not set!";
    $sugar_smarty->assign('class', 'errorbox');
}

$sugar_smarty->assign('display', 'block');
$sugar_smarty->assign('msg', $msg );
echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
?>

<script language="javascript">
setTimeout("redirect('index.php?module=Payments&action=viewRegistrationPayment&regPaymentID=<?php echo $regPaymentID ?>')", 3000);
</script>