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

echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$sugar_smarty = new Sugar_Smarty();

$schedID = $_GET['schedID'];

$config = new Config();
$sched = new Schedule($schedID);

    
    $sugar_smarty->assign('schedID', $schedID);
	$sugar_smarty->assign('schYear', $sched->schYear);
	$sugar_smarty->assign('instructor', $sched->profName);
	$sugar_smarty->assign('schedCode', $sched->schedCode);
	
	$subject = new Subject($sched->subjID);
	
	$sugar_smarty->assign('subject', $subject->subjCode." - ".$subject->descTitle);
	$sugar_smarty->assign('units', $subject->units);
	$sugar_smarty->assign('remarks', $sched->remarks);
	
	if ($sched->rstatus==1) {
	    $sugar_smarty->assign('status', "Pending");
	} else if ($sched->rstatus==2) {
	    $sugar_smarty->assign('status', "Approved");
	} else if ($sched->rstatus==3) {
	    $sugar_smarty->assign('status', "Posted");
	}
	
	$schedule = new Schedule($sched->schedID);
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
    $schedID = $sched->schedID;
    
    $tables[] = 'enrollments';
    $tables[] = 'enrollment_details';
    $tables[] = 'students';
    
    $multi_orders['students.lname'] = "ASC";
    $multi_orders['students.fname'] = "ASC";
    
    $fields['students.*']                = "";
    $fields['enrollment_details.endID']  = "";
    $fields['enrollment_details.fgrade'] = "";
    
    $where[0]['enrollment_details.schedID'] = "='$schedID' AND ";
    $where[0]['enrollment_details.enID']    = "=enrollments.enID AND ";
    $where[0]['enrollments.idno']           = "=students.idno AND ";    
    $where[0]['enrollments.rstatus']        = " = '2'"; // validated

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

	$sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );

	$sugar_smarty->assign('list', $records );
	

    if ($sched->rstatus==2) {
        // to check if the user has an access in post of Class Roster to TOR
        $accessCode = $access->getAccessCode("Post Col Class Roster");
        $sugar_smarty->assign('hasPost', $access->check_access($current_user->id, $accessCode) );
    }

echo $sugar_smarty->fetch('modules/Reports/templates/classRosterElem.tpl');
?>

<script>
addToValidate('frmCurriculum','courseID', '', true, 'Course');
addToValidate('frmCurriculum','curName', '', true, 'Curriculum Name');
addToValidate('frmCurriculum','effectivity', '', true, 'Effectivity Year');
</script>

<script language="javascript">
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}

</script>
