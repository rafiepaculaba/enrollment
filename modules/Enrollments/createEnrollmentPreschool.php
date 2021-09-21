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
require_once('modules/Config/ConfigPreschool.php');
require_once('modules/Subjects/SubjectPreschool.php');
require_once('modules/Students/StudentPreschool.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/SchedulePreschool.php');
require_once('modules/Schedules/BlockSectionPreschool.php');
require_once('modules/Schedules/BlockSectionSubjectPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Preschool Enrollment");
if ($access->check_access($current_user->id,$accessCode)) {
    // get all default setting from configs
    $config = new Config();
    
    // get the default school year
    $default_schYear = $config->getConfig('School Year');

    $default_date = date("m/d/Y",time());
    $sugar_smarty->assign('date', $default_date);
    
//    $schedule = new Schedule();
//    $schedList = $schedule->retrieveAllSchedules();
//    $sugar_smarty->assign('schedList', $schedList);
    
    unset($conds);
    if ($default_schYear) {
       $conds[0]['schYear'] = " = '$default_schYear' AND ";
    }
    
    $conds[0]['rstatus'] = "= 1 ";
    $blocksection = new BlockSection();
    $sectionlist  = $blocksection->retrieveAllBlockSections($conds);
    $sugar_smarty->assign('list', $sectionlist );
    
    // overwrite if from get method
    if ($_GET['schYear']) {
        $default_schYear = $_GET['schYear'];
    }
    
    if ($_GET['idno']) {
        $idno = $_GET['idno'];
        $sugar_smarty->assign('idno', $idno);
    }  
    
    if ($_GET['yrLevel']) {
        $default_year = $_GET['yrLevel'];
        $sugar_smarty->assign('yrLevel', $default_year);
    }

    /**
     * clear the session vars
     */
    unset($_SESSION['SCHEDULES']);
    
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
    
	$yearLevel='<select name="yrLevel" id="yrLevel" >'."\n";
    $yearLevel.='<option value="">-------------------</option>'."\n";
    if ($preschool_yrs) {
        foreach ($preschool_yrs as $key=>$value) {
            if ($key==$yrLevel) {
                $yearLevel .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $yearLevel .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $yearLevel.='</select>';
    $sugar_smarty->assign('YEARLEVEL', $yearLevel);
	
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Enrollments/templates/createEnrollmentPreschool.tpl');
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
addToValidate('frmEnrollment','idno', '', true, 'ID No.');
addToValidate('frmEnrollment','yrLevel', '', true, 'Level');

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

function hideShowSubject(divName)
{
    if ( $(divName).style.display=="Block" || $(divName).style.display=="block" ) {
        $(divName).style.display="None";
        $(divName+"Handle").src="themes/Sugar/images/advanced_search.gif";
    } else {
        $(divName).style.display="Block";
        $(divName+"Handle").src="themes/Sugar/images/basic_search.gif";
    }
}

function saveEnrollment()
{
    addToValidate('frmEnrollment','secName', '', true, 'Section');
    if (check_form('frmEnrollment')) {
        if ($('lname').value!="") {
            onCheckEntry();
        } else {
            msg="Invalid: Student not found!";
            //displayError(msg);
            alert(msg);
            
        }
    } else {
        removeFromValidate('frmEnrollment','secName')
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
    get_data="secID=" + secID + "&action=setblocksectionpreschool";
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


function setBlockSectionHandle()
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
	    	$('yrLevel').disabled=true;
	    	$('cmdBlock').disabled=true;
	    	
	    	
	    	$('secID').value   = secID;
	    	$('secName').value = secName;
	    	
//	    	$('schedCode').value="";
//	    	$('schedCode').focus();
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}


function clearStudentFields()
{
    $('lname').value="";
    $('fname').value="";
    $('mname').value="";
    $('yrLevel').value="";
}

function checkPrevID()
{
    if ( $('previdno').value != $('idno').value ) {
        // new id was entered
        clearStudentFields();
    }
}


function onCheckEnrollment()
{
    if (trim($('idno').value) != "" && trim($('schYear').value) != "" ) {
        get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&action=checkenrollmentpreschool";
        
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
    	    
    	    clearStudentFields();
    	    
    	    alert(msg);
    	    
    	    $('idno').focus();
    	} else {
    	    onDoubleCheckEnrollment();
    	}
        
    }
}


function onDoubleCheckEnrollment()
{
    get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&action=checkenrollmentpreschool";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onDoubleCheckEnrollmentHandle");
}


function onDoubleCheckEnrollmentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (ret=='1') {
    	    msg="Warning: Student already enrolled!";
    	    //displayError(msg);
    	    clearStudentFields();
    	    
    	    alert(msg);
    	    $('idno').focus();
    	} else {
    	    onStudentInfo();
    	}
        
    }
}


function onStudentInfo()
{
    get_data="idno=" + $('idno').value + "&action=getstudentinfopreschool";
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
        	    
                for(i = 0; i < $('yrLevel').length; i++) {
                    if ($('yrLevel').options[i].value==info[c].yrLevel) {
                        $('yrLevel').options[i].selected=true;
                        break;
                    }
                }	
                
                // enabled the schedCode
                //$('schedCode').setAttribute('readonly',false);
        	    
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
            onDoubleCheckOpenBlockSection();
    	} else {
    	    msg="Sorry, can't save empty enrollment form.";
    	    alert(msg);
    	}
    }
}

