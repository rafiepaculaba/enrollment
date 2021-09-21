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

echo "\n<p>\n";
echo get_module_title('enrolmentStatus-college', $mod_strings['LBL_MODULE_TITLE_ES_COL'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Generate Col Enrollment Status");
if ($access->check_access($current_user->id,$accessCode)) {
	//Get Configuration
	$config = new Config();
	
	if ($_GET['cmdGo']) {
		
		$schYear = $default_schYear = $_POST['schYear'];
		$semCode = $default_semCode = $_POST['semCode'];
		$rstatus = $_POST['rstatus'];
		$cmdGo 	 = $_GET['cmdGo'];
		
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
		    if (trim($rstatus) == '') {
		    	$where[0]['rstatus']    = " > '0'";
		    } else if (trim($rstatus) == 1) {
		    	$where[0]['rstatus']    = " = '$rstatus'";
		    } else if (trim($rstatus) == 2) {
		    	$where[0]['rstatus']    = " = '$rstatus'";
		    } else if (trim($rstatus) == 0) {
		    	$where[0]['rstatus']    = " = '$rstatus'";
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
			if(trim($records[0]['total_enrollees']) != '' || $records[0]['total_enrollees'] != NULL){
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
		
		$sugar_smarty->assign('grand', $grand );
		
		if(trim($cmdGo)!='') {
			$cmdGo = 1;
		} else {
			$cmdGo = 0;
		}
		
		$sugar_smarty->assign('cmdGo', $cmdGo );
		
		$sugar_smarty->assign('list', $report );

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
    echo $sugar_smarty->fetch('modules/Reports/templates/generateEnrollmentStatusCol.tpl');	
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
function generateEnrollmentStatus()
{
    if ( trim($('schYear').value) != "" && trim($('semCode').value) != "" ) {
    	get_data="schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&action=generateenrollmentstatus";
    	ajaxQuery("modules/Reports/generateStatusHandler.php",'GET',get_data,"","onGenerateDataHandle");
        
    } else {
		if (check_form('frmGenerateEnrollmentStatusCol')) {
		    $('frmGenerateEnrollmentStatusCol').submit();
		}
    }
}

function onGenerateDataHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//display div
	    	$('enrollments').innerHTML = ret;
	    	
	    	// setting printer for print
	    	setPrinter();
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function getschYear() {
	alert($('schYear').value);
	return $('schYear').value;
}


function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=500,left = 0,top = 0');");
}

// set focus
$('schYear').focus();

</script>
