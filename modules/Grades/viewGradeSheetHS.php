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
require_once('modules/Subjects/SubjectHS.php');
require_once('modules/Students/StudentHS.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleHS.php');
require_once('modules/Schedules/BlockSectionHS.php');
require_once('modules/Schedules/BlockSectionSubjectHS.php');
require_once('modules/Grades/GradesheetHS.php');
require_once('modules/Users/User2.php');

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
$accessCode = $access->getAccessCode("View HS Grade");
if ($access->check_access($current_user->id,$accessCode)) {
    $gsID = $_GET['gsID'];
    
    $gs = new GradeSheet($gsID);
    
    $sugar_smarty->assign('gsID', $gsID);
	$sugar_smarty->assign('schYear', $gs->schYear);
	$sugar_smarty->assign('teacher', $gs->profName);
	$sugar_smarty->assign('schedCode', $gs->schedCode);
	
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
	
	
    if ($gs->rstatus<2) {
        // to check if the user has an access in edit
        $accessCode = $access->getAccessCode("Edit HS Grade");
        $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
        
        // to check if the user has an access in delete
        $accessCode = $access->getAccessCode("Delete HS Grade");
        $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );
        
        // to check if the user has an access in approval of GS
        $accessCode = $access->getAccessCode("Approve HS Grade");
        $sugar_smarty->assign('hasApprove', $access->check_access($current_user->id, $accessCode) );
    }

    if ($gs->rstatus==2) {
        
        // only principal can edit the approved GS
        $u = new User2($current_user->id);
        if ($u->groupID == 10 || $current_user->is_admin) {
            // to check if the user has an access in edit
            $accessCode = $access->getAccessCode("Edit HS Grade");
            $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );    
        }
        
        // to check if the user has an access in post of GS to TOR
        $accessCode = $access->getAccessCode("Post HS Grade");
        $sugar_smarty->assign('hasPost', $access->check_access($current_user->id, $accessCode) );
    }
    
    echo $sugar_smarty->fetch('modules/Grades/templates/viewGradeSheetHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script language="javascript">

function approveGradeSheet(gsID)
{
    reply=confirm("Do you really want to approve this grade sheet?");
    
    if (reply==true)
        redirect('index.php?module=Grades&action=approveGradesheetHS&gsID='+gsID);
}

function deleteGradeSheet(gsID)
{
    reply=confirm("Do you really want to delete this grade sheet?");
    
    if (reply==true)
        redirect('index.php?module=Grades&action=deleteGradesheetHS&gsID='+gsID);
}

function postGradeSheet(gsID)
{
    reply=confirm("Do you want to continue posting grades to the Form137?");
    
    if (reply==true)
        redirect('index.php?module=Grades&action=postGradesheetHS&gsID='+gsID);
}

</script>