<?php
/**
 *
 * Filename: Account.php
 * Date: 	 March 14, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: Account
 * Description: This class is a model of the object - Account
 * 				Implementing the active record pattern of database record
 */

class Account extends Database 
{
	
	var $accID;
	var $idno;
	var $schYear;
	var $semCode;
	var $courseID;
	var $yrLevel;
	var $oldBalance;
	var $totalFee;
	var $payment;
	var $balance;
	var $rstatus;
	
	var $details;
	
	/**
	 * Account() constructor of the Account class
	 *
	 * @return Account
	 */
	function Account($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level

	    // set active record if found
		if ($id) {
			$this->accID = $id;
			$this->retrieveAccount();
		}
	}
	
	
    /**
     * createAccount() method to save the Account record
     *
     * @return bool - return true if successful otherwise false
     */
	function createAccount() 
	{
	    // setting values to fields
        $info['idno']    		= $this->idno;
        $info['schYear']    	= $this->schYear;
        $info['semCode']    	= $this->semCode;
        $info['courseID']    	= $this->courseID;
        $info['yrLevel']    	= $this->yrLevel;
        $info['oldBalance']    	= $this->oldBalance;
        $info['totalFee']    	= $this->totalFee;
        $info['payment']    	= $this->payment;
        $info['balance']    	= $this->balance;
        
		// building an insert query
        $this->tables = "accounts";
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
	 * retrieveAccount() method to retrieve the Account record and assign to the registrant attributes
	 *
	 */
	function retrieveAccount($lock='0')
	{
	    // setting conditions
	    $conds[0]['accID'] = " = ".$this->accID;
	    
	    // building an insert query
	    $this->tables = "accounts";
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
                    $this->accID 		= $data[0]['accID'];
                    $this->idno   		= $data[0]['idno'];
                    $this->schYear      = $data[0]['schYear'];
                    $this->semCode 		= $data[0]['semCode'];
                    $this->courseID 	= $data[0]['courseID'];
                    $this->yrLevel 		= $data[0]['yrLevel'];
                    $this->oldBalance   = $data[0]['oldBalance'];
                    $this->totalFee   	= $data[0]['totalFee'];
                    $this->payment   	= $data[0]['payment'];
                    $this->balance   	= $data[0]['balance'];
                    $this->rstatus      = $data[0]['rstatus'];
            		
                    // get the item details
                    $account_detail = new AccountDetail();
                    
                    $where = array();
                    $where[0]['accID'] = "= '".$this->accID."' ";
                    $where[0][' AND rstatus'] = "= '1' ";
                    $this->details = $account_detail->retrieveAllAccountDetails($where);
            		
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
	 * updateAccount() method to update the Account record with the active accID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateAccount()
	{
	    // setting values to fields
        $info['idno']    		= $this->idno;
        $info['schYear']    	= $this->schYear;
        $info['semCode']    	= $this->semCode;
        $info['yrLevel']    	= $this->yrLevel;
        $info['courseID']    	= $this->courseID;
        $info['oldBalance']    	= $this->oldBalance;
        $info['totalFee']    	= $this->totalFee;
        $info['payment']    	= $this->payment;
        $info['balance']    	= $this->balance;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['accID']  = " = ".$this->accID;
		
		// building an update query
        $this->tables = "accounts";
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
	 * deleteAccount() method to delete the Account record  witht the active accID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteAccount()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['accID'] = " = ".$this->accID;
	    
	    // building an delete query
	    $this->tables = "accounts";
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
	 * retrieveAllAccounts() method to retrieve all/selected Account records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllAccounts($where='',$orderby='schYear', $sorting='DESC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "accounts";
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
	 * retrieveAllAccountsAssociation() method to retrieve all/selected Account records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllAccountsAssociation($where='',$orderby='accounts.schYear', $sorting='DESC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="accounts";
		$tables[]="students";
		$tables[]="courses";
		
		$fields['accounts.*']="";
		$fields['students.lname']="";
		$fields['students.fname']="";
		$fields['students.mname']="";
		$fields['students.gender']="";
		$fields['students.courseID']="";
		$fields['students.yrLevel']="";
		$fields['courses.courseCode']="";
		
		if (count($where)) {
		    $where[0][' AND students.courseID']="=courses.courseID";
		} else {
		    $where[0]['students.courseID']="=courses.courseID";
		}
		
	    $where[0][' AND students.idno']="=accounts.idno";
		
	    $this->tables = $tables;
	    $this->conds  = $where;
	    $this->fields = $fields;
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
	 * countAllAccountsAssociation() method to retrieve all/selected Account records
	 *
	 * @param array $where
	 * @param int $offset
	 * @param int $limit
	 * @return int total records
	 */
	function countAllAccountsAssociation($where='', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="accounts";
		$tables[]="students";
		$tables[]="courses";
		
		$fields['count(students.lname) as ttl_record']="";
		
		if (count($where)) {
		    $where[0][' AND students.courseID']="=courses.courseID";
		} else {
		    $where[0]['students.courseID']="=courses.courseID";
		}
		
	    $where[0][' AND students.idno']="=accounts.idno";
		
	    $this->tables = $tables;
	    $this->conds  = $where;
	    $this->fields = $fields;
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
    		if ($records) {
    		    return $records[0]['ttl_record'];
    		}
    		
    		return 0;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return 0;
		}
	}
	
	
	/**
	 * getLastID() -  this will get the last ID
	 *
	 * @return unknown
	 */
	function getLastID() 
	{
	    $where[0]['idno']="= '".$this->idno."' AND ";
	    $where[0]['schYear']="= '".$this->schYear."' AND ";
	    $where[0]['semCode']="= '".$this->semCode."' AND ";
	    $where[0]['rstatus']="= '1' ";
	    $result = $this->retrieveAllAccounts($where,'accID','DESC',0,1);

	    return $result[0]['accID'];
	}
	
	
	/**
	 * isExist() - function to check the accID is already exist
	 *
	 * @param string $accID
	 * @return bool 
	 */
	function isExist($accID)
	{
	    if ($accID) {
    	    // setting conditions
    	    $conds[]['accID'] = " = '$accID' ";
    	    
    	    // building an insert query
    	    $this->tables = "accounts";
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