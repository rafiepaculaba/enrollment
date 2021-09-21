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
require_once('modules/Account/AccountDetailCol.php');
require_once('modules/Account/Account.php');

global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$enID   = $_GET['enID'];

$enrollment = new Enrollment($enID);
$student = new Student($enrollment->idno);
$account = new Account($student->accID);
$config = new Config();
if ( $enID ) {
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
            $sugar_smarty->assign('semester', "1<sup>st</sup> Semester");    
            break;
        case 2:
            $sugar_smarty->assign('semester', "2<sup>nd</sup> Semester");
            break;
        case 3:
            $sugar_smarty->assign('semester', "3<sup>rd</sup> Semester");
            break;
        case 4:
            $sugar_smarty->assign('semester', "Summer");
    }
    
    
    $sugar_smarty->assign('courseID', $enrollment->courseID );
    $sugar_smarty->assign('courseCode', $enrollment->courseCode );
    $sugar_smarty->assign('yrLevel', $enrollment->yrLevel );
    $sugar_smarty->assign('preparedBy', $enrollment->encodedBy );
    $sugar_smarty->assign('preparedName', $enrollment->encodedName );
    $sugar_smarty->assign('rstatus', $enrollment->rstatus );
    if ($enrollment->subjs) {
        $ctr=0;
        $subject = new Subject();
        foreach($enrollment->subjs as $row) {
            $subject->subjID = $row['subjID'];
            $subject->retrieveSubject();
            
            $data[$ctr]['subjCode']     = $subject->subjCode;
            $data[$ctr]['descTitle']    = $subject->descTitle;
            $data[$ctr]['schedCode']    = $row['sched']->schedCode;
            $data[$ctr]['units']        = $subject->units;
            $data[$ctr]['pregrade']     = $row['pregrade'];
            $data[$ctr]['mgrade']       = $row['mgrade'];
            $data[$ctr]['prefigrade']   = $row['prefigrade'];
            $data[$ctr]['fgrade']       = $row['fgrade'];
            
            $ctr++;
        }
    }

    // list for subject
    $sugar_smarty->assign('scheds', $data);
    $sugar_smarty->assign('total_units', $enrollment->getTotalUnits($data));
    
    if ($config->getConfig('Logo')) {
    	$sugar_smarty->assign('logo', '1' );
    } else {
        $sugar_smarty->assign('logo', '0' );
    }

    $sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
	
	$sugar_smarty->assign('rundate', date("m/d/Y",time()) );

	echo $sugar_smarty->fetch('modules/Grades/templates/printStudentGradeCol.tpl');
} else {
    $msg = "Enrollment No. not found!";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}


?>


<script language="javascript">

function printNow() 
{
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}

</script>