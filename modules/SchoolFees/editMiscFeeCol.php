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
require_once('modules/SchoolFees/MiscFeeCol.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Col School Fee");
if ($access->check_access($current_user->id,$accessCode)) {
	$miscID = $_GET['miscID'];
	
	$misc = new MiscFee();

	$misc->miscID = $miscID;
	$misc->retrieveMiscFee(1); // locked
	
	$sugar_smarty->assign('miscID', $misc->miscID );
	$sugar_smarty->assign('schYear', $misc->schYear );
	$sugar_smarty->assign('courseID', $misc->courseID );
	$sugar_smarty->assign('yrLevel', $misc->yrLevel );
	$sugar_smarty->assign('particular', $misc->particular );
	$sugar_smarty->assign('amount', $misc->amount );
		
 	//school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" disabled>'."\n";
	$schoolYear.='<option value="">-------------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	    	if ($value == $misc->schYear) {
	        	$schoolYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schoolYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schoolYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);

	$yearLevel='<select name="yrLevel" id="yrLevel" disabled>'."\n";
    $yearLevel.='<option value="">-------------------------</option>'."\n";
    if ($college_yrs) {
        foreach ($college_yrs as $key=>$value) {
            if ($key==$misc->yrLevel) {
                $yearLevel .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $yearLevel .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $yearLevel.='</select>';
    $sugar_smarty->assign('YEARLEVEL', $yearLevel);
    
	// get all courses
	$course = new Course();
	$listCourse = $course->retrieveAllCourses();
	$sugar_smarty->assign('listCourse',$listCourse);
	
	echo $sugar_smarty->fetch('modules/SchoolFees/templates/editMiscFeeCol.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmMiscFee','schYear', '', true, 'School Year');
addToValidate('frmMiscFee','courseID', '', true, 'Course');
addToValidate('frmMiscFee','particular', '', true, 'Particular');
addToValidate('frmMiscFee','amount', '', true, 'Amount');
</script>

<script language="javascript">

function onSubmit() {
	if (check_form('frmMiscFee')) {
		$('schYear').disabled = false;
		$('courseID').disabled = false;
		$('yrLevel').disabled = false;
		
		$('frmMiscFee').submit();
	}
}
$('amount').focus();
</script>
