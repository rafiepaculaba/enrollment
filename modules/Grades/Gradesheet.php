<?php
/**
 * Edited
 * Filename: Gradesheet.php
 * Date: 	 March 18, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: GradeSheet
 * Description: This class is a model of the object - GradeSheet
 * 				Implementing the active record pattern of database record
 */

class GradeSheet extends Database 
{
	
	var $gsID;
	var $schYear;
	var $semCode;
	
	var $profID;
	var $profName;
	
	var $schedID;
	var $schedCode;
	var $subjID;
    var $subjCode;
	
	var $units;
	var $remarks;
	
	var $rstatus;
	
	
	/**
	 * GradeSheet() constructor of the GradeSheet class
	 *
	 * @return GradeSheet
	 */
	function GradeSheet($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level

	    // set active record if found
		if ($id) {
			$this->gsID = $id;
			$this->retrieveGradeSheet();
		}
	}
	
	
    /**
     * createGradeSheet() method to save the course record
     *
     * @return bool - return true if successful otherwise false
     */
	function createGradeSheet() 
	{
	    // setting values to fields
        $info['schYear'] 	= $this->schYear;
        $info['semCode'] 	= $this->semCode;
        $info['profID']     = $this->profID;
        $info['schedID']    = $this->schedID;
        $info['units']    	= $this->units;
        $info['remarks']    = $this->remarks;
    	
		// building an insert query
        $this->tables = "grade_sheets";
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
	 * retrieveGradeSheet() method to retrieve the GradeSheet record and assign to the registrant attributes
	 *
	 */
	function retrieveGradeSheet($lock='0')
	{
	    // setting conditions
	    $conds[0]['gsID'] = " = ".$this->gsID;
	    
	    // building an insert query
	    $this->tables = "grade_sheets";
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
                    $this->schYear 	 = $data[0]['schYear'];
                    $this->semCode   = $data[0]['semCode'];
                    $this->profID    = $data[0]['profID'];
                    $this->schedID   = $data[0]['schedID'];
                    $this->units     = $data[0]['units'];
                    $this->remarks   = $data[0]['remarks'];
                    $this->rstatus   = $data[0]['rstatus'];
                    
                    $sched = new Schedule($this->schedID);
                    $this->schedCode = $sched->schedCode;
                    $this->subjID    = $sched->subjID;
                    $this->subjCode  = $sched->subjCode;
                    
                    
                    $user = new User2($this->profID);
                    $this->profName  = htmlentities($user->last_name)." , ".htmlentities($user->first_name);
                    
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
	 * updateGradeSheet() method to update the course record with the active subjID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateGradeSheet()
	{
	    // setting values to fields
        $info['schYear'] 	= $this->schYear;
        $info['semCode'] 	= $this->semCode;
        $info['profID']     = $this->profID;
        $info['schedID']    = $this->schedID;
        $info['units']    	= $this->units;
        $info['remarks']    = $this->remarks;
        $info['rstatus']    = $this->rstatus;
		
		// setting conditions
		$conds[]['gsID']  = " = ".$this->gsID;
		
		// building an insert query
        $this->tables = "grade_sheets";
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
	 * deleteGradeSheet() method to delete the GradeSheet record  witht the active subjID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteGradeSheet()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['gsID'] = " = ".$this->gsID;
	    
	    // building an insert query
	    $this->tables = "grade_sheets";
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
	 * clearGradeSheet() method to clear the GradeSheet record  witht the active subjID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function clearGradeSheet($schedID)
	{
	    // setting conditions
	    $conds[]['schedID'] = " = $schedID";
	    
	    // setting values to fields
        $info['pregrade']       = "";
        $info['mgrade']         = "";
        $info['prefigrade']     = "";
        $info['fgrade'] 	    = "";
		$this->fields = $info;
	    
	    // building an insert query
	    $this->tables = "enrollment_details";
	    $this->conds  = $conds;

	    // building an select query
	    $query = $this->Update();  // generate delete sql query
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
	 * retrieveAllGradeSheets() method to retrieve all/selected GradeSheet records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllGradeSheets($where='',$orderby='schYear', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "grade_sheets";
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
    		
    		if ($records) {
    		    $data=array();
    		    $ctr=0;
    		    $schedule = new Schedule();
    		    $u        = new User2();
    		    
    		    foreach ($records as $row) {
    		        $schedule->schedID = $row['schedID'];
    		        $schedule->retrieveSchedule();
    		        
    		        $u->id = $row['profID'];
    		        $u->retrieveUser();
    		        
    		        $data[$ctr]=$row;
    		        $data[$ctr]['schedCode'] = $schedule->schedCode;
    		        $data[$ctr]['subjCode']  = $schedule->subjCode;
    		        
    		        $ctr++;
    		    }
    		}
    		
    		$this->db->commit();
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	/**
	 * retrieveAllGradeSheets() method to retrieve all/selected GradeSheet records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllGradeSheetsAssociated($where='',$orderby='subjects.subjCode', $sorting='ASC', $offset=0, $limit='',$dept='')
	{
		// building an insert query
		$tables[]="grade_sheets";
		$tables[]="subjects";
		$tables[]="schedules";
		
		if ($dept) {
			$tables[]="courses";
			$tables[]="departments";
		}
		
		$fields['grade_sheets.*']      = "";
		$fields['schedules.schedCode'] = "";
		$fields['subjects.subjCode']   = "";

		if (count($where[0])) {
    		$where[0][' AND grade_sheets.schedID'] = "=schedules.schedID AND ";
    		$where[0]['schedules.subjID'] = "=subjects.subjID";
		} else {
		    $where[0][' grade_sheets.schedID'] = "=schedules.schedID AND ";
    		$where[0]['schedules.subjID'] = "=subjects.subjID";
		}
		
		if ($dept) {
			$where[0]['AND departments.deptCode'] = "='$dept' AND ";
			$where[0]['subjects.courseID'] = "=courses.courseID AND ";
    		$where[0]['courses.deptID'] = "=departments.deptID ";
		}
		
	    $this->tables = $tables;
	    $this->fields = $fields;
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
    		    $data=array();
    		    $ctr=0;
    		    $u        = new User2();
    		    
    		    foreach ($records as $row) {

    		        $u->id = $row['profID'];
    		        $u->retrieveUser();
    		        $data[$ctr]=$row;
    		        $data[$ctr]['profName']  = htmlentities($u->last_name)." , ".htmlentities($u->first_name);
    		        
    		        $ctr++;
    		    }
    		}
    		
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	/**
	 * isExist() - function to check the gradesheet is already exist
	 *
	 * @param string $schYear??
	 * @param string $semCode??
	 * @param string $schedID??
	 * @param string $profID??
	 * @return bool 
	 */
	function isExist($schYear, $semCode, $schedID, $profID)
	{
	    if ($schYear && $semCode && $schedID && $profID) {
    	    // setting conditions
    	    $conds[]['schYear'] = " = '$schYear' AND ";
    	    $conds[]['semCode'] = " = '$semCode' AND ";
    	    $conds[]['schedID'] = " = '$schedID' AND ";
    	    $conds[]['profID']  = " = '$profID' AND ";
    	    $conds[]['rstatus'] = " != 0";

    	    // building an insert query
    	    $this->tables = "grade_sheets";
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
	
	
	function getLastID($schYear, $semCode, $schedID, $profID)
	{
	    if ($schYear && $semCode && $schedID && $profID) {
    	    // setting conditions
    	    $conds[]['schYear'] = " = '$schYear' AND ";
    	    $conds[]['semCode'] = " = '$semCode' AND ";
    	    $conds[]['schedID'] = " = '$schedID' AND ";
    	    $conds[]['profID']  = " = '$profID' AND ";
    	    $conds[]['rstatus'] = " = 1";

    	    // building an insert query
    	    $this->tables = "grade_sheets";
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
                		return $data[0]['gsID'];
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