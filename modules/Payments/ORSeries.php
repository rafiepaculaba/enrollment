<?php
/**
 *
 * Filename: PaymentType.php
 * Date: 	 February 2, 2007
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: PaymentType
 * Description: This class is a model of the object - PaymentType
 * 				Implementing the active record pattern of database record
 */

class ORSeries extends Database 
{
	var $id;
	var $fiscalYear;
	var $firstORNO;
	var $lastORNO;
	var $currentORNO;
	var $cancelledOR;
	var $cashier;
	var $cashierName;
	var $rstatus;
	
	/**
	 * ORSeries() constructor of the ORSeries class
	 *
	 * @return ORSeries
	 */
	function ORSeries($id='') 
	{
	    // calling the parent class
	    parent::Database(0); // college level

	    // set active record if found
		if ($id) {
			$this->id = $id;
			$this->retrieveORSeries();
		}
	}
	
	
    /**
     * createORSeries() method to save the ORSeries record
     *
     * @return bool - return true if successful otherwise false
     */
	function createORSeries() 
	{
	    // setting values to fields
        $info['fiscalYear']     = $this->fiscalYear;
        $info['firstORNO']      = $this->firstORNO;
        $info['lastORNO']       = $this->lastORNO;
        $info['currentORNO']    = $this->currentORNO;
        $info['cancelledOR']    = $this->cancelledOR;
        $info['cashier']        = $this->cashier;
		
		// building an insert query
        $this->tables = "orseries";
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
	 * retrieveORSeries() method to retrieve the ORSeries record and assign to the registrant attributes
	 *
	 */
	function retrieveORSeries($lock='0')
	{
	    // setting conditions
	    $conds[0]['id'] = " = ".$this->id;
	    
	    // building an insert query
	    $this->tables = "orseries";
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
                    $this->id           = $data[0]['id'];
                    $this->fiscalYear   = $data[0]['fiscalYear'];
                    $this->firstORNO    = $data[0]['firstORNO'];
                    $this->lastORNO     = $data[0]['lastORNO'];
                    $this->currentORNO  = $data[0]['currentORNO'];
                    $this->cancelledOR  = $data[0]['cancelledOR'];
                    $this->cashier      = $data[0]['cashier'];
                    
                    //get the cashier name
                    $u = new User2($data[0]['cashier']);
                    $this->cashierName		= htmlentities($u->last_name.", ".$u->first_name);
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
	 * updateORSeries() method to update the ORSeries record with the active id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateORSeries()
	{
	    // setting values to fields
        $info['fiscalYear']     = $this->fiscalYear;
        $info['firstORNO']      = $this->firstORNO;
        $info['lastORNO']       = $this->lastORNO;
        $info['currentORNO']    = $this->currentORNO;
        $info['cancelledOR']    = $this->cancelledOR;
        $info['cashier']        = $this->cashier;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['id']  = " = ".$this->id;
		
		// building an update query
        $this->tables = "orseries";
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
	 * deleteOReries() method to delete the ORSeries record  witht the active id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteORSeries()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['id'] = " = ".$this->id;
	    
	    // building an delete query
	    $this->tables = "orseries";
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
	 * retrieveAllORSeries() method to retrieve all/selected ORSeries records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllORSeries($where='',$orderby='id', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "orseries";
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
    		
    		// User object instance
    		$u = new User2();
    		$data=array();
    		$ctr=0;
    		foreach ($records as $row) {

   			    $u->id = $row['cashier'];
    		    $u->retrieveUser();

    		    $data[$ctr] = $row;
	   		    $data[$ctr]['cashierName'] 	= htmlentities($u->last_name.", ".$u->first_name);

    		    $ctr++;
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
	    $where[0]['fiscalYear'] = "= '".$this->fiscalYear."' AND ";
	    $where[0]['firstORNO'] = "= '".$this->firstORNO."' AND ";
	    $where[0]['lastORNO'] = "= '".$this->lastORNO."'";
	    $result = $this->retrieveAllORSeries($where,'id','DESC',0,1);
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
    	    $this->tables = "orseries";
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