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

require_once('XTemplate/xtpl.php');
require_once('data/Tracker.php');
require_once('modules/Leads/Lead.php');
require_once('modules/Leads/Forms.php');
require_once('include/DetailView/DetailView.php');


global $mod_strings;
global $app_strings;
global $app_list_strings;

$focus = new Lead();

$detailView = new DetailView();
$offset=0;
if (isset($_REQUEST['offset']) or isset($_REQUEST['record'])) {
	$result = $detailView->processSugarBean("LEAD", $focus, $offset);
	if($result == null) {
	    sugar_die($app_strings['ERROR_NO_RECORD']);
	}
	$focus=$result;
} else {
	header("Location: index.php?module=Accounts&action=index");
}
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
}
echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME'].": ".$focus->first_name." ".$focus->last_name, true);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
require_once($theme_path.'layout_utils.php');

$GLOBALS['log']->info("Lead detail/edit view");

// cn: i18n
$focus->_create_proper_name_field();

$xtpl=new XTemplate ('modules/Leads/DetailView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("PREFORM", "<form name='vcard' action='vCard.php'><input type='hidden' name='contact_id' value='".$focus->id."'><input type='hidden' name='module' value='Lead'></form>");
$xtpl->assign("VCARD_LINK", "<input type='button' class='button' name='vCardButton' value='vCard' onClick='document.vcard.submit();'>");
$xtpl->assign("THEME", $theme);
$xtpl->assign("GRIDLINE", $gridline);
$xtpl->assign("IMAGE_PATH", $image_path);$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("ACCOUNT_NAME", $focus->account_name);
$xtpl->assign("OPPORTUNITY_NAME", $focus->opportunity_name);
$xtpl->assign("OPPORTUNITY_AMOUNT", $focus->opportunity_amount);
$xtpl->assign("OPPORTUNITY_ID", $focus->opportunity_id);

$LS = trim($focus->lead_source);
if(!empty($LS)){
	$xtpl->assign("LEAD_SOURCE", $app_list_strings['lead_source_dom'][$focus->lead_source]);
	}else{
		$xtpl->assign("LEAD_SOURCE", " ");
	}
$xtpl->assign('FORMATTED_NAME', $focus->full_name);
$xtpl->assign("TITLE", $focus->title);
$xtpl->assign("DEPARTMENT", $focus->department);

$xtpl->assign("CREATED_BY", $focus->created_by_name);
$xtpl->assign("MODIFIED_BY", $focus->modified_by_name);

if ($focus->do_not_call == 'on') $xtpl->assign("DO_NOT_CALL", "checked");
$xtpl->assign("ASSIGNED_TO", $focus->assigned_user_name);
global $system_config;
if(isset($system_config->settings['system_skypeout_on']) && $system_config->settings['system_skypeout_on'] == 1){
  if(!empty($focus->phone_home) && skype_formatted($focus->phone_home)) $focus->phone_home = '<a href="callto://' . $focus->phone_home. '">'.$focus->phone_home. '</a>' ;  	
  if(!empty($focus->phone_work) && skype_formatted($focus->phone_work)) $focus->phone_work = '<a href="callto://' . $focus->phone_work. '">'.$focus->phone_work. '</a>' ;  		
  if(!empty($focus->phone_mobile)&& skype_formatted($focus->phone_mobile)) $focus->phone_mobile = '<a href="callto://' . $focus->phone_mobile. '">'.$focus->phone_mobile. '</a>' ;  		
   if(!empty($focus->phone_mobile)&& skype_formatted($focus->phone_other)) $focus->phone_mobile = '<a href="callto://' . $focus->phone_other. '">'.$focus->phone_other. '</a>' ;  		
  	
}
$xtpl->assign("PHONE_HOME", $focus->phone_home);
$xtpl->assign("PHONE_MOBILE", $focus->phone_mobile);
$xtpl->assign("PHONE_WORK", $focus->phone_work);
$xtpl->assign("PHONE_OTHER", $focus->phone_other);
$xtpl->assign("PHONE_FAX", $focus->phone_fax);
$xtpl->assign('EMAIL1_LINK', $current_user->getEmailLink('email1', $focus));
$xtpl->assign('EMAIL2_LINK', $current_user->getEmailLink('email2', $focus));
$xtpl->assign("EMAIL1", $focus->email1);
$xtpl->assign("EMAIL2", $focus->email2);

if ($focus->invalid_email == '1') $xtpl->assign("INVALID_EMAIL", "checked");
if ($focus->email_opt_out == 'on') $xtpl->assign("EMAIL_OPT_OUT", "checked");
$xtpl->assign("PRIMARY_ADDRESS_STREET", $focus->primary_address_street);
$xtpl->assign("PRIMARY_ADDRESS_CITY", $focus->primary_address_city);
$xtpl->assign("PRIMARY_ADDRESS_STATE", $focus->primary_address_state);
$xtpl->assign("PRIMARY_ADDRESS_POSTALCODE", $focus->primary_address_postalcode);
$xtpl->assign("PRIMARY_ADDRESS_COUNTRY", $focus->primary_address_country);
$xtpl->assign("ALT_ADDRESS_STREET", $focus->alt_address_street);
$xtpl->assign("ALT_ADDRESS_CITY", $focus->alt_address_city);
$xtpl->assign("ALT_ADDRESS_STATE", $focus->alt_address_state);
$xtpl->assign("ALT_ADDRESS_POSTALCODE", $focus->alt_address_postalcode);
$xtpl->assign("ALT_ADDRESS_COUNTRY", $focus->alt_address_country);
$xtpl->assign("DESCRIPTION", nl2br(url2html($focus->description)));
$xtpl->assign("DATE_MODIFIED", $focus->date_modified);
$xtpl->assign("DATE_ENTERED", $focus->date_entered);
$xtpl->assign("STATUS",(!empty($focus->status) ? $app_list_strings['lead_status_noblank_dom'][$focus->status]:""));

global $current_user;
if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){

	$xtpl->assign("ADMIN_EDIT","<a href='index.php?action=index&module=DynamicLayout&from_action=".$_REQUEST['action'] ."&from_module=".$_REQUEST['module'] ."&record=".$_REQUEST['record']. "'>".get_image($image_path."EditLayout","border='0' alt='Edit Layout' align='bottom'")."</a>");
}

