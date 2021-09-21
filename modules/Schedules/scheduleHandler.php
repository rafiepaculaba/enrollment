<?php
if (!$_SESSION){
    session_start();
}

// ajax action
$action = $_GET['action'];

if ( strtoupper($action)=='GETSUBJECTS' ) {
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
	require_once('../Curriculums/Prerequisite.php');
    require_once('../Users/User2.php');
	require_once('../Curriculums/CurriculumSubject.php');
	require_once('../Curriculums/Curriculum.php');
    
    // get parameters
    $courseID 	= $_GET['courseID'];
    $curID 		= $_GET['curID'];

    if ($courseID) {
        $where[0]['courseID'] = "='$courseID'";
    } else {
        $where="";
    }
    $subject = new Subject();
    $result  = $subject->retrieveAllSubjects($where,'subjCode');
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( strtoupper($action)=='GETCURRICULUMS' ) {
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
	require_once('../Curriculums/Prerequisite.php');
    require_once('../Users/User2.php');
	require_once('../Curriculums/CurriculumSubject.php');
	require_once('../Curriculums/Curriculum.php');
   
	    // get parameters
    $courseID = $_GET['courseID'];

    if ($courseID) {
        $where[0]['courseID'] = "='$courseID'";
    } else {
        $where="";
    }

    $curriculum = new Curriculum();
    $result  = $curriculum->retrieveAllCurriculums($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
    
} else if ( strtoupper($action)=='VALIDATETIME' ) {

	    // get parameters
    $startTime = $_GET['startTime'];
    $endTime   = $_GET['endTime'];

    if (strtotime($startTime)<strtotime($endTime)) {
		echo 1;
	} else {
		echo -1;
	}
    
} else if (strtoupper($action)=='CHECKDUPLICATE') {
    require_once('../../commonAjax.php');

    require_once('../Departments/Department.php');
	require_once('../Courses/Course.php');
	require_once('../Subjects/SubjectCol.php');
	require_once('../Users/User2.php');
	require_once('../Curriculums/Prerequisite.php');
	require_once('../Curriculums/CurriculumSubject.php');
	require_once('../Curriculums/Curriculum.php');
	require_once('../Schedules/Schedule.php');

	$schYear 	= $_GET['schYear'];
	$semCode 	= $_GET['semCode'];
	$schedCode 	= $_GET['schedCode'];
	
	$sched= new Schedule();
    $res = $sched->isExist($schYear, $semCode, $schedCode);
    
    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEHS') {
    require_once('../../commonAjax.php');

	require_once('../Subjects/SubjectHS.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleHS.php');

	$schYear 	= $_GET['schYear'];
	$schedCode 	= $_GET['schedCode'];
	
	$sched= new Schedule();
    $res = $sched->isExist($schYear, $schedCode);
    
    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEELEM') {
    require_once('../../commonAjax.php');

	require_once('../Subjects/SubjectElem.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleElem.php');

	$schYear 	= $_GET['schYear'];
	$schedCode 	= $_GET['schedCode'];
	
	$sched= new Schedule();
    $res = $sched->isExist($schYear, $schedCode);
    
    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEPRESCHOOL') {
    require_once('../../commonAjax.php');

	require_once('../Subjects/SubjectPreschool.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/SchedulePreschool.php');

	$schYear 	= $_GET['schYear'];
	$schedCode 	= $_GET['schedCode'];
	
	$sched= new Schedule();
    $res = $sched->isExist($schYear, $schedCode);
    
    echo $res;
} else if ( strtoupper($action)=='GETSUBJECTSHS' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectHS.php');
    
    // get parameters
    $yrLevel 	= $_GET['yrLevel'];

    if ($yrLevel) {
        $where[0]['yrLevel'] = "='$yrLevel' AND ";
    } 
    $where[0]['rstatus'] = "='1'";
    
    $subject = new Subject();
    $result  = $subject->retrieveAllSubjects($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( strtoupper($action)=='GETSUBJECTSELEM' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectElem.php');
    
    // get parameters
    $yrLevel 	= $_GET['yrLevel'];

    if ($yrLevel) {
        $where[0]['yrLevel'] = "='$yrLevel' AND ";
    } 
    $where[0]['rstatus'] = "='1'";
    
    $subject = new Subject();
    $result  = $subject->retrieveAllSubjects($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( strtoupper($action)=='GETSUBJECTSPRESCHOOL' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectPreschool.php');
    
    // get parameters
    $yrLevel 	= $_GET['yrLevel'];

    if ($yrLevel) {
        $where[0]['yrLevel'] = "='$yrLevel' AND ";
    } 
    $where[0]['rstatus'] = "='1'";
    
    $subject = new Subject();
    $result  = $subject->retrieveAllSubjects($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( strtoupper($action)=='CHECKCONFLICTCOL' ) {
	require_once('../../commonAjax.php');
    
	require_once('../Config/ConfigCol.php');
	require_once('../Departments/Department.php');
	require_once('../Courses/Course.php');
	require_once('../Subjects/SubjectCol.php');
	require_once('../Students/StudentCol.php');
	require_once('../Users/User2.php');
	require_once('../Curriculums/Prerequisite.php');
	require_once('../Curriculums/CurriculumSubject.php');
	require_once('../Curriculums/Curriculum.php');
	require_once('../Schedules/Schedule.php');
	require_once('../Schedules/BlockSectionCol.php');
	require_once('../Schedules/BlockSectionSubjectCol.php');
	require_once('../Enrollments/EnrollmentDetailCol.php');
	require_once('../Enrollments/EnrollmentCol.php');
    
    // get parameters
    $schYear 	= $_GET['schYear'];
    $semCode 	= $_GET['semCode'];
    $schedCode 	= $_GET['schedCode'];
    $startTime 	= $_GET['startTime'];
    $endTime 	= $_GET['endTime'];
    $onMon	 	= $_GET['onMon'];
    $onTue	 	= $_GET['onTue'];
    $onWed	 	= $_GET['onWed'];
    $onThu	 	= $_GET['onThu'];
    $onFri	 	= $_GET['onFri'];
    $onSat	 	= $_GET['onSat'];
    $onSun	 	= $_GET['onSun'];
    $room	 	= $_GET['room'];
    
    $target['start']	= $startTime;
	$target['end']		= $endTime;
	$target['onMon']	= $onMon;
	$target['onTue']	= $onTue;
	$target['onWed']	= $onWed;
	$target['onThu']	= $onThu;
	$target['onFri']	= $onFri;
	$target['onSat']	= $onSat;
	$target['onSun']	= $onSun;
	
	//Select all schedue contains the room target
	$sched = new Schedule();
	
    $tables[] = 'schedules';

    $fields[' * ']               = "";
    
    $where[0]['room'] = "='$room'";
    
    $sched->tables = $tables;
    $sched->fields = $fields;
    $sched->conds  = $where;
    $sched->order  = $orderby;
    $sched->multi_orders = $multi_orders;
            
    // building an select query
    $query = $sched->Select();  // generate delete sql query
    $sched->reset();            // reset all variables in query generator
    
	try {
	    $sched->db->beginTransaction();
    	$result   = $sched->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$sched->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error. ";
	}
	
	if ($records) {
		$data = array();
		$ctr=0;
		foreach($records as $row) {
			$data[$ctr]=$row;
			$split = explode(":",$row['startTime']);
			$data[$ctr]['startdTime'] = date("h:i A",strtotime($split[0].":".$split[1]));
			
			$split = explode(":",$row['endTime']);
			$data[$ctr]['enddTime'] = date("h:i A",strtotime($split[0].":".$split[1]));
			
			$ctr++;
		}
	}

    //$en = new Enrollment();
    $res  = $sched->isConflict($target, $data, $schYear, $semCode, $schedCode);
    
    echo $res;

} else if ( strtoupper($action)=='CHECKCONFLICTHS' ) {
	require_once('../../commonAjax.php');
    
	require_once('../Config/ConfigHS.php');
	require_once('../Subjects/SubjectHS.php');
	require_once('../Students/StudentHS.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleHS.php');
	require_once('../Schedules/BlockSectionHS.php');
	require_once('../Schedules/BlockSectionSubjectHS.php');
	require_once('../Enrollments/EnrollmentDetailHS.php');
	require_once('../Enrollments/EnrollmentHS.php');
    
    // get parameters
    $schYear 	= $_GET['schYear'];
    $schedCode 	= $_GET['schedCode'];
    $startTime 	= $_GET['startTime'];
    $endTime 	= $_GET['endTime'];
    $onMon	 	= $_GET['onMon'];
    $onTue	 	= $_GET['onTue'];
    $onWed	 	= $_GET['onWed'];
    $onThu	 	= $_GET['onThu'];
    $onFri	 	= $_GET['onFri'];
    $onSat	 	= $_GET['onSat'];
    $onSun	 	= $_GET['onSun'];
    $room	 	= $_GET['room'];
	
    
    $target['start']	= $startTime;
	$target['end']		= $endTime;
	$target['onMon']	= $onMon;
	$target['onTue']	= $onTue;
	$target['onWed']	= $onWed;
	$target['onThu']	= $onThu;
	$target['onFri']	= $onFri;
	$target['onSat']	= $onSat;
	$target['onSun']	= $onSun;
	
	//Select all schedue contains the room target
	$sched = new Schedule();
	
    $tables[] = 'schedules';

    $fields[' * ']               = "";
    
    $where[0]['room'] = "='$room'";
    
    $sched->tables = $tables;
    $sched->fields = $fields;
    $sched->conds  = $where;
    $sched->order  = $orderby;
    $sched->multi_orders = $multi_orders;
            
    // building an select query
    $query = $sched->Select();  // generate delete sql query
    $sched->reset();            // reset all variables in query generator
    
	try {
	    $sched->db->beginTransaction();
    	$result   = $sched->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$sched->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error. ";
	}
	
	if ($records) {
		$data = array();
		$ctr=0;
		foreach($records as $row) {
			$data[$ctr]=$row;
			$split = explode(":",$row['startTime']);
			$data[$ctr]['startdTime'] = date("h:i A",strtotime($split[0].":".$split[1]));
			
			$split = explode(":",$row['endTime']);
			$data[$ctr]['enddTime'] = date("h:i A",strtotime($split[0].":".$split[1]));
			
			$ctr++;
		}
	}

    //$en = new Enrollment();
    $res  = $sched->isConflict($target, $data, $schYear, $schedCode);
    
    echo $res;

} else if ( strtoupper($action)=='CHECKCONFLICTELEM' ) {
	require_once('../../commonAjax.php');
    
	require_once('../Config/ConfigElem.php');
	require_once('../Subjects/SubjectElem.php');
	require_once('../Students/StudentElem.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleElem.php');
	require_once('../Schedules/BlockSectionElem.php');
	require_once('../Schedules/BlockSectionSubjectElem.php');
	require_once('../Enrollments/EnrollmentDetailElem.php');
	require_once('../Enrollments/EnrollmentElem.php');
    
    // get parameters
    $schYear 	= $_GET['schYear'];
    $schedCode 	= $_GET['schedCode'];
    $startTime 	= $_GET['startTime'];
    $endTime 	= $_GET['endTime'];
    $onMon	 	= $_GET['onMon'];
    $onTue	 	= $_GET['onTue'];
    $onWed	 	= $_GET['onWed'];
    $onThu	 	= $_GET['onThu'];
    $onFri	 	= $_GET['onFri'];
    $onSat	 	= $_GET['onSat'];
    $onSun	 	= $_GET['onSun'];
    $room	 	= $_GET['room'];
	
    
    $target['start']	= $startTime;
	$target['end']		= $endTime;
	$target['onMon']	= $onMon;
	$target['onTue']	= $onTue;
	$target['onWed']	= $onWed;
	$target['onThu']	= $onThu;
	$target['onFri']	= $onFri;
	$target['onSat']	= $onSat;
	$target['onSun']	= $onSun;
	
	//Select all schedue contains the room target
	$sched = new Schedule();
	
    $tables[] = 'schedules';

    $fields[' * ']               = "";
    
    $where[0]['room'] = "='$room'";
    
    $sched->tables = $tables;
    $sched->fields = $fields;
    $sched->conds  = $where;
    $sched->order  = $orderby;
    $sched->multi_orders = $multi_orders;
            
    // building an select query
    $query = $sched->Select();  // generate delete sql query
    $sched->reset();            // reset all variables in query generator
    
	try {
	    $sched->db->beginTransaction();
    	$result   = $sched->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$sched->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error. ";
	}
	
	if ($records) {
		$data = array();
		$ctr=0;
		foreach($records as $row) {
			$data[$ctr]=$row;
			$split = explode(":",$row['startTime']);
			$data[$ctr]['startdTime'] = date("h:i A",strtotime($split[0].":".$split[1]));
			
			$split = explode(":",$row['endTime']);
			$data[$ctr]['enddTime'] = date("h:i A",strtotime($split[0].":".$split[1]));
			
			$ctr++;
		}
	}

    //$en = new Enrollment();
    $res  = $sched->isConflict($target, $data, $schYear, $schedCode);
    
    echo $res;

} else if ( strtoupper($action)=='CHECKCONFLICTPRESCHOOL' ) {
	require_once('../../commonAjax.php');
    
	require_once('../Config/ConfigPreschool.php');
	require_once('../Subjects/SubjectPreschool.php');
	require_once('../Students/StudentPreschool.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/SchedulePreschool.php');
	require_once('../Schedules/BlockSectionPreschool.php');
	require_once('../Schedules/BlockSectionSubjectPreschool.php');
	require_once('../Enrollments/EnrollmentDetailPreschool.php');
	require_once('../Enrollments/EnrollmentPreschool.php');
    
    // get parameters
    $schYear 	= $_GET['schYear'];
    $schedCode 	= $_GET['schedCode'];
    $startTime 	= $_GET['startTime'];
    $endTime 	= $_GET['endTime'];
    $onMon	 	= $_GET['onMon'];
    $onTue	 	= $_GET['onTue'];
    $onWed	 	= $_GET['onWed'];
    $onThu	 	= $_GET['onThu'];
    $onFri	 	= $_GET['onFri'];
    $onSat	 	= $_GET['onSat'];
    $onSun	 	= $_GET['onSun'];
    $room	 	= $_GET['room'];
	
    
    $target['start']	= $startTime;
	$target['end']		= $endTime;
	$target['onMon']	= $onMon;
	$target['onTue']	= $onTue;
	$target['onWed']	= $onWed;
	$target['onThu']	= $onThu;
	$target['onFri']	= $onFri;
	$target['onSat']	= $onSat;
	$target['onSun']	= $onSun;
	
	//Select all schedue contains the room target
	$sched = new Schedule();
	
    $tables[] = 'schedules';

    $fields[' * ']               = "";
    
    $where[0]['room'] = "='$room'";
    
    $sched->tables = $tables;
    $sched->fields = $fields;
    $sched->conds  = $where;
    $sched->order  = $orderby;
    $sched->multi_orders = $multi_orders;
            
    // building an select query
    $query = $sched->Select();  // generate delete sql query
    $sched->reset();            // reset all variables in query generator
    
	try {
	    $sched->db->beginTransaction();
    	$result   = $sched->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$sched->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error. ";
	}
	
	if ($records) {
		$data = array();
		$ctr=0;
		foreach($records as $row) {
			$data[$ctr]=$row;
			$split = explode(":",$row['startTime']);
			$data[$ctr]['startdTime'] = date("h:i A",strtotime($split[0].":".$split[1]));
			
			$split = explode(":",$row['endTime']);
			$data[$ctr]['enddTime'] = date("h:i A",strtotime($split[0].":".$split[1]));
			
			$ctr++;
		}
	}

    //$en = new Enrollment();
    $res  = $sched->isConflict($target, $data, $schYear, $schedCode);
    
    echo $res;

} else {
    echo 0;
}
?>
