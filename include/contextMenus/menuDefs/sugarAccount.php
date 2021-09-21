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

global $app_strings;

$menuDef['sugarAccount'] = array(
    array('text' => 'LBL_ADD_TO_FAVORITES',
          'action' => 'SUGAR.contextMenu.actions.addToFavorites'),
    array('text' => 'LBL_CREATE_NOTE',
          'action' => 'SUGAR.contextMenu.actions.createNote',
          'module' => 'Notes',
          'aclAction' => 'edit'),
      array('text' => 'LBL_CREATE_TASK',
          'action' => 'SUGAR.contextMenu.actions.createTask',
          'module' => 'Tasks',
          'aclAction' => 'edit'),
    array('text' => 'LBL_CREATE_CONTACT',
          'action' => 'SUGAR.contextMenu.actions.createContact',
          'module' => 'Contacts',
          'aclAction' => 'edit'),
    array('text' => 'LBL_CREATE_OPPORTUNITY',
          'action' => 'SUGAR.contextMenu.actions.createOpportunity',
          'module' => 'Opportunties',
          'aclAction' => 'edit'),
    array('text' => 'LBL_CREATE_CASE',
          'action' => 'SUGAR.contextMenu.actions.createCase',
          'module' => 'Cases',
          'aclAction' => 'edit'),
    array('text' => 'LBL_SCHEDULE_MEETING',
          'action' => 'SUGAR.contextMenu.actions.scheduleMeeting',
          'module' => 'Meetings',
          'aclAction' => 'edit'),
    array('text' => 'LBL_SCHEDULE_CALL',
          'action' => 'SUGAR.contextMenu.actions.scheduleCall',
          'module' => 'Calls',
          'aclAction' => 'edit'),
    );

?>
