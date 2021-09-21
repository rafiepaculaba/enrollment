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
require_once('modules/Config/ConfigElem.php');
require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Students/StudentElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleElem.php');
require_once('modules/Schedules/BlockSectionElem.php');
require_once('modules/Schedules/BlockSectionSubjectElem.php');
require_once('modules/Grades/GradesheetElem.php');

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
$accessCode = $access->getAccessCode("Edit Elem Grade");
if ($access->check_access($current_user->id,$accessCode)) {
    $gsID = $_GET['gsID'];
    
    $gs = new GradeSheet($gsID);
    
    $sugar_smarty->assign('gsID', $gsID);
	$sugar_smarty->assign('schYear', $gs->schYear);
	$sugar_smarty->assign('teacher', $gs->profName);
	$sugar_smarty->assign('schedCode', $gs->schedCode);
	$sugar_smarty->assign('schedID', $gs->schedID);
	
	$subject = new Subject($gs->subjID);
	
	$sugar_smarty->assign('subject', $subject->subjCode." - ".$subject->descTitle);
	$sugar_smarty->assign('units', $gs->units);
	$sugar_smarty->assign('remarks', $gs->remarks);
	
	if ($gs->rstatus==1) {
	    $sugar_smarty->assign('status', "Pending");
	} else if ($gs->rstatus==2) {
	    $sugar_smarty->assign('status', "Approved");
	} else if ($gs->rstatus==3) {
	    $sugar_smarty->assign('status', "Posted");
	}
	
	$schedule = new Schedule($gs->schedID);
	$sugar_smarty->assign('room', $schedule->room);
	$sugar_smarty->assign('time', $schedule->startdTime."-".$schedule->enddTime);
	
	
	// days formation
    if ($schedule->onMon) {
        $days  .= "M";    
    }
    
    if ($schedule->onTue) {
        if ($schedule->onThu) {
            $days  .= "T";
        } else {
            $days  .= "Tue";
        }
    }
    
    if ($schedule->onWed) {
        $days  .= "W";
    }
    
    if ($schedule->onThu) {
        if ($schedule->onTue) {
            $days  .= "Th";
        } else {
            $days  .= "Thu";
        }
    }
    
    if ($schedule->onFri) {
        $days  .= "F";
    }
    
    if ($schedule->onSat) {
        $days  .= "Sat";
    }
    
    if ($schedule->onSun) {
        $days  .= "Sun";
    }
	
	$sugar_smarty->assign('days', $days);
	
	
	// get the class roster
    // get parameters
    $schedID = $gs->schedID;
    
    $tables[] = 'enrollments';
    $tables[] = 'enrollment_details';
    $tables[] = 'students';
    
    $multi_orders['students.lname'] = "ASC";
    $multi_orders['students.fname'] = "ASC";
    
    $fields['students.*']                       = "";
    $fields['enrollment_details.endID']         = "";
    $fields['enrollment_details.firstgrade']    = "";
    $fields['enrollment_details.secondgrade']   = "";
    $fields['enrollment_details.thirdgrade']    = "";
    $fields['enrollment_details.fourthgrade']   = "";
    $fields['enrollment_details.fgrade']        = "";
    
    $where[0]['enrollment_details.schedID'] = "='$schedID' AND ";
    $where[0]['enrollment_details.enID']    = "=enrollments.enID AND ";
    $where[0]['enrollments.idno']           = "=students.idno AND ";
    $where[0]['enrollments.rstatus']        = "='2'";
    
    $gs->tables = $tables;
    $gs->fields = $fields;
    $gs->conds  = $where;
    $gs->order  = $orderby;
    $gs->multi_orders = $multi_orders;
            
    // building an select query
    $query = $gs->Select();  // generate delete sql query
    $gs->reset();            // reset all variables in query generator
    
	try {
	    $gs->db->beginTransaction();
    	$result   = $gs->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$gs->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error.";
	}
	
	$sugar_smarty->assign('list', $records );
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Grades/templates/editGradeSheetElem.tpl');
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
addToValidate('frmGradesheet','profID', '', true, 'Teacher');
addToValidate('frmGradesheet','schedID', '', true, 'Sched Code');
</script>

<script language="javascript">

function goSubmitForm(theForm) 
{
    if (check_form(theForm)) {
        $(theForm).submit();
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
	
	$('students').innerHTML = ' <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody><tr height="20"><td scope="col" class="listViewThS1" nowrap>&nbsp;</td>	<td scope="col" class="listViewThS1" nowrap>ID No.</td><td scope="col" class="listViewThS1" nowrap>Student Name</td><td scope="col" class="listViewThS1" nowrap>Year</td>      <td scope="col" class="listViewThS1" nowrap>1<sup>st</sup></td>       <td scope="col" class="listViewThS1" nowrap>2<sup>nd</sup></td>        <td scope="col" class="listViewThS1" nowrap>3<sup>rd</sup></td>        <td scope="col" class="listViewThS1" nowrap>4<sup>th</sup></td>       <td scope="col" class="listViewThS1" nowrap>Final</td>	</tr></tbody></table>';
	
    get_data="schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&profID=" + $('profID').value + "&action=getschedulescol";
    ajaxQuery("modules/Grades/gradeHandler.php",'GET',get_data,"","onGetSchedulesHandle");
}

function onGetSchedulesHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
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
   } else {
        $('subject').value = "";
    	$('units').value = "";
    	$('room').value = "";
    	$('time').value = "";
    	$('days').value = "";
    	
    	
    	$('students').innerHTML = ' <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody><tr height="20"><td scope="col" class="listViewThS1" nowrap>&nbsp;</td>	<td scope="col" class="listViewThS1" nowrap>ID No.</td><td scope="col" class="listViewThS1" nowrap>Student Name</td><td scope="col" class="listViewThS1" nowrap>Year</td>      <td scope="col" class="listViewThS1" nowrap>1<sup>st</sup></td>       <td scope="col" class="listViewThS1" nowrap>2<sup>nd</sup></td>        <td scope="col" class="listViewThS1" nowrap>3<sup>rd</sup></td>        <td scope="col" class="listViewThS1" nowrap>4<sup>th</sup></td>       <td scope="col" class="listViewThS1" nowrap>Final</td>	</tr></tbody></table>';
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
    	    
    	    getStudents();
    	    
    	} else {
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
    }
}

function onGetStudentsHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
	    	$('students').innerHTML = ret;
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}


</script>
