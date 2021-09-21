<?php
// get parameters

// ajax action
$action = $_GET['action'];

if (strtoupper($action)=='CHECKDUPLICATE') {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php');
	require_once('../Courses/Course.php');
	require_once('../Subjects/SubjectCol.php');

	$subjCode 	= $_GET['subjCode'];
	$courseID 	= $_GET['courseID'];
	$type 		= $_GET['type'];

   $subj= new Subject();
   $res = $subj->isExist($courseID, $subjCode, $type);
   echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEELEM') {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectElem.php');

	$yrLevel 	= $_GET['yrLevel'];
   	$subjCode 	= $_GET['subjCode'];
	$type 		= $_GET['type'];
	
   	$subj= new Subject();
   	$res = $subj->isExist($yrLevel, $subjCode, $type);
    
   	echo $res;
} else if ( strtoupper($action)=='CHECKDUPLICATEHS' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectHS.php');

   	$yrLevel 	= $_GET['yrLevel'];
   	$subjCode 	= $_GET['subjCode'];
	$type 		= $_GET['type'];
	
	$subj= new Subject();
	$res = $subj->isExist($yrLevel, $subjCode, $type);
	
	echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEPRESCHOOL') {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectPreschool.php');

	$yrLevel 	= $_GET['yrLevel'];
   	$subjCode 	= $_GET['subjCode'];
	$type 		= $_GET['type'];
	
   	$subj= new Subject();
   	$res = $subj->isExist($yrLevel, $subjCode, $type);
    
   	echo $res;
} else {
    echo 0;
}
?>