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
require_once('modules/Account/ChartAccountMaster.php');
	
echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Preschool School Fee");
if ($access->check_access($current_user->id,$accessCode)) {

	// get all default setting from configs
	$config = new Config();
	// get the default schYear
	$schYear = $config->getConfig('School Year');

	//school year
	$year = date("Y",time());
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" >'."\n";
	$schoolYear.='<option value="">-------------------------</option>'."\n";
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
    
    $accountMaster = new ChartAccountMaster();
    
	$tuition           = $config->getConfig('Tuition Account Code Pre');
	$registration      = $config->getConfig('Reg Account Code Pre');
	$laboratory        = $config->getConfig('Lab Account Code Pre');
	
	// get the account items for school fees
    $where[0]['account_code'] = "='$tuition' || account_code = '$registration' || account_code = '$laboratory'";
    $accountlist = $accountMaster->retrieveAllChartAccountMaster($where);
    
    $alist='<select name="account_code" id="account_code" onchange="assignDesc();">'."\n";
    $alist.='<option value="">---------------------------------------------------</option>'."\n";
    if ($accountlist) {
        foreach ($accountlist as $acct) {
            $alist .= '<option value="'.$acct['account_code'].'">'.$acct['account_name'].'</option>'."\n";
        }
    }
    $alist.='</select>';
    $sugar_smarty->assign('ACCOUNT_LIST', $alist);

	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/SchoolFees/templates/createSchoolFeePreschool.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmSchoolFee','schYear', '', true, 'School Year');
addToValidate('frmSchoolFee','yrLevel', '', true, 'Year Level');
addToValidate('frmSchoolFee','account_code', '', true, 'Particular');
addToValidate('frmSchoolFee','amount', '', true, 'Amount');
//addToValidate('frmSchoolFee','courseID', '', true, 'Course');
//addToValidate('frmSchoolFee','item', '', true, 'Description');
</script>

<script language="javascript">

function assignDesc()
{
    $('item').value=$('account_code').options[$('account_code').selectedIndex].text;
}

function checkDuplicate()
{
    if (check_form('frmSchoolFee')) {
        get_data="schYear=" + $('schYear').value + "&yrLevel=" + $('yrLevel').value + "&item=" + $('item').value + "&action=checkduplicatepreschool";
        ajaxQuery("modules/SchoolFees/schoolfeeHandler.php",'GET',get_data,"","checkDuplicateHandle");
    }
}

function checkDuplicateHandle() 
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret=='') {
    		redirect('index.php?module=SchoolFees&action=createSchoolFeePreschool&feeID=<?php echo $_GET['feeID']; ?>'); // redirect to entry page
    	} else {
	    	if (ret==-1) {
	    		// School Fee valid
                $('frmSchoolFee').submit();
	    	} else if (ret==1) {
	    		// Has duplicate in existing
	    		msg="Duplicate School Fee.";
	    		displayError(msg);
	    	}
    	}
    }
}

$('yrLevel').focus();
</script>