<?php
/**
 *
 * Filename: Payment.php
 * Date: 	 February 6, 2007
 * 
 * Author: 	 Rafie D. Paculaba
 * 
 */

/**
 * Class: Payment
 * Description: This class is a model of the object - Payment
 * 				Implementing the active record pattern of database record
 */

class Payment extends Database 
{
	
	var $paymentID;
	var $accID;
	var $schYear;
	
	var $idno;
	var $ORno;
	var $studName;
	var $date;

	var $paymentTypeID;
	var $paymentName;
	var $term;

	var $amount;
	var $encodedBy;
	var $rStatus;

	/**
	 * Payment() constructor of the Payment class
	 *
	 * @return Payment
	 */
	function Payment($id='') 
	{
	    // calling the parent class
	    parent::Database(1); // elementary level

	    // set active record if found
		if ($id) {
			$this->paymentID = $id;
			$this->retrievePayment();
		}
	}
	
	
    /**
     * createPayment() method to save the Payment record
     *
     * @return bool - return true if successful otherwise false
     */
	function createPayment() 
	{
	    // setting values to fields
        $info['accID']    			= $this->accID;
        $info['schYear']    		= $this->schYear;
        $info['idno']    			= $this->idno;
        $info['ORno']    			= $this->ORno;
        $info['date']   			= $this->date;
        $info['paymentTypeID']    	= $this->paymentTypeID;
        $info['term']    			= $this->term;
        $info['encodedBy']    		= $this->encodedBy;
        $info['amount']    			= $this->amount;
        
		// building an insert query
        $this->tables = "payments";
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
	 * retrievePayment() method to retrieve the Payment record and assign to the registrant attributes
	 *
	 */
	function retrievePayment($lock='0')
	{
	    // setting conditions
	    $conds[0]['paymentID'] = " = ".$this->paymentID;
	    
	    // building an insert query
	    $this->tables = "payments";
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
                    $this->paymentID 		= $data[0]['paymentID'];
                    $this->accID   			= $data[0]['accID'];
                    $this->schYear     	 	= $data[0]['schYear'];
                    $this->idno   			= $data[0]['idno'];
                    $this->ORno   			= $data[0]['ORno'];

                    $stud 					= new Student($data[0]['idno']);
                    $this->studName 		= htmlentities($stud->lname).", " .htmlentities($stud->fname). " " .htmlentities($stud->mname);
                    
                    $this->date       		= $data[0]['date'];
					$this->paymentTypeID   	= $data[0]['paymentTypeID'];

                    $paymentType = new PaymentType($data[0]['paymentTypeID']);
                    $this->paymentName 		= $paymentType->paymentName;

					$this->term   			= $data[0]['term'];
                    $this->amount   		= $data[0]['amount'];
                    $this->encodedBy    	= $data[0]['encodedBy'];
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
	 * retrieveAllStudentPayments() method to retrieve all/selected Payment records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllStudentPayments($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="payments";
		$tables[]="students";
		
		$multiOrder['payments.schYear'] = "DESC";
		$multiOrder['students.lname'] 	= "ASC";
		$multiOrder['students.fname'] 	= "ASC";
		$multiOrder['students.mname'] 	= "ASC";
		
		if (count($where[0]) && $where) {
		    $where[0]['AND payments.idno'] = "= students.idno ";
		} else {
		    $where[0][' payments.idno'] = "= students.idno ";
		}
		
		$flds['payments.*']  = "";
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
	 * countAllStudentPayments() method to count all/selected Payment records
	 *
	 * @param array $where
	 * @param int $offset
	 * @param int $limit
	 * @return int ttl_record
	 */
	function countAllStudentPayments($where='', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="payments";
		$tables[]="students";
		
		if (count($where[0]) && $where) {
		    $where[0]['AND payments.idno'] = "= students.idno ";
		} else {
		    $where[0][' payments.idno'] = "= students.idno ";
		}
		
		$flds['count(payments.ORno) as ttl_record']  = "";		
		
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
	 * updatePayment() method to update the Payment record with the active PaymentID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updatePayment()
	{
	    // setting values to fields
        $info['accID']    		= $this->accID;
        $info['schYear']        = $this->schYear;
        $info['idno']        	= $this->idno;
        $info['ORno']        	= $this->ORno;
        $info['date']    		= $this->date;
        $info['paymentTypeID']  = $this->paymentTypeID;
        $info['term']    		= $this->term;
        $info['amount']    		= $this->amount;
        $info['encodedBy']      = $this->encodedBy;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['paymentID']  = " = ".$this->paymentID;
		
		// building an update query
        $this->tables = "payments";
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
	 * calcelPayment() method to cancel the Payment record with the active PaymentID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function cancelPayment()
	{
	    // setting values to fields
        $info['accID']    		= $this->accID;
        $info['schYear']        = $this->schYear;
        $info['idno']        	= $this->idno;
        $info['ORno']        	= $this->ORno;
        $info['date']    		= $this->date;
        $info['paymentTypeID']  = $this->paymentTypeID;
        $info['term']    		= $this->term;
        $info['amount']    		= $this->amount;
        $info['encodedBy']      = $this->encodedBy;
        $info['rstatus']        = 0;
		
		// setting conditions
		$conds[]['paymentID']  = " = ".$this->paymentID;
		
		// building an update query
        $this->tables = "payments";
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
	 * deletePayment() method to delete the Payment record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deletePayment()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['paymentID'] = " = ".$this->paymentID;
	    
	    // building an delete query
	    $this->tables = "payments";
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
	 * retrieveAllPayments() method to retrieve all/selected Payment records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllPayments($where='',$orderby='', $sorting='', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "payments";
	    $this->conds  = $where;
	    $this->order  = $orderby;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
		
	    $paymentType = new PaymentType();

	    try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
    		$data=array();
    		$ctr=0;
    		foreach ($records as $row) {

    			//PaymentType instance 	
    		    $paymentType->paymentTypeID = $row['paymentTypeID'];
    		    $paymentType->retrievePaymentType();
    		    
    		    $data[$ctr] = $row;
    		    $data[$ctr]['paymentName'] 	= $paymentType->paymentName;

    		    $ctr++;
    		}

    		return $data;
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
		$where[0]['schYear']	="= '".$this->schYear."' AND ";
		$where[0]['idno']		="= '".$this->idno."' AND ";
		$where[0]['ORno']		="= '".$this->ORno."' AND ";
		$where[0]['rstatus']	="= '1'";
	    
	    $result = $this->retrieveAllPayments($where,'paymentID','DESC',0,1);
	    return $result[0]['paymentID'];
	}

	/**
	 * isExist() - function to check the PaymentID is already exist
	 *
	 * @param string $paymentID
	 * @return bool 
	 */
	function isExist($paymentID)
	{
	    if ($paymentID) {
    	    // setting conditions
    	    $conds[]['paymentID'] = " = '$paymentID' ";
    	    
    	    // building an insert query
    	    $this->tables = "payments";
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