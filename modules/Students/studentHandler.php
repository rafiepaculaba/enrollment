<?php
// get parameters
$idno = $_GET['idno'];

// ajax action
$action = $_GET['action'];

if ( $idno && (strtoupper($action)=='CHECKDUPLICATE_COL') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Students/StudentCol.php'); 
    
    $stud= new Student($idno);
    $res = $stud->isExist($idno);
    echo $res;
} else if ( $idno && (strtoupper($action)=='CHECKDUPLICATE_HS') ) {
    require_once('../../commonAjax.php');
    require_once('../Students/StudentHS.php'); 
    
    $stud= new Student($idno);
    $res = $stud->isExist($idno);
    echo $res;
} else if ( $idno && (strtoupper($action)=='CHECKDUPLICATE_ELEM') ) {
    require_once('../../commonAjax.php');
    require_once('../Students/StudentElem.php'); 
    
    $stud= new Student($idno);
    $res = $stud->isExist($idno);
    echo $res;
} else if ( $idno && (strtoupper($action)=='CHECKDUPLICATE_PRESCHOOL') ) {
    require_once('../../commonAjax.php');
    require_once('../Students/StudentPreschool.php'); 
    
    $stud= new Student($idno);
    $res = $stud->isExist($idno);
    echo $res;
} else if ( strtoupper($action)=='GETCURRICULUMS' ) {
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Students/StudentCol.php');
    require_once('../Registrations/Registration.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    
    $courseID = $_GET['courseID'];
    
    $curriculum = new Curriculum();
    
    if ($courseID) {
        $where[]['courseID'] = "='$courseID'";
    }
    
    $result     = $curriculum->retrieveAllCurriculums($where);
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
} else {
    echo 0;
}
?>
