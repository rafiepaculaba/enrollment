<?php
/**
 *
 * Filename: Schedule.php
 * Date: 	 February 06, 2008
 * 
 * Author: 	 Rafie D. Paculaba
 * 
 */

/**
 * Class: Schedule
 * Description: This class is a model of the object - Schedule
 * 				Implementing the active record pattern of database record
 */
class Schedule extends Database 
{
	
	var $schedID;
	var $schYear;
	var $yrLevel;
	var $schedCode;
	var $subjID;
	var $subjCode;
	
	var $profID;
	var $profName;
	
	var $startTime;
	var $startdTime;

	var $endTime;
	var $enddTime;

	var $onMon;
	var $onTue;
	var $onWed;
	var $onThu;
	var $onFri;
	var $onSat;
	var $onSun;
	var $room;
	var $maxCapacity;
	var $noEnrolled;
	var $labFee;
	var $remarks;
	var $preparedBy;
	var $rstatus;
	
	/**
	 * Schedule() constructor of the Schedule class
	 *
	 * @return Schedule
	 */
	function Schedule($id='') 
	{
	    // calling the parent class
	    parent::Database(1); // college level
		
	    // set active record if found
		if ($id) {
			$this->schedID = $id;
			$this->retrieveSchedule();
		}
	}
	
	
    /**
     * createSchedule() method to save the schedule record
     *
     * @return bool - return true if successful otherwise false
     */
	function createSchedule() 
	{
		// setting values to fields
        $info['schYear']     	= $this->schYear;
        $info['yrLevel']     	= $this->yrLevel;
        $info['schedCode']     	= $this->schedCode;
        $info['subjID']    		= $this->subjID;
        $info['profID'] 		= $this->profID;
        $info['startTime'] 		= $this->startTime;
        $info['endTime']     	= $this->endTime;
        $info['onMon']       	= $this->onMon;
        $info['onTue']   	 	= $this->onTue;
        $info['onWed'] 			= $this->onWed;
        $info['onThu'] 			= $this->onThu;
        $info['onFri']     		= $this->onFri;
        $info['onSat']       	= $this->onSat;
        $info['onSun']    		= $this->onSun;
        $info['room'] 			= $this->room;
        $info['maxCapacity'] 	= $this->maxCapacity;
        $info['noEnrolled']     = $this->noEnrolled;
        $info['labFee']     	= $this->labFee;
        $info['remarks']    	= $this->remarks;
		
		// building an insert query
        $this->tables = "schedules";
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
	 * retrieveSchedule() method to retrieve the schedule record and assign to the registrant attributes
	 *
	 */
	function retrieveSchedule($lock='0')
	{
	    // setting conditions
	    $conds[0]['schedID'] = " = ".$this->schedID;
	    
	    // building an insert query
	    $this->tables = "schedules";
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
                    $this->schYear     		= $data[0]['schYear'];
                    $this->yrLevel     		= $data[0]['yrLevel'];
                    $this->schedCode     	= $data[0]['schedCode'];

                    $this->subjID    		= $data[0]['subjID'];

                    $subj = new Subject($data[0]['subjID']);                 
                    $this->subjCode 		= $subj->subjCode;
                    $this->descTitle 		= $subj->descTitle;
                    $this->units 			= $subj->units;

//                    $this->profID 			= $data[0]['profID'];
                    $u = new User2($data[0]['profID']);
                    $this->profID 			= $data[0]['profID'];
                    $this->profName			= htmlentities($u->last_name.", ".$u->first_name);

                    $stime = date("h:i:A",strtotime($data[0]['startTime']));
                    $sdtime = date("h:i A",strtotime($data[0]['startTime']));

                    $this->startTime 		= $stime;
                    $this->startdTime 		= $sdtime;

                    $etime = date("h:i:A",strtotime($data[0]['endTime']));
                    $edtime = date("h:i A",strtotime($data[0]['endTime']));                                    

                    $this->endTime     		= $etime;
                    $this->enddTime     	= $edtime;
                    
                    $this->onMon       		= $data[0]['onMon'];
                    $this->onTue    		= $data[0]['onTue'];
                    $this->onWed 			= $data[0]['onWed'];
                    $this->onThu  			= $data[0]['onThu'];
                    $this->onFri     		= $data[0]['onFri'];
                    $this->onSat       		= $data[0]['onSat'];
                    $this->onSun    		= $data[0]['onSun'];
                    $this->room 			= $data[0]['room'];
                    $this->maxCapacity		= $data[0]['maxCapacity'];
                    $this->noEnrolled       = $data[0]['noEnrolled'];
                    $this->labFee	       	= $data[0]['labFee'];
                    $this->remarks    		= $data[0]['remarks'];
                    $this->rstatus    		= $data[0]['rstatus'];
            		
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
	 * updateSchedule() method to update the schedule record with the active schedID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateSchedule()
	{
	    // setting values to fields
        $info['schYear']     	= $this->schYear;
        $info['yrLevel']     	= $this->yrLevel;
        $info['schedCode']     	= $this->schedCode;
        $info['subjID']    		= $this->subjID;
        $info['profID'] 		= $this->profID;
        
        $info['startTime'] 		= $this->startTime;
        $info['endTime']     	= $this->endTime;
        
        $info['onMon']       	= $this->onMon;
        $info['onTue']   	 	= $this->onTue;
        $info['onWed'] 			= $this->onWed;
        $info['onThu'] 			= $this->onThu;
        $info['onFri']     		= $this->onFri;
        $info['onSat']       	= $this->onSat;
        $info['onSun']    		= $this->onSun;
        $info['room'] 			= $this->room;
        $info['maxCapacity'] 	= $this->maxCapacity;
        $info['noEnrolled']     = $this->noEnrolled;
        $info['labFee']     	= $this->labFee;
        $info['remarks']    	= $this->remarks;
        
        
        if ( $this->noEnrolled >= $this->maxCapacity) {
            $info['rstatus']    = 0; // closed schedule
        } else {
            $info['rstatus']    = 1; // still open
        }
		
		
		// setting conditions
		$conds[]['schedID']  = " = ".$this->schedID;
		
		// building an insert query
        $this->tables = "schedules";
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
	 * updateScheduleStatus() method to update the schedule record with the active schedID
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function updateScheduleStatus()
	{
	    // setting values to fields
        $info['noEnrolled']     = $this->noEnrolled;
        
        if ( $this->noEnrolled >= $this->maxCapacity) {
            $info['rstatus']    = 0; // closed schedule
        } else {
            $info['rstatus']    = 1; // still open
        }
		
		
		// setting conditions
		$conds[]['schedID']  = " = ".$this->schedID;
		
		// building an insert query
        $this->tables = "schedules";
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
	 * deleteSchedule() method to delete the schedule record  witht the active rec_id
	 *
	 * @return bool - return true if successful otherwise false
	 */
	function deleteSchedule()
	{
	    if ( $this->db->beginTransaction() ) {
	       $this->db->rollBack();
	    }
	    
	    // setting conditions
	    $conds[]['schedID'] = " = ".$this->schedID;
	    
	    // building an insert query
	    $this->tables = "schedules";
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
	 * retrieveAllSchedules() method to retrieve all/selected schedule records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllSchedules($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "schedules";
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
	 * retrieveAllSchedulesUserAssociated() method to retrieve all/selected schedule records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllSchedulesUserAssociated($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "schedules";
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

   			    $u->id = $row['profID'];
    		    $u->retrieveUser();

    		    $data[$ctr] = $row;
    		    $data[$ctr]['subjCode']   	= $subj->subjCode;
    		    $data[$ctr]['descTitle']   	= $subj->descTitle;
    		    $data[$ctr]['type']   		= $subj->type;
	   		    $data[$ctr]['profName'] 	= htmlentities($u->last_name.", ".$u->first_name);

    		    $ctr++;
    		}

    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	
	/**
	 * retrieveAllSchedulesSubjectCourseAssociated() method to retrieve all/selected schedule records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllSchedulesSubjectAssociated($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="schedules";
		$tables[]="subjects";
		
		$multiOrder['schedules.schYear']  = "DESC";
		$multiOrder['subjects.subjCode'] = "ASC";
		
		if (count($where[0]) && $where) {
		    $where[0]['AND schedules.subjID'] = "= subjects.subjID ";
		} else {
		    $where[0][' schedules.subjID'] = "= subjects.subjID ";
		}
		
		$flds['schedules.*']  = "";
		$flds['subjects.subjCode']  = "";
		$flds['subjects.descTitle'] = "";
		$flds['subjects.type']      = "";
		
		$this->multi_orders = $multiOrder;
	    $this->tables = $tables;
	    $this->fields = $flds;
	    $this->conds  = $where;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
		
	    // set association
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
	 * retrieveAllSchedulesAssociated() method to retrieve all/selected schedule records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllSchedulesAssociated($where='',$orderby='', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="schedules";
		$tables[]="subjects";
		
		$multiOrder['schedules.schYear']  = "DESC";
		$multiOrder['subjects.subjCode'] = "ASC";
		
		if (count($where[0]) && $where) {
		    $where[0]['AND schedules.subjID'] = "= subjects.subjID ";
		} else {
		    $where[0][' schedules.subjID'] = "= subjects.subjID ";
		}
		
		$flds['schedules.*']  = "";
		$flds['subjects.subjCode']  = "";
		$flds['subjects.descTitle'] = "";
		$flds['subjects.type']      = "";
		
		$this->multi_orders = $multiOrder;
	    $this->tables = $tables;
	    $this->fields = $flds;
	    $this->conds  = $where;
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

   			    $u->id = $row['profID'];
    		    $u->retrieveUser();


    		    $data[$ctr] = $row;
    		    if ($row['profID']) {
	   		      $data[$ctr]['profName'] 	= htmlentities($u->last_name.", ".$u->first_name);
	   		      //$data[$ctr]['preparedBy'] 	= $u->last_name." ,".$u->first_name;
    		    }

    		    $ctr++;
    		}

    		
    		return $data;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}

	/**
	 * countAllSchedulesAssociated() method to count all/selected schedule records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function countAllSchedulesAssociated($where='', $offset=0, $limit='')
	{
		// building an insert query
		$tables[]="schedules";
		$tables[]="subjects";
		
		if (count($where[0]) && $where) {
		    $where[0]['AND schedules.subjID'] = "= subjects.subjID ";
		} else {
		    $where[0][' schedules.subjID'] = "= subjects.subjID ";
		}
		
		$flds['count(schedules.schedCode) as ttl_record']  = "";
		
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
	    $u = new User2();
		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();

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
	 * getLastID() method to retrieve last entered ID
	 *
	 * @return ID
	 */
	function getLastID() 
	{
	    $where[0]['schYear'] = "= '".$this->schYear."' AND ";
	    $where[0]['schedCode'] = "= '".$this->schedCode."'";
	    
	    $result = $this->retrieveAllSchedules($where,'schedID','DESC',0,1);
	    return $result[0]['schedID'];
	}	

	/**
	 * isExist() - function to check the courseCode is already exist
	 *
	 * @param string $lname
	 * @param string $fname
	 * @param string $mname
	 * @return bool 
	 */
	function isExist($schYear, $schedCode)
	{
	    if ($schYear && $schedCode) {
    	    // setting conditions
    	    $conds[]['schYear'] = " = '$schYear' AND ";
    	    $conds[]['schedCode'] = " = '$schedCode'";
    	    
    	    // building an insert query
    	    $this->tables = "schedules";
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
    		    return false;
    		}
	    } else {
	        return false;
	    }
	    
	}
	
	/**
     * isConflict() - method that will check is the newly added sched is conflict room assignmentto the existing
     * @param array $schYear
     * @param array $target
     * @param array $scheds
     * @return integer [1|0] 
     */
    function isConflict($target, $scheds, $schYear, $schedCode)
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
            
            if ($scheds[$i]['schYear'] == $schYear && $scheds[$i]['schedCode'] != $schedCode) {
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
        }
        
        return $isConflict;
    }
	
}
?>