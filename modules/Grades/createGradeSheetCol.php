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
require_once('modules/Grades/Gradesheet.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_CUR'], $mod_strings['LBL_MODULE_TITLE_CUR'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Col Grade");
if ($access->check_access($current_user->id,$accessCode)) {
    // get all default setting from configs
    $config = new Config();
    
    // get the default school year
    $default_schYear = $config->getConfig('School Year');
    $sugar_smarty->assign('date', $default_date);
    
    // get the default semester
    $default_semCode = $config->getConfig('Semester');
    
    $semesters='<select name="semCode" id="semCode" onchange="getSchedules();">'."\n";
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
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear" onchange="getSchedules();">'."\n";
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
	
    //Professor list
	$user = new User2($current_user->id);
	unset($conds);
	if ($user->groupID==6) {
	    $conds[0]['id']="='".$user->id."'"; 
	    $sugar_smarty->assign('isInstructor', 1);
	} else {
	    $conds[0]['groupID']="=6";  // assuming the groupID 6 is college insctructor
	    $sugar_smarty->assign('isInstructor', 0);
	}

	$profList = $user->retrieveAllUsers($conds);
	$sugar_smarty->assign('PROFLIST', $profList);
    
    
    // get all schedules
    $sched = new Schedule();
    if ($default_schYear) {
        $where[0]['schYear'] = "='".$default_schYear."' ";
        
        if ($default_semCode) {
            $where[0][' AND semCode'] = "='".$default_semCode."'";
        } 
    } else {
        if ($default_semCode) {
            $where[0]['semCode'] = "='".$default_semCode."'";
        } 
    }
    $schedList = $sched->retrieveAllSchedules($where);
    $sugar_smarty->assign('SCHEDLIST', $schedList);
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Grades/templates/createGradeSheetCol.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script>
addToValidate('frmGradesheet','schYear', '', true, 'School Year');
addToValidate('frmGradesheet','semCode', '', true, 'Semester Code');
addToValidate('frmGradesheet','profID', '', true, 'Instructor');
addToValidate('frmGradesheet','schedID', '', true, 'Sched Code');
</script>

<script language="javascript">

function goSubmitForm(theForm) 
{
    if (check_form(theForm)) {
        $(theForm).submit();
    }
}


function checkDuplicate()
{
    if ( trim($('profID').value) != "" && trim($('schedID').value) != "" && trim($('schYear').value) != "" && trim($('semCode').value) != "" ) {
        get_data="profID=" + $('profID').value + "&schedID=" + $('schedID').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&action=checkduplicate";
        ajaxQuery("modules/Grades/gradeHandler.php",'GET',get_data,"","checkDuplicateHandle");
              
    } else {
        
        // hide the loading sign
        hiddenLoading('divloading');
    }
}

function checkDuplicateHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (parseInt(ret)==1) {
    	    
            // hide the loading sign
            hiddenLoading('divloading');
    	    
	    	msg="Warning: Grade sheet is already exist!";
    		displayError(msg);
    		
    		// clear fields
            $('subject').value = "";
        	$('units').value   = "";
        	$('room').value    = "";
        	$('time').value    = "";
        	$('days').value    = "";
        	$('remarks').value = "";
        	
        	$('students').innerHTML = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>	<tr height="20">	    <td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>	    <td scope="col" class="listViewThS1" width="5%" nowrap>Prelim</td>		<td scope="col" class="listViewThS1" width="5%" nowrap>Midterm</td>		<td scope="col" class="listViewThS1" width="5%" nowrap>Pre-Final</td>		<td scope="col" class="listViewThS1" width="5%" nowrap>Final</td>		<td scope="col" class="listViewThS1" width="15%" nowrap>ID No.</td>		<td scope="col" class="listViewThS1" width="40%" nowrap>Student Name</td>		<td scope="col" class="listViewThS1" width="10%" nowrap>Course</td>		<td scope="col" class="listViewThS1" width="10%" nowrap>Year</td>	</tr></tbody></table>';
        	
        	$('schedID').value = "";
        	$('schedID').focus();
    	
    	} else {
    	    getStudents();
    	}
    }
}


