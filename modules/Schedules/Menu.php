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
$col_enabled    = $config->getConfig('College Enabled');
$hs_enabled     = $config->getConfig('HS Enabled');
$elem_enabled   = $config->getConfig('Elem Enabled');
$pre_enabled    = $config->getConfig('PreSchool Enabled');

$access = new AccessChecker();

$module_menu = Array();

// college
if ($col_enabled) {
    $accessCode = $access->getAccessCode("List Col Schedule");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=listSchedules", "College Schedules ","schedules-college");
    }
    $accessCode = $access->getAccessCode("Create Col Schedule");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=createSchedule", "New College Schedule ","schedulesNew-college");
    }
    
    $accessCode = $access->getAccessCode("List Col Block Section");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=listBlockSectionsCol", "College Block Sections ","blockSections_college");
    }
    
    $accessCode = $access->getAccessCode("Create Col Block Section");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=createBlockSectionCol", "New College Block Section ","blockSectionsNew-college");
    }
}


// high school
if ($hs_enabled) {
    $accessCode = $access->getAccessCode("List HS Schedule");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=listSchedulesHS", "High School Schedules ","schedules-highSchool");
    }
    $accessCode = $access->getAccessCode("Create HS Schedule");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=createScheduleHS", "New High School Schedule ","schedulesNew-highSchool");
    }
    
    $accessCode = $access->getAccessCode("List HS Block Section");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=listBlockSectionsHS", "High School Block Sections ","blockSections-highSchool");
    }
    
    $accessCode = $access->getAccessCode("Create HS Block Section");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=createBlockSectionHS", "New High School Block Section ","blockSectionsNew-highSchool");
    }
}

// elementary
if ($elem_enabled) {
    $accessCode = $access->getAccessCode("List Elem Schedule");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=listSchedulesElem", "Elementary Schedules ","schedules-elementary");
    }
    $accessCode = $access->getAccessCode("Create Elem Schedule");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=createScheduleElem", "New Elementary Schedule ","schedulesNew-elementary");
    }
    
    $accessCode = $access->getAccessCode("List Elem Block Section");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=listBlockSectionsElem", "Elementary Block Sections ","blockSections-elementary");
    }
    
    $accessCode = $access->getAccessCode("Create Elem Block Section");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=createBlockSectionElem", "New Elementary Block Section ","blockSectionsNew-elementary");
    }
}

// preschool
if ($pre_enabled) {
    $accessCode = $access->getAccessCode("List Preschool Schedule");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=listSchedulesPreschool", "Preschool Schedules ","schedules-preschool");
    }
    $accessCode = $access->getAccessCode("Create Preschool Schedule");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=createSchedulePreschool", "New Preschool Schedule ","schedulesNew-preschool");
    }
    
    $accessCode = $access->getAccessCode("List Preschool Block Section");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=listBlockSectionsPreschool", "Preschool Block Sections ","blockSections-preschool");
    }
    
    $accessCode = $access->getAccessCode("Create Preschool Block Section");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Schedules&action=createBlockSectionPreschool", "New Preschool Block Section ","blockSectionsNew-preschool");
    }
}

?>
