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
require_once('modules/Config/ConfigPreschool.php');
require_once('modules/Subjects/SubjectPreschool.php');
require_once('modules/Students/StudentPreschool.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/SchedulePreschool.php');
require_once('modules/Schedules/BlockSectionPreschool.php');
require_once('modules/Schedules/BlockSectionSubjectPreschool.php');
require_once('modules/Enrollments/EnrollmentDetailPreschool.php');
require_once('modules/Enrollments/EnrollmentPreschool.php');
require_once('modules/Reports/ReportPreschool.php');

echo "\n<p>\n";
echo get_module_title("view_inline", $mod_strings['LBL_MODULE_PRESCHOOL_DASHBOARD'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Preschool Dashboard");
if ($access->check_access($current_user->id,$accessCode)) {
	//Get Configuration
	$config = new Config();
	
		// get the default school year
	    $schYear = $config->getConfig('School Year');
        
        /**
         * get the collections
         */
        $reportClass = new ReportClass();
        $result = array();

        $ctr=1;
        while ($ctr<=5) {
            
            if ($ctr==5) {
                $index="Special";
            } else {
                $index=$ctr;
            }
            
            if ($ctr<5) {
        		$query = "SELECT count( idno ) AS total_enrollees FROM enrollments WHERE schYear = '$schYear' AND yrLevel = '$ctr' AND rstatus >'0'";
            } else {
        		$query = "SELECT count( idno ) AS total_enrollees FROM enrollments WHERE schYear = '$schYear' AND yrLevel = 'S' AND rstatus >'0'";
            }
            $records = $reportClass->adhocQuery($query);
            if ($records[0]['total_enrollees']) {
    	       $result[$index] = $records[0]['total_enrollees'];
            } else {
    	       $result[$index] = 0;	
            }
        	    
            $total += $result[$index];
            
            $ctr++;
        }
        
        
        $sugar_smarty->assign('overall', $total );

        $sugar_smarty->assign('RESULT', $reportClass->generateEnrollmentStatusPreschool($result,$total));

		$query = "SELECT count(*) ttl_new FROM enrollments WHERE rstatus>0 and (studType='2' or studType='3' ) and schYear='$schYear'";
		
		try {
		    $reportClass->db->beginTransaction();
	    	$result   = $reportClass->db->query($query);
			$records  = $result->fetchAll(PDO::FETCH_BOTH);
			$reportClass->db->commit();
			
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
	    $query = "select count(distinct idno) as ttl_withdrawals from enrollments where schYear='$schYear' and rstatus=0";
		try {
		    $reportClass->db->beginTransaction();
	    	$result   = $reportClass->db->query($query);
			$records  = $result->fetchAll(PDO::FETCH_BOTH);
			$reportClass->db->commit();
			
			if ($records) {
			    $ttl_withdrawals  = $records[0]['ttl_withdrawals']? $records[0]['ttl_withdrawals']:0;
			}
			
		} catch (PDOException $e) {
		    echo "SQL query error.";
		}
		$sugar_smarty->assign('ttl_withdrawals', $ttl_withdrawals );
        

	     $total_terms = $config->getConfig('Terms');
	    
	    /**
		 * get the total collection
		 */
	    // building an select query
	    $collection = array();
	    $ctr=0;
	    // get the total down payments
	    $query = "select sum(amount) total from registration_payments where schYear='$schYear' and rstatus=1";
		try {
		    $reportClass->db->beginTransaction();
	    	$result   = $reportClass->db->query($query);
			$records  = $result->fetchAll(PDO::FETCH_BOTH);
			$reportClass->db->commit();
			
			if ($records) {
			    $collection[$ctr]['term'] = "Down Payment";
			    $collection[$ctr]['ttl']  = $records[0]['total']? $records[0]['total']:0;
			    
			    $collection_total += $records[0]['total'];
			    
			    $ctr++;
			}
			
		} catch (PDOException $e) {
		    echo "SQL query error.";
		}

		// get the total collections by terms
        for ($i=1; $i<=$total_terms; $i++) {
            $query = "select sum(amount) total from payments where schYear='$schYear' and term='$i' and rstatus=1";
    		try {
    		    $reportClass->db->beginTransaction();
    	    	$result   = $reportClass->db->query($query);
    			$records  = $result->fetchAll(PDO::FETCH_BOTH);
    			$reportClass->db->commit();
    			
    			if ($records) {
    			    $collection[$ctr]['term'] = $i;
    			    
    			    $collection[$ctr]['ttl']  = $records[0]['total'];
    			    
    			    $collection_total += $records[0]['total'];
    			    
    			    $ctr++;
    			}
    			
    		} catch (PDOException $e) {
    		    echo "SQL query error.";
    		}
    		
        }
	
    	$sugar_smarty->assign('collection', $collection );
    	$sugar_smarty->assign('collection_total', $collection_total );
	
	$sugar_smarty->assign('schYear', $schYear );
	$sugar_smarty->assign('isAdmin', $current_user->is_admin );

    echo $sugar_smarty->fetch('modules/Home/templates/dashboardPreschool.tpl');	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>
