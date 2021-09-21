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

require_once('modules/Schedules/Schedule.php');
require_once('modules/Schedules/BlockSectionSubjectCol.php');
require_once('modules/Schedules/BlockSectionCol.php');
require_once('modules/Enrollments/EnrollmentCol.php');
require_once('modules/Enrollments/EnrollmentDetailCol.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Col Enrollment");
if ($access->check_access($current_user->id,$accessCode)) {
    $enID = $_GET['enID'];
    
    // get all default setting from configs
    $config = new Config();
    
    // setting for compliance
    $_SESSION['PREREQUISITE_COMPLIANCE'] = $config->getConfig('Check Prerequisite');
    $_SESSION['DEPARTMENTAL_COMPLIANCE'] = $config->getConfig('Check Department');
    
    $enrollment = new Enrollment($enID);
    
    $sugar_smarty->assign('enID', $enID );
    $sugar_smarty->assign('idno', $enrollment->idno );
    $sugar_smarty->assign('lname', $enrollment->lname );
    $sugar_smarty->assign('fname', $enrollment->fname );
    $sugar_smarty->assign('mname', $enrollment->mname );
    $sugar_smarty->assign('schYear', $enrollment->schYear );
    $sugar_smarty->assign('semCode', $enrollment->semCode );
    $sugar_smarty->assign('secName', $enrollment->secName );
    
    $semCode = $enrollment->semCode;
    $default_schYear = $enrollment->schYear;
    
    $sugar_smarty->assign('curID', $enrollment->curID );
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
    
    $schedule = new Schedule($schedID);
    $subj = new Subject($schedule->subjID);
    
    if ($enrollment->subjs) {
        $ctr=0;
        foreach($enrollment->subjs as $row) {
            
            $data = array();
            
            $schedule->schedID = $row['sched']->schedID;
            $schedule->retrieveSchedule();
            $subj->subjID = $schedule->subjID;
            $subj->retrieveSubject();
            
            $data['schedID']       = $schedule->schedID;
            $data['schedCode']     = $schedule->schedCode;
            $data['subjID']        = $schedule->subjID;
            $data['subjCode']      = $schedule->subjCode;
            $data['starttime']     = $schedule->startTime;
            $data['courseCode']    = $row['sched']->courseCode;
            $data['startdTime']    = $schedule->startdTime;
            $data['endtime']       = $schedule->endTime;
            $data['enddTime']      = $schedule->enddTime;
            
            $data['time_display']  = date("g:i",strtotime($schedule->startdTime))."-".date("g:i A",strtotime($schedule->enddTime));
            
            // days for display ex. MWF, TTH, SAT, SUN
            if ($schedule->onMon) {
                $data['days_display']  .= "M";    
            }
            
            if ($schedule->onTue) {
                if ($schedule->onThu) {
                    $data['days_display']  .= "T";
                } else {
                    $data['days_display']  .= "Tue";
                }
            }
            
            if ($schedule->onWed) {
                $data['days_display']  .= "W";
            }
            
            if ($schedule->onThu) {
                if ($schedule->onTue) {
                    $data['days_display']  .= "Th";
                } else {
                    $data['days_display']  .= "Thu";
                }
            }
            
            if ($schedule->onFri) {
                $data['days_display']  .= "F";
            }
            
            if ($schedule->onSat) {
                $data['days_display']  .= "Sat";
            }
            
            if ($schedule->onSun) {
                $data['days_display']  .= "Sun";
            }
            
            // numerical presentation of days separated with comma (,)
            $data['days']   = $schedule->onMon.",".$schedule->onTue.",".$schedule->onWed.",".$schedule->onThu.",".$schedule->onFri.",".$schedule->onSat.",".$schedule->onSun.",";
        
            $data['onMon']  = $schedule->onMon;
            $data['onTue']  = $schedule->onTue;
            $data['onWed']  = $schedule->onWed;
            $data['onThu']  = $schedule->onThu;
            $data['onFri']  = $schedule->onFri;
            $data['onSat']  = $schedule->onSat;
            $data['onSun']  = $schedule->onSun;
            
            $data['room']   = $schedule->room;
            $data['units']  = $subj->units; 
        
            // need duplicate checking
            $_SESSION['SCHEDULES'][]=$data;
        }
    }
    
    $_SESSION['ORIGINAL_SCHEDULES'] = $_SESSION['SCHEDULES'];
    
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
	for($yr=$config->getConfig('Since Year'); $yr<=$year+1; $yr++) {
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
    echo $sugar_smarty->fetch('modules/Enrollments/templates/editEnrollmentCol.tpl');
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

<script language="javascript">

var theSchedID="";

function saveEnrollment()
{
    if (check_form('frmEnrollment')) {
        if ($('lname').value!="") {
            onCheckEntry();
        } else {
            msg="Invalid: Student not found!";
            //displayError(msg);
            alert(msg);
        }
    }
}

function displayWindow(divId,title) 
{
    
    if (check_form('frmEnrollment')) {
        var w, h, l, t;
        w = 400;
        h = 250;
        l = screen.width/4;
        t = screen.height/4;
        
        if (navigator.appName=="Microsoft Internet Explorer") {
            l = 300 + document.body.scrollLeft;
            t = h + document.body.scrollTop;
        } else {
            l = 300 + document.body.scrollLeft;
            t = h + document.body.scrollTop;
        }
    
        // with title		        
        displayFloatingDiv(divId, title, w, h, l, t);
        // populate sections
        getSections();
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
    	    msg="Warning: Student already enrolled!";
    	    //displayError(msg);
    	    alert(msg);
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
        	    
                // set the value of the deptID
                onDepartment();
                
        	    $('yrLevel').focus();
    	    }
    	} else {
    	    msg="Invalid: Student ID not found!";
    	    alert(msg);
    	}
    }
}

function onDepartment()
{
    if ($('courseID').value) {
        get_data="courseID=" + $('courseID').value + "&action=getdepartment";
        ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onDepartmentHandle");
    }
}


function onDepartmentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
        $('deptID').value = ret;
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
            onDoubleCheckOpenSchedule();
    	} else {
    	    msg="Sorry, can't save empty enrollment form.";
    	    alert(msg);
    	}
    }
}

