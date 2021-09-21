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
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_CUR'], $mod_strings['LBL_MODULE_TITLE_CUR']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Curriculum");

if ($access->check_access($current_user->id, $accessCode)) {

    $curID = $_GET['curID'];
    
    if (!$curID) {
        $msg = "Opps! no Curriculum ID seleted.";
        $sugar_smarty->assign('class', 'errorbox');
        $sugar_smarty->assign('display', 'block');
        $sugar_smarty->assign('msg', $msg );
        echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    } else {
        $curriculum = new Curriculum($curID);
        
        $sugar_smarty->assign('curID', $curID );
        $sugar_smarty->assign('curName', $curriculum->curName );
        $sugar_smarty->assign('courseID', $curriculum->courseID );
        $sugar_smarty->assign('courseCode', $curriculum->courseCode );
        $sugar_smarty->assign('effectivity', $curriculum->effectivity );
        $sugar_smarty->assign('major', $curriculum->major );
        $sugar_smarty->assign('remarks', $curriculum->remarks );
        // list for subject
        $sugar_smarty->assign('subj11', $curriculum->subjects11 );
        $sugar_smarty->assign('subj11_ctr', count($curriculum->subjects11) );
        $sugar_smarty->assign('subj11_total', $curriculum->getTotalUnits($curriculum->subjects11) );
        $sugar_smarty->assign('subj12', $curriculum->subjects12 );
        $sugar_smarty->assign('subj12_ctr', count($curriculum->subjects12) );
        $sugar_smarty->assign('subj12_total', $curriculum->getTotalUnits($curriculum->subjects12) );
        $sugar_smarty->assign('subj14', $curriculum->subjects14 );
        $sugar_smarty->assign('subj14_ctr', count($curriculum->subjects14) );
        $sugar_smarty->assign('subj14_total', $curriculum->getTotalUnits($curriculum->subjects14) );

        $sugar_smarty->assign('subj21', $curriculum->subjects21 );
        $sugar_smarty->assign('subj21_ctr', count($curriculum->subjects21) );
        $sugar_smarty->assign('subj21_total', $curriculum->getTotalUnits($curriculum->subjects21) );
        $sugar_smarty->assign('subj22', $curriculum->subjects22 );
        $sugar_smarty->assign('subj22_ctr', count($curriculum->subjects22) );
        $sugar_smarty->assign('subj22_total', $curriculum->getTotalUnits($curriculum->subjects22) );
        $sugar_smarty->assign('subj24', $curriculum->subjects24 );
        $sugar_smarty->assign('subj24_ctr', count($curriculum->subjects24) );
        $sugar_smarty->assign('subj24_total', $curriculum->getTotalUnits($curriculum->subjects24) );

        $sugar_smarty->assign('subj31', $curriculum->subjects31 );
        $sugar_smarty->assign('subj31_ctr', count($curriculum->subjects31) );
        $sugar_smarty->assign('subj31_total', $curriculum->getTotalUnits($curriculum->subjects31) );
        $sugar_smarty->assign('subj32', $curriculum->subjects32 );
        $sugar_smarty->assign('subj32_ctr', count($curriculum->subjects32) );
        $sugar_smarty->assign('subj32_total', $curriculum->getTotalUnits($curriculum->subjects32) );
        $sugar_smarty->assign('subj34', $curriculum->subjects34 );
        $sugar_smarty->assign('subj34_ctr', count($curriculum->subjects34) );
        $sugar_smarty->assign('subj34_total', $curriculum->getTotalUnits($curriculum->subjects34) );
        
        $sugar_smarty->assign('subj41', $curriculum->subjects41 );
        $sugar_smarty->assign('subj41_ctr', count($curriculum->subjects41) );
        $sugar_smarty->assign('subj41_total', $curriculum->getTotalUnits($curriculum->subjects41) );
        $sugar_smarty->assign('subj42', $curriculum->subjects42 );
        $sugar_smarty->assign('subj42_ctr', count($curriculum->subjects42) );
        $sugar_smarty->assign('subj42_total', $curriculum->getTotalUnits($curriculum->subjects42) );
        $sugar_smarty->assign('subj44', $curriculum->subjects44 );
        $sugar_smarty->assign('subj44_ctr', count($curriculum->subjects44) );
        $sugar_smarty->assign('subj44_total', $curriculum->getTotalUnits($curriculum->subjects44) );
        
        $sugar_smarty->assign('subj51', $curriculum->subjects51 );
        $sugar_smarty->assign('subj51_ctr', count($curriculum->subjects51) );
        $sugar_smarty->assign('subj51_total', $curriculum->getTotalUnits($curriculum->subjects51) );
        $sugar_smarty->assign('subj52', $curriculum->subjects52 );
        $sugar_smarty->assign('subj52_ctr', count($curriculum->subjects52) );
        $sugar_smarty->assign('subj52_total', $curriculum->getTotalUnits($curriculum->subjects52) );
        $sugar_smarty->assign('subj54', $curriculum->subjects54 );
        $sugar_smarty->assign('subj54_ctr', count($curriculum->subjects54) );
        $sugar_smarty->assign('subj54_total', $curriculum->getTotalUnits($curriculum->subjects54) );
    
        // to check if the user has an access in edit
        $accessCode = $access->getAccessCode("Edit Curriculum");
        $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
        
        // to check if the user has an access in delete
        $accessCode = $access->getAccessCode("Delete Curriculum");
        $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );
        
        
        echo $sugar_smarty->fetch('modules/Curriculums/templates/viewCurriculum.tpl');
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

function deleteCurriculum(curID)
{
    reply=confirm("Do you really want to delete the curriculum?");
    
    if (reply==true)
        redirect('index.php?module=Curriculums&action=deleteCurriculum&curID='+curID);
}

function hideShowDiv(divName)
{
    if ( $(divName).style.display=="Block" || $(divName).style.display=="block" ) {
        $(divName).style.display="None";
        $(divName+"Handle").src="themes/Sugar/images/advanced_search.gif";
    } else {
        $(divName).style.display="Block";
        $(divName+"Handle").src="themes/Sugar/images/basic_search.gif";
    }
}

</script>
