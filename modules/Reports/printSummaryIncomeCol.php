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

echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$sugar_smarty = new Sugar_Smarty();

$schYear = $_GET['schYear'];
$semCode = $_GET['semCode'];

$config = new Config();
$course = new Course();
$reportClass = new ReportClass();

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
		$grand['Total'] += $grand[$field];
	}
	
    $index++;
}

$sugar_smarty->assign('SCHYEAR', $schYear);

if ($semCode==1) {
   $sugar_smarty->assign('SEMCODE', "1<sup>st</sup> Semester");
} else if ($semCode==2) {
   $sugar_smarty->assign('SEMCODE', "2<sup>nd</sup> Semester");
} else if ($semCode==2) {
   $sugar_smarty->assign('SEMCODE', "3<sup>rd</sup> Semester");
} else {
   $sugar_smarty->assign('SEMCODE', "Summer"); 
}

if ($config->getConfig('Logo')) {
	$sugar_smarty->assign('logo', '1' );
} else {
    $sugar_smarty->assign('logo', '0' );
}

$sugar_smarty->assign('grand', $grand );
$sugar_smarty->assign('list', $report );
$sugar_smarty->assign('columns', $columns );

$sugar_smarty->assign('schName', $config->getConfig('School Name') );
$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
$sugar_smarty->assign('schContact', $config->getConfig('Contact') );

echo $sugar_smarty->fetch('modules/Reports/templates/printSummaryIncomeCol.tpl');
?>

<script language="javascript">
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}
</script>
