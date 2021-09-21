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
require ('modules/Config/ConfigCol.php');
require_once('modules/Account/ChartAccountMaster.php');
//require_once('modules/Account/ChartAccountType.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], "Account Master", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Col Account");
if ($access->check_access($current_user->id,$accessCode)) {
    $acctCode = $_GET['acctCode'];
    $chartaccount = new ChartAccountMaster($acctCode);
//    $chartaccounttype = new ChartAccountType();
//
//    $sugar_smarty->assign('types', $chartaccounttype->retrieveAllRecords() );
    $sugar_smarty->assign('account_code', $chartaccount->account_code );
    $sugar_smarty->assign('account_name', $chartaccount->account_name );
    $sugar_smarty->assign('account_name_type', $chartaccount->account_name_type );
    
    // to check if the user has an access in edit
    $accessCode = $access->getAccessCode("Edit Col Account");
    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
    
    // to check if the user has an access in delete
//    if (!$chartaccount->isUsed()) {
	    $accessCode = $access->getAccessCode("Delete Col Account");
	    $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );
//    }

    echo $sugar_smarty->fetch('modules/Administration/templates/viewChartOfAccount.tpl');
} else {
    $msg = "Sorry, you dont have permission to access this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}  
?>

<script language="javascript">
function deleteRecord(accountCode)
{
    reply=confirm("Do you really want to delete this Account Master?");
    
    if (reply==true)
        redirect('index.php?module=Administration&action=deleteChartAccountMaster&acctCode='+accountCode);
}
</script>