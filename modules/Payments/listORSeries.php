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
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Payments/ORSeries.php');


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Col OR Series");
if ($access->check_access($current_user->id,$accessCode)) {
	
	$orseries = new ORSeries();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;
	
	if ($_GET['cmdFilter']) {
		$id           = $_GET['id'];
		$fiscalYear   = $_GET['fiscalYear'];
		$firstORNO    = $_GET['firstORNO'];
		$lastORNO     = $_GET['lastORNO'];
		$cashier      = $_GET['cashier'];
		$rstatus      = $_GET['rstatus'];
	} else {
		$id     	  = $_SESSION[$_GET['module'].'Col_id'];
		$fiscalYear   = $_SESSION[$_GET['module'].'Col_fiscalYear'];
		$firstORNO    = $_SESSION[$_GET['module'].'Col_firstORNO'];
		$lastORNO     = $_SESSION[$_GET['module'].'Col_lastORNO'];
		$cashier      = $_SESSION[$_GET['module'].'Col_cashier'];
		$rstatus      = $_SESSION[$_GET['module'].'Col_rstatus'];
	}
	
	//set session variables
	$_SESSION[$_GET['module'].'Col_id']            = $id;
	$_SESSION[$_GET['module'].'Col_fiscalYear']    = $fiscalYear;
	$_SESSION[$_GET['module'].'Col_firstORNO']     = $firstORNO;
	$_SESSION[$_GET['module'].'Col_lastORNO']      = $lastORNO;
	$_SESSION[$_GET['module'].'Col_cashier']       = $cashier;
	$_SESSION[$_GET['module'].'Col_rstatus']       = $rstatus;

    //User list cashier
	$user   = new User2($current_user->id);
	unset($where);
	if ($user->groupID==13) {
		// the current user is a college instructor
		$where[0]['id'] = "='".$user->id."' "; // assuming 6-default groupID of College Professor
	    $sugar_smarty->assign('isCashierGroup', 1);
	    $cashier=$user->id;
	} else {
		//User list
		$where[0]['groupID']="=13";
		$sugar_smarty->assign('isCashierGroup', 0);
	}

	$user_list = $user->retrieveAllUsers($where,'');
	$sugar_smarty->assign('user_list', $user_list);

	
    if ($id) {
        if (count($conds[0])) {
            $conds[0][' AND id'] = " = '$id' ";
        } else {
            $conds[0]['id'] = " = '$id' ";
        }
    }
	
    if ($fiscalYear) {
        if (count($conds[0])) {
            $conds[0][' AND fiscalYear'] = " = '$fiscalYear' ";
        } else {
            $conds[0]['fiscalYear'] = " = '$fiscalYear' ";
        }
    }
	    
    if ($firstORNO) {
        if (count($conds[0])) {
            $conds[0][' AND firstORNO'] = " = '$firstORNO' ";
        } else {
            $conds[0]['firstORNO'] = " = '$firstORNO' ";
        }
    }

    if ($lastORNO) {
        if (count($conds[0])) {
            $conds[0][' AND lastORNO'] = " = '$lastORNO' ";
        } else {
            $conds[0]['lastORNO'] = " = '$lastORNO' ";
        }
    }

    if ($cashier) {
        if (count($conds[0])) {
            $conds[0][' AND cashier'] = " = '$cashier' ";
        } else {
            $conds[0]['cashier'] = " = '$cashier' ";
        }
    }

    if ($rstatus!='') {
        if (count($conds[0])) {
            $conds[0][' AND rstatus'] = " = '$rstatus' ";
        } else {
            $conds[0]['rstatus'] = " = '$rstatus' ";
        }
    }

	$allorseries   = $orseries->retrieveAllORSeries($conds);
	$list          = $orseries->retrieveAllORSeries($conds,"id","ASC",$offset, $limit);
	
	if ($allorseries)
		$total_rec=count($allorseries);
	else 
		$total_rec=0;
		
	$main_url="index.php?module=Payments&action=listORSeries&id=$id&fiscalYear=$fiscalYear&firstORNO=$firstORNO&lastORNO=$lastORNO&cashier=$cashier$lastORNO&rstatus=$rstatus";
	
	if (!count($list)) {
    	$list = "";
    }

	$sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('id', $id );
	$sugar_smarty->assign('fiscalYear', $fiscalYear );
	$sugar_smarty->assign('firstORNO', $firstORNO );
	$sugar_smarty->assign('lastORNO', $lastORNO );
	$sugar_smarty->assign('cashier', $cashier );
	$sugar_smarty->assign('rstatus', $rstatus );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Payments/templates/listORSeries.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>
<script language="javascript" >
$('id').focus();
</script>