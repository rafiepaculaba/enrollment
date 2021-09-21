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

require_once('common.php');
require_once('include/Sugar_Smarty.php');
require_once('modules/Users/UserGroup.php');
require_once('modules/Users/GroupRole.php');

global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$groupID = $_GET['groupID'];

$ug     = new UserGroup($groupID);
$groles = new GroupRole();
$access = new AccessChecker();

$accessCode = $access->getAccessCode("Create User Group");

if ($access->check_access($current_user->id, $accessCode)) {
    // check if fromt the adding role form
    if ( isset($_POST["cmdAddRole"]) ) {
        $groupID = $_POST['groupID'];
        
        // from adding roles operation
        // post the newly add roles to the user group template
        if ( !empty($_POST['chkAdd']) ) {
            $groles->groupID = $groupID;
            
            foreach ($_POST['chkAdd'] as $theRole) {
                if ( !$groles->isExist($theRole, $groupID) ) {
                    // add the role to the user group
                    $groles->roleID  = $theRole;
                    $groles->addGroupRole();
                }
            }
        }
    }
    
    // check if from the delete role form
    if ( isset($_POST["cmdDeleteRole"]) ) {
        $groupID = $_POST['groupID'];
        
        // from delete roles operation
        // update roles of the user group template
        if ( !empty($_POST['chkDelete']) ) {
            $groles->groupID = $groupID;
            
            foreach ($_POST['chkDelete'] as $theRole) {
                // delete the role from the user group
                $groles->grID  = $theRole;
                $groles->deleteGroupRole();
            }
        }
    }
    
    $sugar_smarty->assign('groupID', $groupID );
    $sugar_smarty->assign('gname', $ug->name );
    $sugar_smarty->assign('gdesc', $ug->desc );
    $sugar_smarty->assign('gstatus', $ug->status );
    
    // get the roles of the user group
    $conds[0]['ugr.groupID'] = " = $groupID AND ";
    $conds[0]['ugr.roleID']  = " = ar.id";
    
    $theGroupRoles = $groles->retrieveAllGroupRoles($conds);
    $sugar_smarty->assign('theGroupRoles', $theGroupRoles);
    
    // get all the roles available
    if ($theGroupRoles) {
        $ctr=0;
        foreach ($theGroupRoles as $row) {
            if ($ctr==0) {
                $roleAlreadyExist .= "'".$row['roleID']."'";
            } else {
                $roleAlreadyExist .= ",'".$row['roleID']."'";
            }
            
            $ctr++;
        }
    }
    
    if ($roleAlreadyExist) {
        $where[]['id'] = " NOT IN ($roleAlreadyExist) AND ";
    }
    $where[]['deleted'] = " = 0";
    $allRoles = $groles->retrieveAllRoles($where);
    $sugar_smarty->assign('allRoles', $allRoles);
    
    // to check if the user has an access in edit
    $accessCode = $access->getAccessCode("Edit User Group");
    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
    
    // to check if the user has an access in delete
    $accessCode = $access->getAccessCode("Delete User Group");
    $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );
    
    echo "\n<p>\n";
    echo get_module_title($mod_strings['LBL_MODULE_NAME'], "User Group: ".$ug->name, false);
    echo "\n</p>\n";
    
    echo $sugar_smarty->fetch('modules/Users/templates/viewUserGroup.tpl');
    echo "<br>";
    echo $sugar_smarty->fetch('modules/Users/templates/listUserGroupRoles.tpl');
    
    // clear the post variables
    unset($_POST['cmdAddRole']);
    unset($_POST['cmdDeleteRole']);
} else {
    $msg = "Sorry, you dont have permission to access this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">
function deleteUserGroup(groupID)
{
    reply=confirm("Do you really want to delete the user group?");
    
    if (reply==true)
        redirect('index.php?module=Users&action=deleteUserGroup&groupID='+groupID);
}

function displayWindow(divId,title) {
    var w, h, l, t;
    w = 500;
    h = 300;
    l = screen.width/4;
    t = screen.height/4;
    
    if (navigator.appName=="Microsoft Internet Explorer") {
        l = 300 + document.body.scrollLeft;
        t = h + document.body.scrollTop;
    } else {
        l = 300 + document.body.scrollLeft;
        t = h + document.body.scrollTop;
    }

    // with title		        
    displayFloatingDiv(divId, title, w, h, l, t);
}

</script>