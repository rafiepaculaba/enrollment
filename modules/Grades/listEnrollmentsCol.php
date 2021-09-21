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

require_once('config.php');
require_once('include/Sugar_Smarty.php');
require_once('modules/Config/ConfigCol.php');  
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');
require_once('modules/Enrollments/EnrollmentCol.php');
require_once('modules/Enrollments/EnrollmentDetailCol.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL'], false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Col Final Grade");
if ($access->check_access($current_user->id,$accessCode)) {
    $config = new Config();
    $enrollment = new Enrollment();
    
    $limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
    $offset = $_GET['offset']? $_GET['offset']:0;
    
    if ($_GET['cmdFilter']) {
    
        $idno       = $_GET['idno'];
        $lname      = $_GET['lname'];
        $fname      = $_GET['fname'];
        $mname      = $_GET['mname'];
        $gender     = $_GET['gender'];
        $courseID   = $_GET['courseID'];
        $yrLevel    = $_GET['yrLevel'];
    
        $schYear    = $_GET['schYear'];
        $semCode    = $_GET['semCode'];
        
    } else {
        
        $idno     = $_SESSION[$_GET['module'].'ColFG_idno'];
        $lname    = $_SESSION[$_GET['module'].'ColFG_lname'];
        $fname    = $_SESSION[$_GET['module'].'ColFG_fname'];
        $mname    = $_SESSION[$_GET['module'].'ColFG_mname'];
        $gender   = $_SESSION[$_GET['module'].'ColFG_gender'];
        $courseID = $_SESSION[$_GET['module'].'ColFG_courseID'];
        $yrLevel  = $_SESSION[$_GET['module'].'ColFG_yrLevel'];
    
        $schYear  = $_SESSION[$_GET['module'].'ColFG_schYear'];
        $semCode  = $_SESSION[$_GET['module'].'ColFG_semCode'];
    }
        
    if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'Col_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }
    
    if (!isset($_GET['semCode']) && !isset($_SESSION[$_GET['module'].'Col_semCode'])) {
        // get the default semester
        $semCode = $config->getConfig('Semester');
    }
    
    
    // set session variables
    $_SESSION[$_GET['module'].'ColFG_idno']      = $idno;
    $_SESSION[$_GET['module'].'ColFG_lname']     = $lname;
    $_SESSION[$_GET['module'].'ColFG_fname']     = $fname;
    $_SESSION[$_GET['module'].'ColFG_mname']     = $mname;
    $_SESSION[$_GET['module'].'ColFG_gender']    = $gender;
    $_SESSION[$_GET['module'].'ColFG_courseID']  = $courseID;
    $_SESSION[$_GET['module'].'ColFG_yrLevel']   = $yrLevel;
    $_SESSION[$_GET['module'].'ColFG_schYear']   = $schYear;
    $_SESSION[$_GET['module'].'ColFG_semCode']   = $semCode;

    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND enrollments.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['enrollments.schYear'] = " = '$schYear' ";
        }
    }
    
    if ($idno) {
        if (count($conds[0])) {
            $conds[0][' AND enrollments.idno'] = "= '$idno' ";
        } else {
            $conds[0]['enrollments.idno'] = "= '$idno' ";
        }
    }
        
    if ($lname) {
        if (count($conds[0])) {
            $conds[0][' AND students.lname'] = " like '$lname%' ";
        } else {
            $conds[0]['students.lname'] = " like '$lname%' ";
        }
    }
    
    if ($fname) {
        if (count($conds[0])) {
            $conds[0][' AND students.fname'] = " like '$fname%' ";
        } else {
            $conds[0]['students.fname'] = " like '$fname%' ";
        }
    }
    
    if ($mname) {
        if (count($conds[0])) {
            $conds[0][' AND students.mname'] = " like '$mname%' ";
        } else {
            $conds[0]['students.mname'] = " like '$mname%' ";
        }
    }

    if ($gender) {
        if (count($conds[0])) {
            $conds[0][' AND students.gender'] = " like '$gender%' ";
        } else {
            $conds[0]['students.gender'] = " like '$gender%' ";
        }
    }
    
    if ($courseID) {
       if (count($conds[0])) {
           $conds[0][' AND enrollments.courseID'] = " = '$courseID' ";
       } else {
           $conds[0]['enrollments.courseID'] = " = '$courseID' ";
       }
       
    }
    
    if ($yrLevel) {
        if (count($conds[0])) {
            $conds[0]['AND enrollments.yrLevel'] = " = '$yrLevel' ";
        } else {
            $conds[0]['enrollments.yrLevel'] = " = '$yrLevel' ";
        }
        
    }
    
    if ($semCode) {
       if (count($conds[0])) {
           $conds[0][' AND enrollments.semCode'] = " = '$semCode' ";
       } else {
           $conds[0]['enrollments.semCode'] = " = '$semCode' ";
       }
    }
    
    if (count($conds[0])) {
        $conds[0][' AND enrollments.rstatus']    = " > 1 ";
    } else {
        $conds[0]['enrollments.rstatus']    = " > 1 ";
    }

	$allEnrollments = $enrollment->countAllEnrollments($conds);
    $list           = $enrollment->retrieveAllEnrollments($conds,"enrollments.schYear","DESC",$offset, $limit);

	$total_rec=$allEnrollments;
    	
    $main_url="index.php?module=Grades&action=listEnrollmentsCol&idno=$idno&lname=$lname&fname=$fname&mname=$mname&gender=$gender&courseID=$courseId&yrLevel=$yrLevel&schYear=$schYear&semCode=$semCode";
    
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

	//semester
	$semesters='<select name="semCode" id="semCode" >'."\n";
	$semesters.='<option value="">-------</option>'."\n";
	if ($esConfig['semesters']) {
	    foreach ($esConfig['semesters'] as $key=>$value) {
	    	if ($key == $semCode) {
	        	$semesters .= '<option value="'.$key.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$semesters.='</select>';
	
	$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);
	$sugar_smarty->assign('SEMESTERS', $semesters);
    
    // course list
    $course = new Course();
    $sugar_smarty->assign('courseList', $course->retrieveAllCourses() );
    
    // check if the list is empty
    if (!count($list)) {
        $list = "";
    }
    
    $sugar_smarty->assign('list', $list );
    $sugar_smarty->assign('idno', $idno );
    $sugar_smarty->assign('lname', $lname );
    $sugar_smarty->assign('fname', $fname );
    $sugar_smarty->assign('mname', $mname );
    $sugar_smarty->assign('gender', $gender );
    $sugar_smarty->assign('courseID', $courseID );
    $sugar_smarty->assign('yrLevel', $yrLevel );
    $sugar_smarty->assign('schYear', $schYear );
    $sugar_smarty->assign('semCode', $semCode );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit,$export_link,$print_link) );
    
    echo $sugar_smarty->fetch('modules/Grades/templates/listEnrollmentsCol.tpl');
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
$('idno').focus();
</script>