function onDoubleCheckOpenSchedule()
{
    get_data="action=doublecheckopenschedule";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onDoubleCheckOpenScheduleHandle");
}


function onDoubleCheckOpenScheduleHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	if (ret=="" || !ret) {
    	    $('yrLvl').value  = $('yrLevel').value;
            $('course').value = $('courseID').value;
            
            $('schYear').disabled=false;
	    	$('semCode').disabled=false;
	    	
            $('frmEnrollment').submit();
    	} else {
    	    msg="Warning: Some of the subjects are already closed.<br>"+ret;
	    	//displayError(msg);
	    	alert(msg);
	    	$('schedCode').focus();
    	}
    }
}


function onCheckSchedCode()
{
    if (trim($('schYear').value) != "" && trim($('semCode').value) != "" && trim($('schedCode').value) != "") {
        get_data="schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&schedCode=" + $('schedCode').value + "&action=checkschedcode";
        ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckSchedCodeHandle");
        
        // display the loading sign
        l = 200 + document.body.scrollLeft;
        t = 20 + document.body.scrollTop;
        displayLoading('divloading', l, t);
        
    } else {
        alert("Error: Sch Year, Semester and Sched Code is required!");
    }
}

function onCheckSchedCodeHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (trim(ret)!='0') {
    	    theSchedID = ret;
    	    onCheckDuplicate();
    	} else {
            
            // hide the loading sign
            hiddenLoading('divloading');
    	    
    	    msg="Invalid: Sched Code not found!";
    	    alert(msg);
    	    $('schedCode').focus();
    	}
    }
}


function onCheckDuplicate()
{
    get_data="schedID=" + theSchedID + "&action=checkduplicate";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckDuplicateHandle");
}


function onCheckDuplicateHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (parseInt(ret)==1) {
    	    
            // hide the loading sign
            hiddenLoading('divloading');
    	    
	    	msg="Warning: Duplicate schedule";
	    	//displayError(msg);
	    	alert(msg);
	    	$('schedCode').focus();
    	} else {
    	    onCheckOpenSchedule();
    	}
    }
}

function onCheckOpenSchedule()
{
    get_data="schedID=" + theSchedID + "&action=checkopenschedule";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckOpenScheduleHandle");
}


function onCheckOpenScheduleHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (parseInt(ret)==1) {
    	    onCheckConflict();
    	} else {
            
            // hide the loading sign
            hiddenLoading('divloading');
    	    
    	    msg="Warning: Subject schedule is already closed!";
	    	// displayError(msg);
	    	alert(msg);
	    	$('schedCode').focus();
    	}
    }
}


function onCheckConflict()
{
    get_data="schedID=" + theSchedID + "&action=checkconflict";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckConflictHandle");
}


function onCheckConflictHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (parseInt(ret)==1) {
            
            // hide the loading sign
            hiddenLoading('divloading');
    	    
	    	msg="Warning: Conflict schedule";
	    	//displayError(msg);
	    	alert(msg);
	    	$('schedCode').focus();
    	} else {
    	    <?php  
    	    if ($_SESSION['PREREQUISITE_COMPLIANCE']) {
    	       echo "onCheckPrerequisites();";    
    	    } else {
    	       if ($_SESSION['DEPARTMENTAL_COMPLIANCE']) {
    	           echo "onCheckDepartment();";    
    	       } else {
    	           echo "onAddSchedule();";
    	       }
    	    }
    	    ?>
    	    
    	}
    }
}

function onCheckDepartment()
{
    get_data="schedCode=" + $('schedCode').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&action=checkdepartment";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckDepartmentHandle");
}


function onCheckDepartmentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (trim(ret)!='0') {
    	    // check if same department
    	    if ($('deptID').value!=ret) {
    	        
                // hide the loading sign
                hiddenLoading('divloading');
    	        
    	        reply = confirm("Subject is from another department. Do you want to continue?");
    	        if (reply) {
    	            onAddSchedule();
    	        }
    	    } else {
    	        onAddSchedule();
    	    }
    	} else {
    	    msg="Sorry, can't save empty schedule.";
    	    alert(msg);
    	}
    }
}

function onCheckPrerequisites()
{
    //get_data="schedCode=" + $('schedCode').value + "&idno=" + $('idno').value + "&action=checkprerequisites";
    get_data="schedCode=" + $('schedCode').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&idno=" + $('idno').value + "&action=checkprerequisites";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckPrerequisitesHandle");
}


function onCheckPrerequisitesHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (trim(ret)=="") {
            <?php
               if ($_SESSION['DEPARTMENTAL_COMPLIANCE']) {
    	           echo "onCheckDepartment();";    
	           } else {
	               echo "onAddSchedule();";
	           }
            ?>
    	} else {
            
            // hide the loading sign
            hiddenLoading('divloading');
    	    
    	    // check if has prerequisite that have not been taken yet.
    	    msg="Prerequisite(s) required: "+ret;
    	    alert(msg);
    	}
    }
}

function onAddSchedule()
{
    get_data="schedID=" + theSchedID + "&action=addschedule";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onAddScheduleHandle");
    
    // display the loading sign
    l = 200 + document.body.scrollLeft;
    t = 20 + document.body.scrollTop;
    displayLoading('divloading', l, t);
        
}


function onAddScheduleHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
        // hide the loading sign
        hiddenLoading('divloading');
    	
    	if (ret) {
	    	$('divSchedules').innerHTML = ret;
	    	
	    	// make the ID No., course, year and section read only
	    	$('idno').setAttribute('readonly',true);
	    	$('secID').setAttribute('readonly',true);
	    	$('courseID').disabled=true;
	    	$('yrLevel').disabled=true;
	    	//$('cmdBlock').disabled=true;
	    	
	    	$('schedCode').value="";
	    	$('schedCode').focus();
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}


function getSections()
{
    get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&courseID=" + $('courseID').value + "&yrLevel=" + $('yrLevel').value + "&action=getsections";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onGetSectionsHandle");
}

function onGetSectionsHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
	    	$('divSectionList').innerHTML = ret;
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}


function removeSchedule(schedID)
{
    get_data="schedID=" + schedID + "&action=remschedule";
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
//if ($idno) {
//    echo "onStudentInfo();";
//}
?>

// put focus to the School Year
$('schedCode').focus();

// make the sched Code readonly
//$('schedCode').setAttribute('readonly',true);

onDepartment();
</script>
