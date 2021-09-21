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
require_once('modules/Payments/PaymentTypePreschool.php');
require_once('modules/Payments/PaymentPreschool.php');
require_once('modules/Payments/RegistrationPaymentPreschool.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Delete Preschool Registration Payment");
if ($access->check_access($current_user->id,$accessCode)) {

	$regPaymentID = $_GET['regPaymentID'];
	
	$regPayment = new RegistrationPayment($regPaymentID);
	
	if ($regPayment->regPaymentID) {
	    // check if record is exist
	    if ( !empty($regPayment->regPaymentID) ) {
	        // delete user group record
	        if ($regPayment->deleteRegistrationPayment()) {
	            $msg = "Record successfully deleted!";
	    		$sugar_smarty->assign('class', 'notificationbox');
	        } else {
	            $msg = "Record was not successfully deleted!";
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
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script language="javascript">
setTimeout("redirect('index.php?module=Payments&action=listRegistrationPaymentsPreschool')", 3000);
</script>