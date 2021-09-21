<?php
/**
 *
 * Filename: Prerequisite.php
 * Date: 	 Feb 11, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */


/**
 * Class: Prerequisite
 * Description: This class is a model of the object - Prerequisite
 * 				Implementing the active record pattern of database record
 */

class Prerequisite extends Database 
{
	var $preID;
	var $curID;
	var $subjID;
	var $subjCode;
	
	var $preSubjID;
	var $preSubjCode;
	var $rstatus;
	
	/**
	 * Prerequisites() constructor of the Prerequisites class
	 * 
	 * @return Prerequisites
	 */
	function Prerequisite($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->preID = $id;
			$this->retrievePrerequisite();
		}
	}
	
    /**
     * createPrerequisites() method to save the Prerequisites record
     *
     * @return bool - return true if successful otherwise false
     */
	function createPrerequisite() 
	{
	    // setting values to fields
    	$info['preID']     = $this->preID;
    	$info['curID']     = $this->curID;
    	$info['subjID']    = $this->subjID;
    	$info['preSubjID'] = $this->preSubjID;
		
		// building an insert query
        $this->tables = "prerequisites";
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
	 * retrievePrerequisites() method to retrieve the Prerequisites record and assign to the Prerequisites attributes
	 *
	 */
	function retrievePrerequisite($lock='0')
	{
	    // setting conditions
	    $conds[0]['preID'] = " = '".$this->preID."'";
	    
	    // building an insert query
	    $this->tables = "prerequisites";
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
                	
                	// get the subjCode of the prerequisite
                	$this->preSubjID = $data[0]['preSubjID'];
                	$subj->subjID = $this->preSubjID;
                	$subj->retrieveSubject();
                	$this->preSubjCode = $subj->subjCode;
                	
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
	 * deletePrerequisites() method to delete the Prerequisites record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deletePrerequisite()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['preID'] = " = '".$this->preID."'";
	    
	    // building an insert query
	    $this->tables = "prerequisites";
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
	 * retrieveAllPrerequisitess() method to retrieve all/selected Prerequisites records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllPrerequisites($where='',$orderby='subjID', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "prerequisites";
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
    		$data = array();
    		$ctr=0;
		    $subj = new Subject();
    		foreach ($records as $row) {
    		    $subj->subjID = $row['subjID'];
    		    $subj->retrieveSubject();
    		    
    		    $data[$ctr] = $row;
    		    $data[$ctr]['subjCode']  = $subj->subjCode;
    		    
    		    $subj->subjID = $row['preSubjID'];
    		    $subj->retrieveSubject();
    		    $data[$ctr]['preSubjCode']  = $subj->subjCode;
    		    
    		    $ctr++;
    		}
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	
	function getAllPrerequisites($subjID, $curID)
	{
		// building an insert query
		$where[0]['curID']   = "='".$curID."' AND ";
        $where[0]['subjID']  = "='$subjID' AND ";
        $where[0]['rstatus'] = "= 1 ";
		
	    $this->tables = "prerequisites";
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
    		$data = array();
    		$ctr=0;
		    $subj = new Subject();
    		foreach ($records as $row) {
    		    $subj->subjID = $row['subjID'];
    		    $subj->retrieveSubject();
    		    
    		    $data[$ctr] = $row;
    		    $data[$ctr]['subjCode']  = $subj->subjCode;
    		    
    		    $subj->subjID = $row['preSubjID'];
    		    $subj->retrieveSubject();
    		    $data[$ctr]['preSubjCode']  = $subj->subjCode;
    		    
    		    $ctr++;
    		}
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	/**
	 * checkPrerequisites method will check all the prerequisite subjects if the student already passed
	 *
	 * @param integer $subjID
	 * @param string $idno
	 * @return unknown 0=ok, passed all prerequisites : string=not ok, returns the subjects not taken/passed yet
	 */
	function checkPrerequisites($subjID, $idno)
	{
	    $config = new Config();
	    $stud   = new Student($idno);
	    $tor    = new TOR();
	    
	    if ($config->getConfig('Check Prerequisite')) {
    	    // get all prerequisite subjects in curriculum
    	    if ($stud->curID) {
    	        $prerequisites = $this->getAllPrerequisites($subjID, $stud->curID);
    	    } else {
    	        // allow to bypass since the student has no curriculum was set yet.
    	        return 0;
    	    }
            
    	    
    	    $prerequisite_not_found = "";

    	    if ($prerequisites) {
                foreach ($prerequisites as $subj) {
                    // check here if not exist and not passed
                    if ( !$tor->checkTORs($subj['preSubjID'],$idno) ) {
                        if ($prerequisite_not_found) {
                            $prerequisite_not_found .= ",".$subj['preSubjCode'];
                        } else {
                            $prerequisite_not_found .= $subj['preSubjCode'];
                        }
                    }
                }
            }
            
            return $prerequisite_not_found;
	    } else {
	        return 0;
	    }
	}
	
	
}
?>