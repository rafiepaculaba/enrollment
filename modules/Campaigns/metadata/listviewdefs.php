<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$listViewDefs['Campaigns'] = array(
	'NAME' => array(
		'width' => '20', 
		'label' => 'LBL_LIST_CAMPAIGN_NAME',
        'link' => true,
        'default' => true), 
	'STATUS' => array(
		'width' => '10', 
		'label' => 'LBL_LIST_STATUS',
        'default' => true),
    'CAMPAIGN_TYPE' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_TYPE',
        'default' => true),
    'END_DATE' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_END_DATE',
        'default' => true),        
        






	'ASSIGNED_USER_NAME' => array(
		'width' => '8', 
		'label' => 'LBL_LIST_ASSIGNED_USER',
        'default' => true),
    'TRACK_CAMPAIGN' => array(
        'width' => '1', 
        'label' => '&nbsp;',
        'link' => true,
        'customCode' => ' <a title="' . $mod_strings["LBL_TRACK_BUTTON_TITLE"] . '" href="index.php?action=TrackDetailView&module=Campaigns&record={$ID}"><img border="0" src="' . $image_path . 'view_status.gif"></a> ',                
        'default' => true,
        'sortable' => false),      
    'LAUNCH_WIZARD' => array(
        'width' => '1', 
        'label' => '&nbsp;',
        'link' => true,
        'customCode' => ' <a title="' . $mod_strings["LBL_TO_WIZARD_TITLE"] . '" href="index.php?action=WizardHome&module=Campaigns&record={$ID}"><img border="0" src="' . $image_path . 'edit_wizard.gif"></a>  ',
        'default' => true,
        'sortable' => false),                
);
?>
