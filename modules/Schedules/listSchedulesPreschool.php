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
require_once('modules/Schedules/SchedulePreschool.php');
require_once('modules/Users/User2.php');
require_once('modules/Config/ConfigPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Preschool Schedule");
if ($access->check_access($current_user->id,$accessCode)) {

	$sched = new Schedule();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;

	//for dynamic Fields
    $droom = 0;
    $dnoEnrolled = 0;
    $dmaxCapacity = 0;
    $dstartTime = 0;
    $dendTime = 0;
    $dremarks = 0;
    $ddays = 0;
    
	//for dynamic Fields
    $droom = 0;
    $dnoEnrolled = 0;
    $dmaxCapacity = 0;
    $dstartTime = 0;
    $dendTime = 0;
    $dremarks = 0;
    $ddays = 0;
    
    if ($_GET['cmdSelect']) {	
        foreach ($_POST['checkbox'] as $key=>$value) {
    
            if ($_POST['checkbox'][$key] == 'room') {
                $droom = 1;
            }
            if ($_POST['checkbox'][$key] == '#enrolled') {
                $dnoEnrolled = 1;
            }
            if ($_POST['checkbox'][$key] == 'maxcapacity') {
                $dmaxCapacity = 1;
            }
            if ($_POST['checkbox'][$key] == 'starttime') {
                $dstartTime = 1;
            }
            if ($_POST['checkbox'][$key] == 'endtime') {
                $dendTime = 1;
            }
            if ($_POST['checkbox'][$key] == 'remarks') {
                $dremarks = 1;
            }
            if ($_POST['checkbox'][$key] == 'days') {
                $ddays = 1;
            }
        }
    } else {
        
        $droom     		= $_SESSION[$_GET['module'].'Col_droom'];
        $dnoEnrolled    = $_SESSION[$_GET['module'].'Col_dnoEnrolled'];
        $dmaxCapacity   = $_SESSION[$_GET['module'].'Col_dmaxCapacity'];
        $dstartTime     = $_SESSION[$_GET['module'].'Col_dstartTime'];
        $dendTime     	= $_SESSION[$_GET['module'].'Col_dendTime'];
        $dremarks     	= $_SESSION[$_GET['module'].'Col_dremarks'];
        $ddays     		= $_SESSION[$_GET['module'].'Col_ddays'];
    }
   	//set session variables to dynamic fields
	$_SESSION[$_GET['module'].'Col_droom']	        = $droom;
	$_SESSION[$_GET['module'].'Col_dnoEnrolled']	= $dnoEnrolled;
	$_SESSION[$_GET['module'].'Col_dmaxCapacity']	= $dmaxCapacity;
	$_SESSION[$_GET['module'].'Col_dstartTime']	    = $dstartTime;
	$_SESSION[$_GET['module'].'Col_dendTime']	    = $dendTime;
	$_SESSION[$_GET['module'].'Col_dremarks']	    = $dremarks;
	$_SESSION[$_GET['module'].'Col_ddays']	        = $ddays;

	if ($_GET['cmdFilter']) {	
		$schYear 	= $_GET['schYear'];
		$schedCode 	= $_GET['schedCode'];
		$yrLevel 	= $_GET['yrLevel'];
		$subjID   	= $_GET['subjID'];
		$noEnrolled = $_GET['noEnrolled'];
		$profID   	= $_GET['profID'];
		$room   	= $_GET['room'];
		$rstatus   	= $_GET['rstatus'];
	} else {
		$schYear     	= $_SESSION[$_GET['module'].'Preschool_schYear'];			
		$schedCode     	= $_SESSION[$_GET['module'].'Preschool_schedCode'];			
		$yrLevel     	= $_SESSION[$_GET['module'].'Preschool_yrLevel'];			
		$subjID     	= $_SESSION[$_GET['module'].'Preschool_subjID'];			
		$noEnrolled     = $_SESSION[$_GET['module'].'Preschool_noEnrolled'];			
		$profID     	= $_SESSION[$_GET['module'].'Preschool_profID'];			
		$room  		   	= $_SESSION[$_GET['module'].'Preschool_room'];			
		$rstatus     	= $_SESSION[$_GET['module'].'Preschool_rstatus'];			
	}
	
	// get all default setting from configs
    $config = new Config();

    if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'Preschool_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }

    $user = new User2($current_user->id);
	unset($where);

	if ($user->groupID==11) {
		// the current user is a college instructor
		$where[0]['id'] = "='".$user->id."' "; // assuming 6-default groupID of College Professor
	    $sugar_smarty->assign('isPreschoolGroup', 1);
	    $profID=$user->id;
	} else {
		//User list
		$where[0]['groupID']="=8";
		$sugar_smarty->assign('isPreschoolGroup', 0);
	}
	
	$user_list = $user->retrieveAllUsers($where,'');
	$sugar_smarty->assign('user_list', $user_list);
	
	//set session variables
	$_SESSION[$_GET['module'].'Preschool_schYear']		= $schYear;
	$_SESSION[$_GET['module'].'Preschool_schedCode']		= $schedCode;
	$_SESSION[$_GET['module'].'Preschool_yrLevel']		= $yrLevel;
	$_SESSION[$_GET['module'].'Preschool_subjID']		= $subjID;
	$_SESSION[$_GET['module'].'Preschool_noEnrolled']	= $noEnrolled;
	$_SESSION[$_GET['module'].'Preschool_profID']		= $profID;
	$_SESSION[$_GET['module'].'Preschool_room']			= $room;
	$_SESSION[$_GET['module'].'Preschool_rstatus']		= $rstatus;

    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND schedules.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['schedules.schYear'] = " = '$schYear' ";
        }
    }

    if ($yrLevel) {
        if (count($conds[0])) {
            $conds[0][' AND schedules.yrLevel'] = " = '$yrLevel' ";
        } else {
            $conds[0]['schedules.yrLevel'] = " = '$yrLevel' ";
        }
    }
    
    if (trim($schedCode)!='') {
        if (count($conds[0])) {
            $conds[0][' AND schedules.schedCode'] = " = '$schedCode' ";
        } else {
            $conds[0]['schedules.schedCode'] = " = '$schedCode' ";
        }
    }

    if ($courseID) {
        if (count($conds[0])) {
            $conds[0][' AND schedules.courseID'] = " = '$courseID' ";
        } else {
            $conds[0]['schedules.courseID'] = " = '$courseID' ";
        }
    }

    if ($subjID) {
        if (count($conds[0])) {
            $conds[0][' AND schedules.subjID'] = " = '$subjID' ";
        } else {
            $conds[0]['schedules.subjID'] = " = '$subjID' ";
        }
    }

    if ($profID) {
        if (count($conds[0])) {
            $conds[0][' AND schedules.profID'] = " = '$profID' ";
        } else {
            $conds[0]['schedules.profID'] = " = '$profID' ";
        }
    }

    if (trim($room)!='') {
        if (count($conds[0])) {
            $conds[0][' AND schedules.room'] = " = '$room' ";
        } else {
            $conds[0]['schedules.room'] = " = '$room' ";
        }
    }
    
    if (trim($rstatus)!='') {
        if (count($conds[0])) {
            $conds[0][' AND schedules.rstatus'] = " = '$rstatus' ";
        } else {
            $conds[0]['schedules.rstatus'] = " = '$rstatus' ";
        }
    }

    if (trim($noEnrolled)) {
        if (count($conds[0])) {
            $conds[0][' AND schedules.noEnrolled'] = " = '$noEnrolled' ";
        } else {
            $conds[0]['schedules.noEnrolled'] = " = '$noEnrolled' ";
        }
    }

	
