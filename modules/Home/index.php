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

//global $current_user, $sugar_version, $sugar_config, $image_path;
//
//require_once('include/Sugar_Smarty.php');
//
//echo "\n<p>\n";
//echo get_module_title("OnlineDocumentation", $mod_strings['LBL_MODULE_NAME']."", false);
//echo "\n</p>\n";
//
//$sugar_smarty = new Sugar_Smarty();

//echo $_SESSION['oUser'];
//echo $sugar_smarty->fetch('modules/Students/templates/viewStudent.tpl');
require_once('modules/Users/User2.php');

global $mod_strings;
global $current_user;

$access = new AccessChecker();
$accessCode1 = $access->getAccessCode("Col Dashboard");
$accessCode2 = $access->getAccessCode("HS Dashboard");
$accessCode3 = $access->getAccessCode("Elem Dashboard");
$accessCode4 = $access->getAccessCode("Preschool Dashboard");

if ($access->check_access($current_user->id,$accessCode1)) {
    include('modules/Home/dashboardCol.php');
} else if ($access->check_access($current_user->id,$accessCode2)) {
    include('modules/Home/dashboardHS.php');
} else if ($access->check_access($current_user->id,$accessCode3)) {
    include('modules/Home/dashboardElem.php');
} else if ($access->check_access($current_user->id,$accessCode4)) {
    include('modules/Home/dashboardPreschool.php');
} else {
    // display if no dashboard
?>
    <table border="0" align="center">
    <tr>
    <td align="center">
    <img src="themes/Sugar/images/quickenroll_logo.gif" alt="NeTFUSION QuickEnroll System" />
    </td>
    </tr>
    <tr>
    <td class="footer" align="center">
    Best viewed in resolution 1024x768 or up
    </td>
    </tr>
    </table>

<?php
}

?>

