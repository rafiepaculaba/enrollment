<?php
if (!$_SESSION){
    session_start();
}

// ajax action
$action = $_GET['action'];

if ( (strtoupper($action)=='DISPLAYSTUDENTINFOS') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php'); 
    require_once('../Courses/Course.php'); 
    require_once('../Students/StudentCol.php'); 

    // get parameters
    $idno 		= $_GET['idno'];

    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    
    $where[0]['rstatus'] = "= 1 ";
	
    $stud = new Student();
    $result  = $stud->retrieveAllStudents($where);
        
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
    } else {
    	echo 0;
    }
    
} else if ( strtoupper($action)=='GETSUBJECTS' ) {
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
	require_once('../Curriculums/Prerequisite.php');
    require_once('../Users/User2.php');
	require_once('../Curriculums/CurriculumSubject.php');
	require_once('../Curriculums/Curriculum.php');
    
    // get parameters
    $curID 			= $_GET['curID'];
	
   	if (isset($curID)) {
    
    if ($curID) {
        $where[0]['curID'] = "='$curID' AND";
    }
    $where[0]['rstatus'] = "='1'";
    
    
    $curSubj = new CurriculumSubject($curID);
    $result  = $curSubj->retrieveAllCurriculumSubjects($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
    
    } else {
    	echo 0;
    }

}  else if ((strtoupper($action)=='CHECKDUPLICATE') ) {
    require_once('../../commonAjax.php');
    
	require_once('../Departments/Department.php');
	require_once('../Courses/Course.php');
	require_once('../Students/StudentCol.php');
	require_once('../Registrations/Registration.php');
	require_once('../Subjects/SubjectCol.php');
	require_once('../Users/User2.php');
	require_once('../Curriculums/Prerequisite.php');
	require_once('../Credited/CreditedSubject.php');
	
	$schYear 	= $_GET['schYear'];
	$semCode 	= $_GET['semCode'];
	$idno 		= $_GET['idno'];
	$subjID 	= $_GET['subjID'];
	
	$cre = new CreditedSubject();
    $res  = $cre->isExist($schYear, $semCode, $idno, $subjID);
    echo $res;
}

else {
    echo 0;
}
?>