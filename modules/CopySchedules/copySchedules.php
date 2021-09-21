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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $esConfig;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Copy Col Schedule");
if ($access->check_access($current_user->id,$accessCode)) {

	// get all default setting from configs
    $config = new Config();

	//course list
	$course = new Course();

	$course_list = $course->retrieveAllCourses();
	$sugar_smarty->assign('course_list', $course_list);

	// get the default school year
    $default_schYear = $config->getConfig('School Year');
	$year = date("Y",time());
	
	//from Year display
	$fromarrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$fromarrSchYear[] = $yr."-".($yr+1);
	}

	$fromschYear='<select name="fromschYear" id="fromschYear">'."\n";
	$fromschYear.='<option value="">--------------------</option>'."\n";
	if ($fromarrSchYear) {
	    foreach ($fromarrSchYear as $value) {
	        if ($value==$default_schYear-1) {
	           $fromschYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $fromschYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$fromschYear.='</select>';
	$sugar_smarty->assign('FROMSCHOOLYEAR', $fromschYear);

	//	To Year Display
	$toarrSchYear = array();
	for($yr=$year; $yr<=$year+1; $yr++) {
		$toarrSchYear[] = $yr."-".($yr+1);
	}
	
	$toschYear='<select name="toschYear" id="toschYear">'."\n";
	$toschYear.='<option value="">--------------------</option>'."\n";
	if ($toarrSchYear) {
	    foreach ($toarrSchYear as $value) {
	        if ($value==$default_schYear) {
	           $toschYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $toschYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$toschYear.='</select>';
	$sugar_smarty->assign('TOSCHOOLYEAR', $toschYear);

    $fromsemesters='<select name="fromsemCode" id="fromsemCode" >'."\n";
    $fromsemesters.='<option value="">--------------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$default_semCode) {
                $fromsemesters .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $fromsemesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $fromsemesters.='</select>';
    $sugar_smarty->assign('FROMSEMESTERS', $fromsemesters);
    
    $tosemesters='<select name="tosemCode" id="tosemCode" >'."\n";
    $tosemesters.='<option value="">--------------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$default_semCode) {
                $tosemesters .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $tosemesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $tosemesters.='</select>';
    $sugar_smarty->assign('TOSEMESTERS', $tosemesters);

    $yearLevel='<select name="yrLevel" id="yrLevel" >'."\n";
    $yearLevel.='<option value="">--------------------</option>'."\n";
    if ($college_yrs) {
        foreach ($college_yrs as $key=>$value) {
            if ($key==$yrLevel) {
                $yearLevel .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $yearLevel .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $yearLevel.='</select>';
    $sugar_smarty->assign('YEARLEVEL', $yearLevel);
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/CopySchedules/templates/copySchedules.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmCopyScheduleCol','fromschYear', '', true, 'From School Year');
addToValidate('frmCopyScheduleCol','toschYear', '', true, 'To School Year');
addToValidate('frmCopyScheduleCol','courseID', '', true, 'Course');
addToValidate('frmCopyScheduleCol','semCode', '', true, 'Semester');
addToValidate('frmCopyScheduleCol','yrLevel', '', true, 'Year Level');
</script>

<script language="javascript" >
//set Focus
$('courseID').focus();
</script>