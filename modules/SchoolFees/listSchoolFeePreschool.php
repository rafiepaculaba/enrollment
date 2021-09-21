
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
require_once('modules/SchoolFees/SchoolFeePreschool.php');
require_once('modules/Config/ConfigPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Preschool School Fee");
if ($access->check_access($current_user->id,$accessCode)) {

	// get all default setting from configs
	$config = new Config();
	$fee = new SchoolFee();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;
	
	if ($_GET['cmdFilter']) {	
		$schYear   	= $_GET['schYear'];
		$feeID   	= $_GET['feeID'];
		$yrLevel   	= $_GET['yrLevel'];
		$item   	= $_GET['item'];
	} else {
		$schYear     	= $_SESSION[$_GET['module'].'Preschool_schYear'];
		$feeID     		= $_SESSION[$_GET['module'].'Preschool_feeID'];
		$yrLevel     	= $_SESSION[$_GET['module'].'Preschool_yrLevel'];
		$item     		= $_SESSION[$_GET['module'].'Preschool_item'];
	}
	if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'Preschool_schYear'])) {
	// get the default schYear
	$schYear = $config->getConfig('School Year');
	}

	//set session variables
	$_SESSION[$_GET['module'].'Preschool_schYear']	= $schYear;
	$_SESSION[$_GET['module'].'Preschool_feeID']		= $feeID;
	$_SESSION[$_GET['module'].'Preschool_yrLevel']	= $yrLevel;
	$_SESSION[$_GET['module'].'Preschool_item']		= $item;

	if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['schYear'] = " = '$schYear' ";
        }
    }

   	if (trim($feeID)!='') {
        if (count($conds[0])) {
            $conds[0][' AND feeID'] = " = '$feeID' ";
        } else {
            $conds[0]['feeID'] = " = '$feeID' ";
        }
    }
    
   	if ($yrLevel) {
        if (count($conds[0])) {
            $conds[0][' AND yrLevel'] = " = '$yrLevel' ";
        } else {
            $conds[0]['yrLevel'] = " = '$yrLevel' ";
        }
    }

   	if (trim($item)!='') {
        if (count($conds[0])) {
            $conds[0][' AND item'] = " like '$item%' ";
        } else {
            $conds[0]['item'] = " like '$item%' ";
        }
    }

//    $allSchoolFees = $fee->retrieveAllSchoolFees($conds);
    $allSchoolFees = $fee->countAllSchoolFees($conds);
	$list          = $fee->retrieveAllSchoolFees($conds,"item","ASC",$offset, $limit);
	
//	if ($allSchoolFees)
//		$total_rec=count($allSchoolFees);
//	else 
//		$total_rec=0;
	$total_rec=$allSchoolFees;
		
	$main_url="index.php?module=SchoolFees&action=listSchoolFeesPreschool&feeID=$feeID&schYear=$schyear&yrLevel=$yrLevel&item=$item";

    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" >'."\n";
	$schoolYear.='<option value="">---------------</option>'."\n";
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
	$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);

	$yearLevel='<select name="yrLevel" id="yrLevel" >'."\n";
    $yearLevel.='<option value="">-------------------------</option>'."\n";
    if ($preschool_yrs) {
        foreach ($preschool_yrs as $key=>$value) {
            if ($key==$yrLevel) {
                $yearLevel .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $yearLevel .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $yearLevel.='</select>';
    $sugar_smarty->assign('YEARLEVEL', $yearLevel);
    
	if (!count($list)) {
    	$list = "";
    }

	$sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('feeID', $feeID );
	$sugar_smarty->assign('schYear', $schYear );
	$sugar_smarty->assign('yrLevel', $yrLevel );
	$sugar_smarty->assign('item', $item );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
		
	echo $sugar_smarty->fetch('modules/SchoolFees/templates/listSchoolFeePreschool.tpl');
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