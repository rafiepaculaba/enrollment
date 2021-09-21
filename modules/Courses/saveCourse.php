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

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

	if (isset($_POST['courseID'])) {
	    $courseID = $_POST['courseID'];
	    $course = new Course($courseID);
	} else {
	    $course = new Course();
	}
	
	// check if comes from correct form
//	if ( isset($_POST['cmdSave']) ) {
	    
	    if (isset($_POST['courseID'])) {
	        $course->courseID = $_POST['courseID'];
	    }
		
		if ($course->courseID) {
			//get ID to Display
	    	$getLastID = $course->courseID;			
		    $course->courseCode			= $_POST['courseCode'];
	        $course->deptID				= $_POST['deptID'];
	        $course->courseName         = $_POST['courseName'];
	        $course->dean    			= $_POST['dean'];
	        $course->remarks          	= $_POST['remarks'];
		    
		    // update course record
		    if ($course->updateCourse()) {
		        $msg = "Record successfully updated!";
	    		$sugar_smarty->assign('class', 'notificationbox');
		    } else {
		        $msg = "Record was not successfully updated!";
	    	    $sugar_smarty->assign('class', 'errorbox');
		    }
		} else {
		    $course->courseCode			= $_POST['courseCode'];
	        $course->deptID         	= $_POST['deptID'];
	        $course->courseName     	= $_POST['courseName'];
	        $course->remarks          	= $_POST['remarks'];
	        $course->dean          		= $_POST['dean'];
	        $course->rstatus        	= $_POST['rstatus'];
		    
		    // new course record
	    	if ($course->createCourse()) {
				// Get latest ID to Display
	    		$getLastID = $course->getLastID();
	    		$msg = "Record successfully saved!";
	    		$sugar_smarty->assign('class', 'notificationbox');
	    	} else {
	    	    $msg = "Record was not successfully saved!";
	    	    $sugar_smarty->assign('class', 'errorbox');
	    	}
		}
		
		$sugar_smarty->assign('display', 'block');
	    $sugar_smarty->assign('msg', $msg );
	    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
//	}
	
?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Courses&action=viewCourse&courseID=<?php echo $getLastID; ?>')",3000);
</script>