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



$listViewDefs['Meetings'] = array(
    'SET_COMPLETE' => array(
        'width' => '1', 
        'label' => 'LBL_LIST_CLOSE',
        'link' => true,
        'sortable' => false,
        'default' => true,
        'related_fields' => array('status')),
    'MI_ICON' => array(
        'width' => '1', 
        'label' => 'LBL_BLANK',
        'sortable' => false,
        'link' => true,
        'default' => true),
    'NAME' => array(
        'width' => '40', 
        'label' => 'LBL_LIST_SUBJECT', 
        'link' => true,
        'default' => true),
    'CONTACT_NAME' => array(
        'width' => '20', 
        'label' => 'LBL_LIST_CONTACT', 
        'link' => true,
        'id' => 'CONTACT_ID',
        'module' => 'Contacts',
        'default' => true,
        'ACLTag' => 'CONTACT'), 
    'PARENT_NAME' => array(
        'width'   => '20', 
        'label'   => 'LBL_LIST_RELATED_TO',
        'dynamic_module' => 'PARENT_TYPE',
        'id' => 'PARENT_ID',
        'link' => true,
        'default' => true,
        'sortable' => false,        
        'ACLTag' => 'PARENT',
        'related_fields' => array('parent_id', 'parent_type')), 
    'DATE_START' => array(
        'width' => '15', 
        'label' => 'LBL_LIST_DATE', 
        'link' => false,
        'default' => true,
        'related_fields' => array('time_start'),
        ),    
    'TIME_START' => array(
        'width' => '5', 
        'label' => 'LBL_LIST_TIME', 
        'link' => false,
        'default' => false,
        'related_fields' => array('date_start'),
    ),






    
    'ASSIGNED_USER_NAME' => array(
        'width' => '2', 
        'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
        'default' => true),
  
    'STATUS' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_STATUS', 
        'link' => false,
        'default' => false),              
);
?>
