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
require_once('modules/Payments/RegistrationPaymentHS.php');
require_once('modules/Config/ConfigHS.php');

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
$accessCode = $access->getAccessCode("List HS Registration Payment");
if ($access->check_access($current_user->id,$accessCode)) {

	// get all default setting from configs
    $config = new Config();
	$regpayment = new RegistrationPayment();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;

	if ($_GET['cmdFilter']) {
	    $regPaymentID 		= $_GET['regPaymentID'];
		$schYear   			= $_GET['schYear'];
		$ORno   			= $_GET['ORno'];
		$type   			= $_GET['type'];
		$idno   			= $_GET['idno'];
		$lname   			= $_GET['lname'];
		$fname   			= $_GET['fname'];
		$mname   			= $_GET['mname'];
		$rstatus   			= $_GET['rstatus'];
	} else {
		$regPaymentID     	= $_SESSION[$_GET['module'].'regHS_regPaymentID'];
		$schYear     		= $_SESSION[$_GET['module'].'regHS_schYear'];
		$ORno     			= $_SESSION[$_GET['module'].'regHS_ORno'];
		$type     			= $_SESSION[$_GET['module'].'regHS_type'];
		$idno     			= $_SESSION[$_GET['module'].'regHS_idno'];
		$lname     			= $_SESSION[$_GET['module'].'regHS_lname'];
		$fname     			= $_SESSION[$_GET['module'].'regHS_fname'];
		$mname     			= $_SESSION[$_GET['module'].'regHS_mname'];
		$rstatus     		= $_SESSION[$_GET['module'].'regHS_rstatus'];
	}
	
	if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'regHS_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }
    
	//set session variables
	$_SESSION[$_GET['module'].'regHS_regPaymentID']		= $regPaymentID;
	$_SESSION[$_GET['module'].'regHS_schYear']			= $schYear;
	$_SESSION[$_GET['module'].'regHS_ORno']				= $ORno;
	$_SESSION[$_GET['module'].'regHS_type']				= $type;
	$_SESSION[$_GET['module'].'regHS_idno']				= $idno;
	$_SESSION[$_GET['module'].'regHS_lname']			= $lname;
	$_SESSION[$_GET['module'].'regHS_fname']			= $fname;
	$_SESSION[$_GET['module'].'regHS_mname']			= $mname;
	$_SESSION[$_GET['module'].'regHS_rstatus']			= $rstatus;

    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND registration_payments.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['registration_payments.schYear'] = " = '$schYear' ";
        }
    }
    if (trim($regPaymentID)!='') {
        if (count($conds[0])) {
            $conds[0][' AND registration_payments.regPaymentID'] = " = '$regPaymentID' ";
        } else {
            $conds[0]['registration_payments.regPaymentID'] = " = '$regPaymentID' ";
        }
    }
    if (trim($ORno)!='') {
        if (count($conds[0])) {
            $conds[0][' AND registration_payments.ORno'] = " = '$ORno' ";
        } else {
            $conds[0]['registration_payments.ORno'] = " = '$ORno' ";
        }
    }
    if (trim($idno)!='') {
        if (count($conds[0])) {
            $conds[0][' AND registration_payments.idno'] = " = '$idno' ";
        } else {
            $conds[0]['registration_payments.idno'] = " = '$idno' ";
        }
    }
    if (trim($lname)!='') {
        if (count($conds[0])) {
            $conds[0][' AND students.lname'] = " like '$lname%' ";
        } else {
            $conds[0]['students.lname'] = " like '$lname%' ";
        }
    }
    if (trim($fname)!='') {
        if (count($conds[0])) {
            $conds[0][' AND students.fname'] = " like '$fname%' ";
        } else {
            $conds[0]['students.fname'] = " like '$fname%' ";
        }
    }
    if (trim($mname)!='') {
        if (count($conds[0])) {
            $conds[0][' AND students.mname'] = " like '$mname%' ";
        } else {
            $conds[0]['students.mname'] = " like '$mname%' ";
        }
    }
    if (trim($type)!='') {
        if (count($conds[0])) {
            $conds[0][' AND registration_payments.type'] = " = '$type' ";
        } else {
            $conds[0]['registration_payments.type'] = " = '$type' ";
        }
    }
    if (trim($rstatus)!='') {
        if (count($conds[0])) {
            $conds[0][' AND registration_payments.rstatus'] = " = '$rstatus' ";
        } else {
            $conds[0]['registration_payments.rstatus'] = " = '$rstatus' ";
        }
    }

//	$allPayments = $regpayment->retrieveAllStudentRegistrationPayments($conds);
	$allPayments = $regpayment->countAllStudentRegistrationPayments($conds);
	$list        = $regpayment->retrieveAllStudentRegistrationPayments($conds,"regPaymentID","ASC",$offset, $limit);
	
//	if ($allPayments)
//		$total_rec=count($allPayments);
//	else 
//		$total_rec=0;
	$total_rec = $allPayments;

	$main_url="index.php?module=Payments&action=listRegistrationPaymentsHS&regPaymentID=$regPaymentID&schYear=$schYear&ORno=$ORno&idno=$idno&lname=$lname&fname=$fname&mname=$mname&type=$type&rstatus=$rstatus";
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
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

	if (!count($list)) {
    	$list = "";
    }

	$sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('schYear', $schYear );
	$sugar_smarty->assign('regPaymentID', $regPaymentID );
	$sugar_smarty->assign('ORno', $ORno );
	$sugar_smarty->assign('idno', $idno );
	$sugar_smarty->assign('lname', $lname );
	$sugar_smarty->assign('fname', $fname );
	$sugar_smarty->assign('mname', $mname );
	$sugar_smarty->assign('type', $type );
	$sugar_smarty->assign('rstatus', $rstatus );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Payments/templates/listRegistrationPaymentsHS.tpl');
	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>
<script language="javascript">
$('regPaymentID').focus();
</script>	