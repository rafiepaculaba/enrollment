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

class SugarWidgetFieldEnum extends SugarWidgetReportField {

    function SugarWidgetFieldEnum(&$layout_manager) {
        parent::SugarWidgetReportField($layout_manager);
        $this->reporter = $this->layout_manager->getAttribute('reporter');  
    }
	
	function queryFilterEmpty(&$layout_def)
	{
        if( $this->reporter->db->dbType == 'mysql') {
	    	return '( '.$this->_get_column_select($layout_def).' IS NULL OR '.$this->_get_column_select($layout_def)."='' )\n";
        }		
        elseif( $this->reporter->db->dbType == 'mssql') {
	    	return '( '.$this->_get_column_select($layout_def).' IS NULL OR '.$this->_get_column_select($layout_def)." LIKE '' )\n";
        }





	}

	 function queryFilterNot_Empty(&$layout_def)
	 {
	    $reporter = $this->layout_manager->getAttribute("reporter");
        if( $this->reporter->db->dbType == 'mysql') {
	   		return '( '.$this->_get_column_select($layout_def).' IS NOT NULL AND '.$this->_get_column_select($layout_def)."<>'' )\n";
        }
        else if( $this->reporter->db->dbType == 'mssql') {
	        return $this->_get_column_select($layout_def).' IS NOT NULL ' . "\n";
        }






	 }
	
	    
	function queryFilteris(& $layout_def) {
		$input_name0 = $layout_def['input_name0'];
		if (is_array($layout_def['input_name0'])) {
			$input_name0 = $layout_def['input_name0'][0];
		}
		return $this->_get_column_select($layout_def)." like '%".PearDatabase :: quote($input_name0)."%'\n";
	}

	function queryFilterone_of(& $layout_def) {
		$arr = array ();
		foreach ($layout_def['input_name0'] as $value) {
			array_push($arr, "'".PearDatabase :: quote($value)."'");
		}
	    $reporter = $this->layout_manager->getAttribute("reporter");

		if (isset($reporter->focus) && isset($reporter->focus->field_name_map[$layout_def['name']]['source']) && 
			isset($reporter->focus->field_name_map[$layout_def['name']]['source']) == 'custom_fields') {
		    if ($reporter->focus->custom_fields->bean->custom_fields->avail_fields[$layout_def['name']]['data_type'] == 'multienum') {
	        	$col_name = $this->_get_column_select($layout_def) . " LIKE " ;
	        	$arr_count = count($arr);
	        	$query = "";
	        	foreach($arr as $key=>$val) {
	        		$query .= $col_name;
					$value = preg_replace("/^'/", "'%", $val, 1);
					$value = preg_replace("/'$/", "%'", $value, 1);
					$query .= $value;
					if ($key != ($arr_count - 1))
	        			$query.= " OR " ;	
	        	}
				return '('.$query.')';        
		    }
		}
        if( $layout_def['type'] == 'enum') {
			$str = implode(",", $arr);
			return $this->_get_column_select($layout_def)." IN (".$str.")\n";
        } 
	}

	function & displayListPlain($layout_def) {
		$field_def = $this->reporter->all_fields[$layout_def['column_key']];
		
		if (empty ($field_def['fields']) || empty ($field_def['fields'][0]) || empty ($field_def['fields'][1]))
			$value = $this->_get_list_value($layout_def);
			$cell = translate($field_def['options'], $field_def['module'], $value);
		if (is_array($cell)) {
			$cell = str_replace('^,^' ,', ', $value);
		}
		return $cell;
	}


	function & queryOrderBy($layout_def) {
		$field_def = $this->reporter->all_fields[$layout_def['column_key']];
		if (!empty ($field_def['sort_on'])) {
			$order_by = $layout_def['table_alias'].".".$field_def['sort_on'];
		} else {





				$order_by = $this->_get_column_select($layout_def);



		}

		$list = translate($field_def['options'], $field_def['module']);

		$order_by_arr = array ();




















			if (empty ($layout_def['sort_dir']) || $layout_def['sort_dir'] == 'a') {
				$order_dir = " DESC";
			} else {
				$order_dir = " ASC";
			}

			foreach ($list as $key => $value) {
				array_push($order_by_arr, $order_by."='".$key."' $order_dir\n");
			}
			$thisarr = implode(',', $order_by_arr);
			return $thisarr;




    }
    
    function displayInput(&$layout_def) {
        global $app_list_strings;
        if(!empty($layout_def['remove_blank']) && $layout_def['remove_blank']) {
            $ops = $app_list_strings[$layout_def['options']];
            if(array_key_exists('', $app_list_strings[$layout_def['options']])) {
                unset($ops['']);
            }
        }
        else {
            $ops = $app_list_strings[$layout_def['options']];
        }
        
        $str = '<select multiple="true" size="3" name="' . $layout_def['name'] . '[]">';
        $str .= get_select_options_with_id($ops, $layout_def['input_name0']);
        $str .= '</select>';
        return $str;
    }
}
?>

