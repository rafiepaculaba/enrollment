<?php
/**
 *
 * Filename: Form137.php
 * Date: 	 Feb 11, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */


/**
 * Class: Form137
 * Description: This class is a model of the object - Form137
 * 				Implementing the active record pattern of database record
 */

class Form137 extends Database 
{
	var $gradeID;
	var $idno;
	var $yrLevel;
	var $endID;
	var $schYear;
	
	var $subjID;
	var $subjCode;
	var $descTitle;
	var $units;
	
	var $firstgrade;
	var $secondgrade;
	var $thirdgrade;
	var $fourthgrade;
	var $fgrade;
	var $rstatus;
	
	
	/**
	 * Form137s() construcForm137 of the Form137s class
	 * 
	 * @return Form137s
	 */
	function Form137($id='') 
	{
	    // calling the parent class
	    parent::Database(2); // high school level
	    
	    // set active record if found
		if ($id) {
			$this->gradeID = $id;
			$this->retrieveForm137();
		}
	}
	
    /**
     * createForm137s() method to save the Form137s record
     *
     * @return bool - return true if successful otherwise false
     */
	function createForm137() 
	{
	    // setting values to fields
    	$info['idno']    	= $this->idno;
    	$info['yrLevel'] 	= $this->yrLevel;
    	$info['endID']   	= $this->endID;
    	$info['schYear'] 	= $this->schYear;
    	$info['subjID']  	= $this->subjID;
    	$info['firstgrade'] = $this->firstgrade;
    	$info['secondgrade']= $this->secondgrade;
    	$info['thirdgrade'] = $this->thirdgrade;
    	$info['fourthgrade']= $this->fourthgrade;
    	$info['fgrade']  	= $this->fgrade;
    	
		// building an insert query
        $this->tables = "form137";
		$this->fields = $info;
		
		$query = $this->Insert();     // generate insert sql query
		$this->reset();               // reset all variables in query generaForm137
		
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
	 * retrieveForm137s() method to retrieve the Form137s record and assign to the Form137s attributes
	 *
	 */
	function retrieveForm137($lock='0')
	{
	    // setting conditions
	    $conds[0]['gradeID'] = " = '".$this->gradeID."'";
	    
	    // building an insert query
	    $this->tables = "form137";
	    $this->conds  = $conds;
	    $this->lock   = $lock;

	    // building an select query
	    $query = $this->Select();  // generate select sql query
	    $this->reset();            // reset all variables in query generaForm137
		
	    // check if building query is successful
		if ( empty($this->errs) ) {
    	    try {
    	        $this->db->beginTransaction();
        		$result = $this->db->query($query);
        		$data   = $result->fetchAll(PDO::FETCH_BOTH);
        		$this->db->commit();
        		
        		if ($data[0]) {
                	$this->gradeID 		= $data[0]['gradeID'];
                	$this->idno    		= $data[0]['idno'];
                	$this->yrLevel 		= $data[0]['yrLevel'];
                	$this->endID   		= $data[0]['endID'];
                	$this->schYear 		= $data[0]['schYear'];
                	$this->firstgrade  	= $data[0]['firstgrade'];
                	$this->secondgrade  = $data[0]['secondgrade'];
                	$this->thirdgrade  	= $data[0]['thirdgrade'];
                	$this->fourthgrade  = $data[0]['fourthgrade'];
                	$this->fgrade  		= $data[0]['fgrade'];
                	$this->subjID  		= $data[0]['subjID'];
                	
                	$subj = new Subject($this->subjID);
                	$this->subjCode  = $subj->subjCode;
                	$this->descTitle = $subj->descTitle;
                	$this->units     = $subj->units;
                	
                    $this->rstatus = $data[0]['rstatus'];
            		
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
     * updateForm137s() method to save the Form137s record
     *
     * @return bool - return true if successful otherwise false
     */
	function updateForm137() 
	{
	    // setting values to fields
    	$info['idno']     	= $this->idno;
    	$info['endID']    	= $this->endID;
    	$info['schYear']  	= $this->schYear;
    	$info['yrLevel']  	= $this->yrLevel;
    	$info['subjID']   	= $this->subjID;
    	$info['firstgrade'] = $this->firstgrade;
    	$info['secondgrade']= $this->secondgrade;
    	$info['thirdgrade'] = $this->thirdgrade;
    	$info['fourthgrade']= $this->fourthgrade;
    	$info['fgrade']   	= $this->fgrade;
    	$info['rstatus']  	= $this->rstatus;
    	
		// building an insert query
        $this->tables = "form137";
		$this->fields = $info;
		
		$query = $this->Update();     // generate update sql query
		$this->reset();               // reset all variables in query generaForm137
		
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
	 * deleteForm137s() method to delete the Form137s record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteForm137()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['gradeID'] = " = '".$this->gradeID."'";
	    
	    // building an insert query
	    $this->tables = "form137";
	    $this->conds  = $conds;

	    // building an select query
	    $query = $this->Delete();  // generate delete sql query
	    $this->reset();            // reset all variables in query generaForm137
	    
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
	 * retrieveAllForm137ss() method to retrieve all/selected Form137s records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllForm137s($where='',$orderby='form137.yrLevel', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="form137";
		$tables[]="subjects";
		
		$flds['subjects.subjCode']  = "";
		$flds['subjects.descTitle'] = "";
		$flds['subjects.units']     = "";
		$flds['form137.*']              = "";
		
		if (count($where[0]))
		  $where[0]['AND form137.subjID'] = "=subjects.subjID";
	    else
		  $where[0]['form137.subjID']     = "=subjects.subjID";
		
	    $this->tables = $tables;
	    $this->fields = $flds;
	    $this->conds  = $where;
	    $this->order  = $orderby;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generaForm137
	    
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