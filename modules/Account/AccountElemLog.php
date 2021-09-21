<?php
/**
 * Edited
 * Filename: AccountElemLog.php
 * Date: 	 Feb 13, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: AccountLog
 * Description: This class is a model of the object - AccountLog
 * 				Implementing the active record pattern of database record
 */

class AccountLog extends Database 
{
	
	var $logID;
	var $operation;
	var $recID;
	var $logDate;
	var $changes;
	var $changeBy;
	var $changeByName;
	
	/**
	 *AccountLog() constructor of the AccountLog class
	 *
	 * @return AccountLog
	 */
	function AccountLog($id='') 
	{
	    // calling the parent class
	    parent::Database(1); // elem level
	    
	    // set active record if found
		if ($id) {
			$this->logID = $id;
			$this->retrieveAccountLog();
		}
	}
	
	
	
    /**
     * createAccountLog() method to save the AccountLog record
     *
     * @return bool - return true if successful otherwise false
     */
	function createAccountLog() 
	{
	    // setting values to fields
        $info['operation']     = $this->operation;
        $info['recID']     = $this->recID;
        $info['logDate']  = date("Y-m-d H:i:s",time());
        $info['changes'] = $this->changes;
        $info['changeBy'] = $this->changeBy;
		
		// building an insert query
        $this->tables = "account_table_logs";
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
	 * retrieveAccountLog() method to retrieve the AccountLog record and assign to the AccountLog attributes
	 *
	 */
	function retrieveAccountLog($lock='0')
	{
	    // setting conditions
	    $conds[0]['logID'] = " = ".$this->logID;

	    // building an insert query
	    $this->tables = "account_table_logs";
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
                    $this->operation  	= $data[0]['operation'];
                    $this->recID  	= $data[0]['recID'];
                    $this->changes = $data[0]['changes'];
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
	 * updateAccountLog() method to update the AccountLog record with the active deptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateAccountLog()
	{
	    // setting values to fields
        $info['recID']     = $this->recID;
        $info['changes'] = $this->changes;
		
		// setting conditions
		$conds[]['logID']  = " = '".$this->logID."'";
		
		// building an insert query
        $this->tables = "account_table_logs";
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
	 * deleteAccountLog() method to delete the AccountLog record  witht the active DeptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteAccountLog()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['logID'] = " = '".$this->logID."'";
	    
	    // building an insert query
	    $this->tables = "account_table_logs";
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
	 * retrieveAllAccountLogs() method to retrieve all/selected AccountLog records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllAccountLogs($where='',$orderby='logID', $sorting='DESC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "account_table_logs";
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