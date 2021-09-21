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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Col Enrollment");
if ($access->check_access($current_user->id,$accessCode)) {
    // get all default setting from configs
    $config = new Config();
    
    // setting for compliance
    $_SESSION['PREREQUISITE_COMPLIANCE'] = $config->getConfig('Check Prerequisite');
    $_SESSION['DEPARTMENTAL_COMPLIANCE'] = $config->getConfig('Check Department');

    // get the default school year
    $default_schYear = $config->getConfig('School Year');
    
    $default_date = date("m/d/Y",time());
    $sugar_smarty->assign('date', $default_date);
    
    // get the default semester
    $default_semCode = $config->getConfig('Semester');
    
    $course = new Course();
    $sugar_smarty->assign('courseList', $course->retrieveAllCourses() );
    
    //$schedule = new Schedule();
    //$schedList = $schedule->retrieveAllSchedulesAssociated();
    //$sugar_smarty->assign('schedList', $schedList);
    
    unset($conds);
    if ($default_schYear) {
       $conds[0]['schYear'] = " = '$default_schYear' AND ";
    }
    
    if ($default_semCode) {
       $conds[0]['semCode'] = " = '$default_semCode' AND ";
    }
    
    $conds[0]['rstatus'] = "= 1 ";
    $blocksection = new BlockSection();
    $sectionlist  = $blocksection->retrieveAllBlockSections($conds);
    $sugar_smarty->assign('list', $sectionlist );
    
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
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
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
	
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Enrollments/templates/createEnrollmentCol.tpl');
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
addToValidate('frmEnrollment','lname', '', true, 'Last Name');
addToValidate('frmEnrollment','fname', '', true, 'First Name');
addToValidate('frmEnrollment','mname', '', true, 'Middle Name');
addToValidate('frmEnrollment','courseID', '', true, 'Course');
addToValidate('frmEnrollment','yrLevel', '', true, 'Year Level');
</script>

<script language="javascript">

var theSchedID = "";
var secID      = "";
var secName    = "";

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

function changeColor() 
{
	if ($('studType').value==1) {
		SUGAR.themes.changeColor('sugar');
	} else if ($('studType').value==2) {
		SUGAR.themes.changeColor('green');
	} else if ($('studType').value==3) {
		SUGAR.themes.changeColor('blue');
	}
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

function setBlockSection(theSecID, theSecName)
{
    
    secID   = theSecID;
    secName = theSecName;
    get_data="secID=" + secID + "&action=setblocksection";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","setBlockSectionHandle");
    
    // disable the cmdBlock to prevent double clicking
    $('cmdBlock').disabled=true;
    // close the popup div
    hiddenFloatingDiv('windowcontent');
    
    // display the loading sign
    l = 200 + document.body.scrollLeft;
    t = 20 + document.body.scrollTop;
    displayLoading('divloading', l, t);
    
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

function checkPrevID()
{
    if ( $('previdno').value != $('idno').value ) {
        // new id was entered
        clearStudentFields();
    }
}

function setBlockSectionHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
	    	$('divSchedules').innerHTML = ret;
	    	
	    	// make the ID No., course, year and section read only
	    	$('idno').setAttribute('readonly',true);
	    	$('secName').setAttribute('readonly',true);
	    	$('schYear').disabled=true;
	    	$('semCode').disabled=true;
	    	$('courseID').disabled=true;
	    	$('yrLevel').disabled=true;
	    	$('cmdBlock').disabled=true;
	    	
	    	
	    	$('secID').value   = secID;
	    	$('secName').value = secName;
	    	
	    	$('schedCode').value="";
	    	$('schedCode').focus();
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    	
        
        // hide the loading sign
        hiddenLoading('divloading');
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
    get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&action=checkenrollment";
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
    	    onCheckPayment();
    	}
        
    }
}

function onCheckPayment()
{
    get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&action=checkpayment";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckPaymentHandle");
}


function onCheckPaymentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (ret=='1') {
    	    clearStudentFields();
    	    
    	    msg="Warning: Student has not yet paid!";
    	    //displayError(msg);
    	    alert(msg);
    	    
    	    $('idno').focus();
    	} else {
//    	    onStudentInfo();
            onGetTotalUnits();
    	}
    }
}

function onGetTotalUnits()
{
    get_data="idno=" + $('idno').value + "&yrLevel=" + $('yrLevel').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&action=gettotalunits";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onGetTotalUnitsHandle");
}

function onGetTotalUnitsHandle()
{
	if (xmlHttp.readyState==4) {
	    var totalunits;
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (ret=='0' && ret=='') {
    	    clearStudentFields();
    	    
    	    msg="Warning: no curriculum selected !";
    	    //displayError(msg);
    	    alert(msg);
    	    
    	    $('idno').focus();
    	} else {
    	    totalunits = $('totalunits').value = ret;
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
        	    $('previdno').value=info[c].idno;
        	    
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
    	    // clear student fields
    	    clearStudentFields();
    	    
    	    msg="Invalid: Student ID not found!";
    	    alert(msg);
    	    
    	    $('idno').focus();
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
    	    msg="Warning: Some of the subjects are already closed.\n"+ret;
	    	//displayError(msg);
	    	alert(msg);
	    	$('schedCode').focus();
    	}
    }
}



function onCheckSchedCode()
{
    if (trim($('schYear').value) != "" && trim($('semCode').value) != "" && trim($('schedCode').value) != "") {
        sched_code = $('schedCode').value;
        get_data="schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&schedCode=" + $('schedCode').value + "&action=checkschedcode";
        ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckSchedCodeHandle");
        
        // display the loading sign
        l = 200 + document.body.scrollLeft;
        t = 20 + document.body.scrollTop;
        displayLoading('divloading', l, t);
        
    } else {
        alert("Error: School Year, Semester and Sched Code is required!");
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
            
            if (sched_code!=$('schedCode').value) {
                onCheckSchedCode();
            } else {
        	    msg="Invalid: Sched Code not found!";
        	    alert(msg);
        	    $('schedCode').focus();
            }
    	    
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
    	    
            // hide the loading sign
            hiddenLoading('divloading');
    	    
    	    msg="Sorry, can't save empty schedule.";
    	    alert(msg);
    	}
    }
}

function onCheckPrerequisites()
{
    get_data="schedCode=" + $('schedCode').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&idno=" + $('idno').value + "&action=checkprerequisites";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckPrerequisitesHandle");
}


function onCheckPrerequisitesHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (trim(ret)=="" || trim(ret)=="0" || trim(ret)==0) {
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
	    	$('secName').setAttribute('readonly',true);
	    	$('schYear').disabled=true;
	    	$('semCode').disabled=true;
	    	$('courseID').disabled=true;
	    	$('yrLevel').disabled=true;
	    	$('cmdBlock').disabled=true;
	    	
	    	$('schedCode').value="";
	    	onCheckOverLoading();
	    	
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function onCheckOverLoading()
{
	if ($('totalunits').value!="") {
	    if(parseInt($('temptotalunits').value) <= parseInt($('totalunits').value)) {
	  		$('schedCode').focus();
	    } else {
	        alert('Warning: Subject over load');
	    }
	}
}

function getSections()
{
    get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&courseID=" + $('courseID').value + "&yrLevel=" + $('yrLevel').value + "&action=getsections";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onGetSectionsHandle");
    
    // display the loading sign
    l = 200 + document.body.scrollLeft;
    t = 20 + document.body.scrollTop;
    displayLoading('divloading', l, t);
    
}

function onGetSectionsHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	 // hide the loading sign
        hiddenLoading('divloading');
    	
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
    
    // display the loading sign
    l = 200 + document.body.scrollLeft;
    t = 20 + document.body.scrollTop;
    displayLoading('divloading', l, t);
}


function onRemoveScheduleHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	 // hide the loading sign
        hiddenLoading('divloading');
    	
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

// select color
changeColor();

// put focus to the School Year
$('idno').focus();

// make the sched Code readonly
//$('schedCode').setAttribute('readonly',true);


</script>
