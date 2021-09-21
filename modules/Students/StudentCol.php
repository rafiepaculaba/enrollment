<?php
/**
 *
 * Filename: Student.php
 * Date: 	 August 15, 2007
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: Student
 * Description: This class is a model of the object - student
 * 				Implementing the active record pattern of database record
 */

class Student extends Database 
{
	
	var $recID;
	var $idno;
	var $accID;
	
	var $curID;
	var $uname;
	var $pswd;
	var $curName;
	var $effectivity;
	var $major;
	
	var $fname;
	var $lname;
	var $mname;
	
	var $courseID;
	var $courseCode;
	var $courseName;
	
	var $yrLevel;
	var $gender;
	var $age;
	var $bday;
	var $permanentAddr;
	var $currentAddr;
	var $phone;
	var $cstatus;
	var $nationality;
	var $motherName;
	var $fatherName;
	var $guardian;
	
	var $motherOccupation;
	var $fatherOccupation;
	var $guardianOccupation;
	var $motherContact;
	var $fatherContact;
	var $guardianContact;
	
	var $primary_edu;
	var $interm_edu;
	var $hs_edu;
	var $primary_schYear;
	var $interm_shcYear;
	var $hs_schYear;
	var $entryDocs;
	var $entryDate;
	var $rstatus;
	
