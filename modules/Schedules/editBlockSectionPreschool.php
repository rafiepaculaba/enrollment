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
require_once('modules/Subjects/SubjectPreschool.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/SchedulePreschool.php');
require_once('modules/Schedules/BlockSectionSubjectPreschool.php');
require_once('modules/Schedules/BlockSectionPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_BLOCK_PRESCHOOL'], false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Preschool Block Section");

if ($access->check_access($current_user->id, $accessCode)) {

    $secID = $_GET['secID'];
    
    $blocksection = new BlockSection($secID);

    $sugar_smarty->assign('secID', $secID );
    $sugar_smarty->assign('secName', $blocksection->secName );
    $sugar_smarty->assign('schYear', $blocksection->schYear );
    $sugar_smarty->assign('courseCode', $blocksection->courseCode );
    $sugar_smarty->assign('yrLevel', $blocksection->yrLevel );
    $sugar_smarty->assign('maxCapacity', $blocksection->maxCapacity );
    $sugar_smarty->assign('remarks', $blocksection->remarks );
    $sugar_smarty->assign('preparedBy', $blocksection->preparedBy );
    $sugar_smarty->assign('preparedName', $blocksection->preparedName );
    $sugar_smarty->assign('rstatus', $blocksection->rstatus );
    
    
    $schedule = new Schedule($schedID);
    $subj = new Subject($schedule->subjID);
    
    /**
     * clear the session vars
     */    
    unset($_SESSION['SCHEDULES']);
    
    if ($blocksection->subjs) {
        $ctr=0;
        foreach($blocksection->subjs as $row) {
            
            $data = array();
            
            $schedule->schedID = $row['sched']->schedID;
            $schedule->retrieveSchedule();
            $subj->subjID = $schedule->subjID;
            $subj->retrieveSubject();
            
            $data['schedID']       = $schedule->schedID;
            $data['schedCode']     = $schedule->schedCode;
            $data['subjCode']      = $schedule->subjCode;
            $data['starttime']     = $schedule->startTime;
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
    
    // list for subject
    $sugar_smarty->assign('list', $_SESSION['SCHEDULES']);
    $sugar_smarty->assign('total_units', $blocksection->getTotalUnits($_SESSION['SCHEDULES']));
        
    $schedule = new Schedule();
    $schedList = $schedule->retrieveAllSchedules();
    $sugar_smarty->assign('schedList', $schedList);

    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear" onchange="getSchedules();" disabled>'."\n";
	$schYear.='<option value="">--------------------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	        if ($blocksection->schYear==$value) {
	           $schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$schYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);

    // to check if the user has an access in edit
    $accessCode = $access->getAccessCode("Edit HS Block Section");
    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
    
    // to check if the user has an access in delete
    $accessCode = $access->getAccessCode("Delete HS Block Section");
    $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );
    
    $yearLevel='<select name="yrLevel" id="yrLevel" >'."\n";
    $yearLevel.='<option value="">-------------------</option>'."\n";
    if ($preschool_yrs) {
        foreach ($preschool_yrs as $key=>$value) {
            if ($key==$blocksection->yrLevel) {
                $yearLevel .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $yearLevel .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $yearLevel.='</select>';
    $sugar_smarty->assign('YEARLEVEL', $yearLevel);
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Schedules/templates/editBlockSectionPreschool.tpl');
    
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
addToValidate('frmBlockSection','yrLevel', '', true, 'Grade');
addToValidate('frmBlockSection','maxCapacity', '', true, 'Maximum Capacity');
</script>

<script>
addToValidate('frmAddSchedule','schedID', '', true, 'Schedule');
</script>

<script language="javascript">

function getSchedules()
{
//    if ($('schYear').value && $('yrLevel').value) {
        get_data="schYear=" + $('schYear').value + "&yrLevel=" + $('yrLevel').value + "&action=getschedulespreschool";
        ajaxQuery("modules/Schedules/blockSectionHandler.php",'GET',get_data,"","onGetSchedulesHandle");
//    } else {
//        msg = "Required field(s)\n"
//        if ($('schYear').value=="") {
//            msg += " - School Year\n"
//        }
//        
//        if ($('yrLevel').value=="") {
//            msg += " - Year Level\n"
//        }
//        
//        alert(msg);
//    }
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
    get_data="schedID=" + $('schedID').value + "&action=checksubjectlevelpreschool";
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
    	    msg="Sorry, can't add subject not belong to the selected year level.";
    	    alert(msg);
    	}
    }
}

function onCheckConflict()
{
    get_data="schedID=" + $('schedID').value + "&action=checkconflictpreschool";
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
    get_data="schedID=" + $('schedID').value + "&action=addschedulepreschool";
    ajaxQuery("modules/Schedules/blockSectionHandler.php",'GET',get_data,"","onAddScheduleHandle");
}


function onAddScheduleHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
	    	$('divSchedules').innerHTML = ret;
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

getSchedules();

</script>
