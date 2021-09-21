<?php
/**
 *
 * Filename: Student.php
 * Date: 	 June 27, 2008
 * 
 * Author: 	 Rafie D. Paculaba
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
	var $regID;
	var $fname;
	var $lname;
	var $mname;
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
	var $entryDocs;
	var $rstatus;
	
	/**
	 * Student() constructor of the Student class
	 *
	 * @return Student
	 */
	function Student($id='') 
	{
	    // calling the parent class
	    parent::Database(4); // Preschool level
	    
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
        $info['regID']          = $this->regID;
        $info['fname']          = $this->fname;
        $info['lname']          = $this->lname;
        $info['mname']          = $this->mname;
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
	    $conds[0]['s.idno'] = " = '".$this->idno."'";
	    
	    $tables[]    = "students s";
	    $flds['s.*'] = "";
	    
	    // building an insert query
	    $this->tables = $tables;
	    $this->conds  = $conds;
	    $this->fields = $flds;
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
                    $this->regID          = $data[0]['regID'];
                    $this->fname          = $data[0]['fname'];
                    $this->lname          = $data[0]['lname'];
                    $this->mname          = $data[0]['mname'];
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
        $info['regID']          = $this->regID;
        $info['accID']          = $this->accID;
        $info['fname']          = $this->fname;
        $info['lname']          = $this->lname;
        $info['mname']          = $this->mname;
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
    		return $records;
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
	
	
	
}
?>