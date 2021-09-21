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
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_CUR'], $mod_strings['LBL_MODULE_TITLE_CUR']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Curriculum");
if ($access->check_access($current_user->id,$accessCode)) {
    $curriculum = new Curriculum();
    
    $limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
    $offset = $_GET['offset']? $_GET['offset']:0;
    
    if ($_GET['cmdFilter']) {
        $curID      = trim($_GET['curID']);
        $curName    = trim($_GET['curName']);
        $courseID   = trim($_GET['courseID']);
        $effectivity= trim($_GET['effectivity']);
        $major      = trim($_GET['major']);
    } else {
        $curID      = $_SESSION[$_GET['module'].'Cur_curID'];
        $curName    = $_SESSION[$_GET['module'].'Cur_curName'];
        $courseID   = $_SESSION[$_GET['module'].'Cur_courseID'];
        $effectivity= $_SESSION[$_GET['module'].'Cur_effectivity'];
        $major      = $_SESSION[$_GET['module'].'Cur_major'];
    }
    
    // set variable session
    $_SESSION[$_GET['module'].'Cur_curID']       = $curID;
    $_SESSION[$_GET['module'].'Cur_curName']     = $curName;
    $_SESSION[$_GET['module'].'Cur_courseID']    = $courseID;
    $_SESSION[$_GET['module'].'Cur_effectivity'] = $effectivity;
    $_SESSION[$_GET['module'].'Cur_major']       = $major;
    
    if ($courseID) {
       $conds[0]['courseID'] = "= '$courseID' AND ";
    }
    
    if (trim($curID)!="") {
        $conds[0]['curID'] = "= '$curID' AND ";
    }
        
    if (trim($curName)!="") {
       $conds[0]['curName'] = " like '$curName%' AND ";
    }
    
    if (trim($effectivity)!="") {
       $conds[0]['effectivity'] = "= '$effectivity' AND ";
    }
    
    if (trim($major)!="") {
       $conds[0]['major'] = " like '$major%' AND ";
    }
    
    $conds[0]['rstatus'] = "= 1 ";
    
    $allCurriculums = $curriculum->retrieveAllCurriculums($conds);
    $list           = $curriculum->retrieveAllCurriculums($conds,"curName","ASC",$offset, $limit);
    
    if ($allCurriculums)
    	$total_rec=count($allCurriculums);
    else 
    	$total_rec=0;
    	
    $main_url="index.php?module=Curriculums&action=listCurriculums&curID=$curID&curName=$curName&courseID=$courseID&effectivity=$effectivity&major=$major";
    
    // course list
    $course = new Course();
    $sugar_smarty->assign('courseList', $course->retrieveAllCourses() );
    
    // check if the list is empty
    if (!count($list)) {
        $list = "";
    }
    
    $sugar_smarty->assign('list', $list );
    $sugar_smarty->assign('curID', $curID );
    $sugar_smarty->assign('curName', $curName );
    $sugar_smarty->assign('courseID', $courseID );
    $sugar_smarty->assign('effectivity', $effectivity );
    $sugar_smarty->assign('major', $major );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
    
    echo $sugar_smarty->fetch('modules/Curriculums/templates/listCurriculums.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script type='text/javascript'>
$('courseID').focus();
</script>