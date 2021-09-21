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

require_once('modules/Config/ConfigElem.php');
require_once('modules/Students/StudentElem.php');
require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Grades/Form137Elem.php');
require_once('modules/Schedules/ScheduleElem.php');
require_once('modules/Enrollments/EnrollmentElem.php');
require_once('modules/Enrollments/EnrollmentDetailElem.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_ELEM'], false);
echo "\n</p>\n";
global $theme;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Elem Form137");
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
        $sugar_smarty->assign('body', getForm137($idno) );
        
        $sugar_smarty->assign('idno', $idno );
        $sugar_smarty->assign('name', $student->lname.", ".$student->fname." ".$student->mname );
        
        echo $sugar_smarty->fetch('modules/Students/templates/viewForm137Elem.tpl');
    }
} else {
    $msg = "Sorry, you dont have permission to access this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}



function getForm137($idno)
{
    // get all failing grades
    $config = new Config();
    
    $passing_grade = $config->getConfig('Passing Grade');
    
    $enrollment = new Enrollment();
    $enDetail   = new EnrollmentDetail();
    $subject    = new Subject();
    
    $where[0]['enrollments.idno'] = "='$idno'";
    
    // building an select query
	$multiOrder['enrollments.schYear'] = "ASC";
	
	$enrollment->multi_orders = $multiOrder;
	
	$tables[] = "enrollments";
	
	$where[0]['enrollments.idno'] = "= '$idno' ";
	$where[0][' AND enrollments.rstatus'] = "= '2' ";

	$flds['enrollments.*']  = "";
	
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
	    return false;
	}

    if ($records) {
        $ttl_units = 0;
        $output="";
        foreach ($records as $row) {
            
            $output .= "<tr height='20'>";
        	
            // school year and semester
            $output .= "   <td scope='row' class='evenListRowS1' bgcolor='#fdfdfd' align='left' colspan='3' valign='top'>";
            
            if ($row['yrLevel']=='1') {
                $yrLevel = "1<sup>st</sup> &nbsp;Grade ";
            } else if ($row['yrLevel']=='2') {
                $yrLevel = "2<sup>nd</sup> &nbsp;Grade";
            } else if ($row['yrLevel']=='3') {
                $yrLevel = "3<sup>rd</sup> &nbsp;Grade";
            } else if ($row['yrLevel']=='4') {
                $yrLevel = "4<sup>th<sup> &nbsp;Grade";
            } else if ($row['yrLevel']=='5') {
                $yrLevel = "5<sup>th</sup> &nbsp;Grade";
            } else if ($row['yrLevel']=='6') {
                $yrLevel = "6<sup>th</sup> &nbsp;Grade";
            } else if ($row['yrLevel']=='S') {
                $yrLevel = "Special";
            }
            
            $output .= "<b><u>".$yrLevel." - ".$row['schYear']."</u></b>";
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
                    
                    // first grade
                    $output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    
                    // check for failing grades - no units earn if failed grades
                    if ($subj['firstgrade']) {
                        if ( $subj['firstgrade'] < $passing_grade ) {
                            if (is_numeric($subj['firstgrade']))
                                $output .= "<font color='red'>".number_format($subj['firstgrade'],1)."</font>";
                            else 
                                $output .= "<font color='red'>".strtoupper($subj['firstgrade'])."</font>";
                        } else {
                            if (is_numeric($subj['firstgrade']))
                                $output .= number_format($subj['firstgrade'],1);
                            else
                                $output .= strtoupper($subj['firstgrade']);
                        }
                    } else {
                        $output .= "&nbsp;";
                    }
                    
                    $output .= "    </td>";
                    
                    // second grade
                    $output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    
                    // check for failing grades - no units earn if failed grades
                    if ($subj['secondgrade']) {
                        if ( $subj['secondgrade'] < $passing_grade ) {
                            if (is_numeric($subj['secondgrade']))
                                $output .= "<font color='red'>".number_format($subj['secondgrade'],1)."</font>";
                            else 
                                $output .= "<font color='red'>".strtoupper($subj['secondgrade'])."</font>";
                        } else {
                            if (is_numeric($subj['secondgrade']))
                                $output .= number_format($subj['secondgrade'],1);
                            else
                                $output .= strtoupper($subj['secondgrade']);
                        }
                    } else {
                        $output .= "&nbsp;";
                    }
                    
                    $output .= "    </td>";
                    
                    // third grade
                    $output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    
                    // check for failing grades - no units earn if failed grades
                    if ($subj['thirdgrade']) {
                        if ( $subj['thirdgrade'] < $passing_grade ) {
                            if (is_numeric($subj['thirdgrade']))
                                $output .= "<font color='red'>".number_format($subj['thirdgrade'],1)."</font>";
                            else 
                                $output .= "<font color='red'>".strtoupper($subj['thirdgrade'])."</font>";
                        } else {
                            if (is_numeric($subj['thirdgrade']))
                                $output .= number_format($subj['thirdgrade'],1);
                            else
                                $output .= strtoupper($subj['thirdgrade']);
                        }
                    } else {
                        $output .= "&nbsp;";
                    }
                    
                    $output .= "    </td>";
                    
                    // fourth grade
                    $output .= "     <td scope='row' ";
                    if ($ctr%2==0) {
                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
                    } else {
                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
                    }
                    $output .= "    align='left' valign='top'>";
                    
                    // check for failing grades - no units earn if failed grades
                    if ($subj['fourthgrade']) {
                        if ( $subj['fourthgrade'] < $passing_grade ) {
                            if (is_numeric($subj['fourthgrade']))
                                $output .= "<font color='red'>".number_format($subj['fourthgrade'],1)."</font>";
                            else 
                                $output .= "<font color='red'>".strtoupper($subj['fourthgrade'])."</font>";
                        } else {
                            if (is_numeric($subj['fourthgrade']))
                                $output .= number_format($subj['fourthgrade'],1);
                            else
                                $output .= strtoupper($subj['fourthgrade']);
                        }
                    } else {
                        $output .= "&nbsp;";
                    }
                    
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
                    if ($subj['fgrade']) {
                        if ( $subj['fgrade'] < $passing_grade ) {
                            if (is_numeric($subj['fgrade']))
                                $output .= "<font color='red'>".number_format($subj['fgrade'],1)."</font>";
                            else 
                                $output .= "<font color='red'>".strtoupper($subj['fgrade'])."</font>";
                        } else {
                            if (is_numeric($subj['fgrade']))
                                $output .= number_format($subj['fgrade'],1);
                            else
                                $output .= strtoupper($subj['fgrade']);
                        }
                    } else {
                        $output .= "&nbsp;";
                    }
                    
                    $output .= "    </td>";
                    
//                    // earn units
//                    $output .= "     <td scope='row' ";
//                    if ($ctr%2==0) {
//                        $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
//                    } else {
//                        $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
//                    }
//                    $output .= "    align='left' valign='top'>";
//                    
//                     check for failing grades - no units earn if failed grades
//                    if ( $subj['form137_grade'] >= $passing_grade ) {
//                        $output .= number_format($subject->units,1);
//                        $ttl_units += $subject->units;
//                    } else {
//                        $output .= "&nbsp;";    
//                    }
//                    
//                    $output .= "    </td>";
                    
                	$output .= "</tr>";
        	    }
        	    
        	    $output .= "<tr><td colspan='20' class='listViewHRS1'></td></tr>";
        	}
        	
        }
        
        
