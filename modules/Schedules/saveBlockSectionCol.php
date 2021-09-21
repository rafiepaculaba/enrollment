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
require_once('modules/Schedules/Schedule.php');
require_once('modules/Schedules/BlockSectionSubjectCol.php');
require_once('modules/Schedules/BlockSectionCol.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['secID'])) {
    $secID = $_POST['secID'];
    $blocksection = new BlockSection($secID);
} else {
    $blocksection = new BlockSection();
}

// check if comes from correct form
if ( isset($_POST['theForm']) ) {
    
    if (isset($_POST['secID'])) {
        $blocksection->secID = $_POST['secID'];
    }
	
	if ($blocksection->secID) {
	    // update existing record
//	    $blocksection->secName    = $_POST['secName'];
//	    $blocksection->schYear    = $_POST['schYear'];
//	    $blocksection->courseID   = $_POST['courseID'];
//	    $blocksection->yrLevel    = $_POST['yrLevel'];
//	    $blocksection->semCode    = $_POST['semCode'];
	    $blocksection->remarks    = $_POST['remarks'];
	    
	    // update student record
	    if ($blocksection->updateBlockSection()) {
	        $lastID = $blocksection->secID;
	        
	        // clear the shedule details
	        // setting conditions
	        $conds[]['secID'] = " = '".$blocksection->secID."'";
    	    $blocksection->tables = "block_sections_details";
    	    $blocksection->conds  = $conds;
    	    
    	    // building an select query
    	    $query = $blocksection->Delete();  // generate delete sql query
    	    $blocksection->reset();            // reset all variables in query generator
    	 
    	    try { 
    		    $blocksection->db->beginTransaction();
        		$blocksection->db->exec($query);
        		$blocksection->db->commit();
        		$error=false;
            } catch(PDOException $e){
                $blocksection->db->rollBack();
                $error=true;
            }
            
            // save the new sets of subjects of the block section
            $blocksectionSubj = new BlockSectionSubject();
    	    // get all details subjects
            foreach ($_SESSION['SCHEDULES'] as $row) {
                $blocksectionSubj->secID   = $lastID;
                $blocksectionSubj->schedID  = $row['schedID'];
                $blocksectionSubj->createBlockSectionSubject();
            }
	        
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	} else {
	    
	    // create new record
	    $blocksection->secName    = $_POST['secName'];
	    $blocksection->schYear    = $_POST['schYear'];
	    $blocksection->courseID   = $_POST['courseID'];
	    $blocksection->yrLevel    = $_POST['yrLevel'];
	    $blocksection->semCode    = $_POST['semCode'];
	    $blocksection->remarks    = $_POST['remarks'];
	    $blocksection->preparedBy = $current_user->id;
	    
	    // new student record
    	if ($blocksection->createBlockSection()) {
    	    $lastID = $blocksection->getLastID();
    	    
    	    // save the new sets of subjects of the block section
            $blocksectionSubj = new BlockSectionSubject();
    	    // get all details subjects
            foreach ($_SESSION['SCHEDULES'] as $row) {
                $blocksectionSubj->secID   = $lastID;
                $blocksectionSubj->schedID  = $row['schedID'];
                $blocksectionSubj->createBlockSectionSubject();
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
setTimeout("redirect('index.php?module=Schedules&action=viewBlockSectionCol&secID=<?php echo $lastID; ?>')",3000);
</script>