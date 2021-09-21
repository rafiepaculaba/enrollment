<?php
/**
 *
 * Filename: User.php
 * Date: 	 February 2, 2007
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: User
 * Description: This class is a model of the object - User
 * 				Implementing the active record pattern of database record
 */

class User2 extends Database 
{
	
	var $id;
	var $user_name;
	var $user_hash; 
	var $sugar_login;
	var $first_name;
	var $last_name;
	var $is_admin;
	var $title;
    var $department;
    var $deleted;
    var $employee_status;
    var $groupID;
	
	/**
	 * User() constructor of the User class
	 *
	 * @return User
	 */
	function User2($id='') 
	{
	    // calling the parent class
	    parent::Database(0); // framework

	    // set active record if found
		if ($id) {
			$this->id = $id;
			$this->retrieveUser();
		}
	}
	
	
	/**
	 * retrieveUser() method to retrieve the User record and assign to the registrant attributes
	 *
	 */
	function retrieveUser($lock='0')
	{
	    // setting conditions
	    $conds[0]['id'] = " = '".$this->id."'";
	    
	    // building an insert query
	    $this->tables = "users";
	    $this->conds  = $conds;
	    $this->lock   = $lock;

	    // building an select query
	    $query = $this->Select();  // generate select sql query
	    $this->reset();            // reset all variables in query generator
		
	    // check if building query is successful
		if ( empty($this->errs) ) {
    	    try {
    	        $this->db->beginTransaction();
        		$result = $this->db->query($query);
        		$data   = $result->fetchAll(PDO::FETCH_BOTH);
        		$this->db->commit();
        		
        		if ($data[0]) {
                    $this->id          = $data[0]['id'];
                	$this->user_name   = $data[0]['user_name'];
                	$this->user_hash   = $data[0]['user_hash']; 
                	$this->sugar_login = $data[0]['sugar_login'];
                	$this->first_name  = $data[0]['first_name'];
                	$this->last_name   = $data[0]['last_name'];
                	$this->is_admin    = $data[0]['is_admin'];
                	$this->title       = $data[0]['title'];
                    $this->department  = $data[0]['department'];
                    $this->deleted     = $data[0]['deleted'];
                    $this->employee_status = $data[0]['employee_status'];
                    $this->groupID     = $data[0]['groupID'];
            		
            		return true;
            	}    		
    	    } catch(PDOException $e) {
    	        echo $e;
    	        return false;
    	    }
	    } else {
		    $this->displayErrors();
		    return false;
		}
	}
	
	
	/**
	 * updateUser() method to update the User record with the active UserID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateUser()
	{
	    // setting values to fields
        $info['user_name']   = $this->user_name;
    	$info['user_hash']   = $this->user_hash; 
    	$info['sugar_login'] = $this->sugar_login;
    	$info['first_name']  = $this->first_name;
    	$info['last_name']   = $this->last_name;
    	$info['is_admin']    = $this->is_admin;
    	$info['title']       = $this->title;
        $info['department']  = $this->department;
        $info['deleted']     = $this->deleted ;
        $info['employee_status'] = $this->employee_status;
        $info['groupID']     = $this->groupID;
		
		// setting conditions
		$conds[]['id']  = " = '".$this->id."'";
		
		// building an update query
        $this->tables = "users";
		$this->fields = $info;
		$this->conds  = $conds;
		
		// building an select query
	    $query = $this->Update();  // generate update sql query
	    $this->reset();            // reset all variables in query generator
		
	    // check if building query is successful
		if ( empty($this->errs) ) {
    	    try { 
    	        $this->db->beginTransaction();
        		$successful = $this->db->exec($query);
        		$this->db->commit();
                return true;
            } catch(PDOException $e){
               $this->db->rollBack();
               return false;
            }
        } else {
		    $this->displayErrors();
		    return false;
		}
	}
	
	
	/**
	 * retrieveAllUsers() method to retrieve all/selected User records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllUsers($where='',$orderby='last_name', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "users";
	    $this->conds  = $where;
	    $this->order  = $orderby;
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
    		
    		if ($records) {
    		    $data=array();
    		    $ctr=0;
    		    foreach ($records as $row) {
    		        $data[$ctr]=$row;
    		        $data[$ctr]['first_name'] = htmlentities($row['first_name']);
    		        $data[$ctr]['last_name']  = htmlentities($row['last_name']);
    		        $ctr++;
    		    }
    		}
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	function addUserRole($id, $role_id, $user_id)
	{
	    if ($id && $role_id && $user_id) {
    	    // setting values to fields
    	    $info['id']      = $id;
    		$info['role_id'] = $role_id;
    		$info['user_id'] = $user_id;
    		
    		// building an insert query
            $this->tables = "acl_roles_users";
    		$this->fields = $info;
    		
    		$query = $this->Insert();     // generate insert sql query
    		$this->reset();               // reset all variables in query generator
    		
    		// check if building query is successful
    		if ( empty($this->errs) ) {
        	    try { 
        		    $this->db->beginTransaction();
        		    $this->db->exec($query);
        	        $this->db->commit();
                    return true;
                } catch(PDOException $e){
                    echo $e;
                   $this->db->rollBack();
                   return false;
                }
       		} else {
        	    $this->displayErrors();    
        	    return false;
        	}
	    }
	}
	
	
}
?>