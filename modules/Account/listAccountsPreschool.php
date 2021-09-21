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
global $preschool_yrs;

require_once('config.php');
require_once('include/Sugar_Smarty.php');

require_once('modules/Config/ConfigPreschool.php');  
require_once('modules/Students/StudentPreschool.php');
require_once('modules/Account/AccountPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_ACCT'], $mod_strings['LBL_MODULE_TITLE_ACCT_PRESCHOOL'], false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Preschool Account");
if ($access->check_access($current_user->id,$accessCode)) {
    $config  = new Config();
    $account = new Account();
    
    $limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
    $offset = $_GET['offset']? $_GET['offset']:0;
    
    if ($_GET['cmdFilter']) {
        $idno   = trim($_GET['idno']);
        $lname  = trim($_GET['lname']);
        $fname  = trim($_GET['fname']);
        $mname  = trim($_GET['mname']);
        $yrLevel  = trim($_GET['yrLevel']);
        $schYear  = trim($_GET['schYear']);
    } else {
        $idno   = $_SESSION[$_GET['module'].'PreschoolAcc_idno'];
        $lname  = $_SESSION[$_GET['module'].'PreschoolAcc_lname'];
        $fname  = $_SESSION[$_GET['module'].'PreschoolAcc_fname'];
        $mname  = $_SESSION[$_GET['module'].'PreschoolAcc_mname'];
        $yrLevel  = $_SESSION[$_GET['module'].'PreschoolAcc_yrLevel'];
        $schYear  = $_SESSION[$_GET['module'].'PreschoolAcc_schYear'];
    }
    
    if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'PreschoolAcc_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }
    
    // set session variables
    $_SESSION[$_GET['module'].'PreschoolAcc_idno']    = $idno;
    $_SESSION[$_GET['module'].'PreschoolAcc_lname']   = $lname;
    $_SESSION[$_GET['module'].'PreschoolAcc_fname']   = $fname;
    $_SESSION[$_GET['module'].'PreschoolAcc_mname']   = $mname;
    $_SESSION[$_GET['module'].'PreschoolAcc_yrLevel'] = $yrLevel;
    $_SESSION[$_GET['module'].'PreschoolAcc_schYear'] = $schYear;
    
    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND accounts.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['accounts.schYear'] = " = '$schYear' ";
        }
    }
    
    if (trim($idno)!='') {
        if (count($conds[0])) {
            $conds[0][' AND accounts.idno'] = "= '$idno' ";
        } else {
            $conds[0]['accounts.idno'] = "= '$idno' ";
        }
    }
        
    if (trim($lname)!='') {
        if (count($conds[0])) {
            $conds[0][' AND students.lname'] = " like '$lname%' ";
        } else {
            $conds[0]['students.lname'] = " like '$lname%' ";
        }
    }
    
    if (trim($fname)!='') {
        if (count($conds[0])) {
            $conds[0][' AND students.fname'] = " like '$fname%' ";
        } else {
            $conds[0]['students.fname'] = " like '$fname%' ";
        }
    }
    
    if (trim($mname)!='') {
        if (count($conds[0])) {
            $conds[0][' AND students.mname'] = " like '$mname%' ";
        } else {
            $conds[0]['students.mname'] = " like '$mname%' ";
        }
    }
    
    if ($yrLevel) {
        if (count($conds[0])) {
            $conds[0][' AND students.yrLevel'] = " = '$yrLevel' ";
        } else {
            $conds[0]['students.yrLevel'] = " = '$yrLevel' ";
        }
    }
    
    if (count($conds[0])) {
        $conds[0][' AND accounts.rstatus'] = " = '1' ";
    } else {
        $conds[0]['accounts.rstatus'] = " = '1' ";
    }
    
    
//    $allAccounts = $account->retrieveAllAccountsAssociation($conds);
    $allAccounts = $account->countAllAccountsAssociation($conds);
    $list        = $account->retrieveAllAccountsAssociation($conds,"accounts.schYear","DESC",$offset, $limit);

	$total_rec=$allAccounts;
    	
    $main_url="index.php?module=Account&action=listAccountsPreschool&idno=$idno&lname=$lname&fname=$fname&mname=$mname&yrLevel=$yrLevel&schYear=$schYear";
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year+1; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" >'."\n";
	$schoolYear.='<option value="">---------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	    	if ($value == $schYear) {
	        	$schoolYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schoolYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schoolYear.='</select>';
	
	$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);
	
	// check if the list is empty
    if (!count($list)) {
        $list = "";
    }
    
    
    // year levels
    $yrLevel_object = '<select name="yrLevel" id="yrLevel">'."\n";
    $yrLevel_object .= '<option value="">--------</option>'."\n";
    foreach ($preschool_yrs as $key=>$val) {
        if ($key==$yrLevel)
            $yrLevel_object .= '<option value="'.$key.'" selected>'.$val.'</option>'."\n";
        else
            $yrLevel_object .= '<option value="'.$key.'">'.$val.'</option>."\n"';
    }
    $yrLevel_object .= '</select>'."\n";
    $sugar_smarty->assign('yrLevel_object', $yrLevel_object );
    
    $sugar_smarty->assign('list', $list );
    $sugar_smarty->assign('idno', $idno );
    $sugar_smarty->assign('lname', $lname );
    $sugar_smarty->assign('fname', $fname );
    $sugar_smarty->assign('mname', $mname );
    $sugar_smarty->assign('schYear', $schYear );
    $sugar_smarty->assign('yrLevel', $yrLevel );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit,$export_link,$print_link) );
    
    echo $sugar_smarty->fetch('modules/Account/templates/listAccountsPreschool.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script type='text/javascript'>
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=500,left = 0,top = 0');");
}

// set focus
$('idno').focus();
</script>