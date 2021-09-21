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

require_once('config.php');
require_once('modules/Config/ConfigCol.php');  
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');

require_once('modules/Enrollments/OldEnrollmentCol.php');
require_once('modules/Enrollments/OldEnrollmentDetailCol.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL_OLD'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Old Enrollment");
if ($access->check_access($current_user->id,$accessCode)) {
    $oenID = $_GET['oenID'];
    
   	// get all default setting from configs
    $config = new Config();

    $enrollment = new OldEnrollment($oenID);

    $sugar_smarty->assign('oenID', $oenID );
    $sugar_smarty->assign('idno', $enrollment->idno );
    $sugar_smarty->assign('lname', $enrollment->lname );
    $sugar_smarty->assign('fname', $enrollment->fname );
    $sugar_smarty->assign('mname', $enrollment->mname );
    $sugar_smarty->assign('schYear', $enrollment->schYear );
    $sugar_smarty->assign('semCode', $enrollment->semCode );
    
    $semCode = $enrollment->semCode;
    $default_schYear = $enrollment->schYear;
    
    $sugar_smarty->assign('courseID', $enrollment->courseID );
    $sugar_smarty->assign('courseCode', $enrollment->courseCode );
    $sugar_smarty->assign('yrLevel', $enrollment->yrLevel );
    $sugar_smarty->assign('preparedBy', $enrollment->encodedBy );
    $sugar_smarty->assign('preparedName', $enrollment->encodedName );
    $sugar_smarty->assign('rstatus', $enrollment->rstatus );
    
    /**
     * clear the session vars
     */    
    unset($_SESSION['SCHEDULES']);
    unset($_SESSION['ORIGINAL_SCHEDULES']);
    
    $subj = new Subject($schedule->subjID);
    
    if ($enrollment->subjs) {
        $ctr=0;
        $subj = new Subject();
        foreach($enrollment->subjs as $row) {
            
            $subj->subjID = $row['subjID'];
            $subj->retrieveSubject();
            
            $data[$ctr] = $row;
            $data[$ctr]['subjCode'] = $subj->subjCode;
            $data[$ctr]['courseCode'] = $subj->courseCode;
            $data[$ctr]['descTitle'] = $subj->descTitle;
            
            $ctr++;
        }
    }
    
    $_SESSION['SCHEDULES'] = $data;
    
    // list for subject
    $sugar_smarty->assign('list', $_SESSION['SCHEDULES']);
    $sugar_smarty->assign('total_units', $enrollment->getTotalUnits($_SESSION['SCHEDULES']));

    $semesters='<select name="semCode" id="semCode" disabled>'."\n";
    $semesters.='<option value="">------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$semCode) {
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
	
	$schYear='<select name="schYear" id="schYear" disabled>'."\n";
	$schYear.='<option value="">-------------------</option>'."\n";
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
	
	$course = new Course();
    $sugar_smarty->assign('courseList', $course->retrieveAllCourses() );
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Enrollments/templates/editOldEnrollmentCol.tpl');
    calendarSetup('date', 'jscal_trigger');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script>
addToValidate('frmEnrollment','schYear', '', true, 'School Year');
addToValidate('frmEnrollment','semCode', '', true, 'Semester Code');
addToValidate('frmEnrollment','date', '', true, 'Semester Code');
addToValidate('frmEnrollment','idno', '', true, 'ID No.');
addToValidate('frmEnrollment','courseID', '', true, 'Course');
addToValidate('frmEnrollment','yrLevel', '', true, 'Year Level');
</script>

<script>
addToValidate('frmAddSubject','subjID', '', true, 'Subject');
addToValidate('frmAddSubject','fgrade', '', true, 'Grade');
</script>

<script language="javascript">

function clearStudentInfo()
{
    $('idno').value  = "";
    $('lname').value = "";
    $('fname').value = "";
    $('mname').value = "";
    
    $('courseID').options[0].selected=true;
    $('yrLevel').options[0].selected=true;
}

function saveEnrollment()
{
    if (check_form('frmEnrollment')) {
        if ($('lname').value!="") {
            onCheckEntry();
        } else {
            msg="Error: Student not found!";
            displayError(msg);
        }
    }
}



function getSubjects()
{
    get_data="courseID=" + $('courseID').value + "&action=getsubjects";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onGetSubjectsHandle");
}

function onGetSubjectsHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;

    	if (ret) {
	    	initializeCombo('subjID',"--------------------------");
			myData = ret.parseJSON();
			for(c = 0; c < myData.length; c++){
		    	var y=document.createElement('option');
				y.text=myData[c].subjCode;				
				y.setAttribute('value',myData[c].subjID);		
				var x=$('subjID');

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


function onCheckEnrollment()
{
    if (trim($('idno').value) != "" && trim($('schYear').value) != "" && trim($('semCode').value) != "" ) {
        get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&action=checkenrollment";
        ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckEnrollmentHandle");
    } else {
        msg = ""
        if (trim($('idno').value) == "") {
            if (trim(msg)=="") {
                msg = "Required Fields: \n";
            }
            
            msg += "ID No.\n";
        }
        
        if (trim($('schYear').value) == "") {
            if (trim(msg)=="") {
                msg = "Required Fields: \n";
            }
            
            msg += "School Year\n";
        }
        
        if (trim($('semCode').value) == "") {
            if (trim(msg)=="") {
                msg = "Required Fields: \n";
            }
            
            msg += "Semester\n";
        }
        
        if (msg!="") {
            alert(msg);
        }
    }
}


function onCheckEnrollmentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (ret=='1') {
    	    msg="Warning: Student was already enrolled!";
    	    displayError(msg);
    	    $('idno').focus();
    	} else {
    	    onStudentInfo();
    	}
        
    }
}

function onStudentInfo()
{
    get_data="idno=" + $('idno').value + "&action=getstudentinfo";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onStudentInfoHandle");
}

function onStudentInfoHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
        
    	if (ret!="0") {
    	    info = ret.parseJSON();
    	    for(c = 0; c < info.length; c++) {
        	    $('lname').value=info[c].lname;
        	    $('fname').value=info[c].fname;
        	    $('mname').value=info[c].mname;
        	    $('curID').value=info[c].curID;
        	    
                for(i = 0; i < $('courseID').length; i++) {
                    if ($('courseID').options[i].value==info[c].courseID) {
                        $('courseID').options[i].selected=true;
                        break;
                    }
                }	
                
                for(i = 0; i < $('yrLevel').length; i++) {
                    if ($('yrLevel').options[i].value==info[c].yrLevel) {
                        $('yrLevel').options[i].selected=true;
                        break;
                    }
                }	
                
                // enabled the schedCode
                //$('schedCode').setAttribute('readonly',false);
        	    
        	    $('yrLevel').focus();
        	    
        	    getSubjects();
    	    }
    	} else {
    	    msg="Error: Student ID not found!";
    	    alert(msg);
    	}
    }
}


