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
require_once('modules/Config/ConfigElem.php');


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Elem Configuration");
if ($access->check_access($current_user->id,$accessCode)) {
    $config = new Config();
    
    $limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
    $offset = $_GET['offset']? $_GET['offset']:0;
    
    if ($_GET['cmdFilter']) {
        $configID   = trim($_GET['configID']);
        $title      = trim($_GET['title']);
        $definition = trim($_GET['definition']);
    } else {
        $configID   = $_SESSION[$_GET['module'].'Elem_configID'];
        $title      = $_SESSION[$_GET['module'].'Elem_title'];
        $definition = $_SESSION[$_GET['module'].'Elem_definition'];
    }
    
    $_SESSION[$_GET['module'].'Elem_configID']   = $configID;
    $_SESSION[$_GET['module'].'Elem_title']      = $title;
    $_SESSION[$_GET['module'].'Elem_definition'] = $definition;
    
    if ($configID!="") {
        $conds[0]['configID'] = " = '$configID' AND ";
    }
    
    if ($title!="") {
        $conds[0]['title'] = " like '$title%' AND ";
    }
    
    if ($definition!="") {
        $conds[0]['definition'] = " like '$definition%' AND ";
    }
    
    $conds[0]['rstatus'] = "= 1 ";
    
    $allConfigs  = $config->retrieveAllConfigs($conds);
    $list        = $config->retrieveAllConfigs($conds,"title","ASC",$offset, $limit);
    	
    if ($allConfigs)
    	$total_rec=count($allConfigs);
    else 
    	$total_rec=0;
    	
    $main_url="index.php?module=Config&action=listConfigsElem&configID=$configID&title=$title&definition=$definition";
    
    $sugar_smarty->assign('list', $list );
    $sugar_smarty->assign('configID', $configID );
    $sugar_smarty->assign('title', $title );
    $sugar_smarty->assign('definition', $definition );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
    
    echo $sugar_smarty->fetch('modules/Config/templates/listConfigsElem.tpl');
} else {
    $msg = "Sorry, you dont have permission to access this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>
