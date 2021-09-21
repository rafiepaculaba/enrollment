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

require_once('config.php');
require_once('modules/Config/ConfigCol.php');  
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');

require_once('modules/Schedules/Schedule.php');
require_once('modules/Schedules/BlockSectionSubjectCol.php');
require_once('modules/Schedules/BlockSectionCol.php');
require_once('modules/Enrollments/EnrollmentCol.php');
require_once('modules/Enrollments/EnrollmentDetailCol.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL'], false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$config = new Config();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Col Enrollment");

if ($access->check_access($current_user->id, $accessCode)) {

    $enID = $_GET['enID'];
    
    $enrollment = new Enrollment($enID);
    $sugar_smarty->assign('enID', $enID );
    $sugar_smarty->assign('idno', $enrollment->idno );
    $sugar_smarty->assign('lname', $enrollment->lname );
    $sugar_smarty->assign('fname', $enrollment->fname );
    $sugar_smarty->assign('mname', $enrollment->mname );
    $sugar_smarty->assign('schYear', $enrollment->schYear );
    $sugar_smarty->assign('semCode', $enrollment->semCode );
    $sugar_smarty->assign('secName', $enrollment->secName );
    
    switch ($enrollment->semCode) 
    {
        case 1:
            $sugar_smarty->assign('semCode', "1st");    
            break;
        case 2:
            $sugar_smarty->assign('semCode', "2nd");
            break;
        case 4:
            $sugar_smarty->assign('semCode', "Summer");
    }
    
    $sugar_smarty->assign('courseID', $enrollment->courseID );
    $sugar_smarty->assign('courseCode', $enrollment->courseCode );
    $sugar_smarty->assign('yrLevel', $enrollment->yrLevel );
    $sugar_smarty->assign('preparedBy', $enrollment->encodedBy );
    $sugar_smarty->assign('preparedName', $enrollment->encodedName );
    $sugar_smarty->assign('rstatus', $enrollment->rstatus );
    if ($enrollment->subjs) {
        $ctr=0;
        foreach($enrollment->subjs as $row) {
            $data[$ctr]['schedCode'] = $row['sched']->schedCode;
            $data[$ctr]['subjCode'] = $row['sched']->subjCode;
            $data[$ctr]['courseCode'] = $row['sched']->courseCode;
            $data[$ctr]['time'] = date("g:i",strtotime($row['sched']->startdTime))."-".date("g:i A",strtotime($row['sched']->enddTime));
            $data[$ctr]['room'] = $row['sched']->room;
            $data[$ctr]['units'] = $row['sched']->units;
            
            // days formation
            if ($row['sched']->onMon) {
                $data[$ctr]['days']  .= "M";    
            }
            
            if ($row['sched']->onTue) {
                if ($row['sched']->onThu) {
                    $data[$ctr]['days']  .= "T";
                } else {
                    $data[$ctr]['days']  .= "Tue";
                }
            }
            
            if ($row['sched']->onWed) {
                $data[$ctr]['days']  .= "W";
            }
            
            if ($row['sched']->onThu) {
                if ($row['sched']->onTue) {
                    $data[$ctr]['days']  .= "Th";
                } else {
                    $data[$ctr]['days']  .= "Thu";
                }
            }
            
            if ($row['sched']->onFri) {
                $data[$ctr]['days']  .= "F";
            }
            
            if ($row['sched']->onSat) {
                $data[$ctr]['days']  .= "Sat";
            }
            
            if ($row['sched']->onSun) {
                $data[$ctr]['days']  .= "Sun";
            }
            
            $ctr++;
        }
    }
    
    // list for subject
    $sugar_smarty->assign('scheds', $data);
    $sugar_smarty->assign('total_units', $enrollment->getTotalUnits($data));

    // edit/withdraw only if status is 1
    // and if the schYear is the active schYear
    if ($enrollment->rstatus && ($enrollment->schYear==$config->getConfig('School Year') && $enrollment->semCode==$config->getConfig('Semester')) ) {
        // to check if the user has an access in edit
        $accessCode = $access->getAccessCode("Edit Col Enrollment");
        $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
        
        // to check if the user has an access in delete
        $accessCode = $access->getAccessCode("Withdraw Col Enrollment");
        $sugar_smarty->assign('hasWithdraw', $access->check_access($current_user->id, $accessCode) );
        
        // 1 = pending
        // 2 = validated
        // 0 = withdrawn
        
        if ($enrollment->rstatus==1) {
            // to check if the user has an access in delete
            $accessCode = $access->getAccessCode("Validate Col Enrollment");
            $sugar_smarty->assign('hasValidate', $access->check_access($current_user->id, $accessCode) );
        }
    }
    
    // to check if the user has an access in print
     if ($enrollment->rstatus>0) {
	    $accessCode = $access->getAccessCode("Print Col Study Load");
	    $sugar_smarty->assign('hasPrint', $access->check_access($current_user->id, $accessCode) );
     }
    
    echo $sugar_smarty->fetch('modules/Enrollments/templates/viewEnrollmentCol.tpl');
    
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">

function validateEnrollment(enID)
{
    redirect('index.php?module=Enrollments&action=validateEnrollmentCol&enID='+enID);
}

function withdrawEnrollment(enID)
{
    reply=confirm("Do you really want to withdraw the enrollment?");
    
    if (reply==true)
        redirect('index.php?module=Enrollments&action=withdrawEnrollmentCol&enID='+enID);
}

function deleteEnrollment(enID)
{
    reply=confirm("Do you really want to delete the enrollment?");
    
    if (reply==true)
        redirect('index.php?module=Enrollments&action=deleteEnrollmentCol&enID='+enID);
}

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=600,height=700,left = 5,top = 5');");
}

</script>
