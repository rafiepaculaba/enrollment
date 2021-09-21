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
 * Description: This class is a model of the object - chart master
 * 				Implementing the active record pattern of database record
 */

class ChartAccountMaster extends Database 
{
	
	var $account_code;
	var $account_name;
	var $account_type;
	var $account_name_type;
	
	/**
	 * Account() constructor of the Account class
	 *
	 * @return Account
	 */
	function ChartAccountMaster($id='') 
	{
	    // calling the parent class
	    parent::Database(0); // college level

	    // set active record if found
		if ($id) {
			$this->account_code = $id;
			$this->retrieveRecord();
		}
	}
	
	
    /**
     * createAccount() method to save the Account record
     *
     * @return bool - return true if successful otherwise false
     */
	function createRecord() 
	{
	    // setting values to fields
        $info['account_code'] = $this->account_code;
        $info['account_name'] = $this->account_name;
        $info['account_type'] = $this->account_type;
        
		// building an insert query
        $this->tables = "chart_master";
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
	function retrieveRecord($lock='0')
	{
	    // setting conditions
	    $conds[0]['chart_master.account_code'] = " = ".$this->account_code;
	    $conds[0][' and chart_master.account_type'] = " = chart_types.id";
	    
	    $flds['chart_master.*, chart_types.name'] = "";
	    
	    // building an insert query
	    $tables[] = "chart_types";
	    $tables[] = "chart_master";
	    $this->tables = $tables;
	    $this->fields = $flds;
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
                    $this->account_code		= $data[0]['account_code'];
                    $this->account_name		= $data[0]['account_name'];
                    $this->account_type     = $data[0]['account_type'];
                    $this->account_name_type= $data[0]['name'];
                    
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
	function updateRecord()
	{
	    // setting values to fields
        $info['account_name']   = $this->account_name;
        $info['account_type']   = $this->account_type;
		
		// setting conditions
		$conds[]['account_code']  = " = ".$this->account_code;
		
		// building an update query
        $this->tables = "chart_master";
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
	
	
//	function isUsed()
//	{
//	    // setting conditions
//	    $conds[0]['account_code'] = " = ".$this->account_code;
//	    
//	    $flds['count(*) as ttl'] = "";
//	    
//	    // building an insert query
//	    $this->tables = 'ordetails';
//	    $this->fields = $flds;
//	    $this->conds  = $conds;
//	    $this->lock   = $lock;
//
//	    // building an select query
//	    $query = $this->Select();  // generate select sql query
//	    $this->reset();            // reset all variables in query generator
//		
//	    // check if building query is successful
//		if ( empty($this->errs) ) {
//    	    try {
//    	        $this->db->beginTransaction();
//        		$result = $this->db->query($query);
//        		$data   = $result->fetchAll(PDO::FETCH_BOTH);
//        		$this->db->commit();
//        		
//        		if ($data[0]['ttl']) {
//            		return true;
//            	}    	
//    	    } catch(PDOException $e) {
//    	        echo $e;
//    	        return false;
//    	    }
//	    } else {
//		    $this->displayErrors();
//		    return false;
//		}
//	}
	
	
	/**
	 * deleteAccount() method to delete the Account record  witht the active accID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteRecord()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['account_code'] = " = ".$this->account_code;
	    
	    // building an delete query
	    $this->tables = "chart_master";
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
	function retrieveAllRecords($where='',$orderby='chart_master.account_name', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    
		// setting conditions
	    $conds[0]['chart_master.account_type'] = " = chart_types.id";
	    
	    $flds['chart_master.*, chart_types.name'] = "";
	    
	    // building an insert query
	    $tables[] = "chart_types";
	    $tables[] = "chart_master";
	    
	    $this->tables = "chart_types, chart_master";
	    $this->fields = $flds;
		
	    $this->conds  = $conds;
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
	 * retrieveAllChartAccountMaster() method to retrieve all/selected ChartAccountMaster records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllChartAccountMaster($where='',$orderby='', $sorting='DESC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "chart_master";
	    $this->conds  = $where;
	    $this->order  = $orderby;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
		
//  	    $course = new Course();

		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
    		// Course object instance
//    		$data=array();
//    		$ctr=0;
//    		foreach ($records as $row) {
//
//    		    $course->courseID = $row['courseID'];
//    		    $course->retrieveCourse();
//				
//    		    $data[$ctr] = $row;
//    		    $data[$ctr]['courseCode']   = $course->courseCode;
//    		
//    		    $ctr++;
//    		}

    		return $records;
    		
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	/**
	 * isExist() - function to check the accID is already exist
	 *
	 * @param string $accID
	 * @return bool 
	 */
	function isExist($target)
	{
	    if ($target) {
    	    // setting conditions
    	    $conds[]['account_code'] = " = '$target' ";
    	    
    	    // building an insert query
    	    $this->tables = "chart_master";
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