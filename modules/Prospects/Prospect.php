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
/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/



require_once('data/SugarBean.php');
require_once('include/utils.php');

class Prospect extends SugarBean {
    var $field_name_map;
	// Stored fields
	var $id;
	var $name = '';
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $assigned_user_id;
	var $created_by;
	var $created_by_name;
	var $modified_by_name;



	var $description;
	var $salutation;
	var $first_name;
	var $last_name;
	var $full_name;
	var $title;
	var $department;
	var $birthdate;
	var $do_not_call;
	var $phone_home;
	var $phone_mobile;
	var $phone_work;
	var $phone_other;
	var $phone_fax;
	var $email1;
	var $email_and_name1;
	var $email_and_name2;
	var $email2;
	var $assistant;
	var $assistant_phone;
	var $email_opt_out;
	var $primary_address_street;
	var $primary_address_city;
	var $primary_address_state;
	var $primary_address_postalcode;
	var $primary_address_country;
	var $alt_address_street;
	var $alt_address_city;
	var $alt_address_state;
	var $alt_address_postalcode;
	var $alt_address_country;
	var $tracker_key;
	var $invalid_email;
	var $lead_id;
	var $account_name;
	var $assigned_real_user_name;
	// These are for related fields
	var $assigned_user_name;




	var $module_dir = 'Prospects';
	var $table_name = "prospects";

	var $object_name = "Prospect";

	var $new_schema = true;

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array('assigned_user_name');


	function Prospect() {
		global $current_user;
		parent::SugarBean();









	}
	
	// need to override to have a name field created for this class
	function retrieve($id = -1, $encode=true) {
		global $locale;

		$ret_val = parent::retrieve($id, $encode);

		// make a properly formatted first and last name
		$full_name = $locale->getLocaleFormattedName($this->first_name, $this->last_name, $this->salutation);
		$this->name = $full_name;
		$this->full_name = $full_name; 

		return $ret_val;
	}
    
    /**
     * Generate the name field from the first_name and last_name fields.
     */
    function _create_proper_name_field() {
        global $locale;
        $full_name = $locale->getLocaleFormattedName($this->first_name, $this->last_name, $this->salutation);
        $this->name = $full_name;
        $this->full_name = $full_name; 
    }
    
	function get_summary_text() {
        $this->_create_proper_name_field();
        return $this->name;
	}

	function create_list_query($order_by, $where, $show_deleted=0)
	{
		$custom_join = $this->custom_fields->getJOIN();
		$query = "SELECT ";
		
		$query .= "
                users.user_name as assigned_user_name ";



		if($custom_join){
   				$query .= $custom_join['select'];
 		}
        $query .= " ,$this->table_name.* 
                FROM prospects ";





		$query .=		"LEFT JOIN users
	                    ON prospects.assigned_user_id=users.id ";



		if($custom_join){
  				$query .= $custom_join['join'];
		}
			$where_auto = '1=1';
				if($show_deleted == 0){
                	$where_auto = "$this->table_name.deleted=0";
				}else if($show_deleted == 1){
                	$where_auto = "$this->table_name.deleted=1";
				}

		if($where != "")
			$query .= "where ($where) AND ".$where_auto;
		else
			$query .= "where ".$where_auto;

		if(!empty($order_by))
			$query .= " ORDER BY $order_by";

		return $query;
	}



        function create_export_query(&$order_by, &$where)
        {
        		$custom_join = $this->custom_fields->getJOIN();
                         $query = "SELECT
                                prospects.*,
                                users.user_name as assigned_user_name ";



						if($custom_join){
   							$query .= $custom_join['select'];
 						}
						 $query .= " FROM prospects ";




                         $query .= "LEFT JOIN users
	                                ON prospects.assigned_user_id=users.id ";



						if($custom_join){
  							$query .= $custom_join['join'];
						}

		$where_auto = " prospects.deleted=0 ";

                if($where != "")
                        $query .= "where ($where) AND ".$where_auto;
                else
                        $query .= "where ".$where_auto;

                if(!empty($order_by))
                        $query .= " ORDER BY $order_by";

                return $query;
        }



	function save_relationship_changes($is_update)
    {

    }
	function fill_in_additional_list_fields() {
		global $locale;

		$full_name = $locale->getLocaleFormattedName($this->first_name, $this->last_name, $this->salutation);
		$this->name = $full_name;
		$this->full_name = $full_name; 

		$this->email_and_name1 = $full_name." &lt;".$this->email1."&gt;";
		$this->email_and_name2 = $full_name." &lt;".$this->email2."&gt;";
	}

	function fill_in_additional_detail_fields() {
		global $locale;

		$full_name = $locale->getLocaleFormattedName($this->first_name, $this->last_name, $this->salutation);
		$this->name = $full_name;
		$this->full_name = $full_name; 

		// Fill in the assigned_user_name
		$this->assigned_user_name = get_assigned_user_name($this->assigned_user_id);



		$this->created_by_name = get_assigned_user_name($this->created_by);
		$this->modified_by_name = get_assigned_user_name($this->modified_user_id);
	}

	function get_list_view_data() {
		global $locale;
		
		$full_name = $locale->getLocaleFormattedName($this->first_name, $this->last_name, $this->salutation);
		$this->name = $full_name;
		$this->full_name = $full_name; 

		$temp_array = $this->get_list_view_array();
//        $temp_array["ENCODED_NAME"]=$this->first_name.' '.$this->last_name;
		$temp_array["ENCODED_NAME"] = $full_name;
		$temp_array["FULL_NAME"] = $full_name;
    	return $temp_array;
	}

