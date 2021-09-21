<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * Table definition file for the project_relation table
 *
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



$dictionary['project_task_project_tasks'] = array(
	'table' => 'project_task_project_tasks',
	'fields' => array(
		'id' => array(
			'name' => 'id',
			'vname' => 'LBL_ID',
			'required' => true,
			'type' => 'id',
		),
		'project_task_id' => array(
			'name' => 'project_task_id',
			'vname' => 'LBL_PROJECT_TASK_ID',
			'required' => true,
			'type' => 'id',
		),
        'predecessor_project_task_id' => array(
            'name' => 'predecessor_project_task_id',
            'vname' => 'LBL_PROJECT_TASK_ID',
            'required' => true,
            'type' => 'id',
        ),        
		'deleted' => array(
			'name' => 'deleted',
			'vname' => 'LBL_DELETED',
			'type' => 'bool',
			'required' => true,
			'default' => '0',
		),
	),
	'indices' => array(
		array(
			'name' =>'proj_rel_pk',
			'type' =>'primary',
			'fields'=>array('id')
		),
	),

    'relationships' => array(
        'project_task_project_tasks' => array(
            'lhs_module'        => 'ProjectTasks2', 
            'lhs_table'         => 'project_tasks', 
            'lhs_key'           => 'id',
            'rhs_module'        => 'ProjectTasks2', 
            'rhs_table'         => 'project_tasks', 
            'rhs_key'           => 'id',
            'relationship_type' => 'many-to-many',
            'join_table'        => 'project_task_project_tasks', 
            'join_key_lhs'      => 'project_task_id', 
            'join_key_rhs'      => 'predecessor_project_task_id',
        ),
    ),
);

?>
