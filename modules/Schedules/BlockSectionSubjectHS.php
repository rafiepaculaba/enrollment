<?php
/**
 *
 * Filename: BlockSectionSubjectHS.php
 * Date: 	 Feb 18, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */


/**
 * Class: BlockSectionSubject
 * Description: This class is a model of the object - BlockSectionSubject for HS
 * 				Implementing the active record pattern of database record
 */

class BlockSectionSubject extends Database 
{
	var $secDetailID;
	var $secID;
    var $schedID;
    var $rstatus;
    var $sched;
	
	/**
	 * BlockSectionSubject() constructor of the BlockSectionSubject class
	 * 
	 * @return BlockSectionSubject
	 */
	function BlockSectionSubject($id='') 
	{
	    // calling the parent class
	    parent::Database(2); // high school level
	    
	    // set active record if found
		if ($id) {
			$this->secDetailID = $id;
			$this->retrieveBlockSectionSubject();
		}
	}
	
    /**
     * createBlockSectionSubject() method to save the BlockSectionSubject record
     *
     * @return bool - return true if successful otherwise false
     */
	function createBlockSectionSubject() 
	{
	    // setting values to fields
    	$info['secID']    = $this->secID;
    	$info['schedID']  = $this->schedID;
		
		// building an insert query
        $this->tables = "block_sections_details";
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
	 * retrieveBlockSectionSubject() method to retrieve the BlockSectionSubject record and assign to the BlockSectionSubject attributes
	 *
	 */
	function retrieveBlockSectionSubject($lock='0')
	{
	    // setting conditions
	    $conds[0]['secDetailID'] = " = '".$this->secDetailID."'";
	    
	    // building an insert query
	    $this->tables = "block_sections_details";
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
                	$this->secID    = $data[0]['secID'];
                	$this->schedID  = $data[0]['schedID'];
                	$this->sched = new Schedule($this->schedID);
                    $this->rstatus = $data[0]['rstatus'];
            		
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
	 * updateBlockSectionSubject() method to update the BlockSectionSubject record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateBlockSectionSubject()
	{
	    // setting values to fields
    	$info['secID']    = $this->secID;
    	$info['schedID']  = $this->schedID;
        $info['rstatus']  = $this->rstatus;
		
		// setting conditions
		$conds[]['secDetailID']  = " = '".$this->secDetailID."'";
		
		// building an insert query
        $this->tables = "block_sections_details";
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
	 * deleteBlockSectionSubject() method to delete the BlockSectionSubject record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteBlockSectionSubject()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['secDetailID'] = " = '".$this->secDetailID."'";
	    
	    // building an insert query
	    $this->tables = "block_sections_details";
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
	 * retrieveAllBlockSectionSubjects() method to retrieve all/selected BlockSectionSubject records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllBlockSectionSubjects($where='',$orderby='secDetailID', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "block_sections_details";
	    $this->conds  = $where;
	    $this->order  = $orderby;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
	    
	    // set association
	    $u = new User2();
	    
		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
    		$data=array();
    		$ctr=0;
		    
    		foreach ($records as $row) {
    		    $data[$ctr] = $row;
    		
    		    $theSched = new Schedule();    
    		    $theSched->schedID = $row['schedID'];
    		    $theSched->retrieveSchedule();
    		    
    		    // assign sched object
    		    $data[$ctr]['sched'] = $theSched;
    		    
    		    $ctr++;
    		}
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	/**
	 * isExist() - function to check the BlockSectionSubject name is already exist
	 *
	 * @param number $secID
	 * @param number $schedID
	 * @return bool 
	 */
	function isExist($secID, $schedID)
	{
	    if ($secID && $schedID) {
    	    // setting conditions
    	    $conds[]['secID']  = " = '$secID' AND ";
    	    $conds[]['schedID'] = " = '$schedID'";
    	    
    	    // building an insert query
    	    $this->tables = "block_sections_details";
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
                        // return true - the sched is already exist            		
                		return true;
                	} else {
                	    // return false - the sched does not exist
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