<?php
/**
 * Edited
 * Filename: RecordLogHS.php
 * Date: 	 march 12, 2008
 * 
 * Author: 	 Rafie D. Paculaba
 * 
 */

/**
 * Class: RecordLog
 * Description: This class is a model of the object - RecordLog
 * 				Implementing the active record pattern of database record
 */

class RecordLog extends Database 
{	
	var $logID;
	var $docType;
	var $recID;
	var $logDate;
	var $operation;
	var $fields;
	var $user_id;
	
	/**
	 *Master_table_audit_logs() constructor of the Master_table_audit_logs class
	 *
	 * @return Master_table_audit_logs
	 */
	function RecordLog($id='') 
	{
	    // calling the parent class
	    parent::Database(2); // High school level
	    
	    // set active record if found
		if ($id) {
			$this->logID = $id;
			$this->retrievemaster_table_audit_logs();
		}
	}
	
	
	
    /**
     * createmaster_table_audit_logs() method to save the master_table_audit_logs record
     *
     * @return bool - return true if successful otherwise false
     */
	function createRecordLog() 
	{
	    // setting values to fields
        $info['docType']      		= $this->docType;
        $info['recID']  			= $this->recID;
        $info['logDate']  			= $this->logDate;
        $info['operation']  		= $this->operation;
        $info['fields']  			= $this->fields;
        $info['user_id']  			= $this->user_id;
		
		// building an insert query
        $this->tables = "master_table_audit_logs";
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
     * create Payment Record logs() method to save the payment table log record
     *
     * @return bool - return true if successful otherwise false
     */
	function createRecordPaymentLog() 
	{
	    // setting values to fields
        $info['docType']      		= $this->docType;
        $info['recID']  			= $this->recID;
        $info['logDate']  			= $this->logDate;
        $info['operation']  		= $this->operation;
        $info['fields']  			= $this->fields;
        $info['user_id']  			= $this->user_id;
		
		// building an insert query
        $this->tables = "payment_table_logs";
		$this->fields = $info;
		
		$query = $this->Insert();     // generate insert sql query
		$this->reset();            	   // reset all variables in query generator
		
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
	 * retrievemaster_table_audit_logs() method to retrieve the Config record and assign to the master_table_audit_logs attributes
	 *
	 */
	function retrieveRecordLog($lock='0')
	{
	    // setting conditions
	    $conds[0]['logID'] = " = ".$this->logID;

	    // building an insert query
	    $this->tables = "master_table_audit_logs";
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
            		$this->docType       	= $data[0]['docType'];
            		$this->recID       		= $data[0]['recID'];
            		$this->logDate       	= $data[0]['logDate'];
            		$this->operation       	= $data[0]['operation'];
            		$this->fields       	= $data[0]['fields'];
            		$this->user_id       	= $data[0]['user_id'];
            		
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
	 * updateMaster_table_audit_logs() method to update the Master_table_audit_logs record with the active logID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateRecordLog()
	{
	    // setting values to fields
        $info['docType']       	= $this->docType;
        $info['recID']       	= $this->recID;
        $info['logDate']       	= $this->logDate;
        $info['operation']      = $this->operation;
        $info['fields']       	= $this->fields;
        $info['user_id']       	= $this->user_id;
		
		// setting conditions
		$conds[]['logID']  = " = '".$this->logID."'";
		
		// building an insert query
        $this->tables = "master_table_audit_logs";
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
	 * deleteMaster_table_audit_logs() method to delete the master_table_audit_logs record  witht the active logID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteRecordLog()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['logID'] = " = '".$this->logID."'";
	    
	    // building an insert query
	    $this->tables = "master_table_audit_logs";
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
	 * retrieveAllMaster_table_audit_logs() method to retrieve all/selected master_table_audit_logs records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllRecordLogs($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "master_table_audit_logs";
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
	
	function retrieveAllRecordPaymentLogs($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "payment_table_logs";
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