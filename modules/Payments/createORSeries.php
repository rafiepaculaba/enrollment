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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Col OR Series");
if ($access->check_access($current_user->id,$accessCode)) {
    
    //User list cashier
	$user   = new User2($current_user->id);
	if ($user->groupID==13) {
		// the current user is a college instructor
		$where[0]['id'] = "='".$user->id."' "; 
	    $sugar_smarty->assign('isCashierGroup', 1);
	    $profID=$user->id;
	} else {
		//User list
		$where[0]['groupID']="=13";
		$sugar_smarty->assign('isCashierGroup', 0);
	}
	
	$user_list = $user->retrieveAllUsers($where,'');
	$sugar_smarty->assign('user_list', $user_list);
	
	$sugar_smarty->assign('date', date('Y'));
    
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Payments/templates/createORSeries.tpl');
//	calendarSetup('fiscalYear', 'jscal_trigger');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script>
addToValidate('frmORSeries','fiscalYear', '', true, 'Fiscal Year');
addToValidate('frmORSeries','firstORNO', '', true, 'First OR number');
addToValidate('frmORSeries','lastORNO', '', true, 'Last OR number');
addToValidate('frmORSeries','cashier', '', true, 'Cashier');
</script>

<script language="javascript">
$('firstORNO').focus();

function saveORSeries() {
    if (check_form('frmORSeries')) {
        if(parseInt($('firstORNO').value) <= parseInt($('lastORNO').value)) {
            checkDuplicate();
        } else {
            alert('First OR number should not greater than last OR number!!');
        }
    }
}

function checkDuplicate()
{
    get_data="fiscalYear=" + $('fiscalYear').value + "&firstORNO=" + $('firstORNO').value + "&lastORNO=" + $('lastORNO').value + "&action=checkorseries";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","checkORSeriesHandle");
}

function checkORSeriesHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret==-1) {
    		// ID No. duplicate
            $('frmORSeries').submit();
    	} else if (ret==1) {
    		// can't continue saving coz has no item
    		msg="Duplicate OR Series No.";
    		displayError(msg);
    	}
    }
}

</script>