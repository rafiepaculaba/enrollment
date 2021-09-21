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
require_once('modules/Config/ConfigElem.php');
require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Students/StudentElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleElem.php');
require_once('modules/Schedules/BlockSectionElem.php');
require_once('modules/Schedules/BlockSectionSubjectElem.php');
require_once('modules/Enrollments/EnrollmentDetailElem.php');
require_once('modules/Enrollments/EnrollmentElem.php');

require_once('modules/Grades/GradesheetElem.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

// get all posted data
$profID  = $_POST['profID'];
$schedID = $_POST['schedID'];
$schYear = $_POST['schYear'];
$units   = $_POST['units'];
$remarks = $_POST['remarks'];

$gsID    = $_POST['gsID'];

$gs = new GradeSheet();

// check if comes from correct form
if ( $_POST['theForm']=="gradesheet" ) {
    $error="";
    
    if (!$gsID) {
        if (!$gs->isExist($schYear, $schedID, $profID)) {
            // new gradesheet header
            $gs->schYear = $schYear;
            $gs->profID  = $profID;
            $gs->schedID = $schedID;
            $gs->units   = $units;
            $gs->remarks = $remarks;
            
            if ($gs->createGradeSheet()) {
                $lastID = $gs->getLastID($schYear, $schedID, $profID);
                $error = 0;
            } else {
                $error = 1;
            }
        }
    } else {
        $lastID = $gsID;
        $error = 0;
    }
    
    if (!$error) {
        
        $tables[] = 'enrollments';
        $tables[] = 'enrollment_details';
        $tables[] = 'students';
        
        $multi_orders['students.lname'] = "ASC";
        $multi_orders['students.fname'] = "ASC";
        
        $fields['students.*']                = "";
        $fields['enrollment_details.endID']  = "";
        $fields['enrollment_details.firstgrade'] = "";
        $fields['enrollment_details.secondgrade'] = "";
        $fields['enrollment_details.thirdgrade'] = "";
        $fields['enrollment_details.fourthgrade'] = "";
        $fields['enrollment_details.fgrade'] = "";
        
        $where[0]['enrollment_details.schedID'] = "='$schedID' AND ";
        $where[0]['enrollment_details.enID']    = "=enrollments.enID AND ";
        $where[0]['enrollments.idno']           = "=students.idno";
        
        $gs->tables = $tables;
        $gs->fields = $fields;
        $gs->conds  = $where;
        $gs->order  = $orderby;
        $gs->multi_orders = $multi_orders;
                
        // building an select query
        $query = $gs->Select();  // generate delete sql query
        $gs->reset();            // reset all variables in query generator
        
    	try {
    	    $gs->db->beginTransaction();
        	$result   = $gs->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$gs->db->commit();
    	} catch (PDOException $e) {
    	    echo "SQL query error.";
    	}
    	
    	if ($records) {
    	    $enrollmentDetail = new EnrollmentDetail();
    	    foreach ($records as $stud) {
    	        $enrollmentDetail->endID = $stud['endID'];
    	        $enrollmentDetail->retrieveEnrollmentDetail();
    	        
    	        // update fgrades
    	        $enrollmentDetail->firstgrade=$_POST['studfirst'.$stud['recID']];
    	        $enrollmentDetail->secondgrade=$_POST['studsecond'.$stud['recID']];
    	        $enrollmentDetail->thirdgrade=$_POST['studthird'.$stud['recID']];
    	        $enrollmentDetail->fourthgrade=$_POST['studfourth'.$stud['recID']];
    	        $enrollmentDetail->fgrade=$_POST['stud'.$stud['recID']];
    	        
    	        $enrollmentDetail->updateEnrollmentDetail();
    	    }
    	}
    	
        
        // new department record
    	//if (!$gs->isExist($schYear, $semCode, $schedID, $profID)) {
    	if (!$gsID) {
    		$msg = "Grade Sheet successfully saved!";
    		$sugar_smarty->assign('class', 'notificationbox');
    	} else {
    	    $msg = "Grade Sheet successfully updated!";
    	    $sugar_smarty->assign('class', 'notificationbox');
    	}
	
    } else {
        $msg = "Grade Sheet was not successfully saved!";
	    $sugar_smarty->assign('class', 'errorbox');
    }

	
	$sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Grades&action=viewGradeSheetElem&gsID=<?php echo $lastID; ?>')",3000);
</script>