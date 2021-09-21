<?php
/**
 *
 * Filename: Refund.php
 * Date: 	 February 27, 2008
 * 
 * Author: 	 Rafie D. Paculaba
 * 
 */

/**
 * Class: Refund
 * Description: This class is a model of the object - Refund
 * 				Implementing the active record pattern of database record
 */

class Refund extends Database 
{
	
	var $refundID;
	var $accID;
	var $idno;
	var $studName;
	
	var $schYear;
	var $date;
	var $amount;
	var $preparedBy;
	var $rStatus;

	/**
	 * Refund() constructor of the Refund class
	 *
	 * @return Refund
	 */
	function Refund($id='') 
	{
	    // calling the parent class
	    parent::Database(1); // Elementary level

	    // set active record if found
		if ($id) {
			$this->refundID = $id;
			$this->retrieveRefund();
		}
	}
	
	
    /**
     * createRefund() method to save the Refund record
     *
     * @return bool - return true if successful otherwise false
     */
	function createRefund() 
	{
	    // setting values to fields
        $info['accID']    			= $this->accID;
        $info['schYear']    		= $this->schYear;
        $info['idno']    			= $this->idno;
        $info['date']   			= $this->date;
        $info['amount']    			= $this->amount;
        
		// building an insert query
        $this->tables = "refunds";
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
	 * retrieveRefund() method to retrieve the Refund record and assign to the registrant attributes
	 *
	 */
	function retrieveRefund($lock='0')
	{
	    // setting conditions
	    $conds[0]['refundID'] = " = ".$this->refundID;
	    
	    // building an insert query
	    $this->tables = "refunds";
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
                    $this->refundID 		= $data[0]['refundID'];
                    $this->accID   			= $data[0]['accID'];
                    $this->idno   			= $data[0]['idno'];
                    
                    $stud = new Student($data[0] ['idno']);
                    $this->studName = 		$stud->lname.", ".$stud->fname." ".$stud->mname;
                    
                    $this->schYear     	 	= $data[0]['schYear'];
                    $this->date       		= $data[0]['date'];
                    $this->amount   		= $data[0]['amount'];
                    $this->preparedBy    	= $data[0]['preparedBy'];
                    $this->rstatus      	= $data[0]['rstatus'];
            		
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
	 * updateRefund() method to update the Refund record with the active refundID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateRefund()
	{
	    // setting values to fields
        $info['accID']    		= $this->accID;
        $info['idno']    		= $this->idno;
        $info['schYear']        = $this->schYear;
        $info['date']    		= $this->date;
        $info['amount']    		= $this->amount;
        $info['preparedBy']     = $this->preparedBy;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['refundID']  = " = ".$this->refundID;
		
		// building an update query
        $this->tables = "refunds";
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
	 * cancelRefund() method to cancel the Refund record with the active refundID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function cancelRefund()
	{
	    // setting values to fields
        $info['accID']    		= $this->accID;
        $info['idno']    		= $this->idno;
        $info['schYear']        = $this->schYear;
        $info['date']    		= $this->date;
        $info['amount']    		= $this->amount;
        $info['preparedBy']     = $this->preparedBy;
        $info['rstatus']        = 0;
		
		// setting conditions
		$conds[]['refundID']  = " = ".$this->refundID;
		
		// building an update query
        $this->tables = "refunds";
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
	 * deleteRefund() method to delete the Refund record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteRefund()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['refundID'] = " = ".$this->refundID;
	    
	    // building an delete query
	    $this->tables = "refunds";
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
	 * retrieveAllRefunds() method to retrieve all/selected Refund records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllRefunds($where='',$orderby='', $sorting='', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "refunds";
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
	 * retrieveAllStudentRefunds() method to retrieve all/selected Refunds records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllStudentRefunds($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="refunds";
		$tables[]="students";
		
		$multiOrder['refunds.schYear'] = "DESC";
		$multiOrder['students.lname'] 	= "ASC";
		$multiOrder['students.fname'] 	= "ASC";
		$multiOrder['students.mname'] 	= "ASC";
		
		if (count($where[0]) && $where) {
		    $where[0]['AND refunds.idno'] = "= students.idno ";
		} else {
		    $where[0][' refunds.idno'] = "= students.idno ";
		}
		
		$flds['refunds.*']  = "";
		$flds['students.lname'] = "";
		$flds['students.fname'] = "";
		$flds['students.mname'] = "";
		
		$this->multi_orders = $multiOrder;
	    $this->tables = $tables;
	    $this->fields = $flds;
	    $this->conds  = $where;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
		
	    // set association
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
	 * countAllStudentRefunds() method to retrieve all/selected Refunds records
	 *
	 * @param array $where
	 * @param int $offset
	 * @param int $limit
	 * @return int ttl_record
	 */
	function countAllStudentRefunds($where='', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="refunds";
		$tables[]="students";
		
		if (count($where[0]) && $where) {
		    $where[0]['AND refunds.idno'] = "= students.idno ";
		} else {
		    $where[0][' refunds.idno'] = "= students.idno ";
		}
		
		$flds['count(refunds.refundID) as ttl_record']  = "";		
		
	    $this->tables = $tables;
	    $this->fields = $flds;
	    $this->conds  = $where;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
		
	    // set association
		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
			if ($records) {
    		    return $records[0]['ttl_record'];
    		}
    		
    		return $records;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}

	/**
	 * getLastID() method to retrieve last entered ID
	 *
	 * @return ID
	 */
	function getLastID() 
	{
		$where[0]['idno'] ="= '".$this->idno."' AND ";
		$where[0]['accID'] ="= '".$this->accID."' AND ";
		$where[0]['schYear'] ="= '".$this->schYear."' AND ";
	    $where[0]['rstatus'] = "= '1'";
	    
	    $result = $this->retrieveAllRefunds($where,'refundID','DESC',0,1);
	    return $result[0]['refundID'];
	}

	/**
	 * isExist() - function to check the refundID is already exist
	 *
	 * @param string $refundID
	 * @return bool 
	 */
	function isExist($refundID)
	{
	    if ($refundID) {
    	    // setting conditions
    	    $conds[]['refundID'] = " = '$refundID' ";
    	    
    	    // building an insert query
    	    $this->tables = "refunds";
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
                        // return true - record is already exist            		
                		return true;
                	} else {
                	    // return false - record does not exist
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