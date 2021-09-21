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
require_once('modules/Payments/Payment.php');
require_once('modules/Account/AccountDetailCol.php');
require_once('modules/Account/Account.php');
require_once('modules/Account/Assessment.php');
require_once('modules/SchoolFees/SchoolFeeCol.php');
require_once('modules/Payments/ORSeries.php');
require_once('modules/Payments/ORHeader.php');
require_once('modules/Payments/ORDetails.php');
require_once('modules/Config/RecordLog.php');
require_once('modules/Reports/ReportCol.php');

global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

        
        // declare all instances
        $orheader       = new ORHeader();
        $ordetails      = new ORDetails();
        $config         = new Config();
        $reportClass    = new ReportClass();
        
        // get the default 
        $schYear        = $_GET['schYear'];
        $semCode        = $default_semCode = $_GET['semCode'];
        $term           = $_GET['term'];
        $tuition        = $config->getConfig('Tuition Account Code');
        $registration   = $config->getConfig('Reg Account Code');
        $miscellaneous  = $config->getConfig('Misc Account Code');
        $laboratory     = $config->getConfig('Lab Account Code');
        
        /**
         * get the collections
         */
        // get all courses
        $course = new Course();
        $courses = $course->retrieveAllCourses();
        
        $result = array();
        $index=0;
        foreach ($courses as $course) {
            $result[$index]=array();
            //$report[$index]['dept']=$course['deptCode'];
            $result[$index]['course']=$course['courseCode'];
            
            $ctr=1;
            while ($ctr<=5) {
                $query      = "Select sum(ordetails.amount) as total_amount From orheader, ordetails, students Where orheader.orno=ordetails.orno and orheader.idno=students.idno and orheader.schYear='$schYear' and orheader.semCode='$semCode' and orheader.term=$term and students.courseID='".$course['courseID']."' and students.yrLevel=$ctr and orheader.rstatus=1";
                $records    = $reportClass->adhocQuery($query);
                
                if ($records[0]['total_amount']) {
        	       $result[$index][$ctr] = $records[0]['total_amount'];	
                } else {
        	       $result[$index][$ctr] = 0;	
                }
            	    
                $result[$index]['total'] += $result[$index][$ctr];
                $result['gtotal'][$ctr]  += $result[$index][$ctr];
                $result['gtotal']['total']  += $result[$index][$ctr];
                
                $ctr++;
            }
            
            $index++;
        }
        
        $sugar_smarty->assign('RESULT', $reportClass->printCollectionReportCollege($result));
      
    if ($term=="Registration") {
        $term = $term;
    } else {
        // get the default semcode
    	if ($default_semCode<4) {
            $total_terms = $config->getConfig('Semestral Terms');
    	} else {
    	    $total_terms = $config->getConfig('Summer Terms');
    	}
        switch ($total_terms) {
        case 1:
            $term = $term_by_1[$term];
            break;
        case 2:
            $term = $term_by_2[$term];
            break;
        case 3:
            $term = $term_by_3[$term];
            break;
        case 4:
            $term = $term_by_4[$term];
            break;
        default:
            $term = $term;
        }
    }
    
	$sugar_smarty->assign('SCHYEAR', $schYear);
	if ($semCode==1) {
	   $sugar_smarty->assign('SEMCODE', "1<sup>st</sup>");
	} else if ($semCode==2) {
	   $sugar_smarty->assign('SEMCODE', "2<sup>nd</sup>");
	} else if ($semCode==2) {
	   $sugar_smarty->assign('SEMCODE', "3<sup>rd</sup>");
	} else {
	   $sugar_smarty->assign('SEMCODE', "Summer"); 
	}
	
	$sugar_smarty->assign('TERM', $term);
	
	if ($config->getConfig('Logo')) {
        $sugar_smarty->assign('logo', '1' );
    } else {
        $sugar_smarty->assign('logo', '0' );
    }
	
	$sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
	
    echo $sugar_smarty->fetch('modules/Reports/templates/printCollectionReportCol.tpl');	
?>

<script type='text/javascript'>
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}
</script>
