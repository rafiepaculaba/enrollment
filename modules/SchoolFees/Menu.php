<!--<?php


// school fees
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == "createSchoolFeeCol" || $_REQUEST['action'] == "createSchoolFeeHS" || $_REQUEST['action'] == "createSchoolFeeElem") ) {
//    $module_menu = array();
//	$module_menu[] = array('index.php?module=Administration&action=listSchoolFeeCol',"College School Fees", 'Quotes');
//	$module_menu[] = array('index.php?module=Administration&action=createSchoolFeeCol',"Add College School Fee", 'CreateWebToLeadForm');
//	$module_menu[] = array('index.php?module=Administration&action=listSchoolFeeHS',"High School School Fees", 'Quotes');
//	$module_menu[] = array('index.php?module=Administration&action=createSchoolFeeHS',"Add High School School Fee", 'CreateWebToLeadForm');
//	$module_menu[] = array('index.php?module=Administration&action=listSchoolFeeElem',"Elementary School Fees", 'Quotes');
//	$module_menu[] = array('index.php?module=Administration&action=createSchoolFeeElem',"Add Elementary School Fee", 'CreateWebToLeadForm');
}
?>

-->
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
/*********************************************************************************

 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

global $mod_strings;
global $current_user;

require_once('modules/Config/GeneralConfig.php');
// get the config
$config = new GeneralConfig();
$col_enabled = $config->getConfig('College Enabled');
$hs_enabled = $config->getConfig('HS Enabled');
$elem_enabled = $config->getConfig('Elem Enabled');
$pre_enabled = $config->getConfig('PreSchool Enabled');

$access = new AccessChecker();

$module_menu = Array();

// college
if ($col_enabled) {
    $accessCode = $access->getAccessCode("List Col School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=listSchoolFeeCol',"College School Fees ", 'feesSchool-college');
    }
    $accessCode = $access->getAccessCode("Create Col School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=createSchoolFeeCol',"Add College School Fee ", 'feesSchoolNew-college');
    }
    
    $accessCode = $access->getAccessCode("List Col Lab Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=listLabFeeCol',"College Laboratory Fees ", 'feesLab-college');
    }
    $accessCode = $access->getAccessCode("Assign Col Lab Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=assignLabFee',"Add College Laboratory Fee ", 'feesLabNew-college');
    }
    
    $accessCode = $access->getAccessCode("List Col School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=listMiscFeeCol',"College Miscellaneous Fees ", 'feesSchool-college');
    }
    $accessCode = $access->getAccessCode("Create Col School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=createMiscFeeCol',"Add College Miscellaneous Fee ", 'feesSchoolNew-college');
    }
    
}


// high school
if ($hs_enabled) {
    $accessCode = $access->getAccessCode("List HS School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=listSchoolFeeHS',"High School School Fees ", 'feesSchool-highSchool');
    }
    $accessCode = $access->getAccessCode("Create HS School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=createSchoolFeeHS',"Add High School School Fee ", 'feesSchoolNew-highSchool');
    }
    
    $accessCode = $access->getAccessCode("List HS School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=listMiscFeeHS',"High School Miscellaneous Fees ", 'feesSchool-highSchool');
    }
    $accessCode = $access->getAccessCode("Create HS School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=createMiscFeeHS',"Add High School Miscellaneous Fee ", 'feesSchoolNew-highSchool');
    }
}


// elementary
if ($elem_enabled) {
    $accessCode = $access->getAccessCode("List Elem School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=listSchoolFeeElem',"Elementary School Fees ", 'feesSchool-elementary');
    }
    $accessCode = $access->getAccessCode("Create Elem School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=createSchoolFeeElem',"Add Elementary School Fee ", 'feesSchoolNew-elementary');
    }
    $accessCode = $access->getAccessCode("List Elem School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=listMiscFeeElem',"Elementary Miscellaneous Fees ", 'feesSchool-elementary');
    }
    $accessCode = $access->getAccessCode("Create Elem School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=createMiscFeeElem',"Add Elementary Miscellaneous Fee ", 'feesSchoolNew-elementary');
    }
}

// Preschool
if ($pre_enabled) {
    $accessCode = $access->getAccessCode("List Preschool School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=listSchoolFeePreschool',"Preschool School Fees ", 'feesSchool-preschool');
    }
    $accessCode = $access->getAccessCode("Create Preschool School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=createSchoolFeePreschool',"Add Preschool School Fee ", 'feesSchoolNew-preschool');
    }
    $accessCode = $access->getAccessCode("List Preschool School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=listMiscFeePreschool',"Preschool Miscellaneous Fees ", 'feesSchool-preschool');
    }
    $accessCode = $access->getAccessCode("Create Preschool School Fee");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = array('index.php?module=SchoolFees&action=createMiscFeePreschool',"Add Preschool Miscellaneous Fee ", 'feesSchoolNew-preschool');
    }
}

//$accessCode = $access->getAccessCode("List HS Lab Fee");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = array('index.php?module=SchoolFees&action=listLabFeeHS',"High School Laboratory Fees ", 'Quotes');
//}
//$accessCode = $access->getAccessCode("Assign HS Lab Fee");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = array('index.php?module=SchoolFees&action=assignLabFeeHS',"Add High School Laboratory Fee ", 'CreateWebToLeadForm');
//}
//
//$accessCode = $access->getAccessCode("List Elem Lab Fee");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = array('index.php?module=SchoolFees&action=listLabFeeElem',"Elementary Laboratory Fees ", 'Quotes');
//}
//$accessCode = $access->getAccessCode("Assign Elem Lab Fee");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = array('index.php?module=SchoolFees&action=assignLabFeeElem',"Add Elementary Laboratory Fee ", 'CreateWebToLeadForm');
//}

?>
