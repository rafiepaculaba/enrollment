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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Department"); //reminder!! change the access code
if ($access->check_access($current_user->id,$accessCode)) {

	$deptID = $_GET['deptID'];
	
	$dept = new Department();
	
	$dept->deptID = $deptID;
	$dept->retrieveDepartment(1); // locked
	
	$sugar_smarty->assign('deptID', $dept->deptID );
	$sugar_smarty->assign('deptCode', $dept->deptCode );
	$sugar_smarty->assign('deptName', $dept->deptName );
	$sugar_smarty->assign('deptChairman', $dept->deptChairman );
	$sugar_smarty->assign('remarks', $dept->remarks );
	$sugar_smarty->assign('rstatus', $dept->rstatus );
	
	echo $sugar_smarty->fetch('modules/Departments/templates/editDepartment.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmDepartment','deptCode', '', true, 'Department Code');
addToValidate('frmDepartment','deptName', '', true, 'Department Name');
addToValidate('frmDepartment','deptChairman', '', true, 'Department Chairman');
</script>

<script language="javascript">
$('deptName').focus();
</script>
