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

$access = new AccessChecker();

$module_menu = Array();

$accessCode = $access->getAccessCode("Copy Col Schedules");
if ($access->check_access($current_user->id,$accessCode)) {
    $module_menu[] = Array("index.php?module=CopySchedules&action=copySchedules", "Copy College Schedules ","admin_schedulesCopy_college");
}
$accessCode = $access->getAccessCode("Copy HS Schedules");
if ($access->check_access($current_user->id,$accessCode)) {
    $module_menu[] = Array("index.php?module=CopySchedules&action=copySchedulesHS", "Copy High School Schedules ","admin_schedulesCopy_highSchool");
}
$accessCode = $access->getAccessCode("Copy Elem Schedules");
if ($access->check_access($current_user->id,$accessCode)) {
    $module_menu[] = Array("index.php?module=CopySchedules&action=copySchedulesElem", "Copy Elementary Schedules ","admin_schedulesCopy_elementary");
}

$accessCode = $access->getAccessCode("Copy Preschool Schedules");
if ($access->check_access($current_user->id,$accessCode)) {
    $module_menu[] = Array("index.php?module=CopySchedules&action=copySchedulesPreschool", "Copy Preschool Schedules ","admin_schedulesCopy_preSchool");
}


?>
