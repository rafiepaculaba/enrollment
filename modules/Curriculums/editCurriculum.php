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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_CUR'], $mod_strings['LBL_MODULE_TITLE_CUR']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$course = new Course();
$sugar_smarty->assign('courseList', $course->retrieveAllCourses() );

$curID = $_GET['curID'];
$curriculum = new Curriculum($curID);

$sugar_smarty->assign('curID', $curID );
$sugar_smarty->assign('curName', $curriculum->curName );
$sugar_smarty->assign('courseID', $curriculum->courseID );
$sugar_smarty->assign('courseCode', $curriculum->courseCode );
$sugar_smarty->assign('effectivity', $curriculum->effectivity );
$sugar_smarty->assign('major', $curriculum->major );
$sugar_smarty->assign('remarks', $curriculum->remarks );
$sugar_smarty->assign('rstatus', $curriculum->rstatus );
// list for subject
$sugar_smarty->assign('subj11', $curriculum->subjects11 );
$sugar_smarty->assign('subj11_ctr', count($curriculum->subjects11) );
$sugar_smarty->assign('subj11_total', $curriculum->getTotalUnits($curriculum->subjects11) );
$sugar_smarty->assign('subj12', $curriculum->subjects12 );
$sugar_smarty->assign('subj12_ctr', count($curriculum->subjects12) );
$sugar_smarty->assign('subj12_total', $curriculum->getTotalUnits($curriculum->subjects12) );
$sugar_smarty->assign('subj14', $curriculum->subjects14 );
$sugar_smarty->assign('subj14_ctr', count($curriculum->subjects14) );
$sugar_smarty->assign('subj14_total', $curriculum->getTotalUnits($curriculum->subjects14) );

$sugar_smarty->assign('subj21', $curriculum->subjects21 );
$sugar_smarty->assign('subj21_ctr', count($curriculum->subjects21) );
$sugar_smarty->assign('subj21_total', $curriculum->getTotalUnits($curriculum->subjects21) );
$sugar_smarty->assign('subj22', $curriculum->subjects22 );
$sugar_smarty->assign('subj22_ctr', count($curriculum->subjects22) );
$sugar_smarty->assign('subj22_total', $curriculum->getTotalUnits($curriculum->subjects22) );
$sugar_smarty->assign('subj24', $curriculum->subjects24 );
$sugar_smarty->assign('subj24_ctr', count($curriculum->subjects24) );
$sugar_smarty->assign('subj24_total', $curriculum->getTotalUnits($curriculum->subjects24) );

$sugar_smarty->assign('subj31', $curriculum->subjects31 );
$sugar_smarty->assign('subj31_ctr', count($curriculum->subjects31) );
$sugar_smarty->assign('subj31_total', $curriculum->getTotalUnits($curriculum->subjects31) );
$sugar_smarty->assign('subj32', $curriculum->subjects32 );
$sugar_smarty->assign('subj32_ctr', count($curriculum->subjects32) );
$sugar_smarty->assign('subj32_total', $curriculum->getTotalUnits($curriculum->subjects32) );
$sugar_smarty->assign('subj34', $curriculum->subjects34 );
$sugar_smarty->assign('subj34_ctr', count($curriculum->subjects34) );
$sugar_smarty->assign('subj34_total', $curriculum->getTotalUnits($curriculum->subjects34) );

$sugar_smarty->assign('subj41', $curriculum->subjects41 );
$sugar_smarty->assign('subj41_ctr', count($curriculum->subjects41) );
$sugar_smarty->assign('subj41_total', $curriculum->getTotalUnits($curriculum->subjects41) );
$sugar_smarty->assign('subj42', $curriculum->subjects42 );
$sugar_smarty->assign('subj42_ctr', count($curriculum->subjects42) );
$sugar_smarty->assign('subj42_total', $curriculum->getTotalUnits($curriculum->subjects42) );
$sugar_smarty->assign('subj44', $curriculum->subjects44 );
$sugar_smarty->assign('subj44_ctr', count($curriculum->subjects44) );
$sugar_smarty->assign('subj44_total', $curriculum->getTotalUnits($curriculum->subjects44) );

$sugar_smarty->assign('subj51', $curriculum->subjects51 );
$sugar_smarty->assign('subj51_ctr', count($curriculum->subjects51) );
$sugar_smarty->assign('subj51_total', $curriculum->getTotalUnits($curriculum->subjects51) );
$sugar_smarty->assign('subj52', $curriculum->subjects52 );
$sugar_smarty->assign('subj52_ctr', count($curriculum->subjects52) );
$sugar_smarty->assign('subj52_total', $curriculum->getTotalUnits($curriculum->subjects52) );
$sugar_smarty->assign('subj54', $curriculum->subjects54 );
$sugar_smarty->assign('subj54_ctr', count($curriculum->subjects54) );
$sugar_smarty->assign('subj54_total', $curriculum->getTotalUnits($curriculum->subjects54) );

$_SESSION['SUBJ11'] = $curriculum->subjects11;
$_SESSION['SUBJ12'] = $curriculum->subjects12;
$_SESSION['SUBJ14'] = $curriculum->subjects14;

$_SESSION['SUBJ21'] = $curriculum->subjects21;
$_SESSION['SUBJ22'] = $curriculum->subjects22;
$_SESSION['SUBJ24'] = $curriculum->subjects24;

