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
	require_once('../Account/AccountDetailCol.php');
	require_once('../Account/Account.php');

    // get parameters
    $idno = $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno'";
    
        $stud = new Student($idno);
        $result  = $stud->retrieveAllStudents($where);
        
        if ($result) {
            $data[0]['lname']  = $result[0]['lname'];
            $data[0]['fname']  = $result[0]['fname'];
            $data[0]['mname']  = $result[0]['mname'];
            $data[0]['yrLevel']= $result[0]['yrLevel'];
                $course = new Course($result[0]['courseID']);
            $data[0]['course'] = $course->courseCode;
            
            $account = new Account($result[0]['accID']);
            
            if ($account->balance) {
            	$data[0]['balance'] = number_format($account->balance,2);
            } else {
            	$data[0]['balance'] = 0;
            }

            $j = new Services_JSON;
            $res = $j->encode($data);
        
            echo $res;
        } else {
            echo 0;
        }
    } else {
    	echo 0;
    }
    
} else if ( (strtoupper($action)=='DISPLAYSTUDENTINFOSHS') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentHS.php'); 
	require_once('../Account/AccountDetailHS.php');
	require_once('../Account/AccountHS.php');


    // get parameters
    $idno = $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno'";
    
        $stud = new Student($idno);
        $result  = $stud->retrieveAllStudents($where);
        
        if ($result) {
            $data[0]['lname']  = $result[0]['lname'];
            $data[0]['fname']  = $result[0]['fname'];
            $data[0]['mname']  = $result[0]['mname'];
            $data[0]['yrLevel']= $result[0]['yrLevel'];
            
            $account = new Account($result[0]['accID']);
            
            if ($account->balance) {
            	$data[0]['balance'] = number_format($account->balance,2);
            } else {
            	$data[0]['balance'] = 0;
            }

            $j = new Services_JSON;
            $res = $j->encode($data);
        
            echo $res;
        } else {
            echo 0;
        }
    } else {
    	echo 0;
    }
    
} else if ( (strtoupper($action)=='DISPLAYSTUDENTINFOSELEM') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentElem.php'); 
	require_once('../Account/AccountDetailElem.php');
	require_once('../Account/AccountElem.php');

    // get parameters
    $idno = $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno'";
    
        $stud = new Student($idno);
        $result  = $stud->retrieveAllStudents($where);
        
        if ($result) {
            $data[0]['lname']  = $result[0]['lname'];
            $data[0]['fname']  = $result[0]['fname'];
            $data[0]['mname']  = $result[0]['mname'];
            $data[0]['yrLevel']= $result[0]['yrLevel'];
            
            $account = new Account($result[0]['accID']);
            
            if ($account->balance) {
            	$data[0]['balance'] = number_format($account->balance,2);
            } else {
            	$data[0]['balance'] = 0;
            }

            $j = new Services_JSON;
            $res = $j->encode($data);
        
            echo $res;
        } else {
            echo 0;
        }
    } else {
    	echo 0;
    }
    
} else if ( (strtoupper($action)=='DISPLAYSTUDENTINFOSPRESCHOOL') ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentPreschool.php'); 
	require_once('../Account/AccountDetailPreschool.php');
	require_once('../Account/AccountPreschool.php');


    // get parameters
    $idno = $_GET['idno'];
	
    if ($idno) {
        $where[0]['idno'] = "='$idno'";
    
        $stud = new Student($idno);
        $result  = $stud->retrieveAllStudents($where);
        
        if ($result) {
            $data[0]['lname']  = $result[0]['lname'];
            $data[0]['fname']  = $result[0]['fname'];
            $data[0]['mname']  = $result[0]['mname'];
            $data[0]['yrLevel']= $result[0]['yrLevel'];
            
            $account = new Account($result[0]['accID']);
            
            if ($account->balance) {
            	$data[0]['balance'] = number_format($account->balance,2);
            } else {
            	$data[0]['balance'] = 0;
            }

            $j = new Services_JSON;
            $res = $j->encode($data);
        
            echo $res;
        } else {
            echo 0;
        }
    } else {
    	echo 0;
    }
    
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
	require_once('../SchoolFees/SchoolFeeCol.php');
	require_once('../Account/ChartAccountMaster.php');
	
	//display schoolfee item
	$schoolFee         = new SchoolFee();
	$accountMaster     = new ChartAccountMaster();
	
	$account_code = $_GET['particular'];
	
    unset($where);
    $where[0]['account_code'] = "='$account_code'";
    $particular = $accountMaster->retrieveAllChartAccountMaster($where);
    
    $data['account_code']   = $particular[0]['account_name'];
    $data['particular']     = $_GET['particular'];
    $data['amount']         = $_GET['amount'];
    
    $_SESSION['ORITEMS'][] = $data;
    
    echo displayItem();
} else if ( strtoupper($action)=='ADDPAYMENTHS' ) {
    require_once('../../commonAjax.php');
	require_once('../Subjects/SubjectHS.php');
	require_once('../Students/StudentHS.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleHS.php');
	require_once('../Schedules/BlockSectionHS.php');
	require_once('../Schedules/BlockSectionSubjectHS.php');
	require_once('../Enrollments/EnrollmentHS.php');
	require_once('../Enrollments/EnrollmentDetailHS.php');
	require_once('../Payments/ORSeries.php');
	require_once('../SchoolFees/SchoolFeeHS.php');
	require_once('../Account/ChartAccountMaster.php');
	
	//display schoolfee item
	$schoolFee         = new SchoolFee();
	$accountMaster     = new ChartAccountMaster();
	
	$account_code = $_GET['particular'];
	
    unset($where);
    $where[0]['account_code'] = "='$account_code'";
    $particular = $accountMaster->retrieveAllChartAccountMaster($where);
    
    $data['account_code']   = $particular[0]['account_name'];
    $data['particular']     = $_GET['particular'];
    $data['amount']         = $_GET['amount'];
    
    $_SESSION['ORITEMSHS'][] = $data;
    
    echo displayItemhs();
} else if ( strtoupper($action)=='ADDPAYMENTELEM' ) {
    require_once('../../commonAjax.php');
	require_once('../Subjects/SubjectElem.php');
	require_once('../Students/StudentElem.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleElem.php');
	require_once('../Schedules/BlockSectionElem.php');
	require_once('../Schedules/BlockSectionSubjectElem.php');
	require_once('../Enrollments/EnrollmentElem.php');
	require_once('../Enrollments/EnrollmentDetailElem.php');
	require_once('../Payments/ORSeries.php');
	require_once('../SchoolFees/SchoolFeeElem.php');
	require_once('../Account/ChartAccountMaster.php');
	
	//display schoolfee item
	$schoolFee         = new SchoolFee();
	$accountMaster     = new ChartAccountMaster();
	
	$account_code = $_GET['particular'];
	
    unset($where);
    $where[0]['account_code'] = "='$account_code'";
    $particular = $accountMaster->retrieveAllChartAccountMaster($where);
    
    $data['account_code']   = $particular[0]['account_name'];
    $data['particular']     = $_GET['particular'];
    $data['amount']         = $_GET['amount'];
    
    $_SESSION['ORITEMSELEM'][] = $data;
    
    echo displayItemelem();
} else if ( strtoupper($action)=='ADDPAYMENTPRESCHOOL' ) {
    require_once('../../commonAjax.php');
	require_once('../Subjects/SubjectPreschool.php');
	require_once('../Students/StudentPreschool.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/SchedulePreschool.php');
	require_once('../Schedules/BlockSectionPreschool.php');
	require_once('../Schedules/BlockSectionSubjectPreschool.php');
	require_once('../Enrollments/EnrollmentPreschool.php');
	require_once('../Enrollments/EnrollmentDetailPreschool.php');
	require_once('../Payments/ORSeries.php');
	require_once('../SchoolFees/SchoolFeePreschool.php');
	require_once('../Account/ChartAccountMaster.php');
	
	//display schoolfee item
	$schoolFee         = new SchoolFee();
	$accountMaster     = new ChartAccountMaster();
	
	$account_code = $_GET['particular'];
	
    unset($where);
    $where[0]['account_code'] = "='$account_code'";
    $particular = $accountMaster->retrieveAllChartAccountMaster($where);
    
    $data['account_code']   = $particular[0]['account_name'];
    $data['particular']     = $_GET['particular'];
    $data['amount']         = $_GET['amount'];
    
    $_SESSION['ORITEMSPRESCHOOL'][] = $data;
    
    echo displayItemPreschool();
} else if ( strtoupper($action)=='REMOVEPARTICULAR' ) {
    // get parameters
    $particular = $_GET['particular'];

    if ($_SESSION['ORITEMS']) {
        $ctr = 0;
        foreach ($_SESSION['ORITEMS'] as $row) {
            if ($row['particular'] == $particular) {
                // found schedule here
                $found = 1;  
                
                for ($r=$ctr; $r < count($_SESSION['ORITEMS']); $r++) {
                    $_SESSION['ORITEMS'][$r] = $_SESSION['ORITEMS'][$r+1];
                }
                
                // clear the last record since the target was record already
                unset ($_SESSION['ORITEMS'][count($_SESSION['ORITEMS'])-1]);
                
                break;                        
            }
            $ctr++;
        }
    }

    echo displayItem();

} else if ( strtoupper($action)=='REMOVEPARTICULARHS' ) {
    // get parameters
    $particular = $_GET['particular'];

    if ($_SESSION['ORITEMSHS']) {
        $ctr = 0;
        foreach ($_SESSION['ORITEMSHS'] as $row) {
            if ($row['particular'] == $particular) {
                // found schedule here
                $found = 1;  
                
                for ($r=$ctr; $r < count($_SESSION['ORITEMSHS']); $r++) {
                    $_SESSION['ORITEMSHS'][$r] = $_SESSION['ORITEMSHS'][$r+1];
                }
                
                // clear the last record since the target was record already
                unset ($_SESSION['ORITEMSHS'][count($_SESSION['ORITEMSHS'])-1]);
                
                break;                        
            }
            $ctr++;
        }
    }

    echo displayItemhs();

} else if ( strtoupper($action)=='REMOVEPARTICULARELEM' ) {
    // get parameters
    $particular = $_GET['particular'];

    if ($_SESSION['ORITEMSELEM']) {
        $ctr = 0;
        foreach ($_SESSION['ORITEMSELEM'] as $row) {
            if ($row['particular'] == $particular) {
                // found schedule here
                $found = 1;  
                
                for ($r=$ctr; $r < count($_SESSION['ORITEMSELEM']); $r++) {
                    $_SESSION['ORITEMSELEM'][$r] = $_SESSION['ORITEMSELEM'][$r+1];
                }
                
                // clear the last record since the target was record already
                unset ($_SESSION['ORITEMSELEM'][count($_SESSION['ORITEMSELEM'])-1]);
                
                break;                        
            }
            $ctr++;
        }
    }

    echo displayItemelem();

} else if ( strtoupper($action)=='REMOVEPARTICULARPRESCHOOL' ) {
    // get parameters
    $particular = $_GET['particular'];

    if ($_SESSION['ORITEMSPRESCHOOL']) {
        $ctr = 0;
        foreach ($_SESSION['ORITEMSPRESCHOOL'] as $row) {
            if ($row['particular'] == $particular) {
                // found schedule here
                $found = 1;  
                
                for ($r=$ctr; $r < count($_SESSION['ORITEMSPRESCHOOL']); $r++) {
                    $_SESSION['ORITEMSPRESCHOOL'][$r] = $_SESSION['ORITEMSPRESCHOOL'][$r+1];
                }
                
                // clear the last record since the target was record already
                unset ($_SESSION['ORITEMSPRESCHOOL'][count($_SESSION['ORITEMSPRESCHOOL'])-1]);
                
                break;                        
            }
            $ctr++;
        }
    }

    echo displayItemPreschool();

} else if ( strtoupper($action)=='GETSCHOOLFEES' ) {
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
	require_once('../Curriculums/Prerequisite.php');
    require_once('../Users/User2.php');
    require_once('../SchoolFees/SchoolFeeCol.php');
    require_once('../Students/StudentCol.php');
    require_once('../Account/ChartAccountMaster.php');  
    require_once('../Config/ConfigCol.php');  
    
    // get all default setting from configs
    $config     = new Config();
    $accountMaster = new ChartAccountMaster();
    
	$miscellaneous = $config->getConfig('Misc Account Code');
	$laboratory    = $config->getConfig('Lab Account Code');
	
	// get parameters
    $schYear    = $_GET['schYear'];
    $idno       = $_GET['idno'];

    $student    = new Student($idno);

    $where[0]['account_code'] = "!='$miscellaneous' AND account_code != '$laboratory'";
//    $where[0]['account_code'] = "!='$laboratory'";
    
    $result     = $accountMaster->retrieveAllChartAccountMaster($where);

    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
} else if ( strtoupper($action)=='CHECKENTRY' ) {
    
    if (!empty($_SESSION['ORITEMS'])) {
        echo 1;
    } else {
        echo 0;
    }
} else if ( strtoupper($action)=='CHECKENTRYHS' ) {
    
    if (!empty($_SESSION['ORITEMSHS'])) {
        echo 1;
    } else {
        echo 0;
    }
} else if ( strtoupper($action)=='CHECKENTRYELEM' ) {
    
    if (!empty($_SESSION['ORITEMSELEM'])) {
        echo 1;
    } else {
        echo 0;
    }
} else if ( strtoupper($action)=='CHECKENTRYPRESCHOOL' ) {
    
    if (!empty($_SESSION['ORITEMSPRESCHOOL'])) {
        echo 1;
    } else {
        echo 0;
    }
} else if ( strtoupper($action)=='CHECKDUPLICATEENTRY' ) {
    
    // get parameters
    $particular = $_GET['particular'];
    
    echo isDuplicate($particular);
    
} else if ( strtoupper($action)=='CHECKDUPLICATEENTRYHS' ) {
    
    // get parameters
    $particular = $_GET['particular'];
    
    echo isDuplicatehs($particular);
    
} else if ( strtoupper($action)=='CHECKDUPLICATEENTRYELEM' ) {
    
    // get parameters
    $particular = $_GET['particular'];
    
    echo isDuplicateelem($particular);
    
} else if ( strtoupper($action)=='CHECKDUPLICATEENTRYPRESCHOOL' ) {
    
    // get parameters
    $particular = $_GET['particular'];
    
    echo isDuplicatepreschool($particular);
    
} else if ( strtoupper($action)=='CHECKDUPLICATEORNO' ) {
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
	require_once('../Payments/ORHeader.php');
	
    $orno   = $_GET['orno'];
    
    $orheader = new ORHeader();
    $res = $orheader->isExist($orno);
    
    echo $res;
} else if ( strtoupper($action)=='CHECKDUPLICATEORNOHS' ) {
    require_once('../../commonAjax.php');
	require_once('../Subjects/SubjectHS.php');
	require_once('../Students/StudentHS.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleHS.php');
	require_once('../Schedules/BlockSectionHS.php');
	require_once('../Schedules/BlockSectionSubjectHS.php');
	require_once('../Enrollments/EnrollmentHS.php');
	require_once('../Enrollments/EnrollmentDetailHS.php');
	require_once('../Payments/ORSeries.php');
	require_once('../Payments/ORHeaderHS.php');
	
    $orno   = $_GET['orno'];
    
    $orheader = new ORHeader();
    $res = $orheader->isExist($orno);
    
    echo $res;
} else if ( strtoupper($action)=='CHECKDUPLICATEORNOELEM' ) {
    require_once('../../commonAjax.php');
	require_once('../Subjects/SubjectElem.php');
	require_once('../Students/StudentElem.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/ScheduleElem.php');
	require_once('../Schedules/BlockSectionElem.php');
	require_once('../Schedules/BlockSectionSubjectElem.php');
	require_once('../Enrollments/EnrollmentElem.php');
	require_once('../Enrollments/EnrollmentDetailElem.php');
	require_once('../Payments/ORSeries.php');
	require_once('../Payments/ORHeaderElem.php');
	
    $orno   = $_GET['orno'];
    
    $orheader = new ORHeader();
    $res = $orheader->isExist($orno);
    
    echo $res;
} else if ( strtoupper($action)=='CHECKDUPLICATEORNOPRESCHOOL' ) {
    require_once('../../commonAjax.php');
	require_once('../Subjects/SubjectPreschool.php');
	require_once('../Students/StudentPreschool.php');
	require_once('../Users/User2.php');
	require_once('../Schedules/SchedulePreschool.php');
	require_once('../Schedules/BlockSectionPreschool.php');
	require_once('../Schedules/BlockSectionSubjectPreschool.php');
	require_once('../Enrollments/EnrollmentPreschool.php');
	require_once('../Enrollments/EnrollmentDetailPreschool.php');
	require_once('../Payments/ORSeries.php');
	require_once('../Payments/ORHeaderPreschool.php');
	
    $orno   = $_GET['orno'];
    
    $orheader = new ORHeader();
    $res = $orheader->isExist($orno);
    
    echo $res;
}


