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
require_once('modules/Students/StudentPreschool.php');
require_once('modules/Refunds/RefundPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Preschool Refund");
if ($access->check_access($current_user->id,$accessCode)) {

	$refundID = $_GET['refundID'];
	$refund = new Refund($refundID);
		
	$date = date("m/d/Y",strtotime($refund->date));
	
	if ( $refundID ) {

	$sugar_smarty->assign('refundID', $refund->refundID );
	$sugar_smarty->assign('accID', $refund->accID );
	$sugar_smarty->assign('idno', $refund->idno );
	$sugar_smarty->assign('studName', $refund->studName );
	$sugar_smarty->assign('schYear', $refund->schYear );
	$sugar_smarty->assign('date', $date );
	$sugar_smarty->assign('amount', $refund->amount );
	$sugar_smarty->assign('encodedBy', $refund->preparedBy );

	$sugar_smarty->assign('rstatus', $refund->rstatus );
	
	
	if($refund->rstatus == 1) {
	    // to check if the user has an access in edit
	    $accessCode = $access->getAccessCode("Edit Preschool Refund");
	    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
	    
	    // to check if the user has an access in cancel
	    $accessCode = $access->getAccessCode("Cancel Preschool Refund");
	    $sugar_smarty->assign('hasCancel', $access->check_access($current_user->id, $accessCode) );
    } 

	echo $sugar_smarty->fetch('modules/Refunds/templates/viewRefundPreschool.tpl');
	} else {
	    $msg = "Refund ID not found!";
	    $sugar_smarty->assign('class', 'errorbox');
	    $sugar_smarty->assign('display', 'block');
	    $sugar_smarty->assign('msg', $msg );
	    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	}
	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script language="javascript">
/*function deleteRefund(refundID)
{
    reply=confirm("Do you really want to delete the Refund?");

    if (reply==true)
        redirect('index.php?module=Refunds&action=deleteRefund&refundID='+refundID);
}
*/
function cancelRefund(refundID, accID, amount)
{
    reply=confirm("Do you really want to cancel the Refund?");

    if (reply==true)
        redirect('index.php?module=Refunds&action=cancelRefundPreschool&refundID='+refundID+'&accID='+accID+'&amount='+amount);
}
</script>