//        // this will display the total units earn
//        $output .= "<tr height='30'>";
//        
//        // subject code
//        $output .= "     <td scope='row' ";
//        if ($ctr%2==0) {
//            $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
//        } else {
//            $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
//        }
//        $output .= "    align='left' valign='top'>";
//        $output .= "&nbsp;";
//        $output .= "    </td>";
//        
//        // descriptive title
//        $output .= "     <td scope='row' ";
//        if ($ctr%2==0) {
//            $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
//        } else {
//            $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
//        }
//        $output .= "    align='left' valign='top'>";
//        $output .= "&nbsp;";
//        $output .= "    </td>";
//        
//        // final grade
//        $output .= "     <td scope='row' ";
//        if ($ctr%2==0) {
//            $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
//        } else {
//            $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
//        }
//        $output .= "    align='left' valign='top'>";
//        $output .= "<b>TOTAL UNITS: </b>";
//        $output .= "    </td>";
//        
//        // earn units
//        $output .= "     <td scope='row' ";
//        if ($ctr%2==0) {
//            $output .= "    class='evenListRowS1' bgcolor='#fdfdfd' ";
//        } else {
//            $output .= "    class='oddListRowS1' bgcolor='#ffffff' ";
//        }
//        $output .= "    align='left' valign='top'>";
//        $output .= "<b>".number_format($ttl_units,1)."</b>";
//        $output .= "    </td>";
//        
//        $output .= "</tr>";
//        $output .= "<tr><td colspan='20' class='listViewHRS1'></td></tr>";
    }
    
	return $output;
}

?>



