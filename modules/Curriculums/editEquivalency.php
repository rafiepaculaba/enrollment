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
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Equivalency");
if ($access->check_access($current_user->id,$accessCode)) {
    $curriculum = new Curriculum();
    $currSubj   = new CurriculumSubject();
    $subject    = new Subject();
    $sugar_smarty->assign('curList', $curriculum->retrieveAllCurriculums() );  
    $sugar_smarty->assign('cursubjectList', $currSubj->retrieveAllCurriculumSubjects() );
    $sugar_smarty->assign('subjectList', $subject->retrieveAllSubjects() );
    $eqID = $_GET['eqID'];
    $equivalency = new Equivalency($eqID);
    $sugar_smarty->assign('eqID', $equivalency->eqID );
    $sugar_smarty->assign('curID', $equivalency->curID );
    $sugar_smarty->assign('subjID', $equivalency->subjID );
    $sugar_smarty->assign('eqSubjID', $equivalency->eqSubjID );
    $sugar_smarty->assign('rstatus', $equivalency->rstatus );
    
    echo $sugar_smarty->fetch('modules/Curriculums/templates/editEquivalency.tpl');
} else {
    $msg = "Sorry, you dont have permission to access this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}  
?>

<script language="javascript">
function getSubjects()
{
    get_data="curID=" + $('curID').value + "&action=getcursubjects";
    ajaxQuery("modules/Curriculums/curriculumHandler.php",'GET',get_data,"","onGetSubjectsHandle");
}

function onGetSubjectsHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	if (ret) {
	    	initializeCombo('subjID',"---------------------------------------------------------------------------------------------------------");
			myData = ret.parseJSON();
			for(c = 0; c < myData.length; c++){
		    	var y=document.createElement('option');
				y.text=myData[c].subjCode + " - " + myData[c].descTitle + " (" + myData[c].units + ")";				
				y.setAttribute('value',myData[c].subjID);		
				var x=$('subjID');

				if (navigator.appName=="Microsoft Internet Explorer") {
					x.add(y); // IE only  
				} else {
					x.add(y,null);
				}
			}	
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}


</script>

<script>
addToValidate('frmEquivalency','curID', '', true, 'Curriculum');
addToValidate('frmEquivalency','subjID', '', true, 'Subject');
addToValidate('frmEquivalency','eqSubjID', '', true, 'Equivalent Subject');

// set focus
$('curID').focus();

// get all subjects fall under in the curriculum
getSubjects();
</script>