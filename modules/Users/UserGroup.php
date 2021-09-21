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

class UserGroup extends Database 
{
	
	var $groupID;
	var $name;
	var $desc;
	var $status;
	
	/**
	 * UserGroup() constructor of the Student class
	 *
	 * @return Student
	 */
	function UserGroup($id='') 
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
	function createUserGroup() 
	{
	    // setting values to fields
	    $info['name']        = $this->name;
		$info['description'] = $this->desc;
		
		// building an insert query
        $this->tables = "user_groups";
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
	 * retrieve_record() method to retrieve the student record and assign to the student attributes
	 *
	 */
	function retrieveUserGroup($lock='0')
	{
	    // setting conditions
	    $conds[]['groupID'] = " = ".$this->groupID;
	    
	    // building an insert query
	    $this->tables = "user_groups";
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
            		$this->groupID= $data[0]['groupID'];
            		$this->name	  = $data[0]['name'];
            		$this->desc	  = $data[0]['description'];
            		$this->status = $data[0]['status'];
            		
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
	 * update_record() method to update the student record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateUserGroup()
	{
	    // setting values to fields
	    $info['name']        = $this->name;
		$info['description'] = $this->desc;
		$info['status']      = $this->status;
		
		// setting conditions
		$conds[]['groupID']  = " = ".$this->groupID;
		
		// building an insert query
        $this->tables = "user_groups";
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
	function deleteUserGroup()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['groupID'] = " = ".$this->groupID;
	    
	    // building an insert query
	    $this->tables = "user_groups";
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
	 * retrieveAll() method to retrieve all/selected student records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllUserGroups($where='',$orderby='name', $sorting='ASC', $offset=0, $limit='')
	{
	    // setting conditions
//		if ($where) {
//			foreach ($where as $key=>$val) {
//				$conds[0][$key] = " = $val";
//			}
//		}
		

		// building an insert query
	    $this->tables = "user_groups";
	    $this->conds  = $conds;
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
	
	function multidb()
	{
	    $query = 'SELECT 
        management.students.*, 
        guardian.parents.* 
        FROM 
        management.students, guardian.parents 
        WHERE 
        management.students.rec_id = guardian.parents.sid 
        AND 
        management.students.rec_id = 1; ';
        	    
	    try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    echo $e;
		    return false;
		}
		
        echo "<pre>";
        var_dump($records);
        echo "</pre>";
	}
	
}
?>