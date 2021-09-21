
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


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Course");
if ($access->check_access($current_user->id,$accessCode)) {

	$course = new Course();
	$department = new Department();
	$sugar_smarty->assign('deptlist', $department->retrieveAllDepartments() );

	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;
	
	
	if ($_GET['cmdFilter']) {
		$courseCode   = $_GET['courseCode'];
		$courseName   = $_GET['courseName'];
		$deptID       = $_GET['deptID'];
	} else {
		$deptID     	= $_SESSION[$_GET['module'].'_deptID'];
		$courseCode     = $_SESSION[$_GET['module'].'_courseCode'];
		$courseName     = $_SESSION[$_GET['module'].'_courseName'];
	}
	
	//set session variables
	$_SESSION[$_GET['module'].'_deptID']      	= $deptID;
	$_SESSION[$_GET['module'].'_courseCode']    = $courseCode;
	$_SESSION[$_GET['module'].'_courseName']    = $courseName;

	if ($deptID) {
	    $conds[0]['deptID'] = " = $deptID AND ";
	}
	
	if (trim($courseCode)!='') {
	    $conds[0]['courseCode'] = " like '$courseCode%' AND ";
	}
	
	if (trim($courseName)!='') {
	    $conds[0]['courseName'] = " like '$courseName%' AND ";
	}
	
	$conds[0]['rstatus'] = "= 1 ";
	
	$allCourses = $course->retrieveAllCourses($conds);
	$list        = $course->retrieveAllCourses($conds,"courseName","ASC",$offset, $limit);

	if ($allCourses)
		$total_rec=count($allCourses);
	else 
		$total_rec=0;
		
	$main_url="index.php?module=Courses&action=listCourses&deptID=$deptID&courseCode=$courseCode&courseName=$courseName";
	
    if (!count($list)) {
    	$list = "";
    }

	$sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('departmentID', $deptID );
	$sugar_smarty->assign('courseCode', $courseCode );
	$sugar_smarty->assign('courseName', $courseName );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
	
	echo $sugar_smarty->fetch('modules/Courses/templates/listCourses.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">
$('deptID').focus();
</script>