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
require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Config/ConfigElem.php');
require_once('modules/SchoolFees/SchoolFeeElem.php');
require_once('modules/Students/StudentElem.php');
require_once('modules/Account/ChartAccountMaster.php');  
require_once('modules/Payments/ORSeries.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_ELEM']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Elem OR Header");
if ($access->check_access($current_user->id,$accessCode)) {
	
    $orseries       = new ORSeries();
    $accountMaster  = new ChartAccountMaster();
    $config         = new Config();
    $user           = new User2();
    
    unset($_SESSION['ORITEMSELEM']);

	// get the default school year
    $default_schYear = $config->getConfig('School Year');
    $sugar_smarty->assign('school_year', $default_schYear);
    
    //college
	$miscellaneous = $config->getConfig('Misc Account Code');
	$laboratory    = $config->getConfig('Lab Account Code');
	$compSubj      = $config->getConfig('Computer Subj Code');

    //high school
	$miscellaneoushs = $config->getConfig('Misc Account Code HS');
	$laboratoryhs    = $config->getConfig('Lab Account Code HS');
	$compSubjhs      = $config->getConfig('Computer Subj Code HS');

	//elementary
	$miscellaneouselem = $config->getConfig('Misc Account Code Elem');
	$laboratoryelem    = $config->getConfig('Lab Account Code Elem');
	$compSubjelem      = $config->getConfig('Computer Subj Code Elem');

	//Pre school
	$miscellaneouspre = $config->getConfig('Misc Account Code Pre');
	$laboratorypre    = $config->getConfig('Lab Account Code Pre');
	$compSubjpre      = $config->getConfig('Computer Subj Code Pre');
	
    // get the default semester
    $currentTerm = $config->getConfig('Current Payment Term');
    
    if ($currentTerm != 0) {
    	$sugar_smarty->assign('current_term', $currentTerm);
    	$sugar_smarty->assign('payment_term', $currentTerm);
    } else if ($currentTerm == '0') {
    	$sugar_smarty->assign('current_term', '0');
    	$sugar_smarty->assign('payment_term', 'Registration');
    }
    
    //User list cashier
	$where[0]['groupID']="='13'";
	$user_list = $user->retrieveAllUsers($where,'');
	$sugar_smarty->assign('user_list', $user_list);
	
	// select for OR Series
	unset($where);
	$where[0]['cashier']="='$current_user->id' AND ";
	$where[0]['rstatus']="='1'";
	$or    = $orseries->retrieveAllORSeries($where,'');
	
	if (!($or[0]['currentORNO'] > $or[0]['lastORNO'])) {
        $orno  = $or[0]['currentORNO'];	    
	}
	
	$sugar_smarty->assign('orno', $orno);
	
    // get all school fees
	unset($where);
	$where[0]['account_code'] = "!='$miscellaneous' AND account_code != '$miscellaneoushs' AND account_code != '$miscellaneouselem' AND account_code != '$miscellaneouspre' AND account_code != '$laboratory' AND account_code != '$laboratoryhs' AND account_code != '$laboratoryelem' AND account_code != '$laboratorypre' AND account_code != '$compSubj' AND account_code != '$compSubjhs' AND account_code != '$compSubjelem' AND account_code != '$compSubjpre'";
	$schoolfee_list     = $accountMaster->retrieveAllChartAccountMaster($where);
	$sugar_smarty->assign('schoolfee_list', $schoolfee_list);
	
    //school year
	$year = date("Y",time());
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year+1; $yr++) {
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
    
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Payments/templates/createORHeaderElem.tpl');

} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script>
addToValidate('frmORHeader','schYear', '', true, 'School Year');
addToValidate('frmORHeader','idno', '', true, 'ID no.');
addToValidate('frmORHeader','orno', '', true, 'OR no.');
</script>

<script language="javascript">
$('idno').focus();

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=430,left = 0,top = 0');");
}

function setIDNO(id)
{
	$('idno').value=id;
	checkStudent();
}

function onCheckDuplicate()
{
    get_data="particular=" + $('particular').value + "&action=checkduplicateentryelem";
    ajaxQuery("modules/Payments/ORHandler.php",'GET',get_data,"","onCheckDuplicateHandle");
}


function onCheckDuplicateHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (parseInt(ret)==1) {
    	    
            // hide the loading sign
            hiddenLoading('divloading');
    	    
	    	msg="Warning: Duplicate particular";
	    	
	    	alert(msg);
	    	$('particular').focus();
            
    	} else {
    	    addORItem();
    	}
    }
}

