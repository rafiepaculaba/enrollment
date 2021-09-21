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
require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Config/ConfigElem.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_ELEM']."", false);
echo "\n</p>\n";
global $theme;
global $esConfig;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Elem Schedule");
if ($access->check_access($current_user->id,$accessCode)) {

	//Subject list
	$subject = new Subject();

	$subject_list = $subject->retrieveAllSubjects();
	$sugar_smarty->assign('subject_list', $subject_list);

	// get all default setting from configs
    $config = new Config();

    // get the default school year
    $default_schYear = $config->getConfig('School Year');
    
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
	
	$yearLevel='<select name="yrLevel" id="yrLevel" onchange="getSubjects();">'."\n";
    $yearLevel.='<option value="">-------------------</option>'."\n";
    if ($elementary_yrs) {
        foreach ($elementary_yrs as $key=>$value) {
            if ($key==$yrLevel) {
                $yearLevel .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $yearLevel .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $yearLevel.='</select>';
    $sugar_smarty->assign('YEARLEVEL', $yearLevel);	
	
	//user list
	$user = new User2();
	$where[0]['groupID']="=8";

	$user_list = $user->retrieveAllUsers($where,'');
	$sugar_smarty->assign('user_list', $user_list);

	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Schedules/templates/createScheduleElem.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmScheduleElem','schYear', '', true, 'School Year');
addToValidate('frmScheduleElem','yrLevel', '', true, 'Grade Level');
addToValidate('frmScheduleElem','subjID', '', true, 'Subject');
addToValidate('frmScheduleElem','schedCode', '', true, 'Sched Code');
//addToValidate('frmScheduleElem','maxCapacity', '', true, 'Max Capacity');
addToValidate('frmScheduleElem','room', '', true, 'Room');
</script>

<script language="javascript">
function validateTime()
{
	if (check_form('frmScheduleElem')) {
		
		if ($('shh').value != '' && $('smm').value != '' && $('smm').value <60 && $('samp').value != '' && $('ehh').value != '' && $('emm').value != '' && $('emm').value <60 && $('eamp').value != '') {

			startTime = $('shh').value+":"+$('smm').value+" "+$('samp').value;
			endTime   = $('ehh').value+":"+$('emm').value+" "+$('eamp').value;
			
		    get_data="startTime=" + startTime + "&endTime=" + endTime + "&action=validateTime";
		    ajaxQuery("modules/Schedules/scheduleHandler.php",'GET',get_data,"","onValidateTimeHandle");
		
		} else if ($('shh').value == '' || $('smm').value == '' || $('samp').value == '') { 
			msg = "Error: Start time should have a value!";
    		alert(msg);
		} else if ($('ehh').value == '' || $('emm').value == '' || $('eamp').value == '') { 
			msg = "Error: End time should have a value!";
    		alert(msg);
		} else if ($('smm').value >= 60 || $('emm').value >= 60 ) { 
			if ($('smm').value >= 60 && $('emm').value < 60) {
				msg = "Error: Invalid Start time in minutes!";
	    		alert(msg);
			} else if ($('emm').value >= 60 && $('smm').value < 60) {
				msg = "Error: Invalid end time in minutes!";
	    		alert(msg);
			} else {
				msg = "Error: Invalid start and end time in minutes!";
	    		alert(msg);
			}
		}
		else {
			msg = "Error: Invalid start/end time!";
    		alert(msg);
		}
	}
}

function onValidateTimeHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	if (ret==1) {
			//Chek if room are conflict to the other Schedule;
    		checkConflict();
    	} else if (ret==-1) {
    		msg = "Error: Invalid end time!";
    		alert(msg);
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function checkConflict()
{ 
	var onMon;
	var onTue;
	var onWed;
	var onThu;
	var onFri;
	var onSat;
	var onSun;

	startTime = $('shh').value+":"+$('smm').value+" "+$('samp').value;
	endTime   = $('ehh').value+":"+$('emm').value+" "+$('eamp').value;
	if($('onMon').checked) {
		onMon = 1;
	} else {
		onMon = 0;
	}
	if($('onTue').checked) {
		onTue = 1;
	} else {
		onTue = 0;
	}
	if($('onWed').checked) {
		onWed = 1;
	} else {
		onWed = 0;
	}
	if($('onThu').checked) {
		onThu = 1;
	} else {
		onThu = 0;
	}
	if($('onFri').checked) {
		onFri = 1;
	} else {
		onFri = 0;
	}
	if($('onSat').checked) {
		onSat = 1;
	} else {
		onSat = 0;
	}
	if($('onSun').checked) {
		onSun = 1;
	} else {
		onSun = 0;
	}
	
	get_data="schYear=" + $('schYear').value + "&startTime=" + startTime + "&endTime=" + endTime + "&onMon=" + onMon + "&onTue=" + onTue + "&onWed=" + onWed + "&onThu=" + onThu + "&onFri=" + onFri + "&onSat=" + onSat + "&onSun=" + onSun + "&room=" + $('room').value + "&action=checkconflictelem";
    ajaxQuery("modules/Schedules/scheduleHandler.php",'GET',get_data,"","onCheckConflictHandle");
}

function onCheckConflictHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret==1) {
    		//if rooom assignment is conflict;
    		alert("Conflict room assignment!");
    		// setfocus
			$('room').focus();
    		
    	} else if (ret==0) {
    		//Chek if shedCode is already exist;
    		checkDuplicate();

    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function checkDuplicate()
{
    get_data="schYear=" + $('schYear').value + "&schedCode=" + $('schedCode').value + "&action=checkduplicateelem";
    ajaxQuery("modules/Schedules/scheduleHandler.php",'GET',get_data,"","onCheckDuplicateHandle");
}

function onCheckDuplicateHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret=='') {
    		redirect('index.php?module=Schedules&action=createScheduleElem'); // redirect to entry page
    	} else {
	    	if (ret==-1) {
	    		// ID No. duplicate
           		// okay alright..
				$('frmScheduleElem').submit();

	    	} else if (ret==1) {
	    		// can't continue saving coz has no item
	    		msg="Duplicate Schedule Code.";
	    		displayError(msg);
	    	}
	    	
    	}
    }
}

function getSubjects()
{
    get_data="yrLevel=" + $('yrLevel').value + "&action=getsubjectselem";
    ajaxQuery("modules/Schedules/scheduleHandler.php",'GET',get_data,"","onGetSubjectsHandle");
}

function onGetSubjectsHandle()
{
if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		initializeCombo('subjID',"----------------------------------------------------------------------------------------------");
			myData = ret.parseJSON();
			for(c = 0; c < myData.length; c++){
		    	var y=document.createElement('option');
		    	if (myData[c].descTitle != null && myData[c].type == '2'){
		    		y.text=myData[c].subjCode+"    "+html_entity_decode(myData[c].descTitle)+ " (Lab)";
		    	} else if (myData[c].descTitle != null){
		    		y.text=myData[c].subjCode+"    "+html_entity_decode(myData[c].descTitle);
		    	} 
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

// setfocus
$('yrLevel').focus();
</script>
