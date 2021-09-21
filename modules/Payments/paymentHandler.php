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
    $idno = $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno'";
    
    $stud = new Student($idno);
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;
    } else {
    	echo 0;
    }
    
} else if ( (strtoupper($action)=='DISPLAYACCOUNTS') ) {
	require_once('../../commonAjax.php');

    require_once('../Users/User2.php');
    require_once('../Account/Assessment.php');
    // get parameters
    $schYear 	= $_GET['schYear'];
    $semCode 	= $_GET['semCode'];
    $idno 		= $_GET['idno'];
	$term 		= $_GET['term'];
	
	if (($schYear !="") && ($semCode != "") && ($idno != "") && ($term != '')  ) {
		
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' AND ";
    }    
    if ($semCode) {
        $where[0]['semCode'] = "='$semCode' AND ";
    }    
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
    if ($term) {
        $where[0]['term'] = "='$term' AND ";
    }
        $where[0]['rstatus'] = ">='1'";    
	
    $ass = new Assessment();
    $result  = $ass->retrieveAllAssessments($where,'assID','DESC','',1);
    
    if ($result) {
    	$data = array();
    	$ctr = 0;
    	foreach ($result as $row) {
    		$data[$ctr]=$row;
    		$data[$ctr]['amtPaid'] = number_format($row['amtPaid'],2);
    		$data[$ctr]['balance'] = number_format($row['balance'],2);
    		$data[$ctr]['ttlDue']  = number_format($row['ttlDue'],2);
    		$ctr++;
    	}
    }
    
    $j = new Services_JSON;
    $res = $j->encode($data);
    echo $res;
    
    } else	{ 
    echo 0;
    }
} else if ( (strtoupper($action)=='DISPLAYSTUDENTINFOSHS') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentHS.php'); 

    // get parameters
    $idno = $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno'";
    
    $stud = new Student($idno);
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;
    }
    
    else {
    	echo 0;
    }
    
} else if ( (strtoupper($action)=='DISPLAYACCOUNTSHS') ) {
	require_once('../../commonAjax.php');
    require_once('../Account/AssessmentHS.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $idno = $_GET['idno'];
	$term = $_GET['term'];
	
if (($schYear != "") && ($idno != "") && ($term != '')  ) {
		
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' AND ";
    }    
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
    if ($term) {
        $where[0]['term'] = "='$term' AND ";
    }
        $where[0]['rstatus'] = ">='1'";    
	
    $ass = new Assessment();
    $result  = $ass->retrieveAllAssessments($where,'assID','DESC','',1);
	
    if ($result) {
    	$data = array();
    	$ctr = 0;
    	foreach ($result as $row) {
    		$data[$ctr]=$row;
    		$data[$ctr]['balance'] = number_format($row['balance'],2);
    		$data[$ctr]['ttlDue']  = number_format($row['ttlDue'],2);
    		$ctr++;
    	}
    }
    
    $j = new Services_JSON;
    $res = $j->encode($data);
    echo $res;
    
    } else	{ 
    echo 0;
    }
} else if ( (strtoupper($action)=='DISPLAYSTUDENTINFOSELEM') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentElem.php'); 

    // get parameters
    $idno = $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno'";
    
    $stud = new Student($idno);
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;
    }
    
    else {
    	echo 0;
    }
    
} else if ( (strtoupper($action)=='DISPLAYSTUDENTINFOSPRESCHOOL') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentPreschool.php'); 

    // get parameters
    $idno = $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno'";
    
    $stud = new Student($idno);
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;
    }
    
    else {
    	echo 0;
    }
    
} else if ( (strtoupper($action)=='DISPLAYACCOUNTSELEM') ) {
	require_once('../../commonAjax.php');
	
    require_once('../Account/AssessmentElem.php');
    // get parameters
    $schYear = $_GET['schYear'];
    $idno = $_GET['idno'];
	$term = $_GET['term'];
	
if (($schYear != "") && ($idno != "") && ($term != '')  ) {
		
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' AND ";
    }    
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
    if ($term) {
        $where[0]['term'] = "='$term' AND ";
    }
        $where[0]['rstatus'] = ">='1'";    
	
    $ass = new Assessment();
    $result  = $ass->retrieveAllAssessments($where,'assID','DESC','',1);
    
    if ($result) {
    	$data = array();
    	$ctr = 0;
    	foreach ($result as $row) {
    		$data[$ctr]=$row;
    		$data[$ctr]['balance'] = number_format($row['balance'],2);
    		$data[$ctr]['ttlDue']  = number_format($row['ttlDue'],2);
    		$ctr++;
    	}
    }

    $j = new Services_JSON;
    $res = $j->encode($data);
    echo $res;
    
    } else	{ 
    echo 0;
    }
} else if ( (strtoupper($action)=='DISPLAYACCOUNTSPRESCHOOL') ) {
	require_once('../../commonAjax.php');
	
    require_once('../Account/AssessmentPreschool.php');
    // get parameters
    $schYear = $_GET['schYear'];
    $idno = $_GET['idno'];
	$term = $_GET['term'];
	
	if (($schYear != "") && ($idno != "") && ($term != '')  ) {
	    if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	    }    
	    if ($idno) {
	        $where[0]['idno'] = "='$idno' AND ";
	    }
	    if ($term) {
	        $where[0]['term'] = "='$term' AND ";
	    }
	        $where[0]['rstatus'] = ">='1'";    
		
	    $ass = new Assessment();
	    $result  = $ass->retrieveAllAssessments($where,'assID','DESC','',1);
	    
	    if ($result) {
	    	$data = array();
	    	$ctr = 0;
	    	foreach ($result as $row) {
	    		$data[$ctr]=$row;
	    		$data[$ctr]['balance'] = number_format($row['balance'],2);
	    		$data[$ctr]['ttlDue']  = number_format($row['ttlDue'],2);
	    		$ctr++;
	    	}
	    }
	
	    $j = new Services_JSON;
	    $res = $j->encode($data);
	    echo $res;
	    
    } else	{ 
    echo 0;
    }
} else if (strtoupper($action)=='CHECKDUPLICATEPAYMENTNAMECOL' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Payments/PaymentType.php');
	
    $paymentName = $_GET['paymentName'];
    
    $paymentType= new PaymentType();
    $res = $paymentType->isExist($paymentName);

    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEPAYMENTNAMEHS' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Payments/PaymentTypeHS.php');
	
    $paymentName = $_GET['paymentName'];
    
    $paymentType= new PaymentType();
    $res = $paymentType->isExist($paymentName);
    echo $res;
} else if (strtoupper($action)=='CHECKDUPLICATEPAYMENTNAMEELEM' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Payments/PaymentTypeElem.php');
	
    $paymentName = $_GET['paymentName'];
    
    $paymentType= new PaymentType();
    $res = $paymentType->isExist($paymentName);
    echo $res;
} else if ( (strtoupper($action)=='VALIDATEPAYMENTCOL') ) {
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
	require_once('../Enrollments/EnrollmentCol.php');
	require_once('../Enrollments/EnrollmentDetailCol.php');
	require_once('../Payments/RegistrationPayment.php');

	// get parameters
    $schYear 	= $_GET['schYear'];
    $semCode 	= $_GET['semCode'];
    $idno 		= $_GET['idno'];
	
    if ($schYear != '' && $semCode != '' && $idno != '') {
    	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	    }    
	    if ($semCode) {
	        $where[0]['semCode'] = "='$semCode' AND ";
	    }    
	    if ($idno) {
	        $where[0]['idno'] = "='$idno' AND ";
	    }
	        $where[0]['rstatus'] = "='1'";
		
	    $regpayment = new RegistrationPayment();
	    $result  = $regpayment->retrieveAllRegistrationPayments($where);
	    
	    $j = new Services_JSON;
	    $res = $j->encode($result);
	    echo $res;
    } else {
    	echo 0;
    }
	    
} else if ( (strtoupper($action)=='CHECKSTUDINFORMATIONCOL') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigCol.php');
	require_once('../Departments/Department.php');
	require_once('../Courses/Course.php');
	require_once('../Subjects/SubjectCol.php');
	require_once('../Students/StudentCol.php');

	// get parameters
    $idno 		= $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
        $where[0]['rstatus'] = "='1'";
	
    $stud = new Student();
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( (strtoupper($action)=='VALIDATEPAYMENTHS') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigHS.php');
	require_once('../Subjects/SubjectHS.php');
	require_once('../Students/StudentHS.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleHS.php');
	require_once('../Schedules/BlockSectionHS.php');
	require_once('../Schedules/BlockSectionSubjectHS.php');
	require_once('../Enrollments/EnrollmentHS.php');
	require_once('../Enrollments/EnrollmentDetailHS.php');
	require_once('../Payments/RegistrationPaymentHS.php');

	// get parameters
    $schYear 	= $_GET['schYear'];
    $idno 		= $_GET['idno'];
	
    if ($schYear != '' && $idno != '') {
    	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	    }    
	    if ($idno) {
	        $where[0]['idno'] = "='$idno' AND ";
	    }
	        $where[0]['rstatus'] = "='1'";
		
	    $regpayment = new RegistrationPayment();
	    $result  = $regpayment->retrieveAllRegistrationPayments($where);
	    
	    $j = new Services_JSON;
	    $res = $j->encode($result);
	    echo $res;
    } else {
    	echo 0;
    }
	    
} else if ( (strtoupper($action)=='CHECKSTUDINFORMATIONHS') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigHS.php');
	require_once('../Subjects/SubjectHS.php');
	require_once('../Students/StudentHS.php');

	// get parameters
    $idno 		= $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
        $where[0]['rstatus'] = "='1'";
	
    $stud = new Student();
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( (strtoupper($action)=='VALIDATEPAYMENTELEM') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigElem.php');
	require_once('../Subjects/SubjectElem.php');
	require_once('../Students/StudentElem.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleElem.php');
	require_once('../Schedules/BlockSectionElem.php');
	require_once('../Schedules/BlockSectionSubjectElem.php');
	require_once('../Enrollments/EnrollmentElem.php');
	require_once('../Enrollments/EnrollmentDetailElem.php');
	require_once('../Payments/RegistrationPaymentElem.php');

	// get parameters
    $schYear 	= $_GET['schYear'];
    $idno 		= $_GET['idno'];
	
    if ($schYear != '' && $idno != '') {
    	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	    }    
	    if ($idno) {
	        $where[0]['idno'] = "='$idno' AND ";
	    }
	        $where[0]['rstatus'] = "='1'";
		
	    $regpayment = new RegistrationPayment();
	    $result  = $regpayment->retrieveAllRegistrationPayments($where);
	    
	    $j = new Services_JSON;
	    $res = $j->encode($result);
	    echo $res;
    } else {
    	echo 0;
    }
	    
} else if ( (strtoupper($action)=='VALIDATEPAYMENTPRESCHOOL') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigPreschool.php');
	require_once('../Subjects/SubjectPreschool.php');
	require_once('../Students/StudentPreschool.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/SchedulePreschool.php');
	require_once('../Schedules/BlockSectionPreschool.php');
	require_once('../Schedules/BlockSectionSubjectPreschool.php');
	require_once('../Enrollments/EnrollmentPreschool.php');
	require_once('../Enrollments/EnrollmentDetailPreschool.php');
	require_once('../Payments/RegistrationPaymentPreschool.php');

	// get parameters
    $schYear 	= $_GET['schYear'];
    $idno 		= $_GET['idno'];
	
    if ($schYear != '' && $idno != '') {
    	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	    }    
	    if ($idno) {
	        $where[0]['idno'] = "='$idno' AND ";
	    }
	        $where[0]['rstatus'] = "='1'";
		
	    $regpayment = new RegistrationPayment();
	    $result  = $regpayment->retrieveAllRegistrationPayments($where);
	    
	    $j = new Services_JSON;
	    $res = $j->encode($result);
	    echo $res;
    } else {
    	echo 0;
    }
	    
} else if ( (strtoupper($action)=='CHECKSTUDINFORMATIONELEM') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigElem.php');
	require_once('../Subjects/SubjectElem.php');
	require_once('../Students/StudentElem.php');

	// get parameters
    $idno 		= $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
        $where[0]['rstatus'] = "='1'";
	
    $stud = new Student();
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( (strtoupper($action)=='CHECKSTUDINFORMATIONPRESCHOOL') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigPreschool.php');
	require_once('../Subjects/SubjectPreschool.php');
	require_once('../Students/StudentPreschool.php');

	// get parameters
    $idno 		= $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
        $where[0]['rstatus'] = "='1'";
	
    $stud = new Student();
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( (strtoupper($action)=='VALIDATEPAYMENTPAYMENTCOL') ) {
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
	require_once('../Enrollments/EnrollmentCol.php');
	require_once('../Enrollments/EnrollmentDetailCol.php');
	require_once('../Payments/PaymentType.php');
	require_once('../Payments/Payment.php');

	// get parameters
    $schYear 	= $_GET['schYear'];
    $semCode 	= $_GET['semCode'];
    $term 		= $_GET['term'];
    $idno 		= $_GET['idno'];
	
    
    if ($schYear != '' && $semCode != '' && $term != '' && $idno != '') {
    	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	    }    
	    if ($semCode) {
	        $where[0]['semCode'] = "='$semCode' AND ";
	    }    
	    if ($term) {
	        $where[0]['term'] = "='$term' AND ";
	    }    
	    if ($idno) {
	        $where[0]['idno'] = "='$idno' AND ";
	    }
	        $where[0]['rstatus'] = "='1'";
		
	    $payment = new Payment();
	    
	    $result  = $payment->retrieveAllPayments($where);
	    $j = new Services_JSON;
	    $res = $j->encode($result);
	    echo $res;
    } else {
    	echo 0;
    }
	    
} else if ( (strtoupper($action)=='CHECKSTUDINFORMATIONPAYMENTCOL') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigCol.php');
	require_once('../Departments/Department.php');
	require_once('../Courses/Course.php');
	require_once('../Subjects/SubjectCol.php');
	require_once('../Students/StudentCol.php');

	// get parameters
    $idno 		= $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
        $where[0]['rstatus'] = "='1'";
	
    $stud = new Student();
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( (strtoupper($action)=='VALIDATEPAYMENTPAYMENTHS') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigHS.php');
	require_once('../Subjects/SubjectHS.php');
	require_once('../Students/StudentHS.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleHS.php');
	require_once('../Schedules/BlockSectionHS.php');
	require_once('../Schedules/BlockSectionSubjectHS.php');
	require_once('../Enrollments/EnrollmentHS.php');
	require_once('../Enrollments/EnrollmentDetailHS.php');
	require_once('../Payments/PaymentTypeHS.php');
	require_once('../Payments/PaymentHS.php');

	// get parameters
    $schYear 	= $_GET['schYear'];
    $term 		= $_GET['term'];
    $idno 		= $_GET['idno'];
	
    
    if ($schYear != '' && $term != '' && $idno != '') {
    	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	    }    
	    if ($term) {
	        $where[0]['term'] = "='$term' AND ";
	    }
	    if ($idno) {
	        $where[0]['idno'] = "='$idno' AND ";
	    }
	        $where[0]['rstatus'] = "='1'";
		
	    $payment = new Payment();
	    
	    $result  = $payment->retrieveAllPayments($where);
	    $j = new Services_JSON;
	    $res = $j->encode($result);
	    echo $res;
    } else {
    	echo 0;
    }
	    
} else if ( (strtoupper($action)=='CHECKSTUDINFORMATIONPAYMENTHS') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigHS.php');
	require_once('../Subjects/SubjectHS.php');
	require_once('../Students/StudentHS.php');

	// get parameters
    $idno 		= $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
        $where[0]['rstatus'] = "='1'";
	
    $stud = new Student();
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( (strtoupper($action)=='VALIDATEPAYMENTPAYMENTELEM') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigElem.php');
	require_once('../Subjects/SubjectElem.php');
	require_once('../Students/StudentElem.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleElem.php');
	require_once('../Schedules/BlockSectionElem.php');
	require_once('../Schedules/BlockSectionSubjectElem.php');
	require_once('../Enrollments/EnrollmentElem.php');
	require_once('../Enrollments/EnrollmentDetailElem.php');
	require_once('../Payments/PaymentTypeElem.php');
	require_once('../Payments/PaymentElem.php');

	// get parameters
    $schYear 	= $_GET['schYear'];
    $term 		= $_GET['term'];
    $idno 		= $_GET['idno'];
	
    
    if ($schYear != '' && $term != '' && $idno != '') {
    	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	    }    
    	if ($term) {
	        $where[0]['term'] = "='$term' AND ";
	    }    
	    if ($idno) {
	        $where[0]['idno'] = "='$idno' AND ";
	    }
	        $where[0]['rstatus'] = "='1'";
		
	    $payment = new Payment();
	    
	    $result  = $payment->retrieveAllPayments($where);
	    $j = new Services_JSON;
	    $res = $j->encode($result);
	    echo $res;
    } else {
    	echo 0;
    }
	    
} else if ( (strtoupper($action)=='VALIDATEPAYMENTPAYMENTPRESCHOOL') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigPreschool.php');
	require_once('../Subjects/SubjectPreschool.php');
	require_once('../Students/StudentPreschool.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/SchedulePreschool.php');
	require_once('../Schedules/BlockSectionPreschool.php');
	require_once('../Schedules/BlockSectionSubjectPreschool.php');
	require_once('../Enrollments/EnrollmentPreschool.php');
	require_once('../Enrollments/EnrollmentDetailPreschool.php');
	require_once('../Payments/PaymentTypePreschool.php');
	require_once('../Payments/PaymentPreschool.php');

	// get parameters
    $schYear 	= $_GET['schYear'];
    $term 		= $_GET['term'];
    $idno 		= $_GET['idno'];
	
    
    if ($schYear != '' && $term != '' && $idno != '') {
    	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	    }    
    	if ($term) {
	        $where[0]['term'] = "='$term' AND ";
	    }    
	    if ($idno) {
	        $where[0]['idno'] = "='$idno' AND ";
	    }
	        $where[0]['rstatus'] = "='1'";
		
	    $payment = new Payment();
	    
	    $result  = $payment->retrieveAllPayments($where);
	    $j = new Services_JSON;
	    $res = $j->encode($result);
	    echo $res;
    } else {
    	echo 0;
    }
	    
} else if ( (strtoupper($action)=='CHECKSTUDINFORMATIONPAYMENTELEM') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigElem.php');
	require_once('../Subjects/SubjectElem.php');
	require_once('../Students/StudentElem.php');

	// get parameters
    $idno 		= $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
        $where[0]['rstatus'] = "='1'";
	
    $stud = new Student();
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( (strtoupper($action)=='CHECKSTUDINFORMATIONPAYMENTPRESCHOOL') ) {
	require_once('../../commonAjax.php');

    require_once('../Config/ConfigPreschool.php');
	require_once('../Subjects/SubjectPreschool.php');
	require_once('../Students/StudentPreschool.php');

	// get parameters
    $idno 		= $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
        $where[0]['rstatus'] = "='1'";
	
    $stud = new Student();
    $result  = $stud->retrieveAllStudents($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( strtoupper($action)=='GETTERMS' ) {
    require_once('../../commonAjax.php');
    require_once('../Config/ConfigCol.php');  
    
    // get all default setting from configs
    $config = new Config();
    
    // get parameters
    $semCode = $_GET['semCode'];

    // get the default school year
    $total_terms = 0;
	if ($semCode<4) {
	    if ($semCode) {
            $total_terms = $config->getConfig('Semestral Terms');
	    }
	} else {
	    if ($semCode) {
	       $total_terms = $config->getConfig('Summer Terms');
	    }
	}
	
    echo $total_terms;
} else if ( strtoupper($action)=='CHECKORSERIES' ) {
    require_once('../../commonAjax.php');
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
	require_once('../Enrollments/EnrollmentCol.php');
	require_once('../Enrollments/EnrollmentDetailCol.php');
	require_once('../Payments/ORSeries.php');
	
    $fiscalYear = $_GET['fiscalYear'];
    $firstORNO  = $_GET['firstORNO'];
    $lastORNO   = $_GET['lastORNO'];
    
    $orseries = new ORSeries();
    $res = $orseries->isExist($fiscalYear, $firstORNO, $lastORNO);
    
    echo $res;
} else if ( strtoupper($action)=='ADDPAYMENT' ) {
    require_once('../../commonAjax.php');
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
	require_once('../Enrollments/EnrollmentCol.php');
	require_once('../Enrollments/EnrollmentDetailCol.php');
	require_once('../Payments/ORSeries.php');
	
    $data['particular'] = $_GET['particular'];
    $data['amount']     = $_GET['amount'];
    
    $_SESSION['ORITEMS'][] = $data;
    
    echo displayItem();
}


/**
 * This will display the added items (payments)
 *
 * @return unknown
 */
function displayItem() {

    $display .= '
        <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            	<tr height="20">
            		<td scope="col" class="listViewThS1" width="5%" nowrap="nowrap">&nbsp;</td>
            		<td scope="col" class="listViewThS1" width="45%" nowrap="nowrap">Particular</td>
            		<td scope="col" class="listViewThS1" width="50%" nowrap="nowrap">Amount</td>
            	</tr>                
    ';
    $ctr = 0;
        if ($_SESSION['ORITEMS']) {
        $total_units = 0;
        foreach ($_SESSION['ORITEMS'] as $data) {
            $total_amount += $data['amount'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject(\''.$data['ordno'].'\');" /></td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['particular'].'&nbsp;</td>';

            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.number_format($data['amount'],1,".",",").'&nbsp;</td>';

            $display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        }
        $display .= '<tr height="20">
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total</b></td>
                		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>'.number_format($total_amount,1,".",",").'</b></td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                	</tr>';
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}


?>