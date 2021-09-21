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
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['curID'])) {
    $curID = $_POST['curID'];
    $curriculum = new Curriculum($curID);
} else {
    $curriculum = new Curriculum();
}

// check if comes from correct form
if ( isset($_POST['theForm']) ) {
    
    if (isset($_POST['curID'])) {
        $curriculum->curID = $_POST['curID'];
    }
	
	if ($curriculum->curID) {
	    // update existing record
	    
	    $curriculum->curName      = $_POST['curName'];
	    $curriculum->courseID     = $_POST['courseID'];
	    $curriculum->effectivity  = $_POST['effectivity'];
	    $curriculum->major        = $_POST['major'];
	    $curriculum->remarks      = $_POST['remarks'];
	    
	    // update student record
	    if ($curriculum->updateCurriculum()) {
	        $lastID = $curriculum->curID;
	        
	        // clear the subject details
	        
	        // setting conditions
	        $conds[]['curID'] = " = '".$curriculum->curID."'";
    	    $curriculum->tables = "curriculum_subjs";
    	    $curriculum->conds  = $conds;
    	    
    	    // building an select query
    	    $query = $curriculum->Delete();  // generate delete sql query
    	    $curriculum->reset();            // reset all variables in query generator
    	    
    	    // clear the prerequisites
    	    $curriculum->tables = "prerequisites";
    	    $curriculum->conds  = $conds;
    	    
    	    // building an select query
    	    $query_prerequisites = $curriculum->Delete();  // generate delete sql query
    	    $curriculum->reset();  
    	    
    	    try { 
    		    $curriculum->db->beginTransaction();
        		$curriculum->db->exec($query);
        		$curriculum->db->exec($query_prerequisites);
        		$curriculum->db->commit();
        		$error=false;
            } catch(PDOException $e){
                $curriculum->db->rollBack();
                $error=true;
            }
            
            // save the new sets of subjects of the curriculum
            $curSubj = new CurriculumSubject();
    	    
    	    $total_yrLevel = 5;
    	    $total_semCode = 4;
    	    
    	    // prerequisite object
    	    $prerequisite = new Prerequisite();
    	    
    	    // get all details subjects
    	    for($i=1; $i<=$total_yrLevel; $i++) {
                for($s=1; ($s<=$total_semCode) ; $s++) {
                    if ($_SESSION['SUBJ'.$i.$s]) {
                        foreach ($_SESSION['SUBJ'.$i.$s] as $row) {
                            $curSubj->curID   = $lastID;
                            $curSubj->subjID  = $row['subjID'];
                            $curSubj->yrLevel = $row['yrLevel'];
                            $curSubj->semCode = $row['semCode'];
                            $curSubj->createCurriculumSubject();
                            
                            $prerequisites    = explode(",",$row['prerequisitesID'].",");
                            
                            if ($prerequisites) {
                                // saves all prerequisites of the subject
                                foreach ($prerequisites as $prereq) {
                                    if (trim($prereq)) {
                                        $prerequisite->curID = $lastID;
                                        $prerequisite->subjID = $curSubj->subjID;
                                        $prerequisite->preSubjID = $prereq;
                                        $prerequisite->createPrerequisite();
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
	        
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	} else {
	    
	    // create new record
	    $curriculum->curName      = $_POST['curName'];
	    $curriculum->courseID     = $_POST['courseID'];
	    $curriculum->effectivity  = $_POST['effectivity'];
	    $curriculum->major        = $_POST['major'];
	    $curriculum->remarks      = $_POST['remarks'];
	    $curriculum->preparedBy   = $current_user->id;
	    
	    // new student record
    	if ($curriculum->createCurriculum()) {
    	    $lastID = $curriculum->getLastID();
    	    
    	    
    	    $curSubj = new CurriculumSubject();
    	    
    	    $total_yrLevel = 5;
    	    $total_semCode = 4;
    	    
    	    // prerequisite object
    	    $prerequisite = new Prerequisite();
    	    
    	    // get all details subjects
    	    for($i=1; $i<=$total_yrLevel; $i++) {
                for($s=1; ($s<=$total_semCode) ; $s++) {
                    if ($_SESSION['SUBJ'.$i.$s]) {
                        foreach ($_SESSION['SUBJ'.$i.$s] as $row) {
                            $curSubj->curID   = $lastID;
                            $curSubj->subjID  = $row['subjID'];
                            $curSubj->yrLevel = $row['yrLevel'];
                            $curSubj->semCode = $row['semCode'];
                            $curSubj->createCurriculumSubject();
                            
                            $prerequisites    = explode(",",$row['prerequisitesID'].",");
                            
                            if ($prerequisites) {
                                // saves all prerequisites of the subject
                                foreach ($prerequisites as $prereq) {
                                    if (trim($prereq)) {
                                        $prerequisite->curID = $lastID;
                                        $prerequisite->subjID = $curSubj->subjID;
                                        $prerequisite->preSubjID = $prereq;
                                        $prerequisite->createPrerequisite();
                                    }
                                }
                            }
                        }
                    }
                }
            }
    	    
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
}
?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Curriculums&action=viewCurriculum&curID=<?php echo $lastID; ?>')",3000);
</script>