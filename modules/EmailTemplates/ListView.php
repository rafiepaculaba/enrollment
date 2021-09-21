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
require_once('include/QuickSearchDefaults.php');
require_once('modules/EmailTemplates/EmailTemplate.php');
require_once('themes/'.$theme.'/layout_utils.php');
require_once('include/ListView/ListView.php');
require_once('modules/MySettings/StoreQuery.php');

global $list_max_entries_per_page;
global $urlPrefix;
global $currentModule;
global $image_path;
global $focus_list; // focus_list is the means of passing data to a ListView.
global $title;

$header_text = '';
$seedEmailTemplate = new EmailTemplate();
$storeQuery = new StoreQuery();
$qsd = new QuickSearchDefaults();
$list_form = new XTemplate ('modules/EmailTemplates/ListView.html');

echo $qsd->GetQSScripts();

if(empty($_POST['mass']) && empty($where) && empty($_REQUEST['query'])) {
	$_REQUEST['query']='true'; $_REQUEST['current_user_only']='checked'; 
}

if(!isset($_REQUEST['query'])) {
	$storeQuery->loadQuery($currentModule);
	$storeQuery->populateRequest();
} else {
	$storeQuery->saveFromGet($currentModule);	
}

if(!isset($_REQUEST['search_form']) || $_REQUEST['search_form'] != 'false') {
	// Stick the form header out there.
	$search_form=new XTemplate ('modules/EmailTemplates/SearchForm.html');
	$search_form->assign("MOD", $mod_strings);
	$search_form->assign("APP", $app_strings);

	if(isset($_REQUEST['query'])) {
		if(isset($_REQUEST['name'])) $search_form->assign("NAME", $_REQUEST['name']);
		if(isset($_REQUEST['description'])) $search_form->assign("DESCRIPTION", $_REQUEST['description']);
	}
	// adding custom fields:
	$seedEmailTemplate->custom_fields->populateXTPL($search_form, 'search' );
	$search_form->parse("main");
	echo "\n<p>\n";

	if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])) {	
		$header_text = "&nbsp;<a href='index.php?action=index&module=DynamicLayout&from_action=SearchForm&from_module=".$_REQUEST['module'] ."'>".get_image($image_path."EditLayout","border='0' alt='Edit Layout' align='bottom'")."</a>";
	}

	echo get_form_header($mod_strings['LBL_SEARCH_FORM_TITLE']. $header_text, "", false);
	$search_form->out("main");
	echo get_form_footer();
	echo "\n</p>\n";
}

$list_form->assign("MOD", $mod_strings);
$list_form->assign("APP", $app_strings);
$list_form->assign("THEME", $theme);
$list_form->assign("IMAGE_PATH", $image_path);
$list_form->assign("MODULE_NAME", $currentModule);

$where = "";

if(isset($_REQUEST['query'])) {
	// we have a query
	$name = '';
	$desc = '';
	if(isset($_REQUEST['name'])) { 
		$name = $_REQUEST['name'];
	}
	if(isset($_REQUEST['description'])) {
		$desc = $_REQUEST['description'];
	}

	$where_clauses = array();

	if(!empty($name)) {
		array_push($where_clauses, "email_templates.name like '%".PearDatabase::quote($name)."%'");
	}
	if(!empty($desc)) {
		array_push($where_clauses, "email_templates.description like '%".PearDatabase::quote($desc)."%'");
	}
	
	$seedEmailTemplate->custom_fields->setWhereClauses($where_clauses);

	$where = "";
	





	if(isset($where_clauses)) {
		foreach($where_clauses as $clause) {
			if($where != "")
			$where .= " and ";
			$where .= $clause;
		}
	}
	$GLOBALS['log']->info("Here is the where clause for the list view: $where");
}


$display_title = $mod_strings['LBL_LIST_FORM_TITLE'];

if($title) {
	$display_title = $title;
}

$ListView = new ListView();

if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])) {	
	$header_text = "&nbsp;<a href='index.php?action=index&module=DynamicLayout&from_action=ListView&from_module=".$_REQUEST['module'] ."'>".get_image($image_path."EditLayout","border='0' alt='Edit Layout' align='bottom'")."</a>";
}
$ListView->initNewXTemplate( 'modules/EmailTemplates/ListView.html',$mod_strings);
$ListView->setHeaderTitle($display_title . $header_text);
$ListView->setQuery($where, "", "email_templates.date_entered DESC", "EMAIL_TEMPLATE");
$ListView->processListView($seedEmailTemplate, "main", "EMAIL_TEMPLATE");
?>
