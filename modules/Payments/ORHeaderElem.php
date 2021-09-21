<?php
/**
 *
 * Filename: ORHeaderElem.php
 * Date: 	 December 03, 2008
 * 
 * Author: 	 Rafie D. Paculaba
 * 
 */

/**
 * Class: ORHeader
 * Description: This class is a model of the object - ORHeader
 * 				Implementing the active record pattern of database record
 */

class ORHeader extends Database 
{
	var $paymentID;
	var $orno;
	var $particular;
	
	var $idno;
	var $accID;
	var $schYear;
	var $term;
	var $dateCreated;
	var $timeCreated;
	var $totalAmount;
	var $cashier;
	var $rstatus;
	
	
	/**
	 * ORHeader() constructor of the ORHeader class
	 *
	 * @return ORHeader
	 */
	function ORHeader($paymentID='') 
	{
	    // calling the parent class
	    parent::Database(1); // elementary

	    // set active record if found
		if ($paymentID) {
			$this->paymentID = $paymentID;
			$this->retrieveORHeader();
		}
	}
	
	
    /**
     * createORHeader() method to save the ORHeader record
     *
     * @return bool - return true if successful otherwise false
     */
	function createORHeader() 
	{
	    // setting values to fields
        $info['orno']       = $this->orno;
        $info['idno']       = $this->idno;
        $info['accID']      = $this->accID;
        $info['schYear']    = $this->schYear;
        $info['term']       = $this->term;
        $info['dateCreated']= $this->dateCreated;
        $info['timeCreated']= $this->timeCreated;
        $info['totalAmount']= $this->totalAmount;
        $info['cashier']    = $this->cashier;
		
		// building an insert query
        $this->tables = "orheader";
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
	 * retrieveORHeader() method to retrieve the ORHeader record and assign to the registrant attributes
	 *
	 */
	function retrieveORHeader($lock='0')
	{
	    // setting conditions
	    $conds[0]['paymentID'] = " = ".$this->paymentID;
	    
	    // building an insert query
	    $this->tables = "orheader";
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
                    $this->paymentID        = $data[0]['paymentID'];
                    $this->orno             = $data[0]['orno'];
                    $this->idno             = $data[0]['idno'];
                    $this->accID            = $data[0]['accID'];
                    $this->schYear          = $data[0]['schYear'];
                    $this->term             = $data[0]['term'];
                    $this->dateCreated      = $data[0]['dateCreated'];
                    $this->timeCreated      = $data[0]['timeCreated'];
                    $this->totalAmount      = $data[0]['totalAmount'];
                    $this->cashier          = $data[0]['cashier'];
                    $this->rstatus          = $data[0]['rstatus'];
                    
                    $ordetails = new ORDetails();

                    unset($conds);
                    $conds[0]['orno']   = " = '".$this->orno."'";
                    $this->particular = $ordetails->retrieveAllORDetails($conds);
                    
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
	 * updateORHeader() method to update the ORHeader record with the active id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateORHeader()
	{
	    // setting values to fields
        $info['paymentID']      = $this->paymentID;
        $info['orno']           = $this->orno;
        $info['idno']           = $this->idno;
        $info['accID']          = $this->accID;
        $info['schYear']        = $this->schYear;
        $info['term']           = $this->term;
        $info['dateCreated']    = $this->dateCreated;
        $info['timeCreated']    = $this->timeCreated;
        $info['totalAmount']    = $this->totalAmount;
        $info['cashier']        = $this->cashier;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['paymentID']  = " = ".$this->paymentID;
		
		// building an update query
        $this->tables = "orheader";
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
	 * cancelORHeader() method to cancel the ORHeader record with the active id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function cancelORHeader()
	{
	    // setting values to fields
        $info['paymentID']      = $this->paymentID;
        $info['orno']           = $this->orno;
        $info['idno']           = $this->idno;
        $info['accID']          = $this->accID;
        $info['schYear']        = $this->schYear;
        $info['term']           = $this->term;
        $info['dateCreated']    = $this->dateCreated;
        $info['timeCreated']    = $this->timeCreated;
        $info['totalAmount']    = $this->totalAmount;
        $info['cashier']        = $this->cashier;
        $info['rstatus']        = 0;
		
		// setting conditions
		$conds[]['paymentID']  = " = ".$this->paymentID;
		
		// building an update query
        $this->tables = "orheader";
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
            } catch(PDOException $e) {
               $this->db->rollBack();
               return false;
            }
        } else {
		    $this->displayErrors();
		    return false;
		}
	}
	
	/**
	 * deleteORHeader() method to delete the ORHeader record  witht the active id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteORHeader()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['paymentID'] = " = ".$this->paymentID;
	    
	    // building an delete query
	    $this->tables = "orheader";
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
	 * retrieveAllEnrollments() method to retrieve all/selected Enrollment records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllORHeader($where='',$orderby='orheader.schYear', $sorting='DESC', $offset=0, $limit='')
	{
		// building an select query
		if ($orderby!='orheader.paymentID') {
    		$multiOrder['students.lname']   = "ASC";
    		$multiOrder['students.fname']   = "ASC";
    		$multiOrder['orheader.schYear'] = "DESC";
    		
    		$this->multi_orders = $multiOrder;
		} else {
    		$this->order  = $orderby;
    	    $this->sorting= $sorting;    
		}
		
		$tables[] = "orheader";
		$tables[] = "students";
		
		if (count($where[0])) {
		    $where[0]['AND students.idno'] = "= orheader.idno ";
		} else {
		    $where[0]['students.idno'] = "=orheader.idno ";
		}
		
		$flds['orheader.*']  = "";
		$flds['students.lname'] = "";
		$flds['students.fname'] = "";
		$flds['students.mname'] = "";
		$flds['students.gender'] = "";
		$flds['students.yrLevel'] = "";
		
	    $this->tables = $tables;
	    $this->fields = $flds;
	    $this->conds  = $where;
	    
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
	    $where[0]['orheader.schYear'] = "= '".$this->schYear."' AND ";
	    $where[0]['orheader.orno'] = "= '".$this->orno."' AND ";
	    $where[0]['orheader.accID'] = "= '".$this->accID."' AND ";
	    $where[0]['orheader.term'] = "= '".$this->term."' AND ";
	    $where[0]['orheader.idno'] = "= '".$this->idno."'";
	    $result = $this->retrieveAllORHeader($where,'paymentID','DESC',0,1);
	    return $result[0]['paymentID'];
	}

	
	/**
	 * getTotalAmount() - this will get the total amount of the specific payment
	 *
	 * @param unknown_type $subjArray
	 */
	function getTotalAmount($subjArray)
	{
	    $total = 0;
	    if ($subjArray) {
            foreach ($subjArray as $row) {
                $total += $row['totalAmount'];
            }
	    }
	    return $total;
	}
	
	/**
	 * isExist() - function to check the OR Series No. is already exist
	 *
	 * @param string $fiscalYear
	 * @param string $firstORNO
	 * @param string $lastORNO
	 * @return bool 
	 */
	function isExist($orno)
	{
	    if ($orno) {
    	    // setting conditions
    	    $conds[]['orno'] = " = '$orno' ";
    	    
    	    // building an insert query
    	    $this->tables = "orheader";
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
	
	
	
	function getRegistrationPayment($idno, $schYear) 
	{
	  $config = new Config();
	  $registrationCode=$config->getConfig('Reg Account Code Elem');
	  //AND orheader.term =0
      $query = "SELECT
                    orheader.schYear
                    , orheader.term
                    , ordetails.account_code
                    , ordetails.amount
                    , orheader.rstatus
                    , orheader.idno
                    , orheader.paymentID
                FROM
                    ordetails
                    INNER JOIN orheader 
                        ON (ordetails.orno = orheader.orno)
                WHERE (orheader.schYear ='$schYear'
                    AND ordetails.account_code ='$registrationCode'
                    AND orheader.rstatus =1
                    AND orheader.idno ='$idno')
                ORDER BY orheader.paymentID DESC";
	    $this->reset();            // reset all variables in query generator

		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
    		$data = array();
    		$ctr = 0;
    		foreach ($records as $row) {
    		    $data[$ctr] = $row['amount'];
    		    $ctr++;
    		}
    		
    		return $data;
    		
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return 0;
		}
	}
	
	
	
}
?>