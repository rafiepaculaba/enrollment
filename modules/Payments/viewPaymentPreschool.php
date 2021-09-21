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
require_once('modules/Config/ConfigPreschool.php');
require_once('modules/Payments/PaymentTypePreschool.php');
require_once('modules/Payments/PaymentPreschool.php');
require_once('modules/Students/StudentPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Preschool Payment");
if ($access->check_access($current_user->id,$accessCode)) {

	$paymentID = $_GET['paymentID'];
	$config = new Config();
	$payment = new Payment($paymentID);
	
	if ( $paymentID ) {
	
		switch ( $payment->term ) 
	{
		case 1:
			$term="Term 1"	;
			break;
		case 2:
			$term="Term 2"	;
			break;
		case 3:
			$term="Term 3"	;
			break;
		case 4:
			$term="Term 4"	;
			break;
		case 5:
			$term="Term 5"	;
			break;
		case 6:
			$term="Term 6"	;
			break;
		case 7:
			$term="Term 7"	;
			break;
		case 8:
			$term="Term 8"	;
			break;
		case 9:
			$term="Term 9"	;
			break;
		case 10:
			$term="Term 10"	;
			break;
	}
	$date = date("m/d/Y",strtotime($payment->date));

	$sugar_smarty->assign('paymentID', $payment->paymentID );
	$sugar_smarty->assign('accID', $payment->accID );
	$sugar_smarty->assign('schYear', $payment->schYear );
	$sugar_smarty->assign('ORno', $payment->ORno );
	$sugar_smarty->assign('idno', $payment->idno );
	$sugar_smarty->assign('date', $date );
	$sugar_smarty->assign('paymentTypeID', $payment->paymentTypeID );
	$sugar_smarty->assign('termi', $payment->term );
	$sugar_smarty->assign('term', $term );
	$sugar_smarty->assign('amount', $payment->amount );
	$sugar_smarty->assign('encodedBy', $payment->encodedBy );
	$sugar_smarty->assign('rstatus', $payment->rstatus );
	$sugar_smarty->assign('paymentName', $payment->paymentName );

	$sugar_smarty->assign('studName', $payment->studName );
	
	if($payment->rstatus == 1 && $payment->schYear == $config->getConfig('School Year') ) {
		// to check if the user has an access in edit
	    $accessCode = $access->getAccessCode("Edit Preschool Payment");
	    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );

		// to check if the user has an access in cancel
	    $accessCode = $access->getAccessCode("Cancel Preschool Payment");
	    $sugar_smarty->assign('hasCancel', $access->check_access($current_user->id, $accessCode) );
    } 

	echo $sugar_smarty->fetch('modules/Payments/templates/viewPaymentPreschool.tpl');
	} else {
	    $msg = "Payment ID not found!";
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
/*function deletePayment(paymentID)
{
    reply=confirm("Do you really want to delete the Payment?");

    if (reply==true)
        redirect('index.php?module=Payments&action=deletePaymentPreschool&paymentID='+paymentID);
}*/
function cancelPaymentPreschool(paymentID, idno, accID, schYear, term, amount)
{
    reply=confirm("Do you really want to cancel the Payment?");

    if (reply==true)
        redirect('index.php?module=Payments&action=cancelPaymentPreschool&paymentID='+paymentID+'&idno='+idno+'&accID='+accID+'&schYear='+schYear+'&term='+term+'&amount='+amount);
}

</script>