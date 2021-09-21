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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL_OLD']."", false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Old Enrollment");
if ($access->check_access($current_user->id,$accessCode)) {
    // get all default setting from configs
    $config = new Config();
    
    // get the default school year
    $default_schYear = $config->getConfig('School Year');
    
    $default_date = date("m/d/Y",time());
    $sugar_smarty->assign('date', $default_date);
    
    // get the default semester
    $default_semCode = $config->getConfig('Semester');
    
    $course = new Course();
    $sugar_smarty->assign('courseList', $course->retrieveAllCourses() );
    
    
    unset($conds);
    if ($default_schYear) {
       $conds[0]['schYear'] = " = '$default_schYear' AND ";
    }
    
    if ($default_semCode) {
       $conds[0]['semCode'] = " = '$default_semCode' AND ";
    }
    
    $conds[0]['rstatus'] = "= 1 ";
    
    // overwrite if from get method
    if ($_GET['schYear']) {
        $default_schYear = $_GET['schYear'];
    }
    
    if ($_GET['semCode']) {
        $default_semCode = $_GET['semCode'];
    }
     
    if ($_GET['idno']) {
        $idno = $_GET['idno'];
        $sugar_smarty->assign('idno', $idno);
    }  
    
    if ($_GET['courseID']) {
        $default_course = $_GET['courseID'];
        $sugar_smarty->assign('courseID', $default_course);
    }  
    
    if ($_GET['yrLevel']) {
        $default_year = $_GET['yrLevel'];
        $sugar_smarty->assign('yrLevel', $default_year);
    }

    /**
     * clear the session vars
     */
    unset($_SESSION['SCHEDULES']);
    
    $semesters='<select name="semCode" id="semCode" onchange="clearStudentInfo();">'."\n";
    $semesters.='<option value="">------------</option>'."\n";
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
	for($yr=$config->getConfig('Since Year'); $yr<=$year+1; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear">'."\n";
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
	
	$subj = new Subject();
	$sugar_smarty->assign('subjList', $subj->retrieveAllSubjects());
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Enrollments/templates/createOldEnrollmentCol.tpl');
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
addToValidate('frmEnrollment','idno', '', true, 'ID No.');
addToValidate('frmEnrollment','courseID', '', true, 'Course');
addToValidate('frmEnrollment','yrLevel', '', true, 'Year Level');
</script>

<script>
addToValidate('frmAddSubject','subjID', '', true, 'Subject');
addToValidate('frmAddSubject','fgrade', '', true, 'Grade');
</script>

<script language="javascript">
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=430,left = 0,top = 0');");
}

function setIDNO(id)
{
	$('idno').value=id;
	onCheckEnrollment();
}

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
            //displayError(msg);
            alert(msg);
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

//
//function onCheckEnrollment()
//{
//    if (trim($('idno').value) != "" && trim($('schYear').value) != "" && trim($('semCode').value) != "" ) {
//        get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&action=checkenrollment";
//        ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckEnrollmentHandle");
//    } else {
//        msg = ""
//        if (trim($('idno').value) == "") {
//            if (trim(msg)=="") {
//                msg = "Required Fields: \n";
//            }
//            
//            msg += "ID No.\n";
//        }
//        
//        if (trim($('schYear').value) == "") {
//            if (trim(msg)=="") {
//                msg = "Required Fields: \n";
//            }
//            
//            msg += "School Year\n";
//        }
//        
//        if (trim($('semCode').value) == "") {
//            if (trim(msg)=="") {
//                msg = "Required Fields: \n";
//            }
//            
//            msg += "Semester\n";
//        }
//        
//        if (msg!="") {
//            alert(msg);
//        }
//    }
//}
//
//
//function onCheckEnrollmentHandle()
//{
//	if (xmlHttp.readyState==4) {
//        // Get the data from the server's response in text format
//    	var ret = xmlHttp.responseText; // if ret not empty/0
//    	if (ret=='1') {
//    	    msg="Warning: Student was already enrolled!";
//    	    //displayError(msg);
//    	    alert(msg);
//    	    $('idno').focus();
//    	} else {
//    	    onStudentInfo();
//    	}
//        
//    }
//}

function onCheckEnrollment()
{
    if (trim($('idno').value) != "" && trim($('schYear').value) != "" && trim($('semCode').value) != "" ) {
        get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&action=checkoldenrollment";
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
    	    clearStudentFields();
    	    
    	    msg="Warning: Student already enrolled!";
    	    //displayError(msg);
    	    alert(msg);
    	    
    	    $('idno').focus();
    	} else {
    	    onDoubleCheckEnrollment();
    	}
        
    }
}


function onDoubleCheckEnrollment()
{
    get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&action=checkoldenrollment";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onDoubleCheckEnrollmentHandle");
}


function onDoubleCheckEnrollmentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (ret=='1') {
    	    clearStudentFields();
    	    
    	    msg="Warning: Student already enrolled!";
    	    //displayError(msg);
    	    alert(msg);
    	    
    	    $('idno').focus();
    	} else {
    	    onStudentInfo();
    	}
        
    }
}

function clearStudentFields()
{
    $('lname').value="";
    $('fname').value="";
    $('mname').value="";
    $('curID').value="";
    $('courseID').value="";
    $('yrLevel').value="";
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
	    	//displayError(msg);
	    	alert(msg);
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


<?php 
if ($idno) {
    echo "onStudentInfo();";
}
?>

// put focus to the School Year
$('idno').focus();

// make the sched Code readonly
//$('schedCode').setAttribute('readonly',true);


</script>
