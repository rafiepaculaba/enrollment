<?php
/**
 * Edited
 * Filename: MiscFeeElem.php
 * Date: 	 Dec. 04, 2008
 * 
 * Author: 	 Rafie Paculaba
 * 
 */


/**
 * Class: MiscFee
 * Description: This class is a model of the object - MiscFee
 * 				Implementing the active record pattern of database record
 */

class MiscFee extends Database 
{
	
	var $miscID;
	var $schYear;
	var $yrLevel;
	var $particular;
	var $amount;
	
	/**
	 *MiscFee() constructor of the MiscFee class
	 *
	 * @return MiscFee
	 */
	function MiscFee($id='') 
	{
	    // calling the parent class
	    parent::Database(1); //Elementary level
	    
	    // set active record if found
		if ($id) {
			$this->miscID = $id;
			$this->retrieveMiscFee();
		}
	}

    /**
     * createMiscFee() method to save the MiscFee record
     *
     * @return bool - return true if successful otherwise false
     */
	function createMiscFee() 
	{
	    // setting values to fields
	    
        $info['schYear']        = $this->schYear;
        $info['yrLevel']        = $this->yrLevel;
        $info['particular']     = $this->particular;
        $info['amount']         = $this->amount;
		
		// building an insert query
        $this->tables = "misc";
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
	 * retrieveMiscFee() method to retrieve the MiscFee record and assign to the MiscFee attributes
	 *
	 */
	function retrieveMiscFee($lock='0')
	{
	    // setting conditions
	    $conds[0]['miscID'] = " = ".$this->miscID;

	    // building an insert query
	    $this->tables = "misc";
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
                    $this->yrLevel     	= $data[0]['yrLevel'];
                    $this->particular   = $data[0]['particular'];
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
	 * updateMiscFee() method to update the MiscFee record with the active miscID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateMiscFee()
	{
	    // setting values to fields
        $info['schYear']    = $this->schYear;
        $info['yrLevel']    = $this->yrLevel;
        $info['particular'] = $this->particular;
        $info['amount']     = $this->amount;
		
		// setting conditions
		$conds[]['miscID']  = " = '".$this->miscID."'";
		
		// building an insert query
        $this->tables = "misc";
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
	 * deleteSchoolFee() method to delete the SchoolFee record  with the active FeeID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteMiscFee()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['miscID'] = " = '".$this->miscID."'";
	    
	    // building an insert query
	    $this->tables = "misc";
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
	 * retrieveAllmMiscFees() method to retrieve all/selected MiscFee records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllMiscFees($where='',$orderby='miscID', $sorting='DESC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "misc";
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
	function countAllMiscFees($where='', $offset=0, $limit='')
	{
		// building an insert query
		$flds['count(miscID) as ttl_record']  = "";
	    
		$this->tables = "misc";
	    $this->fields = $flds;
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
    		
			if ($records) {
    		    return $records[0]['ttl_record'];
    		}

    		return $data;
    		
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
	    $where[0]['particular'] = "= '".$this->particular."'";
	    
	    $result = $this->retrieveAllMiscFees($where,'miscID','DESC',0,1);
	    return $result[0]['miscID'];
	}	

	/**
	 * isExist() - function to check the misc fee is already exist
	 *
	 * @param string $schYear
	 * @param string $item
	 * @return 1 & -1
	 */
	function isExist($schYear, $yrLevel, $particular)
	{
	    if ($schYear && $yrLevel && $particular) {
    	    // setting conditions
    	    $conds[]['schYear'] = " = '$schYear' AND ";
    	    $conds[]['yrLevel'] = " = '$yrLevel' AND ";
    	    $conds[]['particular'] = " = '$particular'";

    	    // building an insert query
    	    $this->tables = "misc";
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
	 * getFee() method that will get the definition of the config
	 *
	 * @param string $title
	 */
	function getFee($item, $schYear='', $yrLevel) 
	{
	    if ($schYear) {
	       $conds[0]['schYear'] = "='$schYear' AND ";
	    }
	    
        $conds[0]['yrLevel'] = "='$yrLevel' AND ";
        $conds[0]['item'] = "='$item'";
        
        $result = $this->retrieveAllSchoolFees($conds); 
        if ($result) {
            return $result[0]['amount'];
        } else {
            // recheck if has prev school fee with corresponding item and 
            unset($conds);
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
    		
    		// object instance
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