$detailView->processListNavigation($xtpl, "LEAD", $offset, $focus->is_AuditEnabled());
// adding custom fields:
require_once('modules/DynamicFields/templates/Files/DetailView.php');






$xtpl->parse("main.open_source");



















$xtpl->assign("LEAD_SOURCE_DESCRIPTION", nl2br($focus->lead_source_description));
$xtpl->assign("STATUS_DESCRIPTION", nl2br($focus->status_description));
$xtpl->assign("REFERED_BY", $focus->refered_by);
$preform = "<table width='100%' border='1' cellspacing='0' cellpadding='0'><tr><td><table width='100%'><tr><td>";
$displayPreform = false;
$tags = $focus->listviewACLHelper();
if(isset($focus->contact_id) && isset($focus->contact_name)){
	$tag = $tags['CONTACT'];
	$displayPreform = true;
	$preform .= $mod_strings["LBL_CONVERTED_CONTACT"]."&nbsp;<$tag href='index.php?module=Contacts&action=DetailView&record=".$focus->contact_id."'>".$focus->contact_name."</$tag>";
}
$preform .= "</td><td>";
if(isset($focus->account_id) && !empty($focus->account_id)&& isset($focus->account_name)){
	$displayPreform = true;
	$tag = $tags['ACCOUNT'];
	$preform .=$mod_strings["LBL_CONVERTED_ACCOUNT"]."&nbsp;<$tag href='index.php?module=Accounts&action=DetailView&record=".$focus->account_id."'>".$focus->account_name."</$tag>";
}
$preform .= "</td><td>";
if(isset($focus->opportunity_id) && !empty($focus->opportunity_id) &&isset($focus->opportunity_name)){
	$displayPreform = true;
	$tag = $tags['OPPORTUNITY'];
	$preform .= $mod_strings["LBL_CONVERTED_OPP"]."&nbsp;<$tag href='index.php?module=Opportunities&action=DetailView&record=".$focus->opportunity_id."'>".$focus->opportunity_name."</$tag>";
}

