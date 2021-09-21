<?php
/**
 *
 * Filename: ChartAccountType.php
 * Date: 	 March 14, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: ChartAccountType
 * Description: This class is a model of the object - chart type
 * 				Implementing the active record pattern of database record
 */

class ChartAccountType extends Database 
{
	
	var $id;
	var $name;
	var $class_id;
	var $class_name;
	var $parent;
	
	
	/**
	 * Account() constructor of the Account class
	 *
	 * @return Account
	 */
	function ChartAccountType($id='') 
	{
	    // calling the parent class
	    parent::Database(0); // college level

	    // set active record if found
		if ($id) {
			$this->id = $id;
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
	    // account class
	    $config = new Config();
	    
        $info['class_id']   = $config->getConfig('Income Account Number');
        $info['name']       = $this->name;
        $info['parent']     = $this->parent;
        
		// building an insert query
        $this->tables = "chart_types";
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
	    $conds[0]['chart_types.id']       = " = ".$this->id;
	    $conds[0][' and chart_class.cid'] = " chart_types.id";
	    
	    $flds['chart_types.*, chart_class.class_name'] = "";
	    
	    // building an insert query
	    $tables[] = "chart_types";
	    $tables[] = "chart_class";
	    $this->tables = tables;
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
                    $this->name		   = $data[0]['name'];
                    $this->class_id	   = $data[0]['class_id'];
                    $this->class_name  = $data[0]['class_name'];
                    $this->parent      = $data[0]['parent'];
                    
                    
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
        $info['name']       = $this->name;
        $info['class_id']   = $this->account_type;
        $info['parent']     = $this->parent;
		
		// setting conditions
		$conds[]['id']  = " = ".$this->id;
		
		// building an update query
        $this->tables = "chart_types";
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
	function deleteRecord()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['id'] = " = ".$this->id;
	    
	    // building an delete query
	    $this->tables = "chart_types";
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
	function retrieveAllRecords($where='',$orderby='chart_types.name', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    
	    $conds[0]['chart_class.cid'] = " = chart_types.class_id";
	    $flds['chart_types.*, chart_class.class_name'] = "";
	    
	    // building an insert query
	    $tables[] = "chart_types";
	    $tables[] = "chart_class";
	    $this->tables = $tables;
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
	 * isExist() - function to check the accID is already exist
	 *
	 * @param string $accID
	 * @return bool 
	 */
	function isExist($target)
	{
	    if ($target) {
    	    // setting conditions
    	    $conds[]['name'] = " = '$target' ";
    	    
    	    // building an insert query
    	    $this->tables = "chart_types";
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