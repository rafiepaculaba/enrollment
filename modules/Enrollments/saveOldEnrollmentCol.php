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
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Users/User2.php');
//require_once('modules/Curriculums/Prerequisite.php');
//require_once('modules/Curriculums/CurriculumSubject.php');
//require_once('modules/Curriculums/Curriculum.php');
require_once('modules/Schedules/Schedule.php');
require_once('modules/Schedules/BlockSectionCol.php');
require_once('modules/Schedules/BlockSectionSubjectCol.php');
require_once('modules/Enrollments/OldEnrollmentDetailCol.php');
require_once('modules/Enrollments/OldEnrollmentCol.php');
require_once('modules/Grades/TOR.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL'], false);
echo "\n</p>\n";
global $theme;
global $current_user;
global $feeCodes;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['oenID'])) {
    $oenID = $_POST['oenID'];
    $enrollment = new OldEnrollment($oenID);
} else {
    $enrollment = new OldEnrollment();
}

// check if comes from correct form
if ( isset($_POST['theForm']) ) {
    
    if (isset($_POST['enID'])) {
        $enrollment->oenID = $_POST['oenID'];
    }
	
	if ($enrollment->oenID) {
	    // update existing record
	    $enrollment->schYear   = $_POST['schYear'];
    	$enrollment->semCode   = $_POST['semCode'];
    	$enrollment->idno      = $_POST['idno'];
    	//$enrollment->curID     = $_POST['curID'];
    	$enrollment->courseID  = $_POST['courseID'];
    	$enrollment->secID     = $_POST['secID'];
    	$enrollment->yrLevel   = $_POST['yrLevel'];
    	
    	$enrollment->ttlUnits  = $enrollment->getTotalUnits($_SESSION['SCHEDULES']);
    	$enrollment->lastEdited  = $_POST['lastEdited'];
	    
	    // update student record
	    if ($enrollment->updateEnrollment()) {
	        $lastID = $enrollment->oenID;
	        
	        // get all oendID to be deleted in the TOR
	        unset($conds);
	        $conds[0]['oenID'] = " = '".$enrollment->oenID."'";
    	    $enrollment->tables = "old_enrollment_details";
    	    $enrollment->conds  = $conds;
    	    
    	    // building an select query
    	    $query = $enrollment->Select();  // generate select sql query
    	    $enrollment->reset();            // reset all variables in query generator
    	 
    	    try { 
        		$enrollment->db->beginTransaction();
            	$result   = $enrollment->db->query($query);
        		$records  = $result->fetchAll(PDO::FETCH_BOTH);
        		$enrollment->db->commit();
            } catch(PDOException $e){
                $enrollment->db->rollBack();
            }
            
            if ($records) {
                $all_oendID = "";
                $ctr = 0;
                foreach ($records as $row) {
                    if ($ctr==0) {
                        $all_oendID .= $row['oendID'];
                    } else {
                        $all_oendID .= ",".$row['oendID'];
                    }
                    
                    $ctr++;
                }
            }
	        
	        // clear the shedule details
	        // setting conditions
	        unset($conds);
	        $conds[0]['oenID'] = " = '".$enrollment->oenID."'";
    	    $enrollment->tables = "old_enrollment_details";
    	    $enrollment->conds  = $conds;
    	    
    	    // building an delete query
    	    $query = $enrollment->Delete();  // generate delete sql query
    	    $enrollment->reset();            // reset all variables in query generator
    	 
    	    try { 
    		    $enrollment->db->beginTransaction();
        		$enrollment->db->exec($query);
        		$enrollment->db->commit();
        		$error=false;
            } catch(PDOException $e){
                $enrollment->db->rollBack();
                $error=true;
            }
            
            // remove the entry in the TOR
	        // setting conditions
	        unset($conds);
	        $conds[0]['oendID'] = " in ($all_oendID)";
    	    $enrollment->tables = "tor";
    	    $enrollment->conds  = $conds;
    	    
    	    // building an delete query
    	    $query = $enrollment->Delete();  // generate delete sql query
    	    $enrollment->reset();            // reset all variables in query generator
    	 
    	    try { 
    		    $enrollment->db->beginTransaction();
        		$enrollment->db->exec($query);
        		$enrollment->db->commit();
            } catch(PDOException $e){
                $enrollment->db->rollBack();
            }
            
            // save the new sets of subjects
            $enrollmentDetail = new OldEnrollmentDetail();
            
            $tor = new TOR();
    	    // get all details subjects
            foreach ($_SESSION['SCHEDULES'] as $row) {
                $enrollmentDetail->oenID  = $lastID;
                $enrollmentDetail->subjID = $row['subjID'];
                $enrollmentDetail->fgrade = $row['fgrade'];
                $enrollmentDetail->units  = $row['units'];
                $enrollmentDetail->createEnrollmentDetail();
                
                
                // get the last generated ID
                $lastDetailID = $enrollmentDetail->getLastID($lastID, $row['subjID']);
                
                // create an entry to the TOR
                $tor->idno    = $_POST['idno'];
                $tor->schYear = $_POST['schYear'];
                $tor->semCode = $_POST['semCode'];
                $tor->yrLevel = $_POST['yrLevel'];
                $tor->subjID  = $row['subjID'];
                $tor->fgrade  = $row['fgrade'];
                
                $tor->oendID  = $lastDetailID;
                
                $tor->createTOR();   
            }
            
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	    
	} else {
	    	    
	    // create new record
	    $enrollment->schYear   = $_POST['schYear'];
    	$enrollment->semCode   = $_POST['semCode'];
    	$enrollment->idno      = $_POST['idno'];
    	//$enrollment->curID     = $_POST['curID'];
    	$enrollment->courseID  = $_POST['courseID'];
    	$enrollment->yrLevel   = $_POST['yrLevel'];
    	//$enrollment->secID     = $_POST['secID'];
    	$enrollment->dateCreated = date("Y-m-d",time());
    	$enrollment->ttlUnits  = $enrollment->getTotalUnits($_SESSION['SCHEDULES']);
    	$enrollment->encodedBy = $current_user->id;
    	
    	// new student record
    	if ($enrollment->createEnrollment()) {
    	    $lastID = $enrollment->getLastID();
    	    
    	    // save the new sets of subjects
            $enrollmentDetail = new OldEnrollmentDetail();
            
            $tor = new TOR();
            // get all details subjects
            foreach ($_SESSION['SCHEDULES'] as $row) {
                $enrollmentDetail->oenID  = $lastID;
                $enrollmentDetail->subjID = $row['subjID'];
                $enrollmentDetail->fgrade = $row['fgrade'];
                $enrollmentDetail->units  = $row['units'];
                $enrollmentDetail->createEnrollmentDetail();
                
                // get the last generated ID
                $lastDetailID = $enrollmentDetail->getLastID($lastID, $row['subjID']);
                
                // create an entry to the TOR
                $tor->idno    = $_POST['idno'];
                $tor->schYear = $_POST['schYear'];
                $tor->semCode = $_POST['semCode'];
                $tor->yrLevel = $_POST['yrLevel'];
                $tor->subjID  = $row['subjID'];
                $tor->fgrade  = $row['fgrade'];
                
                $tor->oendID  = $lastDetailID;
                
                $tor->createTOR();        
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
<?php if ($oenID) { ?>
    setTimeout("redirect('index.php?module=Enrollments&action=viewOldEnrollmentCol&oenID=<?php echo $oenID; ?>')");
<?php } else { ?>
    setTimeout("redirect('index.php?module=Enrollments&action=createOldEnrollmentCol')");
<?php } ?>
</script>