<?php
/**
 *
 * Filename: EnrollmentCol.php
 * Date: 	 March 3, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */


/**
 * Class: Enrollment
 * Description: This class is a model of the object - Enrollment
 * 				Implementing the active record pattern of database record
 */

class Enrollment extends Database 
{
	var $enID;
	var $schYear;
	var $semCode;
	
	var $idno;
	var $lname;
	var $fname;
	var $mname;
	
	var $curID;
	var $curName;
	
	var $courseID;
	var $courseCode;
	
	var $yrLevel;
	var $dateCreated;
	
	var $encodedBy;
	var $encodedName;
	
	var $lastEdited;
	var $studType;
	var $rstatus;
	
	var $secID;
	var $secName;
	
	var $ttlUnits;
	var $subjs;
	
	var $totalRecords;
	
	
	/**
	 * Enrollment() constructor of the Enrollment class
	 *
	 * @return Enrollment
	 */
	function Enrollment($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->enID = $id;
			$this->retrieveEnrollment();
		}
	}
	
	
    /**
     * createEnrollment() method to save the Enrollment record
     *
     * @return bool - return true if successful otherwise false
     */
	function createEnrollment() 
	{
	    // setting values to fields
	    $info['idno']       = $this->idno;
    	$info['schYear']    = $this->schYear;
    	$info['semCode']    = $this->semCode;
    	
    	
    	$info['studType']   = $this->studType;
    	
    	$info['curID']      = $this->curID;
    	$info['courseID']   = $this->courseID;
    	$info['yrLevel']    = $this->yrLevel;
    	$info['secID']      = $this->secID;
    	
    	$info['dateCreated']= $this->dateCreated;
    	$info['ttlUnits']   = $this->ttlUnits;
    	$info['encodedBy']  = $this->encodedBy;
		
		// building an insert query
        $this->tables = "enrollments";
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
	 * retrieveEnrollment() method to retrieve the Enrollment record and assign to the Enrollment attributes
	 *
	 */
	function retrieveEnrollment($lock='0')
	{
	    // setting conditions
	    $conds[0]['enID'] = " = '".$this->enID."'";
	    
	    // building an insert query
	    $this->tables = "enrollments";
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
    	            $this->idno        = $data[0]['idno'];
    	            $stud = new Student($this->idno);
    	            $this->lname       = $stud->lname;
    	            $this->fname       = $stud->fname;
    	            $this->mname       = $stud->mname;
    	            
    	            $this->schYear     = $data[0]['schYear'];
    	            $this->courseID    = $data[0]['courseID'];
    	            $this->yrLevel     = $data[0]['yrLevel'];
    	            $this->semCode     = $data[0]['semCode'];
    	            $this->studType    = $data[0]['studType'];
    	            
    	            $this->ttlUnits    = $data[0]['remarks'];
    	            $this->encodedBy   = $data[0]['preparedBy'];
    	            $this->dateCreated = $data[0]['dateCreated'];
    	            $this->lastEdited  = $data[0]['lastEdited'];
    	            
    	            $this->curID       = $data[0]['curID'];
        		    $cur = new Curriculum($this->curID);
                	$this->curName     = $cur->curName;
                	
                	$this->courseID    = $data[0]['courseID'];
                	
                	$course = new Course($this->courseID);
                	$this->courseCode  = $course->courseCode;               	
                	
                	$this->encodedBy   = $data[0]['encodedBy'];
                	$u = new User2($this->encodedBy);
                	$this->encodedName = htmlentities($u->last_name)." ,".htmlentities($u->first_name);
                	
                	if ($data[0]['secID']) {
                	   $section = new BlockSection($data[0]['secID']);
                	   
                	   $this->secID   = $data[0]['secID'];
                	   $this->secName = $section->secName;
                	}
                	
                    $this->rstatus     = $data[0]['rstatus'];
                    
                    $enDetails = new EnrollmentDetail();

                    $conds[0]['enID']   = " = '".$this->enID."'";
                    $this->subjs=$enDetails->retrieveAllEnrollmentDetails($conds);
                    
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
	 * updateEnrollment() method to update the Enrollment record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateEnrollment()
	{
	    // setting values to fields
        $info['schYear']    = $this->schYear;
    	$info['semCode']    = $this->semCode;
    	$info['idno']       = $this->idno;
    	
    	$info['curID']      = $this->curID;
    	$info['courseID']   = $this->courseID;
    	$info['yrLevel']    = $this->yrLevel;
    	
    	$info['dateCreated']= $this->dateCreated;
    	$info['ttlUnits']   = $this->ttlUnits;
    	$info['encodedBy']  = $this->encodedBy;
		
		// setting conditions
		$conds[]['enID']  = " = '".$this->enID."'";
		
		// building an insert query
        $this->tables = "enrollments";
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
	 * deleteEnrollment() method to delete the Enrollment record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteEnrollment()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['enID']   = " = '".$this->enID."'";
	    $fields['rstatus'] = "0";
	    
	    // building an insert query
	    $this->tables = "enrollments";
	    $this->conds  = $conds;
	    $this->fields = $fields;
	    
	    // building an select query
	    $query = $this->Delete();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
	    
	    // for subject details
	    $this->tables = "enrollment_details";
	    $this->conds  = $conds;
	    $this->fields = $fields;
	    
	    // building an select query
	    $query_details = $this->Delete();  // generate delete sql query
	    $this->reset();                    // reset all variables in query generator
	    
	    // check if building query is successful
		if ( empty($this->errs) ) {
    	    try { 
    		    $this->db->beginTransaction();
        		$this->db->exec($query);
        		$this->db->exec($query_details);
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
	 * deleteEnrollment() method to delete the Enrollment record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function withdrawEnrollment()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['enID']   = " = '".$this->enID."'";
	    $fields['rstatus'] = "0";
	    
	    // building an insert query
	    $this->tables = "enrollments";
	    $this->conds  = $conds;
	    $this->fields = $fields;
	    
	    // building an select query
	    $query = $this->Update();  // generate update sql query
	    $this->reset();            // reset all variables in query generator
	    
	    // for subject details
	    $this->tables = "enrollment_details";
	    $this->conds  = $conds;
	    $this->fields = $fields;
	    
	    // building an select query
	    $query_details = $this->Update();  // generate update sql query
	    $this->reset();                    // reset all variables in query generator
	    
	    // check if building query is successful
		if ( empty($this->errs) ) {
    	    try { 
    		    $this->db->beginTransaction();
        		$this->db->exec($query);
        		$this->db->exec($query_details);
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
	function retrieveAllEnrollments($where='',$orderby='enrollments.schYear', $sorting='DESC', $offset=0, $limit='')
	{
		// building an select query
		if ($orderby!='enrollments.enID') {
    		$multiOrder['students.lname']      = "ASC";
    		$multiOrder['students.fname']      = "ASC";
    		$multiOrder['enrollments.schYear'] = "DESC";
    		$multiOrder['enrollments.semCode'] = "DESC";
    		
    		$this->multi_orders = $multiOrder;
		} else {
    		$this->order  = $orderby;
    	    $this->sorting= $sorting;    
		}
		
		$tables[] = "enrollments";
		$tables[] = "students";
		
		if (count($where[0])) {
		    $where[0]['AND students.idno'] = "= enrollments.idno ";
		} else {
		    $where[0]['students.idno'] = "= enrollments.idno ";
		}
		
		$flds['enrollments.*']  = "";
		$flds['students.lname'] = "";
		$flds['students.fname'] = "";
		$flds['students.mname'] = "";
		$flds['students.gender'] = "";
		
	    $this->tables = $tables;
	    $this->fields = $flds;
	    $this->conds  = $where;
	    
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
    		foreach ($records as $row) {
    		    $course->courseID = $row['courseID'];
    		    $course->retrieveCourse();

    		    $u->id = $row['encodedBy'];
    		    $u->retrieveUser();

    		    $data[$ctr] = $row;
    		    $data[$ctr]['courseCode']  = $course->courseCode;
    		    $data[$ctr]['encodedName'] = $u->last_name." ,".$u->first_name;

    		    $ctr++;
    		}
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	
	function getTotalEnrolledUnits($idno, $schYear, $semCode)
	{
		// building an select query
	    $where[0]['idno'] = "= '$idno' AND ";
	    $where[0]['schYear'] = "= '$schYear' AND ";
	    $where[0]['semCode'] = "= '$semCode' AND ";
	    $where[0]['rstatus'] = ">0 ";
		
		$flds['ttlUnits']  = "";
		
	    $this->tables = "enrollments";
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
    		foreach ($records as $row) {
				return $row['ttlUnits'];    			
    		}
    		
    		return 0;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return 0;
		}
	}
	
	
	function getTotalEnrolledUnitsCompSubj($idno, $schYear, $semCode)
	{
		// building an select query
	    $query = "SELECT
				    sum(subjects.units) as ttl
				FROM
				    enrollment_details
				    INNER JOIN enrollments 
				        ON (enrollment_details.enID = enrollments.enID)
				    INNER JOIN subjects 
				        ON (enrollment_details.subjID = subjects.subjID)
				WHERE (enrollments.idno ='$idno'
				    AND enrollments.schYear ='$schYear'
				    AND enrollments.semCode ='$semCode'
				    AND enrollments.rstatus >0
				    AND subjects.isCompSubj =1)
				GROUP BY enrollments.idno";
	    
		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		foreach ($records as $row) {
				return $row['ttl'];    			
    		}
    		
    		return 0;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return 0;
		}
	}
	
	/**
	 * countAllEnrollments() method to retrieve all/selected Enrollment records
	 *
	 * @param array $where
	 * @param int $offset
	 * @param int $limit
	 * @return array total records
	 */
	function countAllEnrollments($where='', $offset=0, $limit='')
	{
		// building an select query
		$tables[] = "enrollments";
		$tables[] = "students";
		
		if (count($where[0])) {
		    $where[0]['AND students.idno'] = "= enrollments.idno ";
		} else {
		    $where[0]['students.idno'] = "= enrollments.idno ";
		}
		
		$flds['count(students.lname) as ttl_record'] = "";
		
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
    		if ($records) {
    		    return $records[0]['ttl_record'];
    		}
    		return 0;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	/**
	 * isExist() - function to check the Enrollment name is already exist
	 *
	 * @param string $name
	 * @return bool 
	 */
	function isExist($idno, $schYear, $semCode)
	{
	    if ($idno && $schYear && $semCode) {
    	    // setting conditions
    	    $conds[]['idno']  = " = '$idno' AND ";
    	    $conds[]['schYear']  = " = '$schYear' AND ";
    	    $conds[]['semCode']  = " = '$semCode' AND ";
    	    $conds[]['rstatus']  = " > 0 ";
    	    
    	    // building an insert query
    	    $this->tables = "enrollments";
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
                        // return true - the enrollment is already exist            		
                		return 1;
                	} else {
                	    // return false - the enrollment does not exist
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
	
	/**
	 * getTotalUnits() - this will get the total units of the specific term
	 *
	 * @param unknown_type $subjArray
	 */
	function getTotalUnits($subjArray)
	{
	    $total = 0;
	    if ($subjArray) {
            foreach ($subjArray as $row) {
                $total += $row['units'];
            } 
	    }
	    
	    return $total;
	}
	
	/**
	 * getLastID() -  this will get the last ID
	 *
	 * @return unknown
	 */
	function getLastID() 
	{
	    $where[0]['enrollments.idno']	 = "= '".$this->idno."' AND ";
	    $where[0]['enrollments.schYear'] = "= '".$this->schYear."' AND ";
	    $where[0]['enrollments.semCode'] = "= '".$this->semCode."' AND ";
	    $where[0]['enrollments.rstatus'] = "= '1' ";
	    $result = $this->retrieveAllEnrollments($where,'enrollments.enID','DESC',0,1);

	    return $result[0]['enID'];
	}
	
	
	/**
	 * validateEnrollment() - this function will update the status of the enrollment to validated
	 *
	 * @return unknown
	 */
	function validateEnrollment() 
	{
        $where[0]['enID'] = "='".$this->enID."'";
		$info['rstatus']  = "2";
		
		// building an insert query
        $this->tables = "enrollments";
		$this->fields = $info;
		$this->conds  = $where;
		
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
	
	function devalidateEnrollment() 
	{
        $where[0]['enID'] = "='".$this->enID."'";
		$info['rstatus']  = "1";
		
		// building an insert query
        $this->tables = "enrollments";
		$this->fields = $info;
		$this->conds  = $where;
		
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
     * isConflict() - method that will check is the newly added sched is conflict to the existing
     *
     * @param array $target
     * @param array $scheds
     * @return integer [1|0] 
     */
    function isConflict($target, $scheds)
    {
        // convert to array
        $target['days']=array();
        if ($target['onMon']) {
            $target['days'][] = "M";
        }
        
        if ($target['onTue']) {
            $target['days'][] = "T";
        }
        
        if ($target['onWed']) {
            $target['days'][] = "W";
        }
        
        if ($target['onThu']) {
            $target['days'][] = "TH";
        }
        
        if ($target['onFri']) {
            $target['days'][] = "F";
        }
        
        if ($target['onSat']) {
            $target['days'][] = "Sat";
        }
        
        if ($target['onSun']) {
            $target['days'][] = "Sun";
        }
        
        
        // convert days into arrays
        for($i=0;$i<count($scheds);$i++) {
            $scheds[$i]['days']=array();
            if ($scheds[$i]['onMon']) {
                $scheds[$i]['days'][] = "M";
            }
            
            if ($scheds[$i]['onTue']) {
                $scheds[$i]['days'][] = "T";
            }
            
            if ($scheds[$i]['onWed']) {
                $scheds[$i]['days'][] = "W";
            }
            
            if ($scheds[$i]['onThu']) {
                $scheds[$i]['days'][] = "TH";
            }
            
            if ($scheds[$i]['onFri']) {
                $scheds[$i]['days'][] = "F";
            }
            
            if ($scheds[$i]['onSat']) {
                $scheds[$i]['days'][] = "Sat";
            }
            
            if ($scheds[$i]['onSun']) {
                $scheds[$i]['days'][] = "Sun";
            }
        }
        
        
        $targetStartTime = strtotime($target['start']);
        $targetEndTime   = strtotime($target['end'] );
        
        $isConflict = 0;
        
        for($i=0;$i<count($scheds);$i++) {
            $startTime = strtotime($scheds[$i]['startdTime']);
            $endTime   = strtotime($scheds[$i]['enddTime']);
            
            if ( count(array_diff($scheds[$i]['days'],$target['days'])) < count($scheds[$i]['days']) ) {
                // check for conflict in start time
                if ($targetStartTime>=$startTime && $targetStartTime<$endTime) {
                    $isConflict=1;
                }
                
                // check for conflict in end time
                if ($targetEndTime>$startTime && $targetEndTime<=$endTime) {
                    $isConflict=1;
                }
                
                // check for conflict in end time
                if ($targetStartTime<$startTime && $targetEndTime>$endTime) {
                    $isConflict=1;
                }
                
            }
        }
        
        return $isConflict;
    }

	
	
}

?>