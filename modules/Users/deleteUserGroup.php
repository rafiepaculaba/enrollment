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
require ('modules/Users/UserGroup.php');
require ('modules/Users/GroupRole.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$groupID = $_GET['groupID'];

$ug     = new UserGroup($groupID);
$groles = new GroupRole();
    
if ($ug->groupID) {
    // check if record is exist
    if ( !empty($ug->name) ) {
        // delete user group record
        if ($ug->deleteUserGroup()) {
            // get the roles of the user group target to be deleted
            $conds[0]['ugr.groupID'] = " = $groupID AND ";
            $conds[0]['ugr.roleID']  = " = ar.id";
            $theGroupRoles = $groles->retrieveAllGroupRoles($conds);

            // get all the roles available
            if ($theGroupRoles) {
                foreach ($theGroupRoles as $row) {
                        // delete the role from the user group
                        $groles->grID  = $row['grID'];
                        $groles->deleteGroupRole();
                }
            }
            
            $msg = "Record successfully deleted!";
    		$sugar_smarty->assign('class', 'notificationbox');
        } else {
            $msg = "Record was not successfully deleted!";
    	    $sugar_smarty->assign('class', 'errorbox');
        }
    } else {
        $msg = "User group does not exist!";
	    $sugar_smarty->assign('class', 'errorbox');
    }
} else {
    $msg = "Error: No user group id set!";
    $sugar_smarty->assign('class', 'errorbox');
}

$sugar_smarty->assign('display', 'block');
$sugar_smarty->assign('msg', $msg );
echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
?>

<script language="javascript">
setTimeout("redirect('index.php?module=Users&action=listUserGroups')", 3000);
</script>