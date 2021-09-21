<?php
/**
 * Edited
 * Filename: Department.php
 * Date: 	 January 30, 2008
 * 
 * Author: 	 Rafie Paculaba
 * 
 */

/**
 * Class: Department
 * Description: This class is a model of the object - department
 * 				Implementing the active record pattern of database record
 */

class Department extends Database 
{
	
	var $deptID;
	var $deptCode;
	var $deptName;
	var $deptChairman;
	var $remarks;
	var $rstatus;
	
	/**
	 *Department() constructor of the department class
	 *
	 * @return Department
	 */
	function Department($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->deptID = $id;
			$this->retrieveDepartment();
		}
	}
	
    /**
     * createDepartment() method to save the department record
     *
     * @return bool - return true if successful otherwise false
     */
	function createDepartment() 
	{
	    // setting values to fields
        $info['deptCode']       = $this->deptCode;
        $info['deptName']      	= $this->deptName;
        $info['deptChairman']   = $this->deptChairman;
        $info['remarks']     	= $this->remarks;

		
		// building an insert query
        $this->tables = "departments";
		$this->fields = $info;
		
		$query = $this->Insert();     // generate insert sql query
		//$query = $this->quote($query);
		$this->reset();               // reset all variables in query generator
		
		// check if building query is successful
		if ( empty($this->errs) ) {
    	    try { 
    		    $this->db->beginTransaction();
    		    $this->db->exec($query);
    	        $this->db->commit();
    	        
    	        // assign the newly saved id
    	        $this->deptID = $this->db->lastInsertId();
    	        $this->retrieveDepartment($this->db->lastInsertId());

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
	 * retrieveDepartment() method to retrieve the department record and assign to the department attributes
	 *
	 */
	function retrieveDepartment($lock='0')
	{
	    // setting conditions
	    $conds[0]['deptID'] = " = ".$this->deptID;

	    // building an insert query
	    $this->tables = "departments";
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
            		$this->deptID       = $data[0]['deptID'];
                    $this->deptCode     = $data[0]['deptCode'];
                    $this->deptName     = $data[0]['deptName'];
                    $this->deptChairman = $data[0]['deptChairman'];
                    $this->remarks      = $data[0]['remarks'];
                    $this->rstatus      = $data[0]['rstatus'];
            		
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
	 * updateDepartment() method to update the department record with the active deptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateDepartment()
	{
	    // setting values to fields
        $info['deptID']			= $this->deptID;
        $info['deptCode']    	= $this->deptCode;
        $info['deptName']     	= $this->deptName;
        $info['deptChairman']   = $this->deptChairman;
        $info['remarks']      	= $this->remarks;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['deptID']  = " = '".$this->deptID."'";
		
		// building an insert query
        $this->tables = "departments";
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
	 * deleteDepartment() method to delete the department record  witht the active DeptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteDepartment()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['deptID'] = " = '".$this->deptID."'";
	    
	    // building an insert query
	    $this->tables = "departments";
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
	 * retrieveAllDepartments() method to retrieve all/selected department records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllDepartments($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "departments";
	    $this->conds  = $where;
	    $this->order  = $orderby;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    //$query = $this->quote($query);
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
	 * getLastID() method to retrieve last insertet deptID
	 *
	 * @return deptID
	 */
	
	function getLastID() 
	{
	    $where[0]['deptCode'] = "= '".$this->deptCode."' AND ";
	    $where[0]['deptName'] = "= '".$this->deptName."'";
	    
	    $result = $this->retrieveAllDepartments($where,'deptID','DESC',0,1);
	    return $result[0]['deptID'];
	}	
	/**
	 * isExist() - function to check the department deptID is already exist
	 *
	 * @param number $deptID
	 * @return bool 
	 */
	function isExist($deptCode)
	{
	    if ($deptCode) {
    	    // setting conditions
    	    $conds[0]['deptCode'] = " = '".htmlentities($deptCode)."' AND ";
    	    $conds[0]['rstatus'] = " = 1";

    	    // building an insert query
    	    $this->tables = "departments";
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
                        // return true - the deptID is already exist            		
                		return 1;
                	} else {
                	    // return false - the deptID does not exist
                	    return -1;
                	}   		
        	    } catch(PDOException $e) {
        	        echo $e;
        	        return -1;
        	    }
    	    } else {
    		    $this->displayErrors();
    		    return -1;
    		}
	    } else {
	        return -1;
	    }
	    
	}
	
}
?>