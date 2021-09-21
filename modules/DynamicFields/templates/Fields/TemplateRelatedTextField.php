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
require_once('modules/DynamicFields/templates/Fields/TemplateField.php');
class TemplateRelatedTextField extends TemplateText{
	
	//ext1 is the name field
	//ext2 is the related module
	
	function get_html_edit(){
		$this->prepare();
		$name = $this->name .'_name';
		$value_name = strtoupper('{'.$name.'}');
		$id = $this->name ;
		$value_id = strtoupper('{'.$id .'}');
		
		return "<input type='text' name='$name' id='$name' size='".$this->size."' readonly value='$value_name'><input type='button' onclick='open_popup(\"{". strtoupper($this->name). "_MODULE}\", 600, 400,\" \", true, false, {ENCODED_". strtoupper($this->name). "_POPUP_REQUEST_DATA})' type='button'  class='button' value='{APP.LBL_SELECT_BUTTON_LABEL}' ><input type='hidden' name='$id' value='$value_id'>";
	}

	function get_html_detail(){
		$name = $this->name .'_name';
		$value_name = strtoupper('{'.$name.'}');
		$id = $this->name ;
		$value_id = strtoupper('{'.$id .'}');
		return "<a href='index.php?module=$this->ext2&action=DetailView&record={$value_id}'>{$value_name}</a>" ;	
	}
	
	function get_html_list(){
		if(isset($this->bean)){
			$name = $this->bean->object_name . '.'. $this->ext1;
		}else{
			$name = $this->ext1;	
		}
		return '{'. strtoupper($name) . '}';	
	}
	
	//only allow searching for certain related fields - teams
	function get_xtpl_search(){
		$def = $this->bean->field_name_map[$this->name];
		$searchable = array('team_id');
		$returnXTPL = array();
		if(!empty($def['id_name']) && in_array($def['id_name'], $searchable)){
			$name = $def['id_name'];
			$team_list = '';
			foreach(get_team_array() as $id=>$team){
				$selected = '';
				
				if(!empty($_REQUEST[$name]) && is_array($_REQUEST[$name]) && in_array($id, $_REQUEST[$name])){
					$selected = 'selected';
				}
				$team_list .= "<option  $selected value='$id'>$team</option>";
			}
			$returnXTPL[strtoupper($name). '_FILTER'] = $team_list;
		}

		
		return $returnXTPL;	
	}
	
	function get_html_search(){
		
		$def = $this->bean->field_name_map[$this->name];
		$searchable = array('team_id');
		if(!empty($def['id_name']) && in_array($def['id_name'], $searchable)){
			$name = $def['id_name'];
			return "<select size='3' name='{$name}[]' tabindex='1' multiple='multiple'>{".strtoupper($name). "_FILTER}</select>";	
		}
		return 'NOT AVAILABLE';
	
	}


	function get_xtpl_edit(){
		global $beanList;
	
		
		$name = $this->name .'_name';
		$id = $this->name;
		$module = $this->ext2;
		$returnXTPL = array();
		$popup_request_data = array(
			'call_back_function' => 'set_return',
			'form_name' => 'EditView',
			'field_to_name_array' => array(
			'id' => $this->name,
			$this->ext1 => $name,
		),
		);
		
	
		$json = getJSONobj();
		$encoded_contact_popup_request_data = $json->encode($popup_request_data);
		$returnXTPL['ENCODED_'.strtoupper($id).'_POPUP_REQUEST_DATA'] = $encoded_contact_popup_request_data;
		$returnXTPL[strtoupper($id).'_MODULE'] = $module;

		if(isset($beanList[$module]) && isset($this->bean->$id)){
			if(!isset($this->bean->$name)){
				$mod_field = $this->ext1;
				global $beanFiles;
				
				$class = $beanList[$module];
			
				require_once($beanFiles[$class]);
				$mod = new $class();
				$mod->retrieve($this->bean->$id);
				if(isset($mod->$mod_field)){
					$this->bean->$name = $mod->$mod_field;	
				}	
			}
			$returnXTPL[strtoupper($id)] = $this->bean->$id;
		}
		if(isset($this->bean->$name)){
			$returnXTPL[strtoupper($name)] = $this->bean->$name;
		}
		
		
		return $returnXTPL;	
	}
	
	function get_xtpl_detail(){
		
		return $this->get_xtpl_edit();
		
	}
	
	function get_field_def(){
		return array_merge(array('required'=>$this->is_required(),'relationship' => '', 'source'=>'custom_fields', "name"=>$this->name, "vname"=>$this->label,"len"=>$this->max_size,'rname'=>$this->name, 'table'=>$this->bean->table_name . '_cstm','mass_update'=>$this->mass_update,  'custom_type'=>$this->data_type, 'type'=>'relate'),$this->get_additional_defs());	
	}
	
	function get_related_info(){
			
	}
	
	
    
	
	
}


?>
