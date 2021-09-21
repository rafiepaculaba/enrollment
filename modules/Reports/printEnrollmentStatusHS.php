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
require_once('modules/Config/ConfigHS.php');
require_once('modules/Subjects/SubjectHS.php');
require_once('modules/Students/StudentHS.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleHS.php');
require_once('modules/Schedules/BlockSectionHS.php');
require_once('modules/Schedules/BlockSectionSubjectHS.php');
require_once('modules/Enrollments/EnrollmentDetailHS.php');
require_once('modules/Enrollments/EnrollmentHS.php');
require_once('modules/Reports/ReportHS.php');

echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$sugar_smarty = new Sugar_Smarty();
    
// get all default setting from configs
$config = new Config();

    // get the default school year
    $schYear = $default_schYear = $_POST['schYear'];
    $rstatus = $_POST['rstatus'];
    
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
        	if(trim($rstatus)!='' || trim($rstatus)!=null) {
            	$query = "SELECT count( idno ) AS total_enrollees FROM enrollments WHERE schYear = '$schYear' AND yrLevel = '$ctr' AND rstatus ='$rstatus'";
        	} else {
        		$query = "SELECT count( idno ) AS total_enrollees FROM enrollments WHERE schYear = '$schYear' AND yrLevel = '$ctr' AND rstatus >'0'";
        	}
        } else {
        	if(trim($rstatus)!='' || trim($rstatus)!=null){
        		$query = "SELECT count( idno ) AS total_enrollees FROM enrollments WHERE schYear = '$schYear' AND yrLevel = 'S' AND rstatus ='$rstatus'";
        	} else {
        		$query = "SELECT count( idno ) AS total_enrollees FROM enrollments WHERE schYear = '$schYear' AND yrLevel = 'S' AND rstatus >'0'";
        	}
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

$sugar_smarty->assign('RESULT', $reportClass->printEnrollmentStatusHS($result,$total));
    
//school year
$year = date("Y",time());

$arrSchYear = array();
for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
	$arrSchYear[] = $yr."-".($yr+1);
}

$schoolYear='<select name="schYear" id="schYear" >'."\n";
$schoolYear.='<option value="">-----------------------------</option>'."\n";
if ($arrSchYear) {
    foreach ($arrSchYear as $value) {
        if ($value==$default_schYear) {
           $schoolYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
        } else {
           	$schoolYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
        }
    }
}
$schoolYear.='</select>';
$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);

if(trim($rstatus)!='' && $rstatus == '1') {
	$rstatus = " Pending ";
} else if(trim($rstatus)!='' && $rstatus == '2') {
	$rstatus = " Validated ";
} else if(trim($rstatus)!='' && $rstatus == '0') {
	$rstatus = " Withdrawn ";
} else {
	$rstatus = "Pending and Validated";
}

$sugar_smarty->assign('schYear', $schYear );
$sugar_smarty->assign('rstatus', $rstatus );
$sugar_smarty->assign('total', $total );
$sugar_smarty->assign('schName', $config->getConfig('School Name') );
$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
$sugar_smarty->assign('schContact', $config->getConfig('Contact') );

echo $sugar_smarty->fetch('modules/Reports/templates/printEnrollmentStatusHS.tpl');
?>

<script language="javascript">
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}
</script>
