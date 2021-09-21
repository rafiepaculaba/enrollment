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
require_once('modules/Registrations/RegistrationHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$reg = new Registration();

$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
$offset = $_GET['offset']? $_GET['offset']:0;

if ($_GET['cmdFilter']) {
    $lname  = $_GET['lname'];
    $regID  = $_GET['regID'];
    $rstatus= $_GET['rstatus'];
} else {
    $lname  = $_SESSION[$_GET['module'].'HS_lname'];
    $regID  = $_SESSION[$_GET['module'].'HS_regID'];
    $rstatus= $_SESSION[$_GET['module'].'HS_rstatus'];
}

if ($rstatus=='') {
    // get default status
    $rstatus = 1;
}

// set session variables
$_SESSION[$_GET['module'].'HS_lname']   = $lname;
$_SESSION[$_GET['module'].'HS_regID']   = $regID;
$_SESSION[$_GET['module'].'HS_rstatus'] = $rstatus;


if (trim($regID)!="") {
    if (count($conds[0])) {
        $conds[0][' AND regID'] = "= '$regID' ";
    } else {
        $conds[0]['regID'] = "= '$regID' ";
    }
}
    
if (trim($lname)!="") {
    if (count($conds[0])) {
        $conds[0][' AND lname'] = " like '$lname%' ";
    } else {
        $conds[0]['lname'] = " like '$lname%' ";
    }
}

if (count($conds[0])) {
    $conds[0][' AND rstatus'] = "= $rstatus ";
} else {
    $conds[0]['rstatus'] = "= $rstatus ";
}

$allRegistrants = $reg->retrieveAllRegistrations($conds);
$list           = $reg->retrieveAllRegistrations($conds,"lname","ASC",$offset, $limit);

if ($allRegistrants)
	$total_rec=count($allRegistrants);
else 
	$total_rec=0;
	
$main_url="index.php?module=Registrations&action=listRegistrationsHS&lname=$lname&regID=$regID&rstatus=$rstatus";


// check if the list is empty
if (!count($list)) {
    $list = "";
}

$sugar_smarty->assign('list', $list );
$sugar_smarty->assign('lname', $lname );
$sugar_smarty->assign('regID', $regID );
$sugar_smarty->assign('rstatus', $rstatus );
$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );

echo $sugar_smarty->fetch('modules/Registrations/templates/listRegistrationsHS.tpl');
?>


<script>
$('regID').focus();
</script>