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
require_once('modules/Payments/PaymentTypeHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit HS Payment");
if ($access->check_access($current_user->id,$accessCode)) {
	
	$paymentTypeID = $_GET['paymentTypeID'];
	
	$paymentType = new PaymentType($paymentTypeID);
	$paymentType->paymentTypeID = $paymentTypeID;
	$paymentType->retrievePaymentType(1); // locked
	
	$sugar_smarty->assign('paymentTypeID', $paymentType->paymentTypeID );
	$sugar_smarty->assign('paymentName', $paymentType->paymentName );
	$sugar_smarty->assign('rstatus', $paymentType->rstatus );
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Payments/templates/editPaymentTypeHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmPaymentTypeHS','paymentName', '', true, 'Payment Name');
</script>
<script language="javascript">
function checkDuplicate()
{
	if($('paymentName').value != $('prevpaymentName').value) {
		if (check_form('frmPaymentTypeHS')) {
	        get_data="paymentName=" + $('paymentName').value + "&action=checkduplicatepaymentnamehs";
	        ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","checkDuplicateHandle");
	    }
	} else {
			$('frmPaymentTypeHS').submit();
	}
}

function checkDuplicateHandle() 
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret=='') {
    		redirect('index.php?module=Payments&action=editPaymentTypeHS&paymentTypeID=<?php echo $_GET['paymentTypeID']; ?>'); // redirect to entry page
    	} else {
	    	if (ret==-1) {
	    		// ID No. duplicate
                $('frmPaymentTypeHS').submit();
	    	} else if (ret==1) {
	    		// can't continue saving coz has no item
	    		msg="Duplicate Payment Name.";
	    		displayError(msg);
	    	}
	    	
    	}
    }
}
$('paymentName').focus();
</script>