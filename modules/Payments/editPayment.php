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
require_once('modules/Account/Assessment.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Col Payment");
if ($access->check_access($current_user->id,$accessCode)) {

	// get all default setting from configs
    $config = new Config();
	$paymentID = $_GET['paymentID'];
	
	$payment = new Payment($paymentID);
	$payment->paymentID = $paymentID;
	$payment->retrievePayment(1); // locked

	$paymentType = new PaymentType();
	$paymentType_list = $paymentType->retrieveAllPaymentTypes();

	$sugar_smarty->assign('paymentType_list', $paymentType_list);

	//school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear" disabled >'."\n";
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

	//semester
	$semesters='<select name="semCode" id="semCode" disabled>'."\n";
	$semesters.='<option value="">-----------------</option>'."\n";
	if ($esConfig['semesters']) {
	    foreach ($esConfig['semesters'] as $key=>$value) {
	    	if ($key == $payment->semCode) {
	        	$semesters .= '<option value="'.$key.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$semesters.='</select>';
	

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

    $terms ='<select name="term" id="term" disabled>'."\n";
	$terms.='<option value="">----------------------------------</option>'."\n";
    $terms .= '<option value="'.$payment->term.'" selected>'.$term.'</option>'."\n";
	$terms.='</select>';
	$sugar_smarty->assign('TERMS', $terms);

	//student list
    $stud = new Student($payment->idno);
    $result  = $stud->retrieveAllStudents($where);
    
    $name = $stud->lname.", ".$stud->fname." ". $stud->mname;

    
//Assessment list Begin
	$ass = new Assessment();
	
	if ($payment->schYear) {
	    $conds[0]['schYear'] = "= '$payment->schYear' AND ";
	}
	if ($payment->semCode) {
	    $conds[0]['semCode'] = "= '$payment->semCode' AND ";
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
	
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);
	$sugar_smarty->assign('SEMESTERS', $semesters);
	$sugar_smarty->assign('name', $name);

	$sugar_smarty->assign('paymentID', $payment->paymentID );
	$sugar_smarty->assign('accID', $payment->accID );
	$sugar_smarty->assign('schYear', $payment->schYear );
	$sugar_smarty->assign('semCode', $payment->semCode );
	$sugar_smarty->assign('idno', $payment->idno );
	$sugar_smarty->assign('ORno', $payment->ORno );
	$sugar_smarty->assign('date', $payment->date );
	$sugar_smarty->assign('paymentTypeID', $payment->paymentTypeID );
	$sugar_smarty->assign('term', $term );
	$sugar_smarty->assign('amount', $payment->amount );
	$sugar_smarty->assign('rstatus', $payment->rstatus );

	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');	
	echo $sugar_smarty->fetch('modules/Payments/templates/editPayment.tpl');
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
addToValidate('frmPayment','amount', '', true, 'Amount');
addToValidate('frmPayment','ORno', '', true, 'OR #');
</script>

<script language="javascript">
function isFloatAmount()
{
	if (isFloatValue($('amount').value)) {
	//continue
		onSubmit();
	} else {
		//Stop running
		alert("Error: Invalid amount inputed!!");
	}
}

function onSubmit()
{
	 if (check_form('frmPayment')) {
	 	// enabled all disabled controls
	 	$('schYear').disabled=false;
	 	$('semCode').disabled=false;
	 	$('term').disabled=false;
		
	 	$('frmPayment').submit();
	 		
	 }
}

$('ORno').focus();
</script>