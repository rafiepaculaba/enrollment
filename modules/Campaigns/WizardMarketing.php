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

/**************************** general UI Stuff *******************/
require_once('include/Sugar_Smarty.php');
require_once('data/Tracker.php');
require_once('modules/Campaigns/Campaign.php');
require_once('modules/Campaigns/utils.php');
require_once('modules/Campaigns/Forms.php');
require_once ('modules/Currencies/Currency.php');

global $app_strings;
global $timedate;
global $app_list_strings;
global $mod_strings;
global $current_user;
global $sugar_version, $sugar_config;


/**************************** GENERAL SETUP WORK*******************/
$campaign_focus = new Campaign();
if (isset($_REQUEST['campaign_id']) && !empty($_REQUEST['campaign_id'])) {
    $campaign_focus->retrieve($_REQUEST['campaign_id']);
}else{
    sugar_die($app_strings['ERROR_NO_RECORD']);   
}    
    
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
require_once($theme_path.'layout_utils.php');

$json = getJSONobj();

$GLOBALS['log']->info("Wizard Continue Create Wizard");
 if($campaign_focus->campaign_type=='NewsLetter'){
    echo "\n<p>\n";
    echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_NEWSLETTER WIZARD_TITLE'].' '.$campaign_focus->name, true);
    echo "\n</p>\n";
 }else{
    echo "\n<p>\n";
    echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_CAMPAIGN'].' '.$campaign_focus->name, true);
    echo "\n</p>\n";
 }

$ss = new Sugar_Smarty();
$ss->assign("MOD", $mod_strings);
$ss->assign("APP", $app_strings);
if (isset($_REQUEST['return_module'])) $ss->assign("RETURN_MODULE", $_REQUEST['return_module']);
if (isset($_REQUEST['return_action'])) $ss->assign("RETURN_ACTION", $_REQUEST['return_action']);
if (isset($_REQUEST['return_id'])) $ss->assign("RETURN_ID", $_REQUEST['return_id']);
// handle Create $module then Cancel
$ss->assign("THEME", $theme);
$ss->assign("IMAGE_PATH", $image_path);
$ss->assign('CAMPAIGN_ID', $campaign_focus->id);

$seps = get_number_seperators();
$ss->assign("NUM_GRP_SEP", $seps[0]);
$ss->assign("DEC_SEP", $seps[1]);


/**************************** MARKETING UI DIV Stuff *******************/
//$campaign_focus->load_relationship('emailmarketing');
//$mrkt_ids = $campaign_focus->emailmarketing->get();
require_once('modules/EmailMarketing/EmailMarketing.php');
$mrkt_focus = new EmailMarketing();

//if record param exists and it is not empty, then retrieve this bean
if(isset($_REQUEST['record']) and !empty($_REQUEST['record'])){
    $mrkt_focus->retrieve($_REQUEST['record']);
}else{
        //check to see if this campaign has an email marketing already attached, and if so, create duplicate
        $campaign_focus->load_relationship('emailmarketing');
        $mrkt_lists = $campaign_focus->emailmarketing->get();
        if(!empty($mrkt_lists)){
            //reverse array so we always use the most recent one:
            $mrkt_lists = array_reverse($mrkt_lists);
            $mrkt_focus->retrieve($mrkt_lists[0]);
            $mrkt_focus->id = '';
            $mrkt_focus->name = $mod_strings['LBL_COPY_OF'] . ' '. $mrkt_focus->name;
        }
    
}
    
        
$ss->assign("CALENDAR_LANG", "en");
$ss->assign("USER_DATEFORMAT", '('. $timedate->get_user_date_format().')');
$ss->assign("CALENDAR_DATEFORMAT", $timedate->get_cal_date_format());
$ss->assign("TIME_MERIDIEM", $timedate->AMPMMenu('', $mrkt_focus->time_start));
$ss->assign("MRKT_ID", $mrkt_focus->id);
$ss->assign("MRKT_NAME", $mrkt_focus->name);
$ss->assign("MRKT_FROM_NAME", $mrkt_focus->from_name);
$ss->assign("MRKT_FROM_ADDR", $mrkt_focus->from_addr);
$ss->assign("MRKT_DATE_START", $mrkt_focus->date_start);
$ss->assign("MRKT_TIME_START", $mrkt_focus->time_start);
//$_REQUEST['mass'] = $mrkt_focus->id;
$ss->assign("MRKT_ID", $mrkt_focus->id);
$emails=array();
$mailboxes=get_campaign_mailboxes($emails);


//add empty options.
$emails['']='nobody@example.com';
$mailboxes['']='';

//inbound_email_id
$default_email_address='nobody@example.com';
$from_emails = '';
foreach ($mailboxes as $id=>$name) {
    if (!empty($from_emails)) {
        $from_emails.=',';
    }
    if ($id=='') {
        $from_emails.="'EMPTY','$name','$emails[$id]'";
    } else {
        $from_emails.="'$id','$name','$emails[$id]'";
    }
        if ($id==$mrkt_focus->inbound_email_id) {
        $default_email_address=$emails[$id];
    }
}
$ss->assign("FROM_EMAILS",$from_emails);
$ss->assign("DEFAULT_FROM_EMAIL",$default_email_address);
$ss->assign("STATUS_OPTIONS", get_select_options_with_id($app_list_strings['email_marketing_status_dom'],$mrkt_focus->status));
if (empty($mrkt_focus->inbound_email_id)) {
    $ss->assign("MAILBOXES", get_select_options_with_id($mailboxes, ''));
} else {
    $ss->assign("MAILBOXES", get_select_options_with_id($mailboxes, $mrkt_focus->inbound_email_id));   
}

