<?php
// get parameters
$courseCode = $_GET['courseCode'];

// ajax action
$action = $_GET['action'];

if ( $courseCode && (strtoupper($action)=='CHECKDUPLICATE') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php');
	require_once('../Courses/Course.php');

    $course= new Course();
    $res = $course->isExist($courseCode);
    echo $res;
} else {
    echo 0;
}
?>