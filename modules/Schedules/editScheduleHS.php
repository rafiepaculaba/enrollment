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
require_once('modules/Subjects/SubjectHS.php');
require_once('modules/Schedules/ScheduleHS.php');
require_once('modules/Users/User2.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit HS Schedule");
if ($access->check_access($current_user->id,$accessCode)) {
	
	$subject = new Subject();
    
	$config = new Config();
	$schedID = $_GET['schedID'];
	
	$sched = new Schedule();
	
	$sched->schedID = $schedID;
	$sched->retrieveSchedule(1); // locked
	
	$sugar_smarty->assign('schedID', $sched->schedID );
	$sugar_smarty->assign('schYear', $sched->schYear );
	$sugar_smarty->assign('yrLevel', $sched->yrLevel );
	$sugar_smarty->assign('schedCode', $sched->schedCode );
	$sugar_smarty->assign('subjID', $sched->subjID );
	$sugar_smarty->assign('profID', $sched->profID  );

	//hh-mm am/pm start time
	$stime = explode(":",$sched->startTime);
	$sugar_smarty->assign('shh', $stime[0] ) ;
	$sugar_smarty->assign('smm', $stime[1] ) ;
	$sugar_smarty->assign('samp', $stime[2] );
	
	//hh-mm am/pm end time
	$etime = explode(":",$sched->endTime);

	unset($where);
	$where[0]['yrLevel']="= $sched->yrLevel";
	$subject_list = $subject->retrieveAllSubjects($where);
	$sugar_smarty->assign('subject_list', $subject_list);
	
	$sugar_smarty->assign('ehh', $etime[0] );
	$sugar_smarty->assign('emm', $etime[1] );
	$sugar_smarty->assign('eamp', $etime[2] );
	
	$sugar_smarty->assign('onMon', $sched->onMon );
	$sugar_smarty->assign('onTue', $sched->onTue );
	$sugar_smarty->assign('onWed', $sched->onWed );
	$sugar_smarty->assign('onThu', $sched->onThu );
	$sugar_smarty->assign('onFri', $sched->onFri  );
	$sugar_smarty->assign('onSat', $sched->onSat );
	$sugar_smarty->assign('onSun', $sched->onSun );
	$sugar_smarty->assign('room', $sched->room  );
//	$sugar_smarty->assign('maxCapacity', $sched->maxCapacity );
	$sugar_smarty->assign('noEnrolled', $sched->noEnrolled );
	$sugar_smarty->assign('remarks', $sched->remarks  );
	$sugar_smarty->assign('preparedBy', $sched->preparedBy );
	$sugar_smarty->assign('rstatus', $sched->rstatus  );

	
	//User list
	$user = new User2();
	unset($where);
	$where[0]['groupID']="=7";

	$user_list = $user->retrieveAllUsers($where,'');
	$sugar_smarty->assign('user_list', $user_list);


	//school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear" >'."\n";
	$schYear.='<option value="">-----------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	    	if ($value == $sched->schYear) {
	        	$schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schYear.='</select>';
	
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);
	
    $yearLevel='<select name="yrLevel" id="yrLevel" onchange="getSubjects();">'."\n";
    $yearLevel.='<option value="">-----------------</option>'."\n";
    if ($highschool_yrs) {
        foreach ($highschool_yrs as $key=>$value) {
            if ($key==$sched->yrLevel) {
                $yearLevel .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $yearLevel .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $yearLevel.='</select>';
    $sugar_smarty->assign('YEARLEVEL', $yearLevel);
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Schedules/templates/editScheduleHS.tpl');

} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmScheduleHS','schYear', '', true, 'School Year');
addToValidate('frmScheduleHS','yrLevel', '', true, 'Year Level');
addToValidate('frmScheduleHS','subjID', '', true, 'Subject');
addToValidate('frmScheduleHS','schedCode', '', true, 'Schedule');
//addToValidate('frmScheduleHS','maxCapacity', '', true, 'Max Capacity');
addToValidate('frmScheduleHS','room', '', true, 'Room');
</script>

<script language="javascript">

function validateTime()
{
	if (check_form('frmScheduleHS')) {
		
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
    		// check if room assignment is Conflict
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
	if($('prevroom').value != $('room').value || $('prevschYear').value != $('schYear').value || Number($('prevshh').value) != $('shh').value || Number($('prevsmm').value) != $('smm').value || $('prevsamp').value != $('samp').value || Number($('prevehh').value) != $('ehh').value || Number($('prevemm').value) != $('emm').value || $('preveamp').value != $('eamp').value || $('prevonMon').value != onMon || $('prevonTue').value != onTue || $('prevonWed').value != onWed || $('prevonThu').value != onThu || $('prevonFri').value != onFri || $('prevonSat').value != onSat || $('prevonSun').value != onSun) {
		get_data="schYear=" + $('schYear').value + "&schedCode=" + $('schedCode').value + "&startTime=" + startTime + "&endTime=" + endTime + "&onMon=" + onMon + "&onTue=" + onTue + "&onWed=" + onWed + "&onThu=" + onThu + "&onFri=" + onFri + "&onSat=" + onSat + "&onSun=" + onSun + "&room=" + $('room').value + "&action=checkconflicths";
	    ajaxQuery("modules/Schedules/scheduleHandler.php",'GET',get_data,"","onCheckConflictHandle");
   	} else {
		checkDuplicate();
	}
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
	if($('prevschedCode').value != $('schedCode').value){	
	    get_data="schYear=" + $('schYear').value + "&schedCode=" + $('schedCode').value + "&action=checkduplicatehs";
	    ajaxQuery("modules/Schedules/scheduleHandler.php",'GET',get_data,"","onCheckDuplicateHandle");
	} else {
		$('frmScheduleHS').submit();
	}
}

function onCheckDuplicateHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret=='') {
    		redirect('index.php?module=Schedules&action=createScheduleHS'); // redirect to entry page
    	} else {
	    	if (ret==-1) {
	    		// ID No. duplicate
           		// okay alright..
				$('frmScheduleHS').submit();

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
    get_data="yrLevel=" + $('yrLevel').value + "&action=getsubjectsHS";
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