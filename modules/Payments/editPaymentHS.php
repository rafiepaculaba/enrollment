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
require_once('modules/Students/StudentHS.php');
require_once('modules/Payments/PaymentTypeHS.php');
require_once('modules/Payments/PaymentHS.php');
require_once('modules/Account/AssessmentHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit HS Payment");
if ($access->check_access($current_user->id,$accessCode)) {

	$paymentID = $_GET['paymentID'];
	
	$payment = new Payment($paymentID);
	$payment->paymentID = $paymentID;
	$payment->retrievePayment(1); // locked

	$sugar_smarty->assign('paymentID', $payment->paymentID );
	$sugar_smarty->assign('accID', $payment->accID );
	$sugar_smarty->assign('schYear', $payment->schYear );
	$sugar_smarty->assign('idno', $payment->idno );
	$sugar_smarty->assign('ORno', $payment->ORno );
	$sugar_smarty->assign('date', $payment->date );
	$sugar_smarty->assign('paymentTypeID', $payment->paymentTypeID );
	$sugar_smarty->assign('term', $payment->term );
	$sugar_smarty->assign('amount', $payment->amount );
	$sugar_smarty->assign('rstatus', $payment->rstatus );
	
	
	//school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear" tabindex="1" disabled>'."\n";
	$schYear.='<option value="">-----------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	    	if ($value == $payment->schYear) {
	        	$schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schYear.='</select>';

	//terms
	$colterms='<select name="term" id="term" onchange = "displayAccountsHS();" disabled>'."\n";
	$colterms.='<option value="">-----------------------------------</option>'."\n";
	if ($terms['hs']) {
	    foreach ($terms['hs'] as $key1=>$value1) {
	    	if($key1 == $payment->term){
	        $colterms .= '<option value="'.$key1.'" selected>'.$value1.'</option>'."\n";
	    	}else {
	        $colterms .= '<option value="'.$key1.'">'.$value1.'</option>'."\n";
	    }
	    }
	}
	$colterms.='</select>';
	
	//student list
    $stud = new Student($payment->idno);
    $result  = $stud->retrieveAllStudents($where);
    
    $name = $stud->lname.", ".$stud->fname." ". $stud->mname;

    
	//Assessment list Begin
	$ass = new Assessment();

	if ($payment->schYear) {
	    $conds[0]['schYear'] = "= '$payment->schYear' AND ";
	}
	if ($payment->idno) {
	    $conds[0]['idno'] = "= '$payment->idno' AND ";
	}
	if ($payment->term) {
	    $conds[0]['term'] = "= '$payment->term'";
	}

	$result2 = $ass->retrieveAllAssessments($conds);
	
	$sugar_smarty->assign('term', $payment->term );
	$sugar_smarty->assign('assID', $result2[0][assID] );
	$sugar_smarty->assign('assID_td', $result2[0][assID] );
	$sugar_smarty->assign('assaccID', $result2[0][accID] );
	$sugar_smarty->assign('assoldBalance', $result2[0][oldBalance] );
	$sugar_smarty->assign('asstuitionFee', $result2[0][tuitionFee] );
	$sugar_smarty->assign('asslabFee', $result2[0][labFee] );
	$sugar_smarty->assign('assregFee', $result2[0][regFee] );
	$sugar_smarty->assign('assmiscFee', $result2[0][miscFee] );
	$sugar_smarty->assign('assaddAjd', $result2[0][addAdj] );
	$sugar_smarty->assign('asslessAdj', $result2[0][lessAdj] );
	$sugar_smarty->assign('asstotalFees', $result2[0][totalFees] );
	$sugar_smarty->assign('assttlPayment', $result2[0][ttlPayment] );
	$sugar_smarty->assign('assbalance', $result2[0][balance] );
	$sugar_smarty->assign('assttlDue', $result2[0][ttlDue] );
	$sugar_smarty->assign('assamtPaid', $result2[0][amtPaid] );
	//Assessment list End	
	
	$sugar_smarty->assign('TERMS', $colterms);
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);
	$sugar_smarty->assign('name', $name);
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');	
	echo $sugar_smarty->fetch('modules/Payments/templates/editPaymentHS.tpl');
	calendarSetup('date', 'jscal_trigger');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmPaymentHS','amount', '', true, 'Amount');
addToValidate('frmPaymentHS','ORno', '', true, 'OR #');
</script>

<script language="javascript">
function isFloatAmount()
{
	if (isFloatValue($('amount').value) == true ) {
	//continue
		onSubmit();
	} else {
		//Stop running
		alert("Error: Invalid amount inputed!!");
	}
}

function onSubmit()
{ 
	 if (check_form('frmPaymentHS')) {
	 	// enabled all disabled controls
	 	$('schYear').disabled=false;
	 	$('term').disabled=false;
		
	 	$('frmPaymentHS').submit();
	 }
}

$('ORno').focus();
</script>