if(isset($focus->campaign_id) && !empty($focus->campaign_id)){
	require_once('modules/Campaigns/Campaign.php');
	//$focus->load_relationship('lead_campaign');
	$camp = new Campaign();
    $where = "campaigns.id='{$focus->campaign_id}'";
    $campaign_list = $camp->get_full_list("campaigns.name", $where,true);
    //_ppd($campaign_list[0]->name);
	$xtpl->assign('CAMPAIGN_NAME',$campaign_list[0]->name);	
}
$preform.= "</td></tr></table></td></tr></table>";
if($displayPreform){
	$xtpl->assign("PREVIEW", $preform);
}

///////////////////////////////////////////////////////////////////////////////
////	TO SUPPORT LEGACY XTEMPLATES
$xtpl->assign('FIRST_NAME', $focus->first_name);
$xtpl->assign('LAST_NAME', $focus->last_name);
$xtpl->assign('SALUTATION', $focus->salutation);
////	END SUPPORT LEGACY XTEMPLATES
///////////////////////////////////////////////////////////////////////////////


$xtpl->parse("main");
$xtpl->out("main");

$sub_xtpl = $xtpl;
$old_contents = ob_get_contents();
ob_end_clean();
ob_start();
echo $old_contents;

require_once('include/SubPanel/SubPanelTiles.php');
$subpanel = new SubPanelTiles($focus, 'Leads');
echo $subpanel->display();

require_once('modules/SavedSearch/SavedSearch.php');
$savedSearch = new SavedSearch();
$json = getJSONobj();
$savedSearchSelects = $json->encode(array($GLOBALS['app_strings']['LBL_SAVED_SEARCH_SHORTCUT'] . '<br>' . $savedSearch->getSelect('Leads')));
$str = "<script>
YAHOO.util.Event.addListener(window, 'load', SUGAR.util.fillShortcuts, $savedSearchSelects);
</script>";
echo $str;



//override set_and_save_background js call

$j_str = "
<script>
function set_campaignlog_and_save_background(popup_reply_data)
{
    var form_name = popup_reply_data.form_name;
    var name_to_value_array = popup_reply_data.name_to_value_array;
    var passthru_data = popup_reply_data.passthru_data;
    // construct the POST request
    var query_array =  new Array();
    if (name_to_value_array != 'undefined') {
        for (var the_key in name_to_value_array)
        {
            if(the_key == 'toJSON')
            {
                /* just ignore */
            }
            else
            {
                query_array.push(the_key+\"=\"+name_to_value_array[the_key]);
            }
        }
    }
    //construct the muulti select list
    var selection_list;
     if(popup_reply_data.selection_list)
    {
        selection_list  = popup_reply_data.selection_list;
    }
    else
    {
        selection_list  = popup_reply_data.name_to_value_array;
    }

    if (selection_list != 'undefined') {
        for (var the_key in selection_list)
        {
            query_array.push('subpanel_id[]='+selection_list[the_key])
        }   
    }
    var module = get_module_name();
    var id = get_record_id();

    query_array.push('value=DetailView');
    query_array.push('module='+module);    //query_array.push('module='+module);
    query_array.push('http_method=get');
    query_array.push('return_module='+module);
    query_array.push('return_id='+id);
    query_array.push('record='+id);
    query_array.push('isDuplicate=false');
    query_array.push('return_type=addcampaignlog');
    query_array.push('action=Save2');
    query_array.push('inline=1');

    var refresh_page = escape(passthru_data['refresh_page']);
    for (prop in passthru_data) {
        if (prop=='link_field_name') {
            query_array.push('subpanel_field_name='+escape(passthru_data[prop]));   
        } else {
            if (prop=='module_name') {
                query_array.push('subpanel_module_name='+escape(passthru_data[prop]));  
            } else {
                query_array.push(prop+'='+escape(passthru_data[prop])); 
            }
        }
    }   

    var query_string = query_array.join('&');
    request_map[request_id] = passthru_data['child_field'];
    var returnstuff = http_fetch_sync('index.php',query_string);
    request_id++;
    got_data(returnstuff, true);
    if(refresh_page == 1){
        document.location.reload(true);
    }
}
</script>
";
echo $j_str
?>