	/**
		builds a generic search based on the query string using or
		do not include any $this-> because this is called on without having the class instantiated
	*/
	function build_generic_where_clause ($the_query_string)
	{
		$where_clauses = Array();
		$the_query_string = PearDatabase::quote(from_html($the_query_string));

		array_push($where_clauses, "prospects.last_name like '$the_query_string%'");
		array_push($where_clauses, "prospects.first_name like '$the_query_string%'");
		array_push($where_clauses, "prospects.assistant like '$the_query_string%'");
		array_push($where_clauses, "prospects.email1 like '$the_query_string%'");
		array_push($where_clauses, "prospects.email2 like '$the_query_string%'");

		if (is_numeric($the_query_string))
		{
			array_push($where_clauses, "prospects.phone_home like '%$the_query_string%'");
			array_push($where_clauses, "prospects.phone_mobile like '%$the_query_string%'");
			array_push($where_clauses, "prospects.phone_work like '%$the_query_string%'");
			array_push($where_clauses, "prospects.phone_other like '%$the_query_string%'");
			array_push($where_clauses, "prospects.phone_fax like '%$the_query_string%'");
			array_push($where_clauses, "prospects.assistant_phone like '%$the_query_string%'");
		}

		$the_where = "";
		foreach($where_clauses as $clause)
		{
			if($the_where != "") $the_where .= " or ";
			$the_where .= $clause;
		}


		return $the_where;
	}
/*
 * using default notification string.
	function set_notification_body($xtpl, $prospect)
	{
		$xtpl->assign("PROSPECT_NAME", trim($prospect->first_name . " " . $prospect->last_name));
		$xtpl->assign("PROSPECT_DESCRIPTION", $prospect->description);

		return $xtpl;
	}
*/
	function get_prospect_id_by_email($email)
	{
		$where_clause = "(email1='$email' OR email2='$email') AND deleted=0";

                $query = "SELECT * FROM $this->table_name WHERE $where_clause";
                $GLOBALS['log']->debug("Retrieve $this->object_name: ".$query);

		        //requireSingleResult has beeen deprecated.
                //$result = $this->db->requireSingleResult($query, true, "Retrieving record $where_clause:");
				$result = $this->db->limitQuery($query,0,1,true, "Retrieving record $where_clause:");
                
                if( empty($result))
                {
                        return null;
                }

                $row = $this->db->fetchByAssoc($result, -1, true);
		return $row['id'];

	}

    function converted_prospect($prospectid, $contactid, $accountid, $opportunityid){
    	$query = "UPDATE prospects set  contact_id=$contactid, account_id=$accountid, opportunity_id=$opportunityid where  id=$prospectid and deleted=0";
		$this->db->query($query,true,"Error converting prospect: ");
		//todo--status='Converted', converted='1',
    }	
     function bean_implements($interface){
		switch($interface){
			case 'ACL':return true;
		}
		return false;
	}
    
    /**
     *  This method will be used by Mail Merge in order to retieve the targets as specified in the query
     *  @param query String - this is the query which contains the where clause for the query
     */
    function retrieveTargetList($query, $fields, $offset = 0, $limit= -1, $max = -1, $deleted = 0, $module = ''){
        global  $beanList, $beanFiles; 
        $module_name = $this->module_dir;
       
        if(empty($module)){
            $pattern = '/AND related_type = #(.*)#/i';
            if(preg_match($pattern, $query, $matches) && count($matches) > 1){
                $module_name = $matches[1];
                $query = preg_replace($pattern, "", $query);
            }
             $GLOBALS['log']->debug("PROSPECT QUERY: ".$query);
        }
        $GLOBALS['log']->debug(var_export($matches, true));
        $count = count($fields);
        $index = 1;
        $sel_fields = "";
        if(!empty($fields)){
            foreach($fields as $field){
                if($field == 'id'){
                	$sel_fields .= 'prospect_lists_prospects.id id';
                }else{
                	$sel_fields .= $module_name.".".$field;
                }
                if($index < $count){
                    $sel_fields .= ",";  
                }
                $index++;
            }
        }
       
        $module_name = ucfirst($module_name);
        $class_name = $beanList[$module_name];
        require_once($beanFiles[$class_name]);
        $seed = new $class_name();
        if(empty($sel_fields)){
            $sel_fields = $seed->table_name.'.*';
        }
        $select = "SELECT ".$sel_fields." FROM ".$seed->table_name;
        $select .= " INNER JOIN prospect_lists_prospects ON prospect_lists_prospects.related_id = ".$seed->table_name.".id";
        $select .= " INNER JOIN prospect_list_campaigns ON prospect_list_campaigns.prospect_list_id = prospect_lists_prospects.prospect_list_id";
        $select .= " INNER JOIN campaigns on campaigns.id = prospect_list_campaigns.campaign_id";
        if (!empty($query)) {
            $select .= " WHERE ".$query;
        }
        
        return $this->process_list_query($select, $offset, $limit, $max, $query);
    }
    
    /**
     *  Given an id, looks up in the prospect_lists_prospects table
     *  and retrieve the correct type for this id
     */
    function retrieveTarget($id){
        $query = "SELECT related_id, related_type FROM prospect_lists_prospects";  
        $query .= " INNER JOIN prospect_list_campaigns ON prospect_list_campaigns.prospect_list_id = prospect_lists_prospects.prospect_list_id";
        $query .= " INNER JOIN campaigns ON campaigns.id = prospect_list_campaigns.campaign_id";
        $query .= " WHERE campaigns.id = '".$id."'"; 
        $result = $this->db->query($query);
        if(($row = $this->db->fetchByAssoc($result))){
             global  $beanList, $beanFiles; 
             $module_name = $row['related_type'];
             $class_name = $beanList[$module_name];
             require_once($beanFiles[$class_name]);
             $seed = new $class_name();
             return $seed->retrieve($row['related_id']);        
        }else{
            return null;   
        }
    }

}



?>
