<?php
class User_model extends Model 
{
	var $userID;
	var $userName;
	var $userPswd;
	var $groupID;
	var $lastName;
	var $firstName;
	var $middleName;
	var $telNum;
	var $localNum;
	var $rstatus;

    function User_model($id='')
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database();
    }
    
    function create()
    {
    	$data['userID'] 	= $this->userID;
       	$data['is_admin'] 	= $this->is_admin;
       	$data['userName'] 	= $this->userName;
       	$data['userPswd'] 	= $this->userPswd;
       	$data['groupID'] 	= $this->groupID;
       	$data['lastName'] 	= $this->lastName;
       	$data['firstName'] 	= $this->firstName;
       	$data['middleName'] = $this->middleName;
       	$data['telNum'] 	= $this->telNum;
       	$data['localNum'] 	= $this->localNum;
       	$data['rstatus'] 	= $this->rstatus;
        $this->db->insert('users', $data); 
    }
    
    function retrieve($id)
    {
    	$query = $this->db->query("SELECT * FROM `users` Where userID = '".$id."' ");
    	$row = $query->result();
    	
    	if ($row && $id) {
        	$this->userID      = $row[0]->userID;
        	$this->userName    = $row[0]->userName;
        	$this->userPswd = $row[0]->userPswd;
        	$this->groupID = $row[0]->groupID;
        	$this->lastName = $row[0]->lastName;
        	$this->firstName = $row[0]->firstName;
        	$this->middleName = $row[0]->middleName;
        	$this->telNum = $row[0]->telNum;
        	$this->localNum = $row[0]->localNum;
        	$this->rstatus = $row[0]->rstatus;
    	}
    }
    
    function update($id = '')
    {
    	$data['userID'] 	= $id;
       	$data['userName'] 	= $this->userName;
       	$data['userPswd'] 	= $this->userPswd;
       	$data['groupID'] 	= $this->groupID;
       	$data['lastName'] 	= $this->lastName;
       	$data['firstName'] 	= $this->firstName;
       	$data['middleName'] = $this->middleName;
       	$data['telNum'] 	= $this->telNum;
       	$data['localNum'] 	= $this->localNum;
       	$data['rstatus'] 	= $this->rstatus;
       	
       	$this->db->where('userID', $id);
        $this->db->update('users', $data); 
    }

	function delete($id)
    {
    	$this->db->where('userID', $id);
		$this->db->delete('users'); 
    }    
    
    function retrieveAll($offset=0, $limit=50)
    {
    	$query = $this->db->get("students");
//    	echo $this->db->last_query();
    	return $query->result();
    }

    function retrieveAllStudents()
    {
//    	$this->db->limit(100);
    	$query = $this->db->get('students');
//    	echo $this->db->last_query();
    	return $query->result();
    }

    function isExist($userName)
    {
    	$this->db->where('userName', $userName);
    	$this->db->select('userID');
		$query = $this->db->get('users'); 

		if($query->result()) {
			return 1;
		} else {
			return 0;
		}
    }
    
    function getlastID($userName)
    {
    	$this->db->where('userName', $userName);
    	$this->db->select('userID');
		$query = $this->db->get('users',1); 
		return $query->result();
    }
    
    function addUserRole($role_id, $user_id)
	{
	    if ($role_id && $user_id) {
    	    // setting values to fields
//    	    $data['id']      = $id;
    		$data['roleID'] = $role_id;
    		$data['userID'] = $user_id;
    		$data['rstatus'] = $this->rstatus;
    		$this->db->insert('user_roles', $data); 
	    }
	}
	
    function retrieveAllUserRole()
    {
    	$query = $this->db->get("user_roles");
    	return $query->result();
    }
    
    function retrieveAllRole($id)
    {
        $query = $this->db->query("Select r.* from user_roles ur, roles r where ur.userID='$id' and ur.roleID=r.roleID");    	
    	return $query->result();
    }

    
    function retrieveRole($id)
    {   
    	$query = $this->db->query("Select r.* from user_roles ur, roles r where ur.userID='$id' and ur.roleID=r.roleID");
    	$records = $query->result();

    	$str = "";
	    $ctr = 0;
    	if ($records) {
    	   
    	   foreach ($records as $row) {
    	       if ($ctr>0) {
    	           $str .= ",".$row->roleID; 
	           } else {
	               $str .= $row->roleID; 
	           }
	           $ctr++;
    	   }
    	}
    	
    	if ($str) {
    	   $query = $this->db->query("Select * from roles where roleID not in ($str)");
    	} else {
    	   $query = $this->db->query("Select * from roles");
    	}
    	
    	$records = $query->result();
    	return $records;
    }
    
    function insertUserRole($roleids,$userid)
    {
        foreach ($roleids as $id) {
            $data['roleID'] 	= $id;
    	    $data['userID'] 	= $userid;
            $this->db->insert('user_roles', $data); 
        }
    	
    }
    function deleteRole($roleids)
    {
        if($roleids){
            foreach ($roleids as $id) {
            $this->db->where('roleID', $id);
            $this->db->delete('user_roles');
        }
        }
    }
    
    function isExistRole($userID, $roleID) {
        $query = $this->db->query("Select * from user_roles where userID = '$userID' and roleID = '$roleID'");
        if($query->result()) {
            return 1;
        } else {
            return 0;
        }
    }
    
    function deleteAllRole($userID)
    {
        if($userID) {
            $this->db->where('userID', $userID);    
            $this->db->delete('user_roles');
        }
    }
 