$_SESSION['SUBJ31'] = $curriculum->subjects31;
$_SESSION['SUBJ32'] = $curriculum->subjects32;
$_SESSION['SUBJ34'] = $curriculum->subjects34;

$_SESSION['SUBJ41'] = $curriculum->subjects41;
$_SESSION['SUBJ42'] = $curriculum->subjects42;
$_SESSION['SUBJ44'] = $curriculum->subjects44;

$_SESSION['SUBJ51'] = $curriculum->subjects51;
$_SESSION['SUBJ52'] = $curriculum->subjects52;
$_SESSION['SUBJ54'] = $curriculum->subjects54;

$semesters='<select name="semCode" id="semCode">'."\n";
$semesters.='<option value="">------------</option>'."\n";
if ($esConfig['semesters']) {
    foreach ($esConfig['semesters'] as $key=>$value) {
        $semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
    }
}
$semesters.='</select>';
$sugar_smarty->assign('subjectList', $subjectList);
$sugar_smarty->assign('ctr_subj', $ctr_subj);
$sugar_smarty->assign('SEMESTERS', $semesters);

echo $sugar_smarty->fetch('modules/Curriculums/templates/editCurriculum.tpl');

?>

<script>
addToValidate('frmCurriculum','courseID', '', true, 'Course');
addToValidate('frmCurriculum','curName', '', true, 'Curriculum Name');
addToValidate('frmCurriculum','effectivity', '', true, 'Effectivity Year');
</script>

<script>
addToValidate('frmAddSubject','subjID', '', true, 'Subject');
addToValidate('frmAddSubject','yrLevel', '', true, 'Year Level');
addToValidate('frmAddSubject','semCode', '', true, 'Semester Code');
</script>

<script language="javascript">

function displayWindow(divId,title) 
{
    var w, h, l, t;
    w = 400;
    h = 250;
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
    getSubjectPrerequisites();
}

function hideShowDiv(divName)
{
    if ( $(divName).style.display=="Block" || $(divName).style.display=="block" ) {
        $(divName).style.display="None";
        $(divName+"Handle").src="themes/Sugar/images/advanced_search.gif";
    } else {
        $(divName).style.display="Block";
        $(divName+"Handle").src="themes/Sugar/images/basic_search.gif";
    }
}

function goSubmitForm(theForm) 
{
    if (check_form(theForm)) {
        $(theForm).submit();
    }
}

function addPrerequisites()
{
    $('prerequisitesID').value = "";
    $('prerequisites').value   = "";
    
    ctr = $('ctr_subj').value;
    for (var i=0;i<ctr;i++)
    {
        if ( $('prereq'+i).checked ) {
            prereq   = ($('prereq'+i).value).split("-");
            subjID   = prereq[0];
            subjCode = prereq[1];
            if ($('prerequisitesID').value!="") {
                $('prerequisitesID').value += ","+subjID;
                $('prerequisites').value   += ","+subjCode;
            } else {
                $('prerequisitesID').value += subjID;
                $('prerequisites').value   += subjCode;
            }
        }
    }
    hiddenFloatingDiv('windowcontent');
}

function getSubjects()
{
    get_data="courseID=" + $('courseID').value + "&action=getsubjects";
    ajaxQuery("modules/Curriculums/curriculumHandler.php",'GET',get_data,"","onGetSubjectsHandle");
}

function onGetSubjectsHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	if (ret) {
	    	initializeCombo('subjID',"-----------------------------");
			myData = ret.parseJSON();
			for(c = 0; c < myData.length; c++){
		    	var y=document.createElement('option');
				y.text=myData[c].subjCode;				
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

function getSubjectPrerequisites()
{
    get_data="courseID=" + $('courseID').value + "&action=getprerequisites";
    ajaxQuery("modules/Curriculums/curriculumHandler.php",'GET',get_data,"","onGetSubjectPrerequisitesHandle");
}

function onGetSubjectPrerequisitesHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	if (ret) {
	    	$('divSubjectList').innerHTML = ret;
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}


function onAddSubject()
{
    if ( check_form('frmAddSubject') ) {
        get_data="subjID=" + $('subjID').value + "&yrLevel="+$('yrLevel').value+"&semCode="+$('semCode').value+"&prerequisitesID="+$('prerequisitesID').value+"&prerequisites="+$('prerequisites').value+"&action=addsubject";
        ajaxQuery("modules/Curriculums/curriculumHandler.php",'GET',get_data,"","onAddSubjectHandle");
    }
}


function onAddSubjectHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	if (ret) {
	    	yrLevel = $('yrLevel').value;
	    	semCode = $('semCode').value;
	    	$('div'+yrLevel+semCode).innerHTML = ret;
	    	
	    	$('subjID').options[0].selected=true;
	    	$('yrLevel').options[0].selected=true;
	    	$('semCode').options[0].selected=true;
	    	$('prerequisitesID').value="";
	    	$('prerequisites').value="";
	    	
	    	$('subjID').focus();
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}


function removeSubject(subjID,yr,sem)
{
    yrLevel = yr;
    semCode = sem;
    
    get_data="subjID="+subjID + "&yrLevel="+yrLevel + "&semCode="+semCode + "&action=remsubject";
    ajaxQuery("modules/Curriculums/curriculumHandler.php",'GET',get_data,"","onRemoveSubjectHandle");
}

function onRemoveSubjectHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;

    	if (ret) {
	    	$('div'+yrLevel+semCode).innerHTML = ret;
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

// get all subjects
getSubjects();


// set focus
$('courseID').focus();
</script>
