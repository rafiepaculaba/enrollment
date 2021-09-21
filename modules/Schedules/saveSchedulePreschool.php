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
//tail -f /usr/local/apache2/logs/error_log
global $current_user, $sugar_version, $sugar_config, $image_path;

require_once('include/Sugar_Smarty.php');

require_once('common.php');
require_once('modules/Subjects/SubjectPreschool.php');
require_once('modules/Schedules/SchedulePreschool.php');
require_once('modules/Users/User2.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['schedID'])) {
	$schedID = $_POST['schedID'];
    $sched = new Schedule($schedID);
} else {
	$sched = new Schedule();
}

// check if comes from correct form
//if ( isset($_POST['cmdSave']) ) {
    
    if (isset($_POST['schedID'])) {
        $sched->schedID = $_POST['schedID'];
    }
	if ($sched->schedID) {
		//Get ID to Display
		$getLastID 					= $sched->schedID;
	    $sched->schYear				= $_POST['schYear'];
	    $sched->yrLevel				= $_POST['yrLevel'];
	    $sched->schedCode			= $_POST['schedCode'];
        $sched->subjID     			= $_POST['subjID'];
        $sched->profID         		= $_POST['profID'];

        $stime =$_POST['shh'].":".$_POST['smm']." ".$_POST['samp'];
        if ($_POST['smm']=='') {
			$smm="00";			
        $stime =$_POST['shh'].":".$smm." ".$_POST['samp'];
		}
        
        $sched->startTime		= date("H:i:s",strtotime($stime));

		$etime =$_POST['ehh'].":".$_POST['emm']." ".$_POST['eamp'];
		if ($_POST['emm']=='') {
			$emm="00";		
		$etime =$_POST['ehh'].":".$emm." ".$_POST['eamp'];
		}      

		$sched->endTime 	       	= date("H:i:s",strtotime($etime));

		        if (isset($_POST['onMon'])) {
        	$onMon=1;
        }
        if (isset($_POST['onTue'])) {
        	$onTue=1;
        }
        if (isset($_POST['onWed'])) {
        	$onWed=1;
        }
        if (isset($_POST['onThu'])) {
        	$onThu=1;
        }
        if (isset($_POST['onFri'])) {
        	$onFri=1;
        }
        if (isset($_POST['onSat'])) {
        	$onSat=1;
        }
        if (isset($_POST['onSun'])) {
        	$onSun=1;
        }
        $sched->onMon     			= $onMon;
        $sched->onTue          		= $onTue;
        $sched->onWed         		= $onWed;
        $sched->onThu     			= $onThu;
        $sched->onFri          		= $onFri;
        $sched->onSat         		= $onSat;
        $sched->onSun         		= $onSun;
		$sched->room    			= $_POST['room'];
        $sched->maxCapacity     	= '50';
        $sched->noEnrolled     		= $_POST['noEnrolled'];
        $sched->remarks          	= $_POST['remarks'];
        
	    // update schedule record
	    if ($sched->updateSchedule()) {
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	} else {
	    $sched->schYear			= $_POST['schYear'];
	    $sched->yrLevel			= $_POST['yrLevel'];
	    $sched->schedCode       = $_POST['schedCode'];
        $sched->subjID          = $_POST['subjID'];
        $sched->profID          = $_POST['profID'];   
    
        $stime =$_POST['shh'].":".$_POST['smm']." ".$_POST['samp'];
        if ($_POST['smm']=='') {
			$smm="00";			
        $stime =$_POST['shh'].":".$smm." ".$_POST['samp'];
		}
        
        $sched->startTime		= date("H:i:s",strtotime($stime));

		$etime =$_POST['ehh'].":".$_POST['emm']." ".$_POST['eamp'];
		if ($_POST['emm']=='') {
			$emm="00";		
		$etime =$_POST['ehh'].":".$emm." ".$_POST['eamp'];
		}      

		$sched->endTime        	= date("H:i:s",strtotime($etime));      

		if (isset($_POST['onMon'])) {
        	$onMon=1;
        }
        if (isset($_POST['onTue'])) {
        	$onTue=1;
        }
        if (isset($_POST['onWed'])) {
        	$onWed=1;
        }
        if (isset($_POST['onThu'])) {
        	$onThu=1;
        }
        if (isset($_POST['onFri'])) {
        	$onFri=1;
        }
        if (isset($_POST['onSat'])) {
        	$onSat=1;
        }
        if (isset($_POST['onSun'])) {
        	$onSun=1;
        }
        $sched->onMon     			= $onMon;
        $sched->onTue          		= $onTue;
        $sched->onWed         		= $onWed;
        $sched->onThu     			= $onThu;
        $sched->onFri          		= $onFri;
        $sched->onSat         		= $onSat;
        $sched->onSun         		= $onSun;
		$sched->room          	= $_POST['room'];
        $sched->maxCapacity     = '50';
        $sched->noReserved      = $_POST['noReserved'];
        $sched->noEnrolled      = $_POST['noEnrolled'];
        $sched->remarks     	= $_POST['remarks'];
        $sched->preparedBy      = $_POST['preparedBy'];   
        $sched->rstatus        	= $_POST['rstatus'];

	    // new schedule record
    	if ($sched->createSchedule()) {
			//Get Latest ID to Display
    		$getLastID = $sched->getLastID();
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
//}

?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Schedules&action=viewSchedulePreschool&schedID=<?php echo $getLastID; ?>')",3000);
</script>