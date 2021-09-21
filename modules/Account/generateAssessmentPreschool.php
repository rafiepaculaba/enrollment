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
require_once('modules/Account/AssessmentPreschool.php');

require_once('modules/Payments/RegistrationPaymentPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();


/**
 * This will generate assessments in all students enrolled in the 
 * parameters:
 *  school year
 *  semester
 *  term
 */
$schYear   = $_POST['schYear'];
$term      = $_POST['term'];

$account    = new Account();
$assessment = new Assessment();
$prev_assessment = new Assessment();
$enrollment = new Enrollment();
$student    = new Student();

$config     = new Config();

// check if comes from correct form
if ( isset($_POST['theForm']) && $schYear && $term) {
    // get all students (enrolled only) through is enrollment form
    $where[0]['enrollments.schYear'] = "='$schYear' AND ";
    $where[0]['enrollments.rstatus'] = "='2' "; // only validated enrollment will be generated
    
    $student_enrollments = $enrollment->retrieveAllEnrollments($where);
  
    if ($student_enrollments) {
        foreach ($student_enrollments as $info) {
            $student->idno = $info['idno'];
            $student->retrieveStudent();
            
            $accID = $student->accID;
            $account->accID = $student->accID;
            $account->retrieveAccount();
            
            // get particulars
            if ($account->details) {
        	    $fees = array();
        	    $less_adjustments= array();
        	    $add_adjustments = array();
        	    $addf  = 0;
        	    $less  = 0;
        	    $labf  = 0;
        	    $tfee  = 0;
        	    $regf  = 0;
        	    $miscf = 0;
        	    foreach ($account->details as $data) {
        	        if (strtoupper($data['feeType'])=="ADD") {
                        $addf += $data['amount'];
        	        } else if (strtoupper($data['feeType'])=="LESS") {
                        $less += $data['amount'];
                    } else if (strtoupper($data['feeType'])=="LABORATORY") {
                        $labf += $data['amount'];
                    } else if (strtoupper($data['feeType'])=="TUITION") {
                        $tfee += $data['amount'];
                    } else if (strtoupper($data['feeType'])=="REGISTRATION") {
                        $regf += $data['amount'];
                    } else if (strtoupper($data['feeType'])=="MISCELLANEOUS") {
                        $miscf += $data['amount'];  
        	        } else {
        	            $miscf += $data['amount'];  
        	        }
        	    }
        	}
            
            $total_terms =  $config->getConfig("Terms");           
            /**
             * ex. 
             * total_terms = 4
             * 
             * term = 1 (1st)
             * remaining_terms = (4-1) + 1 = 4
             * 
             * term = 2 (2nd)
             * remaining_terms = (4-2) + 1 = 3
             * 
             * term = 3 (3rd)
             * remaining_terms = (4-3) + 1 = 2
             * 
             * term = 4 (4th)
             * remaining_terms = (4-4) + 1 = 1
             * 
             */
            $remaining_terms = ($total_terms - $term) + 1;
            
            // get the prev assessment of the student before this term
            $prev_assID = $assessment->isExist($student->idno, $accID, $schYear, $term-1);
            $prev_assessment->assID = $prev_assID;
            $prev_assessment->retrieveAssessment();
            
            // get the prev due balance of the student
            if ($prev_assessment->ttlDue > $prev_assessment->amtPaid) {
            	$prev_due_balance = $prev_assessment->ttlDue - $prev_assessment->amtPaid;
            } else {
            	$prev_due_balance = 0;
            }
            
            // get the base installment/term ---------------------------------------------------------------------------
            // get the amount paid during registration
            $regPayment = new RegistrationPayment();
//            unset($where);
//            $where[0]['idno']    = "='".$student->idno."' AND ";
//            $where[0]['schYear'] = "='".$schYear."' AND ";
//            $where[0]['rstatus'] = "=1";
            //$theRegistrationPayment = $regPayment->retrieveAllRegistrationPayments($where,"regPaymentID","Desc",0,1);
            $paid = $regPayment->totalRegistrationPayment($student->idno, $schYear);
//            if ($theRegistrationPayment) {
//                $paid = $theRegistrationPayment[0]['amount'];
//            } else {
//                $paid = 0;
//            }

            $base_installment_per_term = ($account->totalFee-$paid) / $total_terms;
            //-----------------------------------------------------------------------------------------------------------
            
            // check if assessment is already exist if not create then
            if (!$assessment->isExist($student->idno, $accID, $schYear, $term)) {
                // new assessment
                $assessment->idno        = $student->idno;
                $assessment->accID       = $student->accID;
                $assessment->schYear     = $schYear;
                $assessment->yrLevel     = $account->yrLevel;
                $assessment->term        = $term;
                $assessment->tuitionFee  = $tfee;
                $assessment->labFee      = $labf;
                $assessment->regFee      = $regf;
                $assessment->miscFee     = $miscf;
                $assessment->addAdj      = $addf;
                $assessment->lessAdj     = $less;
                $assessment->oldBalance  = $account->oldBalance;
                $assessment->totalFees   = $account->totalFee;
                $assessment->ttlPayment  = $account->payment;
                $assessment->balance     = $account->balance;
                
                // averaging formula
//                if ($account->balance>0) {
//                    $assessment->ttlDue  = $account->balance / $remaining_terms;
//                } else {
//                    $assessment->ttlDue  = 0;
//                }
                
                // overwrite here... 
                // accumulated formula
                if ($account->balance>0) {
                	// check if this will be the last assessment
                	//if ($remaining_terms==$term) {
                	if ($remaining_terms==1) {
						$assessment->ttlDue  = $account->balance;
                	} else {
	                   if ($account->balance <= $base_installment_per_term) {  
							$assessment->ttlDue  = $account->balance / $remaining_terms;
						} else {
	                    	$assessment->ttlDue  = $prev_due_balance + $base_installment_per_term;
						}
                	}
                } else {
                    $assessment->ttlDue  = 0;
                }
                
                // amtPaid = 0
                // $assessment->amtPaid     = $_POST['amtPaid'];
                
                $assessment->preparedBy  = $current_user->id;

                // execute
                $assessment->createAssessment();
            }
            
        }
    }
    
	    
	$msg = "Assessments successfully generated!";
	$sugar_smarty->assign('class', 'notificationbox');
		
	$sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>
