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
require_once('modules/Account/AccountDetailPreschool.php');
require_once('modules/Account/AccountPreschool.php');
require_once('modules/Payments/PaymentTypePreschool.php');
require_once('modules/Students/StudentPreschool.php');
require_once('modules/Config/ConfigPreschool.php');


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
	$accessCode = $access->getAccessCode("Create Preschool Payment");
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
	$schYear.='<option value="">-------------------</option>'."\n";
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
	
    // get the default Term
    $default_term = $config->getConfig('Terms');

	//terms
	$terms ='<select name="term" id="term" onchange="displayAccountsPreschool();" >'."\n";
	$terms.='<option value="">------------------------</option>'."\n";
	if ($default_term) {
	    if (is_array($default_term)) {
    	    foreach ($default_term as $key1=>$value) {
               $terms .= '<option value="'.$key1.'">'.$value.'</option>'."\n";
    	    }
	    } else {
	    	$ctr=1;
		        while ($ctr<=$default_term) {
		            $terms .= '<option value="'.$ctr.'">'.$ctr.'</option>'."\n";
		            $ctr++;    
		        }
	    }
	}

	$terms.='</select>';
	$sugar_smarty->assign('TERMS', $terms);
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');	
	echo $sugar_smarty->fetch('modules/Payments/templates/createPaymentPreschool.tpl');
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
addToValidate('frmPaymentPreschool','schYear', '', true, 'School Year');
addToValidate('frmPaymentPreschool','idno', '', true, 'ID No.');
addToValidate('frmPaymentPreschool','ORno', '', true, 'Official Receipt No.');
addToValidate('frmPaymentPreschool','date', '', true, 'Date');
addToValidate('frmPaymentPreschool','term', '', true, 'Term');
addToValidate('frmPaymentPreschool','amount', '', true, 'Amount');
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
    get_data="schYear=" + $('schYear').value + "&term=" + $('term').value + "&idno=" + $('idno').value + "&action=validatepaymentpaymentpreschool";
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
			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function checkInformation()
{
    get_data="idno=" + $('idno').value + "&action=checkstudinformationpaymentpreschool";
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
				if (($('amount').value == '' || $('schYear').value == '' || $('term').value == '' || $('idno').value == '') && ($('assID').value != '')) {
					if (check_form('frmPaymentPreschool')) {
			    				$('frmPaymentPreschool').submit();	
			    	}
				} else {
					alert(" Wrong student information displayed.. ");
				}
			}
			else {
	    		myData = ret.parseJSON();
				if (($('name').value == (myData[0].lname + ", " + myData[0].fname + " " + myData[0].mname)) && ($('assID').value != '')) {
					if (check_form('frmPaymentPreschool')) {
			    				$('frmPaymentPreschool').submit();	
			    	}
				} else if ($('amount').value == '' || $('schYear').value == '' || $('term').value == '' || $('idno').value == '' && ($('assID').value != ''))  {
					if (check_form('frmPaymentPreschool')) {
			    				$('frmPaymentPreschool').submit();	
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

function displayStudentInfoPreschool()
{
    get_data="idno=" + $('idno').value + "&action=displaystudentinfosPreschool";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onDisplayStudentInfosHandlePreschool");
}

function onDisplayStudentInfosHandlePreschool()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
				displayStudentInfoPreschool2();
	  			$('assID').value 			= "";
	   			$('assID_td').innerHTML		= "-";
    			$('accID').innerHTML 		= "-";
    			$('accID_input').value		= "";
				$('amtPaid').innerHTML 		= "-";
				$('ttlDue').innerHTML 		= "-";
				$('balance').innerHTML 		= "-";
				$('term').value 			= '';	

    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function displayStudentInfoPreschool2()
{
    get_data="idno=" + $('idno').value + "&action=displaystudentinfosPreschool";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onDisplayStudentInfosHandlePreschool2");
}

function onDisplayStudentInfosHandlePreschool2()
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
				$('term').focus();
    			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function displayAccountsPreschool()
{
	if($('term').value != ''){
    get_data="schYear=" + $('schYear').value + "&idno=" + $('idno').value + "&term=" + $('term').value + "&action=displayaccountsPreschool";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onDisplayAccountHandlePreschool");
	} else {
    			$('assID').value 			= "";
    			$('assID_td').innerHTML		= "-";
    			$('accID').innerHTML 		= "-";
    			$('accID_input').value		= "";
				//$('oldBalance').innerHTML 	= "-";
				//$('tuition').innerHTML 		= "-";
				//$('labFee').innerHTML 		= "-";
				//$('regFee').innerHTML 		= "-";
				//$('miscFee').innerHTML 		= "-";
				//$('addAdj').innerHTML 		= "-";
				//$('lessAdj').innerHTML 		= "-";
				//$('ttlPayment').innerHTML 	= "-";
				//$('totalFees').innerHTML 	= "-";
				$('amtPaid').innerHTML 		= "-";
				$('ttlDue').innerHTML 		= "-";
				$('balance').innerHTML 		= "-";

	}
}

function onDisplayAccountHandlePreschool()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
    			if(ret == '[]' || ret == '0' || ret == 'null') {
    				alert("No data found !!");
    				$('term').value = '';	
    				$('term').focus();	
    				myData = ret.parseJSON();

    			$('assID').value	 		= "";
    			$('assID_td').innerHTML		= "-";
    			$('accID').innerHTML 		= "-";
    			$('accID_input').value		= "";
				//$('oldBalance').innerHTML 	= "-";
				//$('tuition').innerHTML 		= "-";
				//$('labFee').innerHTML 		= "-";
				//$('regFee').innerHTML 		= "-";
				//$('miscFee').innerHTML 		= "-";
				//$('addAdj').innerHTML 		= "-";
				//$('lessAdj').innerHTML 		= "-";
				//$('ttlPayment').innerHTML 	= "-";
				//$('totalFees').innerHTML 	= "-";
				$('amtPaid').innerHTML 		= "-";
				$('ttlDue').innerHTML 		= "-";
				$('balance').innerHTML 		= "-";

    			}
    			else {
	    		myData = ret.parseJSON();
	    		//idnametxt, 
				
	    		var account = 0;
	    		
	    		$('assID').value 			= myData[0].assID;
	    		$('assID_td').innerHTML		= myData[0].assID;
				$('accID_input').value 	    = myData[0].accID;
				$('accID').innerHTML 		= myData[0].accID;
				//$('oldBalance').innerHTML 	= myData[0].oldBalance;
				//$('tuition').innerHTML 		= myData[0].tuitionFee;
				//$('labFee').innerHTML 		= myData[0].labFee;
				//$('regFee').innerHTML 		= myData[0].regFee;
				//$('miscFee').innerHTML 		= myData[0].miscFee;
				//$('addAdj').innerHTML 		= myData[0].addAdj;
				//$('lessAdj').innerHTML 		= myData[0].lessAdj;
				$('amtPaid').innerHTML 		= myData[0].amtPaid;
				$('ttlDue').innerHTML 		= myData[0].ttlDue;
				//$('ttlPayment').innerHTML 	= myData[0].ttlPayment;
				//$('totalFees').innerHTML 	= myData[0].totalFees;
				$('balance').innerHTML 		= myData[0].balance;
				
				}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

$('ORno').focus();
</script>