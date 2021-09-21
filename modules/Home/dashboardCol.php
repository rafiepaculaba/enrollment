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
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');
require_once('modules/Schedules/Schedule.php');
require_once('modules/Schedules/BlockSectionCol.php');
require_once('modules/Schedules/BlockSectionSubjectCol.php');
require_once('modules/Enrollments/EnrollmentDetailCol.php');
require_once('modules/Enrollments/EnrollmentCol.php');

echo "\n<p>\n";
echo get_module_title("view_inline", $mod_strings['LBL_MODULE_COL_DASHBOARD'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Col Dashboard");
if ($access->check_access($current_user->id,$accessCode)) {
    
    //Get Configuration
	$config = new Config();
    
    // get the default school year
    $schYear = $config->getConfig('School Year');
    
    // get the default semester
    $semCode = $config->getConfig('Semester');
    
    // get the reg account code
    $registrationCode = $config->getConfig('Reg Account Code');
    
    // get the tution account code
    $tuitionCode = $config->getConfig('Tuition Account Code');
    
		$course = new Course();
		$course_list = $course->retrieveAllCourses($conds,'');
		
		$enroll = new Enrollment();
		$report = array();
		$index=0;
		
		$grand = array();
		
		foreach ($course_list as $key=>$value) {
			$report[$index]=array();	
			
			$report[$index]['deptCode']              = $value['deptCode'];
		    $courseID = $report[$index]['courseID']  = $value['courseID'];
		    $report[$index]['courseCode']            = $value['courseCode'];
		    $ctr = 1;
		    while ( $ctr <= 5 ) {
		    $tables[] = 'enrollments';
		
		    $fields[' count( idno ) AS total_enrollees ']	= "";
		    
		    $where[0]['schYear'] 	= "='$schYear' AND ";
		    $where[0]['semCode']    = "='$semCode' AND ";
		    $where[0]['courseID']   = "='$courseID' AND ";
		    $where[0]['yrLevel']    = "='$ctr' AND ";
		    $where[0]['rstatus']    = " > '0'";
		    
		    $enroll->tables = $tables;
		    $enroll->fields = $fields;
		    $enroll->conds  = $where;
		    $enroll->order  = $orderby;
		    $enroll->multi_orders = $multi_orders;
		            
		    // building an select query
		    $query = $enroll->Select();  // generate delete sql query
		    $enroll->reset();            // reset all variables in query generator
		    
			try {
			    $enroll->db->beginTransaction();
		    	$result   = $enroll->db->query($query);
				$records  = $result->fetchAll(PDO::FETCH_BOTH);
				$enroll->db->commit();
			} catch (PDOException $e) {
			    echo "SQL query error. ";
			}
			if(trim($records[0]['total_enrollees']) != '' && $records[0]['total_enrollees'] != NULL){
		    	$report[$index][$ctr]=$records[0]['total_enrollees'];
			} else {
				$report[$index][$ctr]= 0;
				$records[0]['total_enrollees'] = 0;
			}
			
		    $report[$index]['total'] += $records[0]['total_enrollees'];
		    //$report[$value['courseCode']]['total'] += $report[$value['courseCode']][$records[0]['total_enrollees']];
		    
		    $grand[$ctr] += $report[$index][$ctr];
		    $grand['total'] += $report[$index][$ctr];
		    unset($tables);
		    
		    $ctr++;
		    }

		    $index++;
		}
		
		$sugar_smarty->assign('grand', $grand );
		$sugar_smarty->assign('overall', $grand['total'] );
		$sugar_smarty->assign('list', $report );
		
		for($i=0; $i<count($report); $i++) {
            for($r=$i+1; $r<count($report); $r++) {
                if ($report[$i]['total']<$report[$r]['total']) {
                    // swap
                    $temp=$report[$i];
                    $report[$i]=$report[$r];
                    $report[$r]=$temp;
                }
            }
        }

        $top_3 = $d = array_chunk($report,3);
        
        $sugar_smarty->assign('top_rank', $top_3[0] );
        
		
		// get the stats
		/**
		 * get the total number of new students
		 */
	    $query = "SELECT count(*) ttl_new FROM enrollments WHERE rstatus>0 and (studType='2' or studType='3' ) and schYear='$schYear' and semCode='$semCode'";
		try {
		    $enroll->db->beginTransaction();
	    	$result   = $enroll->db->query($query);
			$records  = $result->fetchAll(PDO::FETCH_BOTH);
			$enroll->db->commit();
			
			if ($records) {
			    $ttl_new  = $records[0]['ttl_new']? $records[0]['ttl_new']:0;
			}
			
		} catch (PDOException $e) {
		    echo "SQL query error.";
		}
		$sugar_smarty->assign('ttl_new', $ttl_new );
		
		/**
		 * get the total number of withdrawals
		 */
	    $query = "select count(distinct idno) as ttl_withdrawals from enrollments where schYear='$schYear' and semCode='$semCode' and rstatus=0";
		try {
		    $enroll->db->beginTransaction();
	    	$result   = $enroll->db->query($query);
			$records  = $result->fetchAll(PDO::FETCH_BOTH);
			$enroll->db->commit();
			
			if ($records) {
			    $ttl_withdrawals  = $records[0]['ttl_withdrawals']? $records[0]['ttl_withdrawals']:0;
			}
			
		} catch (PDOException $e) {
		    echo "SQL query error.";
		}
		$sugar_smarty->assign('ttl_withdrawals', $ttl_withdrawals );
		
		
		
		// get the default semcode
    	if ($semCode<4) {
            $total_terms = $config->getConfig('Semestral Terms');
    	} else {
    	    $total_terms = $config->getConfig('Summer Terms');
    	}
        switch ($total_terms) {
         case 1:
            $theTerms = $term_by_1;
            break;
        case 2:
            $theTerms = $term_by_2;
            break;
        case 3:
            $theTerms = $term_by_3;
            break;
        case 4:
            $theTerms = $term_by_4;
            break;
        default:
            $theTerms = $total_terms;
        }
		
		/**
		 * get the total collection
		 */
	    // building an select query
	    $collection = array();
	    $ctr=0;
	    // get the total down payments
	    //$query = "select sum(amount) total from registration_payments where schYear='$schYear' and semCode='$semCode' and rstatus=1";
	    //AND ordetails.account_code =$registrationCode
	      $query = "SELECT
                        orheader.schYear
                        , orheader.semCode
                        , orheader.term
                        , ordetails.account_code
                        , sum(ordetails.amount) total
                        , orheader.rstatus
                    FROM
                        ordetails
                        INNER JOIN orheader 
                            ON (ordetails.orno = orheader.orno)
                    WHERE (orheader.schYear ='$schYear'
                        AND orheader.semCode ='$semCode'
                        AND orheader.term =0
                        AND orheader.rstatus =1)
                    GROUP BY orheader.schYear, orheader.semCode, orheader.term, ordetails.account_code";
		try {
		    $enroll->db->beginTransaction();
	    	$result   = $enroll->db->query($query);
			$records  = $result->fetchAll(PDO::FETCH_BOTH);
			$enroll->db->commit();
			
			if ($records) {
				$collection[$ctr]['term'] = "Down Payment";
				foreach ($records as $row) {
				    //$collection[$ctr]['ttl']  = $records[0]['total']? $records[0]['total']:0;
				    $collection[$ctr]['ttl']  += $row['total']? $row['total']:0;
				    
				    $collection_total += $row['total'];
				}
			    $ctr++;
			}
			
		} catch (PDOException $e) {
		    echo "SQL query error.";
		}

		// get the total collections by terms
        for ($i=1; $i<=$total_terms; $i++) {
            //echo $query = "select sum(amount) total from payments where schYear='$schYear' and semCode='$semCode' and term='$i' and rstatus=1";
            //AND ordetails.account_code =$tuitionCode
             $query = "SELECT
                        orheader.schYear
                        , orheader.semCode
                        , orheader.term
                        , ordetails.account_code
                        , sum(ordetails.amount) total
                        , orheader.rstatus
                    FROM
                        ordetails
                        INNER JOIN orheader 
                            ON (ordetails.orno = orheader.orno)
                    WHERE (orheader.schYear ='$schYear'
                        AND orheader.semCode ='$semCode'
                        AND orheader.term ='$i'
                        AND orheader.rstatus =1)
                    GROUP BY orheader.schYear, orheader.semCode, orheader.term, ordetails.account_code";
    		try {
    		    $enroll->db->beginTransaction();
    	    	$result   = $enroll->db->query($query);
    			$records  = $result->fetchAll(PDO::FETCH_BOTH);
    			$enroll->db->commit();
    			
    			if ($records) {
    			    if (is_array($theTerms)) {
        			    $collection[$ctr]['term'] = $theTerms[$i];
    			    } else {
        			    $collection[$ctr]['term'] = $theTerms;
    			    }
    			    
    			    foreach ($records as $row) {
	    			    //$collection[$ctr]['ttl']  = $records[0]['total'];
	    			    //$collection_total += $records[0]['total'];
	    			    
	    			    $collection[$ctr]['ttl']  += $row['total'];
	    			    $collection_total += $row['total'];
    			    }
    			    
    			    $ctr++;
    			}
    			
    		} catch (PDOException $e) {
    		    echo "SQL query error.";
    		}
        }
	
    	$sugar_smarty->assign('collection', $collection );
    	$sugar_smarty->assign('collection_total', $collection_total );
	
	$sugar_smarty->assign('schYear', $schYear );
	
	switch ($semCode) 
    {
        case 1:
            $sugar_smarty->assign('semCode', "1<sup>st</sup> Sem");    
            break;
        case 2:
            $sugar_smarty->assign('semCode', "2<sup>nd</sup> Sem");
            break;
        case 4:
            $sugar_smarty->assign('semCode', "Summer");
    }
    
    $sugar_smarty->assign('isAdmin', $current_user->is_admin );
    
    echo $sugar_smarty->fetch('modules/Home/templates/dashboardCol.tpl');	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>
