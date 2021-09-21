<?php
 if(!defined('sugarEntry'))define('sugarEntry', true);
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
require_once('include/entryPoint.php');
require_once('include/formbase.php');
require_once('modules/Leads/LeadFormBase.php');
require_once('modules/Campaigns/Campaign.php');
require_once('modules/CampaignLog/CampaignLog.php');
global $timedate;
$app_strings = return_application_language($sugar_config['default_language']);
$app_list_strings = return_app_list_strings_language($sugar_config['default_language']);
$mod_strings = return_module_language($sugar_config['default_language'], 'Leads');

$app_list_strings['record_type_module'] = array('Contact'=>'Contacts', 'Account'=>'Accounts', 'Opportunity'=>'Opportunities', 'Case'=>'Cases', 'Note'=>'Notes', 'Call'=>'Calls', 'Email'=>'Emails', 'Meeting'=>'Meetings', 'Task'=>'Tasks', 'Lead'=>'Leads','Bug'=>'Bugs',




);

/**
 * To make your changes upgrade safe create a file called leadCapture_override.php and place the changes there
 */
$users = array(
	'PUT A RANDOM KEY FROM THE WEBSITE HERE' => array('name'=>'PUT THE USER_NAME HERE', 'pass'=>'PUT THE USER_HASH FOR THE RESPECTIVE USER HERE'),
);

if (isset($_POST['campaign_id']) && !empty($_POST['campaign_id'])) {
	    //adding the client ip address
	    $_POST['client_id_address'] = query_client_ip();
		$campaign_id=$_POST['campaign_id'];			
		$campaign = new Campaign();
		$camp_query  = "select name,id from campaigns where id='$campaign_id'"; 
		$camp_query .= " and deleted=0";                                  
        $camp_result=$campaign->db->query($camp_query);              
        $camp_data=$campaign->db->fetchByAssoc($camp_result);
	    //$current_user->user_name = $users[$_POST['user']]['name'];
	    
	    if(isset($camp_data) && $camp_data != null ){	   	    			    			    			    		  	    				    	             
				$leadForm = new LeadFormBase();
				$prefix = '';
				if(!empty($_POST['prefix'])){
					$prefix = 	$_POST['prefix'];			
				}
		       //$_POST['first_name'] = $name[0];  $_POST['last_name'] = $name[1];			
				$lead = $leadForm->handleSave('', false, true);
				if(!empty($lead)){
				require_once('modules/CampaignLog/CampaignLog.php');       
		        //create campaign log    
		        $camplog = new CampaignLog();        
		        $camplog->campaign_id  = $_POST['campaign_id'];
		        $camplog->related_id   = $lead->id;
		        $camplog->related_type = $lead->module_dir;
                $camplog->activity_type = "lead";
                $camplog->target_type = $lead->module_dir;
		        $campaign_log->activity_date=$timedate->to_display_date_time(gmdate("Y-m-d H:i:s"));
                $camplog->target_id    = $lead->id;
		        $camplog->save();
		        
		        //link campaignlog and lead               
		        $lead->load_relationship('campaigns');
		        $lead->campaigns->add($camplog->id);
		        $lead->save();
				} 
				if(isset($_POST['redirect_url']) && !empty($_POST['redirect_url'])){			
					echo '<html><head><title>SugarCRM</title></head><body>';
					echo '<form name="redirect" action="' .$_POST['redirect_url']. '" method="POST">';
		
					foreach($_POST as $param => $value) {                 
						if($param != 'redirect_url' ||$param != 'submit') {
							echo '<input type="hidden" name="'.$param.'" value="'.$value.'">';
							
						}
		
					}                  
					if(empty($lead)) {
						echo '<input type="hidden" name="error" value="1">';
					}
					echo '</form><script language="javascript" type="text/javascript">document.redirect.submit();</script>';
					echo '</body></html>';
				}
				else{
					echo $mod_strings['LBL_THANKS_FOR_SUBMITTING_LEAD'];
				}
				sugar_cleanup();
				// die to keep code from running into redirect case below
				die();
	    }		
	   else{
	  	  echo $mod_strings['LBL_SERVER_IS_CURRENTLY_UNAVAILABLE'];
	  }
}

echo $mod_strings['LBL_SERVER_IS_CURRENTLY_UNAVAILABLE'];
if (!empty($_POST['redirect'])) {
	echo '<html><head><title>SugarCRM</title></head><body>';
	echo '<form name="redirect" action="' .$_POST['redirect']. '" method="POST">';
	echo '</form><script language="javascript" type="text/javascript">document.redirect.submit();</script>';
	echo '</body></html>';
}
?>
