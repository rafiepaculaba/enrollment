<?php
if(!defined('sugarEntry')) define('sugarEntry', true);
/**
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
 */



require_once('include/entryPoint.php');
require_once('modules/Campaigns/utils.php');

if (!empty($_REQUEST['remove'])) clean_string($_REQUEST['remove'], "STANDARD");
if (!empty($_REQUEST['from'])) clean_string($_REQUEST['from'], "STANDARD");

if(!empty($_REQUEST['identifier'])) {
	$keys=log_campaign_activity($_REQUEST['identifier'],'removed');
    global $current_language;
    $mod_strings = return_module_language($current_language, 'Campaigns');
    
	if (!empty($keys) && $keys['target_type'] == 'Users'){
        //Users cannot opt out of receiving emails, print out warning message.
        echo $mod_strings['LBL_USERS_CANNOT_OPTOUT'];       
    
    }elseif(!empty($keys) && isset($keys['campaign_id']) && !empty($keys['campaign_id'])){
        //we need to unsubscribe the user from this particular campaign
        require_once('include/modules.php');
        $beantype = $beanList[$keys['target_type']];
        require_once($beanFiles[$beantype]);
        $focus = new $beantype();




        $focus->retrieve($keys['target_id']);



        unsubscribe($keys['campaign_id'], $focus); 

    }elseif(!empty($keys)){
		$id = $keys['target_id'];
		$module = trim($keys['target_type']);
		$class = $beanList[$module];
		require_once($beanFiles[$class]);
		$mod = new $class();
		$db = & PearDatabase::getInstance();

		$id = $db->quote($id);

		//no opt out for users.
		if(ereg('^[0-9A-Za-z\-]*$', $id) && $module != 'Users'){
            //record this activity in the campaing log table..
			$query = "UPDATE $mod->table_name SET email_opt_out='on' WHERE id ='$id'";
			$status=$db->query($query);
			if($status){
				echo "*";
			}
		}
	}
        //Print Confirmation Message.
        echo $mod_strings['LBL_ELECTED_TO_OPTOUT'];

}
sugar_cleanup();
?>
