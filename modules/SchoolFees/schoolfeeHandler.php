<?php

// ajax action
$action = $_GET['action'];

if (strtoupper($action)=='CHECKDUPLICATECOL') {
    require_once('../../commonAjax.php');
    
	require_once('../Departments/Department.php');
	require_once('../Courses/Course.php');
	require_once('../SchoolFees/SchoolFeeCol.php');
	
    // get parameters
	$schYear 	= $_GET['schYear'];
	$courseID 	= $_GET['courseID'];
	$yrLevel 	= $_GET['yrLevel'];
	$item 		= $_GET['item'];

    $schoolfee= new SchoolFee();
    $res = $schoolfee->isExist($schYear, $courseID, $yrLevel, $item);
    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEHS') {
    require_once('../../commonAjax.php');
    
	require_once('../SchoolFees/SchoolFeeHS.php');
	
    // get parameters
	$schYear 	= $_GET['schYear'];
	$yrLevel 	= $_GET['yrLevel'];
	$item 		= $_GET['item'];

    $schoolfee= new SchoolFee();
    $res = $schoolfee->isExist($schYear, $yrLevel, $item);
    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEELEM') {
    require_once('../../commonAjax.php');
    
	require_once('../SchoolFees/SchoolFeeElem.php');
	
    // get parameters
	$schYear 	= $_GET['schYear'];
	$yrLevel 	= $_GET['yrLevel'];
	$item 		= $_GET['item'];

    $schoolfee= new SchoolFee();
    $res = $schoolfee->isExist($schYear, $yrLevel, $item);
    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEPRESCHOOL') {
    require_once('../../commonAjax.php');
    
	require_once('../SchoolFees/SchoolFeePreschool.php');
	
    // get parameters
	$schYear 	= $_GET['schYear'];
	$yrLevel 	= $_GET['yrLevel'];
	$item 		= $_GET['item'];

    $schoolfee= new SchoolFee();
    $res = $schoolfee->isExist($schYear, $yrLevel, $item);
    echo $res;
} else if (strtoupper($action)=='SELECTSCHEDULECOL') {
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
	
    // get parameters
	$schYear 	= $_GET['schYear'];
	$semCode 	= $_GET['semCode'];

  	$sched = new Schedule();
	
    $tables[] = 'subjects';
    $tables[] = 'schedules';
    
    $multi_orders['schedules.schedCode'] = "ASC";
    
    $fields['schedules.*']               = "";
    $fields['subjects.subjCode']         = "";
    
    $where[0]['schedules.subjID']    = "=subjects.subjID AND ";
    $where[0]['schedules.schYear']   = "= '".$schYear."' AND ";
    $where[0]['schedules.semCode']   = "= '".$semCode."' AND ";
    $where[0]['schedules.labFee']    = " <= '0' AND ";
    $where[0]['subjects.type']       = "= '2'"; //Laboratory Subject
    
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
	    echo "SQL query error.";
	}
  
	$j = new Services_JSON;
    $res = $j->encode($records);
    
    echo $res;

} else if (strtoupper($action)=='DISPLAYSCHEDULECOL') {
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
	
    // get parameters
	$schedID 	= $_GET['schedID'];
	
	if ($schedID) {
        $where[0]['schedules.schedID'] = "='$schedID' AND ";
    }
    $where[0]['schedules.rstatus'] = "='1'";
    
    $sched = new Schedule();
    $result  = $sched->retrieveAllSchedulesAssociated($where);
	
	$j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;

} else if (strtoupper($action)=='SELECTSCHEDULEHS') {
    require_once('../../commonAjax.php');
    
	require_once('../Config/ConfigHS.php');
	require_once('../Subjects/SubjectHS.php');
	require_once('../Students/StudentHS.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleHS.php');
	require_once('../Schedules/BlockSectionHS.php');
	require_once('../Schedules/BlockSectionSubjectHS.php');
	
    // get parameters
	$schYear 	= $_GET['schYear'];

  	$sched = new Schedule();
	
    $tables[] = 'subjects';
    $tables[] = 'schedules';
    
    $multi_orders['schedules.schedCode'] = "ASC";
    
    $fields['schedules.*']               = "";
    
    $where[0]['schedules.subjID']     = "=subjects.subjID AND ";
    $where[0]['schedules.schYear']    = "= '".$schYear."' AND ";
    $where[0]['schedules.labFee']     = " <= '0' AND ";
    $where[0]['subjects.type']        = "=2"; //Laboratory Subject
    
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
	    echo "SQL query error.";
	}
  
	$j = new Services_JSON;
    $res = $j->encode($records);
    
    echo $res;

} else if (strtoupper($action)=='DISPLAYSCHEDULEHS') {
    require_once('../../commonAjax.php');
    
	require_once('../Config/ConfigHS.php');
	require_once('../Subjects/SubjectHS.php');
	require_once('../Students/StudentHS.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleHS.php');
	require_once('../Schedules/BlockSectionHS.php');
	require_once('../Schedules/BlockSectionSubjectHS.php');

    // get parameters
	$schedID 	= $_GET['schedID'];
	
	if ($schedID) {
        $where[0]['schedules.schedID'] = "='$schedID' AND ";
    }
    $where[0]['schedules.rstatus'] = "='1'";
    
    $sched = new Schedule();
    $result  = $sched->retrieveAllSchedulesAssociated($where);
	
	$j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;

} else if (strtoupper($action)=='SELECTSCHEDULEELEM') {
    require_once('../../commonAjax.php');
    
	require_once('../Config/ConfigElem.php');
	require_once('../Subjects/SubjectElem.php');
	require_once('../Students/StudentElem.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleElem.php');
	require_once('../Schedules/BlockSectionElem.php');
	require_once('../Schedules/BlockSectionSubjectElem.php');
	
    // get parameters
	$schYear 	= $_GET['schYear'];

  	$sched = new Schedule();
	
    $tables[] = 'subjects';
    $tables[] = 'schedules';
    
    $multi_orders['schedules.schedCode'] = "ASC";
    
    $fields['schedules.*']               = "";
    
    $where[0]['schedules.subjID']     = "=subjects.subjID AND ";
    $where[0]['schedules.schYear']    = "= '".$schYear."' AND ";
    $where[0]['schedules.labFee']     = " <= '0' AND ";
    $where[0]['subjects.type']        = "=2"; //Laboratory Subject
    
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
	    echo "SQL query error.";
	}
  
	$j = new Services_JSON;
    $res = $j->encode($records);
    
    echo $res;

} else if (strtoupper($action)=='DISPLAYSCHEDULEELEM') {
    require_once('../../commonAjax.php');
    
	require_once('../Config/ConfigElem.php');
	require_once('../Subjects/SubjectElem.php');
	require_once('../Students/StudentElem.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleElem.php');
	require_once('../Schedules/BlockSectionElem.php');
	require_once('../Schedules/BlockSectionSubjectElem.php');

    // get parameters
	$schedID 	= $_GET['schedID'];
	
	if ($schedID) {
        $where[0]['schedules.schedID'] = "='$schedID' AND ";
    }
    $where[0]['schedules.rstatus'] = "='1'";
    
    $sched = new Schedule();
    $result  = $sched->retrieveAllSchedulesAssociated($where);
	
	$j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;

} else if (strtoupper($action)=='CHECKDUPLICATEMISCCOL') {
    require_once('../../commonAjax.php');
    
	require_once('../Departments/Department.php');
	require_once('../Courses/Course.php');
	require_once('../SchoolFees/MiscFeeCol.php');
	
    // get parameters
	$schYear 	= $_GET['schYear'];
	$courseID 	= $_GET['courseID'];
	$yrLevel 	= $_GET['yrLevel'];
	$particular	= $_GET['particular'];

    $misc = new MiscFee();
    $res = $misc->isExist($schYear, $courseID, $yrLevel, $particular);
    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEMISCHS') {
    require_once('../../commonAjax.php');
    
	require_once('../SchoolFees/MiscFeeHS.php');
	
    // get parameters
	$schYear 	= $_GET['schYear'];
	$yrLevel 	= $_GET['yrLevel'];
	$particular	= $_GET['particular'];

    $misc = new MiscFee();
    $res = $misc->isExist($schYear, $yrLevel, $particular);
    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEMISCELEM') {
    require_once('../../commonAjax.php');
    
	require_once('../SchoolFees/MiscFeeElem.php');
	
    // get parameters
	$schYear 	= $_GET['schYear'];
	$yrLevel 	= $_GET['yrLevel'];
	$particular	= $_GET['particular'];

    $misc = new MiscFee();
    $res = $misc->isExist($schYear, $yrLevel, $particular);
    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEMISCPRESCHOOL') {
    require_once('../../commonAjax.php');
    
	require_once('../SchoolFees/MiscFeePreschool.php');
	
    // get parameters
	$schYear 	= $_GET['schYear'];
	$yrLevel 	= $_GET['yrLevel'];
	$particular	= $_GET['particular'];

    $misc = new MiscFee();
    $res = $misc->isExist($schYear, $yrLevel, $particular);
    echo $res;
} else {
    echo 0;
}
?>