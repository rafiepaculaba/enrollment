<?php
/**
 * Edited
 * Filename: ConfigElem.php
 * Date: 	 Feb 13, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: Config
 * Description: This class is a model of the object - Config
 * 				Implementing the active record pattern of database record
 */

class Config extends Database 
{
	
	var $configID;
	var $title;
	var $definition;
	var $rstatus;
	
	/**
	 *Config() constructor of the Config class
	 *
	 * @return Config
	 */
	function Config($id='') 
	{
	    // calling the parent class
	    parent::Database(1); // elem level
	    
	    // set active record if found
		if ($id) {
			$this->configID = $id;
			$this->retrieveConfig();
		}
	}
	
	
	
    /**
     * createConfig() method to save the Config record
     *
     * @return bool - return true if successful otherwise false
     */
	function createConfig() 
	{
	    // setting values to fields
        $info['title']       = $this->title;
        $info['definition']  = $this->definition;
		
		// building an insert query
        $this->tables = "configurations";
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
	 * retrieveConfig() method to retrieve the Config record and assign to the Config attributes
	 *
	 */
	function retrieveConfig($lock='0')
	{
	    // setting conditions
	    $conds[0]['configID'] = " = ".$this->configID;

	    // building an insert query
	    $this->tables = "configurations";
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
            		$this->title       = $data[0]['title'];
                    $this->definition  = $data[0]['definition'];
                    $this->rstatus     = $data[0]['rstatus'];
            		
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
	 * updateConfig() method to update the Config record with the active deptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateConfig()
	{
	    // setting values to fields
        $info['title']       = $this->title;
        $info['definition']  = $this->definition;
        $info['rstatus']     = $this->rstatus;
		
		// setting conditions
		$conds[]['configID']  = " = '".$this->configID."'";
		
		// building an insert query
        $this->tables = "configurations";
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
	 * deleteConfig() method to delete the Config record  witht the active DeptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteConfig()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['configID'] = " = '".$this->configID."'";
	    
	    // building an insert query
	    $this->tables = "configurations";
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
	 * retrieveAllConfigs() method to retrieve all/selected Config records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllConfigs($where='',$orderby='title', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "configurations";
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
//		    echo $e;
		    echo "SQL query error.";
		    return false;
		}
	}
	
	/**
	 * getLastID() method to retrieve last insertet deptID
	 *
	 * @return deptID
	 */
	function getLastID() 
	{
	    $where[0]['title'] = "= '".$this->title."' ";
	    
	    $result = $this->retrieveAllConfigs($where,'title','DESC',0,1);
	    
	    return $result[0]['configID'];
	}	
	
	
	/**
	 * isExist() - function to check the Config deptID is already exist
	 *
	 * @param number $deptID
	 * @return bool 
	 */
	function isExist($title)
	{
	    if ($title) {
    	    // setting conditions
    	    $conds[]['title'] = " = $title AND ";
    	    $conds[]['rstatus'] = " = 1";
    	    
    	    // building an insert query
    	    $this->tables = "configurations";
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
                        // return true - the config is already exist            		
                		return true;
                	} else {
                	    // return false - the config does not exist
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
	 * getConfig() method that will get the definition of the config
	 *
	 * @param string $title
	 */
	function getConfig($title) 
	{
	    $conds[0]['title'] = "='$title'";
        $result = $this->retrieveAllConfigs($conds);
        if ($result) {
            return $result[0]['definition'];
        } else {
            return "";
        }
	}
	
}
?>