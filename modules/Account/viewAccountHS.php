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
require_once('modules/Config/ConfigHS.php');
require_once('modules/Account/AccountDetailHS.php');
require_once('modules/Account/AccountHS.php');
require_once('modules/SchoolFees/SchoolFeeHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_ACCT'], $mod_strings['LBL_MODULE_TITLE_ACCT_HS']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();
$config = new Config();
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View HS Account");
if ($access->check_access($current_user->id,$accessCode)) {

	$accID   = $_GET['accID'];
	$account = new Account($accID);

	if ( $accID ) {
    	
    	$sugar_smarty->assign('accID', $account->accID );
    	$sugar_smarty->assign('schYear', $account->schYear );
    	$sugar_smarty->assign('idno', $account->idno );
    	
    	$student = new Student($account->idno);
    	
    	if ($account->details) {
    	    $fees = array();
    	    $less_adjustments= array();
    	    $add_adjustments = array();
    	    foreach ($account->details as $data) {
    	        if (strtoupper($data['feeType'])=="ADD") {
                    $add_adjustments[] = $data;        
    	        } else if (strtoupper($data['feeType'])=="LESS") {
                    $less_adjustments[] = $data;        
    	        } else {
    	            $fees[] = $data;  
    	        }
    	    }
    	}

    	if (count($fees)) {
    	   $sugar_smarty->assign('fees', $fees );
    	} else {
    	   $sugar_smarty->assign('fees', "" );
    	}
    	
    	if (count($less_adjustments)) {
    	   $sugar_smarty->assign('less_adjustments', $less_adjustments );
    	} else {
    	   $sugar_smarty->assign('less_adjustments', "" );
    	}
    	
    	if (count($add_adjustments)) {
    	   $sugar_smarty->assign('add_adjustments', $add_adjustments );
    	} else {
    	   $sugar_smarty->assign('add_adjustments', "" );
    	}
    	
    	$sugar_smarty->assign('lname', $student->lname );
    	$sugar_smarty->assign('fname', $student->fname );
    	$sugar_smarty->assign('mname', $student->mname );
    	
    	switch ($student->yrLevel) {
    	 	case '1':
                $sugar_smarty->assign('yrLevel', "1<sup>st</sup>" );
    	 		break;
    	    case '2':
                $sugar_smarty->assign('yrLevel', "2<sup>nd</sup>" );
    	 		break;
	 		case '3':
                $sugar_smarty->assign('yrLevel', "3<sup>rd</sup>" );
    	 		break;
	 		case '4':
                $sugar_smarty->assign('yrLevel', "4<sup>th</sup>" );
    	 		break;
    	 	default:
    	 	    $sugar_smarty->assign('yrLevel', "Special" );
    	 		break;
    	 }
    	
    	$schoolFee = new SchoolFee();
    	$misc= $schoolFee->getMisc($account->yrLevel, $account->schYear);
    	$sugar_smarty->assign('misc', $misc['misc'] );
    	 
    	$sugar_smarty->assign('oldBalance', $account->oldBalance );
    	$sugar_smarty->assign('totalFee', $account->totalFee );
    	$sugar_smarty->assign('payment', $account->payment );
    	$sugar_smarty->assign('balance', $account->balance );
    	
        // to check if the user has an access in edit
        if ( $account->schYear==$config->getConfig('School Year') ) {
	        $accessCode = $access->getAccessCode("Edit HS Account");
	        $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
        }
    
    	echo $sugar_smarty->fetch('modules/Account/templates/viewAccountHS.tpl');
	} else {
	    $msg = "Account ID not found!";
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

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=550,height=130,left = 100,top = 100');");
}

function popUpPrint(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=400,left = 0,top = 0');");
}



function displayWindow(divId,title) 
{
    
    if (check_form('frmEnrollment')) {
        var w, h, l, t;
        w = 400;
        h = 250;
        l = screen.width/4;
        t = screen.height/4;
        
        if (navigator.appName=="Microsoft Internet Explorer") {
            l = 300 + document.body.scrollLeft;
            t = h + document.body.scrollTop;
        } else {
            l = 300 + document.body.scrollLeft;
            t = h + document.body.scrollTop;
        }
    
        // with title		        
        displayFloatingDiv(divId, title, w, h, l, t);
    }
}


</script>