function getSchedules()
{
    // clear fields
    $('subject').value = "";
	$('units').value = "";
	$('room').value = "";
	$('time').value = "";
	$('days').value = "";
	
	$('students').innerHTML = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>	<tr height="20">	    <td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>	    <td scope="col" class="listViewThS1" width="5%" nowrap>Prelim</td>	    <td scope="col" class="listViewThS1" width="5%" nowrap>Midterm</td>	    <td scope="col" class="listViewThS1" width="5%" nowrap>Pre-Final</td>	    <td scope="col" class="listViewThS1" width="5%" nowrap>Final</td>		<td scope="col" class="listViewThS1" width="15%" nowrap>ID No.</td>		<td scope="col" class="listViewThS1" width="40%" nowrap>Student Name</td>		<td scope="col" class="listViewThS1" width="10%" nowrap>Course</td>		<td scope="col" class="listViewThS1" width="10%" nowrap>Year</td>	</tr></tbody></table>';
	
    get_data="schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&profID=" + $('profID').value + "&action=getschedulescol";
    ajaxQuery("modules/Grades/gradeHandler.php",'GET',get_data,"","onGetSchedulesHandle");
    
    // display the loading sign
    l = 200 + document.body.scrollLeft;
    t = 20 + document.body.scrollTop;
    displayLoading('divloading', l, t);
}

function onGetSchedulesHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
        
        // hide the loading sign
        hiddenLoading('divloading');
    	
    	if (ret) {
	    	initializeCombo('schedID',"-----------------------------");
			myData = ret.parseJSON();
			for(c = 0; c < myData.length; c++){
		    	var y=document.createElement('option');
				y.text=myData[c].schedCode;				
				y.setAttribute('value',myData[c].schedID);		
				var x=$('schedID');

				if (navigator.appName=="Microsoft Internet Explorer") {
					x.add(y); // IE only  
				} else {
					x.add(y,null);
				}
			}	
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function getSubject()
{
   if (trim($('schedID').value)!="") {
        get_data="schedID=" + $('schedID').value + "&action=getsubject";
        ajaxQuery("modules/Grades/gradeHandler.php",'GET',get_data,"","onGetSubjectHandle");
        
        // display the loading sign
        l = 200 + document.body.scrollLeft;
        t = 20 + document.body.scrollTop;
        displayLoading('divloading', l, t);
        
   } else {
        $('subject').value = "";
    	$('units').value = "";
    	$('room').value = "";
    	$('time').value = "";
    	$('days').value = "";
    	
    	
    	$('students').innerHTML = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>	<tr height="20">	    <td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>	    <td scope="col" class="listViewThS1" width="5%" nowrap>Prelim</td>		<td scope="col" class="listViewThS1" width="5%" nowrap>Midterm</td>	    <td scope="col" class="listViewThS1" width="5%" nowrap>Pre-Final</td>		<td scope="col" class="listViewThS1" width="5%" nowrap>Final</td>		<td scope="col" class="listViewThS1" width="15%" nowrap>ID No.</td>		<td scope="col" class="listViewThS1" width="40%" nowrap>Student Name</td>		<td scope="col" class="listViewThS1" width="10%" nowrap>Course</td>		<td scope="col" class="listViewThS1" width="10%" nowrap>Year</td>	</tr></tbody></table>';
    }
}


function onGetSubjectHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	if (ret) {
    	    if (ret!='0') {
        	    myData = ret.parseJSON();
    	    	$('subject').value = myData[0].subjCode;
    	    	$('units').value = myData[0].units;
    	    	$('room').value = myData[0].room;
    	    	$('time').value = myData[0].time;
    	    	$('days').value = myData[0].days;
    	    }
    	    
    	    checkDuplicate();
    	    
    	} else {
    	    
            // hide the loading sign
            hiddenLoading('divloading');
    	    
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function getStudents()
{
    if ( trim($('schedID').value) != "" ) {
        get_data="schedID=" + $('schedID').value + "&action=getclassroster";
        ajaxQuery("modules/Grades/gradeHandler.php",'GET',get_data,"","onGetStudentsHandle");
    } else {
        
        // hide the loading sign
        hiddenLoading('divloading');
    }
}

function onGetStudentsHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
        // hide the loading sign
        hiddenLoading('divloading');
    	if (ret) {
	    	$('students').innerHTML = ret;
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

// set focus
$('profID').focus();

getSchedules();

</script>
