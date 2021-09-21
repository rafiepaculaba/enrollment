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
require_once('modules/Config/ConfigElem.php');  
require_once('modules/Students/StudentElem.php');
require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleElem.php');
require_once('modules/Schedules/BlockSectionSubjectElem.php');
require_once('modules/Schedules/BlockSectionElem.php');
require_once('modules/Enrollments/EnrollmentDetailElem.php');
require_once('modules/Enrollments/EnrollmentElem.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_ELEM'], false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Elem Enrollment");

if ($access->check_access($current_user->id, $accessCode)) {

    $enID = $_GET['enID'];
    
    $enrollment = new Enrollment($enID);
    $sugar_smarty->assign('enID', $enID );
    $sugar_smarty->assign('idno', $enrollment->idno );
    $sugar_smarty->assign('lname', $enrollment->lname );
    $sugar_smarty->assign('fname', $enrollment->fname );
    $sugar_smarty->assign('mname', $enrollment->mname );
    $sugar_smarty->assign('schYear', $enrollment->schYear );
    $sugar_smarty->assign('secName', $enrollment->secName );
    
    $sugar_smarty->assign('yrLevel', $enrollment->yrLevel );
    $sugar_smarty->assign('preparedBy', $enrollment->encodedBy );
    $sugar_smarty->assign('preparedName', $enrollment->encodedName );
    $sugar_smarty->assign('rstatus', $enrollment->rstatus );

    $schedule = new Schedule($schedID);
    $subj = new Subject($schedule->subjID);
    
    if ($enrollment->subjs) {
        $ctr=0;
        $subject = new Subject();
        foreach($enrollment->subjs as $row) {
            $subject->subjID = $row['subjID'];
            $subject->retrieveSubject();
            
            $data[$ctr]['subjCode']     = $subject->subjCode;
            $data[$ctr]['descTitle']    = $subject->descTitle;
            $data[$ctr]['schedCode']    = $row['sched']->schedCode;
            $data[$ctr]['firstgrade']   = $row['firstgrade'];
            $data[$ctr]['secondgrade']  = $row['secondgrade'];
            $data[$ctr]['thirdgrade']   = $row['thirdgrade'];
            $data[$ctr]['fourthgrade']  = $row['fourthgrade'];
            $data[$ctr]['fgrade']       = $row['fgrade'];
            
            $ctr++;
        }
    }
    
    // list for subject
    $sugar_smarty->assign('scheds', $data);

    echo $sugar_smarty->fetch('modules/Grades/templates/viewStudentGradeElem.tpl');
    
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=450,left = 5,top = 5');");
}

</script>
