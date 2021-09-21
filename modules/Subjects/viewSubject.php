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
require_once('modules/Curriculums/Equivalency.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$equivalency = new Equivalency();
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Col Subject");
if ($access->check_access($current_user->id,$accessCode)) {
	
	$subjID = $_GET['subjID'];
	
	// check if fromt the adding role form
    if ( isset($_POST["cmdAddEquivalence"]) ) {
        $subjID = $_POST['subjID'];
        
        // from adding roles operation
        // post the newly add roles to the user group template
        if ( !empty($_POST['chkAdd']) ) {
            $equivalency->subjID = $subjID;
            
            foreach ($_POST['chkAdd'] as $theSubjID) {
                // add the role to the user group
                $equivalency->eqSubjID  = $theSubjID;
                $equivalency->createEquivalency();
            }
        }
    }
    
    // check if from the delete role form
    if ( isset($_POST["cmdDeleteSubject"]) ) {
        $subjID = $_POST['subjID'];
        
        // from delete roles operation
        // update roles of the user group template
        if ( !empty($_POST['chkDelete']) ) {
            $equivalency->subjID = $subjID;
            
            foreach ($_POST['chkDelete'] as $theSubjID) {
                // delete the role from the user group
                $equivalency->eqID  = $theSubjID;
                $equivalency->deleteEquivalency();
            }
        }
    }

	$subj = new Subject($subjID);
	
	switch ($subj->type)
	{
		case 1:
			$type = "Lec";
		break;
		case 2:
			$type = "Lab";
		break;	
	}

	switch ($subj->isCompSubj)
	{
		case 0:
			$isCompSubj = "No";
		break;
		case 1:
			$isCompSubj = "Yes";
		break;	
	}

	$sugar_smarty->assign('subjID', $subj->subjID );
	$sugar_smarty->assign('courseID', $subj->courseID );
	$sugar_smarty->assign('subjCode', $subj->subjCode );
	$sugar_smarty->assign('yrLevel', $subj->yrLevel);
	$sugar_smarty->assign('descTitle', $subj->descTitle );
	$sugar_smarty->assign('subjDesc', $subj->subjDesc );
	$sugar_smarty->assign('units', $subj->units );
	$sugar_smarty->assign('type', $type );
	$sugar_smarty->assign('isCompSubj', $isCompSubj );
	$sugar_smarty->assign('rstatus', $subj->rstatus );
	
	$sugar_smarty->assign('courseCode', $subj->courseCode );
	
	$theEquivalence = $subj->retrieveEquivalence($subj->subjID);
	$sugar_smarty->assign('theEquivalence', $theEquivalence );
	
	if ($theEquivalence) {
		$all_ready_exist = "(";
		$ctr=0;
		foreach ($theEquivalence as $row) {
			if ($ctr==0) {
				$all_ready_exist .= $row['eqID'];
			} else {
				$all_ready_exist .= ",".$row['eqID'];
			}
			
			$ctr++;
		}
		$all_ready_exist .= ")";
	}
	
	// get all subjects excluding the already exist
	unset($where);
	if ($all_ready_exist) {
		$where[0]['subjID not in '] = $all_ready_exist;
	}
	
	$allSubjects = $subj->retrieveAllSubjects($where,'subjCode');
	$sugar_smarty->assign('allSubjects', $allSubjects );
	
	// to check if the user has an access in edit
    $accessCode = $access->getAccessCode("Edit Col Subject");
    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
    
    // to check if the user has an access in delete
    $accessCode = $access->getAccessCode("Delete Col Subject");
    $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );

	
	echo $sugar_smarty->fetch('modules/Subjects/templates/viewSubject.tpl');
	echo $sugar_smarty->fetch('modules/Subjects/templates/listEquivalency.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script language="javascript">
function deleteSubject(subjID)
{
    reply=confirm("Do you really want to delete this Subject?");
    
    if (reply==true)
        redirect('index.php?module=Subjects&action=deleteSubject&subjID='+subjID);
}



function displayWindow(divId,title) {
    var w, h, l, t;
    w = 500;
    h = 300;
    l = screen.width/4;
    t = screen.height/4;
    
    if (navigator.appName=="Microsoft Internet Explorer") {
        l = 300 + document.body.scrollLeft;
        t = h + document.body.scrollTop;
    } else {
        l = 300 + document.body.scrollLeft;
        t = h + document.body.scrollTop;
    }

    // with title		        
    displayFloatingDiv(divId, title, w, h, l, t);
}

</script>