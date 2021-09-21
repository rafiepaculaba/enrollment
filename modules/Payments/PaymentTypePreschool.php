<?php
/**
 *
 * Filename: PaymentType.php
 * Date: 	 June 27, 2007
 * 
 * Author: 	 Rafie D. Paculaba 
 * 
 */

/**
 * Class: PaymentType
 * Description: This class is a model of the object - PaymentType
 * 				Implementing the active record pattern of database record
 */

class PaymentType extends Database 
{
	
	var $paymentTypeID;
	var $paymentName;
	var $rstatus;
	
	/**
	 * PaymentType() constructor of the PaymentType class
	 *
	 * @return PaymentType
	 */
	function PaymentType($id='') 
	{
	    // calling the parent class
	    parent::Database(4); // Preschool level

	    // set active record if found
		if ($id) {
			$this->paymentTypeID = $id;
			$this->retrievePaymentType();
		}
	}
	
	
    /**
     * createPaymentType() method to save the PaymentType record
     *
     * @return bool - return true if successful otherwise false
     */
	function createPaymentType() 
	{
	    // setting values to fields
        $info['paymentName']    = $this->paymentName;
		
		// building an insert query
        $this->tables = "payment_types";
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
	 * retrievePaymentType() method to retrieve the PaymentType record and assign to the registrant attributes
	 *
	 */
	function retrievePaymentType($lock='0')
	{
	    // setting conditions
	    $conds[0]['paymentTypeID'] = " = ".$this->paymentTypeID;
	    
	    // building an insert query
	    $this->tables = "payment_types";
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
                    $this->paymentTypeID = $data[0]['paymentTypeID'];
                    $this->paymentName   = $data[0]['paymentName'];
                    $this->rstatus       = $data[0]['rstatus'];

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
	 * updatePaymentType() method to update the PaymentType record with the active PaymentTypeID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updatePaymentType()
	{
	    // setting values to fields
        $info['paymentName']    = $this->paymentName;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['paymentTypeID']  = " = ".$this->paymentTypeID;
		
		// building an update query
        $this->tables = "payment_types";
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
	 * deletePaymentType() method to delete the PaymentType record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deletePaymentType()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['paymentTypeID'] = " = ".$this->paymentTypeID;
	    
	    // building an delete query
	    $this->tables = "payment_types";
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
	 * retrieveAllPaymentTypes() method to retrieve all/selected PaymentType records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllPaymentTypes($where='',$orderby='paymentName', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "payment_types";
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
	 * getLastID() method to retrieve last entered ID
	 *
	 * @return ID
	 */
	function getLastID() 
	{
	    $where[0]['paymentName'] = "= '".$this->paymentName."' AND ";
	    $where[0]['rstatus'] = "= '1'";
	    
	    $result = $this->retrieveAllPaymentTypes($where,'paymentTypeID','DESC',0,1);
	    return $result[0]['paymentTypeID'];
	}

	/**
	 * isExist() - function to check the PaymentName is already exist
	 *
	 * @param string $paymentName
	 * @return bool 
	 */
	function isExist($paymentName)
	{
	    if ($paymentName) {
    	    // setting conditions
    	    $conds[]['paymentName'] = " = '$paymentName' ";
    	    
    	    // building an insert query
    	    $this->tables = "payment_types";
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
    		    return false;
    		}
	    } else {
	        return false;
	    }
	    
	}
	
}
?>