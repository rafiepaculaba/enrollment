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
$col_enabled	= $config->getConfig('College Enabled');
$hs_enabled 	= $config->getConfig('HS Enabled');
$elem_enabled 	= $config->getConfig('Elem Enabled');
$pre_enabled 	= $config->getConfig('PreSchool Enabled');

$access = new AccessChecker();
$module_menu = Array();

// college
if ($col_enabled) {
    $accessCode = $access->getAccessCode("List Col Enrollment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Enrollments&action=listEnrollmentsCol", "College Enrollees ","enrolees-college");
    }
    
    $accessCode = $access->getAccessCode("Create Col Enrollment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Enrollments&action=createEnrollmentCol", "New College Enrollee ","enroleeNew-college");
    }
    
    
    $accessCode = $access->getAccessCode("List Old Enrollment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Enrollments&action=listOldEnrollmentsCol", "College Old Enrollees ","enroleeOld-college");
    }
    
    $accessCode = $access->getAccessCode("Create Old Enrollment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Enrollments&action=createOldEnrollmentCol", "Add College Old Enrollee ","enroleeOldAdd-college");
    }
}


// hs
if ($hs_enabled) {
    $accessCode = $access->getAccessCode("List HS Enrollment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Enrollments&action=listEnrollmentsHS", "High School Enrollees ","enrolees-highSchool");
    }
    
    $accessCode = $access->getAccessCode("Create HS Enrollment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Enrollments&action=createEnrollmentHS", "New High School Enrollee ","enroleeNew-highSchool");
    }
}



//elementary
if ($elem_enabled) {
    $accessCode = $access->getAccessCode("List Elem Enrollment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Enrollments&action=listEnrollmentsElem", "Elementary Enrollees ","enrolees-elementary");
    }
    
    $accessCode = $access->getAccessCode("Create Elem Enrollment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Enrollments&action=createEnrollmentElem", "New Elementary Enrollee ","enroleeNew-elementary");
    }
}

//preschool
if ($pre_enabled) {
    $accessCode = $access->getAccessCode("List Preschool Enrollment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Enrollments&action=listEnrollmentsPreschool", "Preschool Enrollees ","enrolees-preSchool");
    }
    
    $accessCode = $access->getAccessCode("Create Preschool Enrollment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Enrollments&action=createEnrollmentPreschool", "New Preschool Enrollee ","enroleeNew-preSchool");
    }
}


?>
