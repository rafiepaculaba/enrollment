<?php
/**
 * Edited
 * Filename: Equivalency.php
 * Date: 	 Feb 14, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: Equivalency
 * Description: This class is a model of the object - Equivalency
 * 				Implementing the active record pattern of database record
 */

class Equivalency extends Database 
{
	
	var $eqID;
	var $curID;
	var $curName;
	
	var $subjID;
	var $subjCode;
	var $subjDescTitle;
	var $subjUnits;
	
	var $eqSubjID;
	var $eqSubjCode;
	var $eqSubjDescTitle;
	var $eqSubjUnits;
	
	var $rstatus;
	
	/**
	 *Equivalency() constructor of the Equivalency class
	 *
	 * @return Equivalency
	 */
	function Equivalency($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->eqID = $id;
			$this->retrieveEquivalency();
		}
	}
	
	
	
    /**
     * createEquivalency() method to save the Equivalency record
     *
     * @return bool - return true if successful otherwise false
     */
	function createEquivalency() 
	{
	    // setting values to fields
        $info['subjID']   = $this->subjID;
        $info['eqSubjID'] = $this->eqSubjID;
		
		// building an insert query
        $this->tables = "equivalency";
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
	 * retrieveEquivalency() method to retrieve the Equivalency record and assign to the Equivalency attributes
	 *
	 */
	function retrieveEquivalency($lock='0')
	{
	    // setting conditions
	    $conds[0]['eqID'] = " = ".$this->eqID;

	    // building an insert query
	    $this->tables = "equivalency";
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
        		
        		
        		$subject = new Subject();
        		if ($data[0]) {
            		$this->curID    = $data[0]['curID'];
            		$curriculum     = new Curriculum($this->curID);
            		$this->curName  = $curriculum->curName;
            		
                    $this->subjID   = $data[0]['subjID'];
                    $subject->subjID= $this->subjID;
                    $subject->retrieveSubject();
                    $this->subjCode      = $subject->subjCode;
                    $this->subjDescTitle = $subject->descTitle;
                    $this->subjUnits     = $subject->units;
                    
                    $this->eqSubjID = $data[0]['eqSubjID'];
                    $subject->subjID= $this->eqSubjID;
                    $subject->retrieveSubject();
                    $this->eqSubjCode      = $subject->subjCode;
                    $this->eqSubjDescTitle = $subject->descTitle;
                    $this->eqSubjUnits     = $subject->units;
                    
                    $this->rstatus  = $data[0]['rstatus'];
            		
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
	 * updateEquivalency() method to update the Equivalency record with the active deptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateEquivalency()
	{
	    // setting values to fields
        $info['curID']    = $this->curID;
        $info['subjID']   = $this->subjID;
        $info['eqSubjID'] = $this->eqSubjID;
        $info['rstatus']  = $this->rstatus;
		
		// setting conditions
		$conds[]['eqID']  = " = '".$this->eqID."'";
		
		// building an insert query
        $this->tables = "equivalency";
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
	 * deleteEquivalency() method to delete the Equivalency record  witht the active DeptID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteEquivalency()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['eqID'] = " = '".$this->eqID."'";
	    
	    // building an insert query
	    $this->tables = "equivalency";
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
	 * retrieveAllEquivalencys() method to retrieve all/selected Equivalency records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllEquivalency($where='',$orderby='s.subjCode', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[] = "equivalency e";
		$tables[] = "subjects s";
		
		$fields['e.*'] = "";
		$fields['s.subjCode']  = "";
		$fields['s.descTitle'] = "";
		
	    $this->tables = $tables;
	    $this->conds  = $where;
	    $this->fields = $fields;
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
	 * getLastID() method to retrieve last insertet deptID
	 *
	 * @return deptID
	 */
	function getLastID() 
	{
	    $where[0]['e.curID']     = "= '".$this->curID."' AND ";
	    $where[0]['e.subjID']    = "= '".$this->subjID."' AND ";
	    $where[0]['e.eqSubjID']  = "= '".$this->eqSubjID."' AND ";
	    $where[0]['e.rstatus']  = "= 1";
	    
	    $result = $this->retrieveAllEquivalency($where,'eqID','DESC',0,1);
	    
	    return $result[0]['eqID'];
	}	
	
	
	/**
	 * isExist() - function to check the Equivalency deptID is already exist
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
    	    $this->tables = "Equivalencyurations";
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
                        // return true - the Equivalency is already exist            		
                		return true;
                	} else {
                	    // return false - the Equivalency does not exist
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