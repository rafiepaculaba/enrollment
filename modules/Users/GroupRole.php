<?php
/**
 *
 * Filename: UserGroup.php
 * Date: 	 August 15, 2007
 * 
 * Author: 	 Erwin Dacua
 * 
 */

require_once('include/blumango/classes/database/Database.php');

/**
 * Class: Student
 * Description: This class is a model of the object - student
 * 				Implementing the active record pattern of database record
 */

class GroupRole extends Database 
{
	
	var $grID;
	var $groupID;
	var $roleID;
	var $status;
	
	/**
	 * GroupRole() constructor of the Student class
	 *
	 * @return Student
	 */
	function GroupRole($id='') 
	{
	    // calling the parent class
	    parent::Database();
	    
	    // set active record if found
		if ($id) {
			$this->groupID = $id;
			$this->retrieveUserGroup();
		}
	}
	
    /**
     * create_record() method to save the student record
     *
     * @return bool - return true if successful otherwise false
     */
	function addGroupRole() 
	{
	    // setting values to fields
		$info['groupID']   = $this->groupID;
		$info['roleID']    = $this->roleID;
		
		// building an insert query
        $this->tables = "user_group_roles";
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
	
	
	/**
	 * retrieveGroupRole() method to retrieve the student record and assign to the student attributes
	 *
	 */
	function retrieveGroupRole($lock='0')
	{
	    // setting conditions
	    $conds[]['grID'] = " = ".$this->grID;
	    
	    // building an insert query
	    $this->tables = "user_group_roles";
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
            		$this->grID    = $data[0]['grID'];
            		$this->groupID = $data[0]['groupID'];
            		$this->roleID  = $data[0]['roleID'];
            		$this->status  = $data[0]['status'];
            		
            		return true;
            	} else {
            	    // just to make sure that there's no values set to the attributes
            		$this->groupID = "";
            		$this->roleID  = "";
            		$this->status  = "";
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
	 * update_record() method to update the student record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateGroupRole()
	{
	    // setting values to fields
	    $info['groupID']  = $this->groupID;
		$info['roleID']   = $this->roleID;
		$info['status']   = $this->status;
		
		// setting conditions
		$conds[]['grID']  = " = ".$this->grID;
		
		// building an insert query
        $this->tables = "user_group_roles";
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
	 * delete_record() method to delete the student record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteGroupRole()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['grID'] = " = ".$this->grID;
	    
	    // building an insert query
	    $this->tables = "user_group_roles";
	    $this->conds  = $conds;

	    // building an select query
	    $query = $this->Delete();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
	    
	    // check if building query is successful
		if ( empty($this->errs) ) {
    	    try { 
    		    $this->db->beginTransaction();
        		$this->db->exec($query);
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
	 * retrieveAllGroupRoles() method to retrieve all/selected student records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllGroupRoles($where='',$orderby='ar.name', $sorting='ASC', $offset=0, $limit='')
	{
        $tables[] = "user_group_roles ugr";
        $tables[] = "acl_roles ar";
        
        $flds['ar.name']        = "";
        $flds['ar.description'] = "";
        $flds['ugr.*']          = "";
        
		// building an insert query
	    $this->tables = $tables;
	    $this->fields = $flds;
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
    		return $records;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	/**
	 * retrieveAllGroupRoles() method to retrieve all/selected student records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllRoles($where='',$orderby='name', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "acl_roles";
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
    		return $records;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	/**
	 * isExist() - function to check the role is already exist
	 *
	 * @param string $roleID
	 * @return bool 
	 */
	function isExist($roleID, $groupID)
	{
	    if ($roleID && $groupID) {
    	    // setting conditions
    	    $conds[]['roleID'] = " = '$roleID' AND ";
    	    $conds[]['groupID'] = " = '$groupID' AND ";
    	    $conds[]['status'] = " = 1";
    	    
    	    // building an insert query
    	    $this->tables = "user_group_roles";
    	    $this->conds  = $conds;
    
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
                        // return true - the roleID is already exist            		
                		return true;
                	} else {
                	    // return false - the roleID does not exist
                	    return false;
                	}   		
        	    } catch(PDOException $e) {
        	        echo $e;
        	        return false;
        	    }
    	    } else {
    		    $this->displayErrors();
    		    return false;
    		}
	    } else {
	        return false;
	    }
	    
	}
	
}
?>