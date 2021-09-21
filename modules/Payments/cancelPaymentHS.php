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
require_once('modules/Config/RecordLogHS.php'); 
require_once('modules/Students/StudentHS.php');
require_once('modules/Users/User2.php');
require_once('modules/Account/AccountDetailHS.php');
require_once('modules/Account/AccountHS.php');
require_once('modules/Account/AssessmentHS.php');
require_once('modules/Payments/PaymentTypeHS.php');
require_once('modules/Payments/PaymentHS.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$paymentID 	= $_GET['paymentID'];
$idno 		= $_GET['idno'];
$accID 		= $_GET['accID'];
$schYear 	= $_GET['schYear'];
$term 		= $_GET['term'];
$amount 	= $_GET['amount'];

$recordLog = new RecordLog();

//assessment record begin
$ass = new Assessment();

if ($schYear) {
    $conds[0]['schYear'] = "= '$schYear' AND ";
}
if ($accID) {
    $conds[0]['accID'] = "= '$accID' AND ";
}
if ($idno) {
    $conds[0]['idno'] = "= '$idno' AND ";
}
if ($term) {
    $conds[0]['term'] = "= '$term'";
}

$result2 = $ass->retrieveAllAssessments($conds);
$assID = $result2[0][assID];
$ass1 = new Assessment($assID);

if ($assID != '') {

	$ass1->amtPaid 		-=  $amount;
	$ass1->rstatus 		=  1;

	// update asssessment record
	$ass1->updateAssessment();

    $account = new Account($accID);
	
    $account->payment 		-=  $amount;  
    $account->balance 		+=  $amount;  
	// update account record
	$account->updateAccount();
} //else here if assID does not exist

$recordLog->docType 		= "HS Payment";
$recordLog->recID 			= $paymentID;
$recordLog->logDate 		= date("Y-m-d H:i:s", time());
$recordLog->operation 		= "Cancel";
$recordLog->fields 			= "Amount = ".$_GET['amount'];
$recordLog->user_id 		= $current_user->id;
$recordLog->createRecordLog();

$payment = new Payment($paymentID);
if ($payment->paymentID) {
    // check if record is exist
    if ( !empty($payment->paymentID) ) {
        // delete user group record
        if ($payment->cancelPayment()) {
            $msg = "Record successfully cancelled!";
    		$sugar_smarty->assign('class', 'notificationbox');
        } else {
            $msg = "Record was not successfully cancelled!";
    	    $sugar_smarty->assign('class', 'errorbox');
        }
    } else {
        $msg = "Payment Type ID does not exist!";
	    $sugar_smarty->assign('class', 'errorbox');
    }
} else {
    $msg = "Error: Payment Type ID not set!";
    $sugar_smarty->assign('class', 'errorbox');
}

$sugar_smarty->assign('display', 'block');
$sugar_smarty->assign('msg', $msg );
echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
?>

<script language="javascript">
setTimeout("redirect('index.php?module=Payments&action=viewPaymentHS&paymentID=<?php echo $paymentID ?>')", 3000);
</script>