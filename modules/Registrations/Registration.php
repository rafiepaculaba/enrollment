<?php
/**
 *
 * Filename: Registration.php
 * Date: 	 August 15, 2007
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: Registration
 * Description: This class is a model of the object - Registration
 * 				Implementing the active record pattern of database record
 */

class Registration extends Database 
{
	
	var $regID;
	var $fname;
	var $lname;
	var $mname;
	var $gender;
	var $age;
	var $bday;
	var $cstatus;
	var $nationality;
	var $entryDocs;
	var $lastSchool;
	var $sch_last_attended;
	var $regDate;
	var $rstatus;
	
	/**
	 * Registration() constructor of the registration class
	 *
	 * @return Registration
	 */
	function Registration($id='') 
	{
	    // calling the parent class
	    parent::Database(3); // college level

	    // set active record if found
		if ($id) {
			$this->regID = $id;
			$this->retrieveRegistration();
		}
	}
	
	
	
    /**
     * createRegistration() method to save the registrant record
     *
     * @return bool - return true if successful otherwise false
     */
	function createRegistration() 
	{
	    // setting values to fields
        $info['fname']          = $this->fname;
        $info['lname']          = $this->lname;
        $info['mname']          = $this->mname;
        $info['gender']         = $this->gender;
        $info['age']            = $this->age;
        $info['bday']           = $this->bday;
        $info['cstatus']        = $this->cstatus;
        $info['nationality']    = $this->nationality;
        $info['entryDocs']      = $this->entryDocs;
        $info['lastSchool']     = $this->lastSchool;
        $info['sch_last_attended'] = $this->sch_last_attended;
        $info['regDate']        = $this->regDate;
        $info['encodedBy']      = $this->encodedBy;

		
		// building an insert query
        $this->tables = "registrations";
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
	 * retrieveRegistration() method to retrieve the registrant record and assign to the registrant attributes
	 *
	 */
	function retrieveRegistration($lock='0')
	{
	    // setting conditions
	    $conds[0]['regID'] = " = ".$this->regID;
	    
	    // building an insert query
	    $this->tables = "registrations";
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
                    $this->fname          = $data[0]['fname'];
                    $this->lname          = $data[0]['lname'];
                    $this->mname          = $data[0]['mname'];
                    $this->gender         = $data[0]['gender'];
                    $this->age            = $data[0]['age'];
                    $this->bday           = $data[0]['bday'];
                    $this->cstatus        = $data[0]['cstatus'];
                    $this->nationality    = $data[0]['nationality'];
                    $this->entryDocs      = $data[0]['entryDocs'];
                    $this->lastSchool     = $data[0]['lastSchool'];
                    $this->sch_last_attended = $data[0]['sch_last_attended'];
                    $this->regDate        = $data[0]['regDate'];
                    $this->encodedBy      = $data[0]['encodedBy'];
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
	 * updateRegistration() method to update the registrant record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateRegistration()
	{
	    // setting values to fields
        $info['fname']          = $this->fname;
        $info['lname']          = $this->lname;
        $info['mname']          = $this->mname;
        $info['gender']         = $this->gender;
        $info['age']            = $this->age;
        $info['bday']           = $this->bday;
        $info['cstatus']        = $this->cstatus;
        $info['nationality']    = $this->nationality;
        $info['entryDocs']      = $this->entryDocs;
        $info['lastSchool']     = $this->lastSchool;
        $info['sch_last_attended'] = $this->sch_last_attended;
        $info['regDate']        = $this->regDate;
        $info['encodedBy']      = $this->encodedBy;
        $info['rstatus']        = $this->rstatus;
		
		// setting conditions
		$conds[]['regID']  = " = ".$this->regID;
		
		// building an insert query
        $this->tables = "registrations";
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
	 * deleteRegistration() method to delete the registrant record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteRegistration()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['regID'] = " = ".$this->regID;
	    
	    // building an insert query
	    $this->tables = "registrations";
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
	 * retrieveAllRegistrations() method to retrieve all/selected registrant records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllRegistrations($where='',$orderby='lname', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "registrations";
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
	 * getLastID() method to retrieve last insertet registration
	 *
	 * @return deptID
	 */
	function getLastID() 
	{

	    $where[0]['lname'] = "= '".$this->lname."' AND ";
	    $where[0]['fname'] = "= '".$this->fname."' AND ";
	    $where[0]['mname'] = "= '".$this->mname."' AND ";
	    $where[0]['rstatus'] = "= '1' ";
	    
	    $result = $this->retrieveAllRegistrations($where,'regID','DESC',0,1);
	    return $result[0]['regID'];
	}	
	
	
	/**
	 * isExist() - function to check the registrant is already exist
	 *
	 * @param string $lname
	 * @param string $fname
	 * @param string $mname
	 * @return bool 
	 */
	function isExist($lname, $fname, $mname)
	{
	    if ($lname && $fname) {
    	    // setting conditions
    	    $conds[]['lname'] = " = '$lname' AND ";
    	    $conds[]['fname'] = " = '$fname' AND ";
    	    $conds[]['mname'] = " = '$mname' AND ";
    	    $conds[]['rstatus'] = " = 1";
    	    
    	    // building an insert query
    	    $this->tables = "registrations";
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
	
}
?>