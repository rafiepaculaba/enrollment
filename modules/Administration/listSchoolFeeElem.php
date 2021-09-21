
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
global $pageLimit;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Elem School Fee");
if ($access->check_access($current_user->id,$accessCode)) {

	$fee = new SchoolFee();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;
	
	$feeID   	= $_GET['feeID'];
	$schYear   	= $_GET['schYear'];
	$yrLevel   	= $_GET['yrLevel'];
	$item   	= $_GET['item'];
	
	if ($feeID) {
	    $conds[0]['feeID'] = "= '$feeID' AND ";
	}
	if ($schYear) {
	    $conds[0]['schYear'] = "= '$schYear' AND ";
	}
	if ($yrLevel) {
	    $conds[0]['yrLevel'] = "= '$yrLevel' AND ";
	}
	if ($item) {
	    $conds[0]['item'] = " like '$item%' AND ";
	}
	
	$conds[0]['rstatus'] = "= 1 ";
			
	//school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" >'."\n";
	$schoolYear.='<option value="">-------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	    	if ($value == $schYear) {
	        	$schoolYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schoolYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schoolYear.='</select>';
	
	$allSchoolFees = $fee->retrieveAllSchoolFees($conds);
	$list          = $fee->retrieveAllSchoolFees($conds,"item","ASC",$offset, $limit);
	
	if ($allSchoolFees)
		$total_rec=count($allSchoolFees);
	else 
		$total_rec=0;
		
	$main_url="index.php?module=Administration&action=listSchoolFeesElem&feeID=$feeID&schYear=$schyear&yrLevel=$yrLevel&item=$item";

	$sugar_smarty->assign('SCHOOLYEAR',$schoolYear);
	$sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('feeID', $feeID );
	$sugar_smarty->assign('schYear', $schYear );
	$sugar_smarty->assign('yrLevel', $yrLevel );
	$sugar_smarty->assign('item', $item );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
		
	echo $sugar_smarty->fetch('modules/Administration/templates/listSchoolFeeElem.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>
<script language="javascript">
$('feeID').focus();
</script>