function addORItem()
{
    if($('particular').value != '' && $('amount').value != '') {
        get_data="particular=" + $('particular').value + "&amount=" + $('amount').value + "&action=addPaymentelem";
        ajaxQuery("modules/Payments/ORHandler.php",'GET',get_data,"","onAddPaymentHandle");
    } else {
        if ($('particular').value == '' && $('amount').value == '') {
            alert('Particular and amount is required!!! ');
        } else if ($('amount').value == '') {
            alert('Please specify amount!!! ');
        } else {
            alert('Please specify particular!!! ');
        }
    }
}

function onAddPaymentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		// ID No. duplicate
            $('divItem').innerHTML = ret;
            
            //clear particular, amount
            $('particular').value = '';
            $('amount').value = '';
    	} else {
    		// can't continue saving coz has no item
    		msg="Can't get any responds to the server! ";
    		displayError(msg);
    	}
    }
}

function checkStudent()
{
    get_data="idno=" + $('idno').value + "&action=DISPLAYSTUDENTINFOSELEM";
    ajaxQuery("modules/Payments/ORHandler.php",'GET',get_data,"","oncheckStudentHandle");
}

function oncheckStudentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    	    myData = ret.parseJSON();
            checkStudent2();
    	} else {
    		// can't continue saving coz has no item
    		msg="Student ID not found! ";
    		displayError(msg);
    	}
    }
}

function checkStudent2()
{
    get_data="idno=" + $('idno').value + "&action=DISPLAYSTUDENTINFOSELEM";
    ajaxQuery("modules/Payments/ORHandler.php",'GET',get_data,"","oncheckStudentHandle2");
}

function oncheckStudentHandle2()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret && (ret!='[]') && (ret!='0') && (ret!='')) {
    	    myData = ret.parseJSON();
            $('particular').focus();
            
            //display complete name
            $('lname').value    = myData[0].lname;
            $('fname').value    = myData[0].fname;
            $('mname').value    = myData[0].mname;
            $('yrLevel').value  = myData[0].yrLevel;
            $('acctBalance').innerHTML    = "<b>"+myData[0].balance+"</b>";

    	} else {
    		// can't continue saving coz has no item
    		msg="Student ID not found! ";
    		displayError(msg);
    		clearDetail();
    	}
    }
}

function clearDetail()
{
    $('lname').value    = '';
    $('fname').value    = '';
    $('mname').value    = '';    
    $('yrLevel').value   = '';    
}

function onCheckEntry()
{
    if ($('orno').value != '') {
        get_data="action=checkentryelem";
        ajaxQuery("modules/Payments/ORHandler.php",'GET',get_data,"","onCheckEntryHandle");
    } else {
        if(check_form('frmORHeader')) {
            $('frmORHeader').submit();
        }
    }
}

function onCheckEntryHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (trim(ret)!='0') {
            checkDuplicateORNO();
    	} else {
    	    msg="Sorry, can't save empty Payments.";
    	    alert(msg);
    	}
    }
}

function checkDuplicateORNO()
{
    get_data="orno=" + $('orno').value + "&action=checkduplicateornoelem";
    ajaxQuery("modules/Payments/ORHandler.php",'GET',get_data,"","chechDuplicateORNOHandle");
}

function chechDuplicateORNOHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret==-1) {
    		// OR No. duplicate
            $('frmORHeader').submit();
    	} else if (ret==1) {
    		// can't continue saving coz has no item
    		msg="Duplicate OR No.";
    		displayError(msg);
    	}
    }
}

function removeParticular(particular)
{
    get_data="particular=" + particular + "&action=removeParticularelem";
    ajaxQuery("modules/Payments/ORHandler.php",'GET',get_data,"","onRemoveParticularHandle");
    
    // display the loading sign
    l = 200 + document.body.scrollLeft;
    t = 20 + document.body.scrollTop;
    displayLoading('divloading', l, t);
    
}

function onRemoveParticularHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	 // hide the loading sign
        hiddenLoading('divloading');
    	
    	if (ret) {
	    	$('divItem').innerHTML = ret;
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    	
        
    }
}

function checkORNO() {
    if($('orno').value == '') {
        alert('No orno available! Please create your OR series.');
    }
}

checkORNO();

</script>