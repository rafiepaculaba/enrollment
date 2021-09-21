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
require_once('modules/Payments/ORSeries.php');
require_once('modules/Payments/ORHeader.php');
require_once('modules/Payments/ORDetails.php');
require_once('modules/SchoolFees/SchoolFeeCol.php');
require_once('modules/Account/AccountDetailCol.php');
require_once('modules/Account/Account.php');
require_once('modules/Account/Assessment.php');
require_once('modules/Account/ChartAccountMaster.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Cancel Col OR Header");
if ($access->check_access($current_user->id,$accessCode)) {

    $paymentID 	= $_GET['paymentID'];
    $schYear   	= $_GET['schYear'];
    $semCode   	= $_GET['semCode'];
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
    $tuition            = $config->getConfig('Tuition Account Code');
    $registration       = $config->getConfig('Reg Account Code');
    $oldAccount         = $config->getConfig('Old Account Code');
    
//    $where[0]['cashier']="='$orheader->cashier'";
//    $result = $orseries->retrieveAllORSeries($where);
//    $orno = new ORSeries($result[0]['id']);
//    $orno->cancelledOR = $orno->cancelledOR + 1;
//    $orno->updateORSeries();
    
    //Delete ORDetails
//    $where[0]['orno']="='$orno'";
//    $resultDetails = $ordetails->retrieveAllORDetails($where);
//    foreach ($resultDetails as $resultDetails) {
//    	$ordetails->ordno = $resultDetails['ordno'];
//    	$ordetails->deleteORDetails();
//    }
    
    if ($orheader->paymentID) {
        // check if record is exist
        if ( !empty($orheader->paymentID) ) {
    
            if ($orheader->particular) {
                $ctr=0;

                foreach($orheader->particular as $row) {
                    
                    $account_code   = $row['account_code'];
                    $amount         = $row['amount'];
                    
                    //for registration cancel payment
                    if($row['account_code'] ==  $registration) {
                        unset($where);
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
                		$result 	= $account->retrieveAllAccounts($where,'accID','DESC',0,1);
                		//account instance where accID = $result [0][accID]
                		$account1 = new Account($result[0][accID]);
                		
                		$account1->payment -= $amount;
                		$account1->balance += $amount;
                		$account1->updateAccount();
                
                		//if payment is registration type devalidate the student enrollment
                		if ($term == '0') {
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
                        
                    } else if($row['account_code'] ==  $tuition) {
                        //for tuition cancel payment
                        
                        $ass = new Assessment();
                        unset($conds);
                        if ($schYear) {
                            $conds[0]['schYear'] = "= '$schYear' AND ";
                        }
                        if ($semCode) {
                            $conds[0]['semCode'] = "= '$semCode' AND ";
                        }
                        if ($idno) {
                            $conds[0]['idno'] = "= '$idno' AND ";
                        }
                        if ($term) {
                            $conds[0]['term'] = "= '".$orheader->term."'";
                        }
                        
                        $result2    = $ass->retrieveAllAssessments($conds,'assID','DESC','',1);
                        $assID      = $result2[0]['assID'];
                        $ass1       = new Assessment($assID);
                        
                        if ($assID) {
                        	$ass1->amtPaid 		-=  $amount;
                        	
                        	if ($ass1->amtPaid <= 0) {
                                $ass1->rstatus 		=  1;                        		
                        	}
                            
                        	$ass1->updateAssessment();

                            unset($where);
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
                    		$result 	= $account->retrieveAllAccounts($where,'accID','DESC',0,1);
                    		//account instance where accID = $result [0][accID]
                    		$account1 = new Account($result[0][accID]);
                    		
                    		$account1->payment -= $amount; 
                    		$account1->balance += $amount; 
                    		$account1->updateAccount();

                        }
                    }
                    $ctr++;
                    
               		//create record log
            		$recordLog = new RecordLog();
                
    				$recordLog->docType 		= "Col Payment";
    				$recordLog->recID 			= $paymentID;
    				$recordLog->logDate 		= date("Y-m-d H:i:s", time());
    				$recordLog->operation 		= "Cancel";
    				$recordLog->fields 			= "Amount = ".$amount;
    				$recordLog->user_id 		= $current_user->id;
    				$recordLog->createRecordPaymentLog();
                }
            }
        
        	// cancel  payment record
            if ($orheader->cancelORHeader()) {
                $msg = "Record successfully cancelled!";
        		$sugar_smarty->assign('class', 'notificationbox');
            } else {
                $msg = "Record was not successfully cancelled!";
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
setTimeout("redirect('index.php?module=Payments&action=viewORHeader&paymentID=<?php echo $paymentID ?>')", 3000);
</script>