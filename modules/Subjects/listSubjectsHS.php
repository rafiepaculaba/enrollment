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
require_once('modules/Subjects/SubjectHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List HS Subject");
if ($access->check_access($current_user->id,$accessCode)) {
	
	$subj = new Subject();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;
	
	if ($_GET['cmdFilter']) {
		$subjCode	= $_GET['subjCode'];
		$descTitle  = $_GET['descTitle'];
		$yrLevel   	= $_GET['yrLevel'];
	} else {
		$subjCode     	= $_SESSION[$_GET['module'].'HS_subjCode'];			
		$descTitle     	= $_SESSION[$_GET['module'].'HS_descTitle'];			
		$yrLevel     	= $_SESSION[$_GET['module'].'HS_yrLevel'];			
	}
		
	//set session variables
	$_SESSION[$_GET['module'].'HS_subjCode']	= $subjCode;
	$_SESSION[$_GET['module'].'HS_descTitle']   = $descTitle;
	$_SESSION[$_GET['module'].'HS_yrLevel']   	= $yrLevel;
	
	if ($subjCode) {
	    $conds[0]['subjCode'] = " like '$subjCode%' AND ";
	}
	
	if ($descTitle) {
	    $conds[0]['descTitle'] = " like '$descTitle%' AND ";
	}
	
	if ($yrLevel) {
	   $conds[0]['yrLevel'] = " = '$yrLevel' AND ";
	}
	
	$conds[0]['rstatus'] = "= 1 ";
	
//	$allSubjects = $subj->retrieveAllSubjects($conds);
	$allSubjects = $subj->countAllSubjects($conds);
	$list        = $subj->retrieveAllSubjects($conds,"subjCode","ASC",$offset, $limit);
		
//	if ($allSubjects)
//		$total_rec=count($allSubjects);
//	else 
//		$total_rec=0;
	$total_rec=$allSubjects;
		
	$main_url="index.php?module=Subjects&action=listSubjectsHS&subjCode=$subjCode&descTitle=$descTitle&yrLevel=$yrLevel";
	
    if (!count($list)) {
    	$list = "";
    }

	$sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('subjCode', $subjCode );
	$sugar_smarty->assign('descTitle', $descTitle );
	$sugar_smarty->assign('yrLevel', $yrLevel );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
	
	echo $sugar_smarty->fetch('modules/Subjects/templates/listSubjectsHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>
<script language="javascript">
$('subjCode').focus()
</script>