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
$accessCode = $access->getAccessCode("View Credited Subject");
if ($access->check_access($current_user->id,$accessCode)) {

	$creID = $_GET['creID'];
	$cre = new CreditedSubject($creID);

	switch ($cre->semCode) {
		case 1 :
			$semCode = "1st Sem" ;
			break;
		case 2 :
			$semCode = "2nd Sem" ;
			break;
		case 4 :
			$semCode = "Summer" ;
			break;
	}

	if ( $creID ) {
	$sugar_smarty->assign('creID', $cre->creID );
	$sugar_smarty->assign('idno', $cre->idno );
	$sugar_smarty->assign('studName', $cre->studName );
	$sugar_smarty->assign('schYear', $cre->schYear );
	$sugar_smarty->assign('yrLevel', $cre->yrLevel );
	$sugar_smarty->assign('semCode', $semCode );
	$sugar_smarty->assign('fgrade', $cre->fgrade );
	$sugar_smarty->assign('subjID', $cre->subjID );
	$sugar_smarty->assign('subjCode', $cre->subjCode );
	$sugar_smarty->assign('eqSubj', $cre->eqSubj );
	$sugar_smarty->assign('eqUnits', $cre->eqUnits );
	$sugar_smarty->assign('school', $cre->school );
	$sugar_smarty->assign('remarks', $cre->remarks );

	$sugar_smarty->assign('studName', $cre->studName );
	
	// to check if the user has an access in edit
    $accessCode = $access->getAccessCode("Edit Credited Subject");
    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );

	// to check if the user has an access in cancel
    $accessCode = $access->getAccessCode("Delete Credited Subject");
    $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );
    
    echo $sugar_smarty->fetch('modules/Credited/templates/viewCreditedSubject.tpl');
	} else {
	    $msg = "Payment ID not found!";
	    $sugar_smarty->assign('class', 'errorbox');
	    $sugar_smarty->assign('display', 'block');
	    $sugar_smarty->assign('msg', $msg );
	    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	}
	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script language="javascript">
function deleteCreditedSubject(creID)
{
    reply=confirm("Do you really want to delete the Credited Subject?");

    if (reply==true)
        redirect('index.php?module=Credited&action=deleteCreditedSubject&creID='+creID);
}
</script>