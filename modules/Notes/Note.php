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
require_once('include/upload_file.php');

// Note is used to store customer information.
class Note extends SugarBean {
	var $field_name_map;
	// Stored fields
	var $id;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $created_by;
	var $created_by_name;
	var $modified_by_name;
	var $description;
	var $name;
	var $filename;
	// handle to an upload_file object
	// used in emails
	var $file;
	var $embed_flag; // inline image flag
	var $parent_type;
	var $parent_id;
	var $contact_id;
	var $portal_flag;




	var $parent_name;
	var $contact_name;
	var $contact_phone;
	var $contact_email;
	var $file_mime_type;
	var $module_dir = "Notes";
	var $default_note_name_dom = array('Meeting notes', 'Reminder');
	var $table_name = "notes";
	var $new_schema = true;
	var $object_name = "Note";

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array('contact_name', 'contact_phone', 'contact_email', 'parent_name','first_name','last_name');
	
	

	function Note() {
		parent::SugarBean();



	}
	
	function safeAttachmentName() {
		global $sugar_config;
		
		//get position of last "." in file name
		$file_ext_beg = strrpos($this->filename, ".");
		$file_ext = "";
		
		//get file extension
		if($file_ext_beg > 0) {
			$file_ext = substr($this->filename, $file_ext_beg + 1);
		}
		
		//check to see if this is a file with extension located in "badext"
		foreach($sugar_config['upload_badext'] as $badExt) {
			if(strtolower($file_ext) == strtolower($badExt)) {
				//if found, then append with .txt and break out of lookup
				$this->name = $this->name . ".txt";
				$this->file_mime_type = 'text/';
				$this->filename = $this->filename . ".txt";
				break; // no need to look for more
			}
		}
		
	}
	
	/**
	 * overrides SugarBean's method.
	 * If a system setting is set, it will mark all related notes as deleted, and attempt to delete files that are
	 * related to those notes
	 * @param string id ID
	 */
	function mark_deleted($id) {
		global $sugar_config;
		
		if($this->parent_type == 'Emails') {
			if(isset($sugar_config['email_default_delete_attachments']) && $sugar_config['email_default_delete_attachments'] == true) {
				$removeFile = getcwd()."/{$sugar_config['upload_dir']}{$id}";
				if(file_exists($removeFile)) {
					if(!unlink($removeFile)) {
						$GLOBALS['log']->error("*** Could not unlink() file: [ {$removeFile} ]");
					}
				}
			}
		}
		
		// delete note
		parent::mark_deleted($id);
	}
	
	function deleteAttachment(){
		if($this->ACLAccess('edit'))
			$removeFile = getcwd()."/{$GLOBALS['sugar_config']['upload_dir']}{$this->id}";
			if(file_exists($removeFile)) {
				if(!unlink($removeFile)) {
					$GLOBALS['log']->error("*** Could not unlink() file: [ {$removeFile} ]");
				}else{
					$this->filename = '';
					$this->file_mime_type = ''; 
					$this->file = '';
					$this->save();
					return true;
				}
			}
		return false;
	}	


	function get_summary_text() {
		return "$this->name";
	}

	function create_list_query($order_by, $where, $show_deleted=0) {
		$contact_required = ereg("contacts\.first_name", $where);
		$contact_required = 1;
		$query = "SELECT ";
		$custom_join = $this->custom_fields->getJOIN();

		if($contact_required) {
    		$query .= "$this->table_name.*";



			if ( ( $this->db->dbType == 'mysql' ) or ( $this->db->dbType == 'oci8' ) )
			{
				$query .= ", concat(concat(contacts.first_name , ' '), contacts.last_name) AS contact_name";
			}
			if($this->db->dbType == 'mssql')
			{
				$query .= ", contacts.first_name + ' ' + contacts.last_name AS contact_name";
			}
			$query .= ", contacts.assigned_user_id contact_name_owner";

			if($custom_join) {
				$query .= $custom_join['select'];
			}

			$query.= " FROM notes ";






			
			$query .= " LEFT JOIN contacts ON notes.contact_id=contacts.id ";
			
			if($custom_join) {
   				$query .= $custom_join['join'];
 			}
 			$where_auto = '1=1';
			if($show_deleted == 0) {
				$where_auto = " (contacts.deleted IS NULL OR contacts.deleted=0) AND notes.deleted=0";
			} elseif($show_deleted == 1) {
				$where_auto = " notes.deleted=0 ";
			}
		} else {
			$query .= ' id, name, parent_type, parent_id, contact_id, filename, date_modified ';
			if($custom_join) {
   				$query .= $custom_join['select'];
 			}








 			if($custom_join) {
   				$query .= $custom_join['join'];
 			}

 			$where_auto = '1=1';
 			if($show_deleted == 0) {
				$where_auto = "deleted=0";
 			} elseif($show_deleted == 1) {
 				$where_auto = "deleted=1"; 	
 			}
		}

		if($where != "")
			$query .= "where $where AND ".$where_auto;
		else
			$query .= "where ".$where_auto;
		if($order_by != ""){
				 $query .=  " ORDER BY ". $this->process_order_by($order_by, null);
		
		}else
		{
			$query .= " ORDER BY notes.name";
		}
		return $query;
	}




