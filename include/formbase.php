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

 * Description:  is a form helper
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

/**
 * Check for null or zero for list of values
 * @param $prefix the prefix of value to be checked
 * @param $required array of value to be checked
 * @return boolean true if all values are set in the array
 */
function checkRequired($prefix, $required)
{
	foreach($required as $key)
	{
		if(!isset($_POST[$prefix.$key]) || number_empty($_POST[$prefix.$key]))
		{
			return false;
		}
	}
	return true;
}
function populateFromPost($prefix, &$focus)
{
	global $current_user;
	
	if(!empty($_REQUEST[$prefix.'record']))
		$focus->retrieve($_REQUEST[$prefix.'record']);
	
	if(isset($_REQUEST[$prefix.'status']) && !empty($_REQUEST[$prefix.'status']))
	{
		// cn: bug 12088
		if(is_string($_REQUEST[$prefix.'status'])){
			$focus->status = $_REQUEST[$prefix.'status'];
        }	
	}
	if (!empty($_POST['assigned_user_id']) && 
	    ($focus->assigned_user_id != $_POST['assigned_user_id']) && 
	    ($_POST['assigned_user_id'] != $current_user->id)) 
	{
		$GLOBALS['check_notify'] = true;
	}
	foreach($focus->column_fields as $field) {
		if(isset($_POST[$prefix.$field])) {
			if(is_array($_POST[$prefix.$field]) && !empty($focus->field_defs[$field]['isMultiSelect'])) {
				if(empty($_POST[$prefix.$field][0])) {
					unset($_POST[$prefix.$field][0]);
				}
				if(!empty($_POST[$prefix.$field][0])) {
					$_POST[$prefix.$field] = implode('^,^', $_POST[$prefix.$field]);	
				} else {
					continue;	
				}
			}

			$focus->$field = $_POST[$prefix.$field];
			
			/* 
			 * overrides the passed value for booleans.
			 * this will be fully deprecated when the change to binary booleans is complete.
			 */
			if(isset($focus->field_defs[$prefix.$field]) && $focus->field_defs[$prefix.$field]['type'] == 'bool' && isset($focus->field_defs[$prefix.$field]['options'])) {
				$opts = explode("|", $focus->field_defs[$prefix.$field]['options']);
				$bool = $_POST[$prefix.$field];

				if(is_int($bool) || ($bool === "0" || $bool === "1" || $bool === "2")) {
					// 1=on, 2=off
					$selection = ($_POST[$prefix.$field] == "0") ? 1 : 0;
				} elseif(is_bool($_POST[$prefix.$field])) {
					// true=on, false=off
					$selection = ($_POST[$prefix.$field]) ? 0 : 1;
				}
				$focus->$field = $opts[$selection];
				
				// special processing for Tasks
				if($focus->object_name == 'Task') {
					if($field == 'date_due_flag' && $focus->$field == 'on') {
						$reset_date = 'on';
					}
				}
			}
		}
	}
	
	foreach($focus->additional_column_fields as $field) {
		if(isset($_POST[$prefix.$field])) {
			$value = $_POST[$prefix.$field];
			$focus->$field = $value;
		}
	}
	
	// special processing for Tasks
	if(isset($reset_date)) {
		$focus->date_due = '';
		$focus->time_due = '';
	}

	return $focus;
}

function getPostToForm($ignore='')
{
	$fields = '';
	foreach ($_POST as $key=>$value)
	{
		if($key != $ignore)
			$fields.= "<input type='hidden' name='$key' value='$value'>";
	}
	return $fields;

}
function getGetToForm($ignore='')
{
	$fields = '';
	foreach ($_GET as $key=>$value)
	{
		if($key != $ignore)
			$fields.= "<input type='hidden' name='$key' value='$value'>";
	}
	return $fields;

}
function getAnyToForm($ignore='')
{
	$fields = getPostToForm($ignore);
	$fields .= getGetToForm($ignore);
	return $fields;

}

function handleRedirect($return_id='', $return_module='')
{
	if(isset($_REQUEST['return_url']) && $_REQUEST['return_url'] != "")
	{
		//header("Location: ". html_entity_decode($_REQUEST['return_url']));
		header("Location: ". $_REQUEST['return_url']);

		exit;
	}

	if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "")
	{
		$return_module = $_REQUEST['return_module'];
	}
	else
	{
		$return_module = $return_module;
	}
	if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "")
	{
	    
	   //if we are doing a "Close and Create New"
        if($_REQUEST['action'] == "Save" && isset($_REQUEST['isSaveAndNew']) && 
            $_REQUEST['isSaveAndNew'] == 'true')
        {
            $return_action = "EditView";    
            $isDuplicate = "true";        
            $status = "";
        } 
		// if we create a new record "Save", we want to redirect to the DetailView
		else if($_REQUEST['action'] == "Save" 
			&& $_REQUEST['return_module'] != 'Activities'



			&& $_REQUEST['return_module'] != 'Home' 
			&& $_REQUEST['return_module'] != 'Forecasts' 
			&& $_REQUEST['return_module'] != 'Calendar'
			&& $_REQUEST['return_module'] != 'MailMerge'



			) 
			{
			    $return_action = 'DetailView';
			} elseif($_REQUEST['return_module'] == 'Activities' || $_REQUEST['return_module'] == 'Calendar') {
			$return_module = $_REQUEST['module'];
			$return_action = $_REQUEST['return_action']; 
			// wp: return action needs to be set for one-click close in task list
		} 
		else 
		{
			// if we "Cancel", we go back to the list view.
			$return_action = $_REQUEST['return_action'];
		}
	}
	else
	{
		$return_action = "DetailView";
	}
	
	if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "")
	{
		$return_id = $_REQUEST['return_id'];
	}
    
    if (!$isDuplicate)
    {
        header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&return_module=$return_module&return_action=$return_action");
    }
    else
    {
        header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&isDuplicate=true&return_module=$return_module&return_action=$return_action&status=$status");
    }
	exit;
}

function getLikeForEachWord($fieldname, $value, $minsize=4)
{
	$value = trim($value);
	$values = split(' ',$value);
	$ret = '';
	foreach($values as $val)
	{
		if(strlen($val) >= $minsize)
		{
			if(!empty($ret))
			{
				$ret .= ' or';
			}
			$ret .= ' '. $fieldname . ' LIKE %'.$val.'%';
		}

	}


}


?>
