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
require_once('modules/Account/AccountDetailHS.php');
require_once('modules/Account/AccountHS.php');
require_once('modules/Refunds/RefundHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit HS Refund");
if ($access->check_access($current_user->id,$accessCode)) {

	$refundID = $_GET['refundID'];

	$refund = new Refund($refundID);
	$refund->refundID = $refundID;
	$refund->retrieveRefund(1); // locked

	$sugar_smarty->assign('refundID', $refund->refundID );
	$sugar_smarty->assign('accID', $refund->accID );
	$sugar_smarty->assign('idno', $refund->idno );
	$sugar_smarty->assign('schYear', $refund->schYear );
	$sugar_smarty->assign('date', $refund->date );
	$sugar_smarty->assign('amount', $refund->amount );
	$sugar_smarty->assign('rstatus', $refund->rstatus );
	
	$acc = new Account($refund->accID);

	$balance = (-1 * $refund->amount) + $acc->balance;
	
	$sugar_smarty->assign('balance', abs($balance) );
	
	//student list
    $stud = new Student($refund->idno);
    $result  = $stud->retrieveAllStudents($where);
    
    $name = $stud->lname.", ".$stud->fname." ". $stud->mname;
	$sugar_smarty->assign('name', $name );

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
	    	if ($value == $refund->schYear) {
	        	$schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schYear.='</select>';

	$sugar_smarty->assign('SCHOOLYEAR', $schYear);
	$sugar_smarty->assign('SEMESTERS', $semesters);
	
	echo $sugar_smarty->fetch('modules/Refunds/templates/editRefundHS.tpl');
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
addToValidate('frmRefundHS','amount', '', true, 'Amount');
</script>
<script language="javascript"> 
function isFloatAmount()
{
	if (isFloatValue($('amount').value) == true ) {
	//continue
		onSubmit();
	} else {
		//Stop running
		alert("Transaction cannot proceed amount inputed is invalid!!");
	}
}

function onSubmit()
{
    get_data="idno=" + $('idno').value +"&schYear=" + $('schYear').value +"&amount=" + $('amount').value +"&balance=" + $('balance').value + "&action=editcheckamountshs";
    ajaxQuery("modules/Refunds/refundHandler.php",'GET',get_data,"","onCheckAmountHandle");
}
function onCheckAmountHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
    			if(ret == '0' || ret == -1 ) {
    				alert("Amount should Less than or Equal to Refundable Amount!");
    				$('amount').focus();
	   			}
    			else {
						 if (check_form('frmRefundHS')) {
						 	// enabled all disabled controls
						 	$('schYear').disabled=false;
					
						 	$('frmRefundHS').submit();
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
    get_data="idno=" + $('idno').value +"&schYear=" + $('schYear').value + "&action=displaystudentinfoshs";
    ajaxQuery("modules/Refunds/refundHandler.php",'GET',get_data,"","onDisplayStudentInfosHandle");
}

function onDisplayStudentInfosHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
    			if(ret == '[]' || ret == '0' ) {
    				alert("No Record Found !!");
    				$('idno').focus();	
    				myData = ret.parseJSON();
    				$('balance').value = "";
	   			}
    			else {
	    		myData = ret.parseJSON();
	    		//idnametxt, 
	    		if(myData[0].balance < 0) {
	    		$('balance').value= myData[0].balance;	
	    		}
	    		else {
	    			alert("No Refundable Amount..");
	    		}
	    		
				$('accID').value = myData[0].accID;	
				$('amount').focus();
    			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

$('amount').focus();
</script>