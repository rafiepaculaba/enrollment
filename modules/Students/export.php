<?php

$conds  = !empty($_SESSION['EXPORT_COND'])? $_SESSION['EXPORT_COND']:"";
$orderby= !empty($_SESSION['EXPORT_ORDERBY'])? $_SESSION['EXPORT_ORDERBY']:"lname";
$sorting= !empty($_SESSION['EXPORT_SORTING'])? $_SESSION['EXPORT_SORTING']:"ASC";
$offset = isset($_SESSION['EXPORT_OFFSET'])? $_SESSION['EXPORT_OFFSET']:"0";
$limit  = isset($_SESSION['EXPORT_LIMIT'])? $_SESSION['EXPORT_LIMIT']:"";

switch ($_GET['level']) {
case 1:
    // elem level
    //require_once('modules/Students/StudentElem.php');
    
    break;
case 2:
    // hs level
    //require_once('modules/Students/StudentHS.php');

    break;
case 3:
    // col level
    require_once('modules/Students/StudentCol.php');
    $stud = new Student();
    $data = $stud->retrieveAllStudents($conds, $orderby, $sorting, $offset, $limit);
     $stud->exportStudents($data);
    //header("index.php?module=Students&action=index");
    break;
default:

}

?>

