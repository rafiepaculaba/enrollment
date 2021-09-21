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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Create Preschool Registration");
if ($access->check_access($current_user->id,$accessCode)) {
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
        $month_object .= '<option value="'.$key.'">'.$month.'</option>'."\n";
    }
    $month_object .= '</select>'."\n";
    
    $sugar_smarty->assign('month_object', $month_object );
    
    
    $day_object = '<select name="day" id="day">'."\n";
    $day_object .= '<option value="">---</option>'."\n";
    for($i=1; $i<=31; $i++) {
        $day_object .= '<option value="'.$i.'">'.$i.'</option>'."\n";
    }
    $day_object .= '</select>'."\n";
    
    $sugar_smarty->assign('day_object', $day_object );
    
    echo $sugar_smarty->fetch('modules/Registrations/templates/createRegistrationPreschool.tpl');
    calendarSetup('sch_last_attended', 'jscal_trigger');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script>
addToValidate('frmRegistration','lname', '', true, 'Last Name');
addToValidate('frmRegistration','fname', '', true, 'First Name');
addToValidate('frmRegistration','mname', '', true, 'Middle Name');
addToValidate('frmRegistration','gender', '', true, 'Gender');
addToValidate('frmRegistration','age', '', true, 'Age');
addToValidate('frmRegistration','month', '', true, 'Birth Month');
addToValidate('frmRegistration','day', '', true, 'Birth Date');
addToValidate('frmRegistration','year', '', true, 'Birth Year');
addToValidate('frmRegistration','cstatus', '', true, 'Civil Status');
addToValidate('frmRegistration','nationality', '', true, 'Nationality');
</script>