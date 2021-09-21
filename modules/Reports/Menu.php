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

//College Reports
if ($col_enabled) {
    $accessCode = $access->getAccessCode("View Col Class Roster");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=viewClassRosterCol", "College Class Rosters ","classRosters-college");
    }
    
    $accessCode = $access->getAccessCode("Generate Col Enrollment Status");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=generateEnrollmentStatusCol", "College Enrollment Status ","enrolmentStatus-college");
    }
    
    $accessCode = $access->getAccessCode("Summary of Income Col");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=summaryIncomeCol", "Summary of Income ","collectionReports-college");
    }

    $accessCode = $access->getAccessCode("Collection Report Col");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=collectionReportCol", "College Collection Reports ","collectionReports-college");
    }
    
    $accessCode = $access->getAccessCode("View Receivable Col");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=receivableReportCol", "College Receivable Reports ","receivableReports-college");
    }
    
    $accessCode = $access->getAccessCode("Cashier Report Col");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=cashierReportCol", "College Cashier Reports ","receivableReports-college");
    }
    
    $accessCode = $access->getAccessCode("Cashier Report Col");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=abstractReportCol", "Abstract Collection Reports ","receivableReports-college");
    }

    $accessCode = $access->getAccessCode("Cash Summary Report Col");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=cashSummaryReportCol", "Cash Summary Reports ","receivableReports-college");
    }
    
    $accessCode = $access->getAccessCode("Teachers Load Col");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=teachersLoadCol", "College Instructor's Load ","teacherLoad-college");
    }
    
    $accessCode = $access->getAccessCode("Enrollment List Col");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=enrollmentListCol", "College Enrollment List ","listEnrollment_college");
    }
    
    $accessCode = $access->getAccessCode("Promotionary List Col");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=promotionaryListCol", "College Promotionary List ","listPromotionary_college");
    }
    
}

//High School Reports
if ($hs_enabled) {
    $accessCode = $access->getAccessCode("View HS Class Roster");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=viewClassRosterHS", "High School Class Rosters ","classRosters-highschool");
    }
    
    $accessCode = $access->getAccessCode("Generate HS Enrollment Status");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=generateEnrollmentStatusHS", "High School Enrollment Status ","enrolmentStatus-highSchool");
    }
    
    $accessCode = $access->getAccessCode("Collection Report HS");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=collectionReportHS", "High School Collection Reports ","collectionReports-highSchool");
    }
    
    $accessCode = $access->getAccessCode("View Receivable HS");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=receivableReportHS", "High School Receivable Reports ","receivableReports-highSchool");
    }
    
    $accessCode = $access->getAccessCode("Teachers Load HS");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=teachersLoadHS", "High School Teacher's Load ","teacherLoad-highSchool");
    }
}    

//Elementary Reports
if ($elem_enabled) {
    $accessCode = $access->getAccessCode("View Elem Class Roster");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=viewClassRosterElem", "Elementary Class Rosters ","classRosters-elementary");
    }
    
    $accessCode = $access->getAccessCode("Generate Elem Enrollment Status");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=generateEnrollmentStatusElem", "Elementary Enrollment Status ","enrolmentStatus-elementary");
    }
    
    $accessCode = $access->getAccessCode("Collection Report Elem");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=collectionReportElem", "Elementary Collection Reports ","collectionReports-elementary");
    }
    
    $accessCode = $access->getAccessCode("View Receivable Elem");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=receivableReportElem", "Elementary Receivable Reports ","receivableReports-elementary");
    }
    
    $accessCode = $access->getAccessCode("Teachers Load Elem");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=teachersLoadElem", "Elementary Teacher's Load ","teacherLoad-elementary");
    }
}

//Preschool Reports
if ($pre_enabled) {
    $accessCode = $access->getAccessCode("View Preschool Class Roster");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=viewClassRosterPreschool", "Preschool Class Rosters ","classRosters-preSchool");
    }
    
    $accessCode = $access->getAccessCode("Generate Preschool Enrollment Status");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=generateEnrollmentStatusPreschool", "Preschool Enrollment Status ","enrolmentStatus-preschool");
    }
    
    $accessCode = $access->getAccessCode("Collection Report Preschool");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=collectionReportPreschool", "Preschool Collection Reports ","collectionReports-preSchool");
    }
    
    $accessCode = $access->getAccessCode("View Receivable Preschool");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=receivableReportPreschool", "Preschool Receivable Reports ","receivableReports-preSchool");
    }
    
    $accessCode = $access->getAccessCode("Teachers Load Preschool");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Reports&action=teachersLoadPreschool", "Preschool Teacher's Load ","teacherLoad-preSchool");
    }
}

?>
