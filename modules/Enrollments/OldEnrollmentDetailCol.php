<?php
/**
 *
 * Filename: EnrollmentDetailCol.php
 * Date: 	 March 3, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */


/**
 * Class: EnrollmentDetail
 * Description: This class is a model of the object - EnrollmentDetail
 * 				Implementing the active record pattern of database record
 */

class OldEnrollmentDetail extends Database 
{
	var $oendID;
	var $oenID;
    var $subjID;
    var $fgrade;
    var $rstatus;
    var $units;
    var $sched;
	
	/**
	 * EnrollmentDetail() constructor of the EnrollmentDetail class
	 * 
	 * @return EnrollmentDetail
	 */
	function OldEnrollmentDetail($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->oendID = $id;
			$this->retrieveEnrollmentDetail();
		}
	}
	
    /**
     * createEnrollmentDetail() method to save the EnrollmentDetail record
     *
     * @return bool - return true if successful otherwise false
     */
	function createEnrollmentDetail() 
	{
	    // setting values to fields
    	$info['oenID']   = $this->oenID;
    	$info['subjID']  = $this->subjID;
    	$info['fgrade']  = $this->fgrade;
    	$info['units']   = $this->units;
		
		// building an insert query
        $this->tables = "old_enrollment_details";
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
	 * retrieveEnrollmentDetail() method to retrieve the EnrollmentDetail record and assign to the EnrollmentDetail attributes
	 *
	 */
	function retrieveEnrollmentDetail($lock='0')
	{
	    // setting conditions
	    $conds[0]['oendID'] = " = '".$this->oendID."'";
	    
	    // building an insert query
	    $this->tables = "old_enrollment_details";
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
                	$this->enID    = $data[0]['oenID'];
                	$this->subjID  = $data[0]['subjID'];
                	$this->fgrade  = $data[0]['fgrade'];
                	$this->units   = $data[0]['units'];
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
	 * updateEnrollmentDetail() method to update the EnrollmentDetail record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateEnrollmentDetail()
	{
	    // setting values to fields
    	$info['oenID']    = $this->oenID;
    	$info['subjID']   = $this->subjID;
 	    $info['fgrade']   = $this->fgrade;
 	    $info['units']    = $this->units;
        $info['rstatus']  = $this->rstatus;
		
		// setting conditions
		$conds[]['oendID']  = " = '".$this->oendID."'";
		
		// building an insert query
        $this->tables = "old_enrollment_details";
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
	 * deleteEnrollmentDetail() method to delete the EnrollmentDetail record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteEnrollmentDetail()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['oendID'] = " = '".$this->oendID."'";
	    
	    // building an insert query
	    $this->tables = "old_enrollment_details";
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
	 * retrieveAllEnrollmentDetails() method to retrieve all/selected EnrollmentDetail records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllEnrollmentDetails($where='',$orderby='oendID', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "old_enrollment_details";
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
    		
    		// Course object instance
    		$data=array();
    		$ctr=0;
    		foreach ($records as $row) {
    		    $data[$ctr] = $row;
    		    
    		    // get the fgrade in the tor
    		    $query = "select fgrade from tor where oendID='".$row['oendID']."' limit 1";
    		    try {
            	    $this->db->beginTransaction();
                	$result2   = $this->db->query($query);
            		$records2  = $result2->fetchAll(PDO::FETCH_BOTH);
            		$this->db->commit();
    		    } catch (PDOException $e) {
        		    echo "SQL query error.";
        		}
        		
        		if (count($records2)) {
        		   $data[$ctr]['tor_grade'] = $records2[0]['fgrade'];
        		} else { 
        		   $data[$ctr]['tor_grade'] = "";
        		}
    		    
    		    $ctr++;
    		}
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	/**
	 * isExist() - function to check the EnrollmentDetail name is already exist
	 *
	 * @param number $oenID
	 * @param number $subjID
	 * @return bool 
	 */
	function isExist($oenID, $subjID)
	{
	    if ($oenID && $subjID) {
    	    // setting conditions
    	    $conds[]['oenID']  = " = '$oenID' AND ";
    	    $conds[]['subjID'] = " = '$subjID'";
    	    
    	    // building an insert query
    	    $this->tables = "old_enrollment_details";
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
	
	
	
	function getLastID($oenID, $subjID)
	{
	    if ($oenID && $subjID) {
    	    // setting conditions
    	    $conds[]['oenID'] = " = '$oenID' AND ";
    	    $conds[]['subjID'] = " = '$subjID' AND ";
    	    $conds[]['rstatus'] = " = 1";

    	    // building an insert query
    	    $this->tables = "old_enrollment_details";
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
                        // return true - the gsID is already exist            		
                		return $data[0]['oendID'];
                	} else {
                	    // return false - the gsID does not exist
                	    return 0;
                	}   		
        	    } catch(PDOException $e) {
        	        echo $e;
        	        return 0;
        	    }
    	    } else {
    		    $this->displayErrors();
    		    return 0;
    		}
	    } else {
	        return 0;
	    }
	    
	}
	
}
?>