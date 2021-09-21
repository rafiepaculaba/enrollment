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
$col_enabled    = $config->getConfig('College Enabled');
$hs_enabled     = $config->getConfig('HS Enabled');
$elem_enabled   = $config->getConfig('Elem Enabled');
$pre_enabled    = $config->getConfig('PreSchool Enabled');

$access = new AccessChecker();

$module_menu = Array();

// default
$accessCode = $access->getAccessCode("List Col OR Series");
if ($access->check_access($current_user->id,$accessCode)) {
    $module_menu[] = Array("index.php?module=Payments&action=listORSeries", "College OR Series ","paymentTypes-college");
}
$accessCode = $access->getAccessCode("Create Col OR Series");
if ($access->check_access($current_user->id,$accessCode)) {
    $module_menu[] = Array("index.php?module=Payments&action=createORSeries", "New College OR Series ","paymentTypesNew-college");
}

//college
if ($col_enabled) {
    $accessCode = $access->getAccessCode("List Col OR Header");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Payments&action=listORHeader", "College OR ","payments-college");
    }
    $accessCode = $access->getAccessCode("Create Col OR Header");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Payments&action=createORHeader", "New College OR ","paymentsNew-college");
    }
}

//high school
if ($hs_enabled) {
    $accessCode = $access->getAccessCode("List HS OR Header");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Payments&action=listORHeaderHS", "High School OR ","payments-highSchool");
    }
    $accessCode = $access->getAccessCode("Create HS OR Header");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Payments&action=createORHeaderHS", "New High School OR ","paymentsNew-highSchool");
    }
}

if ($elem_enabled) {
    $accessCode = $access->getAccessCode("List Elem OR Header");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Payments&action=listORHeaderElem", "Elementary OR ","payments-elementary");
    }
    $accessCode = $access->getAccessCode("Create Elem OR Header");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Payments&action=createORHeaderElem", "New Elementary OR ","paymentsNew-elementary");
    }
}

if ($pre_enabled) {
    $accessCode = $access->getAccessCode("List Preschool OR Header");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Payments&action=listORHeaderPreschool", "Preschool OR ","payments-preSchool");
    }
    $accessCode = $access->getAccessCode("Create Preschool OR Header");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Payments&action=createORHeaderPreschool", "New Preschool OR ","paymentsNew-preSchool");
    }
}


//
//$accessCode = $access->getAccessCode("List Col Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listPayments", "College Payments ","payments-college");
//}
//$accessCode = $access->getAccessCode("Create Col Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createPayment", "New College Payment ","paymentsNew-college");
//}
//
//$accessCode = $access->getAccessCode("List Col Registration Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listRegistrationPayments", "College Registration/ Downpayment ","paymentsDown-college");
//}
//$accessCode = $access->getAccessCode("Create Col Registration Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createRegistrationPayment", "New College Registration/ Downpayment ","paymentsDownNew-college");
//}

//
//// high school
//$accessCode = $access->getAccessCode("List HS Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listPaymentTypesHS", "High School Payment Types ","paymentTypes-highSchool");
//}
//$accessCode = $access->getAccessCode("Create HS Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createPaymentTypeHS", "New High School Payment Type ","paymentTypesNew-highSchool");
//}
//
//$accessCode = $access->getAccessCode("List HS Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listPaymentsHS", "High School Payments ","payments-highSchool");
//}
//$accessCode = $access->getAccessCode("Create HS Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createPaymentHS", "New High School Payment ","paymentsNew-highSchool");
//}
//
//$accessCode = $access->getAccessCode("List HS Registration Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listRegistrationPaymentsHS", "High School Registration/ Downpayment ","paymentsDown-highSchool");
//}
//$accessCode = $access->getAccessCode("Create HS Registration Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createRegistrationPaymentHS", "New High School Registration/ Downpayment ","paymentsDownNew-highSchool");
//}
//
//
//// elementary
//$accessCode = $access->getAccessCode("List Elem Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listPaymentTypesElem", "Elementary Payment Types ","paymentTypes-elementary");
//}
//$accessCode = $access->getAccessCode("Create Elem Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createPaymentTypeElem", "New Elementary Payment Type ","paymentTypesNew-elementary");
//}
//
//$accessCode = $access->getAccessCode("List Elem Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listPaymentsElem", "Elementary Payments ","payments-elementary");
//}
//$accessCode = $access->getAccessCode("Create Elem Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createPaymentElem", "New Elementary Payment ","paymentsNew-elementary");
//}
//
//$accessCode = $access->getAccessCode("List Elem Registration Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listRegistrationPaymentsElem", "Elementary Registration/ Downpayment ","paymentsDown-elementary");
//}
//$accessCode = $access->getAccessCode("Create Elem Registration Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createRegistrationPaymentElem", "New Elementary Registration/ Downpayment ","paymentsDownNew-elementary");
//}
//
//// preschool
//$accessCode = $access->getAccessCode("List Preschool Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listPaymentTypesPreschool", "Preschool Payment Types ","paymentTypes-preSchool");
//}
//$accessCode = $access->getAccessCode("Create Preschool Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createPaymentTypePreschool", "New Preschool Payment Type ","paymentTypesNew-preSchool");
//}
//
//$accessCode = $access->getAccessCode("List Preschool Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listPaymentsPreschool", "Preschool Payments ","payments-preSchool");
//}
//$accessCode = $access->getAccessCode("Create Preschool Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createPaymentPreschool", "New Preschool Payment ","paymentsNew-preSchool");
//}
//
//$accessCode = $access->getAccessCode("List Preschool Registration Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=listRegistrationPaymentsPreschool", "Preschool Registration/ Downpayment ","paymentsDown-preSchool");
//}
//$accessCode = $access->getAccessCode("Create Preschool Registration Payment");
//if ($access->check_access($current_user->id,$accessCode)) {
//    $module_menu[] = Array("index.php?module=Payments&action=createRegistrationPaymentPreschool", "New Preschool Registration/ Downpayment ","paymentsDownNew-preSchool");
//}


?>