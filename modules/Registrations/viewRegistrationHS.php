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
$accessCode = $access->getAccessCode("View HS Registration");
if ($access->check_access($current_user->id,$accessCode)) {
    $regID = $_GET['regID'];
    
    if (!$regID) {
        $msg = "Opps! no Registration ID selected.";
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
        $sugar_smarty->assign('age', $reg->age );
        $sugar_smarty->assign('bday', date("F d, Y", strtotime($reg->bday)) );
        
        if ($reg->gender == "M")
            $sugar_smarty->assign('gender', "Male");
        else if ($reg->gender == "F")
            $sugar_smarty->assign('gender', "Female");
        
        if ($reg->cstatus == "S")
            $sugar_smarty->assign('cstatus', "Single" );
        else if ($reg->cstatus == "M")
            $sugar_smarty->assign('cstatus', "Married" );
        
        $sugar_smarty->assign('nationality', $reg->nationality );
        $sugar_smarty->assign('lastSchool', $reg->lastSchool );
        
        if ( $reg->sch_last_attended != "0000-00-00" ) {
            $sugar_smarty->assign('sch_last_attended', date("F d, Y", strtotime($reg->sch_last_attended)) );
        } else {
            $sugar_smarty->assign('sch_last_attended', "" );
        }
         
        $sugar_smarty->assign('regDate', date("F d, Y", strtotime($reg->regDate)) );
        $sugar_smarty->assign('entryDocs', $reg->entryDocs );
        
        // to check if the user has an access in edit
        $accessCode = $access->getAccessCode("Edit HS Registration");
        $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
        
        // to check if the user has an access in delete
        $accessCode = $access->getAccessCode("Delete HS Registration");
        $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );
        
        echo $sugar_smarty->fetch('modules/Registrations/templates/viewRegistrationHS.tpl');
    }
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script language="javascript">
function deleteRegistration(regID)
{
    reply=confirm("Do you really want to delete the registration?");
    
    if (reply==true)
        redirect('index.php?module=Registrations&action=deleteRegistrationHS&regID='+regID);
}
</script>