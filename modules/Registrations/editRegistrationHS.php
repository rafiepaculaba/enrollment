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
require_once('modules/Registrations/RegistrationHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit HS Registration");
if ($access->check_access($current_user->id,$accessCode)) {
    $regID = $_GET['regID'];
    
    if (!$regID) {
        $msg = "Opps! no Registration ID seleted.";
        $sugar_smarty->assign('class', 'errorbox');
        $sugar_smarty->assign('display', 'block');
        $sugar_smarty->assign('msg', $msg );
        echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    } else {
        $reg = new Registration($regID);
        
        $sugar_smarty->assign('regID', $reg->regID );
        $sugar_smarty->assign('fname', $reg->fname );
        $sugar_smarty->assign('lname', $reg->lname );
        $sugar_smarty->assign('mname', $reg->mname );
        $sugar_smarty->assign('gender', $reg->gender );
        $sugar_smarty->assign('age', $reg->age );
        
        // bday
        $bday = explode("-",$reg->bday);
        $year = $bday[0];
        $mon  = $bday[1];
        $day  = $bday[2];
        
        $sugar_smarty->assign('year', $year );
        
        $sugar_smarty->assign('cstatus', $reg->cstatus );
        $sugar_smarty->assign('nationality', $reg->nationality );
        $sugar_smarty->assign('lastSchool', $reg->lastSchool );
        
        if ( $reg->sch_last_attended != "0000-00-00" ) {
            $sugar_smarty->assign('sch_last_attended', date("m/d/Y", strtotime($reg->sch_last_attended)) );
        } else {
            $sugar_smarty->assign('sch_last_attended', "" );
        }
        
        $sugar_smarty->assign('regDate', date("m/d/Y", strtotime($reg->regDate)) );
        $sugar_smarty->assign('entryDocs', $reg->entryDocs );
        
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
        
        $month_object = '<select name="month" id="month">';
        foreach ($months as $key=>$month) {
            if ($key==$mon)
                $month_object .= '<option value="'.$key.'" selected>'.$month.'</option>';
            else
                $month_object .= '<option value="'.$key.'">'.$month.'</option>';
        }
        $month_object .= '</select>';
        
        $sugar_smarty->assign('month_object', $month_object );
        
        
        $day_object = '<select name="day" id="day">';
        for($i=1; $i<=31; $i++) {
            if ($i==$day)
                $day_object .= '<option value="'.$i.'" selected>'.$i.'</option>';
            else
                $day_object .= '<option value="'.$i.'">'.$i.'</option>';
        }
        $day_object .= '</select>';
        
        $sugar_smarty->assign('day_object', $day_object );
        
        
        echo $sugar_smarty->fetch('modules/Registrations/templates/editRegistrationHS.tpl');
        calendarSetup('sch_last_attended', 'jscal_trigger');
    }
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