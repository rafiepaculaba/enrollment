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

require_once('config.php');
require_once('include/Sugar_Smarty.php');
require_once('modules/Config/ConfigHS.php');  
require_once('modules/Students/StudentHS.php');
require_once('modules/Subjects/SubjectHS.php');
require_once('modules/Users/User2.php');
require_once('modules/Enrollments/EnrollmentDetailHS.php');
require_once('modules/Enrollments/EnrollmentHS.php');
require_once('modules/Schedules/BlockSectionHS.php');
require_once('modules/Schedules/BlockSectionSubjectHS.php');


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View HS Final Grade");
if ($access->check_access($current_user->id,$accessCode)) {
    $config = new Config();
    $enrollment = new Enrollment();
    
    $limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
    $offset = $_GET['offset']? $_GET['offset']:0;

    if ($_GET['cmdFilter']) {
        $idno   = trim($_GET['idno']);
        $lname  = trim($_GET['lname']);
        $fname  = trim($_GET['fname']);
        $mname  = trim($_GET['mname']);
        $yrLevel = trim($_GET['yrLevel']);
        $schYear = trim($_GET['schYear']);
        $secID   = trim($_GET['secID']);
    } else {
        $idno   = $_SESSION[$_GET['module'].'HSFG_idno'];
        $lname  = $_SESSION[$_GET['module'].'HSFG_lname'];
        $fname  = $_SESSION[$_GET['module'].'HSFG_fname'];
        $mname  = $_SESSION[$_GET['module'].'HSFG_mname'];
        $yrLevel = $_SESSION[$_GET['module'].'HSFG_yrLevel'];
        $schYear = $_SESSION[$_GET['module'].'HSFG_schYear'];
        $secID   = $_SESSION[$_GET['module'].'HSFG_secID'];
    }
    
    if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'HS_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }
    
    if (!isset($_GET['semCode']) && !isset($_SESSION[$_GET['module'].'HS_semCode'])) {
        // get the default semester
        $semCode = $config->getConfig('Semester');
    }
    
    // set session variables
    $_SESSION[$_GET['module'].'HSFG_idno']      = $idno;
    $_SESSION[$_GET['module'].'HSFG_lname']     = $lname;
    $_SESSION[$_GET['module'].'HSFG_fname']     = $fname;
    $_SESSION[$_GET['module'].'HSFG_mname']     = $mname;
    $_SESSION[$_GET['module'].'HSFG_yrLevel']   = $yrLevel;
    $_SESSION[$_GET['module'].'HSFG_schYear']   = $schYear;
    $_SESSION[$_GET['module'].'HSFG_secID']     = $secID;
    
    if ($idno!="") {
        if (count($conds[0])) {
            $conds[0][' AND enrollments.idno'] = "= '$idno' ";
        } else {
            $conds[0]['enrollments.idno'] = "= '$idno' ";
        }
    }
        
    if ($lname!="") {
        if (count($conds[0])) {
            $conds[0][' AND students.lname'] = " like '$lname%' ";
        } else {
            $conds[0]['students.lname'] = " like '$lname%' ";
        }
    }
    
    if ($fname!="") {
        if (count($conds[0])) {
            $conds[0][' AND students.fname'] = " like '$fname%' ";
        } else {
            $conds[0]['students.fname'] = " like '$fname%' ";
        }
    }
    
    if ($mname!="") {
        if (count($conds[0])) {
            $conds[0][' AND students.mname'] = " like '$mname%' ";
        } else {
            $conds[0]['students.mname'] = " like '$mname%' ";
        }
    }
    
    if ($yrLevel) {
        if (count($conds[0])) {
            $conds[0][' AND enrollments.yrLevel'] = " = '$yrLevel' ";
        } else {
            $conds[0]['enrollments.yrLevel'] = " = '$yrLevel' ";
        }
    }

    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND enrollments.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['enrollments.schYear'] = " = '$schYear' ";
        }
    }
    
    if ($secID) {
        if (count($conds[0])) {
            $conds[0][' AND enrollments.secID'] = " = '$secID' ";
        } else {
            $conds[0]['enrollments.secID'] = " = '$secID' ";
        }
    }
    
    if (count($conds[0])) {
        $conds[0][' AND enrollments.rstatus']    = " > 1 ";
    } else {
        $conds[0]['enrollments.rstatus']    = " > 1 ";
    }
    
    $allEnrollments = $enrollment->countAllEnrollments($conds);
    $list           = $enrollment->retrieveAllEnrollments($conds,"enrollments.schYear","DESC",$offset, $limit);

	$total_rec = $allEnrollments;
    	
    $main_url="index.php?module=Grades&action=listEnrollmentsHS&idno=$idno&lname=$lname&fname=$fname&mname=$mname&yrLevel=$yrLevel&schYear=$schYear&semCode=$semCode&secID=$secID";
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$year-2; $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear"  onchange="getSections();">'."\n";
	$schoolYear.='<option value="">---------------</option>'."\n";
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
	
	// block sections
	unset($conds);
	if ($schYear) {
        $conds[0]['schYear']  = " = '$schYear' ";
	}

	if ($yrLevel){
    	if (count($conds[0])){
            $conds[0][' AND yrLevel']  = " = '$yrLevel' ";
    	} else {
            $conds[0]['yrLevel']  = " = '$yrLevel' ";
    	}
	}
    	
    $blocksection = new BlockSection();
    $result  = $blocksection->retrieveAllBlockSections($conds);
    $sugar_smarty->assign('listBlockSections', $result );
	
	// check if the list is empty
    if (!count($list)) {
        $list = "";
    }
    $sugar_smarty->assign('list', $list );
    $sugar_smarty->assign('idno', $idno );
    $sugar_smarty->assign('lname', $lname );
    $sugar_smarty->assign('fname', $fname );
    $sugar_smarty->assign('mname', $mname );
    $sugar_smarty->assign('yrLevel', $yrLevel );
    $sugar_smarty->assign('schYear', $schYear );
    $sugar_smarty->assign('secID', $secID );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit,$export_link,$print_link) );
    
    echo $sugar_smarty->fetch('modules/Grades/templates/listEnrollmentsHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script type='text/javascript'>

function getSections()
{
    get_data="schYear=" + $('schYear').value + "&yrLevel=" + $('yrLevel').value + "&action=getsectionshs2";
    ajaxQuery("modules/Enrollments/enrollmentHandler.php",'GET',get_data,"","onGetSectionsHandle");
    
}

function onGetSectionsHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;

    	if (ret) {
    	    
	    	initializeCombo('secID',"-------");
			myData = ret.parseJSON();
			for(c = 0; c < myData.length; c++){
		    	var y=document.createElement('option');
				y.text=myData[c].secName;				
				y.setAttribute('value',myData[c].secID);		
				var x=$('secID');

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



// set focus
$('idno').focus();

</script>