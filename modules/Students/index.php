<?php


global $current_user;

$access = new AccessChecker();

$ac1=$access->getAccessCode("List Col Student");
$ac2=$access->getAccessCode("List HS Student");
$ac3=$access->getAccessCode("List Elem Student");
$ac4=$access->getAccessCode("List Preschool Student");

if ($access->check_access($current_user->id,$ac1)) {
    include('modules/Students/listStudents.php');    
} else if ($access->check_access($current_user->id,$ac2)) {
    include('modules/Students/listStudentsHS.php');    
} else if ($access->check_access($current_user->id,$ac3)) {
    include('modules/Students/listStudentsElem.php');    
} else if ($access->check_access($current_user->id,$ac4)) {
    include('modules/Students/listStudentsPreschool.php');    
}


?>

