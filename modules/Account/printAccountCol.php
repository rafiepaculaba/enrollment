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
require_once('modules/Account/AccountDetailCol.php');
require_once('modules/Account/Account.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Account/Account.php');

global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();


$accID   = $_GET['accID'];
$account = new Account($accID);

if ( $accID ) {
    
    // get all default setting from configs
    $config = new Config();
	
	$sugar_smarty->assign('accID', $account->accID );
	$sugar_smarty->assign('schYear', $account->schYear );
	$sugar_smarty->assign('semCode', $account->semCode );
	
	if ($account->semCode==1) {
	   $sugar_smarty->assign('semester', "1<sup>st</sup>" );
	} else if ($account->semCode==2) {
	   $sugar_smarty->assign('semester', "2<sup>nd</sup>" );
	} else if ($account->semCode==3) {
	   $sugar_smarty->assign('semester', "3<sup>rd</sup>" );
	} else if ($account->semCode==4) {
	   $sugar_smarty->assign('semester', "Summer" );
	}
	
	$sugar_smarty->assign('idno', $account->idno );
	
	$student = new Student($account->idno);
	
	if ($account->details) {
	    $fees = array();
	    $less_adjustments= array();
	    $add_adjustments = array();
	    foreach ($account->details as $data) {
	        if (strtoupper($data['feeType'])=="ADD") {
                $add_adjustments[] = $data;        
	        } else if (strtoupper($data['feeType'])=="LESS") {
                $less_adjustments[] = $data;        
            } else if (strtoupper($data['feeType'])=="LABORATORY") {
                $lab_fees[] = $data;        
	        } else {
	            $fees[] = $data;  
	        }
	    }
	}

	if (count($fees)) {
	   $sugar_smarty->assign('fees', $fees );
	} else {
	   $sugar_smarty->assign('fees', "" );
	}
	
	if (count($less_adjustments)) {
	   $sugar_smarty->assign('less_adjustments', $less_adjustments );
	} else {
	   $sugar_smarty->assign('less_adjustments', "" );
	}
	
	if (count($add_adjustments)) {
	   $sugar_smarty->assign('add_adjustments', $add_adjustments );
	} else {
	   $sugar_smarty->assign('add_adjustments', "" );
	}
	
	if (count($lab_fees)) {
	   $sugar_smarty->assign('lab_fees', $lab_fees );
	} else {
	   $sugar_smarty->assign('lab_fees', "" );
	}
	
	$sugar_smarty->assign('lname', $student->lname );
	$sugar_smarty->assign('fname', $student->fname );
	$sugar_smarty->assign('mname', $student->mname );
	$sugar_smarty->assign('courseCode', $student->courseCode );
	$sugar_smarty->assign('yrLevel', $student->yrLevel );
	
	$sugar_smarty->assign('oldBalance', $account->oldBalance );
	$sugar_smarty->assign('totalFee', $account->totalFee );
	$sugar_smarty->assign('payment', $account->payment );
	$sugar_smarty->assign('balance', $account->balance );
	
	if ($config->getConfig('Logo')) {
    	$sugar_smarty->assign('logo', '1' );
    } else {
        $sugar_smarty->assign('logo', '0' );
    }
	
	$sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
	
	echo $sugar_smarty->fetch('modules/Account/templates/printAccountCol.tpl');
} else {
    $msg = "Account ID not found!";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>


<script language="javascript">

function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}

</script>