	/**
	 * Student() constructor of the Student class
	 *
	 * @return Student
	 */
	function Student($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->idno = $id;
			$this->retrieveStudent();
		}
	}
	
	
    /**
     * createStudent() method to save the student record
     *
     * @return bool - return true if successful otherwise false
     */
	function createStudent() 
	{
	    // setting values to fields
	    $info['idno']           = $this->idno;
//        $info['regID']          = $this->regID;
        $info['curID']          = $this->curID;
        $info['uname']          = $this->uname;
        $info['pswd']           = $this->pswd;
        $info['curID']          = $this->curID;
        $info['fname']          = $this->fname;
        $info['lname']          = $this->lname;
        $info['mname']          = $this->mname;
        $info['courseID']       = $this->courseID;
        $info['yrLevel']        = $this->yrLevel;
        $info['gender']         = $this->gender;
        $info['age']            = $this->age;
        $info['bday']           = $this->bday;
        $info['permanentAddr']  = $this->permanentAddr;
        $info['currentAddr']    = $this->currentAddr;
        $info['phone']          = $this->phone;
        $info['cstatus']        = $this->cstatus;
        $info['nationality']    = $this->nationality;
        $info['motherName']     = $this->motherName;
        $info['fatherName']     = $this->fatherName;
        $info['guardian']       = $this->guardian;
        
        $info['motherOccupation']  = $this->motherOccupation;
        $info['fatherOccupation']  = $this->fatherOccupation;
        $info['guardianOccupation']= $this->guardianOccupation;
        
        $info['motherContact']     = $this->motherContact;
        $info['fatherContact']     = $this->fatherContact;
        $info['guardianContact']   = $this->guardianContact;
        
        $info['primary_edu']    = $this->primary_edu;
        $info['interm_edu']    	= $this->interm_edu;
        $info['hs_edu']    		= $this->hs_edu;
        $info['primary_schYear']= $this->primary_schYear;
        $info['interm_schYear']	= $this->interm_schYear;
        $info['hs_schYear']		= $this->hs_schYear;
        $info['entryDocs']      = $this->entryDocs;
        $info['entryDate']      = $this->entryDate;

		// building an insert query
        $this->tables = "students";
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
	 * retrieveStudent() method to retrieve the student record and assign to the student attributes
	 *
	 */
	function retrieveStudent($lock='0')
	{
	    // setting conditions
	    $conds[0]['idno'] = " = '".$this->idno."'";
	    
	    // building an insert query
	    $this->tables = "students";
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
            		$this->recID          = $data[0]['recID'];
            		$this->idno           = $data[0]['idno'];
            		$this->accID          = $data[0]['accID'];
//                    $this->regID          = $data[0]['regID'];

                    $this->curID          = $data[0]['curID'];
                    $this->uname          = $data[0]['uname'];
                    $this->pswd           = $data[0]['pswd'];
                    $this->curID          = $data[0]['curID'];
                    $this->curName        = $data[0]['curName'];
                    $this->effectivity    = $data[0]['effectivity'];
                    $this->major          = $data[0]['major'];
                    
                    $this->fname          = $data[0]['fname'];
                    $this->lname          = $data[0]['lname'];
                    $this->mname          = $data[0]['mname'];
                    
                    $course = new Course($data[0]['courseID']);
                    $this->courseID       = $course->courseID;
                    $this->courseCode     = $course->courseCode;
                    $this->courseName     = $course->courseName;
                    
                    $this->yrLevel        = $data[0]['yrLevel'];
                    $this->gender         = $data[0]['gender'];
                    $this->age            = $data[0]['age'];
                    $this->bday           = $data[0]['bday'];
                    $this->permanentAddr  = $data[0]['permanentAddr'];
                    $this->currentAddr    = $data[0]['currentAddr'];
                    $this->phone          = $data[0]['phone'];
                    $this->cstatus        = $data[0]['cstatus'];
                    $this->nationality    = $data[0]['nationality'];
                    $this->motherName     = $data[0]['motherName'];
                    $this->fatherName     = $data[0]['fatherName'];
                    $this->guardian       = $data[0]['guardian'];
                    
                    $this->motherOccupation  = $data[0]['motherOccupation'];
                    $this->fatherOccupation  = $data[0]['fatherOccupation'];
                    $this->guardianOccupation= $data[0]['guardianOccupation'];
                    
                    $this->motherContact     = $data[0]['motherContact'];
                    $this->fatherContact     = $data[0]['fatherContact'];
                    $this->guardianContact   = $data[0]['guardianContact'];
                    
                    $this->primary_edu    = $data[0]['primary_edu'];
                    $this->interm_edu     = $data[0]['interm_edu'];
                    $this->hs_edu     	  = $data[0]['hs_edu'];
                    $this->primary_schYear= $data[0]['primary_schYear'];
                    $this->interm_shcYear = $data[0]['interm_schYear'];
                    $this->hs_schYear 	  = $data[0]['hs_schYear'];
                    $this->entryDocs      = $data[0]['entryDocs'];
                    $this->entryDate      = $data[0]['entryDate'];
                    $this->rstatus        = $data[0]['rstatus'];
            		
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
	 * updateStudent() method to update the student record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateStudent()
	{
	    // setting values to fields
//        $info['regID']          = $this->regID;
        $info['accID']          = $this->accID;
        $info['curID']          = $this->curID;
        $info['uname']          = $this->uname;
        $info['pswd']           = $this->pswd;
        $info['fname']          = $this->fname;
        $info['lname']          = $this->lname;
        $info['mname']          = $this->mname;
        $info['courseID']       = $this->courseID;
        $info['yrLevel']        = $this->yrLevel;
        $info['gender']         = $this->gender;
        $info['age']            = $this->age;
        $info['bday']           = $this->bday;
        $info['permanentAddr']  = $this->permanentAddr;
        $info['currentAddr']    = $this->currentAddr;
        $info['phone']          = $this->phone;
        $info['cstatus']        = $this->cstatus;
        $info['nationality']    = $this->nationality;
        $info['motherName']     = $this->motherName;
        $info['fatherName']     = $this->fatherName;
        $info['guardian']       = $this->guardian;
        
        $info['motherOccupation']  = $this->motherOccupation;
        $info['fatherOccupation']  = $this->fatherOccupation;
        $info['guardianOccupation']= $this->guardianOccupation;
        
        $info['motherContact']     = $this->motherContact;
        $info['fatherContact']     = $this->fatherContact;
        $info['guardianContact']   = $this->guardianContact;
        
        $info['primary_edu']    = $this->primary_edu;
        $info['interm_edu']     = $this->interm_edu;
        $info['hs_edu']     	= $this->hs_edu;
        $info['primary_schYear']= $this->primary_schYear;
        $info['interm_schYear'] = $this->interm_shcYear;
        $info['hs_schYear'] 	= $this->hs_schYear;
        $info['entryDocs']      = $this->entryDocs;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['idno']  = " = '".$this->idno."'";
		
		// building an insert query
        $this->tables = "students";
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
	 * deleteStudent() method to delete the student record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteStudent()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['idno'] = " = '".$this->idno."'";
	    
	    // building an insert query
	    $this->tables = "students";
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
	 * retrieveAllStudents() method to retrieve all/selected student records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllStudents($where='',$orderby='lname', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "students";
	    $this->conds  = $where;
	    
	    $multi_orders[$orderby]=$sorting;
	    $multi_orders['fname']='ASC';
	    
	    //$this->order  = $orderby;
	    
	    $this->multi_orders  = $multi_orders;
	    
	    
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
    		
    		// Course object instance
    		$data=array();
    		$ctr=0;
    		foreach ($records as $row) {
    		    $course = new Course($row['courseID']);
    		    $data[$ctr] = $row;
    		    $data[$ctr]['courseCode'] = $course->courseCode;
    		    unset($course);
    		    $ctr++;
    		}
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	/**
	 * countAllStudents() method to retrieve all/selected student records
	 *
	 * @param array $where
	 * @param int $offset
	 * @param int $limit
	 * @return int total records
	 */
	function countAllStudents($where='', $offset=0, $limit='')
	{
		// building an insert query
		
	    $this->tables = "students";
	    $this->conds  = $where;
	    
	    $flds['count(lname) as ttl_record'] = "";
	    $this->fields = $flds;
	    
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
		    return 0;
		}
	}
	
	
	/**
	 * isExist() - function to check the student idno is already exist
	 *
	 * @param number $idno
	 * @return bool
	 */
	function isExist($idno)
	{
	    if ($idno) {
	        
    	    // setting conditions
    	    $conds[]['idno'] = " = '$idno' ";
    	    
    	    // building an insert query
    	    $this->tables = "students";
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
                		return 1;
                	} else {
                	    // return false - the idno does not exist
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
	
	function getLastID() 
	{
	    $where[0]['deptCode']="= '".$this->deptCode."' AND ";
	    $where[0]['deptName']="= '".$this->deptName."'";
	    
	    $result = $this->retrieveAllDepartments($where,'deptID','DESC',0,1);
	    
	    return $result[0]['deptID'];
	}
	
	/**
	 * retrieveTOR() method to retrieve selected TOR record
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveTOR($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "tor";
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
	
}
?>