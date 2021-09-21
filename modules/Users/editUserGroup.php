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

require_once('common.php');
require_once('include/Sugar_Smarty.php');
require ('modules/Users/UserGroup.php');

global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$groupID = $_GET['groupID'];

$access = new AccessChecker();

$accessCode = $access->getAccessCode("Edit User Group");

if ($access->check_access($current_user->id, $accessCode)) {
    $ug    = new UserGroup($groupID);
    
    $sugar_smarty->assign('groupID', $groupID );
    $sugar_smarty->assign('gname', $ug->name );
    $sugar_smarty->assign('gdesc', $ug->desc );
    $sugar_smarty->assign('gstatus', $ug->status );
    
    echo "\n<p>\n";
    echo get_module_title($mod_strings['LBL_MODULE_NAME'], "User Group: ".$ug->name, false);
    echo "\n</p>\n";
    
    echo $sugar_smarty->fetch('modules/Users/templates/editUserGroup.tpl');
} else {
    $msg = "Sorry, you dont have permission to access this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>
