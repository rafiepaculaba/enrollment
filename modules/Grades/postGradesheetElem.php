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
require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Students/StudentElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleElem.php');
require_once('modules/Schedules/BlockSectionElem.php');
require_once('modules/Schedules/BlockSectionSubjectElem.php');
require_once('modules/Grades/GradesheetElem.php');
require_once('modules/Grades/Form137Elem.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Post Col Grade");
if ($access->check_access($current_user->id,$accessCode)) {
    $gsID = $_GET['gsID'];
    
    $gs = new GradeSheet($gsID);
    
    if ($gs->gsID) {
        // check if record is exist
        if ( !empty($gs->schYear) ) {
            // approve gs
            $gs->rstatus = 3;
            
            if ($gs->updateGradeSheet()) {
                // get the class roster
                // get parameters
                $schedID = $gs->schedID;
                
                $tables[] = 'enrollments';
                $tables[] = 'enrollment_details';
                $tables[] = 'students';
                
                $multi_orders['students.lname'] = "ASC";
                $multi_orders['students.fname'] = "ASC";
                
                $fields['students.*']                       = "";
                $fields['enrollment_details.endID']         = "";
                $fields['enrollment_details.firstgrade']    = "";
                $fields['enrollment_details.secondgrade']   = "";
                $fields['enrollment_details.thirdgrade']    = "";
                $fields['enrollment_details.fourthgrade']   = "";
                $fields['enrollment_details.fgrade']        = "";
                
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
            	    foreach ($records as $grade) {
            	        // insert to the TOR
                        $tor = new Form137();
                        $tor->idno          = $grade['idno'];
                        $tor->endID         = $grade['endID'];
                        $tor->schYear       = $gs->schYear;
                        $tor->yrLevel       = $grade['yrLevel'];
                        $tor->subjID        = $gs->subjID;
                        $tor->units         = $gs->units;
                        $tor->firstgrade  	= $grade['firstgrade'];
                        $tor->secondgrade  	= $grade['secondgrade'];
                        $tor->thirdgrade  	= $grade['thirdgrade'];
                        $tor->fourthgrade  	= $grade['fourthgrade'];
                        $tor->fgrade        = $grade['fgrade'];
                        
                        $tor->createForm137();        
            	    }
            	}
                
                $msg = "Record successfully posted!";
        		$sugar_smarty->assign('class', 'notificationbox');
            } else {
                $msg = "Record was not successfully posted!";
        	    $sugar_smarty->assign('class', 'errorbox');
            }
        } else {
            $msg = "GradeSheet ID does not exist!";
    	    $sugar_smarty->assign('class', 'errorbox');
        }
    } else {
        $msg = "Error: No GradeSheet ID set!";
        $sugar_smarty->assign('class', 'errorbox');
    }
    
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');

} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">
setTimeout("redirect('index.php?module=Grades&action=viewGradeSheetElem&gsID=<?php echo $gsID; ?>')", 3000);
</script>