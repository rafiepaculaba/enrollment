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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['regPaymentID'])) {
	$regPaymentID = $_POST['regPaymentID'];
	
    $regpayment = new RegistrationPayment($regPaymentID);
} else {
    $regpayment = new RegistrationPayment();
}
$recordLog = new RecordLog();
	// check if comes from correct form
//	if ( isset($_POST['cmdSave']) ) {

	    if (isset($_POST['regPaymentID'])) {
	    	$regpayment->regPaymentID = $_POST['regPaymentID'];
	    }

		if ($regpayment->regPaymentID) {
			//Get ID to Display
			$getLastID = $regpayment->regPaymentID;

	        $regpayment->schYear		= $_POST['schYear'];
	        $regpayment->semCode       	= $_POST['semCode'];
	        $regpayment->idno    		= $_POST['idno'];
	        $regpayment->ORno    		= $_POST['ORno'];
	        $regpayment->type    		= $_POST['type'];
			$regpayment->amount 		= $_POST['amount'];
			
            $regpayment->date 			= date("Y-m-d");
            $regpayment->encodedBy 		= $current_user->id;
            	
            $schYear 	= $_POST['schYear'];
            $semCode 	= $_POST['semCode'];
            $idno 		= $_POST['idno'];
            

			// update Registration Payment record
		    if ($regpayment->updateRegistrationPayment()) {
		              
        	    //account instance
                $account = new Account();
                
                if ($schYear) {
        			$where[0]['schYear'] = "= '$schYear' AND ";             	
                }
                if ($semCode) {
        		   $where[0]['semCode'] = "= '$semCode' AND ";
        		}
                if ($idno) {
        		   $where[0]['idno'] = "= '$idno'";
        		}
        
        		$result = $account->retrieveAllAccounts($where,'accID','DESC',0,1);
        		$account1 = new Account($result [0][accID]);
        
        		//Payment 	
        		$diff = $_POST['amount'] - $_POST['prevamount'];
        		
        		$account1->payment += $diff;
        		$account1->balance -= $diff; 
        		$account1->updateAccount();
        
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
        		   $where[0]['enrollments.rstatus'] = "= 1";
        		//retrieving for enrollment
        		$resulten 	= $enrollment->retrieveAllEnrollments($where);
        
        		//enrollment instance where enID = $resulten [0][enID]
        		$enrollval = new Enrollment($resulten[0]['enID']);
        		$enrollval->validateEnrollment();
        
        		if ($_POST['prevamount'] != $_POST['amount']) {
        			
        			$recordLog->docType 		= "Col RegPayment";
        			$recordLog->recID 			= $regpayment->regPaymentID;
        			$recordLog->logDate 		= date("Y-m-d H:i:s", time());
        			$recordLog->operation 		= "Edit";
        			$recordLog->fields 			= "Amount = ".$_POST['prevamount'];
        			$recordLog->user_id 		= $current_user->id;
        			$recordLog->createRecordLog();
        		}

        		$msg = "Record successfully updated!";
	    		$sugar_smarty->assign('class', 'notificationbox');
		    } else {
		        $msg = "Record was not successfully updated!";
	    	    $sugar_smarty->assign('class', 'errorbox');
		    }
		} else {
	        $regpayment->schYear			= $_POST['schYear'];
	        $regpayment->semCode       		= $_POST['semCode'];
	        $regpayment->idno    			= $_POST['idno'];
	        $regpayment->ORno    			= $_POST['ORno'];
	        $regpayment->type    			= $_POST['type'];
            $regpayment->date				= date("Y-m-d");
	        $regpayment->amount        		= $_POST['amount'];
	        $regpayment->encodedBy        	= $current_user->id;
	        $regpayment->rstatus       		= $_POST['rstatus'];
            
            $schYear 	= $_POST['schYear'];
            $semCode 	= $_POST['semCode'];
            $idno 		= $_POST['idno'];

			// new Registration payment record
	    	if ($regpayment->createRegistrationPayment()) {
	    	    
				//Get latest ID to Display
				$getLastID = $regpayment->getLastID();
	    		
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
    			$result 	= $account->retrieveAllAccounts($where,'accID','DESC',0,1);
    			
    			//account instance where accID = $result [0][accID]
    			$account1 = new Account($result[0][accID]);
    
    			$account1->payment += $_POST['amount']; 
    			$account1->balance -= $_POST['amount']; 
    			$account1->updateAccount();
    
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
    			   $where[0]['enrollments.rstatus'] = "= 1";
    			//retrieving for enrollment
    			
    			$resulten 	= $enrollment->retrieveAllEnrollments($where);
    			
    			//enrollment instance where enID = $resulten [0][enID]
    			$enrollval = new Enrollment($resulten[0]['enID']);
    			$enrollval->validateEnrollment();
				
       			$recordLog->docType 		= "Col RegPayment";
    			$recordLog->recID 			= $getLastID;
    			$recordLog->logDate 		= date("Y-m-d H:i:s", time());
    			$recordLog->operation 		= "Create";
    			$recordLog->fields 			= "Amount = ".$_POST['amount'];
    			$recordLog->user_id 		= $current_user->id;
    			$recordLog->createRecordLog();
    			
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
//	}

?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Payments&action=viewRegistrationPayment&regPaymentID=<?php echo $getLastID; ?>')",3000);
</script>