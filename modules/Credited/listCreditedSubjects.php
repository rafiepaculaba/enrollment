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
require_once('modules/Config/ConfigCol.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Registrations/Registration.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Credited/CreditedSubject.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE'], false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Credited Subject");
if ($access->check_access($current_user->id,$accessCode)) {

	// get all default setting from configs
    $config = new Config();
	$cre = new CreditedSubject();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;
	
	if ($_GET['cmdFilter']) {
		$schYear 		= $_GET['schYear'];
		$semCode 		= $_GET['semCode'];
		$creID 			= $_GET['creID'];
		$idno   		= $_GET['idno'];
		$subjID   		= $_GET['subjID'];
		$eqSubj   		= $_GET['eqSubj'];
		$eqUnits   		= $_GET['eqUnits'];
	} else {
		$schYear     	= $_SESSION[$_GET['module'].'Col_schYear'];	
		$semCode     	= $_SESSION[$_GET['module'].'Col_semCode'];	
		$creID     		= $_SESSION[$_GET['module'].'Col_creID'];	
		$idno     		= $_SESSION[$_GET['module'].'Col_idno'];	
		$subjID     	= $_SESSION[$_GET['module'].'Col_subjID'];	
		$eqSubj     	= $_SESSION[$_GET['module'].'Col_eqSubj'];	
		$eqUnits     	= $_SESSION[$_GET['module'].'Col_eqUnits'];	
	}
	
	if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'Col_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }
    
    if (!isset($_GET['semCode']) && !isset($_SESSION[$_GET['module'].'Col_semCode'])) {
        // get the default semester
        $semCode = $config->getConfig('Semester');
    }
	
	//set session variables
	$_SESSION[$_GET['module'].'Col_schYear']	= $schYear;
	$_SESSION[$_GET['module'].'Col_semCode']	= $semCode;
	$_SESSION[$_GET['module'].'Col_creID']		= $creID;
	$_SESSION[$_GET['module'].'Col_idno']		= $idno;
	$_SESSION[$_GET['module'].'Col_subjID']		= $subjID;
	$_SESSION[$_GET['module'].'Col_eqSubj']		= $eqSubj;
	$_SESSION[$_GET['module'].'Col_eqUnits']	= $eqUnits;
		
	if ($schYear) {
	    $conds[0]['schYear'] = "= '$schYear' AND ";
	}
	if ($semCode) {
	    $conds[0]['semCode'] = "= '$semCode' AND ";
	}
	if (trim($creID)!='') {
	    $conds[0]['creID'] = "= '$creID' AND ";
	}
	if (trim($idno)!='') {
	    $conds[0]['idno'] = "= '$idno' AND ";
	}
	if ($subjID) {
	    $conds[0]['subjID'] = "= '$subjID' AND ";
	}
	if (trim($eqSubj)!='') {
	    $conds[0]['eqSubj'] = " like '$eqSubj%' AND ";
	}
	if (trim($eqUnits)!='') {
	    $conds[0]['eqUnits'] = "= '$eqUnits' AND ";
	}
	    $conds[0]['rstatus'] = "= '1'";
    
//	$allCreditedSubjects = $cre->retrieveAllCreditedSubjects($conds);
	$allCreditedSubjects = $cre->countAllCreditedSubjects($conds);
	$list        = $cre->retrieveAllCreditedSubjects($conds,"creID","ASC",$offset, $limit);
	
//	if ($allCreditedSubjects)
//		$total_rec=count($allCreditedSubjects);
//	else 
//		$total_rec=0;
		$total_rec=$allCreditedSubjects;

	$main_url="index.php?module=Credited&action=listCreditedSubjects&creID=$creID&schYear=$schYear&semCode=$semCode&idno=$idno&subjID=$subjID&eqSubj=$eqSubj&eqUnits=$eqUnits";

	//semester
	$semesters='<select name="semCode" id="semCode" >'."\n";
    $semesters.='<option value="">-------------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$semCode	) {
                $semesters .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $semesters.='</select>';
    $sugar_smarty->assign('SEMESTERS', $semesters);
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear">'."\n";
	$schoolYear.='<option value="">-------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	        if ($value==$schYear) {
	           $schoolYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $schoolYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$schoolYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);

	if (!count($list)) {
    	$list = "";
    }

	$sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('creID', $creID );
	$sugar_smarty->assign('schYear', $schYear );
	$sugar_smarty->assign('semCode', $semCode );
	$sugar_smarty->assign('idno', $idno );
	$sugar_smarty->assign('subjID', $subjID );
	$sugar_smarty->assign('eqSubj', $eqSubj );
	$sugar_smarty->assign('eqUnits', $eqUnits );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
	
	
	$subj = new Subject();
    $sugar_smarty->assign('subjlist', $subj->retrieveAllSubjects() );
	
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Credited/templates/listCreditedSubjects.tpl');
	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>
<script language="javascript">
$('creID').focus();
</script>