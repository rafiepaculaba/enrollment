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
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Credited Subject");
if ($access->check_access($current_user->id,$accessCode)) {

	$cresubj = new CreditedSubject();

	$subj = new Subject();

	$subj_list = $subj->retrieveAllSubjects();
	
	$sugar_smarty->assign('subj_list', $subj_list);
	
	// get all default setting from configs
    $config = new Config();

    // get the default semester
    $default_semCode = $config->getConfig('Semester');
    
    $semesters='<select name="semCode" id="semCode" >'."\n";
    $semesters.='<option value="">-------------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$default_semCode) {
                $semesters .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {	
                $semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $semesters.='</select>';
    $sugar_smarty->assign('SEMESTERS', $semesters);
    
     // get the default school year
    $default_schYear = $config->getConfig('School Year');

    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear">'."\n";
	$schYear.='<option value="">-------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	        if ($value==$default_schYear) {
	           $schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$schYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);

	$yearLevel='<select name="yrLevel" id="yrLevel" onchange="getSubjects();">'."\n";
    $yearLevel.='<option value="">-------------------</option>'."\n";
    if ($college_yrs) {
        foreach ($college_yrs as $key=>$value) {
            if ($key==$yrLevel) {
                $yearLevel .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $yearLevel .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $yearLevel.='</select>';
    $sugar_smarty->assign('YEARLEVEL', $yearLevel);
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Credited/templates/createCreditedSubject.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script>
addToValidate('frmCreditedSubject','idno', '', true, 'ID No.');
addToValidate('frmCreditedSubject','schYear', '', true, 'School Year');
addToValidate('frmCreditedSubject','yrLevel', '', true, 'Year Level');
addToValidate('frmCreditedSubject','semCode', '', true, 'Semester');
addToValidate('frmCreditedSubject','fgrade', '', true, 'Final Grade');
addToValidate('frmCreditedSubject','subjID', '', true, 'Credited Subject');
addToValidate('frmCreditedSubject','eqSubj', '', true, 'Equivalent Subject');
addToValidate('frmCreditedSubject','eqUnits', '', true, 'Equivalent Units');
addToValidate('frmCreditedSubject','school', '', true, 'School');
</script>

<script language="javascript">
function checkDuplicate()
{
        get_data="schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&idno=" + $('idno').value + "&subjID=" + $('subjID').value + "&action=checkduplicate";
        ajaxQuery("modules/Credited/creditedSubjectHandler.php",'GET',get_data,"","checkDuplicateHandle");
}

function checkDuplicateHandle() 
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret=='') {
    		redirect('index.php?module=Credited&action=createCreditedSubject&creID=<?php echo $_GET['creID']; ?>'); // redirect to entry page
    	} else {
	    	if (ret==-1) {
	    		// Credited ID  no duplicate
	    		if(check_form('frmCreditedSubject')){
                	$('frmCreditedSubject').submit();
	    		}
                
	    	} else if (ret==1) {
	    		// can't continue saving coz has no item
	    		msg="Duplicate Credited Subject.";
	    		displayError(msg);
	    	}
	    	
    	}
    }
}

function displayStudentInfo()
{
    get_data="idno=" + $('idno').value + "&action=displaystudentinfos";
    ajaxQuery("modules/Credited/creditedSubjectHandler.php",'GET',get_data,"","onDisplayStudentInfosHandle");
}

function onDisplayStudentInfosHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
    			if(ret == '[]' || ret == '0' ) {
    				alert("ID no. does not exist !!");
    				$('idno').focus();	
    				myData = ret.parseJSON();

				$('name').value= '';	
	   			}
    			else {
	    		myData = ret.parseJSON();
	    		//idnametxt, 
				$('name').value= '';			
				$('name').value=myData[0].fname + " " + myData[0].mname + " " + myData[0].lname;
				
				$('yrLevel').focus();
				$('curID').value = myData[0].curID;
				
				getSubjects();
				
    			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function getSubjects()
{
    get_data="curID=" + $('curID').value + "&action=getsubjects";
    ajaxQuery("modules/Credited/creditedSubjectHandler.php",'GET',get_data,"","onGetSubjectsHandle");
}

function onGetSubjectsHandle()
{
if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		initializeCombo('subjID',"----------------------------------------------------------------------------------------------");
			myData = ret.parseJSON();
			for(c = 0; c < myData.length; c++){
		    	var y=document.createElement('option');
		    	if(myData[c].descTitle){
		    		y.text=myData[c].subjCode+"    "+html_entity_decode(myData[c].descTitle);
		    	}
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

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=430,left = 0,top = 0');");
}

function setIDNO(id)
{
	$('idno').value=id;
	displayStudentInfo();
}


$('idno').focus();
</script>
