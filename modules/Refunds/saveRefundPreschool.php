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

require_once('modules/Students/StudentPreschool.php');
require_once('modules/Refunds/RefundPreschool.php');
require_once('modules/Account/AccountDetailPreschool.php');
require_once('modules/Account/AccountPreschool.php');
require_once('modules/Account/AssessmentPreschool.php');
require_once('modules/Config/RecordLogPreschool.php');
echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['refundID'])) {
    $refundID = $_POST['refundID'];
    $refund = new Refund($refundID);
} else {
    $refund = new Refund();
}
$recordLog = new RecordLog();
	// check if comes from correct form
//	if ( isset($_POST['cmdSave']) ) {
	    
	    if (isset($_POST['refundID'])) {
	        $refund->refundID = $_POST['refundID'];
	    }
		
		if ($refund->refundID) {
			//Get ID to Display
    		$getLastID = $refund->refundID;
			
		    $refund->accID				= $_POST['accID'];
		    $refund->idno				= $_POST['idno'];
	        $refund->schYear			= $_POST['schYear'];
            $refund->date 				= date("Y-m-d");

            $prevAmount	= $refund->amount;
            $refund->amount        		= $_POST['amount'];
			$refund->preparedBy     	= $current_user->id;

			$newamount 	= $_POST['amount'];
			$diff 		= $newamount - $_POST['prevamount'];

	        // update refund record
		    if ($refund->updateRefund()) {
		        
	            $account = new Account($_POST['accID']);

    	    	$account->payment 	-= $diff;
    	    	$account->balance 	+= $diff;
    	        $account->updateAccount();
    			
    	        unset($where);
    	        $ass = new Assessment();
    
    	        if($refund->idno) {
    	        	$where[0]['idno'] = "= '$refund->idno' AND ";
    	        }
    	        if($refund->schYear) {
    	        	$where[0]['schYear'] = "= '$refund->schYear' AND ";
    	        }
    	        $where[0]['rstatus'] = "= '1'";
    	        
    	        $selectedAssessment = $ass->retrieveAllAssessments($where);
    
    	        $selectthatAss = new Assessment($selectedAssessment[0][assID]);
    	        
    	        $selectthatAss->amtPaid -= $diff;
    	        $selectthatAss->updateAssessment();
    			
    			if ($_POST['prevamount'] != $_POST['amount']) {
    				$recordLog->docType 		= "Preschool Refund";
    				$recordLog->recID 			= $refund->refundID;
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
			$refund->accID				= $_POST['accID'];
			$refund->idno				= $_POST['idno'];
	        $refund->schYear			= $_POST['schYear'];
            $refund->date 				= date("Y-m-d");
	        $refund->amount        		= $_POST['amount'];
	        $refund->preparedBy     	= $current_user->id;
	        $refund->rstatus       		= $_POST['rstatus'];
	        
	        $account = new Account($_POST['accID']);

	    	$account->payment -= $_POST['amount'];  
	        $account->balance += $_POST['amount'];
	        $account->updateAccount();

	        // new refund record
	    	if ($refund->createRefund()) {
				//Get latest ID to Display
	    		$getLastID = $refund->getLastID();
	    		
		        unset($where);
    	        $ass = new Assessment();
    
    	        if($refund->idno) {
    	        	$where[0]['idno'] = "= '$refund->idno' AND ";
    	        }
    	        if($refund->accID) {
    	        	$where[0]['accID'] = "= '$refund->accID' AND ";
    	        }
    	        if($refund->schYear) {
    	        	$where[0]['schYear'] = "= '$refund->schYear' AND ";
    	        }
    	        $where[0]['rstatus'] = "= '1'";
    	        
    	        $selectedAssessment = $ass->retrieveAllAssessments($where);
    
    	        $selectthatAss = new Assessment($selectedAssessment[0][assID]);
    	        
    	        $selectthatAss->amtPaid -= $_POST['amount'];
    	        $selectthatAss->updateAssessment();

				$recordLog->docType 		= "Preschool Refund";
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
setTimeout("redirect('index.php?module=Refunds&action=viewRefundPreschool&refundID=<?php echo $getLastID; ?>')",3000);
</script>