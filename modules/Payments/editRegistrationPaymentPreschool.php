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
require_once('modules/Payments/PaymentTypePreschool.php');
require_once('modules/Payments/PaymentPreschool.php');
require_once('modules/Students/StudentPreschool.php');
require_once('modules/Account/AssessmentPreschool.php');
require_once('modules/Payments/RegistrationPaymentPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Preschool Registration Payment");
if ($access->check_access($current_user->id,$accessCode)) {

	$regPaymentID = $_GET['regPaymentID'];
	
	$regpayment = new RegistrationPayment($regPaymentID);
	$regpayment->regPaymentID = $regPaymentID;
	$regpayment->retrieveRegistrationPayment(1); // locked

	$sugar_smarty->assign('regPaymentID', $regpayment->regPaymentID );
	$sugar_smarty->assign('schYear', $regpayment->schYear );
	$sugar_smarty->assign('semCode', $regpayment->semCode );
	$sugar_smarty->assign('idno', $regpayment->idno );
	$sugar_smarty->assign('ORno', $regpayment->ORno );
	$sugar_smarty->assign('type', $regpayment->type );
	$sugar_smarty->assign('date', $regpayment->date );
	$sugar_smarty->assign('amount', $regpayment->amount );
	$sugar_smarty->assign('encodedBy', $regpayment->encodedBy );
	$sugar_smarty->assign('rstatus', $regpayment->rstatus );
	
	//school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear" disabled>'."\n";
	$schYear.='<option value="">-----------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	    	if ($value == $regpayment->schYear) {
	        	$schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schYear.='</select>';

	//student list
	$stud = new Student($regpayment->idno);
    $result  = $stud->retrieveAllStudents();
    
    $name = $stud->lname.", ".$stud->fname." ". $stud->mname;
	
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);
	$sugar_smarty->assign('name', $name);
    
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');	
	echo $sugar_smarty->fetch('modules/Payments/templates/editRegistrationPaymentPreschool.tpl');
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
addToValidate('frmRegistrationPaymentPreschool','amount', '', true, 'Amount');
addToValidate('frmRegistrationPaymentPreschool','ORno', '', true, 'OR #');
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
	 if (check_form('frmRegistrationPaymentPreschool')) {
	 	// enabled all disabled controls
	 	$('schYear').disabled=false;
	 	$('type1').disabled=false;
	 	$('type2').disabled=false;

	 	$('frmRegistrationPaymentPreschool').submit();
	 		
	 }
}

function displayStudentInfo()
{
    get_data="idno=" + $('idno').value + "&action=displaystudentinfosPreschool";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onDisplayStudentInfosHandle");
}

function onDisplayStudentInfosHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
    			if(ret == '[]' || ret == '0' ) {
    				alert("ID no. does not exist !!");
    				$('idno').focus();	
    				myData = ret.parseJSON();

				$('name').value= '';	
	   			}
    			else {
	    		myData = ret.parseJSON();
	    		//idnametxt, 
				$('name').value= '';			
				$('name').value=myData[0].lname + ", " + myData[0].fname + " " + myData[0].mname;
				$('paymentTypeID').focus();	
    			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function displayAccounts()
{
    get_data="idno=" + $('idno').value + "&term=" + $('term').value + "&action=displayaccounts";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onDisplayAccountHandle");
}

function onDisplayAccountHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
    			if(ret == '[]' || ret == '0' ) {
    				alert("No data found !!");
    				$('term').focus();	
    				myData = ret.parseJSON();

    			$('accID').innerHTML 		= "-";
				$('oldBalance').innerHTML 	= "-";
				$('tuition').innerHTML 		= "-";
				$('labFee').innerHTML 		= "-";
				$('regFee').innerHTML 		= "-";
				$('miscFee').innerHTML 		= "-";
				$('addAdj').innerHTML 		= "-";
				$('lessAdj').innerHTML 		= "-";
				$('ttlDue').innerHTML 		= "-";
				$('balance').innerHTML 		= "-";
				$('ttlPayment').innerHTML 	= "-";
				$('totalFees').innerHTML 	= "-";
	   			}
    			else {
	    		myData = ret.parseJSON();
	    		//idnametxt, 
				
	    		var account = 0;
	    		
	    		$('assID').value 			= myData[0].assID;
				$('accID').innerHTML 		= myData[0].accID;
				$('oldBalance').innerHTML 	= myData[0].oldBalance;
				$('tuition').innerHTML 		= myData[0].tuitionFee;
				$('labFee').innerHTML 		= myData[0].labFee;
				$('regFee').innerHTML 		= myData[0].regFee;
				$('miscFee').innerHTML 		= myData[0].miscFee;
				$('addAdj').innerHTML 		= myData[0].addAdj;
				$('lessAdj').innerHTML 		= myData[0].lessAdj;
				$('ttlDue').innerHTML 		= myData[0].ttlDue;
				$('ttlPayment').innerHTML 	= myData[0].ttlPayment;
				$('totalFees').innerHTML 	= myData[0].totalFees;
				$('balance').innerHTML 		= myData[0].balance;
				
				}    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

$('ORno').focus();
</script>