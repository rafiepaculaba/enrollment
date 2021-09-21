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
global $college_yrs;

require_once('include/Sugar_Smarty.php');

require_once('common.php');

require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Registrations/Registration.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Col Student");
if ($access->check_access($current_user->id,$accessCode)) {
    // if comes from registration
    $regID = $_GET['regID'];
    
    $reg = new Registration($regID);
    $course = new Course();
    $sugar_smarty->assign('courseList', $course->retrieveAllCourses() );
    
    $curriculum = new Curriculum();
    $sugar_smarty->assign('curList', $curriculum->retrieveAllCurriculums() );
    
    $sugar_smarty->assign('regID', $reg->regID );
    $sugar_smarty->assign('fname', $reg->fname );
    $sugar_smarty->assign('lname', $reg->lname );
    $sugar_smarty->assign('mname', $reg->mname );
    $sugar_smarty->assign('gender', $reg->gender );
    $sugar_smarty->assign('age', $reg->age );
    $sugar_smarty->assign('entryDocs', $reg->entryDocs );
    
    // bday
    $bday = explode("-",$reg->bday);
    $year = $bday[0];
    $mon  = $bday[1];
    $day  = $bday[2];
    
    $sugar_smarty->assign('cstatus', $reg->cstatus );
    $sugar_smarty->assign('nationality', $reg->nationality? $reg->nationality:"Filipino" );
    $sugar_smarty->assign('lastSchool', $reg->lastSchool );
    
    // months list
    $months=array(
    1=>'January',
    2=>'February',
    3=>'March',
    4=>'April',
    5=>'May',
    6=>'June',
    7=>'July',
    8=>'August',
    9=>'September',
    10=>'October',
    11=>'November',
    12=>'December'
    );
    
    $month_object = '<select name="month" id="month">'."\n";
    $month_object .= '<option value="">------</option>'."\n";
    foreach ($months as $key=>$month) {
        if ($key==$mon)
            $month_object .= '<option value="'.$key.'" selected>'.$month.'</option>'."\n";
        else
            $month_object .= '<option value="'.$key.'">'.$month.'</option>."\n"';
    }
    $month_object .= '</select>'."\n";
    
    $sugar_smarty->assign('month_object', $month_object );
    
    $day_object = '<select name="day" id="day">'."\n";
    $day_object .= '<option value="">---</option>'."\n";
    for($i=1; $i<=31; $i++) {
        if ($i==$day)
            $day_object .= '<option value="'.$i.'" selected>'.$i.'</option>'."\n";
        else
            $day_object .= '<option value="'.$i.'">'.$i.'</option>'."\n";
    }
    $day_object .= '</select>'."\n";
    
    $sugar_smarty->assign('day_object', $day_object );
    $sugar_smarty->assign('year', $year );
    
    
    // year levels
    $yrLevel_object = '<select name="yrLevel" id="yrLevel">'."\n";
    $yrLevel_object .= '<option value="">--------</option>'."\n";
    foreach ($college_yrs as $key=>$val) {
        if ($key==$yrLevel)
            $yrLevel_object .= '<option value="'.$key.'" selected>'.$val.'</option>'."\n";
        else
            $yrLevel_object .= '<option value="'.$key.'">'.$val.'</option>."\n"';
    }
    $yrLevel_object .= '</select>'."\n";
    $sugar_smarty->assign('yrLevel_object', $yrLevel_object );
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Students/templates/createStudent.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


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
}

function checkDuplicate()
{
    if (check_form('frmStudent')) {
        get_data="idno=" + $('idno').value + "&action=checkDuplicate_col";
        ajaxQuery("modules/Students/studentHandler.php",'GET',get_data,"","checkDuplicateHandle");
    }
}

function checkDuplicateHandle() 
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret=='') {
    		redirect('index.php?module=Students&action=createStudent&regID=<?php echo $_GET['regID']; ?>'); // redirect to entry page
    	} else {
	    	if (ret==-1) {
	    		// ID No. duplicate
                //$('frmStudent').submit();
                document.frmStudent.submit();
	    	} else if (ret==1) {
	    		// can't continue saving coz has no item
	    		msg="Duplicate Student ID No.";
	    		displayError(msg);
	    	}
    	}
    }
}


function getCurriculums()
{
    get_data="courseID=" + $('courseID').value + "&action=getcurriculums";
    ajaxQuery("modules/Students/studentHandler.php",'GET',get_data,"","onCurriculumDisplay");
}

function onCurriculumDisplay() 
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	
    	if (ret=='') {
    		redirect('index.php?module=Students&action=createStudent&regID=<?php echo $_GET['regID']; ?>'); // redirect to entry page
    	} else {
	    	initializeCombo('curID',"----------------------------------------");
			myData = ret.parseJSON();
			for(c = 0; c < myData.length; c++){
		    	var y=document.createElement('option');
		    	
		    	if (trim(myData[c].major)!="") {
				    y.text=myData[c].curName + " major in " + myData[c].major;				
		    	} else {
		    	    y.text=myData[c].curName;				
		    	}
		    	
				y.setAttribute('value',myData[c].curID);		
				var x=$('curID');

				if (navigator.appName=="Microsoft Internet Explorer") {
					x.add(y); // IE only  
				} else {
					x.add(y,null);
				}
			}	
    	}
    }
}

// set focus
$('idno').focus();

</script>

<script>
addToValidate('frmStudent','idno', '', true, 'Student ID No.');
addToValidate('frmStudent','lname', '', true, 'Last Name');
addToValidate('frmStudent','fname', '', true, 'First Name');
addToValidate('frmStudent','mname', '', true, 'Middle Name');
//addToValidate('frmStudent','curID', '', true, 'Curriculum');
//addToValidate('frmStudent','courseID', '', true, 'Course');
//addToValidate('frmStudent','yrLevel', '', true, 'Year');
//addToValidate('frmStudent','age', '', true, 'Age');
//addToValidate('frmStudent','month', '', true, 'Birth Month');
//addToValidate('frmStudent','day', '', true, 'Birth Date');
//addToValidate('frmStudent','year', '', true, 'Birth Year');
addToValidate('frmStudent','cstatus', '', true, 'Civil Status');
addToValidate('frmStudent','gender', '', true, 'Gender');
//addToValidate('frmStudent','nationality', '', true, 'Nationality');
//addToValidate('frmStudent','permanentAddr', '', true, 'Permanent Address');
</script>