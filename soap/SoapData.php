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
require_once('soap/SoapRelationshipHelper.php');
set_time_limit(360);
 
$server->register(
    'sync_get_modified_relationships',
    array('session'=>'xsd:string', 'module_name'=>'xsd:string','related_module'=>'xsd:string', 'from_date'=>'xsd:string', 'to_date'=>'xsd:string','offset'=>'xsd:int', 'max_results'=>'xsd:int','deleted'=>'xsd:int', 'module_id'=>'xsd:string', 'select_fields'=>'tns:select_fields', 'ids'=>'tns:select_fields', 'relationship_name'=>'xsd:string', 'deletion_date'=>'xsd:string', 'php_serialize'=>'xsd:int'),
    array('return'=>'tns:get_entry_list_result_encoded'),
    $NAMESPACE);



/**
 * Get a list of the relationship records that have been modified within a 
 * specified date range.  This is used to perform a sync with a mobile client.
 * The results are paged.
 *
 * @param xsd:string $session
 * @param xsd:string $module_name
 * @param xsd:string $related_module
 * @param xsd:string $from_date
 * @param xsd:string $to_date
 * @param xsd:int $offset
 * @param xsd:int $max_results
 * @param xsd:int $deleted
 * @param xsd:int $module_id
 * @param tns:select_fields $select_fields
 * @param tns:select_fields $ids
 * @param xsd:string $relationship_name
 * @param xsd:string $deletion_date
 * @param xsd:int $php_serialize
 * @return 
 */
function sync_get_modified_relationships($session, $module_name, $related_module,$from_date,$to_date,$offset, $max_results, $deleted, $module_id = '', $select_fields = array(), $ids = array(), $relationship_name = '', $deletion_date = '', $php_serialize = 1){
	global  $beanList, $beanFiles;
	$error = new SoapError();
	$output_list = array();
	if(!validate_authenticated($session)){
		$error->set_error('invalid_login');	
		return array('result_count'=>-1, 'entry_list'=>array(), 'error'=>$error->get_soap_array());
	}
	if(empty($beanList[$module_name]) || empty($beanList[$related_module])){
		$error->set_error('no_module');	
		return array('result_count'=>-1, 'entry_list'=>array(), 'error'=>$error->get_soap_array());
	}
	global $current_user;
	if(!check_modules_access($current_user, $module_name, 'read') || !check_modules_access($current_user, $related_module, 'read')){
		$error->set_error('no_access');	
		return array('result_count'=>-1, 'entry_list'=>array(), 'error'=>$error->get_soap_array());
	}
	if($max_results > 0 || $max_results == '-99'){
		global $sugar_config;
		$sugar_config['list_max_entries_per_page'] = $max_results;	
	}

	$date_query = "(m1.date_modified > " . db_convert("'$from_date'", 'datetime'). " AND m1.date_modified <= ". db_convert("'$to_date'", 'datetime')." AND {0}.deleted = $deleted)";
	if(isset($deletion_date) && !empty($deletion_date)){
		$date_query .= " OR ({0}.date_modified > " . db_convert("'$deletion_date'", 'datetime'). " AND {0}.date_modified <= ". db_convert("'$to_date'", 'datetime')." AND {0}.deleted = 1)";
	}

	$in = '';
	if(isset($ids) && !empty($ids)){
		foreach($ids as $value){
			if(empty($in))
			{
				$in .= "('" . $value . "'";	
			}
			else
			{
				$in .= ",'" . $value . "'";	
			}
		}
		$in .=')';
	}
	$query = '';
	if(isset($in) && !empty($in)){
		$query .= "( $date_query AND m1.id IN $in) OR (m1.id NOT IN $in AND {0}.deleted = 0)";
	}
	else{
		$query .= "( {0}.deleted = 0)";
	}
	if(isset($module_id) && !empty($module_id)){
		//if(isset($in) && !empty($in)){
			$query .= " AND";
		//}
		$query .= " m2.id = '$module_id'";
	}
	if($related_module == 'Meetings' || $related_module == 'Calls'){
		$query = string_format($query, array('m1'));	
	}	
	$results = retrieve_modified_relationships($module_name,  $related_module, $query, $deleted, $offset, $max_results, $select_fields, $relationship_name);

	$list = $results['result'];
	
	$xml = '<?xml version="1.0" encoding="utf-8"?><items>';
	foreach($list as $value)
	{
		$val = array_get_return_value($value, $results['table_name']);
		if($php_serialize == 0){
			$xml .= get_name_value_xml($val, $module_name);
		}
		$output_list[] = $val;
	}
	$xml .= '</items>';
	$next_offset = $offset + sizeof($output_list);
	
	if($php_serialize == 0){
		$myoutput = base64_encode($xml);	
	}
	else{
		$myoutput = get_encoded($output_list);
	}
	
	return array('result_count'=>sizeof($output_list),'next_offset'=>0, 'total_count'=>sizeof($output_list), 'field_list'=>array(), 'entry_list'=>$myoutput , 'error'=>$error->get_soap_array());
}


$server->register(
    'get_modified_entries',
    array('session'=>'xsd:string', 'module_name'=>'xsd:string', 'ids'=>'tns:select_fields', 'select_fields'=>'tns:select_fields'),
    array('return'=>'tns:get_sync_result_encoded'),
    $NAMESPACE);