/**
 * This will check if the newly added schedule is already exist in College particular payments
 *
 * @param unknown_type $particular
 * @return unknown
 */
function isDuplicate($particular) 
{
    $found = 0;
    if ($_SESSION['ORITEMS']) {
        $ctr = 0;
        foreach ($_SESSION['ORITEMS'] as $row) {
            if ($row['particular'] == $particular) {
                // found schedule here
                $found = 1;  
                break;                        
            }
            $ctr++;
        }
    }
    return $found;
}

/**
 * This will check if the newly added schedule is already exist in High School particular payments
 *
 * @param unknown_type $particular
 * @return unknown
 */
function isDuplicatehs($particular)
{
    $found = 0;
    if ($_SESSION['ORITEMSHS']) {
        $ctr = 0;
        foreach ($_SESSION['ORITEMSHS'] as $row) {
            if ($row['particular'] == $particular) {
                // found schedule here
                $found = 1;  
                break;                        
            }
            $ctr++;
        }
    }
    return $found;
}

/**
 * This will check if the newly added schedule is already exist in High School particular payments
 *
 * @param unknown_type $particular
 * @return unknown
 */
function isDuplicateelem($particular)
{
    $found = 0;
    if ($_SESSION['ORITEMSELEM']) {
        $ctr = 0;
        foreach ($_SESSION['ORITEMSELEM'] as $row) {
            if ($row['particular'] == $particular) {
                // found schedule here
                $found = 1;  
                break;                        
            }
            $ctr++;
        }
    }
    return $found;
}

