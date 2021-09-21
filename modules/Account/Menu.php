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
$col_enabled  = $config->getConfig('College Enabled');
$hs_enabled   = $config->getConfig('HS Enabled');
$elem_enabled = $config->getConfig('Elem Enabled');
$pre_enabled  = $config->getConfig('PreSchool Enabled');

$access = new AccessChecker();

$module_menu = Array();


// college
if ($col_enabled) {
    $accessCode = $access->getAccessCode("Chart of Accounts");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=listChartOfAccounts", "Chart of Accounts ","accounts_college");
    }
    $accessCode = $access->getAccessCode("List Col Account");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=listAccountsCol", "College Accounts ","accounts_college");
    }
    
    $accessCode = $access->getAccessCode("List Col Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=listAssessmentsCol", "College Assessments ","assessments_college");
    }
    
    $accessCode = $access->getAccessCode("Create Col Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=assessmentGenerationCol", "Generate College Assessments ","generateAssessments-college");
    }
    
    $accessCode = $access->getAccessCode("Print Bulk Col Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=bulkAssessmentCol", "Print College Assessments ","assessmentsPrint-college");
    }
    
    $accessCode = $access->getAccessCode("Print Bulk Col Admission");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=bulkAdmissionCol", "Print College Admission Slips ","assessmentsPrint-college");
    }
}

//high school

if ($hs_enabled) {
    $accessCode = $access->getAccessCode("List HS Account");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=listAccountsHS", "High School Accounts ","accounts_highSchool");
    }
    
    $accessCode = $access->getAccessCode("List HS Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=listAssessmentsHS", "High School Assessments ","assessments_highSchool");
    }
    
    $accessCode = $access->getAccessCode("Create HS Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=assessmentGenerationHS", "Generate High School Assessments ","generateAssessments-highSchool");
    }
    
    $accessCode = $access->getAccessCode("Print Bulk HS Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=bulkAssessmentHS", "Print High School Assessments ","assessmentsPrint-highSchool");
    }
}


//elementary
if ($elem_enabled) {
    $accessCode = $access->getAccessCode("List Elem Account");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=listAccountsElem", "Elementary Accounts ","accounts_elementary");
    }
    
    $accessCode = $access->getAccessCode("List Elem Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=listAssessmentsElem", "Elementary Assessments ","assessments_elementary");
    }
    
    $accessCode = $access->getAccessCode("Create Elem Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=assessmentGenerationElem", "Generate Elementary Assessments ","generateAssessments-elementary");
    }
    
    $accessCode = $access->getAccessCode("Print Bulk Elem Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=bulkAssessmentElem", "Print Elementary Assessments ","assessmentsPrint-elementary");
    }
}

//Preschool
if ($pre_enabled) {
    $accessCode = $access->getAccessCode("List Preschool Account");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=listAccountsPreschool", "Preschool Accounts ","accounts_preSchool");
    }
    
    $accessCode = $access->getAccessCode("List Preschool Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=listAssessmentsPreschool", "Preschool Assessments ","assessments_preSchool");
    }
    
    $accessCode = $access->getAccessCode("Create Preschool Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=assessmentGenerationPreschool", "Generate Preschool Assessments ","generateAssessments-preSchool");
    }
    
    $accessCode = $access->getAccessCode("Print Bulk Preschool Assessment");
    if ($access->check_access($current_user->id,$accessCode)) {
        $module_menu[] = Array("index.php?module=Account&action=bulkAssessmentPreschool", "Print Preschool Assessments ","assessmentsPrint-preSchool");
    }
}

?>
