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
require_once('modules/Registrations/Registration.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Credited/CreditedSubject.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE'], false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Credited Subject");
if ($access->check_access($current_user->id,$accessCode)) {

	// get all default setting from configs
    $config = new Config();

	$creID = $_GET['creID'];
	
	$cre = new CreditedSubject($creID);
	$cre->creID = $creID;
	$cre->retrieveCreditedSubject(1); // locked

	$sugar_smarty->assign('creID', $cre->creID );
	$sugar_smarty->assign('idno', $cre->idno );
	$sugar_smarty->assign('schYear', $cre->schYear );
	$sugar_smarty->assign('yrLevel', $cre->yrLevel );
	$sugar_smarty->assign('semCode', $cre->semCode );
	$sugar_smarty->assign('fgrade', $cre->fgrade );
	$sugar_smarty->assign('name', $cre->studName );
	$sugar_smarty->assign('subjID', $cre->subjID );
	$sugar_smarty->assign('subjCode', $cre->subjCode );
	$sugar_smarty->assign('eqSubj', $cre->eqSubj );
	$sugar_smarty->assign('eqUnits', $cre->eqUnits );
	$sugar_smarty->assign('school', $cre->school );
	$sugar_smarty->assign('remarks', $cre->remarks );
	$sugar_smarty->assign('encodedBy', $cre->encodedBy );
	$sugar_smarty->assign('rstatus', $cre->rstatus );
	
	$semesters='<select name="semCode" id="semCode" disabled>'."\n";
    $semesters.='<option value="">-------------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$cre->semCode) {
                $semesters .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {	
                $semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $semesters.='</select>';
    $sugar_smarty->assign('SEMESTERS', $semesters);
    
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year+1; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear" disabled>'."\n";
	$schYear.='<option value="">-------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	        if ($value==$cre->schYear) {
	           $schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$schYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);

	$subject = new Subject();
	$subject_list = $subject->retrieveAllSubjects();

	$sugar_smarty->assign('subject_list', $subject_list);
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');	
	echo $sugar_smarty->fetch('modules/Credited/templates/editCreditedSubject.tpl');
	calendarSetup('date', 'jscal_trigger');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmCreditedSubject','idno', '', true, 'ID No.');
addToValidate('frmCreditedSubject','schYear', '', true, 'School Year');
addToValidate('frmCreditedSubject','yrLevel', '', true, 'Year Level');
addToValidate('frmCreditedSubject','semCode', '', true, 'Semester');
addToValidate('frmCreditedSubject','fgrade', '', true, 'Final Grade');
addToValidate('frmCreditedSubject','subjID', '', true, 'Credited Subject');
addToValidate('frmCreditedSubject','eqSubj', '', true, 'Equivalent Subject');
addToValidate('frmCreditedSubject','eqUnits', '', true, 'Equivalent Units');
addToValidate('frmCreditedSubject','school', '', true, 'School');
</script>

<script language="javascript">
function onSubmit()
{    
	if (check_form('frmCreditedSubject')) {
		$('schYear').disabled = false;
		$('semCode').disabled = false;
		$('idno').disabled = false;
		$('subjID').disabled = false;
		$('yrLevel').disabled = false;
		
		$('frmCreditedSubject').submit();
	}
}

$('fgrade').focus();
</script>
