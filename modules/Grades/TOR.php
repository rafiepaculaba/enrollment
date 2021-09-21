<?php
/**
 *
 * Filename: TOR.php
 * Date: 	 Feb 11, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */


/**
 * Class: TOR
 * Description: This class is a model of the object - TOR
 * 				Implementing the active record pattern of database record
 */

class TOR extends Database 
{
	var $torID;
	var $recID;
	var $idno;
	var $endID;
	var $oendID;
	var $creID;
	var $schYear;
	var $semCode;
	var $yrLevel;
	
	var $subjID;
	var $subjCode;
	var $descTitle;
	var $units;
	
	var $fgrade;
	var $rstatus;
	
	
	/**
	 * TORs() constructor of the TORs class
	 * 
	 * @return TORs
	 */
	function TOR($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->torID = $id;
			$this->retrieveTOR();
		}
	}
	
    /**
     * createTORs() method to save the TORs record
     *
     * @return bool - return true if successful otherwise false
     */
	function createTOR() 
	{
	    // setting values to fields
    	$info['idno']    = $this->idno;
    	if ($this->endID)
    	   $info['endID']   = $this->endID;
        
        if ($this->oendID)
    	   $info['oendID']  = $this->oendID;
    	   
        if ($this->creID)
    	   $info['creID']   = $this->creID;
    	   
    	$info['schYear'] = $this->schYear;
    	$info['semCode'] = $this->semCode;
    	$info['yrLevel'] = $this->yrLevel;
    	$info['subjID']  = $this->subjID;
    	
    	if (is_numeric($this->fgrade)) {
    		$info['fgrade']  = number_format($this->fgrade,1);
    	} else {
    		$info['fgrade']  = $this->fgrade;
    	}
    	
		// building an insert query
        $this->tables = "tor";
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
	 * retrieveTORs() method to retrieve the TORs record and assign to the TORs attributes
	 *
	 */
	function retrieveTOR($lock='0')
	{
	    // setting conditions
	    $conds[0]['torID'] = " = '".$this->torID."'";
	    
	    // building an insert query
	    $this->tables = "tor";
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
                	$this->torID   = $data[0]['torID'];
                	$this->recID   = $data[0]['recID'];
                	$this->idno    = $data[0]['idno'];
                	$this->endID   = $data[0]['endID'];
                	$this->oendID  = $data[0]['oendID'];
                	$this->creID   = $data[0]['creID'];
                	$this->schYear = $data[0]['schYear'];
                	$this->semCode = $data[0]['semCode'];
                	$this->yrLevel = $data[0]['yrLevel'];
                	$this->fgrade  = $data[0]['fgrade'];
                	$this->subjID  = $data[0]['subjID'];
                	
                	$subj = new Subject($this->subjID);
                	$this->subjCode  = $subj->subjCode;
                	$this->descTitle = $subj->descTitle;
                	$this->units     = $subj->units;
                	
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
     * updateTORs() method to save the TORs record
     *
     * @return bool - return true if successful otherwise false
     */
	function updateTOR() 
	{
	    // setting values to fields
    	$info['idno']    = $this->idno;
    	$info['endID']   = $this->endID;
    	$info['oendID']  = $this->oendID;
    	$info['creID']   = $this->creID;
    	$info['schYear'] = $this->schYear;
    	$info['semCode'] = $this->semCode;
    	$info['yrLevel'] = $this->yrLevel;
    	$info['subjID']  = $this->subjID;
    	$info['fgrade']  = $this->fgrade;
    	$info['rstatus']  = $this->rstatus;
    	
    	// setting conditions
	    $conds[0]['torID'] = " = '".$this->torID."'";
	    
		// building an insert query
        $this->tables = "tor";
		$this->fields = $info;
		$this->conds  = $conds;
		
		$query = $this->Update();     // generate update sql query
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
	 * deleteTORs() method to delete the TORs record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteTOR()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['torID'] = " = '".$this->torID."'";
	    
	    // building an insert query
	    $this->tables = "tor";
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
	 * retrieveAllTORss() method to retrieve all/selected TORs records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllTORs($where='',$orderby='tor.yrLevel', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="tor";
		$tables[]="subjects";
		
		$flds['subjects.subjCode']  = "";
		$flds['subjects.descTitle'] = "";
		$flds['subjects.units']     = "";
		$flds['tor.*']              = "";
		
		
		if ($orderby!="tor.yrLevel") {
		    $multi_order['tor.yrLevel']="ASC";
		    $multi_order['tor.semCode']="ASC";
		    $this->multi_orders = $multi_order;
		} else {
		    $this->order  = $orderby;    
		}
		
		if (count($where[0]))
		  $where[0]['AND tor.subjID'] = "=subjects.subjID";
	    else
		  $where[0]['tor.subjID']     = "=subjects.subjID";
		
	    $this->tables = $tables;
	    $this->fields = $flds;
	    $this->conds  = $where;
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
	
	
	function checkTORs($subjID, $idno)
	{
	    // building an insert query
	    $config = new Config();
	    
	    $failed_grades = $config->getConfig('Failed Grades');
        $failed_grades = explode("," , $failed_grades);
        $grades = "";
        if ($failed_grades) {
            $ctr=0;
            foreach ($failed_grades as $data) {
            	$isNum = false;
            	
                if (is_numeric($data)) {
                    $data1 = $data; 					// actual data
                    $data = number_format($data,1);		// formatted data
                    $isNum = true;
                }
                
                if ($ctr) {
                    $grades .= ",'".trim($data)."'";
                    if ($isNum) {
                    	$grades .= ",'".trim($data1)."'";
                    }
                } else {
                    $grades .= "'".trim($data)."'";
                    if ($isNum) {
                    	$grades .= ",'".trim($data1)."'";
                    }
                }
                
                $ctr++;
            }
        }
        
        unset($where);
        $where[0]['tor.subjID']     = "='$subjID' AND ";
        $where[0]['tor.idno']       = "='$idno' ";
        
        if ($grades) {
            $where[0]['AND tor.fgrade'] = " not in ($grades) ";
        }
	    
		$flds['tor.*']              = "";
		
	    $this->tables = "tor";
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
    		
    		if ($records)
    		  return $records[0]['fgrade'];
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
        
	}
	
	
	function getTOR($idno)
	{
	    // building an insert query
	    $config = new Config();
	    
	    $failed_grades = $config->getConfig('Failed Grades');
        $failed_grades = explode("," , $failed_grades);
        $grades = "";
        if ($failed_grades) {
            $ctr=0;
            foreach ($failed_grades as $data) {
            	$isNum = false;
            	
                if (is_numeric($data)) {
                    $data1 = $data; 					// actual data
                    $data = number_format($data,1);		// formatted data
                    $isNum = true;
                }
                
                if ($ctr) {
                    $grades .= ",'".trim($data)."'";
                    if ($isNum) {
                    	$grades .= ",'".trim($data1)."'";
                    }
                } else {
                    $grades .= "'".trim($data)."'";
                    if ($isNum) {
                    	$grades .= ",'".trim($data1)."'";
                    }
                }
                
                $ctr++;
            }
        }
        
        unset($where);
        $where[0]['tor.idno']       = "='$idno' ";
        
        if ($grades) {
            $where[0]['AND tor.fgrade'] = " not in ($grades) ";
        }
	    
		$flds['tor.*']              = "";
		
	    $this->tables = "tor";
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
    		
		    return $records;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
        
	}
	
	
	function checkEquivalence($targetSubject, $passed_subjects)
	{
    	$query = "select count(subjID) as ret from equivalency where eqSubjID='$targetSubject' and subjID in ($passed_subjects)";
	    
		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
		    return $records[0]['ret'];
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
        
	}
	
	
}
?>