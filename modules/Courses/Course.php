<?php
/**
 *
 * Filename: Course.php
 * Date: 	 August 15, 2007
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: Course
 * Description: This class is a model of the object - Course
 * 				Implementing the active record pattern of database record
 */

class Course extends Database 
{
	
	var $courseID;
	var $courseCode;
	var $courseName;
	
	var $deptID;
	var $deptCode;
	var $deptName;
	
	var $dean;
	var $remarks;
	var $rstatus;
	
	/**
	 * Course() constructor of the Course class
	 *
	 * @return Course
	 */
	function Course($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
		
	    // set active record if found
		if ($id) {
			$this->courseID = $id;
			$this->retrieveCourse();
		}
	}
	
	
    /**
     * createCourse() method to save the course record
     *
     * @return bool - return true if successful otherwise false
     */
	function createCourse() 
	{
	    // setting values to fields
        $info['courseCode'] = $this->courseCode;
        $info['courseName'] = $this->courseName;
        $info['deptID']     = $this->deptID;
        $info['dean']       = $this->dean;
        $info['remarks']    = $this->remarks;
		
		// building an insert query
        $this->tables = "courses";
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
	 * retrieveCourse() method to retrieve the course record and assign to the registrant attributes
	 *
	 */
	function retrieveCourse($lock='0')
	{
	    // setting conditions
	    $conds[0]['courseID'] = " = ".$this->courseID;
	    
	    // building an insert query
	    $this->tables = "courses";
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
                    $this->courseCode = $data[0]['courseCode'];
                    $this->courseName = $data[0]['courseName'];
                    
                    $this->deptID     = $data[0]['deptID'];
                    
                    $dept = new Department($data[0]['deptID']);
                   
                    $this->deptCode = $dept->deptCode;
                    $this->deptName = $dept->deptName;
                    
                    $this->dean       = $data[0]['dean'];
                    $this->remarks    = $data[0]['remarks'];
                    $this->rstatus    = $data[0]['rstatus'];
            		
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
	 * updateCourse() method to update the course record with the active courseID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateCourse()
	{
	    // setting values to fields
        $info['courseCode'] = $this->courseCode;
        $info['courseName'] = $this->courseName;
        $info['deptID']     = $this->deptID;
        $info['dean']       = $this->dean;
        $info['remarks']    = $this->remarks;
        $info['rstatus']    = $this->rstatus;
		
		// setting conditions
		$conds[]['courseID']  = " = ".$this->courseID;
		
		// building an insert query
        $this->tables = "courses";
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
	 * deleteCourse() method to delete the course record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteCourse()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['courseID'] = " = ".$this->courseID;
	    
	    // building an insert query
	    $this->tables = "courses";
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
	 * retrieveAllCourses() method to retrieve all/selected course records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllCourses($where='',$orderby='courseCode', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "courses";
	    $this->conds  = $where;
	    $this->order  = $orderby;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator

	    $department = new Department();
	    
	    try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
    		$data = array();
    		if ($records) {
    		    $ctr=0;
    		    foreach ($records as $row) {
    		        $department->deptID = $row['deptID'];
    		        $department->retrieveDepartment();
    		        
    		        $row['deptCode'] = $department->deptCode;
    		        $data[$ctr]=$row;
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
	 * getLastID() method to retrieve last ID course records
	 *
	 * @return lastID entry
	 */
	
	function getLastID() 
	{

	    $where[0]['courseCode'] = "= '".$this->courseCode."'";
	    
	    $result = $this->retrieveAllCourses($where,'courseID','DESC',0,1);
	    
	    return $result[0]['courseID'];
	}	
	
	
	/**
	 * isExist() - function to check the courseCode is already exist
	 *
	 * @param string $lname
	 * @param string $fname
	 * @param string $mname
	 * @return bool 
	 */
	function isExist($courseCode)
	{
	    if ($courseCode) {
    	    // setting conditions
    	    $conds[0]['courseCode'] = " = '$courseCode' AND ";
    	    $conds[0]['rstatus'] = " = 1";

    	    // building an insert query
    	    $this->tables = "courses";
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
	
	
	function allowDelete($courseID)
	{
	    if ($courseID) {
    	    // setting conditions
    	    $conds[0]['courseID'] = " = $courseID ";

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
                        // return true - the courseID is already in used
                        //  should not allow to delete the course
                		return 0;
                	} else {
                	    // return false - the courseID is not in used
                	    // allow to delete
                	    return 1;
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