function onDoubleCheckOpenBlockSection()
{
    if (trim($('secID').value)!="") {
        get_data="secID=" + $('secID').value + "&action=doublecheckopenblocksectionpreschool";
        ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onDoubleCheckOpenBlockSectionHandle");
    } else {
        onDoubleCheckOpenSchedule();
    }
}


function onDoubleCheckOpenBlockSectionHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret!="" && parseInt(ret)) {
            onDoubleCheckOpenSchedule();
    	} else {
    	    msg="Warning: Sorry, the section is already closed.";
	    	alert(msg);
	    	$('schedCode').focus();
    	}
    }
}


function onDoubleCheckOpenSchedule()
{
    get_data="action=doublecheckopenschedulepreschool";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onDoubleCheckOpenScheduleHandle");
}


function onDoubleCheckOpenScheduleHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	if (ret=="" || !ret) {
    	    $('yrLvl').value  = $('yrLevel').value;
    	    $('sy').value     = $('schYear').value;
            
            $('schYear').disabled=false;
	    	$('yrLevel').disabled=false;
	    	
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
    if (trim($('schYear').value) != "" && trim($('schedCode').value) != "") {
        sched_code = $('schedCode').value;
        get_data="schYear=" + $('schYear').value + "&schedCode=" + $('schedCode').value + "&action=checkschedcodepreschool";
        ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onCheckSchedCodeHandle");
        
        
        // display the loading sign
        l = 200 + document.body.scrollLeft;
        t = 20 + document.body.scrollTop;
        displayLoading('divloading', l, t);
        
    } else {
        alert("Error: Sch Year and Sched Code is required!");
    }
}



function onCheckSchedCodeHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (trim(ret)!='0') {
    	    theSchedID = ret;
    	    onSubjectLevel();
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


function onSubjectLevel()
{
    get_data="schedID=" + theSchedID + "&action=checksubjectlevelpreschool";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onSubjectLevelHandle");
}


function onSubjectLevelHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (trim(ret)==$('yrLevel').value || trim(ret)=='0') {
            onCheckDuplicate();
    	} else {
    	    
    	    // hide the loading sign
            hiddenLoading('divloading');
    	    
    	    msg="Sorry, can't enroll subject not belong to the selected year level.";
    	    alert(msg);
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
    get_data="schedID=" + theSchedID + "&action=checkopenschedulepreschool";
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
    get_data="schedID=" + theSchedID + "&action=checkconflictpreschool";
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
    	    onAddSchedule();
    	}
    }
}

function onAddSchedule()
{
    get_data="schedID=" + theSchedID + "&action=addschedulepreschool";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onAddScheduleHandle");
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
	    	$('yrLevel').disabled=true;
	    	$('cmdBlock').disabled=true;
	    	
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
    get_data="idno=" + $('idno').value + "&schYear=" + $('schYear').value + "&yrLevel=" + $('yrLevel').value + "&action=getsectionspreschool";
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
    get_data="schedID=" + schedID + "&action=remschedulepreschool";
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

// select color
changeColor();

// put focus to the School Year
$('idno').focus();

// make the sched Code readonly
//$('schedCode').setAttribute('readonly',true);

// hide first the add subject
//hideShowSubject('divSubject');
</script>
