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
require_once('modules/Students/StudentElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Account/AccountElem.php');
require_once('modules/Account/AssessmentElem.php');

require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Schedules/ScheduleElem.php');
require_once('modules/Schedules/BlockSectionSubjectElem.php');
require_once('modules/Schedules/BlockSectionElem.php');
require_once('modules/Enrollments/EnrollmentDetailElem.php');
require_once('modules/Enrollments/EnrollmentElem.php');


global $theme;  
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$assID  = $_GET['assID'];
$assessment = new Assessment($assID);
$config = new Config();

if ( $assID ) {
	
	$sugar_smarty->assign('assID', $assessment->assID );
	$sugar_smarty->assign('schYear', $assessment->schYear );
	$sugar_smarty->assign('yrLevel', $assessment->yrLevel );
	
    if ($assessment->yrLevel=='S')
	   $sugar_smarty->assign('yrLevel', "Special" );
	
	$sugar_smarty->assign('idno', $assessment->idno );
   
    if ($assessment->term==1)
        $sugar_smarty->assign('term',$assessment->term."<sup>st</sup>" );
    else if ($assessment->term==2)
        $sugar_smarty->assign('term',$assessment->term."<sup>nd</sup>" );
    else if ($assessment->term==3)            
        $sugar_smarty->assign('term',$assessment->term."<sup>rd</sup>" );
    else
        $sugar_smarty->assign('term',$assessment->term."<sup>th</sup>" );
	
	$student = new Student($assessment->idno);
	
	$sugar_smarty->assign('lname', $student->lname );
	$sugar_smarty->assign('fname', $student->fname );
	$sugar_smarty->assign('mname', $student->mname );
	$sugar_smarty->assign('courseCode', $student->courseCode );
	
	$sugar_smarty->assign('oldBalance', $assessment->oldBalance );
	$sugar_smarty->assign('tuitionFee', $assessment->tuitionFee );
	$sugar_smarty->assign('labFee', $assessment->labFee );
	$sugar_smarty->assign('regFee', $assessment->regFee );
	$sugar_smarty->assign('miscFee', $assessment->miscFee );
	$sugar_smarty->assign('addAdj', $assessment->addAdj );
	$sugar_smarty->assign('lessAdj', $assessment->lessAdj );
	$sugar_smarty->assign('totalFees', $assessment->totalFees );
	$sugar_smarty->assign('ttlPayment', $assessment->ttlPayment );
	$sugar_smarty->assign('amtPaid', $assessment->amtPaid );
	$sugar_smarty->assign('balance', $assessment->balance );
	$sugar_smarty->assign('ttlDue', $assessment->ttlDue );
	
    
    // get the enrollment data
    $enID = $assessment->getEnrollmentID();
    $enrollment = new Enrollment($enID);
    
    if ($enrollment->subjs) {
        $data_subjs = array();
        $ctr=0;
        foreach ($enrollment->subjs as $row) {
            $data_subjs[$ctr]['subjCode']=$row['sched']->subjCode;
            $data_subjs[$ctr]['units']=$row['sched']->units;
            $ctr++;
        }
    }
    
    $sugar_smarty->assign('subjects', $data_subjs );
    
	$sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
    	
	echo $sugar_smarty->fetch('modules/Account/templates/printAssessmentElem.tpl');
} else {
    $msg = "Account ID not found!";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script language="javascript">

function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}

</script>