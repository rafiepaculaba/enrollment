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



$listViewDefs['Users'] = array(
    'NAME' => array(
        'width' => '40', 
        'label' => 'LBL_LIST_NAME', 
        'link' => true,
        'related_fields' => array('last_name', 'first_name'),
        'orderBy' => 'last_name',
        'default' => true),
    'USER_NAME' => array(
        'width' => '5', 
        'label' => 'LBL_USER_NAME', 
        'link' => true,
        'default' => true),
    'DEPARTMENT' => array(
        'width' => '15', 
        'label' => 'LBL_DEPARTMENT', 
        'link' => true,
        'default' => true),
    'EMAIL1' => array(
        'width' => '40', 
        'label' => 'LBL_LIST_EMAIL', 
        'link' => true,
        'default' => true),
    'PHONE_WORK' => array(
        'width' => '40', 
        'label' => 'LBL_LIST_PHONE', 
        'link' => true,
        'default' => true),
    'STATUS' => array(
        'width' => '10', 
        'label' => 'LBL_STATUS', 
        'link' => false,
        'default' => true),
    'IS_ADMIN' => array(
        'width' => '10', 
        'label' => 'LBL_ADMIN', 
        'link' => false,
        'default' => true),                      
    'IS_GROUP' => array(
        'width' => '40', 
        'label' => 'LBL_LIST_GROUP', 
        'link' => true,
        'default' => false),

);
?>
