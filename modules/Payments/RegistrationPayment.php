<?php
/**
 *
 * Filename: Registration Payment.php
 * Date: 	 March 10, 2007
 * 
 * Author: 	 Rafie D. Paculaba
 * 
 */

/**
 * Class: Registration Payment
 * Description: This class is a model of the object - Registration Payment
 * 				Implementing the active record pattern of database record
 */

class RegistrationPayment extends Database 
{
	
	var $regPaymentID;
	var $schYear;
	var $semCode;
	var $idno;
	var $ORno;
	var $type;
	var $studName;
	var $date;
	var $amount;
	var $encodedBy;
	var $rstatus;

	/**
	 * RegistrationPayment() constructor of the RegistrationPayment class
	 *
	 * @return RegistrationPayment
	 */
	function RegistrationPayment($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level

	    // set active record if found
		if ($id) {
			$this->regPaymentID = $id;
			$this->retrieveRegistrationPayment();
		}
	}
	
	
    /**
     * createRegistrationPayment() method to save the RegistrationPayment record
     *
     * @return bool - return true if successful otherwise false
     */
	function createRegistrationPayment() 
	{
	    // setting values to fields
        $info['schYear']    		= $this->schYear;
        $info['semCode']    		= $this->semCode;
        $info['idno']    			= $this->idno;
        $info['ORno']    			= $this->ORno;
        $info['type']    			= $this->type;
        $info['date']   			= $this->date;
        $info['amount']    			= $this->amount;
        $info['encodedBy']    		= $this->encodedBy;
        
		// building an insert query
        $this->tables = "registration_payments";
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
	 * retrieveRegistrationPayment() method to retrieve the RegistrationPayment record and assign to the registrant attributes
	 *
	 */
	function retrieveRegistrationPayment($lock='0')
	{
	    // setting conditions
	    $conds[0]['regPaymentID'] = " = ".$this->regPaymentID;
	    
	    // building an insert query
	    $this->tables = "registration_payments";
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
                    $this->semCode 			= $data[0]['semCode'];
                    $this->idno   			= $data[0]['idno'];
                    $this->ORno   			= $data[0]['ORno'];
                    $this->type   			= $data[0]['type'];

                    $stud 					= new Student($data[0]['idno']);
                    $this->studName 		= $stud->lname.", " . $stud->fname . " " .$stud->mname;
                    
                    $this->date       		= $data[0]['date'];
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
	 * updatePayment() method to update the Payment record with the active PaymentID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateRegistrationPayment()
	{
	    // setting values to fields
        $info['schYear']        = $this->schYear;
        $info['semCode']    	= $this->semCode;
        $info['idno']        	= $this->idno;
        $info['ORno']        	= $this->ORno;
        $info['type']        	= $this->type;
        $info['date']    		= $this->date;
        $info['amount']    		= $this->amount;
        $info['encodedBy']      = $this->encodedBy;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['regPaymentID']  = " = ".$this->regPaymentID;
		
		// building an update query
        $this->tables = "registration_payments";
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
	 * calcelRegistrationPayment() method to cancel the RegistrationPayment record with the active regPaymentID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function cancelRegistrationPayment()
	{
	    // setting values to fields
        $info['schYear']        = $this->schYear;
        $info['semCode']    	= $this->semCode;
        $info['idno']        	= $this->idno;
        $info['ORno']        	= $this->ORno;
        $info['type']        	= $this->type;
        $info['date']    		= $this->date;
        $info['amount']    		= $this->amount;
        $info['encodedBy']      = $this->encodedBy;
        $info['rstatus']        = '0';
		
		// setting conditions
		$conds[]['regPaymentID']  = " = ".$this->regPaymentID;
		
		// building an update query
        $this->tables = "registration_payments";
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
	 * deleteRegistrationPayment() method to delete the RegistrationPayment record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteRegistrationPayment()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['regPaymentID'] = " = ".$this->regPaymentID;
	    
	    // building an delete query
	    $this->tables = "registration_payments";
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
	 * retrieveAllRegistrationPayments() method to retrieve all/selected Payment records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllRegistrationPayments($where='',$orderby='', $sorting='', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "registration_payments";
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
	 * retrieveAllStudentRegistrationPayments() method to retrieve all/selected Payment records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllStudentRegistrationPayments($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="registration_payments";
		$tables[]="students";
		
		$multiOrder['registration_payments.schYear'] = "DESC";
		$multiOrder['registration_payments.semCode'] = "DESC";
		$multiOrder['students.lname'] 	= "ASC";
		$multiOrder['students.fname'] 	= "ASC";
		$multiOrder['students.mname'] 	= "ASC";
		
		if (count($where[0]) && $where) {
		    $where[0]['AND registration_payments.idno'] = "= students.idno ";
		} else {
		    $where[0][' registration_payments.idno'] = "= students.idno ";
		}
		
		$flds['registration_payments.*']  = "";
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
	 * countAllStudentRegistrationPayments() method to retrieve all/selected Payment records
	 *
	 * @param int $offset
	 * @param int $limit
	 * @return int ttl_record
	 */
	function countAllStudentRegistrationPayments($where='', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="registration_payments";
		$tables[]="students";
		
		if (count($where[0]) && $where) {
		    $where[0]['AND registration_payments.idno'] = "= students.idno ";
		} else {
		    $where[0][' registration_payments.idno'] = "= students.idno ";
		}
		
		$flds['count(registration_payments.ORno) as ttl_record']  = "";		
		
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
		$where[0]['schYear']="= '".$this->schYear."' AND ";
	    $where[0]['semCode'] = "= '".$this->semCode."' AND ";
	    $where[0]['ORno'] = "= '".$this->ORno."' AND ";
	    $where[0]['type'] = "= '".$this->type."' AND ";
	    $where[0]['idno'] = "= '".$this->idno."'";
	    
	    $result = $this->retrieveAllRegistrationPayments($where,'regPaymentID','DESC',0,1);
	    return $result[0]['regPaymentID'];
	}

	/**
	 * isExist() - function to check the PaymentID is already exist
	 *
	 * @param string $paymentID
	 * @return bool 
	 */
	function isExist($schYear, $semCode, $type, $idno)
	{
	    if ($schYear && $semCode && $type && $idno) {
    	    // setting conditions
    	    $conds[]['schYear'] = " = '$schYear' AND ";
    	    $conds[]['semCode'] = " = '$semCode' AND ";
    	    $conds[]['type'] = " = '$type' AND ";
    	    $conds[]['idno'] = " = '$idno' AND ";
    	    $conds[]['rstatus'] = " = '1'";
    	    
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
	
	
	/**
	 * totalRegistrationPayment() method to retrieve the RegistrationPayment record and assign to the registrant attributes
	 *
	 */
	function totalRegistrationPayment($idno, $schYear, $semCode)
	{
	    // setting conditions
	    $conds[0]['idno'] = " = '$idno' AND ";
	    $conds[0]['schYear'] = " = '$schYear' AND ";
	    $conds[0]['semCode'] = " = '$semCode' AND ";
	    $conds[0]['rstatus'] = " = 1";
	    
	    $fields['sum(amount) as totalDPayment']= '';
	    
	    // building an insert query
	    $this->tables = "registration_payments";
	    $this->conds  = $conds;
	    $this->fields = $fields;
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
                    return $data[0]['totalDPayment'];
            	}    		
    	    } catch(PDOException $e) {
    	        echo $e;
    	        return 0;
    	    }
	    } else {
		    $this->displayErrors();
		    return 0;
		}
	}
	
}

?>