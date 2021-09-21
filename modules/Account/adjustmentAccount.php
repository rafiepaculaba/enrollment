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
require_once('modules/Students/StudentCol.php');
require_once('modules/Account/AccountDetailCol.php');
require_once('modules/Account/Account.php');
require_once('modules/Account/AccountColLog.php');


echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if ($_POST['submit']) {
    // meaning from adding an additional fees or less adjustments
    if (trim($_POST['accID'])) {
        
        $account_detail = new AccountDetail();
        $account_detail->accID      = trim($_POST['accID']);
        $account_detail->feeType    = trim($_POST['feeType']);
        $account_detail->particular = trim($_POST['particular']);
        $account_detail->amount     = trim($_POST['amount']);
        $account_detail->createAccountDetail();
        
        $account = new Account(trim($_POST['accID']));
        
        if (strtoupper(trim($_POST['feeType']))=="ADD") {
            $account->totalFee += $account_detail->amount;
            $account->balance  += $account_detail->amount;
            $changes_for_log = "Add: ".$account_detail->particular." ".number_format($account_detail->amount,2);
        } else {
            $account->totalFee -= $account_detail->amount;
            $account->balance  -= $account_detail->amount;
            $changes_for_log = "Less: ".$account_detail->particular." ".number_format($account_detail->amount,2);
        }
        
        // update account
        $account->updateAccount();
        
        // logging here------------------------------------------------------
        $accountLog = new AccountLog();
        $accountLog->recID 	= $account->accID;
        $accountLog->operation 	= "Adjustment";
        $accountLog->changes= $changes_for_log;
        $accountLog->changeBy= $current_user->id;
        $accountLog->createAccountLog();
        //-------------------------------------------------------------------
        
    }
}

$sugar_smarty->assign('accID', $_GET['accID'] );
$sugar_smarty->assign('feeType', $_GET['feeType'] );
echo $sugar_smarty->fetch('modules/Account/templates/adjustmentAccount.tpl');
?>

<script language="javascript" src="themes/{THEME}/style.js?s={SUGAR_VERSION}&c={JS_CUSTOM_VERSION}"></script>
<script language="javascript" src="include/blumango/javascript/utils.js"></script>
<script language="javascript" src="include/blumango/javascript/validate.js"></script>
<script language="javascript">

addToValidate('frmAdd','feeType', '', true, 'Adjustment Type');
addToValidate('frmAdd','particular', '', true, 'Particular');
addToValidate('frmAdd','amount', '', true, 'Amount');

<?php 
if ($_POST['submit'] && $_POST['accID']) {
?>
    window.opener.document.getElementById('frmDummy').submit();
    window.close();
<?php
}
?>


</script>