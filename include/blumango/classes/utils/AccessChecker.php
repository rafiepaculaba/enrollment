<?php
/**
 * class: AccessChecker
 * description: This is a role access checker class
 * date created: 12/20/2007
 * created by: BluMango Dev Team
 */

require_once('config.php');
require_once('include/blumango/classes/database/QBuilder.php');
require_once('include/blumango/classes/database/Database.php');

/**
 * required classes: Database.php
 */
class AccessChecker extends Database
{
    /**
     * Constructor
     */
    function __construct() 
    {
        // calling the parent class
	    parent::Database();
    }
    
    /**
     * function: checkAccess - method that will check the access code if the current user has an access to this code
     *                       - checking in the database
     *
     * @param string $userid
     * @param string $accesscode
     * @return int(-1) missing required fields
     * @return int(0) no access
     * @return int(1) has access
     */	
    function check_access($userid, $accesscode, $is_admin=0)
    {
        global $current_user;
    
        if ($current_user->is_admin) {
            return 1;
        } else if ($is_admin) {
            return 1;
        } else if ($userid && $accesscode) {
    		$conds[0]['user_id'] = " = '$userid' AND ";
    		$conds[0]['role_id'] = " = '$accesscode' AND";	
    		$conds[0]['deleted'] = " = 0";
    		
    		$fields['id'] = '';
    		
    		$this->tables  = 'acl_roles_users';
    		$this->fields = $fields;
    		$this->conds  = $conds;
    		
    		$query = $this->Select();
    		$this->reset();
    		
    		try {
    			$this->db->beginTransaction();
        		$result = $this->db->query($query);
        		$data   = $result->fetchAll(PDO::FETCH_BOTH);
        		$this->db->commit();
        		if ($data[0]) {
            		return 1;
            	}    		
    	    } catch(PDOException $e) {
    	        echo $e;
    	        return 0;
    	    }
    		
    	} else {
    		return 0;
    	}
    }
    
    
    /** 
     * function: getAccessCode - method that will get the role id of the specified role name
     *
     * @param string $roleName
     * @return string id
     */
    function getAccessCode($roleName)
    {
    	if ($roleName) {
    	    
    		$conds[0]['name'] = " like '$roleName' AND";	
    		$conds[0]['deleted'] = " = 0";
    		
    		$fields['id'] = '';
    		
    		$this->tables  = 'acl_roles';
    		$this->fields = $fields;
    		$this->conds  = $conds;

    		$query= $this->Select();
    		
    		try {
    			$this->db->beginTransaction();
        		$result = $this->db->query($query);
        		$data   = $result->fetchAll(PDO::FETCH_BOTH);
        		$this->db->commit();
        		if ($data[0]) {
            		return $data[0]['id'];
            	}    		
    	    } catch(PDOException $e) {
    	        echo $e;
    	        return false;
    	    }
    			
    	} else {
    		return -1;
    	}
    }
    
    function retrieveAllUserRoles($where='',$orderby='name', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="acl_roles ar";
		$tables[]="acl_roles_users aru";
		
		$fields['ar.id']="";
		$fields['ar.name']="";
				
	    $this->tables = $tables;
	    $this->fields = $fields;
	    $this->conds  = $where;
	    $this->order  = $orderby;
	    $this->groupby= "aru.role_id";
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
	    
		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
    		return $records;
		} catch (PDOException $e) {
		    echo "    SQL query error.";
		    return false;
		}
	}
    
    /**
     * function: permitAccess - method that will check if the user will has an access to the resource (in session)
     *
     * @param string $accesscode
     * @return boolean
     */
    function permitAccess($accesscode)
    {
        if ($accesscode) {
            if (!empty($_SESSION['ACCESS'])) {
                return in_array($accesscode,$_SESSION['ACCESS']);
            }
        }
        // no access to the resource
        return false;
    }
	
}


?>