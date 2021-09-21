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
require_once('modules/Config/ConfigCol.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');
require_once('modules/Schedules/Schedule.php');
require_once('modules/Schedules/BlockSectionSubjectCol.php');
require_once('modules/Schedules/BlockSectionCol.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_BLOCK_COL'], false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
global $current_user;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Col Block Section");
if ($access->check_access($current_user->id,$accessCode)) {
    $blocksection = new BlockSection();
    
    $limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
    $offset = $_GET['offset']? $_GET['offset']:0;
    
    if ($_GET['cmdFilter']) {
        $secID     = $_GET['secID'];
        $secName   = $_GET['secName'];
        $schYear   = $_GET['schYear'];
        $semCode   = $_GET['semCode'];
        $courseID  = $_GET['courseID'];
        $yrLevel   = $_GET['yrLevel'];
    } else {
        $secID     = $_SESSION[$_GET['module'].'Col_secID'];
        $secName   = $_SESSION[$_GET['module'].'Col_secName'];
        $schYear   = $_SESSION[$_GET['module'].'Col_schYear'];
        $semCode   = $_SESSION[$_GET['module'].'Col_semCode'];
        $courseID  = $_SESSION[$_GET['module'].'Col_courseID'];
        $yrLevel   = $_SESSION[$_GET['module'].'Col_yrLevel'];
    }
    
    
    // get all default setting from configs
    $config = new Config();
    if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'Col_schYear'])) {
        // get the default school year
        $schYear = $config->getConfig('School Year');
    }
    
    if (!isset($_GET['semCode']) && !isset($_SESSION[$_GET['module'].'Col_semCode'])) {
        // get the default semester
        $semCode = $config->getConfig('Semester');
    }
    
    $_SESSION[$_GET['module'].'Col_secID']    = $secID;
    $_SESSION[$_GET['module'].'Col_secName']  = $secName;
    $_SESSION[$_GET['module'].'Col_schYear']  = $schYear;
    $_SESSION[$_GET['module'].'Col_semCode']  = $semCode;
    $_SESSION[$_GET['module'].'Col_courseID'] = $courseID;
    $_SESSION[$_GET['module'].'Col_yrLevel']  = $yrLevel;
    
    if (trim($secID)!="") {
        if (count($conds[0])) {
            $conds[0][' AND secID'] = "= '$secID' ";
        } else {
            $conds[0]['secID'] = "= '$secID' ";
        }
    }
        
    if (trim($secName)!="") {
        if (count($conds[0])) {
            $conds[0][' AND secName'] = " like '$secName%' ";
        } else {
            $conds[0]['secName'] = " like '$secName%' ";
        }
    }
    
    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['schYear'] = " = '$schYear' ";
        }
    }
    
    if ($semCode) {
        if (count($conds[0])) {
            $conds[0][' AND semCode'] = " = '$semCode' ";
        } else {
            $conds[0]['semCode'] = " = '$semCode' ";
        }
    }
    
    if ($courseID) {
        if (count($conds[0])) {
            $conds[0][' AND courseID'] = "= '$courseID' ";
        } else {
            $conds[0]['courseID'] = "= '$courseID' ";
        }
    }
    
    if ($yrLevel) {
        if (count($conds[0])) {
            $conds[0][' AND yrLevel'] = "= '$yrLevel' ";
        } else {
            $conds[0]['yrLevel'] = "= '$yrLevel' ";
        }
    }
    
    if (count($conds[0])) {
        $conds[0][' AND rstatus'] = "= 1 ";
    } else {
        $conds[0]['rstatus'] = "= 1 ";
    }
    
    
//    $allBlockSections = $blocksection->retrieveAllBlockSections($conds);
    $allBlockSections = $blocksection->countAllBlockSections($conds);
    $list             = $blocksection->retrieveAllBlockSections($conds,"secName","ASC",$offset, $limit);
    $total_rec = $allBlockSections;
//    if ($allBlockSections)
//    	$total_rec=count($allBlockSections);
//    else 
//    	$total_rec=0;
    	
    $main_url="index.php?module=Schedules&action=listBlockSectionsCol&secID=$secID&secName=$secName&schYear=$schYear&semCode=$semCode&courseID=$courseID&yrLevel=$yrLevel";
    
    // course list
    $course = new Course();
    $sugar_smarty->assign('courseList', $course->retrieveAllCourses() );
    
    
    $semesters='<select name="semCode" id="semCode" onchange="getSchedules();">'."\n";
    $semesters.='<option value="">------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$semCode) {
                $semesters .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $semesters.='</select>';
    $sugar_smarty->assign('SEMESTERS', $semesters);
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
    $schYearDisplay='<select name="schYear" id="schYear" onchange="getSchedules();">'."\n";
	$schYearDisplay.='<option value="">--------------------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	        if ($value == $schYear) {
	           $schYearDisplay .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $schYearDisplay .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$schYearDisplay.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schYearDisplay);
       
	// check if the list is empty
    if (!count($list)) {
        $list = "";
    }
    
    $sugar_smarty->assign('list', $list );
    $sugar_smarty->assign('secID', $secID );
    $sugar_smarty->assign('secName', $secName );
    $sugar_smarty->assign('schYear', $schYear );
    $sugar_smarty->assign('courseID', $courseID );
    $sugar_smarty->assign('yrLevel', $yrLevel );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
    
    echo $sugar_smarty->fetch('modules/Schedules/templates/listBlockSectionsCol.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script type='text/javascript'>
$('schYear').focus();
</script>