function onCheckEntry()
{
    get_data="action=checkentry";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckEntryHandle");
}


function onCheckEntryHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (trim(ret)!='0') {
    	    $('schYear').disabled=false;
	    	$('semCode').disabled=false;
            $('frmEnrollment').submit();
    	} else {
    	    msg="Sorry, can't save empty enrollment form.";
    	    alert(msg);
    	}
    }
}

function onCheckDuplicate()
{
    if (check_form('frmAddSubject')) {
        get_data="subjID=" + $('subjID').value + "&action=checkduplicatesubj";
        ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckDuplicateHandle");
    }
}


function onCheckDuplicateHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (parseInt(ret)==1) {
	    	msg="Warning: Duplicate subject!";
	    	displayError(msg);
	    	$('fgrade').value="";
	    	$('subjID').focus();
    	} else {
    	    onAddSubject();
    	}
    }
}


function onAddSubject()
{
    get_data="subjID=" + $('subjID').value + "&fgrade=" + $('fgrade').value + "&action=addsubject";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onAddSubjectHandle");
}


function onAddSubjectHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
	    	$('divSchedules').innerHTML = ret;
	    	
	    	// make the ID No., course, year and section read only
//	    	$('idno').setAttribute('readonly',true);
//	    	$('secName').setAttribute('readonly',true);
//	    	$('schYear').disabled=true;
//	    	$('semCode').disabled=true;
//	    	$('courseID').disabled=true;
//	    	$('yrLevel').disabled=true;
	    	
	    	$('subjID').value="";
	    	$('fgrade').value="";
	    	$('subjID').focus();
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}


function removeSubject(subjID)
{
    get_data="subjID=" + subjID + "&action=remsubject";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onRemoveScheduleHandle");
}


function onRemoveScheduleHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	if (ret) {
	    	$('divSchedules').innerHTML = ret;
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

// put focus to the School Year
$('subjID').focus();

getSubjects();

</script>
