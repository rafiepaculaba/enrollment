<?php
/**
 *
 * Filename: Assessment.php
 * Date: 	 March 14, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: Assessment
 * Description: This class is a model of the object - Assessment
 * 				Implementing the active record pattern of database record
 */

class Assessment extends Database 
{
	
	var $assID;
	var $idno;
	var $accID;
	var $schYear;
	var $semCode;
	var $yrLevel;
	var $courseID;
	var $term;
	var $tuitionFee;
	var $labFee;
	var $regFee;
	var $miscFee;
	var $addAdj;
	var $lessAdj;
	var $oldBalance;
	var $totalFees;
	var $ttlPayment;
	var $balance;
	var $ttlDue;
	var $amtPaid;
	
	var $preparedBy;
	var $preparedName;
	
	var $rstatus;

	/**
	 * Assessment() constructor of the Assessment class
	 *
	 * @return Assessment
	 */
	function Assessment($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level

	    // set active record if found
		if ($id) {
			$this->assID = $id;
			$this->retrieveAssessment();
		}
	}
	
	
    /**
     * createAssesssment() method to save the Assessment record
     *
     * @return bool - return true if successful otherwise false
     */
	function createAssessment() 
	{
	    // setting values to fields
        $info['idno']    		= $this->idno;
        $info['accID']    		= $this->accID;
        $info['schYear']    	= $this->schYear;
        $info['semCode']    	= $this->semCode;
        $info['courseID']    	= $this->courseID;
        $info['yrLevel']    	= $this->yrLevel;
        $info['term']    		= $this->term;
        $info['tuitionFee']    	= $this->tuitionFee;
        $info['labFee']   		= $this->labFee;
        $info['regFee']    		= $this->regFee;
        $info['miscFee']    	= $this->miscFee;
        $info['addAdj']    		= $this->addAdj;
        $info['lessAdj']    	= $this->lessAdj;
        $info['oldBalance']    	= $this->oldBalance;
        $info['totalFees']    	= $this->totalFees;
        $info['ttlPayment']    	= $this->ttlPayment;
        $info['balance']    	= $this->balance;
        $info['ttlDue']    		= $this->ttlDue;
        $info['preparedBy']    	= $this->preparedBy;
        //$info['amtPaid']   		= $this->amtPaid;
        
		// building an insert query
        $this->tables = "assessments";
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
	 * retrieveAssessment() method to retrieve the Assessment record and assign to the registrant attributes
	 *
	 */
	function retrieveAssessment($lock='0')
	{
	    // setting conditions
	    $conds[0]['assID'] = " = ".$this->assID;
	    
	    // building an insert query
	    $this->tables = "assessments";
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
                    $this->assID 		= $data[0]['assID'];
                    $this->idno   		= $data[0]['idno'];
                    $this->accID      	= $data[0]['accID'];
                    $this->schYear      = $data[0]['schYear'];
                    $this->semCode 		= $data[0]['semCode'];
                    $this->courseID 	= $data[0]['courseID'];
                    $this->yrLevel 		= $data[0]['yrLevel'];
                    $this->term  		= $data[0]['term'];
                    $this->tuitionFee  	= $data[0]['tuitionFee'];
                    $this->labFee       = $data[0]['labFee'];
                    $this->regFee 		= $data[0]['regFee'];
                    $this->miscFee   	= $data[0]['miscFee'];
                    $this->addAdj    	= $data[0]['addAdj'];
                    $this->lessAdj   	= $data[0]['lessAdj'];
                    $this->oldBalance   = $data[0]['oldBalance'];
                    $this->totalFees   	= $data[0]['totalFees'];
                    $this->ttlPayment   = $data[0]['ttlPayment'];
                    $this->balance   	= $data[0]['balance'];
                    $this->ttlDue   	= $data[0]['ttlDue'];
                    $this->amtPaid   	= $data[0]['amtPaid'];
                    $this->preparedBy   = $data[0]['preparedBy'];
                    $this->rstatus      = $data[0]['rstatus'];
                    
                    $u = new User2();
                    $u->id = $data[0]['preparedBy'];
        		    $u->retrieveUser();
    
        		    $this->preparedName   = $u->last_name." ,".$u->first_name;
            		
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
	 * updateAssessment() method to update the Assessment record with the active assID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateAssessment()
	{
	    // setting values to fields
        $info['idno']    		= $this->idno;
        $info['accID']    		= $this->accID;
        $info['schYear']    	= $this->schYear;
        $info['semCode']    	= $this->semCode;
        $info['courseID']    	= $this->courseID;
        $info['yrLevel']    	= $this->yrLevel;
        $info['term']    		= $this->term;
        $info['tuitionFee']    	= $this->tuitionFee;
        $info['labFee']   		= $this->labFee;
        $info['regFee']    		= $this->regFee;
        $info['miscFee']    	= $this->miscFee;
        $info['addAdj']    		= $this->addAdj;
        $info['lessAdj']    	= $this->lessAdj;
        $info['oldBalance']    	= $this->oldBalance;
        $info['totalFees']    	= $this->totalFees;
        $info['ttlPayment']    	= $this->ttlPayment;
        $info['balance']    	= $this->balance;
        $info['ttlDue']    		= $this->ttlDue;
		$info['amtPaid']    	= $this->amtPaid;
        $info['preparedBy']     = $this->preparedBy;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['assID']  = " = ".$this->assID;
		
		// building an update query
        $this->tables = "assessments";
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
	 * deleteAssessment() method to delete the Assessment record  witht the active assID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteAssessment()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['assID'] = " = ".$this->assID;
	    
	    // building an delete query
	    $this->tables = "assessments";
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
	 * retrieveAllAssessments() method to retrieve all/selected Assessment records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllAssessments($where='',$orderby='schYear', $sorting='DESC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "assessments";
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
	
	
	/**
	 * retrieveAllAssessmentsAssociated() method to retrieve all/selected Assessment records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllAssessmentsAssociated($where='',$orderby='assessments.schYear', $sorting='DESC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="assessments";
		$tables[]="students";
		$tables[]="courses";
		
		$fields['assessments.*']="";
		$fields['students.lname']="";
		$fields['students.fname']="";
		$fields['students.mname']="";
		$fields['students.courseID']="";
		$fields['assessments.yrLevel']="";
		$fields['courses.courseCode']="";
		
		if (count($where)) {
		    $where[0][' AND assessments.courseID  ']="=courses.courseID";
		} else {
		    $where[0]['assessments.courseID']="=courses.courseID";
		}
		
	    $where[0][' AND students.idno']="=assessments.idno";
		
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
	 * countAllAssessmentsAssociated() method to retrieve all/selected Assessment records
	 *
	 * @param array $where
	 * @param int $offset
	 * @param int $limit
	 * @return int total records
	 */
	function countAllAssessmentsAssociated($where='', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="assessments";
		$tables[]="students";
		$tables[]="courses";
		
		$fields['count(students.lname) as ttl_record']="";
		
		if (count($where)) {
		    $where[0][' AND assessments.courseID ']="=courses.courseID";
		} else {
		    $where[0]['assessments.courseID']="=courses.courseID";
		}
		
	    $where[0][' AND students.idno']="=assessments.idno";
		
	    $this->tables = $tables;
	    $this->conds  = $where;
	    $this->fields = $fields;
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
	 * getLastID() -  this will get the last ID
	 *
	 * @return unknown
	 */
	function getLastID() 
	{
	    $where[0]['idno']="= '".$this->idno."' AND ";
	    $where[0]['accID']="= '".$this->accID."' AND ";
	    $where[0]['schYear']="= '".$this->schYear."' AND ";
	    $where[0]['semCode']="= '".$this->semCode."' AND ";
	    $where[0]['term']="= '".$this->term."' AND ";
	    $where[0]['rstatus']="= '1' ";
	    $result = $this->retrieveAllAssessments($where,'assID','DESC',0,1);

	    return $result[0]['assID'];
	}

	/**
	 * getEnrollmentID() -  this will get the enrollment id of this account
	 *
	 * @return int
	 */
	function getEnrollmentID() 
	{
	    $where[0]['idno']="= '".$this->idno."' AND ";
	    $where[0]['schYear']="= '".$this->schYear."' AND ";
	    $where[0]['semCode']="= '".$this->semCode."' AND ";
	    $where[0]['yrLevel']="= '".$this->yrLevel."' AND ";
	    $where[0]['rstatus']="> 0 ";
	    
	    $this->tables = 'enrollments';
	    $this->conds  = $where;
	    $this->fields = $fields;
	    $this->order  = 'enID';
	    $this->sorting= 'Desc';
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
		    
		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
    		return $records[0]['enID'];
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return 0;
		}
	    
	}
	
	
	/**
	 * isExist() - function to check the assID is already exist
	 *
	 * @param string $assID
	 * @return bool 
	 */
	function isExist($idno, $accID, $schYear, $semCode, $term)
	{
	    if ($idno && $accID && $schYear && $semCode && $term) {
    	    // setting conditions
    	    $where[0]['idno']    = "= '$idno' AND ";
    	    $where[0]['accID']   = "= '$accID' AND ";
    	    $where[0]['schYear'] = "= '$schYear' AND ";
    	    $where[0]['semCode'] = "= '$semCode' AND ";
    	    $where[0]['term']    = "= '$term' AND ";
    	    $where[0]['rstatus'] = " > 0 ";
    	    
    	    // building an insert query
    	    $this->tables = "assessments";
    	    $this->conds  = $where;
    
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
                        // return true - record is already exist            		
                		return $data[0]['assID'];
                	} else {
                	    // return false - record does not exist
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