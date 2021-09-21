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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('include/formbase.php');
require_once('modules/Campaigns/Campaign.php');





$focus = new Campaign();

$focus->retrieve($_POST['record']);
if(!$focus->ACLAccess('Save')){
	ACLController::displayNoAccess(true);
	sugar_cleanup(true);
}
if (!empty($_POST['assigned_user_id']) && ($focus->assigned_user_id != $_POST['assigned_user_id']) && ($_POST['assigned_user_id'] != $current_user->id)) {
	$check_notify = TRUE;
}
else {
	$check_notify = FALSE;
}

foreach($focus->column_fields as $field)
{
	if(isset($_POST[$field]))
	{
		$value = $_POST[$field];
		$focus->$field = $value;

	}
}

foreach($focus->additional_column_fields as $field)
{
	if(isset($_POST[$field]))
	{
		$value = $_POST[$field];
		$focus->$field = $value;

	}
}


$focus->save($check_notify);
$return_id = $focus->id;
$GLOBALS['log']->debug("Saved record with id of ".$return_id);


//if type is set to newsletter then make sure there are propsect lists attached
if($focus->campaign_type =='NewsLetter'){
        $focus->load_relationship('prospectlists');
        $target_lists = $focus->prospectlists->get();
        if(count($target_lists)<1){
            //if no prospect lists are attached, then lets create a subscription and unsubscription
            //default prospect lists as these are required for newsletters.
             require_once('modules/ProspectLists/ProspectList.php');       
             //create subscription list     
             $subs = new ProspectList();
             $subs->name = "$focus->name Subscription List";
             $subs->list_type = "default";
             $subs->save();
             $focus->prospectlists->add($subs->id);

             //create unsubscription list
             $unsubs = new ProspectList();
             $unsubs->name = "$focus->name Unsubscription List";
             $unsubs->list_type = "exempt";
             $unsubs->save();
             $focus->prospectlists->add($unsubs->id);
             
             //create unsubscription list
             $test_subs = new ProspectList();
             $test_subs->name = "$focus->name Test List";
             $test_subs->list_type = "test";
             $test_subs->save();
             $focus->prospectlists->add($test_subs->id);             
        }
        //save new relationships
        $focus->save();

}//finish newsletter processing

handleRedirect($focus->id, $focus->name);


?>