function get_modified_entries($session, $module_name, $ids, $select_fields ){
	global  $beanList, $beanFiles;
	$error = new SoapError();
	$field_list = array();
	$output_list = array();
	if(!validate_authenticated($session)){
		$error->set_error('invalid_login');	
		return array('field_list'=>$field_list, 'entry_list'=>array(), 'error'=>$error->get_soap_array());
	}
	if(empty($beanList[$module_name])){
		$error->set_error('no_module');	
		return array('field_list'=>$field_list, 'entry_list'=>array(), 'error'=>$error->get_soap_array());
	}
	global $current_user;
	if(!check_modules_access($current_user, $module_name, 'read')){
		$error->set_error('no_access');	
		return array('field_list'=>$field_list, 'entry_list'=>array(), 'error'=>$error->get_soap_array());
	}
	
	$class_name = $beanList[$module_name];
	require_once($beanFiles[$class_name]);
	$seed = new $class_name();
	//rsmith
	$in = '';
	$field_select ='';
	
	$table_name = $seed->table_name;
	if(isset($ids)){
		foreach($ids as $value){
			if(empty($in))
			{
				$in .= "('" . $value . "'";	
			}
			else
			{
				$in .= ",'" . $value . "'";	
			}
		}//end foreach
	}
	$index = 0;
	foreach($select_fields as $field){
			$field_select .= $table_name.".".$field;
		
			if($index < (count($select_fields) - 1))
			{
				$field_select .= ",";
				$index++;
			}
		}//end foreach
	
		$ids = array();
	
	//end rsmith
	if(!empty($in)){
			$in .=')';	
	}
	
	$query = $seed->create_list_query($seed->process_order_by('', null), "$table_name.id IN $in", -2);
	$pattern = '/SELECT.*('.$table_name.'\.\*.*?)/is';  // ignores the case
	$replacement = 'SELECT '. $field_select .' ';
	$modified_select_query = preg_replace($pattern, $replacement, $query);
	$result = $seed->db->query($modified_select_query , true, "Error running count query for $seed->object_name List: ");
	$xml = '<?xml version="1.0" encoding="utf-8"?><items>';
	while($row = $seed->db->fetchByAssoc($result))
	{
		$val = array_get_return_value($row, $table_name);
		$xml .= get_name_value_xml($val, $module_name);	
	}
	$xml .= "</items>";
	
	$xml = base64_encode($xml);
	
	return array('result'=>$xml, 'error'=>$error->get_soap_array());
}

$server->register(
    'get_attendee_list',
    array('session'=>'xsd:string', 'module_name'=>'xsd:string', 'id'=>'xsd:string'),
    array('return'=>'tns:get_sync_result_encoded'),
    $NAMESPACE);

function get_attendee_list($session, $module_name, $id){
	global  $beanList, $beanFiles;
	$error = new SoapError();
	$field_list = array();
	$output_list = array();
	if(!validate_authenticated($session)){
		$error->set_error('invalid_login');	
		return array('field_list'=>$field_list, 'entry_list'=>array(), 'error'=>$error->get_soap_array());
	}
	if(empty($beanList[$module_name])){
		$error->set_error('no_module');	
		return array('field_list'=>$field_list, 'entry_list'=>array(), 'error'=>$error->get_soap_array());
	}
	global $current_user;
	if(!check_modules_access($current_user, $module_name, 'read')){
		$error->set_error('no_access');	
		return array('field_list'=>$field_list, 'entry_list'=>array(), 'error'=>$error->get_soap_array());
	}
	

	$class_name = $beanList[$module_name];
	require_once($beanFiles[$class_name]);
	$seed = new $class_name();
	
			//rsmith
			$xml = '<?xml version="1.0" encoding="utf-8"?>';
			if($module_name == 'Meetings' || $module_name == 'Calls'){
				//if we find a meeting or call we want to send back the attendees
				$l_module_name = strtolower($module_name);
				$table_name = $l_module_name."_users";
				if($module_name == 'Meetings')
					$join_field = "meeting";
				else
					$join_field = "call";
				$xml .= '<attendees>';
				$result = $seed->db->query("SELECT users.id, $table_name.date_modified, first_name, last_name, email1 FROM users INNER JOIN $table_name ON $table_name.user_id = users.id WHERE ".$table_name.".".$join_field."_id = '".$id."' AND $table_name.deleted = 0"); 
				while($row = $seed->db->fetchByAssoc($result))
				{
					$xml .= '<attendee>';
					$xml .= '<id>'.$row['id'].'</id>';
					$xml .= '<first_name>'.$row['first_name'].'</first_name>';
					$xml .= '<last_name>'.$row['last_name'].'</last_name>';
					$xml .= '<email1>'.$row['email1'].'</email1>';
					$xml .= '</attendee>';
				}	
				//now get contacts
				$table_name = $l_module_name."_contacts";
				$result = $seed->db->query("SELECT contacts.id, $table_name.date_modified, first_name, last_name, email1 FROM contacts INNER JOIN $table_name ON $table_name.contact_id = contacts.id INNER JOIN $seed->table_name ON ".$seed->table_name.".id = ".$table_name.".".$join_field."_id WHERE ".$table_name.".".$join_field."_id = '".$id."' AND ".$table_name.".deleted = 0 AND (contacts.id != ".$seed->table_name.".parent_id OR ".$seed->table_name.".parent_id IS NULL)"); 
				while($row = $seed->db->fetchByAssoc($result))
				{
					$xml .= '<attendee>';
					$xml .= '<id>'.$row['id'].'</id>';
					$xml .= '<first_name>'.$row['first_name'].'</first_name>';
					$xml .= '<last_name>'.$row['last_name'].'</last_name>';
					$xml .= '<email1>'.$row['email1'].'</email1>';
					$xml .= '</attendee>';
				}					
				$xml .= '</attendees>';
			}
			
	$xml = base64_encode($xml);
	return array('result'=>$xml, 'error'=>$error->get_soap_array());
}
?>
