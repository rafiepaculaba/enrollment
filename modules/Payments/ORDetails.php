<?php
/**
 *
 * Filename: ORDetails.php
 * Date: 	 February 2, 2007
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: ORDetails
 * Description: This class is a model of the object - ORDetails
 * 				Implementing the active record pattern of database record
 */

class ORDetails extends Database 
{
    var $ordno;
	var $orno;
	var $account_code;
	var $amount;
	
	/**
	 * ORDetails() constructor of the ORDetails class
	 *
	 * @return ORDetails
	 */
	function ORDetails($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level

	    // set active record if found
		if ($id) {
			$this->id = $id;
			$this->retrieveORDetails();
		}
	}
	
    /**
     * createORDetails() method to save the ORDetails record
     *
     * @return bool - return true if successful otherwise false
     */
	function createORDetails() 
	{   
	    // setting values to fields
        $info['orno']           = $this->orno;
        $info['account_code']   = $this->account_code;
        $info['amount']         = $this->amount;
		
		// building an insert query
        $this->tables = "ordetails";
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
	 * retrieveORDetails() method to retrieve the ORDetails record and assign to the registrant attributes
	 *
	 */
	function retrieveORDetails($lock='0')
	{
	    // setting conditions
	    $conds[0]['ordno'] = " = ".$this->ordno;
	    
	    // building an insert query
	    $this->tables = "ORDetails";
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
                    $this->ordno        = $data[0]['ordno'];
                    $this->orno         = $data[0]['orno'];
                    $this->account_code = $data[0]['account_code'];
                    $this->amount       = $data[0]['amount'];
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
	 * updateORDetails() method to update the ORDetails record with the active id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateORDetails()
	{
	    // setting values to fields
        $info['ordno']          = $this->ordno;
        $info['orno']           = $this->orno;
        $info['account_code']   = $this->account_code;
        $info['amount']         = $this->amount;
		
		// setting conditions
		$conds[]['ordno']  = " = ".$this->ordno;
		
		// building an update query
        $this->tables = "ordetails";
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
	 * deleteORDetails() method to delete the ORDetails record  witht the active id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteORDetails()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['ordno'] = " = ".$this->ordno;
	    
	    // building an delete query
	    $this->tables = "ordetails";
	    $this->conds  = $conds;

	    // building an select query
	    $query = $this->Delete();  // generate delete sql query
	    $this->reset();          // reset all variables in query generator
	    
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
	 * retrieveAllORDetails() method to retrieve all/selected ORDetails records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllORDetails($where='',$orderby='ordno', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "ordetails";
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
	    $where[0]['fiscalYear'] = "= '".$this->fiscalYear."' AND ";
	    $where[0]['firstORNO'] = "= '".$this->firstORNO."' AND ";
	    $where[0]['lastORNO'] = "= '".$this->lastORNO."'";
	    $result = $this->retrieveAllORDetails($where,'id','DESC',0,1);
	    return $result[0]['id'];
	}

	
	/**
	 * isExist() - function to check the OR Series No. is already exist
	 *
	 * @param string $fiscalYear
	 * @param string $firstORNO
	 * @param string $lastORNO
	 * @return bool 
	 */
	function isExist($fiscalYear, $firstORNO, $lastORNO)
	{
	    if ($fiscalYear && $firstORNO && $lastORNO) {
    	    // setting conditions
    	    $conds[]['fiscalYear'] = " = '$fiscalYear' AND ";
    	    $conds[]['firstORNO'] = " = '$firstORNO' AND ";
    	    $conds[]['lastORNO'] = " = '$lastORNO' ";
    	    
    	    // building an insert query
    	    $this->tables = "ordetails";
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