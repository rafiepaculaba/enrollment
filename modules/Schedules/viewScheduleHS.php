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
require_once('modules/Subjects/SubjectHS.php');
require_once('modules/Schedules/ScheduleHS.php');
require_once('modules/Users/User2.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("View HS Schedule");
if ($access->check_access($current_user->id,$accessCode)) {

	$schedID = $_GET['schedID'];
	
	$sched = new Schedule($schedID);
	
	$sugar_smarty->assign('schedID', $sched->schedID );
	$sugar_smarty->assign('schYear', $sched->schYear );
	$sugar_smarty->assign('yrLevel', $sched->yrLevel );
	$sugar_smarty->assign('schedCode', $sched->schedCode );
	$sugar_smarty->assign('subjID', $sched->subjID );
	$sugar_smarty->assign('profID', $sched->profID );
	$sugar_smarty->assign('startTime', $sched->startdTime );
	$sugar_smarty->assign('endTime', $sched->enddTime );
	$sugar_smarty->assign('onMon', $sched->onMon );
	$sugar_smarty->assign('onTue', $sched->onTue );
	$sugar_smarty->assign('onWed', $sched->onWed );
	$sugar_smarty->assign('onThu', $sched->onThu );
	$sugar_smarty->assign('onFri', $sched->onFri );
	$sugar_smarty->assign('onSat', $sched->onSat );
	$sugar_smarty->assign('onSun', $sched->onSun );
	$sugar_smarty->assign('room', $sched->room );
	$sugar_smarty->assign('maxCapacity', $sched->maxCapacity );
	$sugar_smarty->assign('noEnrolled', $sched->noEnrolled );
	$sugar_smarty->assign('remarks', $sched->remarks );
	$sugar_smarty->assign('preparedBy', $sched->preparedBy );
	$sugar_smarty->assign('rstatus', $sched->rstatus );
	
	$sugar_smarty->assign('subjCode', $sched->subjCode );
	$sugar_smarty->assign('profName', $sched->profName);	

	// to check if the user has an access in edit
    $accessCode = $access->getAccessCode("Edit HS Schedule");
    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
    
    // to check if the user has an access in delete
    $accessCode = $access->getAccessCode("Delete HS Schedule");
    $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );
	
	echo $sugar_smarty->fetch('modules/Schedules/templates/viewScheduleHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script language="javascript">
function deleteSchedule(schedID)
{
    reply=confirm("Do you really want to delete this Schedule?");
    
    if (reply==true)
        redirect('index.php?module=Schedules&action=deleteScheduleHS&schedID='+schedID);
}
</script>