<?php
if (!$_SESSION){
    session_start();
}

// ajax action
$action = $_GET['action'];

if ( (strtoupper($action)=='DISPLAYSTUDENTINFOS') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Account/AccountDetailCol.php'); 
    require_once('../Account/Account.php'); 
    // get parameters
    $idno 		= $_GET['idno'];
    $schYear 	= $_GET['schYear'];
    $semCode 	= $_GET['semCode'];

    if ($idno) {
        $where[0]['idno'] = "='$idno' AND";
    
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' AND ";
    }
    if ($semCode) {
        $where[0]['semCode'] = "='$semCode' AND ";
    }
	$where[0]['rstatus'] = "= 1 ";
	
    $acc = new Account();
    $result  = $acc->retrieveAllAccounts($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;
    }
    
    else {
    	echo 0;
    }
    
} else if ( (strtoupper($action)=='DISPLAYCOMPLETENAME') ) {
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
  
} else if ( (strtoupper($action)=='DISPLAYCOMPLETENAMEHS') ) {
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
    } else {
    	echo 0;
    }
  
} else if ( (strtoupper($action)=='DISPLAYCOMPLETENAMEELEM') ) {
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
    } else {
    	echo 0;
    }
  
} else if ( (strtoupper($action)=='DISPLAYCOMPLETENAMEPRESCHOOL') ) {
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
    } else {
    	echo 0;
    }
  
} else if ( (strtoupper($action)=='DISPLAYACCOUNTS') ) {
	require_once('../../commonAjax.php');

    require_once('../Account/Assessment.php');
    // get parameters
    $idno = $_GET['idno'];
	$term = $_GET['term'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    
    if ($term) {
        $where[0]['term'] = "='$term'";
    }    
    $ass = new Assessment();
    $result  = $ass->retrieveAllAssessments($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
    
    } else	{ 
    echo 0;
    }
} else if ( (strtoupper($action)=='DISPLAYSTUDENTINFOSHS') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Account/AccountDetailHS.php'); 
    require_once('../Account/AccountHS.php'); 
    
    // get parameters
    $idno 		= $_GET['idno'];
    $schYear 	= $_GET['schYear'];

    if ($idno) {
        $where[0]['idno'] = "='$idno' AND";
    
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' AND ";
    }
	$where[0]['rstatus'] = "= 1 ";
	
    $acc = new Account();
    $result  = $acc->retrieveAllAccounts($where);
    
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
    $idno = $_GET['idno'];
	$term = $_GET['term'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    
    if ($term) {
        $where[0]['term'] = "='$term'";
    }    
    $ass = new Assessment();
    $result  = $ass->retrieveAllAssessments($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
    
    } else	{ 
    echo 0;
    }
} else if ( (strtoupper($action)=='DISPLAYSTUDENTINFOSELEM') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Account/AccountDetailElem.php'); 
    require_once('../Account/AccountElem.php'); 
    
    // get parameters
    $idno 		= $_GET['idno'];
    $schYear 	= $_GET['schYear'];

    if ($idno) {
        $where[0]['idno'] = "='$idno' AND";
    
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' AND ";
    }
	$where[0]['rstatus'] = "= 1 ";
	
    $acc = new Account();
    $result  = $acc->retrieveAllAccounts($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;
    }
    
    else {
    	echo 0;
    }
    
} else if ( (strtoupper($action)=='DISPLAYSTUDENTINFOSPRESCHOOL') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Account/AccountDetailPreschool.php'); 
    require_once('../Account/AccountPreschool.php'); 
    
    // get parameters
    $idno 		= $_GET['idno'];
    $schYear 	= $_GET['schYear'];

    if ($idno) {
        $where[0]['idno'] = "='$idno' AND";
    
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' AND ";
    }
	$where[0]['rstatus'] = "= 1 ";
	
    $acc = new Account();
    $result  = $acc->retrieveAllAccounts($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;
    }
    
    else {
    	echo 0;
    }
    
} else if ( (strtoupper($action)=='DISPLAYACCOUNTSHS') ) {
	require_once('../../commonAjax.php');
	
    require_once('../Account/AssessmentElem.php');
    // get parameters
    $idno = $_GET['idno'];
	$term = $_GET['term'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    
    if ($term) {
        $where[0]['term'] = "='$term'";
    }    
    $ass = new Assessment();
    $result  = $ass->retrieveAllAssessments($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
    
    } else	{ 
    echo 0;
    }
} else if ( (strtoupper($action)=='CHECKAMOUNTS') ) {
	require_once('../../commonAjax.php');

    require_once('../Account/Account.php');

    // get parameters
    $idno = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $semCode = $_GET['semCode'];
    $amount = $_GET['amount'];

    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	}    
	if ($semCode) {
	        $where[0]['semCode'] = "='$semCode' AND ";
	}
	$where[0]['rstatus'] = "='1'";

	$acc = new Account();
    $result  = $acc->retrieveAllAccounts($where);

    if ($amount <= abs($result[0]['balance'])) {
    	$safe = 1;
    } else {
    	$safe = -1;
    }
    echo $safe;

} else if ( (strtoupper($action)=='EDITCHECKAMOUNTS') ) {
	require_once('../../commonAjax.php');

    // get parameters
    $idno = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $semCode = $_GET['semCode'];
    $amount = $_GET['amount'];
    $balance = $_GET['balance'];

    if ($amount <= abs($balance)) {
    	$safe = 1;
    } else {
    	$safe = -1;
    }
    echo $safe;

} else if ( (strtoupper($action)=='CHECKAMOUNTSHS') ) {
	require_once('../../commonAjax.php');

    require_once('../Account/AccountHS.php');

    // get parameters
    $idno = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $amount = $_GET['amount'];

    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	}    
	$where[0]['rstatus'] = "='1'";

	$acc = new Account();
    $result  = $acc->retrieveAllAccounts($where);

    if ($amount <= abs($result[0]['balance'])) {
    	$safe = 1;
    } else {
    	$safe = -1;
    }
    echo $safe;

} else if ( (strtoupper($action)=='EDITCHECKAMOUNTSHS') ) {
	require_once('../../commonAjax.php');

    // get parameters
    $idno = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $amount = $_GET['amount'];
    $balance = $_GET['balance'];

    if ($amount <= abs($balance)) {
    	$safe = 1;
    } else {
    	$safe = -1;
    }
    echo $safe;

} else if ( (strtoupper($action)=='CHECKAMOUNTSELEM') ) {
	require_once('../../commonAjax.php');

    require_once('../Account/AccountElem.php');

    // get parameters
    $idno = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $amount = $_GET['amount'];

    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	}    
	$where[0]['rstatus'] = "='1'";

	$acc = new Account();
    $result  = $acc->retrieveAllAccounts($where);

    if ($amount <= abs($result[0]['balance'])) {
    	$safe = 1;
    } else {
    	$safe = -1;
    }
    echo $safe;

} else if ( (strtoupper($action)=='CHECKAMOUNTSPRESCHOOL') ) {
	require_once('../../commonAjax.php');

    require_once('../Account/AccountPreschool.php');

    // get parameters
    $idno = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $amount = $_GET['amount'];

    if ($idno) {
        $where[0]['idno'] = "='$idno' AND ";
    }
	if ($schYear) {
	        $where[0]['schYear'] = "='$schYear' AND ";
	}    
	$where[0]['rstatus'] = "='1'";

	$acc = new Account();
    $result  = $acc->retrieveAllAccounts($where);

    if ($amount <= abs($result[0]['balance'])) {
    	$safe = 1;
    } else {
    	$safe = -1;
    }
    echo $safe;

} else if ( (strtoupper($action)=='EDITCHECKAMOUNTSELEM') ) {
	require_once('../../commonAjax.php');

    // get parameters
    $idno = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $amount = $_GET['amount'];
    $balance = $_GET['balance'];

    if ($amount <= abs($balance)) {
    	$safe = 1;
    } else {
    	$safe = -1;
    }
    echo $safe;

} else if ( (strtoupper($action)=='EDITCHECKAMOUNTSPRESCHOOL') ) {
	require_once('../../commonAjax.php');

    // get parameters
    $idno = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $amount = $_GET['amount'];
    $balance = $_GET['balance'];

    if ($amount <= abs($balance)) {
    	$safe = 1;
    } else {
    	$safe = -1;
    }
    echo $safe;

} else {
    echo 0;
}
?>