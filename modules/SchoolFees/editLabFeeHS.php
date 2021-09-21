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
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleHS.php');
require_once('modules/Config/ConfigHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit HS Lab Fee");
if ($access->check_access($current_user->id,$accessCode)) {

	$schedID = $_GET['schedID'];
	
	// get all default setting from configs
	$config = new Config();

	$sched = new Schedule();
	
	$sched->schedID = $schedID;
	$sched->retrieveSchedule(1); // locked
	
	$sugar_smarty->assign('schedID', $sched->schedID );
	
	$sugar_smarty->assign('schYear', $sched->schYear );
	$sugar_smarty->assign('yrLevel', $sched->yrLevel );
	$sugar_smarty->assign('curID', $sched->curID );
	$sugar_smarty->assign('schedCode', $sched->schedCode );
	$sugar_smarty->assign('courseID', $sched->courseID );
	$sugar_smarty->assign('subjID', $sched->subjID );
	$sugar_smarty->assign('profID', $sched->profID  );
	
	//hh-mm am/pm start time
	$stime = explode(":",$sched->startTime);
	$sugar_smarty->assign('shh', $stime[0] ) ;
	$sugar_smarty->assign('smm', $stime[1] ) ;
	$sugar_smarty->assign('samp', $stime[2] );

	//hh-mm am/pm end time
	$etime = explode(":",$sched->endTime);
	
	$sugar_smarty->assign('ehh', $etime[0] );
	$sugar_smarty->assign('emm', $etime[1] );
	$sugar_smarty->assign('eamp', $etime[2] );
	
	
	$sugar_smarty->assign('onMon', $sched->onMon );
	$sugar_smarty->assign('onTue', $sched->onTue );
	$sugar_smarty->assign('onWed', $sched->onWed );
	$sugar_smarty->assign('onThu', $sched->onThu );
	$sugar_smarty->assign('onFri', $sched->onFri  );
	$sugar_smarty->assign('onSat', $sched->onSat );
	$sugar_smarty->assign('onSun', $sched->onSun );
	$sugar_smarty->assign('room', $sched->room  );
	$sugar_smarty->assign('maxCapacity', $sched->maxCapacity );
	$sugar_smarty->assign('noReserved', $sched->noReserved );
	$sugar_smarty->assign('noEnrolled', $sched->noEnrolled );
	$sugar_smarty->assign('remarks ', $sched->remarks  );
	$sugar_smarty->assign('noReserved', $sched->noReserved );
	$sugar_smarty->assign('noEnrolled', $sched->noEnrolled );
	$sugar_smarty->assign('remarks', $sched->remarks  );
	$sugar_smarty->assign('preparedBy', $sched->preparedBy );
	$sugar_smarty->assign('rstatus', $sched->rstatus  );

	if($sched->onMon == 1) {
		$days = $days."M";
	}
	if($sched->onTue == 1) {
		$days = $days."Tue";
	}
	if($sched->onWed == 1) {
		$days = $days."W";
	}
	if($sched->onThu == 1) {
		$days = $days."Thu";
	}
	if($sched->onFri == 1) {
		$days = $days."F";
	}
	if($sched->onSat == 1) {
		$days = $days."Sat";
	}
	if($sched->onSun == 1) {
		$days = $days."Sun";
	}

	$stime = explode(":",$sched->startTime);

	if($stime[0] < 12){
		$amplitude = " AM";
	} else {
		if($stime[0] == 12){
			
		} else {
			$stime[0] -= 12;
		}
		$amplitude = " PM";
	}
	
	$ttime 			= $stime[0].":".$stime[1].$amplitude;

	$etime = explode(":",$sched->endTime);

	if($etime[0] < 12){
		$amplitude = " AM";
	} else {
		if($etime[0] == 12){
			
		} else {
			$etime[0] -= 12;
		}
		$amplitude = " PM";
	}
	
	$time 			= $ttime." - ".$etime[0].":".$etime[1].$amplitude;
	
	$sugar_smarty->assign('subjCode', $sched->subjCode  );
	$sugar_smarty->assign('profName', $sched->profName  );
	$sugar_smarty->assign('days', $days  );
	$sugar_smarty->assign('time', $time  );
	$sugar_smarty->assign('amount', $sched->labFee);
		
	//school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear" disabled>'."\n";
	$schYear.='<option value="">-----------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	    	if ($value == $sched->schYear) {
	        	$schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schYear.='</select>';

	$schYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);

	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/SchoolFees/templates/editLabFeeHS.tpl');

} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmLabFee','amount', '', true, 'Amount');
</script>

<script language="javascript">
function saveLabFee()
{
	if (check_form('frmLabFeeHS')) {
		
		$('schYear').disabled = false;
		$('schedID').disabled = false;
			
		$('frmLabFeeHS').submit();
	}
	
	
}
$('amount').focus();
</script>