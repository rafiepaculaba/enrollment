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
    $accessCode = $access->getAccessCode("List Col Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=listGradesheetsCol", "College Grade Sheets ","gradeSheets-college");
    }
    
    $accessCode = $access->getAccessCode("Create Col Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=createGradeSheetCol", "New College Grade Sheets ","gradeSheetsNew-college");
    }
    
    $accessCode = $access->getAccessCode("View Col Final Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=listEnrollmentsCol", "College Grades ","gradeSheetsFinal-college");
    }
}


// hs
if ($hs_enabled) {
    $accessCode = $access->getAccessCode("List HS Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=listGradesheetsHS", "High School Grade Sheets ","gradeSheets-highSchool");
    }
    
    $accessCode = $access->getAccessCode("Create HS Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=createGradeSheetHS", "New High School Grade Sheets ","gradeSheetsNew-highSchool");
    }
    
    $accessCode = $access->getAccessCode("View HS Final Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=listEnrollmentsHS", "High School Final Grades ","gradeSheetsFinal-highSschool");
    }
}

//elementary
if ($elem_enabled) {
    $accessCode = $access->getAccessCode("List Elem Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=listGradesheetsElem", "Elementary Grade Sheets ","gradeSheets-elementary");
    }
    
    $accessCode = $access->getAccessCode("Create Elem Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=createGradeSheetElem", "New Elementary Grade Sheets ","gradeSheetsNew-elementary");
    }
    
    $accessCode = $access->getAccessCode("View Elem Final Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=listEnrollmentsElem", "Elementary Final Grades ","gradeSheetsFinal-elementary");
    }
}

//preschool
if ($pre_enabled) {
    $accessCode = $access->getAccessCode("List Preschool Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=listGradesheetsPreschool", "Preschool Grade Sheets ","gradeSheets-preschool");
    }
    
    $accessCode = $access->getAccessCode("Create Preschool Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=createGradeSheetPreschool", "New Preschool Grade Sheets ","gradeSheetsNew-preschool");
    }
    
    $accessCode = $access->getAccessCode("View Preschool Final Grade");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Grades&action=listEnrollmentsPreschool", "Preschool Final Grades ","gradeSheetsFinal-preschool");
    }
}

?>
