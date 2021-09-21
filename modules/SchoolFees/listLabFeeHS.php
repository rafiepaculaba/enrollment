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
require_once('modules/Config/ConfigHS.php');
require_once('modules/Subjects/SubjectHS.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List HS Lab Fee");
if ($access->check_access($current_user->id,$accessCode)) {

	// get all default setting from configs
    $config = new Config();
	$sched = new Schedule();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;

	if ($_GET['cmdFilter']) {	
		$schYear 	= trim($_GET['schYear']);
		$schedCode 	= trim($_GET['schedCode']);
		$subjCode 	= trim($_GET['subjCode']);
	} else {
		$schYear     	= $_SESSION[$_GET['module'].'HS_schYear'];			
		$schedCode     	= $_SESSION[$_GET['module'].'HS_schedCode'];			
		$subjCode     	= $_SESSION[$_GET['module'].'HS_subjCode'];			
	}

    if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'HS_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }

	//set session variables
	$_SESSION[$_GET['module'].'HS_schYear']		= $schYear;
	$_SESSION[$_GET['module'].'HS_schedCode']	= $schedCode;
	$_SESSION[$_GET['module'].'HS_subjCode']	= $subjCode;
    
	if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND schedules.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['schedules.schYear'] = " = '$schYear' ";
        }
    }

    if ($schedCode!='') {
        if (count($conds[0])) {
            $conds[0][' AND schedules.schedCode'] = " = '$schedCode' ";
        } else {
            $conds[0]['schedules.schedCode'] = " = '$schedCode' ";
        }
    }

    if ($subjCode!="") {
        if (count($conds[0])) {
            $conds[0][' AND subjects.subjCode'] = " like '$subjCode%' ";
        } else {
            $conds[0]['subjects.subjCode'] = " like '$subjCode%' ";
        }
    }
    
    
    // laboratory type only
    if (count($conds[0])) {
        $conds[0][' AND subjects.type'] = " ='2'";
    } else {
        $conds[0]['subjects.type'] = " ='2' ";
    }

//    $allSchedules = $sched->retrieveAllSchedulesAssociated($conds);
    $allSchedules = $sched->countAllSchedulesAssociated($conds);
	$list        = $sched->retrieveAllSchedulesAssociated($conds,"","",$offset, $limit);

//	if ($allSchedules)
//		$total_rec=count($allSchedules);
//	else 
//		$total_rec=0;
	$total_rec=$allSchedules;

	$main_url="index.php?module=SchoolFees&action=listLabFeeHS&schedID=$schedID&schYear=$schYear&schedCode=$schedCode&subjCode=$subjCode";

    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" >'."\n";
	$schoolYear.='<option value="">---------------</optmathion>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	    	if ($value == $schYear) {
	        	$schoolYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schoolYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schoolYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);

    $subj = new Subject();
    $sugar_smarty->assign('subjlist', $subj->retrieveAllSubjects() );
	if (!count($list)) {
    	$list = "";
    }

    $sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('schedID', $schedID );
	$sugar_smarty->assign('schYear', $schYear );
	$sugar_smarty->assign('schedCode', $schedCode );
	$sugar_smarty->assign('subjCode', $subjCode );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/SchoolFees/templates/listLabFeeHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">
// setfocus
$('schedCode').focus();
</script>