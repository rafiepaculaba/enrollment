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

require_once('modules/Administration/SchoolFeeHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit HS School Fee");
if ($access->check_access($current_user->id,$accessCode)) {
	$feeID = $_GET['feeID'];
	
	$fee = new SchoolFee();

	$fee->feeID = $feeID;
	$fee->retrieveSchoolFee(1); // locked
	
	$sugar_smarty->assign('feeID', $fee->feeID );
	$sugar_smarty->assign('schYear', $fee->schYear );
	$sugar_smarty->assign('yrLevel', $fee->yrLevel );
	$sugar_smarty->assign('item', $fee->item );
	$sugar_smarty->assign('amount', $fee->amount );
	$sugar_smarty->assign('rstatus', $fee->rstatus );
		
		// generation of school year
	$current_year = date("Y",time());
	for($yr=$current_year-2; $yr<=$current_year; $yr++) {
	    $arr[]=$yr.'-'.($yr+1);
	}
	
	$combo  ="<select name='schYear' id='schYear'>";
	$combo .= "<option value=''>----------------------------</option>";
	if ($arr) {
		    foreach ($arr as $yr) {
		    	if ($yr == $fee->schYear) {
		        	$combo .= '<option value="'.$yr.'" selected>'.$yr.'</option>'."\n";
		    	} else {
		        	$combo .= '<option value="'.$yr.'">'.$yr.'</option>'."\n";
		    	}
		    }
		}
	$combo .= "</select>";

$sugar_smarty->assign('combo',$combo);
	echo $sugar_smarty->fetch('modules/Administration/templates/editSchoolFeeHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmSchoolFeeHS','schYear', '', true, 'School Year');
addToValidate('frmSchoolFeeHS','yrLevel', '', true, 'Year Level');
addToValidate('frmSchoolFeeHS','item', '', true, 'Item');
addToValidate('frmSchoolFeeHS','amount', '', true, 'Amount');
</script>