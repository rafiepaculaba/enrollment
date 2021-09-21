<?php
/**
 *
 * Filename: Curriculum.php
 * Date: 	 Feb 2, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */


/**
 * Class: Curriculum
 * Description: This class is a model of the object - Curriculum
 * 				Implementing the active record pattern of database record
 */

class Curriculum extends Database 
{
	
	var $curID;
	var $curName;
	
	var $courseID;
	var $courseCode;
	
	var $effectivity;
	var $major;
	var $remarks;
	var $preparedBy;
	var $preparedName;
	
	var $rstatus;
	
	var $subjects11;
	var $subjects12;
	var $subjects14;
	
	var $subjects21;
	var $subjects22;
	var $subjects24;
	
	var $subjects31;
	var $subjects32;
	var $subjects34;
	
	var $subjects41;
	var $subjects42;
	var $subjects44;
	
	var $subjects51;
	var $subjects52;
	var $subjects54;
	
	/**
	 * Curriculum() constructor of the Curriculum class
	 *
	 * @return Curriculum
	 */
	function Curriculum($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->curID = $id;
			$this->retrieveCurriculum();
		}
	}
	
	
	
    /**
     * createCurriculum() method to save the Curriculum record
     *
     * @return bool - return true if successful otherwise false
     */
	function createCurriculum() 
	{
	    // setting values to fields
    	$info['curName']    = $this->curName;
    	$info['courseID']   = $this->courseID;
    	$info['effectivity']= $this->effectivity;
    	$info['major']      = $this->major;
    	$info['remarks']    = $this->remarks;
    	$info['preparedBy'] = $this->preparedBy;
		
		// building an insert query
        $this->tables = "curriculums";
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
	 * retrieveCurriculum() method to retrieve the Curriculum record and assign to the Curriculum attributes
	 *
	 */
	function retrieveCurriculum($lock='0')
	{
	    // setting conditions
	    $conds[0]['curID'] = " = '".$this->curID."'";
	    
	    // building an insert query
	    $this->tables = "curriculums";
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
                	$this->curName     = $data[0]['curName'];
                	$this->courseID    = $data[0]['courseID'];
                	
                	$course = new Course($this->courseID);
                	$this->courseCode  = $course->courseCode;               	
                	
                	$this->effectivity = $data[0]['effectivity'];
                	$this->major       = $data[0]['major'];
                	$this->remarks     = $data[0]['remarks'];
                	
                	$this->preparedBy  = $data[0]['preparedBy'];
                	$u = new User2($this->preparedBy);
                	$this->preparedName= $u->last_name." ,".$u->first_name;
                	
                    $this->rstatus     = $data[0]['rstatus'];
                    
                    $curSubj = new CurriculumSubject();

                    $conds[0]['curID']   = " = '".$this->curID."' AND ";
                    
                    // get all subjects 1yr - 1st sem
                    $conds[0]['yrLevel'] = " = '1' AND ";
                    $conds[0]['semCode'] = " = '1' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects11=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 1yr - 2nd sem
                    $conds[0]['yrLevel'] = " = '1' AND ";
                    $conds[0]['semCode'] = " = '2' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects12=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 1yr - summer
                    $conds[0]['yrLevel'] = " = '1' AND ";
                    $conds[0]['semCode'] = " = '4' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects14=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 2yr - 1st sem
                    $conds[0]['yrLevel'] = " = '2' AND ";
                    $conds[0]['semCode'] = " = '1' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects21=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 2yr - 2nd sem
                    $conds[0]['yrLevel'] = " = '2' AND ";
                    $conds[0]['semCode'] = " = '2' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects22=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 2yr - summer
                    $conds[0]['yrLevel'] = " = '2' AND ";
                    $conds[0]['semCode'] = " = '4' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects24=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 3yr - 1st sem
                    $conds[0]['yrLevel'] = " = '3' AND ";
                    $conds[0]['semCode'] = " = '1' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects31=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 3yr - 2nd sem
                    $conds[0]['yrLevel'] = " = '3' AND ";
                    $conds[0]['semCode'] = " = '2' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects32=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 3yr - summer
                    $conds[0]['yrLevel'] = " = '3' AND ";
                    $conds[0]['semCode'] = " = '4' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects34=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 4yr - 1st sem
                    $conds[0]['yrLevel'] = " = '4' AND ";
                    $conds[0]['semCode'] = " = '1' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects41=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 4yr - 2nd sem
                    $conds[0]['yrLevel'] = " = '4' AND ";
                    $conds[0]['semCode'] = " = '2' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects42=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 4yr - summer
                    $conds[0]['yrLevel'] = " = '4' AND ";
                    $conds[0]['semCode'] = " = '4' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects44=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 5yr - 1st sem
                    $conds[0]['yrLevel'] = " = '5' AND ";
                    $conds[0]['semCode'] = " = '1' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects51=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 5yr - 2nd sem
                    $conds[0]['yrLevel'] = " = '5' AND ";
                    $conds[0]['semCode'] = " = '2' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects52=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
                    // get all subjects 5yr - summer
                    $conds[0]['yrLevel'] = " = '5' AND ";
                    $conds[0]['semCode'] = " = '4' AND ";
                    $conds[0]['rstatus'] = " = 1 ";
                    $this->subjects54=$curSubj->retrieveAllCurriculumSubjects($conds);
                    
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
	 * updateCurriculum() method to update the Curriculum record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateCurriculum()
	{
	    // setting values to fields
    	$info['curName']    = $this->curName;
    	$info['courseID']   = $this->courseID;
    	$info['effectivity']= $this->effectivity;
    	$info['major']      = $this->major;
    	$info['remarks']    = $this->remarks;
    	$info['preparedBy'] = $this->preparedBy;
        $info['rstatus']    = $this->rstatus;
		
		// setting conditions
		$conds[]['curID']  = " = '".$this->curID."'";
		
		// building an insert query
        $this->tables = "curriculums";
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
	 * deleteCurriculum() method to delete the Curriculum record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteCurriculum()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['curID'] = " = '".$this->curID."'";
	    
	    // building an insert query
	    $this->tables = "curriculums";
	    $this->conds  = $conds;
	    
	    // building an select query
	    $query = $this->Delete();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
	    
	    // for subject details
	    $this->tables = "curriculum_subjs";
	    $this->conds  = $conds;
	    
	    // building an select query
	    $query_details = $this->Delete();  // generate delete sql query
	    $this->reset();                    // reset all variables in query generator
	    
	    // for subject details
	    $this->tables = "prerequisites";
	    $this->conds  = $conds;
	    
	    // building an select query
	    $query_prerequisites = $this->Delete();  // generate delete sql query
	    $this->reset();                          // reset all variables in query generator
	    
	    
	    // check if building query is successful
		if ( empty($this->errs) ) {
    	    try { 
    		    $this->db->beginTransaction();
        		$this->db->exec($query);
        		$this->db->exec($query_details);
        		$this->db->exec($query_prerequisites);
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
	 * retrieveAllCurriculums() method to retrieve all/selected Curriculum records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllCurriculums($where='',$orderby='curName', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "curriculums";
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
    		foreach ($records as $row) {
    		    $course->courseID = $row['courseID'];
    		    $course->retrieveCourse();

    		    $u->id = $row['preparedBy'];
    		    $u->retrieveUser();

    		    $data[$ctr] = $row;
    		    $data[$ctr]['courseCode']   = $course->courseCode;
    		    $data[$ctr]['preparedName'] = $u->last_name." ,".$u->first_name;

    		    $ctr++;
    		}
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	/**
	 * isExist() - function to check the Curriculum name is already exist
	 *
	 * @param string $name
	 * @return bool 
	 */
	function isExist($name)
	{
	    if ($name) {
    	    // setting conditions
    	    $conds[]['curName'] = " = '$name' ";
    	    
    	    // building an insert query
    	    $this->tables = "curriculums";
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
	    $where[0]['courseID']="= '".$this->courseID."' AND ";
	    $where[0]['curName']="= '".$this->curName."' AND ";
	    $where[0]['effectivity']="= '".$this->effectivity."'";
	    $result = $this->retrieveAllCurriculums($where,'curID','DESC',0,1);

	    return $result[0]['curID'];
	}
	
}

?>