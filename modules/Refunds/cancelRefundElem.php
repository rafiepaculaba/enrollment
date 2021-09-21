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

require_once('modules/Students/StudentElem.php');
require_once('modules/Refunds/RefundElem.php');
require_once('modules/Account/AccountDetailElem.php');
require_once('modules/Account/AccountElem.php');
require_once('modules/Account/AssessmentElem.php');
require_once('modules/Config/RecordLogElem.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$refundID   = $_GET['refundID'];
$amount     = $_GET['amount'];

$recordLog = new RecordLog();
$refund = new Refund($refundID);

if ($refund->refundID) {
    // check if record is exist
    if ( !empty($refund->refundID) ) {
        
    	$account = new Account($_GET['accID']);
		
        $account->payment += $_GET['amount'];  
        $account->balance -= $_GET['amount'];
        
        $account->updateAccount();

		$recordLog->docType 		= "Elem Refund";
		$recordLog->recID 			= $refundID;
		$recordLog->logDate 		= date("Y-m-d H:i:s", time());
		$recordLog->operation 		= "Cancel";
		$recordLog->fields 			= "Amount = ".$_GET['amount'];
		$recordLog->user_id 		= $current_user->id;
		$recordLog->createRecordLog();

    	// cancle refund record
        if ($refund->cancelRefund()) {
            $msg = "Record successfully cancelled!";
    		$sugar_smarty->assign('class', 'notificationbox');
        } else {
            $msg = "Record was not successfully cancelled!";
    	    $sugar_smarty->assign('class', 'errorbox');
        }
    } else {
        $msg = "Refund Type ID does not exist!";
	    $sugar_smarty->assign('class', 'errorbox');
    }
} else {
    $msg = "Error: Refund ID not set!";
    $sugar_smarty->assign('class', 'errorbox');
}

$sugar_smarty->assign('display', 'block');
$sugar_smarty->assign('msg', $msg );
echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
?>

<script language="javascript">
setTimeout("redirect('index.php?module=Refunds&action=viewRefundElem&refundID=<?php echo $refundID; ?>')", 3000);
</script>