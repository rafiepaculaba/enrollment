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
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Payments/ORSeries.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $orseries = new ORSeries($id);
} else {
    $orseries = new ORSeries();
}

// check if comes from correct form
//if ( isset($_POST['cmdSave']) ) {
    
    if (isset($_POST['id'])) {
        $orseries->id = $_POST['id'];
    }
	
	if ($orseries->id) {
		//Get Latest ID to Display
		$getLastID = $orseries->id;

		// update existing record
        $orseries->fiscalYear    = $_POST['fiscalYear'];
        $orseries->firstORNO     = $_POST['firstORNO'];
        $orseries->lastORNO      = $_POST['lastORNO'];
        $orseries->currentORNO   = $_POST['firstORNO'];
        $orseries->cancelledOR   = $_POST['cancelledOR'];
        $orseries->cashier       = $_POST['cashier'];
        $orseries->rstatus       = $_POST['rstatus'];
	    
	    // update student record
	    if ($orseries->updateORSeries()) {
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	} else {
	    // create new record
        $orseries->fiscalYear    = $_POST['fiscalYear'];
        $orseries->firstORNO     = $_POST['firstORNO'];
        $orseries->lastORNO      = $_POST['lastORNO'];
        $orseries->currentORNO   = $_POST['firstORNO'];
        $orseries->cancelledOR   = $_POST['cancelledOR'];
        $orseries->cashier       = $_POST['cashier'];
	    
	    // new student record
    	if ($orseries->createORSeries()) {
			//Get Latest ID to Display
			$getLastID = $orseries->getLastID();

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
setTimeout("redirect('index.php?module=Payments&action=viewORSeries&id=<?php echo $getLastID; ?>')",3000);
</script>