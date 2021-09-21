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
require_once('modules/Config/ConfigElem.php');
require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Students/StudentElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleElem.php');
require_once('modules/Schedules/BlockSectionElem.php');
require_once('modules/Schedules/BlockSectionSubjectElem.php');
require_once('modules/Enrollments/EnrollmentDetailElem.php');
require_once('modules/Enrollments/EnrollmentElem.php');

require_once('modules/Grades/GradesheetElem.php');


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Elem Grade");
if ($access->check_access($current_user->id,$accessCode)) {
    $config = new Config();
    
    $gs     = new GradeSheet();
    
    $limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
    $offset = $_GET['offset']? $_GET['offset']:0;
    
    if ($_GET['cmdFilter']) {
        $gsID      = trim($_GET['gsID']);
        $schedCode = trim($_GET['schedCode']);
        $subjCode  = trim($_GET['subjCode']);
        $profID    = trim($_GET['profID']);
    
        $schYear   = trim($_GET['schYear']);
        $rstatus   = trim($_GET['rstatus']);
    } else {
        $gsID      = $_SESSION[$_GET['module'].'Elem_gsID'];
        $schedCode = $_SESSION[$_GET['module'].'Elem_schedCode'];
        $subjCode  = $_SESSION[$_GET['module'].'Elem_subjCode'];
        $profID    = $_SESSION[$_GET['module'].'Elem_profID'];
    
        $schYear   = $_SESSION[$_GET['module'].'Elem_schYear'];
        $rstatus   = $_SESSION[$_GET['module'].'Elem_rstatus'];
    }

    if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'HS_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }
    
    //Professor list
	$user = new User2($current_user->id);
	unset($where);
	if ($user->groupID==8) {
	    $where[0]['id']="='".$user->id."'"; 
	    $sugar_smarty->assign('isInstructor', 1);
	    $profID = $user->id;
	} else {
	    $where[0]['groupID']="=8";  // assuming the groupID 7 is high school teacher
	    $sugar_smarty->assign('isInstructor', 0);
	}

	$prof_list = $user->retrieveAllUsers($where,'');
	$sugar_smarty->assign('profList', $prof_list);
	
    // set session variables
    $_SESSION[$_GET['module'].'Elem_gsID']        = $gsID;
    $_SESSION[$_GET['module'].'Elem_schedCode']   = $schedCode;
    $_SESSION[$_GET['module'].'Elem_subjCode']    = $subjCode;
    $_SESSION[$_GET['module'].'Elem_profID']      = $profID;
    $_SESSION[$_GET['module'].'Elem_schYear']     = $schYear;
    $_SESSION[$_GET['module'].'Elem_rstatus']     = $rstatus;
    
    
    if ($gsID!="") {
        if (count($conds[0])) {
            $conds[0][' AND grade_sheets.gsID'] = " = '$gsID' ";
        } else {
            $conds[0]['grade_sheets.gsID'] = " = '$gsID' ";
        }
    }
    
    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND grade_sheets.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['grade_sheets.schYear'] = " = '$schYear' ";
        }
    }
    
    if ($schedCode!="") {
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
    
    if ($profID) {
        if (count($conds[0])) {
            $conds[0][' AND grade_sheets.profID'] = " = '$profID' ";
        } else {
            $conds[0]['grade_sheets.profID'] = " = '$profID' ";
        }
    }
    
    if ($rstatus) {
        if (count($conds[0])) {
            $conds[0][' AND grade_sheets.rstatus'] = " = '$rstatus' ";
        } else {
            $conds[0]['grade_sheets.rstatus'] = " = '$rstatus' ";
        }
    }
    
    $allGS = $gs->retrieveAllGradeSheetsAssociated($conds);
    $list  = $gs->retrieveAllGradeSheetsAssociated($conds,"subjects.subjCode","ASC",$offset, $limit);

    if ($allGS)
    	$total_rec=count($allGS);
    else 
    	$total_rec=0;
    	
    $main_url="index.php?module=Grades&action=listGradesheetsElem&gsID=$gsID&schedCode=$schedCode&subjCode=$subjCode&profID=$profID&schYear=$schYear&rstatus=$rstatus";
    
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" >'."\n";
	$schoolYear.='<option value="">---------------</option>'."\n";
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

	// check if the list is empty
    if (!count($list)) {
        $list = "";
    }
    
    $sugar_smarty->assign('list', $list );
    $sugar_smarty->assign('gsID', $gsID );
    $sugar_smarty->assign('schedCode', $schedCode );
    $sugar_smarty->assign('subjCode', $subjCode );
    $sugar_smarty->assign('profID', $profID );
    $sugar_smarty->assign('schYear', $schYear );
    $sugar_smarty->assign('rstatus', $rstatus );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit,$export_link,$print_link) );
    
    echo $sugar_smarty->fetch('modules/Grades/templates/listGradesheetsElem.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script type='text/javascript'>
// set focus
$('gsID').focus();
</script>