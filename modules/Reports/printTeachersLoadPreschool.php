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

global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

//Get Configuration
$config = new Config();

	$schYear = $_GET['schYear'];
	$profID  = $_POST['profID'];
	
	$reportClass = new ReportClass();
	
	$sched = new Schedule();
	
	if ($schYear) {
	    if (count($conds[0])) {
            $conds[0][' AND schedules.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['schedules.schYear'] = " = '$schYear' ";
        }
    }

    if ($profID) {
        if (count($conds[0])) {
            $conds[0][' AND schedules.profID'] = " = '$profID' ";
        } else {
            $conds[0]['schedules.profID'] = " = '$profID' ";
        }
    }

    $record = $sched->retrieveAllSchedulesAssociated($conds);
	
	$user = new User2();
	if ($profID) {
    	$where[0]['id'] = " = '$profID' ";
        $result = $user->retrieveAllUsers($where,'');
	    foreach ($result as $key=>$row) {
	    	$name = $row['last_name'].", ".$row['first_name'];
			$sugar_smarty->assign('NAME', $name);
		}
	}
    
	$record = $sched->retrieveAllSchedulesAssociated($conds);
	$sugar_smarty->assign('RESULT', $reportClass->printTeachersLoadPreschool($record));
	$sugar_smarty->assign('schYear', $schYear);
	
	$sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );

echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
echo $sugar_smarty->fetch('modules/Reports/templates/printTeachersLoadPreschool.tpl');	
?>

<script type='text/javascript'>
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}
</script>
