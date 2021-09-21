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
require_once('modules/Students/StudentCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');
require_once('modules/Schedules/Schedule.php');
require_once('modules/Schedules/BlockSectionCol.php');
require_once('modules/Schedules/BlockSectionSubjectCol.php');
require_once('modules/Enrollments/EnrollmentDetailCol.php');
require_once('modules/Enrollments/EnrollmentCol.php');
require_once('modules/Reports/ReportCol.php');

echo "\n<p>\n";
echo get_module_title('collectionReports-college', $mod_strings['LBL_MODULE_TITLE_ES_COL'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Summary of Income Col");
if ($access->check_access($current_user->id,$accessCode)) {
	//Get Configuration
	$config = new Config();
	$reportClass = new ReportClass();
	
	if ($_GET['cmdGo']) {
		
		$schYear = $default_schYear = $_POST['schYear'];
		$semCode = $default_semCode = $_POST['semCode'];
		$cmdGo 	 = $_GET['cmdGo'];
		
		$course = new Course();
		$course_list = $course->retrieveAllCourses($conds,'');
		
		$report = array();
		$grand = array();
		$index=0;
		
		$columns = array();
		$columns[] = "Registration";
		$columns[] = "Tuition";
		$columns[] = "Miscellaneous";
		$columns[] = "Laboratory";
		
		$grand['Registration'] 	= 0;
		$grand['Tuition'] 		= 0;
		$grand['Miscellaneous'] = 0;
		$grand['Laboratory'] 	= 0;
		$grand['Total'] 		= 0;
		foreach ($course_list as $key=>$value) {
			
			$report[$index] = array();
			$report[$index]['course'] = $value['courseCode'];
			$report[$index]['total']  = 0;
			
			foreach ($columns as $field) {
				$data = $reportClass->getIncome($schYear,$semCode,$field,$value['courseID']);
				$report[$index][$field] = $data[0]['ttl'];
				$report[$index]['total']  += $data[0]['ttl'];
				
				$grand[$field] += $data[0]['ttl'];
				$grand['Total'] += $data[0]['ttl'];
			}
			
		    $index++;
		}
		
		$sugar_smarty->assign('grand', $grand );
		if(trim($cmdGo)!='') {
			$cmdGo = 1;
		} else {
			$cmdGo = 0;
		}
		
		$sugar_smarty->assign('cmdGo', $cmdGo );
		$sugar_smarty->assign('list', $report );
		$sugar_smarty->assign('columns', $columns );

	} else {
	    
	    // get the default school year
	    $default_schYear = $config->getConfig('School Year');
	    // get the default semester
	    $default_semCode = $config->getConfig('Semester');

	}

    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" >'."\n";
	$schoolYear.='<option value="">-----------------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	        if ($value==$default_schYear) {
	           $schoolYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           	$schoolYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$schoolYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);
	
    $semesters='<select name="semCode" id="semCode" >'."\n";
    $semesters.='<option value="">-----------------------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$default_semCode) {
                $semesters .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $semesters.='</select>';
    $sugar_smarty->assign('SEMESTERS', $semesters);
	
	$sugar_smarty->assign('schYear', $default_schYear );
	$sugar_smarty->assign('semCode', $default_semCode );
	$sugar_smarty->assign('rstatus', $rstatus );

	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Reports/templates/summaryIncomeCol.tpl');	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script>
addToValidate('frmGenerateEnrollmentStatusCol','schYear', '', true, 'School Year');
addToValidate('frmGenerateEnrollmentStatusCol','semCode', '', true, 'Semester Code');
</script>

<script language="javascript">
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=500,left = 0,top = 0');");
}

// set focus
$('schYear').focus();

</script>
