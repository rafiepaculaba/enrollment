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
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');
require_once('modules/Curriculums/Equivalency.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_EQ'], $mod_strings['LBL_MODULE_TITLE_EQ']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Equivalency");
if ($access->check_access($current_user->id,$accessCode)) {
    $equivalency = new Equivalency();
    $subject    = new Subject();
    $sugar_smarty->assign('subjectList', $subject->retrieveAllSubjects() );
    
    $limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
    $offset = $_GET['offset']? $_GET['offset']:0;
    
    if ($_GET['cmdFilter']) {
        $eqID     = trim($_GET['eqID']);
        $curID    = trim($_GET['curID']);
        $subjID   = trim($_GET['subjID']);
        $eqSubjID = trim($_GET['eqSubjID']);
    } else {
        $eqID     = $_SESSION[$_GET['module'].'Eq_eqID'];
        $curID    = $_SESSION[$_GET['module'].'Eq_curID'];
        $subjID   = $_SESSION[$_GET['module'].'Eq_subjID'];
        $eqSubjID = $_SESSION[$_GET['module'].'Eq_eqSubjID'];
    }
    
    $_SESSION[$_GET['module'].'Eq_eqID']     = $eqID;
    $_SESSION[$_GET['module'].'Eq_curID']    = $curID;
    $_SESSION[$_GET['module'].'Eq_subjID']   = $subjID;
    $_SESSION[$_GET['module'].'Eq_eqSubjID'] = $eqSubjID;
    
    if ($eqID!="") {
        $conds[0]['e.eqID'] = " = '$eqID' AND ";  
    }
    
    if ($curID!="") {
        $conds[0]['e.curID'] = " = '$curID' AND ";
    }
    
    if ($subjID) {
        $conds[0]['e.subjID'] = " = '$subjID' AND ";
    }
    
    if ($eqSubjID) {
        $conds[0]['e.eqSubjID'] = " = '$eqSubjID' AND ";
    }
    
    $conds[0]['s.subjID'] = "= e.subjID AND ";
    $conds[0]['e.rstatus'] = "= 1 ";
    
    $allEquivalency = $equivalency->retrieveAllEquivalency($conds);
    $list           = $equivalency->retrieveAllEquivalency($conds,"s.subjCode","ASC",$offset, $limit);
    
   
    // get the subjCode and subjDescTitle of the eqSubjID
    if ($list) {
        $data = array();
        $ctr  = 0;
        foreach ($list as $row) {
            $subject->subjID = $row['eqSubjID'];
            $subject->retrieveSubject();
            $row['eqSubjCode']      = $subject->subjCode;
            $row['eqSubjDescTitle'] = $subject->descTitle;
            
            $data[$ctr]=$row;
            
            $ctr++;
        }
        if ($data) {
            $list = $data;
        }
    }
    	
    if ($allEquivalency)
    	$total_rec=count($allEquivalency);
    else 
    	$total_rec=0;
    	
    $main_url="index.php?module=Curriculums&action=listEquivalency&eqID=$eqID&curID=$curID&subjID=$subjID&eqSubjID=$eqSubjID";
    
    // check if the list is empty
    if (!count($list)) {
        $list = "";
    }
    
    $sugar_smarty->assign('list', $list );
    $sugar_smarty->assign('eqID', $eqID );
    $sugar_smarty->assign('curID', $curID );
    $sugar_smarty->assign('subjID', $subjID );
    $sugar_smarty->assign('eqSubjID', $eqSubjID );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
    
    echo $sugar_smarty->fetch('modules/Curriculums/templates/listEquivalency.tpl');
} else {
    $msg = "Sorry, you dont have permission to access this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script type='text/javascript'>
$('eqID').focus();
</script>