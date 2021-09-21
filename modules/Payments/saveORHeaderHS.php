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
require_once('modules/Account/AccountDetailHS.php');
require_once('modules/Account/AccountHS.php');
require_once('modules/Account/AssessmentHS.php');
require_once('modules/SchoolFees/SchoolFeeHS.php');
require_once('modules/Payments/ORSeries.php');
require_once('modules/Payments/ORDetailsHS.php');
require_once('modules/Payments/ORHeaderHS.php');
require_once('modules/Config/RecordLogHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$ordetails  = new ORDetails();
$schoolFee  = new SchoolFee();
$config     = new Config();
$account    = new Account();
$assessment = new Assessment();
$student    = new Student();
$enrollment = new Enrollment();
$recordLog  = new RecordLog();


$idno         = trim($_POST['idno']);
$orno         = trim($_POST['orno']);
$acciD        = trim($_POST['acciD']);
$schYear      = trim($_POST['schYear']);
$semCode      = trim($_POST['semCode']);
$totalAmount  = trim($_POST['totalAmount']);

$currentTerm        = $config->getConfig('Current Payment Term');
$tuition            = $config->getConfig('Tuition Account Code HS');
$registration       = $config->getConfig('Reg Account Code HS');
$oldAccount         = $config->getConfig('Old Account Code HS');
$PGMA         		= $config->getConfig('PGMA');
$tuitionPGMA        = $config->getConfig('Tuition PGMA Code');

if (isset($_POST['paymentID'])) {
    $paymentID = $_POST['paymentID'];
    $orheader = new ORHeader($paymentID);
    $orheader->paymentID = $_POST['paymentID'];
} else {
    $orheader = new ORHeader();
}
	
    //this for edit
	if ($orheader->paymentID) {
		//Get Latest ID to Display
		$getLastID = $orheader->paymentID;

		// update existing record
        $orheader->orno         = $orno;
        $orheader->idno         = $idno;
        $orheader->acciD        = $acciD;
        $orheader->schYear      = $schYear;
        $orheader->semCode      = $semCode;
        $orheader->term         = $currentTerm;
        $orheader->dateCreated  = date("Y-m-d",time());
        $orheader->timeCreated  = date("H:i:s",time());
        $orheader->totalAmount  = $totalAmount;
        $orheader->cashier      = $current_user->id;
        $orheader->rstatus      = $rstatus;
		
	    // update student record
	    if ($orheader->updateORHeader()) {
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	} else {
	    // create new record
        $orheader->idno         = $idno;
        $orheader->orno         = $orno;
        $orheader->schYear      = $schYear;
        $orheader->term         = $currentTerm;
        $orheader->dateCreated  = date("Y-m-d",time());
        $orheader->timeCreated  = date("H:i:s",time());
        $orheader->totalAmount  = $totalAmount;
        $orheader->cashier      = $current_user->id;
	    // new student record

    	if ($orheader->createORHeader()) {
			//Get Latest ID to Display
			
			if($currentTerm!='') {
    			$getLastID = $orheader->getLastID();
    			
    			//SAVE TO ORDETAILS
    			foreach ($_SESSION['ORITEMSHS'] as $row) {
            	    $ordetails->orno           = $_POST['orno'];
            	    $ordetails->account_code   = $row['particular'];
            	    $ordetails->amount         = $row['amount'];
            	    $ordetails->createORDetails();
                
    			    //for registration payment
                    if($row['particular'] == $registration) {
                        //Account and enrollment instance
                        unset($where);
            			if ($schYear) {
            				$where[0]['schYear'] = "= '$schYear' AND ";             	
                        }
                        if ($idno) {
            			   $where[0]['idno'] = "= '$idno' AND ";
            			}
            			$where[0]['rstatus'] = "= 1";
            			//retrieving for enrollment
            			$acc1 	= $account->retrieveAllAccounts($where,'accID','DESC',0,1);
            			//account instance where accID = $result [0][accID]
            			$account1 = new Account($acc1[0][accID]);
            			$account1->payment += $row['amount']; 
            			$account1->balance -= $row['amount'];
            			$account1->updateAccount();
            			unset($where);
            			if ($schYear) {
            				$where[0]['enrollments.schYear'] = "= '$schYear' AND ";             	
                        }
                        if ($idno) {
            			   $where[0]['enrollments.idno'] = "= '$idno' AND ";
            			}
            			$where[0]['enrollments.rstatus'] = "= 1";
            			$resulten 	= $enrollment->retrieveAllEnrollments($where);
            			
            			//enrollment instance where enID = $resulten [0][enID]
            			if ($resulten) {
            			    $enrollval = new Enrollment($resulten[0]['enID']);
                			$enrollval->validateEnrollment();
            			}
            			
                    } else if ($tuition == $row['particular']) {
                    
                        //for tuition 1st term(prelim)
                    	if (($schYear !="") && ($idno != "")) {
                    	    unset($where);
                            $where[0]['schYear'] = "='$schYear' AND ";
                            $where[0]['idno'] = "='$idno' AND ";
                            $where[0]['term'] = "='$currentTerm'";
        //                        $where[0]['rstatus'] = ">='1'";

                            $assessment1  = $assessment->retrieveAllAssessments($where,'assID','DESC','',1);
                            $ass1 = new Assessment($assessment1[0]['assID']);
                            
            	        	$ass1->amtPaid 	+=  $row['amount'];
            	        	if(trim($totalAmount)!='' && $row['amount'] >= $ass1->ttlDue) {
            	        		$ass1->rstatus 	=  2;
            	        	}
            				// update asssessment record
            				$ass1->updateAssessment();
            				
            				//update for account start
                			unset($where);
                			if ($schYear) {
                				$where[0]['schYear'] = "= '$schYear' AND ";             	
                            }
                            if ($idno) {
                			   $where[0]['idno'] = "= '$idno' AND ";
                			}
                			$where[0]['rstatus'] = "= 1";
                			//retrieving for enrollment
                			$acc1 	= $account->retrieveAllAccounts($where,'accID','DESC',0,1);
                			//account instance where accID = $result [0][accID]
                			$account1 = new Account($acc1[0][accID]);
        
                			$orheader->acciD        = $acc1[0][accID];
            			    $account1->payment 		+=  $row['amount'];  
            			    $account1->balance 		-=  $row['amount'];  
            				// update account record
            				$account1->updateAccount();
        
                    	}
                    } else if ($oldAccount == $row['particular']) {
                    
            				//update for account start
                			unset($where);
                			if ($schYear) {
                				$where[0]['schYear'] = "= '$schYear' AND ";             	
                            }
                            if ($idno) {
                			   $where[0]['idno'] = "= '$idno' AND ";
                			}
                			$where[0]['rstatus'] = "= 1";
                			//retrieving for enrollment
                			$acc1 	= $account->retrieveAllAccounts($where,'accID','DESC',0,1);
                			//account instance where accID = $result [0][accID]
                			$account1 = new Account($acc1[0][accID]);

            			    $account1->payment 		+=  $row['amount'];  
            			    $account1->balance 		-=  $row['amount'];  
            				// update account record
            				$account1->updateAccount();

                    } else if ($tuitionPGMA == $row['particular']) {
                    
                        //for tuition 1st term(prelim)
                    	if (($schYear !="") && ($semCode != "") && ($idno != "")) {
                    	    unset($where);
                            $where[0]['schYear'] = "='$schYear' AND ";
                            $where[0]['idno'] = "='$idno' AND ";
                            $where[0]['term'] = "='$currentTerm'";

                            $assessment1  = $assessment->retrieveAllAssessments($where,'assID','DESC','',1);
                            $ass1 = new Assessment($assessment1[0]['assID']);
            	        	$ass1->amtPaid 	+=  $row['amount'];
            	        	if(trim($totalAmount)!='' && $row['amount'] >= $ass1->ttlDue) {
            	        		$ass1->rstatus 	=  2;
            	        	}
            				// update asssessment record
            				$ass1->updateAssessment();
            				
            				//update for account start
                			unset($where);
                			if ($schYear) {
                				$where[0]['schYear'] = "= '$schYear' AND ";             	
                            }
                            if ($idno) {
                			   $where[0]['idno'] = "= '$idno' AND ";
                			}
                			$where[0]['rstatus'] = "= 1";
                			//retrieving for enrollment
                			$acc1 	= $account->retrieveAllAccounts($where,'accID','DESC',0,1);
                			//account instance where accID = $result [0][accID]
                			$account1 = new Account($acc1[0][accID]);
        
                			$orheader->acciD        = $acc1[0][accID];
            			    $account1->payment 		+=  $row['amount'];  
            			    $account1->balance 		-=  $row['amount'];  
            				// update account record
            				$account1->updateAccount();
        
                    	}
                    }
    			
				$recordLog->docType 		= "HS Payment";
				$recordLog->recID 			= $getLastID;
				$recordLog->logDate 		= date("Y-m-d H:i:s", time());
				$recordLog->operation 		= "Create OR";
				$recordLog->fields 			= "Amount = ".$row['amount'];
				$recordLog->user_id 		= $current_user->id;
				$recordLog->createRecordPaymentLog();

    			}
    			//update orseries
                unset($where);
            	$orseries   = new ORSeries();
            	$where[0]['cashier']="='$current_user->id' AND ";
            	$where[0]['rstatus']="='1'";
            	$or    = $orseries->retrieveAllORSeries($where,'');
            	$orseries   = new ORSeries($or[0]['id']);
            	
            	if ($_POST['orno'] >= $orseries->lastORNO) {
            		$orseries->rstatus = 2;
            	} else {
            		if ($_POST['orno'] >= $orseries->currentORNO) {
						$orseries->currentORNO = $_POST['orno']+1;            			
            		}

            	}
                $orseries->updateORSeries();
                
    			$msg = "Record successfully saved!";
        		$sugar_smarty->assign('class', 'notificationbox');
			} else {
			    $msg = "Please set up Current Payment Term First!";
        		$sugar_smarty->assign('class', 'notificationbox');
			}
    	} else {
    	    $msg = "Record was not successfully saved!";
    	    $sugar_smarty->assign('class', 'errorbox');
    	}
	}
	
	$sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Payments&action=viewORHeaderHS&paymentID=<?php echo $getLastID; ?>')",3000);
</script>