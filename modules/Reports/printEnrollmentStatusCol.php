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

echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$sugar_smarty = new Sugar_Smarty();

$schYear = $_GET['schYear'];
$semCode = $_GET['semCode'];
$rstatus = $_POST['rstatus'];

$config = new Config();
$course = new Course();

$course_list = $course->retrieveAllCourses($conds,'');

$enroll = new Enrollment();
$report = array();
$index=0;

$grand = array();

foreach ($course_list as $key=>$value) {
	$report[$index]=array();	
	
	$report[$index]['deptCode']=$value['deptCode'];
    $courseID = $report[$index]['courseID']=$value['courseID'];
    $report[$index]['courseCode']=$value['courseCode'];
    $ctr=1;
    while ($ctr<=5) {
    // SELECT count( idno ) AS total_enrollees FROM enrollments WHERE schYear = '2008-2009' AND semCode = '1' AND yrLevel = '1' AND rstatus >1
    $tables[] = 'enrollments';

    $fields[' count( idno ) AS total_enrollees ']	= "";
    
    $where[0]['schYear'] 	= "='$schYear' AND ";
    $where[0]['semCode']    = "='$semCode' AND ";
    $where[0]['courseID']   = "='$courseID' AND ";
    $where[0]['yrLevel']    = "='$ctr' AND ";
    if (trim($rstatus) =='') {
    	$where[0]['rstatus']    = " > '0'";
    	$sugar_smarty->assign('rstatus', " Pending and Validate ");
    } else if (trim($rstatus) == 1) {
    	$where[0]['rstatus']    = " = '$rstatus'";
    	$sugar_smarty->assign('rstatus', " Pending ");
    } else if (trim($rstatus) == 2) {
    	$where[0]['rstatus']    = " = '$rstatus'";
    	$sugar_smarty->assign('rstatus', " Validated ");
    } else if (trim($rstatus) == 0) {
    	$where[0]['rstatus']    = " = '$rstatus'";
    	$sugar_smarty->assign('rstatus', " Withdrawn ");    	    	
    }
    
    $enroll->tables = $tables;
    $enroll->fields = $fields;
    $enroll->conds  = $where;
    $enroll->order  = $orderby;
    $enroll->multi_orders = $multi_orders;
            
    // building an select query
    $query = $enroll->Select();  // generate delete sql query
    $enroll->reset();            // reset all variables in query generator
    
	try {
	    $enroll->db->beginTransaction();
    	$result   = $enroll->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$enroll->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error.";
	}
	if(trim($records[0]['total_enrollees']) != '' || $records[0]['total_enrollees'] != NULL) {
    	$report[$index][$ctr]=$records[0]['total_enrollees'];
	} else {
		$report[$index][$ctr]= 0;
		$records[0]['total_enrollees'] = 0;
	}
	
    $report[$index]['total'] += $records[0]['total_enrollees'];
    //$report[$value['courseCode']]['total'] += $report[$value['courseCode']][$records[0]['total_enrollees']];
    
    $grand[$ctr] += $report[$index][$ctr];
    $grand['total'] += $report[$index][$ctr];

    unset($tables);
    
    $ctr++;
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
$sugar_smarty->assign('schName', $config->getConfig('School Name') );
$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
$sugar_smarty->assign('schContact', $config->getConfig('Contact') );

echo $sugar_smarty->fetch('modules/Reports/templates/printEnrollmentStatusCol.tpl');
?>

<script language="javascript">
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}
</script>
