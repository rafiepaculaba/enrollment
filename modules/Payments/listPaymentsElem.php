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
require_once('modules/Payments/PaymentTypeElem.php');
require_once('modules/Payments/PaymentElem.php');
require_once('modules/Config/ConfigElem.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_ELEM']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Elem Payment");
if ($access->check_access($current_user->id,$accessCode)) {

	// get all default setting from configs
    $config = new Config();
	$payment = new Payment();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;
	
	if ($_GET['cmdFilter']) {
		$paymentID 		= $_GET['paymentID'];
		$schYear   		= $_GET['schYear'];
		$term   		= $_GET['term'];
		$idno   		= $_GET['idno'];
		$ORno   		= $_GET['ORno'];
		$lname   		= $_GET['lname'];
		$fname   		= $_GET['fname'];
		$mname   		= $_GET['mname'];
		$rstatus   		= $_GET['rstatus'];
	} else {
		$paymentID     	= $_SESSION[$_GET['module'].'Elem_paymentID'];
		$schYear     	= $_SESSION[$_GET['module'].'Elem_schYear'];
		$term     		= $_SESSION[$_GET['module'].'Elem_term'];
		$idno     		= $_SESSION[$_GET['module'].'Elem_idno'];
		$ORno     		= $_SESSION[$_GET['module'].'Elem_ORno'];
		$lname     		= $_SESSION[$_GET['module'].'Elem_lname'];
		$fname     		= $_SESSION[$_GET['module'].'Elem_fname'];
		$mname     		= $_SESSION[$_GET['module'].'Elem_mname'];
		$rstatus     	= $_SESSION[$_GET['module'].'Elem_rstatus'];
	}
	
	if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'Elem_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }
    
	//set session variables
	$_SESSION[$_GET['module'].'Elem_paymentID']	= $paymentID;
	$_SESSION[$_GET['module'].'Elem_schYear']	= $schYear;
	$_SESSION[$_GET['module'].'Elem_term']		= $term;
	$_SESSION[$_GET['module'].'Elem_idno']		= $idno;
	$_SESSION[$_GET['module'].'Elem_lname']		= $lname;
	$_SESSION[$_GET['module'].'Elem_fname']		= $fname;
	$_SESSION[$_GET['module'].'Elem_mname']		= $mname;
	$_SESSION[$_GET['module'].'Elem_ORno']		= $ORno;
	$_SESSION[$_GET['module'].'Elem_rstatus']	= $rstatus;
    
    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND payments.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['payments.schYear'] = " = '$schYear' ";
        }
    }
	
    if (trim($paymentID)!='') {
        if (count($conds[0])) {
            $conds[0][' AND payments.paymentID'] = " = '$paymentID' ";
        } else {
            $conds[0]['payments.paymentID'] = " = '$paymentID' ";
        }
    }
    
    if (trim($ORno)!='') {
        if (count($conds[0])) {
            $conds[0][' AND payments.ORno'] = " = '$ORno' ";
        } else {
            $conds[0]['payments.ORno'] = " = '$ORno' ";
        }
    }

    if (trim($idno)!='') {
        if (count($conds[0])) {
            $conds[0][' AND payments.idno'] = " = '$idno' ";
        } else {
            $conds[0]['payments.idno'] = " = '$idno' ";
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

    if ($term) {
        if (count($conds[0])) {
            $conds[0][' AND payments.term'] = " = '$term' ";
        } else {
            $conds[0]['payments.term'] = " = '$term' ";
        }
    }

    if (trim($rstatus)!='') {
        if (count($conds[0])) {
            $conds[0][' AND payments.rstatus'] = " = '$rstatus' ";
        } else {
            $conds[0]['payments.rstatus'] = " = '$rstatus' ";
        }
    }
	
//	$allPayments = $payment->retrieveAllStudentPayments($conds);
	$allPayments = $payment->countAllStudentPayments($conds);
	$list        = $payment->retrieveAllStudentPayments($conds,"paymentID","ASC",$offset, $limit);
	
//	if ($allPayments)
//		$total_rec=count($allPayments);
//	else 
//		$total_rec=0;
	$total_rec = $allPayments;

	$main_url="index.php?module=Payments&action=listPaymentsElem&paymentID=$paymentID&schYear=$schYear&term=$term&ORno=$ORno&idno=$idno&lname=$lname&fname=$fname&mname=$mname&rstatus=$rstatus";

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
	
	//Get Term Configuration
	$theTerms = $config->getConfig('Terms');
	
	$terms ='<select name="term" id="term">'."\n";
	$terms.='<option value="">----------</option>'."\n";
	if ($theTerms) {
	    if (is_array($theTerms)) {
    	    foreach ($theTerms as $key=>$value) {
    	       if ($key==$term) {
                $terms .= '<option value="'.$key.'" selected>'.$value.'</option>'."\n";
    	       } else {
                $terms .= '<option value="'.$key.'">'.$value.'</option>'."\n";
    	       }
    	    }
	    } else {
	        $ctr=1;
	        while ($ctr<=$theTerms) {
	            if ($ctr==$term) {
	               $terms .= '<option value="'.$ctr.'" selected>'.$ctr.'</option>'."\n";
	            } else {
	               $terms .= '<option value="'.$ctr.'">'.$ctr.'</option>'."\n";
	            }
	            $ctr++;    
	        }
	    }
	}

	$terms.='</select>';
	$sugar_smarty->assign('TERMS', $terms);

	if (!count($list)) {
    	$list = "";
    }

	$sugar_smarty->assign('list', $list );
	$sugar_smarty->assign('schYear', $schYear );
	$sugar_smarty->assign('paymentID', $paymentID );
	$sugar_smarty->assign('term', $term );
	$sugar_smarty->assign('idno', $idno );
	$sugar_smarty->assign('lname', $lname );
	$sugar_smarty->assign('fname', $fname );
	$sugar_smarty->assign('mname', $mname );
	$sugar_smarty->assign('rstatus', $rstatus );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Payments/templates/listPaymentsElem.tpl');

} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>
<script language="javascript">
$('paymentID').focus();
</script>