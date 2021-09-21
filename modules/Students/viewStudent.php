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

require_once('config.php');
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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL'], false);
echo "\n</p>\n";
global $theme;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$config = new Config();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Col Student");
if ($access->check_access($current_user->id,$accessCode)) {
    $changed = $_GET['changed'];
    
    if($changed) {
    	$refreshit = 1;
    	$sugar_smarty->assign('refreshit', $refreshit );
    	unset($changed);
    } else {
    	$refreshit = 2;
    	$sugar_smarty->assign('refreshit', $refreshit );
    }
    
    $idno = $_GET['idno'];
    if (!$idno) {
        $msg = "Opps! no Student ID seleted.";
        $sugar_smarty->assign('class', 'errorbox');
        $sugar_smarty->assign('display', 'block');
        $sugar_smarty->assign('msg', $msg );
        echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    } else {
        
        $stud = new Student($idno);

        //        $stud->idno = $idno;
//        $stud->retrieveStudent(0); // not locked and associated

        if ( $stud->isExist($idno)==1 ) {
            $sugar_smarty->assign('recID', $stud->recID );
            $sugar_smarty->assign('idno', $stud->idno );
            $sugar_smarty->assign('regID', $stud->regID );
            $sugar_smarty->assign('fname', $stud->fname );
            $sugar_smarty->assign('lname', $stud->lname );
            $sugar_smarty->assign('mname', $stud->mname );
            
            $curriculum = new Curriculum($stud->curID);
            $sugar_smarty->assign('curName', $curriculum->curName );
            $sugar_smarty->assign('major', $curriculum->major );
            
            $sugar_smarty->assign('courseCode', $stud->courseCode );
            $sugar_smarty->assign('courseName', $stud->courseName );
            $sugar_smarty->assign('yrLevel', $stud->yrLevel );
            
            $sugar_smarty->assign('age', $stud->age );
            $sugar_smarty->assign('bday', date("F d, Y", strtotime($stud->bday)) );
            $sugar_smarty->assign('permanentAddr', $stud->permanentAddr );
            $sugar_smarty->assign('currentAddr', $stud->currentAddr );
            $sugar_smarty->assign('phone', $stud->phone );
            $sugar_smarty->assign('nationality', $stud->nationality );
            $sugar_smarty->assign('primary_edu', $stud->primary_edu );
            $sugar_smarty->assign('interm_edu', $stud->interm_edu );
            $sugar_smarty->assign('hs_edu', $stud->hs_edu );
            $sugar_smarty->assign('primary_schYear', $stud->primary_schYear );
            $sugar_smarty->assign('interm_shcYear', $stud->interm_shcYear );
            $sugar_smarty->assign('hs_schYear', $stud->hs_schYear );
            $sugar_smarty->assign('fatherName', $stud->fatherName );
            $sugar_smarty->assign('motherName', $stud->motherName );
            $sugar_smarty->assign('guardian', $stud->guardian );
            
            $sugar_smarty->assign('fatherOccupation', $stud->fatherOccupation );
            $sugar_smarty->assign('motherOccupation', $stud->motherOccupation );
            $sugar_smarty->assign('guardianOccupation', $stud->guardianOccupation );
            
            $sugar_smarty->assign('fatherContact', $stud->fatherContact );
            $sugar_smarty->assign('motherContact', $stud->motherContact );
            $sugar_smarty->assign('guardianContact', $stud->guardianContact );
            
            $sugar_smarty->assign('entryDocs', $stud->entryDocs );
            $sugar_smarty->assign('rstatus', $stud->rstatus? "Enrolled":"Not Enrolled" );
            
            if ($stud->gender == "M")
                $sugar_smarty->assign('gender', "Male");
            else if ($stud->gender == "F")
                $sugar_smarty->assign('gender', "Female");
            
            if ($stud->cstatus == "S")
                $sugar_smarty->assign('cstatus', "Single" );
            else if ($stud->cstatus == "M")
                $sugar_smarty->assign('cstatus', "Married" );
            
            // to check if the user has an access in edit
            $accessCode = $access->getAccessCode("Edit Col Student");
            $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
            
            // to check if the user has an access in delete
            $accessCode = $access->getAccessCode("Delete Col Student");
            $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );
            
            // to check if the user has an access in view TOR
            $accessCode = $access->getAccessCode("View Col TOR");
            $sugar_smarty->assign('hasViewTOR', $access->check_access($current_user->id, $accessCode) );
            
            // check for student image
            $allowed_filetypes = array('.jpg','.JPG','.JPEG','.gif','.GIF','.bmp','.BMP','.png','.BMP','.PNG');            
            $image = "uploads/".$stud->gender."_no_image.jpg";
            foreach ($allowed_filetypes as $value) {
                if (is_file("uploads/col_students/".$stud->idno.$value)) {
                    $image = "uploads/col_students/".$stud->idno.$value;
                    break;
                }	
            }
            
            $sugar_smarty->assign('image', $image );
            $sugar_smarty->assign('img_width', $config->getConfig('Image Width') );
            $sugar_smarty->assign('img_height', $config->getConfig('Image Height') );
            
            echo $sugar_smarty->fetch('modules/Students/templates/viewStudent.tpl');
        } else {
            $msg = "Student ID No. not found!";
            $sugar_smarty->assign('class', 'errorbox');
            $sugar_smarty->assign('display', 'block');
            $sugar_smarty->assign('msg', $msg );
            echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
        }
    }
} else {
    $msg = "Sorry, you dont have permission to access this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">
function deleteStudent(idno)
{
    reply=confirm("Do you really want to delete the student?");
    
    if (reply==true)
        redirect('index.php?module=Students&action=deleteStudent&idno='+idno);
}

</script>