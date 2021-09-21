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
require_once('modules/Config/ConfigHS.php');
require_once('modules/Subjects/SubjectHS.php');
require_once('modules/Students/StudentHS.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleHS.php');
require_once('modules/Schedules/BlockSectionHS.php');
require_once('modules/Schedules/BlockSectionSubjectHS.php');
require_once('modules/Enrollments/EnrollmentDetailHS.php');
require_once('modules/Enrollments/EnrollmentHS.php');
require_once('modules/Payments/PaymentHS.php');
require_once('modules/Account/AccountDetailHS.php');
require_once('modules/Account/AccountHS.php');
require_once('modules/SchoolFees/SchoolFeeHS.php');

require_once('modules/Enrollments/EnrollmentHSLog.php');
require_once('modules/Payments/ORHeaderHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS'], false);
echo "\n</p>\n";
global $theme;
global $current_user;
global $feeCodes;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['enID'])) {
    $enID = $_POST['enID'];
    $enrollment = new Enrollment($enID);
} else {
    $enrollment = new Enrollment();
}

// check if comes from correct form
if ( isset($_POST['theForm']) ) {
    
    if (isset($_POST['enID'])) {
        $enrollment->enID = $_POST['enID'];
    }
	
	if ($enrollment->enID) {
	    // update existing record
	    $enrollment->schYear   = $_POST['schYear'];
    	$enrollment->idno      = $_POST['idno'];
    	$enrollment->secID     = $_POST['secID'];
    	$enrollment->yrLevel   = $_POST['yrLevel'];
    	
    	$enrollment->ttlUnits  = $enrollment->getTotalUnits($_SESSION['SCHEDULES']);
    	$enrollment->lastEdited  = date("Y-m-d",time());
	    
	    // update student record
	    if ($enrollment->updateEnrollment()) {
	        $lastID = $enrollment->enID;
	        
	        // update all prev details subjects
	        $orig_subjs = array();
            foreach ($enrollment->subjs as $row) {
                // update schedule enrolled student
                $schedule = new Schedule($row['schedID']);
                $schedule->noEnrolled--;  // add 1 to the enrollment student
                $schedule->updateScheduleStatus();
                
                $orig_subjs[]=$schedule->schedCode;
            }
	        
	        // clear the shedule details
	        // setting conditions
	        $conds[]['enID'] = " = '".$enrollment->enID."'";
    	    $enrollment->tables = "enrollment_details";
    	    $enrollment->conds  = $conds;
    	    
    	    // building an select query
    	    $query = $enrollment->Delete();  // generate delete sql query
    	    $enrollment->reset();            // reset all variables in query generator
    	 
    	    try { 
    		    $enrollment->db->beginTransaction();
        		$enrollment->db->exec($query);
        		$enrollment->db->commit();
        		$error=false;
            } catch(PDOException $e){
                $enrollment->db->rollBack();
                $error=true;
            }
            
            // save the new sets of subjects
            $enrollmentDetail = new EnrollmentDetail();
            
    	    // get all details subjects
    	    $new_subjs = array();
            foreach ($_SESSION['SCHEDULES'] as $row) {
                $enrollmentDetail->enID     = $lastID;
                $enrollmentDetail->schedID  = $row['schedID'];
                $enrollmentDetail->subjID   = $row['subjID'];
                $enrollmentDetail->createEnrollmentDetail();
                
                // update schedule enrolled student
                $schedule = new Schedule($row['schedID']);
                $schedule->noEnrolled++;  // add 1 to the enrollment student
                $schedule->updateScheduleStatus();
                //$schedule->updateSchedule();
                
                $new_subjs[]=$row['schedCode'];
            }
            
             // update the student status
            $student = new Student($enrollment->idno);
            $student->yrLevel  = $enrollment->yrLevel;
            $student->courseID = $enrollment->courseID;
            $student->updateStudent();
            
            // logging here------------------------------------------------------
	        // examine if any changes in the enrollment
	        $withdraw 	= array_diff($orig_subjs,$new_subjs);
	        // append all withrawn subjs
	        if ($withdraw) {
	        	$withdrawn = "Withdrawals: ";
	        	$ctr = 0;
	        	foreach ($withdraw as $row) {
	        		if ($ctr > 0) {
	        			$withdrawn .= ", ".$row;
	        		} else {
	        			$withdrawn .= $row;
	        		}
	        		
	        		$ctr++;
	        	}
	        }
	        
	        $additional = array_diff($new_subjs,$orig_subjs);
	        // append all additional subjs
	        if ($additional) {
	        	$add_subjs = "Additionals: ";
	        	$ctr = 0;
	        	foreach ($additional as $row) {
	        		if ($ctr > 0) {
	        			$add_subjs .= ", ".$row;
	        		} else {
	        			$add_subjs .= $row;
	        		}
	        		
	        		$ctr++;
	        	}
	        }

	        if (count($withdraw) || count($additional)) {
		        $enrollmentLog = new EnrollmentLog();
		        $enrollmentLog->enID 	= $_POST['enID'];
		        $enrollmentLog->docType = "Edit";
		        
		        $enrollmentLog->subjects= $withdrawn;
		        if (count($withdraw) && count($additional)) {
		        	$enrollmentLog->subjects .= "<br>";
		        }
		        $enrollmentLog->subjects.= $add_subjs;
		        
		        $enrollmentLog->changeBy= $current_user->id;
		        $enrollmentLog->createEnrollmentLog();
	        }
	        //-------------------------------------------------------------------
            
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	    
	} else {
	    	    
	    // create new record
	    $enrollment->schYear   = $_POST['schYear'];
    	$enrollment->idno      = $_POST['idno'];
    	$enrollment->yrLevel   = $_POST['yrLevel'];
    	$enrollment->secID     = $_POST['secID'];
    	$enrollment->studType  = $_POST['studType'];
    	$enrollment->dateCreated = date("Y-m-d",time());
    	$enrollment->ttlUnits  = $enrollment->getTotalUnits($_SESSION['SCHEDULES']);
    	$enrollment->encodedBy = $current_user->id;
    	
    	// new student record
    	if ($enrollment->createEnrollment()) {
    	    
    	    // update the blocksetion status
    	    if ($enrollment->secID) {
        	    $blocksection = new BlockSection($enrollment->secID);
        	    $blocksection->noEnrolled++;
        	    $blocksection->updateBlockSection();
            }
    	    
    	    $lastID = $enrollment->getLastID();
    	    
    	    // save the new sets of subjects
            $enrollmentDetail = new EnrollmentDetail();
            
    	    // get all details subjects
            foreach ($_SESSION['SCHEDULES'] as $row) {
                $enrollmentDetail->enID     = $lastID;
                $enrollmentDetail->schedID  = $row['schedID'];
                $enrollmentDetail->subjID   = $row['subjID'];
                $enrollmentDetail->createEnrollmentDetail();
                
                // update schedule enrolled student
                $schedule = new Schedule($enrollmentDetail->schedID);
                $schedule->noEnrolled++;  // add 1 to the enrollment student
                $schedule->updateScheduleStatus();
                //$schedule->updateSchedule();
            }
            
            // get the student
            $student = new Student($enrollment->idno);
            
            // get the latest account for old balance
            $account = new Account($student->accID);
            $account_detail = new AccountDetail();
            
            // get the latest account for old balance
            if ($account->balance!=0 && $account->balance!='') {
                $oldBalance = $account->balance;
            } else {
                $oldBalance = 0;
            }
            
            // deactivate the prev account of this student 
            $account->rstatus = 0;
            $account->updateAccount();
            
            
            // get the school fees
            $schoolFee = new SchoolFee();
            $fees = $schoolFee->getFees($enrollment->schYear, $enrollment->yrLevel);
            $totalFee = $oldBalance;
            if ($fees) {
                foreach ($fees as $fee) {
                    // get the total fee
                    $totalFee += $fee['amount'];
                }
            }
            
            // get misc and save it
            $misc = $schoolFee->getMisc($enrollment->yrLevel, $enrollment->schYear);
            
            if ($misc) {
                $totalFee += $misc['total'];
            } else { 
                $totalFee += 0;
            }
            
            // get the amount paid during registration
            $orheader = new ORHeader();
            $payments = $orheader->getRegistrationPayment($enrollment->idno, $enrollment->schYear, $enrollment->semCode);
            
            if ($payments) {
            	// check if student has prev withdrawned enrollment
	            unset($where);
	            $where[0]['enrollments.idno']    = "='".$_POST['idno']."' AND ";
	            $where[0]['enrollments.schYear'] = "='".$_POST['schYear']."' AND ";
	            $where[0]['enrollments.rstatus'] = "='0'";
	            $chkWithdrawnedEnrollment = $enrollment->retrieveAllEnrollments($where,'enrollments.schYear','DESC',0,1);
	            
	            // if student has prev withdrawned enrollment in same enrollment period
	            // the system will still required him/her to pay the registration payment
	            if (!empty($chkWithdrawnedEnrollment)) {
	            	if (count($payments)>1) {
	                   $paid = $payments[0];
	                } else {
	            	   $paid  = 0;
	                }
	            } else {
	            	$paid = $payments[0];
	            }
            } else {
                $paid = 0;
            }
            
            // set the balance
            $balance = $totalFee - $paid;
            
            // set attributes
            $account->idno      = $_POST['idno'];
	        $account->schYear   = $_POST['schYear'];
	        $account->yrLevel   = $_POST['yrLevel'];
	        $account->oldBalance= $oldBalance;
	        $account->totalFee  = $totalFee;
	        $account->payment   = $paid;
	        $account->balance   = $balance;
	        $account->createAccount();
	        
	        $account_lastID = $account->getLastID();
	        
	        // save all account particulars
	        if ($fees) {
                foreach ($fees as $fee) {
                    $account_detail->accID      = $account_lastID;
                    
                    $strA = explode(" ",strtoupper($fee['item']));
                    
                    if ( in_array("LABORATORY",$strA) || in_array("LAB",$strA) ) {
        	           $account_detail->feeType    = "Laboratory";
                    } else {
        	           $account_detail->feeType    = substr($fee['item'],0,15);
                    }
                    
        	        $account_detail->particular = $fee['item'];
        	        $account_detail->amount     = $fee['amount'];
        	        
        	        $account_detail->createAccountDetail();
                }
            }
            
            
            // save misc
            if ($misc) {
                $account_detail->amount     = $misc['total'];
            } else { 
                $account_detail->amount     = 0;
            }
            
            $account_detail->accID      = $account_lastID;
	        $account_detail->feeType    = "Miscellaneous";
	        $account_detail->particular = "Miscellaneous";
	        $account_detail->createAccountDetail();
	        
	         // update the student status
            $student->yrLevel  = $enrollment->yrLevel;
            $student->accID    = $account_lastID;
	        $student->updateStudent();
	        
	        // check if the student already paid the registration
	        // if paid: set the enrollment status to validated
	        if ($paid>0) {
	            $enrollment->enID = $enrollment->getLastID();
	            $enrollment->validateEnrollment();
	        }
	        
	        // LOGGING HERE.. ------------------------------------------
	        $enrollmentLog = new EnrollmentLog();
	        $enrollmentLog->enID 	= $enrollment->enID;
	        $enrollmentLog->docType = "Save";
	        $enrollmentLog->subjects= "Save enrollment form";
	        $enrollmentLog->changeBy= $current_user->id;
	        $enrollmentLog->createEnrollmentLog();
	        // ---------------------------------------------------------
            
    		$msg = "Record successfully saved!";
    		$sugar_smarty->assign('class', 'notificationbox');
    	} else {
    	    $msg = "Record was not successfully saved!";
    	    $sugar_smarty->assign('class', 'errorbox');
    	}
	}
	
	$sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script language="JavaScript">
<?php if ($enID) { ?>
    setTimeout("redirect('index.php?module=Enrollments&action=viewEnrollmentHS&enID=<?php echo $enID; ?>')");
<?php } else { ?>
    setTimeout("redirect('index.php?module=Enrollments&action=createEnrollmentHS')");
<?php } ?>
</script>