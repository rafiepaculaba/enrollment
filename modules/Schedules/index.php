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
global $current_user;

require_once('modules/Config/GeneralConfig.php');
// get the config
$config = new GeneralConfig();
$col_enabled    = $config->getConfig('College Enabled');
$hs_enabled     = $config->getConfig('HS Enabled');
$elem_enabled   = $config->getConfig('Elem Enabled');
$pre_enabled    = $config->getConfig('PreSchool Enabled');

$access = new AccessChecker();

if ($col_enabled) {
    $ac1=$access->getAccessCode("List Col Schedule");
}
if ($hs_enabled) {
    $ac2=$access->getAccessCode("List HS Schedule");
}
if ($elem_enabled) {
    $ac3=$access->getAccessCode("List Elem Schedule");
}
if ($pre_enabled) {
    $ac4=$access->getAccessCode("List Preschool Schedule");
}

if ($access->check_access($current_user->id,$ac1)) {
include('modules/Schedules/listSchedules.php');
} else if ($access->check_access($current_user->id,$ac2)) {
include('modules/Schedules/listSchedulesHS.php');
} else if ($access->check_access($current_user->id,$ac3)) {
include('modules/Schedules/listSchedulesElem.php');
} else if ($access->check_access($current_user->id,$ac4)) {
include('modules/Schedules/listSchedulesPreschool.php');
}

?>
