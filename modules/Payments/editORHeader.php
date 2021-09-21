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
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Config/ConfigCol.php');
require_once('modules/SchoolFees/SchoolFeeCol.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Payments/ORSeries.php');
require_once('modules/Payments/ORHeader.php');
require_once('modules/Payments/ORDetails.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Col OR Header");
if ($access->check_access($current_user->id,$accessCode)) {
	
    unset($_SESSION['ORITEMS']);
    $config     = new Config();
   	$paymentID = $_GET['paymentID'];
	
	$orheader = new ORHeader($paymentID);
	$schoolFee = new SchoolFee();
	
    // to check if the user has an access in edit
    $accessCode = $access->getAccessCode("Edit Col OR Header");
    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
    
    // to check if the user has an access in delete
    $accessCode = $access->getAccessCode("Delete Col OR Header");
    $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );

    $sugar_smarty->assign('paymentID', $orheader->paymentID );
    $sugar_smarty->assign('orno', $orheader->orno );
    $student = new Student($orheader->idno);

    $sugar_smarty->assign('idno', $orheader->idno );
    $sugar_smarty->assign('lname', $student->lname );
    $sugar_smarty->assign('fname', $student->fname );
    $sugar_smarty->assign('mname', $student->mname );
    $sugar_smarty->assign('accID', $orheader->accID );
    $sugar_smarty->assign('schYear', $orheader->schYear );
    $sugar_smarty->assign('semCode', $orheader->semCode );
    $sugar_smarty->assign('term', $orheader->term );
    $sugar_smarty->assign('dateCreated', $orheader->dateCreated );
    $sugar_smarty->assign('totalAmount', $orheader->totalAmount );
    $sugar_smarty->assign('cashier', $orheader->cashier );
    $sugar_smarty->assign('rstatus', $orheader->rstatus );
    
   if ($orheader->particular) {
        $ctr=0;
        foreach($orheader->particular as $row) {
            
            //display schoolfee item
            $account_code = $row['account_code'];
            unset($where);
            $where[0]['account_code'] = "='$account_code'";
            $particular = $schoolFee->retrieveAllSchoolFees($where);
            
            $data[$ctr]['particular'] = $particular[0]['item'];
            $data[$ctr]['amount'] = $row['amount'];
            $total_amount += $row['amount']; 
            $ctr++;
            
        }
    }

    $_SESSION['ORITEMS'][] = $data;
    
    // get the default school year
    $default_schYear = $config->getConfig('School Year');
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
	
    // get the default semester
    $default_semCode = $config->getConfig('Semester');
    
    $semesters='<select name="semCode" id="semCode" onchange="getTerms();" >'."\n";
    $semesters.='<option value="">------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$default_semCode) {
                $semesters .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $semesters.='</select>';
    $sugar_smarty->assign('SEMESTERS', $semesters);

    // list for OR details
    $sugar_smarty->assign('ordetails', $data);
    $sugar_smarty->assign('total_amount', $total_amount);
	    
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Payments/templates/editORHeader.tpl');
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
addToValidate('frmORHeader','semCode', '', true, 'Semester');
addToValidate('frmORHeader','idno', '', true, 'ID no.');
addToValidate('frmORHeader','orno', '', true, 'OR no.');
</script>

<script language="javascript">
$('idno').focus();

function onCheckDuplicate()
{
    get_data="particular=" + $('particular').value + "&action=checkduplicateentry";
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
        get_data="particular=" + $('particular').value + "&amount=" + $('amount').value + "&action=addPayment";
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
    	alert(ret);
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
    get_data="idno=" + $('idno').value + "&action=DISPLAYSTUDENTINFOS";
    ajaxQuery("modules/Payments/ORHandler.php",'GET',get_data,"","oncheckStudentHandle");
}

function oncheckStudentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret && (ret!='[]') && (ret!='0') && (ret!='')) {
    	    myData = ret.parseJSON();
            $('orno').focus();
            
            //display complete name
            $('lname').value = myData[0].lname;
            $('fname').value = myData[0].fname;
            $('mname').value = myData[0].mname;

            getSchoolFees();
    	} else {
    		// can't continue saving coz has no item
    		msg="Student ID not found! ";
    		displayError(msg);
    	}
    }
}

function getSchoolFees()
{
    get_data="schYear=" + $('schYear').value + "&idno=" + $('idno').value + "&action=getschoolfees";
    ajaxQuery("modules/payments/ORHandler.php",'GET',get_data,"","onGetSchoolFeesHandle");
}

function onGetSchoolFeesHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		initializeCombo('particular'," ------------------------------ ");
			myData = ret.parseJSON();
			for(c = 0; c < myData.length; c++){
		    	var y=document.createElement('option');
		    	y.text=myData[c].item;				
				y.setAttribute('value',myData[c].account_code);		
				var x=$('particular');

				if (navigator.appName=="Microsoft Internet Explorer") {
					x.add(y); // IE only  
				} else {
					x.add(y,null);
				}
			}	
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function clearDetail()
{
    $('lname').value = '';
    $('fname').value = '';
    $('mname').value = '';    
}

function onCheckEntry()
{
    get_data="action=checkentry";
    ajaxQuery("modules/Payments/ORHandler.php",'GET',get_data,"","onCheckEntryHandle");
}

function onCheckEntryHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (trim(ret)!='0') {
            saveORHeader();
    	} else {
    	    msg="Sorry, can't save empty Payments.";
    	    alert(msg);
    	}
    }
}

function saveORHeader() {
    if(check_form('frmORHeader')) {
         $('frmORHeader').submit();
    }
}

function removeParticular(particular)
{
    get_data="particular=" + particular + "&action=removeParticular";
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
getSchoolFees();
</script>