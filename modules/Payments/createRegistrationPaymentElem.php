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
require_once('modules/Account/AccountDetailElem.php');
require_once('modules/Account/AccountElem.php');
require_once('modules/Payments/PaymentTypeElem.php');
require_once('modules/Students/StudentElem.php');
require_once('modules/Config/ConfigElem.php');
echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_ELEM']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
	$accessCode = $access->getAccessCode("Create Elem Registration Payment");
if ($access->check_access($current_user->id,$accessCode)) {
	
	// get all default setting from configs
    $config = new Config();
    
    // get the default school year
    $default_schYear = $config->getConfig('School Year');
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear">'."\n";
	$schYear.='<option value="">--------------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	        if ($value==$default_schYear) {
	           $schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$schYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);

echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');	
echo $sugar_smarty->fetch('modules/Payments/templates/createRegistrationPaymentElem.tpl');
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
addToValidate('frmRegistrationPaymentElem','schYear', '', true, 'School Year');
addToValidate('frmRegistrationPaymentElem','idno', '', true, 'ID No.');
addToValidate('frmRegistrationPaymentElem','ORno', '', true, 'Official Receipt No.');
addToValidate('frmRegistrationPaymentElem','date', '', true, 'Date');
addToValidate('frmRegistrationPaymentElem','amount', '', true, 'Amount');
</script>

<script language="javascript">
function isFloatAmount()
{
	if (isFloatValue($('amount').value) == true ) {
	//continue
		validatePayment();
	} else {
		//Stop running
		alert("Error: Invalid amount inputed!!");
	}
}

function validatePayment()
{
    get_data="schYear=" + $('schYear').value + "&idno=" + $('idno').value + "&action=validatepaymentelem";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onValidatePaymentHandle");
}

function onValidatePaymentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
			if(ret == '[]' || ret == '0' ) {
					
				checkInformation();
			}
			else {
				checkInformation();
				//alert("Student Already Paid ...");
			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function checkInformation()
{
    get_data="idno=" + $('idno').value + "&action=checkstudinformationelem";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onCheckinformationHandle");
	
}

function onCheckinformationHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
			if(ret == '[]' || ret == '0' ) {
				if ($('amount').value == '' || $('schYear').value == '' || $('idno').value == '') {
					if (check_form('frmRegistrationPaymentElem')) {
			    				$('frmRegistrationPaymentElem').submit();	
			    	}
				} else {
					alert(" Wrong student information displayed.. ");
				}
			}
			else {
	    		myData = ret.parseJSON();
				if ($('name').value == (myData[0].lname + ", " + myData[0].fname + " " + myData[0].mname)) {
					if (check_form('frmRegistrationPaymentElem')) {
			    				$('frmRegistrationPaymentElem').submit();	
			    	}
				} else if ($('amount').value == '' || $('schYear').value == '' || $('idno').value == '')  {
					if (check_form('frmRegistrationPaymentElem')) {
			    				$('frmRegistrationPaymentElem').submit();	
			    	}
				} else {
					alert(" Wrong student information displayed.. ");
				}
			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function displayStudentInfo()
{
    get_data="idno=" + $('idno').value + "&action=displaystudentinfosElem";
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