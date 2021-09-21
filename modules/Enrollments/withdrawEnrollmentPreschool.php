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
require_once('config.php');
require_once('modules/Config/ConfigPreschool.php');  
require_once('modules/Students/StudentPreschool.php');
require_once('modules/Subjects/SubjectPreschool.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/SchedulePreschool.php');
require_once('modules/Schedules/BlockSectionSubjectPreschool.php');
require_once('modules/Schedules/BlockSectionPreschool.php');
require_once('modules/Enrollments/EnrollmentPreschool.php');
require_once('modules/Enrollments/EnrollmentDetailPreschool.php');
require_once('modules/Account/AccountDetailPreschool.php');
require_once('modules/Account/AccountPreschool.php');
require_once('modules/Payments/RegistrationPaymentPreschool.php');

require_once('modules/Enrollments/EnrollmentPreschoolLog.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

/**
 *  this file is for early withdrawals of enrollment
 */
global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Withdraw Preschool Enrollment");
if ($access->check_access($current_user->id,$accessCode)) {
    $enID = $_GET['enID'];
    
    $enrollment = new Enrollment($enID);
    $enrollment_status = $enrollment->rstatus;
    
    // get the status of the enrollment
    $enrollment_status = $enrollment->rstatus;
    
    if ($enrollment->enID) {
        // check if record is exist
        if ( !empty($enrollment->idno) ) {
            // delete user group record
            if ($enrollment->withdrawEnrollment()) {
                
                if ($enrollment->secID) {
            	    $blocksection = new BlockSection($enrollment->secID);
            	    $blocksection->noEnrolled--;
            	    $blocksection->updateBlockSection();
                }
                
                // update the schedules number of student enrolled
                if ($enrollment->subjs) {
                    foreach ($enrollment->subjs as $sched) {
                        $schedule = new Schedule($sched['schedID']);
                        $schedule->noEnrolled--;  // add 1 to the enrollment student
                        $schedule->updateScheduleStatus();
                    }
                }
                
                // update the student account
                $student = new Student($enrollment->idno);
                $account = new Account($student->accID);
                $account_detail = new AccountDetail();

                
				$account_detail = new AccountDetail();
				
				if ($account->details) {
		    	    $fees = 0;
		    	    $less_adjustments= 0;
		    	    $add_adjustments = 0;
		    	    $reg_fees = 0;
		    	    foreach ($account->details as $data) {
		    	        if (strtoupper($data['feeType'])=="ADD") {
		                    $add_adjustments += $data['amount'];        
		    	        } else if (strtoupper($data['feeType'])=="LESS") {
		                    $less_adjustments += $data['amount'];        
		                } else if (strtoupper($data['feeType'])=="LABORATORY") {
		                    $lab_fees += $data['amount'];  
		                } else if (strtoupper($data['feeType'])=="REGISTRATION") {
		                    $reg_fees += $data['amount'];         
		    	        } else {
		    	            $fees += $data['amount'];  
		    	        }
		    	        
		    	        if ($enrollment_status==2) {
                            if (strtoupper($data['particular'])!="REGISTRATION") {
                                // update the account particulars    
                                $account_detail->accDetailID = $data['accDetailID'];
                                $account_detail->accID       = $data['accID'];
                                $account_detail->feeType     = $data['feeType'];
                                $account_detail->particular  = $data['particular'];
                                $account_detail->amount      = 0;
                                $account_detail->rstatus     = $data['rstatus'];
                                $account_detail->updateAccountDetail();
                            }
                        } else {
                            // update the account particulars
                            $account_detail->accDetailID = $data['accDetailID'];
                            $account_detail->accID       = $data['accID'];
                            $account_detail->feeType     = $data['feeType'];
                            $account_detail->particular  = $data['particular'];
                            $account_detail->amount      = 0;
                            $account_detail->rstatus     = $data['rstatus'];
                            $account_detail->updateAccountDetail();
                        }
		    	        
		    	    } 	
		    	}
                
                $account->totalFee -= ($fees+$lab_fees+$add_adjustments);
                $account->balance  -= ($fees+$lab_fees+$add_adjustments);
                
                $account->totalFee += $less_adjustments;
                $account->balance  += $less_adjustments;
                
                // check if there is a payment in registration
                $regPayment = new RegistrationPayment();
                $where[0]['idno']    = "='".$enrollment->idno."' AND ";
                $where[0]['schYear'] = "='".$enrollment->schYear."' ";
                $regResult = $regPayment->retrieveAllRegistrationPayments($where);

                if ($regResult) {
                    if ($regResult[0]['amount']) {
                        // has regisrtation payment
                        // no action
                    } else {
                        // no registration payment
                        $account->balance  -= $reg_fees;
                    }
                } else {
                    // no registration payment
                    $account->totalFee -= $reg_fees;
                    $account->balance  -= $reg_fees;
                }                   
                
                $account->updateAccount();
                
                // logs here... ------------------------------
                $enrollmentLog = new EnrollmentLog();
		        $enrollmentLog->enID 	= $enID;
		        $enrollmentLog->docType = "Withdraw";
		        $enrollmentLog->subjects= "All subjects";
		        $enrollmentLog->changeBy= $current_user->id;
		        $enrollmentLog->createEnrollmentLog();
		        // --------------------------------------------
                
                $msg = "Record successfully withdrawn!";
        		$sugar_smarty->assign('class', 'notificationbox');
            } else {
                $msg = "Record was not successfully withdrawn!";
        	    $sugar_smarty->assign('class', 'errorbox');
            }
        } else {
            $msg = "Enrollment ID does not exist!";
    	    $sugar_smarty->assign('class', 'errorbox');
        }
    } else {
        $msg = "Error: No Enrollment ID set!";
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
setTimeout("redirect('index.php?module=Enrollments&action=viewEnrollmentPreschool&enID=<?php echo $enID; ?>')", 3000);
</script>