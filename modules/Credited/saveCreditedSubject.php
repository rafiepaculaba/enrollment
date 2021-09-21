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
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Registrations/Registration.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Credited/CreditedSubject.php');
require_once('modules/Grades/TOR.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE'], false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['creID'])) {
    $creID = $_POST['creID'];
    $cre = new CreditedSubject($creID);
} else {
    $cre = new CreditedSubject();
}

// check if comes from correct form
//if ( isset($_POST['cmdSave']) ) {
    if (isset($_POST['creID'])) {
        $cre->creID = $_POST['creID'];
    }
	if ($cre->creID) {
       	// Get ID to Display
       	$getLastID = $cre->creID;

       	$cre->idno				= $_POST['idno'];
       	$cre->schYear			= $_POST['schYear'];
       	$cre->yrLevel			= $_POST['yrLevel'];
       	$cre->semCode			= $_POST['semCode'];
       	$cre->fgrade			= $_POST['fgrade'];
       	$cre->subjID			= $_POST['subjID'];
       	$cre->eqSubj			= $_POST['eqSubj'];
       	$cre->eqUnits			= $_POST['eqUnits'];
       	$cre->school			= $_POST['school'];
       	$cre->remarks			= $_POST['remarks'];
       	$cre->encodedBy			= $_POST['encodedBy'];

       	$tor = new TOR();
	    $conds[0]['tor.creID'] = "= '$cre->creID' AND ";
	    $conds[0]['tor.idno'] = "= '$cre->idno' AND ";
	    $conds[0]['tor.schYear'] = "= '$cre->schYear' AND ";
	    $conds[0]['tor.yrLevel'] = "= '$cre->yrLevel' AND ";
	    $conds[0]['tor.semCode'] = "= '$cre->semCode' AND ";
	    $conds[0]['tor.subjID'] = "= '$cre->subjID'";
	    
	    $result = $tor->retrieveAllTORs($conds);
		
	    if (isset($result[0][torID])) {
		    $torID = $result[0][torID];
		    $torD = new TOR($torID);
		}
		
		if (isset($result[0][torID])) {
        	$torD->torID = $result[0][torID];
    	}
	    if ($torD->torID) {
			$torD->schYear 	= $_POST['schYear'];
		   	$torD->semCode 	= $_POST['semCode'];
		   	$torD->idno 	= $_POST['idno'];
		   	$torD->subjID 	= $_POST['subjID'];
		   	$torD->yrLevel 	= $_POST['yrLevel'];
		   	$torD->fgrade 	= $_POST['fgrade'];
		   	
		   	$torD->updateTOR();
    	}
       	
	    // update subject record
	    if ($cre->updateCreditedSubject()) {
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	} else {
       	$cre->idno				= $_POST['idno'];
       	$cre->schYear			= $_POST['schYear'];
       	$cre->yrLevel			= $_POST['yrLevel'];
       	$cre->semCode			= $_POST['semCode'];
       	$cre->fgrade			= $_POST['fgrade'];
       	$cre->subjID			= $_POST['subjID'];
       	$cre->eqSubj			= $_POST['eqSubj'];
       	$cre->eqUnits			= $_POST['eqUnits'];
       	$cre->school			= $_POST['school'];
       	$cre->remarks			= $_POST['remarks'];
       	$cre->encodedBy			= $current_user->id;
        $cre->rstatus        	= $_POST['rstatus'];
	    
	    // new Credited Subject record
    	if ($cre->createCreditedSubject()) {
			
    		$tor = new TOR();
	       	
	       	$tor->creID 	= $cre->getLastID();
	       	$tor->schYear 	= $_POST['schYear'];
	       	$tor->semCode 	= $_POST['semCode'];
	       	$tor->idno 		= $_POST['idno'];
	       	$tor->subjID 	= $_POST['subjID'];
	       	$tor->yrLevel 	= $_POST['yrLevel'];
	       	$tor->fgrade 	= $_POST['fgrade'];
	       	
	       	$tor->createTOR();
			
	       	// Get Latest ID to Display
	       	$getLastID = $cre->getLastID();

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
setTimeout("redirect('index.php?module=Credited&action=viewCreditedSubject&creID=<?php echo $getLastID; ?>')",3000);
</script>