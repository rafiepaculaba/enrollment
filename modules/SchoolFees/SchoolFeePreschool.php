<?php
/**
 * Edited
 * Filename: SchoolFeePreschool.php
 * Date: 	 June 27, 2008
 * 
 * Author: 	 Rafie D. Paculaba
 * 
 */


/**
 * Class: SchoolFee
 * Description: This class is a model of the object - SchoolFee
 * 				Implementing the active record pattern of database record
 */

class SchoolFee extends Database 
{
	
	var $feeID;
	var $schYear;
	var $yrLevel;
	var $item;
	var $amount;
	var $rstatus;
	
	/**
	 *SchoolFee() constructor of the SchoolFee class
	 *
	 * @return SchoolFee
	 */
	function SchoolFee($id='') 
	{
	    // calling the parent class
	    parent::Database(4); // Preschool level
	    
	    // set active record if found
		if ($id) {
			$this->feeID = $id;
			$this->retrieveSchoolFee();
		}
	}
	
	
	
    /**
     * createSchoolFee() method to save the SchoolFee record
     *
     * @return bool - return true if successful otherwise false
     */
	function createSchoolFee() 
	{
	    // setting values to fields
        $info['schYear']  = $this->schYear;
        $info['yrLevel']  = $this->yrLevel;
        $info['item']     = $this->item;
        $info['amount']   = $this->amount;
		
		// building an insert query
        $this->tables = "school_fees";
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
	 * retrieveSchoolFee() method to retrieve the SchoolFee record and assign to the SchoolFee attributes
	 *
	 */
	function retrieveSchoolFee($lock='0')
	{
	    // setting conditions
	    $conds[0]['feeID'] = " = ".$this->feeID;

	    // building an insert query
	    $this->tables = "school_fees";
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
            		$this->schYear      = $data[0]['schYear'];
            		$this->yrLevel      = $data[0]['yrLevel'];
                    $this->item         = $data[0]['item'];
                    $this->amount       = $data[0]['amount'];
                    $this->rstatus      = $data[0]['rstatus'];
            		
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
	 * updateSchoolFee() method to update the SchoolFee record with the active deptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateSchoolFee()
	{
	    // setting values to fields
        $info['schYear']  = $this->schYear;
        $info['yrLevel']  = $this->yrLevel;
        $info['item']     = $this->item;
        $info['amount']   = $this->amount;
        $info['rstatus']  = $this->rstatus;
		
		// setting conditions
		$conds[]['feeID']  = " = '".$this->feeID."'";
		
		// building an insert query
        $this->tables = "school_fees";
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
	 * deleteSchoolFee() method to delete the SchoolFee record  witht the active DeptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteSchoolFee()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['feeID'] = " = '".$this->feeID."'";
	    
	    // building an insert query
	    $this->tables = "school_fees";
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
	 * retrieveAllSchoolFees() method to retrieve all/selected SchoolFee records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllSchoolFees($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "school_fees";
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
	 * countAllSchoolFees() method to retrieve all/selected SchoolFee records
	 *
	 * @param array $where
	 * @param int $offset
	 * @param int $limit
	 * @return int ttl_record
	 */
	function countAllSchoolFees($where='', $offset=0, $limit='')
	{
		// building an insert query
		$flds['count(feeID) as ttl_record']  = "";
		
	    $this->tables = "school_fees";
	    $this->fields = $flds;
	    $this->conds  = $where;
	    $this->order  = $orderby;
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
		$where[0]['yrLevel']="= '".$this->yrLevel."' AND ";
	    $where[0]['item'] = "= '".$this->item."' AND ";
	    $where[0]['rstatus'] = "= 1";
	    
	    $result = $this->retrieveAllSchoolFees($where,'feeID','DESC',0,1);
	    return $result[0]['feeID'];
	}
	
	/**
	 * isExist() - function to check the school fee is already exist
	 *
	 * @param string $schYear
	 * @param string $yrLevel
	 * @param string $item
	 * @return 1 & -1
	 */
	function isExist($schYear, $yrLevel, $item)
	{
	    if ($schYear && $yrLevel && $item) {
    	    // setting conditions
    	    $conds[]['schYear'] = " = '$schYear' AND ";
    	    $conds[]['yrLevel'] = " = '$yrLevel' AND ";
    	    $conds[]['item'] = " = '$item' AND ";
    	    $conds[]['rstatus'] = " = '1'";

    	    // building an insert query
    	    $this->tables = "school_fees";
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
                        // return true - the school fee is already exist            		
                		return 1;
                	} else {
                	    // return false - the school fee does not exist
                	    return -1;
                	}   		
        	    } catch(PDOException $e) {
        	        echo $e;
        	        return -1;
        	    }
    	    } else {
    		    $this->displayErrors();
    		    return -1;
    		}
	    } else {
	        return -1;
	    }
	    
	}

	
	/**
	 * getConfig() method that will get the definition of the config
	 *
	 * @param string $title
	 */
	function getFee($item, $yrLevel, $schYear='') 
	{
	    if ($schYear) {
	       $conds[0]['schYear'] = "='$schYear' AND ";
	    }
	    
        $conds[0]['yrLevel'] = "='$yrLevel' AND ";
        $conds[0]['item'] = "='$item'";
        
        $result = $this->retrieveAllSchoolFees($conds,'schYear','DESC'); 
        if ($result) {
            return $result[0]['amount'];
        } else {
            // recheck if has prev school fee with corresponding item and course
            unset($conds);
            $conds[0]['yrLevel'] = "='$yrLevel' AND ";
            $conds[0]['item'] = "='$item'";
            
            $result = $this->retrieveAllSchoolFees($conds);
            
            if ($result) {
                return $result[0]['amount'];
            } else {
                return 0;
            }
        }
	}
	
	
	/**
	 * getFees() method that will get all the school fees
	 *
	 * @param string $title
	 */
	function getFees($schYear, $yrLevel) 
	{
	    if ($schYear && $yrLevel) {
	        $conds[0]['schYear'] = "='$schYear' AND ";
            $conds[0]['yrLevel'] = "='$yrLevel' ";
            
            $result = $this->retrieveAllSchoolFees($conds,'schYear','DESC'); 
            
            return $result;
        }
        
        return false;
	}
	
	/**
	 * getFee() method that will get the definition of the config
	 *
	 * @param string $title
	 */
	function getMisc($yrLevel, $schYear) 
	{
	    $conds[0]['schYear'] = "='$schYear' AND ";
        $conds[0]['yrLevel'] = "='$yrLevel' ";
        
        // building an insert query
	    $this->tables = "misc";
	    $this->conds  = $conds;
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
    		$misc = array();
    		$ctr  = 0;
    		$total= 0;
    		foreach ($records as $row) {
    		    $misc[$ctr] = $row;
    		    $total += $row['amount'];
    		    $ctr++;
    		}
    		
    		$data=array();
    		$data['misc'] = $misc;
    		$data['total'] = $total;

    		return $data;
    		
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
}
?>