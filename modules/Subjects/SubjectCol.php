<?php
/**
 * Edited
 * Filename: Subject.php
 * Date: 	 Februay 4, 2008
 * 
 * Author: 	 Rafie D. Paculaba
 * 
 */


/**
 * Class: Subject
 * Description: This class is a model of the object - Subject
 * 				Implementing the active record pattern of database record
 */

class Subject extends Database 
{
	
	var $subjID;
	var $courseID;
	var $courseCode;
	
	var $yrLevel;
	
	var $subjCode;
	var $descTitle;
	var $subjDesc;
	
	var $units;
	var $type;  // 1=lec / 2=lab
	var $isCompSubj;  // 0=not comp subj / 1=comp subj
	var $rstatus;
	
	/**
	 * Subject() constructor of the Subject class
	 *
	 * @return Subject
	 */
	function Subject($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level

	    // set active record if found
		if ($id) {
			$this->subjID = $id;
			$this->retrieveSubject();
		}
	}
	
	
    /**
     * createSubject() method to save the course record
     *
     * @return bool - return true if successful otherwise false
     */
	function createSubject() 
	{
	    // setting values to fields
        $info['courseID'] 		= $this->courseID;
/*        $info['yrLevel'] 		= $this->yrLevel;*/
        $info['subjCode']     	= $this->subjCode;
        $info['descTitle']      = $this->descTitle;
        $info['subjDesc']      	= $this->subjDesc;
        $info['units']    		= $this->units;
        $info['type']    		= $this->type;
        $info['isCompSubj']    	= $this->isCompSubj;
		
		// building an insert query
        $this->tables = "subjects";
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
	 * retrieveSubject() method to retrieve the subject record and assign to the registrant attributes
	 *
	 */
	function retrieveSubject($lock='0')
	{
	    // setting conditions
	    $conds[0]['subjID'] = " = ".$this->subjID;
	    
	    // building an insert query
	    $this->tables = "subjects";
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
                    $this->courseID = $data[0]['courseID'];
				    
                    $course = new Course($data[0]['courseID']);
                    $this->courseCode = $course->courseCode;
                    
                    //$this->yrLevel 		= $data[0]['yrLevel'];
                    $this->subjCode     = $data[0]['subjCode'];
                    $this->descTitle    = $data[0]['descTitle'];
                    $this->subjDesc    	= $data[0]['subjDesc'];
                    $this->units    	= $data[0]['units'];
                    $this->type    		= $data[0]['type'];
                    $this->isCompSubj   = $data[0]['isCompSubj'];
                    $this->rstatus    	= $data[0]['rstatus'];
            		
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
	 * updateSubject() method to update the course record with the active subjID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateSubject()
	{
	    // setting values to fields
        $info['courseID'] 	= $this->courseID;
        //$info['yrLevel'] 	= $this->yrLevel;
        $info['subjCode']   = $this->subjCode;
        $info['descTitle']  = $this->descTitle;
        $info['subjDesc']  	= $this->subjDesc;
        $info['units']    	= $this->units;
        $info['type']   	= $this->type;
        $info['isCompSubj'] = $this->isCompSubj;
        $info['rstatus']    = $this->rstatus;
		
		// setting conditions
		$conds[]['subjID']  = " = ".$this->subjID;
		
		// building an insert query
        $this->tables = "subjects";
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
	 * deleteSubject() method to delete the subject record  witht the active subjID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteSubject()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['subjID'] = " = ".$this->subjID;
	    
	    // building an insert query
	    $this->tables = "subjects";
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
	 * retrieveAllSubjects() method to retrieve all/selected subject records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllSubjects($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "subjects";
	    $this->conds  = $where;
	    $this->order  = $orderby;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
		
	    $course = new Course();
		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
    		// Course object instance
    		$data=array();
    		$ctr=0;
    		foreach ($records as $row) {

    		    $course->courseID = $row['courseID'];
    		    $course->retrieveCourse();
				
    		    $data[$ctr] = $row;
    		    $data[$ctr]['courseCode']   = $course->courseCode;
    		
    		    $ctr++;
    		}

    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	function retrieveEquivalence($subjID)
	{
		// building an insert query
		$where[0]['equivalency.subjID']   = " = $subjID and ";
		$where[0]['equivalency.eqSubjID'] = " = subjects.subjID";
		
		$fields['equivalency.eqID, equivalency.eqSubjID, subjects.subjCode, subjects.descTitle'] = "";
		
	    $this->tables = "equivalency, subjects";
	    $this->fields = $fields;
	    $this->conds  = $where;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
		
	    $course = new Course();
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
    		    $ctr++;
    		}

    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}

	/**
	 * countAllSubjects() method to retrieve all/selected subject records
	 *
	 * @param array $where
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function countAllSubjects($where='', $offset=0, $limit='')
	{
		// building an insert query
		$flds['count(subjID) as ttl_record']  = "";
		
	    $this->tables = "subjects";
	    $this->conds  = $where;
	    $this->fields = $flds;
	    $this->order  = $orderby;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
		
	    $course = new Course();
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

	    $where[0]['courseID'] = "= '".$this->courseID."' AND ";
	    $where[0]['subjCode'] = "= '".$this->subjCode."' AND ";
	    $where[0]['type'] = "= '".$this->type."' AND ";
	    $where[0]['rstatus'] = "= '1'";
	    
	    $result = $this->retrieveAllSubjects($where,'subjID','DESC',0,1);
	    
	    return $result[0]['subjID'];
	}	
	
	/**
	 * isExist() - function to check the subjCode is already exist
	 *
	 * @param string $lname??
	 * @param string $fname??
	 * @param string $mname??
	 * @return bool 
	 */
	function isExist($courseID, $subjCode, $type)
	{
	    if ($courseID && $subjCode && $type) {
    	    // setting conditions
    	    $conds[0]['courseID'] = " = '$courseID' AND ";
    	    $conds[0]['subjCode'] = " = '$subjCode' AND ";
    	    $conds[0]['type'] = " = '$type' AND ";
    	    $conds[0]['rstatus'] = " = 1";

    	    // building an insert query
    	    $this->tables = "subjects";
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
    		    return -1;
    		}
	    } else {
	        return -1;
	    }
	    
	}
	
}
?>