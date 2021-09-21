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
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Assign Preschool Lab Fee");
if ($access->check_access($current_user->id,$accessCode)) {

	// get all default setting from configs
	$config = new Config();

	// get the default schYear
	$schYear = $config->getConfig('School Year');

	//school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" onchange="selectSchedule();">'."\n";
	$schoolYear.='<option value="">------------------------------</option>'."\n";
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
	
	$sched = new Schedule();
	
    $tables[] = 'subjects';
    $tables[] = 'schedules';
    
    $multi_orders['schedules.schedCode'] = "ASC";
    
    $fields['schedules.*']               = "";
    
    $where[0]['schedules.subjID']    = "=subjects.subjID AND ";
    $where[0]['schedules.labFee']    = " <= '0' AND ";
    $where[0]['subjects.type']        	= "=2"; //Laboratory Subject
    
    $sched->tables = $tables;
    $sched->fields = $fields;
    $sched->conds  = $where;
    $sched->order  = $orderby;
    $sched->multi_orders = $multi_orders;

    // building an select query
    $query = $sched->Select();  // generate delete sql query
    $sched->reset();            // reset all variables in query generator

	try {
	    $sched->db->beginTransaction();
    	$result   = $sched->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$sched->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error.";
	}
	
	
	$sugar_smarty->assign('sched_list', $records );

	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/SchoolFees/templates/assignLabFeePreschool.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmLabFeePreschool','schYear', '', true, 'School Year');
addToValidate('frmLabFeePreschool','schedID', '', true, 'Sched Code');
addToValidate('frmLabFeePreschool','amount', '', true, 'Amount');
</script>

<script language="javascript">
function saveLabFee()
{
	if (check_form('frmLabFeePreschool')) {
		$('frmLabFeePreschool').submit();
	}
}

function selectSchedule()
{
	initializeCombo('schedID',"------------------------------");
    if ($('schYear').value != '') {
    	
    	//clearing Shedule details
    	$('yrLevel').value = '';
    	$('subjCode').value = '';
    	$('profName').value = '';
    	$('maxCapacity').value = '';
    	$('room').value = '';
    	$('days').value = '';
    	$('time').value = '';
    	$('remarks').value = '';
    	
        get_data="schYear=" + $('schYear').value + "&action=selectschedulepreschool";
        ajaxQuery("modules/SchoolFees/schoolfeeHandler.php",'GET',get_data,"","selectScheduleHandle");
    } else if ($('schYear').value == '') {

    	$('schedID').value = '';
    	//clearing Shedule details
    	$('yrLevel').value = '';
    	$('subjCode').value = '';
    	$('profName').value = '';
    	$('maxCapacity').value = '';
    	$('room').value = '';
    	$('days').value = '';
    	$('time').value = '';
    	$('remarks').value = '';
    	
    }
    
}

function selectScheduleHandle()
{
if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		initializeCombo('schedID',"------------------------------");
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

function displaySchedule()
{
    if ($('schYear').value != '') {
        get_data="schedID=" + $('schedID').value + "&action=displayschedulepreschool";
        ajaxQuery("modules/SchoolFees/schoolfeeHandler.php",'GET',get_data,"","displayScheduleHandle");
    }
}

function displayScheduleHandle()
{
if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
			myData = ret.parseJSON();

			$('yrLevel').value 			= myData[0].yrLevel;
			$('subjCode').value 		= myData[0].subjCode;
			$('profName').value 		= myData[0].profName;
			$('maxCapacity').value 		= myData[0].maxCapacity;
			$('room').value 			= myData[0].room;
			
			
			var amplitude = '';
			var time = '';
			stime = myData[0].startTime.split(":");
			if (stime[0] < 12) {
				amplitude = " AM";
			} else {
				if (stime[0] == 12) {
					
				} else {
					stime[0] -= 12;
				}
				
				amplitude = " PM";
			}
			
			time 			= stime[0] + ":" + stime[1] + amplitude;
			
			etime = myData[0].endTime.split(":");
			
			if (etime[0] < 12) {
				amplitude = " AM";
			} else {
				if (etime[0] == 12) {
					
				} else {
					etime[0] -= 12;
				}
				
				amplitude = " PM";
			}
			
			$('time').value 			= time + " - " +etime[0] + ":" + etime[1] + amplitude;
			
			
			var Days = '';
			if (myData[0].onMon == 1){
				Days = Days + 'M';
			}
			if (myData[0].onTue == 1){
				Days = Days + 'T';
			}
			if (myData[0].onWed == 1){
				Days = Days + 'W';
			}
			if (myData[0].onThu == 1){
				Days = Days + 'Th';
			}
			if (myData[0].onFri == 1){
				Days = Days + 'F';
			}
			if (myData[0].onSat == 1){
				Days = Days + 'Sa';
			}
			if (myData[0].onSun == 1){
				Days = Days + 'Su';
			}			
			
			$('days').value 			= Days;
			//$('units').value 			= myData[0].units;
			$('remarks').value 			= myData[0].remarks;
			$('amount').focus();
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

$('schedID').focus();
</script>