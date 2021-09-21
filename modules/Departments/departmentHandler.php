<?php
// get parameters
$deptCode = $_GET['deptCode'];

// ajax action
$action = $_GET['action'];

if ( $deptCode && (strtoupper($action)=='CHECKDUPLICATE') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php');
	
    $dept= new Department();
    $res = $dept->isExist($deptCode);
    echo $res;
} else {
    echo 0;
}
?>