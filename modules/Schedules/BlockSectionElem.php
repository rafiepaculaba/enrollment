<?php
/**
 *
 * Filename: BlockSectionElem.php
 * Date: 	 Feb 18, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */


/**
 * Class: BlockSection
 * Description: This class is a model of the object - BlockSection for high school level
 * 				Implementing the active record pattern of database record
 */

class BlockSection extends Database 
{
	var $secID;
	var $secName;
	var $schYear;
	
	var $yrLevel;
	var $remarks;
	
	var $maxCapacity;
	var $noEnrolled;
	
	var $preparedBy;
	var $preparedName;
	
	var $rstatus;
	
	var $subjs;
	
	
	/**
	 * BlockSection() constructor of the BlockSection class
	 *
	 * @return BlockSection
	 */
	function BlockSection($id='') 
	{
	    // calling the parent class
	    parent::Database(1); // elem level
	    
	    // set active record if found
		if ($id) {
			$this->secID = $id;
			$this->retrieveBlockSection();
		}
	}
	
	
    /**
     * createBlockSection() method to save the BlockSection record
     *
     * @return bool - return true if successful otherwise false
     */
	function createBlockSection() 
	{
	    // setting values to fields
    	$info['secName']    = $this->secName;
    	$info['schYear']    = $this->schYear;
    	$info['yrLevel']    = $this->yrLevel;
    	$info['maxCapacity']= $this->maxCapacity;
    	$info['remarks']    = $this->remarks;
    	$info['preparedBy'] = $this->preparedBy;
		
		// building an insert query
        $this->tables = "block_sections";
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
	 * retrieveBlockSection() method to retrieve the BlockSection record and assign to the BlockSection attributes
	 *
	 */
	function retrieveBlockSection($lock='0')
	{
	    // setting conditions
	    $conds[0]['secID'] = " = '".$this->secID."'";
	    
	    // building an insert query
	    $this->tables = "block_sections";
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
        		    $this->secName     = $data[0]['secName'];
    	            $this->schYear     = $data[0]['schYear'];
    	            $this->yrLevel     = $data[0]['yrLevel'];
    	            $this->noEnrolled  = $data[0]['noEnrolled'];
    	            $this->maxCapacity = $data[0]['maxCapacity'];
    	            $this->remarks     = $data[0]['remarks'];
    	            $this->preparedBy  = $data[0]['preparedBy'];
        		    
                	$this->preparedBy  = $data[0]['preparedBy'];
                	$u = new User2($this->preparedBy);
                	$this->preparedName= $u->last_name." ,".$u->first_name;
                	
                    $this->rstatus     = $data[0]['rstatus'];
                    
                    $blockSubjs = new BlockSectionSubject();

                    $conds[0]['secID']   = " = '".$this->secID."'";
                    $this->subjs=$blockSubjs->retrieveAllBlockSectionSubjects($conds);
                    
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
	 * updateBlockSection() method to update the BlockSection record with the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateBlockSection()
	{
	    // setting values to fields
        $info['secName']    = $this->secName;
    	$info['schYear']    = $this->schYear;
    	$info['yrLevel']    = $this->yrLevel;
    	$info['maxCapacity']= $this->maxCapacity;
    	$info['noEnrolled'] = $this->noEnrolled;
    	$info['remarks']    = $this->remarks;
    	
    	// check if the enrolled exceed to the max
    	if ($this->noEnrolled >= $this->maxCapacity) {
    	    $info['rstatus'] = 0; // closed
    	} else {
    	    $info['rstatus'] = 1; // open
    	}
		
		// setting conditions
		$conds[]['secID']  = " = '".$this->secID."'";
		
		// building an insert query
        $this->tables = "block_sections";
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
	 * deleteBlockSection() method to delete the BlockSection record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteBlockSection()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['secID'] = " = '".$this->secID."'";
	    
	    // building an insert query
	    $this->tables = "block_sections";
	    $this->conds  = $conds;
	    
	    // building an select query
	    $query = $this->Delete();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
	    
	    // for subject details
	    $this->tables = "block_sections_details";
	    $this->conds  = $conds;
	    
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
	 * retrieveAllBlockSections() method to retrieve all/selected BlockSection records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllBlockSections($where='',$orderby='secName', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "block_sections";
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
    		    $u->id = $row['preparedBy'];
    		    $u->retrieveUser();

    		    $data[$ctr] = $row;
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
	 * countAllBlockSections() method to retrieve all/selected BlockSection records
	 *
	 * @param array $where
	 * @param int $offset
	 * @param int $limit
	 * @return int total records
	 */
	function countAllBlockSections($where='', $offset=0, $limit='')
	{
		// building an insert query
		$flds['count(secID) as ttl_record'] = "";
		
	    $this->fields = $flds;
	    $this->tables = "block_sections";
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
		    return 0;
		}
	}
	
	
	/**
	 * isExist() - function to check the BlockSection name is already exist
	 *
	 * @param string $name
	 * @return bool 
	 */
	function isExist($secName, $schYear, $semCode, $courseID, $yrLevel)
	{
	    if ($secName && $schYear && $semCode && $courseID && $yrLevel) {
    	    // setting conditions
    	    $conds[]['secName']  = " = '$secName' AND ";
    	    $conds[]['schYear']  = " = '$schYear' AND ";
    	    $conds[]['semCode']  = " = '$semCode' AND ";
    	    $conds[]['courseID'] = " = '$courseID' AND ";
    	    $conds[]['yrLevel']  = " = '$yrLevel' ";
    	    
    	    // building an insert query
    	    $this->tables = "block_sections";
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
                        // return true - the block section is already exist            		
                		return true;
                	} else {
                	    // return false - the block section does not exist
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
	    $where[0]['secName']="= '".$this->secName."' AND ";
	    $where[0]['schYear']="= '".$this->schYear."' AND ";
	    $where[0]['yrLevel']="= '".$this->yrLevel."' ";
	    $result = $this->retrieveAllBlockSections($where,'secID','DESC',0,1);

	    return $result[0]['secID'];
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