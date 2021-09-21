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
require_once('modules/Config/ConfigHS.php');
require_once('modules/Subjects/SubjectHS.php');
require_once('modules/Users/User2.php');
require_once('modules/Payments/ORHeaderHS.php');
require_once('modules/Payments/ORDetailsHS.php');


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
$accessCode = $access->getAccessCode("List HS OR Header");
if ($access->check_access($current_user->id,$accessCode)) {
	
	$config = new Config();
	$orheader = new ORHeader();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;
	
	if ($_GET['cmdFilter']) {
	    
		$paymentID    = $_GET['paymentID'];
		$orno         = $_GET['orno'];
		$idno         = $_GET['idno'];
		$lname        = $_GET['lname'];
		$fname        = $_GET['fname'];
		$mname        = $_GET['mname'];
		$gender       = $_GET['gender'];
		$accID        = $_GET['accID'];
		$schYear      = $_GET['schYear'];
		$semCode      = $_GET['semCode'];
		$term         = $_GET['term'];
		$dateCreated  = $_GET['dateCreated'];
		$totalAmount  = $_GET['totalAmount'];
		$cashier      = $_GET['cashier'];
		$rstatus      = $_GET['rstatus'];
	} else {
		$paymentID    = $_SESSION[$_GET['module'].'HS_paymentID'];
		$orno         = $_SESSION[$_GET['module'].'HS_orno'];
		$idno         = $_SESSION[$_GET['module'].'HS_idno'];
		$lname        = $_SESSION[$_GET['module'].'HS_lname'];
		$fname        = $_SESSION[$_GET['module'].'HS_fname'];
		$mname        = $_SESSION[$_GET['module'].'HS_mname'];
		$gender       = $_SESSION[$_GET['module'].'HS_gender'];
		$schYear      = $_SESSION[$_GET['module'].'HS_schYear'];
		$semCode      = $_SESSION[$_GET['module'].'HS_semCode'];
		$term         = $_SESSION[$_GET['module'].'HS_term'];
		$dateCreated  = $_SESSION[$_GET['module'].'HS_dateCreated'];
		$totalAmount  = $_SESSION[$_GET['module'].'HS_totalAmount'];
		$cashier      = $_SESSION[$_GET['module'].'HS_cashier'];
		$rstatus      = $_SESSION[$_GET['module'].'HS_rstatus'];
	}
	
	//set session variables
    $_SESSION[$_GET['module'].'HS_paymentID']     = $paymentID;
	$_SESSION[$_GET['module'].'HS_orno']          = $orno;
	$_SESSION[$_GET['module'].'HS_idno']          = $idno;
	$_SESSION[$_GET['module'].'HS_lname']         = $lname;
	$_SESSION[$_GET['module'].'HS_fname']         = $fname;
	$_SESSION[$_GET['module'].'HS_mname']         = $mname;
	$_SESSION[$_GET['module'].'HS_gender']        = $gender;
	$_SESSION[$_GET['module'].'HS_schYear']       = $schYear;
	$_SESSION[$_GET['module'].'HS_semCode']       = $semCode;
	$_SESSION[$_GET['module'].'HS_cashier']       = $cashier;
	$_SESSION[$_GET['module'].'HS_rstatus']       = $rstatus;

    if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'HS_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }
    
    if (!isset($_GET['semCode']) && !isset($_SESSION[$_GET['module'].'HS_semCode'])) {
        // get the default semester
        $semCode = $config->getConfig('Semester');
    }
    
    if (!isset($_SESSION[$_GET['module'].'HS_rstatus'])) {
        // get default status
        $rstatus = 1;
    }
    
    //user 
	$user = new User2($current_user->id);
	unset($where);
	if ($user->groupID==13) {
		// the current user is a cashier
		$where[0]['id'] = "='".$user->id."' "; 
//	    $sugar_smarty->assign('isInstructorGroup', 1);
	    $cashier=$user->id;
	} else {
		//User list
		$where[0]['groupID']="=13";
//		$sugar_smarty->assign('isInstructorGroup', 0);
	}
	
//	$user_list = $user->retrieveAllUsers($where);
//	$sugar_smarty->assign('user_list', $user_list);

    
	
    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND orheader.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['orheader.schYear'] = " = '$schYear' ";
        }
    }
    
    if ($orno) {
        if (count($conds[0])) {
            $conds[0][' AND orheader.orno'] = "= '$orno' ";
        } else {
            $conds[0]['orheader.orno'] = "= '$orno' ";
        }
    }

    if ($idno) {
        if (count($conds[0])) {
            $conds[0][' AND orheader.idno'] = "= '$idno' ";
        } else {
            $conds[0]['orheader.idno'] = "= '$idno' ";
        }
    }

    if ($lname) {
        if (count($conds[0])) {
            $conds[0][' AND students.lname'] = " like '$lname%' ";
        } else {
            $conds[0]['students.lname'] = " like '$lname%' ";
        }
    }
    
    if ($fname) {
        if (count($conds[0])) {
            $conds[0][' AND students.fname'] = " like '$fname%' ";
        } else {
            $conds[0]['students.fname'] = " like '$fname%' ";
        }
    }
    
    if ($mname) {
        if (count($conds[0])) {
            $conds[0][' AND students.mname'] = " like '$mname%' ";
        } else {
            $conds[0]['students.mname'] = " like '$mname%' ";
        }
    }
    if ($gender) {
        if (count($conds[0])) {
            $conds[0][' AND students.gender'] = " like '$gender%' ";
        } else {
            $conds[0]['students.gender'] = " like '$gender%' ";
        }
    }
    
    if ($cashier) {
       if (count($conds[0])) {
           $conds[0][' AND orheader.cashier'] = " = '$cashier' ";
       } else {
           $conds[0]['orheader.cashier'] = " = '$cashier' ";
       }
    }
    
    if ($rstatus!="") {
        if (count($conds[0])) {
            $conds[0][' AND orheader.rstatus']    = " = '$rstatus' ";
        } else {
            $conds[0]['orheader.rstatus']    = " = '$rstatus' ";
        }
    }
	
	$allorheader   = $orheader->retrieveAllORHeader($conds);
	$list          = $orheader->retrieveAllORHeader($conds,"paymentID","ASC",$offset, $limit);
	
	if ($allorheader)
		$total_rec=count($allorheader);
	else 
		$total_rec=0;
		
	$main_url="index.php?module=Payments&action=listORHeaderHS&paymentID=$paymentID&orno=$orno&idno=$idno&schYear=$schYear&rstatus=$rstatus";
	
	if (!count($list)) {
    	$list = "";
    }
    
        //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year+1; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" >'."\n";
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
	$sugar_smarty->assign('SEMESTERS', $semesters);
    
	$sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('paymentID', $paymentID );
	$sugar_smarty->assign('orno', $orno );
	$sugar_smarty->assign('idno', $idno );
	$sugar_smarty->assign('lname', $lname );
	$sugar_smarty->assign('fname', $fname );
	$sugar_smarty->assign('mname', $mname );
	$sugar_smarty->assign('gender', $gender );
	$sugar_smarty->assign('schYear', $schYear );
	$sugar_smarty->assign('semCode', $semCode );
	$sugar_smarty->assign('rstatus', $rstatus );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Payments/templates/listORHeaderHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>
<script language="javascript" >
$('orno').focus();
</script>