//	$allSchedules = $sched->retrieveAllSchedulesAssociated($conds);
	$allSchedules = $sched->countAllSchedulesAssociated($conds);
	$list        = $sched->retrieveAllSchedulesAssociated($conds,"schedCode","ASC",$offset, $limit);
		
//	if ($allSchedules)
//		$total_rec=count($allSchedules);
//	else 
//		$total_rec=0;
	
	$total_rec=$allSchedules;	
		
	$main_url="index.php?module=Schedules&action=listSchedulesPreschool&schYear=$schYear&yrLevel=$yrLevel&schedCode=$schedCode&subjID=$subjID&noEnrolled=$noEnrolled&profID=$profID&rstatus=$rstatus";

    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year+1; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" >'."\n";
	$schoolYear.='<option value="">---------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	    	if ($value == $schYear) {
	        	$schoolYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schoolYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schoolYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);

	$yearLevel='<select name="yrLevel" id="yrLevel" onchange="getSubjects();">'."\n";
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
	
	$subj = new Subject();
    $sugar_smarty->assign('subjlist', $subj->retrieveAllSubjects() );

	if (!count($list)) {
    	$list = "";
    }

   	// for printing query settings
    $_SESSION['PRINT_CONDS'] = $conds;
    $_SESSION['PRINT_OFFSET'] = $offset;
    //$_SESSION['PRINT_LIMIT'] = $limit;

    //for printable version
    $print_link = "index.php?module=Schedules&action=printSchedulesPreschool&schYear=$schYear&droom=$droom&dnoEnrolled=$dnoEnrolled&dmaxCapacity=$dmaxCapacity&dstartTime=$dstartTime&dendTime=$dendTime&dremarks=$dremarks&ddays=$ddays&sugar_body_only=1";

    //Assignment for dynamic Fields
    $sugar_smarty->assign('droom', $droom );
    $sugar_smarty->assign('dnoEnrolled', $dnoEnrolled );
    $sugar_smarty->assign('dmaxCapacity', $dmaxCapacity );
    $sugar_smarty->assign('dstartTime', $dstartTime );
    $sugar_smarty->assign('dendTime', $dendTime );
    $sugar_smarty->assign('dremarks', $dremarks );
    $sugar_smarty->assign('ddays', $ddays );

    $sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('schYear', $schYear );
	$sugar_smarty->assign('yrLevel', $yrLevel );
	$sugar_smarty->assign('schedCode', $schedCode );
	$sugar_smarty->assign('subjID', $subjID );
	$sugar_smarty->assign('noEnrolled', $noEnrolled );
	$sugar_smarty->assign('profID', $profID );
	$sugar_smarty->assign('room', $room );
	$sugar_smarty->assign('rstatus', $rstatus );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit,$export_link,$print_link) );

	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Schedules/templates/listSchedulesPreschool.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">
function getSubjects()
{
    get_data="yrLevel=" + $('yrLevel').value + "&action=getsubjectsPreschool";
    ajaxQuery("modules/Schedules/scheduleHandler.php",'GET',get_data,"","onGetSubjectsHandle");
}

function onGetSubjectsHandle()
{
if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		initializeCombo('subjID',"------------------------------");
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

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=500,left = 0,top = 0');");
}

function hideShowSubject(divName)
{
    if ( $(divName).style.display=="Block" || $(divName).style.display=="block" ) {
        $(divName).style.display="None";
        $(divName+"Handle").src="themes/Sugar/images/advanced_search.gif";
        $(divName+"Handle2").src="themes/Sugar/images/advanced_search.gif";
    } else {
        $(divName).style.display="Block";
        $(divName+"Handle").src="themes/Sugar/images/basic_search.gif";
        $(divName+"Handle2").src="themes/Sugar/images/basic_search.gif";
    }
}

// setfocus
$('yrLevel').focus();
// hide first the add subject
hideShowSubject('divSubject');
</script>
