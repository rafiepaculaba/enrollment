<?php
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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright(C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/



$authController->login($_REQUEST['user_name'], $_REQUEST['user_password']);
if(isset($_SESSION['authenticated_user_id'])) {
    
    $module = !empty($_REQUEST['login_module']) ? '?module='.$_REQUEST['login_module'] : '?module=Home';
    $action = !empty($_REQUEST['login_action']) ? '&action='.$_REQUEST['login_action'] : '&action=index';
    $record = !empty($_REQUEST['login_record']) ? '&record='.$_REQUEST['login_record'] : '';
    
    global $current_user;
    //C.L. Added $hasHistory check to respect the login_XXX settings if they are set
    $hasHistory = (!empty($_REQUEST['login_module']) || !empty($_REQUEST['login_action']) || !empty($_REQUEST['login_record']));
    if(isset($current_user) && !$hasHistory){
	    $modListHeader = query_module_access_list($current_user);
	    //try to get the user's tabs
	    $tempList = $modListHeader;
	    $idx = array_shift($tempList);
	    if(!empty($modListHeader[$idx])){
	    	$module = '?module='.$modListHeader[$idx];
	    	$action = '&action=index';
	    	$record = '';
	    }
    }
    
    /**
     * blumango codes
     * this will store the role access of the user in a session var
     */
//    if ($current_user->id) {
//        require_once('include/blumango/classes/utils/AccessChecker.php');
//        $access = new AccessChecker();
//        $where[0]['aru.user_id']="='".$current_user->id."' AND ";
//        $where[0]['aru.role_id']="=ar.id AND ";
//        $where[0]['aru.deleted']="= '0'";
//        $userRoles = $access->retrieveAllUserRoles($where);
//        if ($userRoles) {
//            foreach ($userRoles as $row) {
//                $_SESSION['ACCESS'][]=$row['id'];
//            }
//        }
//    }

//    global $current_user;
//    
//    require_once('common.php');
//    require_once ('modules/Users/User2.php');
//    $cur_user = new User($current_user->id);
//    
//    if (!isset($_SESSION)) {
//        session_start();
//    }
//    
//	$_SESSION['oUser']=$current_user->id;

    
} else {
    $module ="";
    $action="";
    $record="";
}
sugar_cleanup();

header('Location: index.php'.$module.$action.$record);?>
