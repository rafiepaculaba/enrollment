<?php
/**
 * Edited
 * Filename: EnrollmentPreschoolLog.php
 * Date: 	 Feb 13, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: EnrollmentColLog
 * Description: This class is a model of the object - EnrollmentColLog
 * 				Implementing the active record pattern of database record
 */

class EnrollmentLog extends Database 
{
	
	var $logID;
	var $docType;
	var $enID;
	var $logDate;
	var $subjects;
	var $changeBy;
	var $changeByName;
	
	/**
	 *EnrollmentColLog() constructor of the EnrollmentColLog class
	 *
	 * @return EnrollmentLog
	 */
	function EnrollmentLog($id='') 
	{
	    // calling the parent class
	    parent::Database(4); // Preschool level
	    
	    // set active record if found
		if ($id) {
			$this->logID = $id;
			$this->retrieveEnrollmentLog();
		}
	}
	
	
	
    /**
     * createEnrollmentLog() method to save the EnrollmentColLog record
     *
     * @return bool - return true if successful otherwise false
     */
	function createEnrollmentLog() 
	{
	    // setting values to fields
        $info['docType']  = $this->docType;
        $info['enID']     = $this->enID;
        $info['logDate']  = date("Y-m-d H:i:s",time());
        $info['subjects'] = $this->subjects;
        $info['changeBy'] = $this->changeBy;
		
		// building an insert query
        $this->tables = "enrollment_table_logs";
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
	 * retrieveEnrollmentLog() method to retrieve the EnrollmentColLog record and assign to the EnrollmentColLog attributes
	 *
	 */
	function retrieveEnrollmentLog($lock='0')
	{
	    // setting conditions
	    $conds[0]['logID'] = " = ".$this->logID;

	    // building an insert query
	    $this->tables = "enrollment_table_logs";
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
            		$this->docType  = $data[0]['docType'];
                    $this->enID  	= $data[0]['enID'];
                    $this->subjects = $data[0]['subjects'];
                    $this->logDate  = date("m/d/Y h:i A",strtotime($data[0]['logDate']));
                    $this->changeBy = $data[0]['changeBy'];
                    
                    $u = new User2($this->changeBy);
            		$this->changeByName = htmlentities($u->last_name)." , ".htmlentities($u->first_name);
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
	 * updateEnrollmentLog() method to update the EnrollmentColLog record with the active deptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateEnrollmentLog()
	{
	    // setting values to fields
        $info['docType']  = $this->docType;
        $info['enID']     = $this->enID;
        $info['subjects'] = $this->subjects;
		
		// setting conditions
		$conds[]['logID']  = " = '".$this->logID."'";
		
		// building an insert query
        $this->tables = "enrollment_table_logs";
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
	 * deleteEnrollmentColLog() method to delete the EnrollmentColLog record  witht the active DeptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteEnrollmentLog()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['logID'] = " = '".$this->logID."'";
	    
	    // building an insert query
	    $this->tables = "enrollment_table_logs";
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
	 * retrieveAllEnrollmentLogs() method to retrieve all/selected EnrollmentColLog records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllEnrollmentLogs($where='',$orderby='logID', $sorting='DESC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "enrollment_table_logs";
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
	
	
}
?>