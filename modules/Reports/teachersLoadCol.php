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
echo get_module_title('teacherLoad-college', $mod_strings['LBL_MODULE_TITLE_TL_COL'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Teachers Load Col");
if ($access->check_access($current_user->id,$accessCode)) {
	//Get Configuration
	$config = new Config();
	
	if ($_POST['cmdGo']) {

		$schYear = $default_schYear = $_POST['schYear'];
		$semCode = $default_semCode = $_POST['semCode'];
		$profID  = $_POST['profID'];
		
		$reportClass = new ReportClass();
		
		$sched = new Schedule();
		
		if ($schYear) {
		    if (count($conds[0])) {
	            $conds[0][' AND schedules.schYear'] = " = '$schYear' ";
	        } else {
	            $conds[0]['schedules.schYear'] = " = '$schYear' ";
	        }
	    }
	
	  	if ($semCode) {
	        if (count($conds[0])) {
	            $conds[0][' AND schedules.semCode'] = " = '$semCode' ";
	        } else {
	            $conds[0]['schedules.semCode'] = " = '$semCode' ";
	        }
	    }
	    
        if ($profID) {
	        if (count($conds[0])) {
	            $conds[0][' AND schedules.profID'] = " = '$profID' ";
	        } else {
	            $conds[0]['schedules.profID'] = " = '$profID' ";
	        }
	    }

	    $record = $sched->retrieveAllSchedulesAssociated($conds);
	    
		//$query = "Select * FROM schedules WHERE schYear = '$schYear' AND semCode = '$semCode' AND profID = '$profID'";
		//$record = $reportClass->adhocQuery($query);
	    
		$sugar_smarty->assign('RESULT', $reportClass->teachersLoadCol($record));
		
	} else {
		
		// get the default school year
    	$default_schYear = $config->getConfig('School Year');
    	
		// get the default semester
	    $default_semCode = $config->getConfig('Semester');
	}
	
	//User list
	$user = new User2($current_user->id);
	
	if ($user->groupID==6) {
		// the current user is a college instructor
		$where[0]['id'] = "='".$user->id."' "; // assuming 6-default groupID of College Professor
	    $sugar_smarty->assign('isInstructorGroup', 1);
	    $profID=$user->id;
	} else {
		// the current user is admin
		//$where[0]['groupID']="=6";
		$where[0]['groupID']=">='5' AND groupID <= '6'";
		$sugar_smarty->assign('isInstructorGroup', 0);
	}
	
	$user_list = $user->retrieveAllUsers($where);
	$sugar_smarty->assign('user_list', $user_list);
	$sugar_smarty->assign('profID', $profID);

    //school year
	$year = date("Y",time());
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear" >'."\n";
	$schYear.='<option value="">-----------------------------</option>'."\n";
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
	
    //Semester
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
	
    $sugar_smarty->assign('schYear', $default_schYear);
    $sugar_smarty->assign('semCode', $default_semCode);
    $sugar_smarty->assign('profID', $profID);

	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Reports/templates/teachersLoadCol.tpl');	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script>
addToValidate('frmTeachersLoadCol','schYear', '', true, 'School Year');
addToValidate('frmTeachersLoadCol','semCode', '', true, 'Semester Code');
addToValidate('frmTeachersLoadCol','profID', '', true, 'Instructor ');
</script>

<script language="javascript">
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=500,left = 0,top = 0');");
}

// set focus
$('profID').focus();

</script>
