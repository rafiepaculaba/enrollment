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
/*********************************************************************************

 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..

 ********************************************************************************/



global $mod_strings;
global $current_user;

require_once('modules/Config/GeneralConfig.php');
// get the config
$config = new GeneralConfig();
$col_enabled = $config->getConfig('College Enabled');
$hs_enabled = $config->getConfig('HS Enabled');
$elem_enabled = $config->getConfig('Elem Enabled');
$pre_enabled = $config->getConfig('PreSchool Enabled');

$module_menu = Array();
$access = new AccessChecker();

//$accessCode = $access->getAccessCode("Create Col Registration");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Registrations&action=createRegistration", "New College Registration","RegistrationCreate");
//}
//
//$accessCode = $access->getAccessCode("Create HS Registration");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Registrations&action=createRegistrationHS", "New High School Registration","RegistrationCreate");
//}
//
//$accessCode = $access->getAccessCode("Create Elem Registration");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Registrations&action=createRegistrationElem", "New Elementary Registration","RegistrationCreate");
//}
//
//$accessCode = $access->getAccessCode("Create Col Student");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Students&action=createStudent", "New College Student ","studentNew-college");
//}
//
//$accessCode = $access->getAccessCode("Create HS Student");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Students&action=createStudentHS", "New High School Student ","studentNew-highSchool");
//}
//
//$accessCode = $access->getAccessCode("Create Elem Student");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Students&action=createStudentElem", "New Elementary Student ","studentNew-elementary");
//}


if ($col_enabled) {
    $accessCode = $access->getAccessCode("Col Dashboard");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Home&action=dashboardCol", "College Dashboard ","dashboard-college");
    }
}

if ($hs_enabled) {
    $accessCode = $access->getAccessCode("HS Dashboard");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Home&action=dashboardHS", "High School Dashboard ","dashboard-highSchool");
    }
}

if ($elem_enabled) {
    $accessCode = $access->getAccessCode("Elem Dashboard");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Home&action=dashboardElem", "Elementary Dashboard ","dashboard-elementary");
    }
}

if ($pre_enabled) {
    $accessCode = $access->getAccessCode("Preschool Dashboard");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Home&action=dashboardPreschool", "Preschool Dashboard ","dashboard-preSchool");
    }
}

?>
