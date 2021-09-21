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
require_once('modules/Config/ConfigHS.php');
require_once('modules/Departments/Department.php');
require_once('modules/Subjects/SubjectHS.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleHS.php');
require_once('modules/Schedules/BlockSectionHS.php');
require_once('modules/Schedules/BlockSectionSubjectHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_BLOCK_HS'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create HS Block Section");
if ($access->check_access($current_user->id,$accessCode)) {
        
    $schedule = new Schedule();
    $schedList = $schedule->retrieveAllSchedulesSubjectAssociated();
    $sugar_smarty->assign('schedList', $schedList);
    
    // get all default setting from configs
    $config = new Config();
    
    // get the default school year
    $default_schYear = $config->getConfig('School Year');

    /**
     * clear the session vars
     */
    unset($_SESSION['SCHEDULES']);
        
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear" onchange="getSchedules(0);">'."\n";
	$schYear.='<option value="">--------------------------------</option>'."\n";
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
    echo $sugar_smarty->fetch('modules/Schedules/templates/createBlockSectionHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script>
addToValidate('frmBlockSection','schYear', '', true, 'School Year');
addToValidate('frmBlockSection','secName', '', true, 'Section Name');
addToValidate('frmBlockSection','yrLevel', '', true, 'Year');
addToValidate('frmBlockSection','maxCapacity', '', true, 'Maximum Capacity');
</script>

<script>
addToValidate('frmAddSchedule','schedID', '', true, 'Sched Code');
</script>

<script language="javascript">

function getSchedules(checking)
{
    if ($('schYear').value && $('yrLevel').value) {
        get_data="schYear=" + $('schYear').value + "&yrLevel=" + $('yrLevel').value + "&action=getscheduleshs";
        ajaxQuery("modules/Schedules/blockSectionHandler.php",'GET',get_data,"","onGetSchedulesHandle");
    } else {
        msg = "Required field(s)\n"
        if ($('schYear').value=="") {
            msg += " - School Year\n"
        }
        
        if ($('yrLevel').value=="") {
            msg += " - Year\n"
        }
        
        if (checking) {
            alert(msg);
            $('schYear').focus();
        }
    }
}

function onGetSchedulesHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
	    	initializeCombo('schedID',"------------------------------------------");
			myData = ret.parseJSON();
			for(c = 0; c < myData.length; c++){
		    	var y=document.createElement('option');
				//y.text=myData[c].schedCode;				
				y.text=myData[c].schedCode + " - " + myData[c].subjCode;
				//  + " " + myData[c].descTitle;
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


function onCheckDuplicateSection()
{
    if ( check_form('frmBlockSection') ) {
        get_data="schYear=" + $('schYear').value + "&yrLevel=" + $('yrLevel').value + "&secName=" + $('secName').value + "&action=checkduplicatesectionhs";
        ajaxQuery("modules/Schedules/blockSectionHandler.php",'GET',get_data,"","onCheckDuplicateSectionHandle");
    }
}


function onCheckDuplicateSectionHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (parseInt(ret)==1) {
	    	msg="Warning: Duplicate block section.";
	    	//displayError(msg);
	    	alert(msg);
    	} else {
    	    //$('frmBlockSection').submit();
    	    onCheckEntry();
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
            $('frmBlockSection').submit();
    	} else {
    	    msg="Sorry, can't save empty section/block.";
    	    alert(msg);
    	}
    }
}



function onCheckDuplicate()
{
    if ( check_form('frmAddSchedule') ) {
        get_data="schedID=" + $('schedID').value + "&action=checkduplicate";
        ajaxQuery("modules/Schedules/blockSectionHandler.php",'GET',get_data,"","onCheckDuplicateHandle");
    }
}


function onCheckDuplicateHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (parseInt(ret)==1) {
	    	msg="Warning: Duplicate schedule";
	    	//displayError(msg);
	    	alert(msg);
    	} else {
    	    onSubjectLevel();
    	}
    }
}


function onSubjectLevel()
{
    get_data="schedID=" + $('schedID').value + "&action=checksubjectlevelhs";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onSubjectLevelHandle");
}


function onSubjectLevelHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText; // if ret not empty/0
    	if (trim(ret)==$('yrLevel').value || trim(ret)=='0') {
            onCheckConflict();
    	} else {
    	    msg="Sorry, can't enroll subject not belong to the selected year level.";
    	    alert(msg);
    	}
    }
}


function onCheckConflict()
{
    get_data="schedID=" + $('schedID').value + "&action=checkconflicths";
    ajaxQuery("modules/Schedules/blockSectionHandler.php",'GET',get_data,"","onCheckConflictHandle");
}


function onCheckConflictHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (parseInt(ret)==1) {
	    	msg="Warning: Conflict schedule";
	    	//displayError(msg);
	    	alert(msg);
    	} else {
    	    onAddSchedule();
    	}
    }
}


function onAddSchedule()
{
    get_data="schedID=" + $('schedID').value + "&action=addschedulehs";
    ajaxQuery("modules/Schedules/blockSectionHandler.php",'GET',get_data,"","onAddScheduleHandle");
}


function onAddScheduleHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
	    	$('divSchedules').innerHTML = ret;
	    	$('schedID').value="";
	    	$('schedID').focus();
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}


function removeSchedule(schedID)
{
    get_data="schedID=" + schedID + "&action=remschedule";
    ajaxQuery("modules/Schedules/blockSectionHandler.php",'GET',get_data,"","onRemoveScheduleHandle");
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
$('schYear').focus();

// set defaults
getSchedules(0);

</script>
