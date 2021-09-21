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
require_once('modules/Grades/TOR.php');
require_once('modules/Schedules/Schedule.php');
require_once('modules/Enrollments/EnrollmentCol.php');
require_once('modules/Enrollments/EnrollmentDetailCol.php');

require_once('modules/Enrollments/OldEnrollmentCol.php');
require_once('modules/Enrollments/OldEnrollmentDetailCol.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL'], false);
echo "\n</p>\n";
global $theme;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Col TOR");
if ($access->check_access($current_user->id,$accessCode)) {
    $idno = $_GET['idno'];
    if (!$idno) {
        $msg = "Opps! no Student ID seleted.";
        $sugar_smarty->assign('class', 'errorbox');
        $sugar_smarty->assign('display', 'block');
        $sugar_smarty->assign('msg', $msg );
        echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    } else {
        
         $student  = new Student($idno);
        
        $sugar_smarty->assign('subjects', $data );
        $sugar_smarty->assign('body', getTOR($idno) );
        
        $sugar_smarty->assign('idno', $idno );
        $sugar_smarty->assign('name', $student->lname.", ".$student->fname." ".$student->mname );
        $sugar_smarty->assign('courseName', $student->courseName );
        
        echo $sugar_smarty->fetch('modules/Students/templates/viewTOR.tpl');
    }
} else {
    $msg = "Sorry, you dont have permission to access this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}



function getTOR($idno)
{
    // get all failing grades
    $config = new Config();
    $tor    = new TOR();
    
    $failed_grades = $config->getConfig('Failed Grades');
    $failed_grades = explode("," , $failed_grades);
    
    if ($failed_grades) {
        $data = array();
        foreach ($failed_grades as $grade) {
            $data[]=strtoupper(trim($grade));
        }
        
        $failed_grades = $data;
    }
    
    
    $enrollment = new Enrollment();
    $enDetail   = new EnrollmentDetail();
    $subject    = new Subject();
    
    $oenrollment = new OldEnrollment();
    $oenDetail   = new OldEnrollmentDetail();
    

/*************************************** start of old enrollment *********************************/
    unset($where);
    unset($multiOrder);
    unset($tables);
    unset($flds);
    
    $ttl_units = 0;
    $output="";
    
    // building an select query
	$multiOrder['old_enrollments.schYear'] = "ASC";
	$multiOrder['old_enrollments.semCode'] = "ASC";
	
	$enrollment->multi_orders = $multiOrder;
	
	$tables[] = "old_enrollments";
	$tables[] = "courses";
	
	$where[0]['old_enrollments.idno'] = "= '$idno'";
    $where[0]['AND old_enrollments.courseID'] = "= courses.courseID ";
    $where[0]['AND old_enrollments.rstatus'] = "= 1 ";
    

	$flds['old_enrollments.*']  = "";
	$flds['courses.courseCode'] = "";
	
    $enrollment->tables = $tables;
    $enrollment->fields = $flds;
    $enrollment->conds  = $where;
    
    $enrollment->offset = $offset;
    $enrollment->limit  = $limit;
    $enrollment->lock   = 0;

    // building an select query
    $query = $enrollment->Select();  // generate delete sql query
    $enrollment->reset();            // reset all variables in query generator
    
	try {
	    $enrollment->db->beginTransaction();
    	$result   = $enrollment->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$enrollment->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error.";
	}

	if ($records) {
//            $output .= "<tr><td colspan='4' class='evenListRowS1' align='center'> <h3>Old Records</h3></td></tr>";
        foreach ($records as $row) {
            
            $output .= "<tr height='20'>";
        	
            // course and yr
            $output .= "   <td scope='row' class='evenListRowS1' bgcolor='#fdfdfd' align='left' valign='top'>";
            $output .= "<b><u>".$row['courseCode']."-".$row['yrLevel']."</u></b>";
            $output .= "   </td>";
            
            // school year and semester
            $output .= "   <td scope='row' class='evenListRowS1' bgcolor='#fdfdfd' align='left' valign='top'>";
            
            $schYear = $row['schYear'];
            if ($row['semCode']=='1') {
                $semester = "1<sup>st</sup> &nbsp;Semester";
            } else if ($row['semCode']=='2') {
                $semester = "2<sup>nd</sup> &nbsp;Semester";
            } else if ($row['semCode']=='3') {
                $semester = "3<sup>rd</sup> &nbsp;Semester";
            } else if ($row['semCode']=='4') {
                $semester = "Summer";
                
                $schYears = explode("-",$row['schYear']);
                
                $schYear  = $schYears[1];
            }
            
            $output .= "<b><u>".$semester." - ".$schYear."</u></b>";
            $output .= "   </td>";
            
             // blank
            $output .= "   <td scope='row' class='evenListRowS1' bgcolor='#fdfdfd' align='left' valign='top'>";
            $output .= "&nbsp;";
            $output .= "   </td>";
            
            // blank
            $output .= "   <td scope='row' class='evenListRowS1' bgcolor='#fdfdfd' align='left' valign='top'>";
            $output .= "&nbsp;";
            $output .= "   </td>";
            
        	$output .= "</tr>";
//        	$output .= "<tr><td colspan='20' class='listViewHRS1'></td></tr>";
        	
        	unset($where);
        	$where[0]['oenID']="='".$row['oenID']."'";
        	
        	$subjects = $oenDetail->retrieveAllEnrollmentDetails($where);
            
        	if ($subjects) {
        	    $ctr = 0;
        	    foreach ($subjects as $subj) {
        	        $subject->subjID = $subj['subjID'];
        	        $subject->retrieveSubject();
                	
                    $output .= "<tr onmouseover=\"setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');\" onmouseout=\"setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');\" onmousedown=\"setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');\" height='20'>";
                    
                    // subject code
                	$output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    $output .= $subject->subjCode;
                    $output .= "    </td>";
                    
                    // descriptive title
                    $output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    $output .= $subject->descTitle;
                    $output .= "    </td>";
                    
                    // final grade
                    $output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    
                    // check for failing grades - no units earn if failed grades
                    if ($subj['tor_grade']) {
                        if (in_array($subj['tor_grade'],$failed_grades)) {
                            if (is_numeric($subj['tor_grade'])) 
                                $output .= "<font color='red'>".number_format($subj['tor_grade'],1)."</font>";
                            else 
                                $output .= "<font color='red'>".strtoupper($subj['tor_grade'])."</font>";
                        } else {
                            if (is_numeric($subj['tor_grade']))
                                $output .= number_format($subj['tor_grade'],1);
                            else
                                $output .= strtoupper($subj['tor_grade']);
                        }
                    } else {
                        $output .= "&nbsp;";
                    }
                    
                    $output .= "    </td>";

                    // earn units
                    $output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    
                    // check for failing grades - no units earn if failed grades
                    if (in_array($subj['fgrade'],$failed_grades)) {
                        $output .= "&nbsp;";    
                    } else {
                        $output .= number_format($subject->units,1);
                        
                        $ttl_units += $subject->units;
                    }
                    $output .= "    </td>";
                    
                	$output .= "</tr>";
        	    }
        	    
        	    $output .= "<tr><td colspan='20' class='listViewHRS1'></td></tr>";
        	}
        	
        }
    }
/*************************************** end of old enrollment *********************************/
    
    
/*************************************** start of current enrollment *********************************/
    unset($where);
    unset($multiOrder);
    unset($tables);
    unset($flds);    

    // building an select query
	$multiOrder['enrollments.schYear'] = "ASC";
	$multiOrder['enrollments.semCode'] = "ASC";
	
	$enrollment->multi_orders = $multiOrder;
	
	$tables[] = "enrollments";
	$tables[] = "courses";
	
	$where[0]['enrollments.idno'] = "='$idno'";
    $where[0]['AND enrollments.courseID'] = "= courses.courseID ";
    $where[0]['AND enrollments.rstatus'] = "= 2 ";  // only validated enrollment are viewed in the TOR
    

	$flds['enrollments.*']  = "";
	$flds['courses.courseCode'] = "";
	
    $enrollment->tables = $tables;
    $enrollment->fields = $flds;
    $enrollment->conds  = $where;
    
    $enrollment->offset = $offset;
    $enrollment->limit  = $limit;
    $enrollment->lock   = 0;

    // building an select query
    $query = $enrollment->Select();  // generate delete sql query
    $enrollment->reset();            // reset all variables in query generator
    
	try {
	    $enrollment->db->beginTransaction();
    	$result   = $enrollment->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$enrollment->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error.";
	}

    if ($records) {
        
        foreach ($records as $row) {
            
            $output .= "<tr height='20'>";
        	
            // course and yr
            $output .= "   <td scope='row' class='evenListRowS1' bgcolor='#fdfdfd' align='left' valign='top'>";
            $output .= "<b><u>".$row['courseCode']."-".$row['yrLevel']."</u></b>";
            $output .= "   </td>";
            
            // school year and semester
            $output .= "   <td scope='row' class='evenListRowS1' bgcolor='#fdfdfd' align='left' valign='top'>";
            
            $schYear = $row['schYear'];
            if ($row['semCode']=='1') {
                $semester = "1<sup>st</sup> &nbsp;Semester";
            } else if ($row['semCode']=='2') {
                $semester = "2<sup>nd</sup> &nbsp;Semester";
            } else if ($row['semCode']=='3') {
                $semester = "3<sup>rd</sup> &nbsp;Semester";
            } else if ($row['semCode']=='4') {
                $semester = "Summer";
                
                $schYears = explode("-",$row['schYear']);
                
                $schYear  = $schYears[1];
            }
            
            $output .= "<b><u>".$semester." - ".$schYear."</u></b>";
            $output .= "   </td>";
            
             // blank
            $output .= "   <td scope='row' class='evenListRowS1' bgcolor='#fdfdfd' align='left' valign='top'>";
            $output .= "&nbsp;";
            $output .= "   </td>";
            
            // blank
            $output .= "   <td scope='row' class='evenListRowS1' bgcolor='#fdfdfd' align='left' valign='top'>";
            $output .= "&nbsp;";
            $output .= "   </td>";
            
        	$output .= "</tr>";
//        	$output .= "<tr><td colspan='20' class='listViewHRS1'></td></tr>";
        	
        	unset($where);
        	$where[0]['enID']="='".$row['enID']."'";
        	
        	$subjects = $enDetail->retrieveAllEnrollmentDetails($where);
        	if ($subjects) {
        	    $ctr = 0;
        	    foreach ($subjects as $subj) {
        	        $subject->subjID = $subj['sched']->subjID;
        	        $subject->retrieveSubject();
                	
                    $output .= "<tr onmouseover=\"setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');\" onmouseout=\"setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');\" onmousedown=\"setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');\" height='20'>";
                    
                    // subject code
                	$output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    $output .= $subject->subjCode;
                    $output .= "    </td>";
                    
                    // descriptive title
                    $output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    $output .= $subject->descTitle;
                    $output .= "    </td>";
                    
                    // final grade
                    $output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    
                    // check for failing grades - no units earn if failed grades
                    if ($subj['tor_grade']) {
                        if (in_array(strtoupper($subj['tor_grade']),$failed_grades)) {
                            if (is_numeric($subj['tor_grade']))
                                $output .= "<font color='red'>".number_format($subj['tor_grade'],1)."</font>";
                            else 
                                $output .= "<font color='red'>".strtoupper($subj['tor_grade'])."</font>";
                        } else {
                            if (is_numeric($subj['tor_grade']))
                                $output .= number_format($subj['tor_grade'],2);
                            else
                                $output .= strtoupper($subj['tor_grade']);
                        }
                    } else {
                        $output .= "&nbsp;";
                    }
                    $output .= "    </td>";

                    // earn units
                    $output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    
                    // check for failing grades - no units earn if failed grades
                    if ($subj['tor_grade']) {
                        if (in_array(strtoupper($subj['tor_grade']),$failed_grades)) {
                            $output .= "&nbsp;";    
                        } else {
                            $output .= number_format($subject->units,1);
                            
                            $ttl_units += $subject->units;
                        }
                    } else {
                        $output .= "&nbsp;";
                    }
                    $output .= "    </td>";
                    
                	$output .= "</tr>";
        	    }
        	    
        	    $output .= "<tr><td colspan='20' class='listViewHRS1'></td></tr>";
        	}
        	
        }
    }
        
/*************************************** end of current enrollment *********************************/

    // this will display the total units earn
    $output .= "<tr height='30'>";
    
    // subject code
    $output .= "     <td scope='row' ";
    if ($ctr%2==0) {
        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
    } else {
        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
    }
    $output .= "    align='left' valign='top'>";
    $output .= "&nbsp;";
    $output .= "    </td>";
    
    // descriptive title
    $output .= "     <td scope='row' ";
    if ($ctr%2==0) {
        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
    } else {
        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
    }
    $output .= "    align='left' valign='top'>";
    $output .= "&nbsp;";
    $output .= "    </td>";
    
    // final grade
    $output .= "     <td scope='row' ";
    if ($ctr%2==0) {
        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
    } else {
        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
    }
    $output .= "    align='left' valign='top'>";
    $output .= "<b>TOTAL UNITS: </b>";
    $output .= "    </td>";
    
    // earn units
    $output .= "     <td scope='row' ";
    if ($ctr%2==0) {
        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
    } else {
        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
    }
    $output .= "    align='left' valign='top'>";
    $output .= "<b>".number_format($ttl_units,1)."</b>";
    $output .= "    </td>";
    
    $output .= "</tr>";
    $output .= "<tr><td colspan='20' class='listViewHRS1'></td></tr>";
    
	return $output;
}

?>