/**
 * This will check if the newly added schedule is already exist in High School particular payments
 *
 * @param unknown_type $particular
 * @return unknown
 */
function isDuplicatepreschool($particular)
{
    $found = 0;
    if ($_SESSION['ORITEMSPRESCHOOL']) {
        $ctr = 0;
        foreach ($_SESSION['ORITEMSPRESCHOOL'] as $row) {
            if ($row['particular'] == $particular) {
                // found schedule here
                $found = 1;  
                break;                        
            }
            $ctr++;
        }
    }
    return $found;
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
            $totalAmount += $data['amount'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeParticular(\''.$data['particular'].'\');" /></td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['account_code'].'&nbsp;</td>';

            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.number_format($data['amount'],2,".",",").'&nbsp;</td>';

            $display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        }
        $display .= '<tr height="20">
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total</b></td>
                		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>'.number_format($totalAmount,2,".",",").'</b><input type="hidden" name="totalAmount" value="'.$totalAmount.'"></td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                	</tr>';
    }
    
    $display .= '</tbody></table>';
    
    return $display;
} 

/**
 * This will display the added items (payments) hs
 *
 * @return unknown
 */
function displayItemhs() {

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
        if ($_SESSION['ORITEMSHS']) {
        $total_units = 0;
        foreach ($_SESSION['ORITEMSHS'] as $data) {
            $totalAmount += $data['amount'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeParticular(\''.$data['particular'].'\');" /></td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['account_code'].'&nbsp;</td>';

            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.number_format($data['amount'],2,".",",").'&nbsp;</td>';

            $display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        }
        $display .= '<tr height="20">
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total</b></td>
                		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>'.number_format($totalAmount,2,".",",").'</b><input type="hidden" name="totalAmount" value="'.$totalAmount.'"></td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                	</tr>';
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}

/**
 * This will display the added items (payments) elem   
 *
 * @return unknown
 */
function displayItemelem() {

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
        if ($_SESSION['ORITEMSELEM']) {
        $total_units = 0;
        foreach ($_SESSION['ORITEMSELEM'] as $data) {
            $totalAmount += $data['amount'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeParticular(\''.$data['particular'].'\');" /></td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['account_code'].'&nbsp;</td>';

            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.number_format($data['amount'],2,".",",").'&nbsp;</td>';

            $display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        }
        $display .= '<tr height="20">
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total</b></td>
                		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>'.number_format($totalAmount,2,".",",").'</b><input type="hidden" name="totalAmount" value="'.$totalAmount.'"></td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                	</tr>';
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}

/**
 * This will display the added items (payments) elem   
 *
 * @return unknown
 */
function displayItemPreschool() {
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
        if ($_SESSION['ORITEMSPRESCHOOL']) {
        $total_units = 0;
        foreach ($_SESSION['ORITEMSPRESCHOOL'] as $data) {
            $totalAmount += $data['amount'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeParticular(\''.$data['particular'].'\');" /></td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['account_code'].'&nbsp;</td>';

            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.number_format($data['amount'],2,".",",").'&nbsp;</td>';

            $display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        }
        $display .= '<tr height="20">
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total</b></td>
                		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>'.number_format($totalAmount,2,".",",").'</b><input type="hidden" name="totalAmount" value="'.$totalAmount.'"></td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                	</tr>';
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}

?>