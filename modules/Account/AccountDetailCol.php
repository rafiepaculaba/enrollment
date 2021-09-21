<?php
/**
 *
 * Filename: AccountDetailElem.php
 * Date: 	 March 3, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */


/**
 * Class: AccountDetail
 * Description: This class is a model of the object - AccountDetail
 * 				Implementing the active record pattern of database record
 */

class AccountDetail extends Database 
{
	var $accDetailID;
	var $accID;
    var $feeType;
    var $particular;
    var $amount;
    var $rstatus;
	
	/**
	 * AccountDetail() constructor of the AccountDetail class
	 * 
	 * @return AccountDetail
	 */
	function AccountDetail($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->accDetailID = $id;
			$this->retrieveAccountDetail();
		}
	}
	
    /**
     * createAccountDetail() method to save the AccountDetail record
     *
     * @return bool - return true if successful otherwise false
     */
	function createAccountDetail() 
	{
	    // setting values to fields
    	$info['accID']      = $this->accID;
    	$info['feeType']    = $this->feeType;
    	$info['particular'] = $this->particular;
    	$info['amount']     = $this->amount;
		
		// building an insert query
        $this->tables = "account_details";
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
	 * retrieveAccountDetail() method to retrieve the AccountDetail record and assign to the AccountDetail attributes
	 *
	 */
	function retrieveAccountDetail($lock='0')
	{
	    // setting conditions
	    $conds[0]['accDetailID'] = " = '".$this->accDetailID."'";
	    
	    // building an insert query
	    $this->tables = "account_details";
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
                	$this->accID      = $data[0]['accID'];
                	$this->feeType    = $data[0]['feeType'];
                	$this->particular = $data[0]['particular'];
                	$this->amount     = $data[0]['amount'];
                    $this->rstatus    = $data[0]['rstatus'];
            		
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
	 * updateAccountDetail() method to update the AccountDetail record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateAccountDetail()
	{
	    // setting values to fields
    	//$info['accID']      = $this->accID;
    	//$info['feeType']    = $this->feeType;
    	//$info['particular'] = $this->particular;
 	    $info['amount']     = $this->amount;
        //$info['rstatus']    = $this->rstatus;
		
		// setting conditions
		$conds[]['accDetailID']  = " = '".$this->accDetailID."'";
		
		// building an insert query
        $this->tables = "account_details";
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
	 * deleteAccountDetail() method to delete the AccountDetail record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteAccountDetail()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['accDetailID'] = " = '".$this->accDetailID."'";
	    
	    // building an insert query
	    $this->tables = "account_details";
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
	 * retrieveAllAccountDetails() method to retrieve all/selected AccountDetail records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllAccountDetails($where='',$orderby='accDetailID', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "account_details";
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