<?php
/**
 *
 * Filename: CurriculumSubject.php
 * Date: 	 Feb 2, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */


/**
 * Class: CurriculumSubject
 * Description: This class is a model of the object - CurriculumSubject
 * 				Implementing the active record pattern of database record
 */

class CurriculumSubject extends Database 
{
	var $curSubjID;
	var $curID;
	
	var $subjID;
	var $subjCode;

	var $yrLevel;
	var $semCode;
	var $rstatus;
	
	/**
	 * CurriculumSubject() constructor of the CurriculumSubject class
	 * 
	 * @return CurriculumSubject
	 */
	function CurriculumSubject($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->curSubjID = $id;
			$this->retrieveCurriculumSubject();
		}
	}
	
    /**
     * createCurriculumSubject() method to save the CurriculumSubject record
     *
     * @return bool - return true if successful otherwise false
     */
	function createCurriculumSubject() 
	{
	    // setting values to fields
    	$info['curID']   = $this->curID;
    	$info['subjID']  = $this->subjID;
    	$info['yrLevel'] = $this->yrLevel;
    	$info['semCode'] = $this->semCode;
		
		// building an insert query
        $this->tables = "curriculum_subjs";
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
	 * retrieveCurriculumSubject() method to retrieve the CurriculumSubject record and assign to the CurriculumSubject attributes
	 *
	 */
	function retrieveCurriculumSubject($lock='0')
	{
	    // setting conditions
	    $conds[0]['curSubjID'] = " = '".$this->curSubjID."'";
	    
	    // building an insert query
	    $this->tables = "curriculum_subjs";
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
                	$this->curID   = $data[0]['curID'];
                	$this->subjID  = $data[0]['subjID'];
                	
                	$subj = new Subject($this->subjID);
                	$this->subjCode= $subj->subjCode;
                	
                	$this->yrLevel = $data[0]['yrLevel'];
                	$this->semCode = $data[0]['semCode'];
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
	 * updateCurriculumSubject() method to update the CurriculumSubject record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateCurriculumSubject()
	{
	    // setting values to fields
    	$info['curID']   = $this->curID;
    	$info['subjID']  = $this->subjID;
    	$info['yrLevel'] = $this->yrLevel;
    	$info['semCode'] = $this->semCode;
        $info['rstatus'] = $this->rstatus;
		
		// setting conditions
		$conds[]['curSubjID']  = " = '".$this->curSubjID."'";
		
		// building an insert query
        $this->tables = "curriculum_subjs";
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
	 * deleteCurriculumSubject() method to delete the CurriculumSubject record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteCurriculumSubject()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['curSubjID'] = " = '".$this->curSubjID."'";
	    
	    // building an insert query
	    $this->tables = "curriculum_subjs";
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
	 * retrieveAllCurriculumSubjects() method to retrieve all/selected CurriculumSubject records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllCurriculumSubjects($where='',$orderby='yrLevel', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "curriculum_subjs";
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
	    $course = new Course();
	    $u = new User2();
	    
		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
    		// Course object instance
    		$data=array();
    		$ctr=0;
		    $subj = new Subject();
    		foreach ($records as $row) {
    		    $subj->subjID = $row['subjID'];
    		    $subj->retrieveSubject();
    		    
    		    $data[$ctr] = $row;
    		    $data[$ctr]['subjCode']  = $subj->subjCode;
    		    $data[$ctr]['descTitle'] = $subj->descTitle;
    		    $data[$ctr]['units']     = $subj->units;
    		    
    		    $prereq=$this->getPrerequisites($row['curID'], $row['subjID']);
    		    
    		    $data[$ctr]['prerequisitesID']   = !empty($prereq['prerequisitesID'])? $prereq['prerequisitesID']:"";
    		    $data[$ctr]['prerequisites'] = !empty($prereq['prerequisitesCode'])?  $prereq['prerequisitesCode']:"";
    		    
    		    $ctr++;
    		}
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	/**
	 * isExist() - function to check the CurriculumSubject name is already exist
	 *
	 * @param number $curID
	 * @param number $subjID
	 * @return bool 
	 */
	function isExist($curID, $subjID)
	{
	    if ($curID && $subjID) {
    	    // setting conditions
    	    $conds[]['curID']  = " = '$curID' AND ";
    	    $conds[]['subjID'] = " = '$subjID'";
    	    
    	    // building an insert query
    	    $this->tables = "curriculum_subjs";
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
                        // return true - the idno is already exist            		
                		return true;
                	} else {
                	    // return false - the idno does not exist
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
	
	function getPrerequisites($curID, $subjID)
	{
	    if ($curID && $subjID) {
	        $conds[]['curID']  = "='$curID' AND ";
	        $conds[]['subjID'] = "='$subjID'";
	        
	        $prereq=new Prerequisite();
	        
	        $allPrerequisites=$prereq->retrieveAllPrerequisites($conds);
	        
	        if ($allPrerequisites) {
	            $ctr=0;
	            $total_pre = count($allPrerequisites);
	            $thePrerequisitesID   = "";
	            $thePrerequisitesCode = "";
	            foreach ($allPrerequisites as $row) {
                    $thePrerequisitesID   .= $row['preSubjID'];
                    $thePrerequisitesCode .= $row['preSubjCode'];
                    
                    $ctr++;
                    if ($ctr<$total_pre) {
                        $thePrerequisitesID   .= ",";
                        $thePrerequisitesCode   .= ",";
                    }
	            }
	            
	            $prereqCombo['prerequisitesID']   = $thePrerequisitesID;
	            $prereqCombo['prerequisitesCode'] = $thePrerequisitesCode;
	        }
	    }
	    
	    return $prereqCombo;
	}
	
  
	
}
?>