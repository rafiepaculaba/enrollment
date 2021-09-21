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
require_once('modules/Administration/SchoolFeeElem.php');


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['feeID'])) {
    $feeID = $_POST['feeID'];
    $fee = new SchoolFee($feeID);
} else {
    $fee = new SchoolFee();
}

// check if comes from correct form
if ( isset($_POST['cmdSave']) ) {
    
    if (isset($_POST['feeID'])) {
        $fee->feeID = $_POST['feeID'];
    }
	
	if ($fee->feeID) {
		$getLastID = $fee->feeID;
		
	    $fee->schYear			= $_POST['schYear'];
	    $fee->yrLevel			= $_POST['yrLevel'];
        $fee->item		        = $_POST['item'];
        $fee->amount            = $_POST['amount'];
	    
	    // update school fee record
	    if ($fee->updateSchoolFee()) {
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	} else {
	    $fee->schYear			= $_POST['schYear'];
	    $fee->yrLevel			= $_POST['yrLevel'];
        $fee->item		        = $_POST['item'];
        $fee->amount		    = $_POST['amount'];
        $fee->rstatus        	= $_POST['rstatus'];

	    // new school fee record
    	if ($fee->createSchoolFee()) {
    		$msg = "Record successfully saved!";
    		$sugar_smarty->assign('class', 'notificationbox');
    	} else {
    	    $msg = "Record was not successfully saved!";
    	    $sugar_smarty->assign('class', 'errorbox');
    	}
    	$getLastID = $fee->getLastID();
	}
	
	$sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

	

?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Administration&action=viewSchoolFeeElem&feeID=<?php echo $getLastID; ?>')",3000);
</script>