	function create_export_query(&$order_by, &$where) {
		$custom_join = $this->custom_fields->getJOIN();
		$query = "SELECT notes.*, contacts.first_name, contacts.last_name ";

		if($custom_join) {
   			$query .= $custom_join['select'];
 		}
    	
    	$query .= " FROM notes ";




		
		$query .= "	LEFT JOIN contacts ON notes.contact_id=contacts.id ";
	
		if($custom_join) {
			$query .= $custom_join['join'];
		}
        
		$where_auto = " notes.deleted=0 AND (contacts.deleted IS NULL OR contacts.deleted=0)";
					
        if($where != "")
			$query .= "where $where AND ".$where_auto;
        else
			$query .= "where ".$where_auto;

        if($order_by != "")
			$query .=  " ORDER BY ". $this->process_order_by($order_by, null);
        else
			$query .= " ORDER BY notes.name";

		return $query;
	}

	function fill_in_additional_list_fields() {
		$this->fill_in_additional_parent_fields();
	}

	function fill_in_additional_detail_fields() {
		//TODO:  Seems odd we need to clear out these values so that list views don't show the previous rows value if current value is blank
		$this->contact_name = '';
		$this->contact_phone = '';
		$this->contact_email = '';
		$this->parent_name = '';
		$this->contact_name_owner = '';
		$this->contact_name_mod = '';

		if(isset($this->contact_id) && $this->contact_id != '') {
			require_once("modules/Contacts/Contact.php");
			$contact = new Contact();
			$query = "SELECT first_name, last_name, phone_work, email1, assigned_user_id contact_name_owner from $contact->table_name where id = '$this->contact_id'";
			$result =$this->db->query($query,true," Error filling in additional detail fields: ");

			// Get the id and the name.
			$row = $this->db->fetchByAssoc($result);

			if($row != null) {
				$this->contact_name_owner = $row['contact_name_owner'];
				$this->contact_name_mod = 'Contacts';
				$this->contact_name = return_name($row, 'first_name', 'last_name');
				
				if($row['phone_work'] != '') 
					$this->contact_phone = $row['phone_work'];
				else
					$this->contact_phone = '';
				if($row['email1'] != '') 
					$this->contact_email = $row['email1'];
				else 
					$this->contact_email = '';
			}

		}




		$this->created_by_name = get_assigned_user_name($this->created_by);
		$this->modified_by_name = get_assigned_user_name($this->modified_user_id);
		$this->fill_in_additional_parent_fields();
	}

	function fill_in_additional_parent_fields() {
		global $app_strings;
		global $beanFiles, $beanList;
		global $locale;
		
		$this->parent_name = '';
		// cn: bug 6324 - load parent_type|name dynamically
		if(!empty($this->parent_type) and isset($beanFiles[$beanList[$this->parent_type]])) {
			require_once($beanFiles[$beanList[$this->parent_type]]);
			$parentBean = new $beanList[$this->parent_type]();
			$parentBean->retrieve($this->parent_id);
			
			// cn: bug 10626 contacts, leads, users, etc. have no "name" column
			if(isset($parentBean->name) && !empty($parentBean->name)) {
				$this->parent_name = $parentBean->name;
			} elseif(method_exists($parentBean, '_create_proper_name_field')) {
				$parentBean->_create_proper_name_field();
				$this->parent_name = $parentBean->full_name;
			} elseif(isset($parentBean->first_name) && isset($parentBean->last_name)) {
				$this->parent_name = $locale->getLocaleFormattedName($parentBean->first_name, $parentBean->last_name);
			}

			if(isset($parentBean->assigned_user_id) && !empty($parentBean->assigned_user_id)) {
				$this->parent_name_owner = $parentBean->assigned_user_id;
				$this->parent_name_mod = $this->parent_type;
			}
		}
	}
	
	function get_list_view_data() {
		$note_fields = $this->get_list_view_array();
		global $app_list_strings, $focus, $action, $currentModule,$mod_strings, $sugar_config;
		$note_fields["DATE_MODIFIED"] = substr($note_fields["DATE_MODIFIED"], 0 , 10);
		if(isset($this->parent_type)) {
			$note_fields['PARENT_MODULE'] = $this->parent_type;
		}

		if(!isset($this->filename) || $this->filename != ''){  
            $file_path = UploadFile::get_file_path($this->filename,$this->id);
    
            if(file_exists($file_path)){
                $save_file = urlencode(basename(UploadFile::get_url($this->filename,$this->id)));
                $note_fields['FILENAME'] = $this->filename; 
                $note_fields['FILE_URL'] = "download.php?id=".$save_file."&type=Notes";
            }






        }

		global $current_language;
		$mod_strings = return_module_language($current_language, 'Notes');
		$note_fields['STATUS']=$mod_strings['LBL_NOTE_STATUS'];


		return $note_fields;
	}
	
	function listviewACLHelper() {
		$array_assign = parent::listviewACLHelper();
		$is_owner = false;
		if(!empty($this->parent_name)) {
			if(!empty($this->parent_name_owner)) {
				global $current_user;
				$is_owner = $current_user->id == $this->parent_name_owner;
			}
		}
			
		if(!ACLController::moduleSupportsACL($this->parent_type) || ACLController::checkAccess($this->parent_type, 'view', $is_owner)) {
			$array_assign['PARENT'] = 'a';
		} else {
			$array_assign['PARENT'] = 'span';
		}
		
		$is_owner = false;
		if(!empty($this->contact_name)) {
			if(!empty($this->contact_name_owner)) {
				global $current_user;
				$is_owner = $current_user->id == $this->contact_name_owner;
			}
		}
			
		if( ACLController::checkAccess('Contacts', 'view', $is_owner)) {
			$array_assign['CONTACT'] = 'a';
		} else {
			$array_assign['CONTACT'] = 'span';
		}
		
		return $array_assign;
	}
	
	function bean_implements($interface) {
		switch($interface) {
			case 'ACL':return true;
		}
		return false;
	}

}
?>