$ss->assign("TIME_MERIDIEM", $timedate->AMPMMenu('', $mrkt_focus->time_start));
$ss->assign("TIME_FORMAT", '('. $timedate->get_user_time_format().')');

$email_templates_arr = get_bean_select_array(true, 'EmailTemplate','name','','name');
if($mrkt_focus->template_id) {
    $ss->assign("TEMPLATE_ID", $mrkt_focus->template_id);
    $ss->assign("EMAIL_TEMPLATE_OPTIONS", get_select_options_with_id($email_templates_arr, $mrkt_focus->template_id));
    $ss->assign("EDIT_TEMPLATE","visibility:inline");
}
else {
    $ss->assign("EMAIL_TEMPLATE_OPTIONS", get_select_options_with_id($email_templates_arr, ""));
    $ss->assign("EDIT_TEMPLATE","visibility:hidden");
}
    
  
$scope_options=get_message_scope_dom($campaign_focus->id,$campaign_focus->name,$mrkt_focus->db);
$prospectlists=array();
if (isset($mrkt_focus->all_prospect_lists) && $mrkt_focus->all_prospect_lists==1) {
    $ss->assign("ALL_PROSPECT_LISTS_CHECKED","checked");
    $ss->assign("MESSAGE_FOR_DISABLED","disabled");       
}   
else {
    //get select prospect list.
    if (!empty($mrkt_focus->id)) {
        $mrkt_focus->load_relationship('prospectlists');
        $prospectlists=$mrkt_focus->prospectlists->get();
    };
}
if (empty($prospectlists)) $prospectlists=array();
if (empty($scope_options)) $scope_options=array();
$ss->assign("SCOPE_OPTIONS", get_select_options_with_id($scope_options, $prospectlists));
$ss->assign("SAVE_CONFIRM_MESSAGE", $mod_strings['LBL_CONFIRM_SEND_SAVE']);


require_once('include/javascript/javascript.php');
$javascript = new javascript();
$javascript->setFormName('wizform');
$javascript->setSugarBean($mrkt_focus);
$javascript->addAllFields('');
echo $javascript->getScript();

/**************************** Final Step UI DIV *******************/

    //Grab the prospect list of type default
    $default_pl_focus = ' ';
        $campaign_focus->load_relationship('prospectlists');
        $prospectlists=$campaign_focus->prospectlists->get();

    require_once('modules/ProspectLists/ProspectList.php');
    $pl_count = 0;
    $pl_lists = 0;
    if(!empty($prospectlists)){
        foreach ($prospectlists as $prospect_id){
            $pl_focus = new ProspectList();
            $pl_focus->retrieve($prospect_id);
    
            if (($pl_focus->list_type == 'default') || ($pl_focus->list_type == 'seed')){
                $default_pl_focus= $pl_focus;
                // get count of all attached target types
                $pl_count = $default_pl_focus->get_entry_count();
             }
             $pl_lists = $pl_lists+1;
        }

            
    }
    //if count is 0, then hide inputs and and print warning message
    if ($pl_count==0){
        if ($pl_lists==0){
            //print no target list warning
            $ss->assign("WARNING_MESSAGE", $mod_strings['LBL_NO_TARGETS_WARNING']);
        }else{
            //print no entries warning
            if($campaign_focus->campaign_type='NewsLetter'){
                $ss->assign("WARNING_MESSAGE", $mod_strings['LBL_NO_SUBS_ENTRIES_WARNING']);
            }else{
               $ss->assign("WARNING_MESSAGE", $mod_strings['LBL_NO_TARGET_ENTRIES_WARNING']);
            }
        }
        //disable the send email options
        $ss->assign("PL_DISABLED",'disabled');
        
    }else{
        //show inputs and assign type to be radio
    }



/**************************** WIZARD UI DIV Stuff *******************/

$camp_url = "index.php?action=WizardNewsletter&module=Campaigns&return_module=Campaigns&return_action=WizardHome";
$camp_url .= "&return_id=".$campaign_focus->id."&record=".$campaign_focus->id."&direct_step=";
$ss->assign("CAMP_WIZ_URL", $camp_url);
    $summ_url = $mod_strings['LBL_NAVIGATION_MENU_SUMMARY'];
    if(!empty($focus->id)){
        $summ_url = "<a  class ='listViewTdLinkS1' href='index.php?action=WizardHome&module=Campaigns";
        $summ_url .= "&return_id=".$focus->id."&record=".$focus->id;
        $summ_url .= "'> ". $mod_strings['LBL_NAVIGATION_MENU_SUMMARY']."</a>";
    } 
$summ_url = $mod_strings['LBL_NAVIGATION_MENU_SUMMARY'];
if(!empty($focus->id)){
    $summ_url = "index.php?action=WizardHome&module=Campaigns&return_id=".$focus->id."&record=".$focus->id; 
}   
$ss->assign("SUMM_URL", $summ_url);

//  this is the wizard control script that resides in page    
 $divScript = <<<EOQ

 <script type="text/javascript" language="javascript">  
    /*
     * this is the custom validation script that will call the right validation for each div
     */
    function validate_wiz_form(step){
        switch (step){
            case 'step1':
            return check_form('wizform');
            break;
            default://no additional validation needed      
        }
        return true;
    
    }
  
    showfirst('marketing')
</script>
EOQ;

//$ss->assign("WIZ_JAVASCRIPT", print_wizard_jscript());
$ss->assign("DIV_JAVASCRIPT", $divScript);





/**************************** FINAL END OF PAGE UI Stuff *******************/

      $ss->display('modules/Campaigns/WizardMarketing.html');
?>
