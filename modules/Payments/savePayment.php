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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['paymentID'])) {
	$paymentID = $_POST['paymentID'];
	
    $payment = new Payment($paymentID);
} else {
    $payment = new Payment();
}

$recordLog = new RecordLog();

	// check if comes from correct form
//	if ( isset($_POST['cmdSave']) ) {

	    if (isset($_POST['paymentID'])) {
	        $payment->paymentID = $_POST['paymentID'];
	    }

		if ($payment->paymentID) {
			//Get ID To Display
			$getLastID 					= $payment->paymentID;
			
		    $payment->accID				= $_POST['assaccID'];
	        $payment->schYear			= $_POST['schYear'];
	        $payment->semCode       	= $_POST['semCode'];
	        $payment->idno    			= $_POST['idno'];
	        $payment->ORno    			= $_POST['ORno'];
            $payment->date 				= date("Y-m-d");
		    $payment->paymentTypeID 	= '0';
		    $payment->term 				= $_POST['term'];
			
		    $prevAmount 				= $payment->amount;
		    $payment->amount 			= $_POST['amount'];
	        $payment->encodedBy        	= $current_user->id;
			
	        $assID 		= $_POST['assID'];
		    $amount 	= $_POST['amount'];

		    $diff = $amount - $prevAmount;
		    
			// update payment record
		    if ($payment->updatePayment()) {
		        
		        $ass = new Assessment($assID);
    	        if ($assID) {
    				$where[0]['assID'] = "= '$assID'";
                }
    			$result = $ass->retrieveAllAssessments($where,'assID','DESC','',1);	
    		    if (isset($_POST['assID'])) {
    				//$payment->accID		= $ass->accID;
    				
    				$ass->amtPaid 		+=  $diff;
    				
    	        	if(trim($amount)!='' && $amount >= $result[0]['ttlDue']) {
    	        		$ass->rstatus 	=  '2';
    	        	} else {
    	        		$ass->rstatus 	=  '1';
    	        	}
    				// update asssessment record
    				$ass->updateAssessment();
    				$accID = $ass->accID;
    				//Account instance
    				$account = new Account($ass->accID);
    				
    			    
    		    	$account->payment 	+= $diff;
    		    	$account->balance 	-= $diff;
    				$account->updateAccount();
    			    
    			}//else here if assID does not exist
    
    			if ($_POST['prevamount'] != $_POST['amount']) {
    				
    				$recordLog->docType 		= "Col Payment";
    				$recordLog->recID 			= $payment->paymentID;
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
	        $payment->accID			    = $_POST['accID_input'];
	        $payment->schYear			= $_POST['schYear'];
	        $payment->semCode       	= $_POST['semCode'];
	        $payment->idno    			= $_POST['idno'];
	        $payment->ORno    			= $_POST['ORno'];
            $payment->date 				= date("Y-m-d"); //,strtotime($_POST['date'])
			$payment->paymentTypeID   	= '0';
        	$payment->term   			= $_POST['term'];
	        $payment->amount        	= $_POST['amount'];
	        $payment->encodedBy        	= $current_user->id;
	        $payment->rstatus       	= $_POST['rstatus'];

			// new payment record
	    	if ($payment->createPayment()) {
	    	    
				//Get Latest ID To Display
				$getLastID = $payment->getLastID();
				
		        $assID 		= $_POST['assID'];
		        $accID      = $_POST['accID_input'];
    		    $amount 	= $_POST['amount'];

    		    $ass = new Assessment($assID);
                if ($assID) {
    				$where[0]['assID'] = "= '$assID'";
                }
                
    			$result = $ass->retrieveAllAssessments($where,'assID','DESC','',1);	
    		    if (isset($_POST['assID'])) {
    	
//				$payment->accID				= $accID;
	        	$ass->amtPaid 				+=  $amount;
	        	if(trim($amount)!='' && $amount >= $result[0]['ttlDue']) {
	        		$ass->rstatus 	=  2;
	        	}
				// update asssessment record
				$ass->updateAssessment();
				
			    $account = new Account($accID);
				
			    $account->payment 		+=  $amount;  
			    $account->balance 		-=  $amount;  
				// update account record
				$account->updateAccount();
				}//else here if assID does not exist
			
				$recordLog->docType 		= "Col Payment";
				$recordLog->recID 			= $getLastID;
				$recordLog->logDate 		= date("Y-m-d H:i:s", time());
				$recordLog->operation 		= "Create";
				$recordLog->fields 			= "Amount = ".$_POST['amount'];
				$recordLog->user_id 		= $current_user->id;
				$recordLog->createRecordPaymentLog();

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
setTimeout("redirect('index.php?module=Payments&action=viewPayment&paymentID=<?php echo $getLastID; ?>')",3000);
</script>