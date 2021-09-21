<?php

/**
 * $esConfig - basic config of the 1Destiny enrollment system
 */
$esConfig = array(
// list of semester in a school year
'semesters' => array(1=>'1st Sem',2=>'2nd Sem',4=>'Summer'),
);


/**
 * $pageLimit - limit number of display in listview in every module
 */
$pageLimit = array(
    'Administration'=> 50,
    'Registrations' => 50,
    'Students'      => 50,
    'Departments'   => 50,
    'Courses'       => 50,
    'Curriculums'   => 50,
    'Subjects'      => 50,
    'Schedules'     => 50,
    'Payments'      => 50,
    'Config'        => 50,
    'Enrollments'   => 50,
    'Account'       => 50,
    'Refunds'       => 50,
    'Credited'      => 50,
    'Grades'        => 50,
    'SchoolFees'    => 50,
);


$terms = array(
'col'   => array(1 =>'Prelim',2 =>'Midterm', 3 =>'PreFi', 4 =>'Final'),
'hs'    => array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5',6  => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10'),
'elem'    => array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5',6  => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10'),
'preschool'    => array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5',6  => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10'),
);


$feeCodes = array(
'tuition' => 'Tuition',
'misc'    => 'Miscellaneous',
'reg'     => 'Registration',
'lab'     => 'Laboratory',
);



// college terms
$term_by_1 = array(
1 => 'Full Payment',
);

// college terms
$term_by_2 = array(
1 => 'Midterm',
2 => 'Final',
);

$term_by_3 = array(
1 => 'Prelim',
2 => 'Midterm',
3 => 'Final',
);

$term_by_4 = array(
1 => 'Prelim',
2 => 'Midterm',
3 => 'PreFinal',
4 => 'Final',
);


// number of years per level
$college_yrs = array(
1 => '1',
2 => '2',
3 => '3',
4 => '4',
5 => '5',
//6 => '6',
);

$highschool_yrs = array(
1 => '1',
2 => '2',
3 => '3',
4 => '4',
//'S' => 'Special',
);

$elementary_yrs = array(
1 => '1',
2 => '2',
3 => '3',
4 => '4',
5 => '5',
6 => '6',
//'S' => 'Special',
);

$preschool_yrs = array(
1 => 'Nursery 1',
2 => 'Nursery 2',
3 => 'Kinder 1',
4 => 'Kinder 2',
//'S' => 'Special',
);

?>