/*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*/


    // This method will retrieve Course
    function retrieveCourse($courseID)
    {
    	$query = $this->db->query("SELECT * FROM `courses` Where courseID = '".$courseID."' ");
    	return $query->result();
    }

    // This method will retrieve Curriculum
    function retrieveCurriculum($curID)
    {
    	$query = $this->db->query("SELECT * FROM `curriculums` Where curID = '".$curID."'");
    	return $query->result();
    }
 
    // This method will retrieve courseID from Curriculum
    function retrieveCurriculumDetail($curID)
    {
    	$query = $this->db->query("SELECT * FROM `curriculum_subjs` Where curID = '".$curID."' and (yrLevel = '1' and semCode = '1')");
    	return $query->result();
    }
 
    // This method will retrieve Miscellaneous
    function retrieveMiscellaneous()
    {
    	$query = $this->db->get("`misc`");
    	return $query->result();
    }
    
    // This method will retrieve school fees
    function retrieveSchool_fees()
    {
    	$query = $this->db->get("`school_fees`");
    	return $query->result();
    }
    
    // This method will retrieve Accounts
    function retrieveAccounts($accID)
    {
    	$query = $this->db->query("SELECT * FROM `accounts` Where accID = '".$accID."' ");
    	return $query->result();
    }
    
     // This method will retrieve from Account Detail
    function retrieveAccountDetail()
    {
    	$query = $this->db->get("`account_details`");
    	return $query->result();
    }
    
      // This method will retrieve additional_fees from Account Detail
    function retrieveAccountDetail_Add($accID)
    {
    	$query = $this->db->query("SELECT * FROM `account_details` Where accID = '".$accID."' and feeType = 'Add'");
    	return $query->result();
    }
    
    
      // This method will retrieve less_adjustments from Account Detail
    function retrieveAccountDetail_Less($accID)
    {
    	$query = $this->db->query("SELECT * FROM `account_details` Where accID = '".$accID."' and feeType = 'Less'");
    	return $query->result();
    }
    
    // This method will retrieve List of Assessments
    function retrieveAssessmentList($idno)
    {
    	$query = $this->db->query("SELECT * FROM `assessments` Where idno = '".$idno."' ");
    	return $query->result();
    }
    
    // This method will retrieve Assessment
    function retrieveAssessment($assID)
    {
    	$query = $this->db->query("SELECT * FROM `assessments` Where assID = '".$assID."'");
    	return $query->result();
    }
    
     // This method will retrieve List of Payments
    function retrievePaymentList($orno)
    {
    	$query = $this->db->query("SELECT * FROM `ordetails` Where orno = '".$orno."'");
    	return $query->result();
    }
    
    // This method will retrieve Payment
    function retrievePayment($orno, $idno)
    {
    	$query = $this->db->query("SELECT * FROM `orheader` Where orno = '".$orno."' and idno = '".$idno."'");
    	return $query->result();
    }
    
    // This method will retrieve All Payments
    function retrieveAllPayment()
    {
    	$query = $this->db->get("`orheader`");
    	return $query->result();
    }
   
    // This method will retrieve Enrollment
    function retrieveEnrollment($idno)
    {
    	$query = $this->db->query("SELECT * FROM `enrollments` Where idno = '".$idno."'");
    	return $query->result();
    }
   
    // This method will retrieve Enrollment Detail
    function retrieveEnrollmentDetail($enID)
    {
    	$query = $this->db->query("SELECT * FROM `enrollment_details` Where enID = '".$enID."'");
    	return $query->result();
    }
   
    // This method will retrieve block section
    function retrieveBlockSection($secID)
    {
    	$query = $this->db->query("SELECT * FROM `block_sections` Where secID = '".$secID."'");
    	return $query->result();
    }

    // This method will retrieve block section
    function retrieveBlockSectionDetails($schedID)
    {
    	$query = $this->db->query("SELECT * FROM `block_sections_details` Where schedID = '".$schedID."'");
//    	echo $this->db->last_query();
    	return $query->result();
    }

    // This method will retrieve Schedules
    function retrieveSchedules($schedID)
    {
    	$query = $this->db->query("SELECT * FROM `schedules` Where schedID = '".$schedID."'");
    	return $query->result();
    }
    
    
    // This method will retrieve Schedules
    function retrieveSchedulesSubj($subjID)
    {
    	$query = $this->db->query("SELECT * FROM `schedules` Where subjID = '".$subjID."'");
    	return $query->result();
    }
    
    // This method will retrieve Subjects for reservation
    function retrieveSubjects($subjID)
    {
    	$query = $this->db->query("SELECT * FROM `subjects` Where subjID = '".$subjID."'");
    	return $query->result();
    }
       
    // This method will retrieve all subjects for SOA
    function retrieveCompSubj($idno, $schYear, $semCode)
    {
//    	$this->db->select('*');
//		$this->db->from('subjects');
//		$this->db->join('enrollement_details', 'subjects.subjID = enrollment_details.subjID');
    	$query = $this->db->query("SELECT sum(subjects.units) as ttl FROM `enrollment_details` INNER JOIN `enrollments` ON (enrollment_details.enID = enrollments.enID) INNER JOIN `subjects` ON (enrollment_details.subjID = subjects.subjID) WHERE (enrollments.idno ='$idno' AND enrollments.schYear ='$schYear' AND enrollments.semCode ='$semCode' AND enrollments.rstatus >0 AND subjects.isCompSubj =1) GROUP BY enrollments.idno");
    	return $query->result();
    }  
    
    // This method will retrieve Subjects by course
    function retrieveSubjByCourse($courseID)
    {
    	$query = $this->db->query("SELECT * FROM `subjects` Where courseID = '".$courseID."'");
    	return $query->result();
    }
    
    // This method will retrieve Fnal Grade from TOR
    function retrieveTOR($idno, $subjID)
    {
    	$query = $this->db->query("SELECT * FROM `tor` Where idno = '".$idno."' and subjID = '".$subjID."'");
    	return $query->result();
    }
 
    // This method will retrieve yrLevel and semCode from EnrollmentDetail
    function retrieveYrLevelSemCode($idno)
    {
    	$query = $this->db->query("SELECT * FROM `enrollments` Where idno = '".$idno."' and rstatus = '2'");
    	return $query->result();
    }
    
	// This method will retrieveall Curriculun
    function retrieveAllCurriculumSubj()
    {
    	$query = $this->db->get("`curriculum_subjs`");
    	return $query->result();
    }
    
    // This method will retrieveall Enrollment
    function retrieveAllEnrollment()
    {
    	$query = $this->db->get("`enrollments`");
//    	echo $this->db->last_query();
    	return $query->result();
    }
     // This method will retrieve Enrollment
    function retrieveEnrollments($idno, $schYear, $semCode)
    {
    	$query = $this->db->query("SELECT * FROM `enrollments` Where idno = '$idno' and schYear = '$schYear' and semCode = '$semCode' and rstatus > 0");
//    	echo $this->db->last_query();
    	return $query->result();
    }
    // This method will retrieveall Enrollment Detail
    function retrieveAllEnrollmentDetail()
    {
    	$query = $this->db->get("`enrollment_details`");
    	return $query->result();
    }
     
    // This method will retrieveall TOR
    function retrieveAllTOR($idno)
    { 
    	$query = $this->db->query("SELECT * FROM `tor` Where idno = '".$idno."'  and semCode = '".$semCode."' and subjID = '".$subjID."'");
    	return $query->result();
    }
    
    
    function checkTORs($subjID, $idno)
	{
		$this->db->where('title', "Failed Grades");
	 	$fg = $this->retrieveConfigurations();
	 	
        $failed_grades = explode("," , $fg[0]->definition);
        $grades = "";
        if ($failed_grades) {
            $ctr=0;
            foreach ($failed_grades as $data) {
            	$isNum = false;
            	
                if (is_numeric($data)) {
                    $data1 = $data; 					// actual data
                    $data = number_format($data,1);		// formatted data
                    $isNum = true;
                }
                
                if ($ctr) {
                    $grades .= ",'".trim($data)."'";
                    if ($isNum) {
                    	$grades .= ",'".trim($data1)."'";
                    }
                } else {
                    $grades .= "'".trim($data)."'";
                    if ($isNum) {
                    	$grades .= ",'".trim($data1)."'";
                    }
                }
                
                $ctr++;
            }
        }
        
        if ($grades) {
        	$query = $this->db->query("SELECT * FROM tor where subjID='$subjID' and idno='$idno' and fgrade not in ($grades)");
        	$records = $query->result();
    	
	    	if ($records)
	    		  return $records[0]->fgrade;
        } else {
			return false;
        }
        
	}
	
	
	function getTOR($idno)
	{
		$this->db->where('title', "Failed Grades");
	 	$fg = $this->retrieveConfigurations();
	 	
        $failed_grades = explode("," , $fg[0]->definition);
        $grades = "";
        if ($failed_grades) {
            $ctr=0;
            foreach ($failed_grades as $data) {
            	$isNum = false;
            	
                if (is_numeric($data)) {
                    $data1 = $data; 					// actual data
                    $data = number_format($data,1);		// formatted data
                    $isNum = true;
                }
                
                if ($ctr) {
                    $grades .= ",'".trim($data)."'";
                    if ($isNum) {
                    	$grades .= ",'".trim($data1)."'";
                    }
                } else {
                    $grades .= "'".trim($data)."'";
                    if ($isNum) {
                    	$grades .= ",'".trim($data1)."'";
                    }
                }
                
                $ctr++;
            }
        }
        
        
        $q = "SELECT * FROM tor where idno='$idno' ";
        
        if ($grades) {
			$q .=  " and fgrade not in ($grades)";        	
        }
        
        $query = $this->db->query($q);
        $records = $query->result();
        
    	return $records;
        
	}
	
	function checkEquivalence($targetSubject, $passed_subjects)
	{
    	$q = "select count(subjID) as ret from equivalency where eqSubjID='$targetSubject' and subjID in ($passed_subjects)";
	    
    	$query = $this->db->query($q);
        $records = $query->result();
    	return $records[0]->ret;
        
	}
	
     
    // This method will retrieveall Course
    function retrieveAllCourse()
    {
    	$query = $this->db->get("`courses`");
    	return $query->result();
    }
    
    // This method will retrieveall Sections
    function retrieveAllSections()
    {
    	$query = $this->db->get("`block_sections`");
    	return $query->result();
    }
    
    // This method will retrieve prerequisites
    function retrievePrerequisites($curID, $subjID)
    {
    	$query = $this->db->query("SELECT * FROM `prerequisites` Where curID = '".$curID."' and subjID = '".$subjID."'");
    	return $query->result();
    }
     
    // This method will retrieve Configurations
    function retrieveConfigurations()
    {
    	$query = $this->db->get("`configurations`");
    	return $query->result();
    }
}

?>