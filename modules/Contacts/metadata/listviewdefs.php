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



$listViewDefs['Contacts'] = array(
	'NAME' => array(
		'width' => '20%', 		
		'label' => 'LBL_LIST_NAME', 
		'link' => true,
        'contextMenu' => array('objectType' => 'sugarPerson', 
                               'metaData' => array('contact_id' => '{$ID}', 
                                                   'module' => 'Contacts',
                                                   'return_action' => 'ListView', 
                                                   'contact_name' => '{$FULL_NAME}', 
                                                   'parent_id' => '{$ACCOUNT_ID}',
                                                   'parent_name' => '{$ACCOUNT_NAME}',
                                                   'return_module' => 'Contacts', 
                                                   'return_action' => 'ListView', 
                                                   'parent_type' => 'Account', 
                                                   'notes_parent_type' => 'Account')
                              ),
		'orderBy' => 'last_name',
        'default' => true,
        'related_fields' => array('first_name', 'last_name', 'salutation', 'account_name', 'account_id'),
		), 
	'TITLE' => array(
		'width' => '15%', 
		'label' => 'LBL_LIST_TITLE',
        'default' => true), 
	'ACCOUNT_NAME' => array(
		'width' => '34%', 
		'label' => 'LBL_LIST_ACCOUNT_NAME', 
		'module' => 'Accounts',
		'id' => 'ACCOUNT_ID',
		'link' => true,
        'contextMenu' => array('objectType' => 'sugarAccount', 
                               'metaData' => array('return_module' => 'Contacts', 
                                                   'return_action' => 'ListView', 
                                                   'module' => 'Accounts',
                                                   'return_action' => 'ListView', 
                                                   'parent_id' => '{$ACCOUNT_ID}', 
                                                   'parent_name' => '{$ACCOUNT_NAME}', 
                                                   'account_id' => '{$ACCOUNT_ID}', 
                                                   'account_name' => '{$ACCOUNT_NAME}'),
                              ),
        'default' => true,
        'sortable'=> true,
        'ACLTag' => 'ACCOUNT',
        'related_fields' => array('account_id')),
	'EMAIL1' => array(
		'width' => '15%', 
		'label' => 'LBL_LIST_EMAIL_ADDRESS',
		'link' => true,
		'customCode' => '{$EMAIL1_LINK}{$EMAIL1}</a>',
        'default' => true
		),  
	'PHONE_WORK' => array(
		'width' => '15%', 
		'label' => 'LBL_OFFICE_PHONE',
        'default' => true),
    'DEPARTMENT' => array(
        'width' => '10', 
        'label' => 'LBL_DEPARTMENT'),
    'DO_NOT_CALL' => array(
        'width' => '10', 
        'label' => 'LBL_DO_NOT_CALL'),
    'PHONE_HOME' => array(
        'width' => '10', 
        'label' => 'LBL_HOME_PHONE'),
    'PHONE_MOBILE' => array(
        'width' => '10', 
        'label' => 'LBL_MOBILE_PHONE'),
    'PHONE_OTHER' => array(
        'width' => '10', 
        'label' => 'LBL_OTHER_PHONE'),
    'PHONE_FAX' => array(
        'width' => '10', 
        'label' => 'LBL_FAX_PHONE'),
    'EMAIL2' => array(
        'width' => '15', 
        'label' => 'LBL_LIST_EMAIL_ADDRESS',
        'customCode' => '{$EMAIL2_LINK}{$EMAIL2}</a>'),  
    'EMAIL_OPT_OUT' => array(
        'width' => '10', 
        'label' => 'LBL_EMAIL_OPT_OUT'),
    'PRIMARY_ADDRESS_STREET' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_STREET'),
    'PRIMARY_ADDRESS_CITY' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_CITY'),
    'PRIMARY_ADDRESS_STATE' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_STATE'),
    'PRIMARY_ADDRESS_POSTALCODE' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE'),
    'ALT_ADDRESS_COUNTRY' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_COUNTRY'),
    'ALT_ADDRESS_STREET' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_STREET'),
    'ALT_ADDRESS_CITY' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_CITY'),
    'ALT_ADDRESS_STATE' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_STATE'),
    'ALT_ADDRESS_POSTALCODE' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_POSTALCODE'),
    'ALT_ADDRESS_COUNTRY' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_COUNTRY'),
    'DATE_ENTERED' => array(
        'width' => '10', 
        'label' => 'LBL_DATE_ENTERED'),
    'CREATED_BY_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_CREATED'),






    'ASSIGNED_USER_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'default' => true),
    'MODIFIED_USER_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_MODIFIED')
);
?>
