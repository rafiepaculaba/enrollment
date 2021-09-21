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
require_once('modules/Subjects/SubjectPreschool.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/SchedulePreschool.php');
echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$yrLevel 	= $_POST['yrLevel'];
$fromschYear= $_POST['fromschYear'];
$toschYear 	= $_POST['toschYear'];

$sched = new Schedule();

if ($yrLevel) {
        $conds[0]['yrLevel'] = " = '$yrLevel' AND ";
}
if ($fromschYear) {
        $conds[0]['schYear'] = " = '$fromschYear'";
}

$list = $sched->retrieveAllSchedules($conds);

if (!count($list)) {
	    $msg = "No record found!";
	    $sugar_smarty->assign('class', 'errorbox');
} else {
	$ctr = 0;
	while ($ctr <= count($list)) {
	
		$sched->schYear		=	$toschYear;
		$sched->yrLevel		=	$list[$ctr]['yrLevel'];
		$sched->schedCode	=	$list[$ctr]['schedCode'];
		$sched->subjID		=	$list[$ctr]['subjID'];
		$sched->profID		=	$list[$ctr]['profID'];
		$sched->startTime	=	$list[$ctr]['startTime'];
		$sched->endTime		=	$list[$ctr]['endTime'];
		$sched->onMon		=	$list[$ctr]['onMon'];
		$sched->onTue		=	$list[$ctr]['onTue'];
		$sched->onWed		=	$list[$ctr]['onWed'];
		$sched->onThu		=	$list[$ctr]['onThu'];
		$sched->onFri		=	$list[$ctr]['onFri'];
		$sched->onSat		=	$list[$ctr]['onSat'];
		$sched->onSun		=	$list[$ctr]['onSun'];
		$sched->room		=	$list[$ctr]['room'];
		$sched->maxCapacity	=	$list[$ctr]['maxCapacity'];
		$sched->noReserved	=	$list[$ctr]['noReserved'];
		$sched->noEnrolled	=	"";
		$sched->labFee		=	$list[$ctr]['labFee'];
		$sched->remarks		=	$list[$ctr]['remarks'];
		$sched->preparedBy	=	$list[$ctr]['preparedBy'];
	    if(($sched->isExist($toschYear, $list[$ctr]['schedCode'])) == -1){
		// new schedule record
		$sched->createSchedule();
	    }
		$ctr++;

}

    $msg = "Record successfully copied!";
	$sugar_smarty->assign('class', 'notificationbox');

}
$sugar_smarty->assign('display', 'block');
$sugar_smarty->assign('msg', $msg );
echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');

?>

<script language="JavaScript">
//setTimeout("redirect('index.php?module=Schedules&action=viewSchedule&schedID=<?php echo $getLastID; ?>')",3000);
</script>