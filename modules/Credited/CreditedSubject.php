<?php
/**
 *
 * Filename: CreditedSubject.php
 * Date: 	 Feb 27, 2008
 * 
 * Author: 	 Rafie D. Paculaba
 * 
 */


/**
 * Class: CreditedSubject
 * Description: This class is a model of the object - CreditedSubject
 * 				Implementing the active record pattern of database record
 */

class CreditedSubject extends Database 
{
	var $creID;
	var $idno;
	var $studName;

	var $schYear;
	var $yrLevel;
	var $semCode;
	var $fgrade;
	var $subjID;
	var $subjCode;

	var $eqSubj;
	var $eqUnits;
	var $school;
	var $remarks;
	var $encodedBy;
	var $rstatus;
	
	/**
	 * CreditedSubject() constructor of the CreditedSubject class
	 * 
	 * @return CreditedSubject
	 */
	function CreditedSubject($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level
	    
	    // set active record if found
		if ($id) {
			$this->creID = $id;
			$this->retrieveCreditedSubject();
		}
	}
	
    /**
     * createCreditedSubject() method to save the CreditedSubject record
     *
     * @return bool - return true if successful otherwise false
     */
	function createCreditedSubject() 
	{
	    // setting values to fields
    	$info['idno']  		= $this->idno;
    	$info['schYear']  	= $this->schYear;
    	$info['yrLevel']  	= $this->yrLevel;
    	$info['semCode']  	= $this->semCode;
    	$info['fgrade']  	= $this->fgrade;
    	$info['subjID']  	= $this->subjID;
    	$info['eqSubj'] 	= $this->eqSubj;
    	$info['eqUnits'] 	= $this->eqUnits;
    	$info['school'] 	= $this->school;
    	$info['remarks'] 	= $this->remarks;
    	$info['encodedBy'] 	= $this->encodedBy;
		
		// building an insert query
        $this->tables = "credited_subjs";
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
	 * retrieveCreditedSubject() method to retrieve the CreditedSubject record and assign to the CreditedSubject attributes
	 *
	 */
	function retrieveCreditedSubject($lock='0')
	{
	    // setting conditions
	    $conds[0]['creID'] = " = '".$this->creID."'";
	    
	    // building an insert query
	    $this->tables = "credited_subjs";
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
                	$this->idno   		= $data[0]['idno'];
                	$this->schYear   	= $data[0]['schYear'];
                	$this->yrLevel   	= $data[0]['yrLevel'];
                	$this->semCode   	= $data[0]['semCode'];
                	$this->fgrade   	= $data[0]['fgrade'];
                	
                	$stud 				= new Student($data[0]['idno']);
                	$this->studName		= $stud->fname." ".$stud->lname." ".$stud->mname;
                	
                	$this->subjID  		= $data[0]['subjID'];
                		
                	$subj 				= new Subject($this->subjID);
                	$this->subjCode		= $subj->subjCode;
                	
                	$this->eqSubj 		= $data[0]['eqSubj'];
                	$this->eqUnits 		= $data[0]['eqUnits'];
                	$this->school 		= $data[0]['school'];
                	$this->remarks 		= $data[0]['remarks'];
                	$this->encodedBy 	= $data[0]['encodedBy'];
                    $this->rstatus 		= $data[0]['rstatus'];
            		
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
	 * updateCreditedSubject() method to update the CreditedSubject record with the active creID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateCreditedSubject()
	{
	    // setting values to fields
       	$info['idno']   	= $this->idno;
       	$info['schYear']   	= $this->schYear;
       	$info['yrLevel']   	= $this->yrLevel;
       	$info['semCode']   	= $this->semCode;
       	$info['fgrade']   	= $this->fgrade;
    	$info['subjID']  	= $this->subjID;
    	$info['eqSubj'] 	= $this->eqSubj;
    	$info['eqUnits'] 	= $this->eqUnits;
    	$info['school'] 	= $this->school;
    	$info['remarks'] 	= $this->remarks;
    	$info['encodedBy'] 	= $this->encodedBy;
        $info['rstatus'] 	= $this->rstatus;

		// setting conditions
		$conds[]['creID']  = " = '".$this->creID."'";
		
		// building an insert query
        $this->tables = "credited_subjs";
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
	 * deleteCreditedSubject() method to delete the CreditedSubject record  witht the active creID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteCreditedSubject()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['creID'] = " = '".$this->creID."'";
	    
	    // building an insert query
	    $this->tables = "credited_subjs";
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
	 * retrieveAllCreditedSubjects() method to retrieve all/selected CreditedSubject records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllCreditedSubjects($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "credited_subjs";
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
    		    $data[$ctr]['type'] 	 = $subj->type;
    		    $data[$ctr]['units']     = $subj->units;
    		    
    		    $prereq=$this->getPrerequisites($row['curID'], $row['subjID']);
    		    
    		    $data[$ctr]['prerequisitesID']   = !empty($prereq['prerequisitesID'])? $prereq['prerequisitesID']:"";
    		    $data[$ctr]['prerequisitesCode'] = !empty($prereq['prerequisitesCode'])?  $prereq['prerequisitesCode']:"";
    		    
    		    $ctr++;
    		}
    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	/**
	 * countAllCreditedSubjects() method to retrieve all/selected CreditedSubject records
	 *
	 * @param array $where
	 * @param int $offset
	 * @param int $limit
	 * @return int ttl_record
	 */
	function countAllCreditedSubjects($where='', $offset=0, $limit='')
	{
		// building an insert query
		$flds['count(creID) as ttl_record']  = "";
		
	    $this->tables = "credited_subjs";
	    $this->fields = $flds;
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
	 *  LastID() method to retrieve last entered ID
	 *
	 * @return ID
	 */
	function getLastID() 
	{
	    $where[0]['idno'] = "= '".$this->idno."' AND ";
	    $where[0]['schYear'] = "= '".$this->schYear."' AND ";
	    $where[0]['yrLevel'] = "= '".$this->yrLevel."' AND ";
	    $where[0]['semCode'] = "= '".$this->semCode."' AND ";
	    $where[0]['subjID'] = "= '".$this->subjID."'";
	    
	    
	    $result = $this->retrieveAllCreditedSubjects($where,'creID','DESC',0,1);
	    return $result[0]['creID'];
	}	

	
	/**
	 * isExist() - function to check the CreditedSubject name is already exist
	 *
	 * @param number $curID
	 * @param number $subjID
	 * @return bool 
	 */
	function isExist($schYear, $semCode, $idno, $subjID)
	{
	    if ($schYear && $semCode && $idno && $subjID) {
    	    // setting conditions
    	    $conds[]['schYear'] = " = '$schYear' AND ";
    	    $conds[]['semCode'] = " = '$semCode' AND ";
    	    $conds[]['idno'] = " = '$idno' AND ";
    	    $conds[]['subjID'] = " = '$subjID'";

    	    // building an insert query
    	    $this->tables = "credited_subjs";
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