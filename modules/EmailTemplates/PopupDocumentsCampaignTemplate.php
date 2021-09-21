<?php
//_pp($_REQUEST);
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
require_once('modules/Documents/Popup_picker.php');
$popup = new Popup_Picker();

global $theme;
global $current_mod_strings;
global $app_strings;
global $currentModule;
global $sugar_version, $sugar_config;
global $app_list_strings;

$current_mod_strings = return_module_language($current_language, 'Documents');
$output_html = '';
$where = '';

$where = $popup->_get_where_clause();

$image_path = 'themes/'.$theme.'/images/';

$name = empty($_REQUEST['name']) ? '' : $_REQUEST['name'];
$document_name = empty($_REQUEST['document_name']) ? '' : $_REQUEST['document_name'];
$category_id = empty($_REQUEST['category_id']) ? '' : $_REQUEST['category_id'];
$subcategory_id = empty($_REQUEST['subcategory_id']) ? '' : $_REQUEST['subcategory_id'];
$template_type = empty($_REQUEST['template_type']) ? '' : $_REQUEST['template_type'];
$is_template = empty($_REQUEST['is_template']) ? '' : $_REQUEST['is_template'];
$document_revision_id = empty($_REQUEST['document_revision_id']) ? '' : $_REQUEST['document_revision_id'];
$document_mime_type = empty($_REQUEST['last_rev_mime_type']) ? '' : $_REQUEST['last_rev_mime_type'];
$document_mime_type = empty($_REQUEST['latest_revision']) ? '' :$_REQUEST['latest_revision'];

//$request_data = empty($_REQUEST['request_data']) ? '' : $_REQUEST['request_data'];

$hide_clear_button = empty($_REQUEST['hide_clear_button']) ? false : true;
$button  = "<form action='index.php' method='post' name='form' id='form'>\n";
if(!$hide_clear_button)
{
	$button .= "<input type='button' name='button' class='button' onclick=\"send_back('','');\" title='"
		.$app_strings['LBL_CLEAR_BUTTON_TITLE']."' accesskey='"
		.$app_strings['LBL_CLEAR_BUTTON_KEY']."' value='  "
		.$app_strings['LBL_CLEAR_BUTTON_LABEL']."  ' />\n";
}
$button .= "<input type='submit' name='button' class='button' onclick=\"window.close();\" title='"
	.$app_strings['LBL_CANCEL_BUTTON_TITLE']."' accesskey='"
	.$app_strings['LBL_CANCEL_BUTTON_KEY']."' value='  "
	.$app_strings['LBL_CANCEL_BUTTON_LABEL']."  ' />\n";
$button .= "</form>\n";


$form = new XTemplate('modules/EmailTemplates/PopupDocumentsCampaignTemplate.html');
$form->assign('MOD', $current_mod_strings);
$form->assign('APP', $app_strings);
$form->assign('THEME', $theme);
$form->assign('MODULE_NAME', $currentModule);
$form->assign('NAME', $name);
$form->assign('DOCUMENT_NAME', $document_name);
$form->assign('DOCUMENT_TARGET', $_REQUEST['target']);
$form->assign('DOCUMENT_REVISION_ID', $document_revision_id);
$form->assign('DOCUMENT_MIME_TYPE', $document_mime_type);

//$form->assign('request_data', $request_data);
$form->assign("CATEGORY_OPTIONS", get_select_options_with_id($app_list_strings['document_category_dom'], $category_id));
$form->assign("SUB_CATEGORY_OPTIONS", get_select_options_with_id($app_list_strings['document_subcategory_dom'], $subcategory_id));
$form->assign("IS_TEMPLATE_OPTIONS", get_select_options_with_id($app_list_strings['checkbox_dom'], $is_template));
$form->assign("TEMPLATE_TYPE_OPTIONS", get_select_options_with_id($app_list_strings['document_template_type_dom'], $template_type));


ob_start();
insert_popup_header($theme);
$output_html .= ob_get_contents();
ob_end_clean();

$output_html .= get_form_header($current_mod_strings['LBL_SEARCH_FORM_TITLE'], '', false);

$form->parse('main.SearchHeader');
$output_html .= $form->text('main.SearchHeader');

$output_html .= get_form_footer();

// Reset the sections that are already in the page so that they do not print again later.
$form->reset('main.SearchHeader');

// create the listview
$seed_bean = new Document();
$ListView = new ListView();
$ListView->show_export_button = false;
$ListView->process_for_popups = true;
$ListView->setXTemplate($form);
$ListView->setHeaderTitle($current_mod_strings['LBL_LIST_FORM_TITLE']);
$ListView->setHeaderText($button);
$ListView->setQuery($where, '', 'document_name', 'DOCUMENT');
$ListView->setModStrings($current_mod_strings);

ob_start();
$ListView->processListView($seed_bean, 'main', 'DOCUMENT');
$output_html .= ob_get_contents();
ob_end_clean();
		
$output_html .= get_form_footer();
$output_html .= insert_popup_footer();


echo $output_html;










?>
