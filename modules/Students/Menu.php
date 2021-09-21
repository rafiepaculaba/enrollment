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

$access = new AccessChecker();

$module_menu = Array();

// college
if ($col_enabled) {
    $accessCode = $access->getAccessCode("List Col Student");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Students&action=listStudents", "College Students ","student-college");
    }
    
    $accessCode = $access->getAccessCode("Create Col Student");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Students&action=createStudent", "New College Student ","studentNew-college");
    }
}

// hs
if ($hs_enabled) {
    $accessCode = $access->getAccessCode("List HS Student");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Students&action=listStudentsHS", "High School Students ","student-highSchool");
    }
    
    $accessCode = $access->getAccessCode("Create HS Student");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Students&action=createStudentHS", "New High School Student ","studentNew-highSchool");
    }
}


// elementary
if ($elem_enabled) {
    $accessCode = $access->getAccessCode("List Elem Student");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Students&action=listStudentsElem", "Elementary Students ","student-elementary");
    }
    
    $accessCode = $access->getAccessCode("Create Elem Student");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Students&action=createStudentElem", "New Elementary Student ","studentNew-elementary");
    }
}

//preschool
if ($pre_enabled) {
    $accessCode = $access->getAccessCode("List Preschool Student");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Students&action=listStudentsPreschool", "Preschool Students ","student-preSchool");
    }
    
    $accessCode = $access->getAccessCode("Create Preschool Student");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Students&action=createStudentPreschool", "New Preschool Student ","studentNew-preSchool");
    }
}

?>
