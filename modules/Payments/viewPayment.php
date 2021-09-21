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
require_once('modules/Config/ConfigCol.php');
require_once('modules/Payments/PaymentType.php');
require_once('modules/Payments/Payment.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Col Payment");
if ($access->check_access($current_user->id,$accessCode)) {

	$paymentID = $_GET['paymentID'];
	$payment = new Payment($paymentID);
	
	// get all default setting from configs
    $config = new Config();

	if ( $paymentID ) {
	
		switch ( $payment->semCode ) 
	{
		case 1:
			$semCode="1st Sem"	;
			break;
		case 2:
			$semCode="2nd Sem"	;
			break;
		case 4:
			$semCode="Summer"	;
			break;
	}
	$date = date("m/d/Y",strtotime($payment->date));

	if ($payment->semCode<4) {
        $total_terms = $config->getConfig('Semestral Terms');
	} else {
	    $total_terms = $config->getConfig('Summer Terms');
	}
    switch ($total_terms) {
     case 1:
        $theTerms = $term_by_1;
        $term = $theTerms[$payment->term];
        break;
    case 2:
        $theTerms = $term_by_2;
        $term = $theTerms[$payment->term];
        break;
    case 3:
        $theTerms = $term_by_3;
        $term = $theTerms[$payment->term];
        break;
    case 4:
        $theTerms = $term_by_4;
        $term = $theTerms[$payment->term];
        break;
    default:
        $theTerms = $total_terms;
        $term = $theTerms[$payment->term];
    }
	
	$sugar_smarty->assign('paymentID', $payment->paymentID );
	$sugar_smarty->assign('accID', $payment->accID );
	$sugar_smarty->assign('schYear', $payment->schYear );
	$sugar_smarty->assign('semCode', $payment->semCode );
	$sugar_smarty->assign('semCoded', $semCode );
	$sugar_smarty->assign('idno', $payment->idno );
	$sugar_smarty->assign('ORno', $payment->ORno );
	$sugar_smarty->assign('date', $date );
	$sugar_smarty->assign('paymentTypeID', $payment->paymentTypeID );
	$sugar_smarty->assign('termi', $payment->term );
	$sugar_smarty->assign('term', $term );
	$sugar_smarty->assign('amount', $payment->amount );
	$sugar_smarty->assign('encodedBy', $payment->encodedBy );
	$sugar_smarty->assign('rstatus', $payment->rstatus );
	$sugar_smarty->assign('paymentName', $payment->paymentName );

	$sugar_smarty->assign('studName', $payment->studName );
	
	if($payment->rstatus == 1 && $payment->schYear == $config->getConfig('School Year') && $payment->semCode == $config->getConfig('Semester') ) {

		// to check if the user has an access in edit
	    $accessCode = $access->getAccessCode("Edit Col Payment");
	    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );

		// to check if the user has an access in cancel
	    $accessCode = $access->getAccessCode("Cancel Col Payment");
	    $sugar_smarty->assign('hasCancel', $access->check_access($current_user->id, $accessCode) );
    } 
    
    echo $sugar_smarty->fetch('modules/Payments/templates/viewPayment.tpl');
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
        redirect('index.php?module=Payments&action=deletePayment&paymentID='+paymentID);
}
*/

function cancelPayment(paymentID, idno, accID, schYear, semCode, term, amount)
{
    reply=confirm("Do you really want to cancel the Payment?");

    if (reply==true)
        redirect('index.php?module=Payments&action=cancelPayment&paymentID='+paymentID+'&idno='+idno+'&accID='+accID+'&schYear='+schYear+'&semCode='+semCode+'&term='+term+'&amount='+amount);
}
</script>