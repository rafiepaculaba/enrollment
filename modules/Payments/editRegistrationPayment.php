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
require_once('modules/Payments/PaymentType.php');
require_once('modules/Payments/Payment.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Account/Assessment.php');
require_once('modules/Payments/RegistrationPayment.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Col Registration Payment");
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

	//semester
	$semesters='<select name="semCode" id="semCode" tabindex="2" disabled >'."\n";
	$semesters.='<option value="">-----------------</option>'."\n";
	if ($esConfig['semesters']) {
	    foreach ($esConfig['semesters'] as $key=>$value) {
	    	if ($key == $regpayment->semCode) {
	        	$semesters .= '<option value="'.$key.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$semesters.='</select>';
		
	//student list
	$stud = new Student($regpayment->idno);
    $result  = $stud->retrieveAllStudents();
    
    $name = $stud->lname.", ".$stud->fname." ". $stud->mname;
	
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);
	$sugar_smarty->assign('SEMESTERS', $semesters);
	$sugar_smarty->assign('name', $name);
    
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');	
	echo $sugar_smarty->fetch('modules/Payments/templates/editRegistrationPayment.tpl');
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
addToValidate('frmRegistrationPayment','amount', '', true, 'Amount');
addToValidate('frmRegistrationPayment','ORno', '', true, 'OR #');
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
	 if (check_form('frmRegistrationPayment')) {
	 	// enabled all disabled controls
	 	$('schYear').disabled=false;
	 	$('semCode').disabled=false;
	 	$('type1').disabled=false;
	 	$('type2').disabled=false;

	 	$('frmRegistrationPayment').submit();
	 		
	 }
}

function displayStudentInfo()
{
    get_data="idno=" + $('idno').value + "&action=displaystudentinfos";
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
				$('amount').focus();
    			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

$('ORno').focus();
</script>