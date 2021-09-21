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
echo get_module_title('listEnrollment_college', $mod_strings['LBL_MODULE_TITLE_EL_COL'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Enrollment List Col");
if ($access->check_access($current_user->id,$accessCode)) {
    
    // get all default setting from configs
    $config = new Config();
    $reportClass = new ReportClass();
    
    if ($_POST['theForm']) {
        // get the default school year
        $schYear = $default_schYear = $_POST['schYear'];
        // get the default semester
        $semCode = $default_semCode = $_POST['semCode'];
		
        $courseID = $_POST['courseID'];
        $yrLevel  = $_POST['yrLevel'];
        
        $enrollment = new Enrollment();
		
		$where[0]['enrollments.schYear'] = "='".$schYear."' AND"; 
		$where[0]['enrollments.semCode'] = "='".$semCode."' AND"; 
		$where[0]['enrollments.courseID'] = "='".$courseID."' AND"; 
		$where[0]['enrollments.yrLevel'] = "='".$yrLevel."' "; 
		
		$records = $enrollment->retrieveAllEnrollments($where,'');
		
		$schName		= $config->getConfig('School Name');
		$schAddress		= $config->getConfig('School Address');
		$schContact  	= $config->getConfig('Contact');
		$schRegion  	= $config->getConfig('School Region');
		
		//get Course Name
		$course1 = new Course($courseID);
    	$course1->retrieveAllCourses();
		$courseName = $course1->courseName;

		$sugar_smarty->assign('RESULT', $reportClass->enrollmentListCollege($records, $courseName, $semCode, $yrLevel, $schName, $schAddress, $schContact, $schRegion));
        
        $sugar_smarty->assign('courseID', $courseID);
        $sugar_smarty->assign('yrLevel', $yrLevel);

    } else {
        // get the default school year
        $default_schYear = $config->getConfig('School Year');
        
        // get the default semester
        $default_semCode = $config->getConfig('Semester');
        
        $sugar_smarty->assign('RESULT', "");
    }

    $semesters='<select name="semCode" id="semCode">'."\n";
    $semesters.='<option value="">--------------------------</option>'."\n";
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
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	$schYear='<select name="schYear" id="schYear">'."\n";
	$schYear.='<option value="">--------------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	        if ($value==$default_schYear) {
	           $schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$schYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);
	
	$sugar_smarty->assign('schYear', $default_schYear);
	$sugar_smarty->assign('semCode', $default_semCode);
    
	//Year Level
	$yearLevel='<select name="yrLevel" id="yrLevel" >'."\n";
    $yearLevel.='<option value="">--------------------------</option>'."\n";
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
    
    // course list
    $course = new Course();
    $sugar_smarty->assign('courseList', $course->retrieveAllCourses() );
	
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Reports/templates/enrollmentListCol.tpl');	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script>
addToValidate('frmEnrollmentListCol','schYear', '', true, 'School Year');
addToValidate('frmEnrollmentListCol','semCode', '', true, 'Semester');
addToValidate('frmEnrollmentListCol','courseID', '', true, 'Course');
addToValidate('frmEnrollmentListCol','yrLevel', '', true, 'Year Level');
</script>

<script language="javascript">
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1100,height=500,left = 0,top = 0');");
}

// set focus
$('schYear').focus();

</script>
