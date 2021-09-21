<?php
if (!$_SESSION){
    session_start();
}

// ajax action
$action = $_GET['action'];

if ( strtoupper($action)=='GETSTUDENTINFO' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Students/StudentCol.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    
    // get parameters
    $idno  = trim($_GET['idno']);

    if ($idno!="") {
        $where[0]['idno'] = "='$idno' ";
    } 
    
    $stud = new Student();
    $result = $stud->retrieveAllStudents($where);
    
    if (!empty($result)) {
        $j = new Services_JSON;
        $res = $j->encode($result);
    } else {
        $res = 0;
    }
    echo $res;
} else if ( strtoupper($action)=='GETSTUDENTINFOHS' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentHS.php');
    
    // get parameters
    $idno  = trim($_GET['idno']);

    if ($idno!="") {
        $where[0]['idno'] = "='$idno' ";
    } 
    
    $stud = new Student();
    $result = $stud->retrieveAllStudents($where);
    
    if (!empty($result)) {
        $j = new Services_JSON;
        $res = $j->encode($result);
    } else {
        $res = 0;
    }
    echo $res;
} else if ( strtoupper($action)=='GETSTUDENTINFOELEM' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentElem.php');
    
    // get parameters
    $idno  = trim($_GET['idno']);

    if ($idno!="") {
        $where[0]['idno'] = "='$idno' ";
    } 
    
    $stud = new Student();
    $result = $stud->retrieveAllStudents($where);
    
    if (!empty($result)) {
        $j = new Services_JSON;
        $res = $j->encode($result);
    } else {
        $res = 0;
    }
    echo $res;
} else if ( strtoupper($action)=='GETSTUDENTINFOPRESCHOOL' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentPreschool.php');
    
    // get parameters
    $idno  = trim($_GET['idno']);

    if ($idno!="") {
        $where[0]['idno'] = "='$idno' ";
    } 
    
    $stud = new Student();
    $result = $stud->retrieveAllStudents($where);
    
    if (!empty($result)) {
        $j = new Services_JSON;
        $res = $j->encode($result);
    } else {
        $res = 0;
    }
    echo $res;
} else if ( strtoupper($action)=='GETSUBJECTS' ) {
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    
    // get parameters
    $courseID = $_GET['courseID'];

    if ($courseID) {
        $where[0]['courseID'] = "='$courseID'";
    } else {
        $where="";
    }
        
    $subject = new Subject();
    $result  = $subject->retrieveAllSubjects($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
} else if ( strtoupper($action)=='CHECKENROLLMENT' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Students/StudentCol.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Enrollments/EnrollmentCol.php');
    require_once('../Enrollments/EnrollmentDetailCol.php');
    
    // get parameters
    $idno    = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $semCode = $_GET['semCode'];

    $enrollment = new Enrollment();
    
    echo $enrollment->isExist($idno, $schYear, $semCode);
} else if ( strtoupper($action)=='CHECKOLDENROLLMENT' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Students/StudentCol.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Enrollments/OldEnrollmentCol.php');
    require_once('../Enrollments/OldEnrollmentDetailCol.php');
    
    // get parameters
    $idno    = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $semCode = $_GET['semCode'];

    $enrollment = new OldEnrollment();
    
    echo $enrollment->isExist($idno, $schYear, $semCode);
} else if ( strtoupper($action)=='CHECKENROLLMENTHS' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentHS.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Enrollments/EnrollmentHS.php');
    require_once('../Enrollments/EnrollmentDetailHS.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Schedules/BlockSectionSubjectHS.php');
    require_once('../Schedules/BlockSectionHS.php');
    
    // get parameters
    $idno    = $_GET['idno'];
    $schYear = $_GET['schYear'];

    $enrollment = new Enrollment();
    
    echo $enrollment->isExist($idno, $schYear);
} else if ( strtoupper($action)=='CHECKENROLLMENTELEM' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentElem.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Enrollments/EnrollmentElem.php');
    require_once('../Enrollments/EnrollmentDetailElem.php');
    require_once('../Schedules/ScheduleElem.php');
    require_once('../Schedules/BlockSectionSubjectElem.php');
    require_once('../Schedules/BlockSectionElem.php');
    
    // get parameters
    $idno    = $_GET['idno'];
    $schYear = $_GET['schYear'];

    $enrollment = new Enrollment();
    
    echo $enrollment->isExist($idno, $schYear);
} else if ( strtoupper($action)=='CHECKENROLLMENTPRESCHOOL' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentPreschool.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Enrollments/EnrollmentPreschool.php');
    require_once('../Enrollments/EnrollmentDetailPreschool.php');
    require_once('../Schedules/SchedulePreschool.php');
    require_once('../Schedules/BlockSectionSubjectPreschool.php');
    require_once('../Schedules/BlockSectionPreschool.php');
    
    // get parameters
    $idno    = $_GET['idno'];
    $schYear = $_GET['schYear'];

    $enrollment = new Enrollment();
    
    echo $enrollment->isExist($idno, $schYear);
} else if ( strtoupper($action)=='CHECKPAYMENT' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Config/ConfigCol.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Students/StudentCol.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Enrollments/EnrollmentCol.php');
    require_once('../Enrollments/EnrollmentDetailCol.php');
    require_once('../Payments/ORHeader.php');
    
    // get parameters
    $idno    = $_GET['idno'];
    $schYear = $_GET['schYear'];
    $semCode = $_GET['semCode'];

    $config = new Config();
    
    if($config->getConfig('No Pending Setup') == '1') {
        $ok=0;
        $orheader = new ORHeader();
        $records = $orheader->getRegistrationPayment($idno, $schYear, $semCode);
        if (!$records) {
            $ok = 1;
        } 
        echo $ok;
    } else {
        echo 0;
    }
    
} else if ( strtoupper($action)=='GETTOTALUNITS' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Config/ConfigCol.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Students/StudentCol.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Enrollments/EnrollmentCol.php');
    require_once('../Enrollments/EnrollmentDetailCol.php');
    require_once('../Reports/ReportCol.php');
    
    // get parameters
    $idno       = $_GET['idno'];
    $schYear    = $_GET['schYear'];
    $semCode    = $_GET['semCode'];

    
    $reportClass = new ReportClass();
    $student    = new Student($idno);
    $curID      = $student->curID;
    $yrLevel    = $student->yrLevel;

    $query =    "SELECT sum( subjects.units ) AS allowableUnits
                FROM students
                INNER JOIN curriculum_subjs ON ( '$curID' = curriculum_subjs.curID )
                INNER JOIN subjects ON ( curriculum_subjs.subjID = subjects.subjID )
                WHERE (
                curriculum_subjs.yrLevel = '$yrLevel'
                AND curriculum_subjs.semCode = '$semCode'
                AND students.idno = '$idno'
                )
                GROUP BY curriculum_subjs.curID";
		
    $records = $reportClass->adhocQuery($query);
    if ($records!='0') {
        foreach ($records as $row) {
            echo $row['allowableUnits'];
        }
    } else {
        echo 0;
    }
} else if ( strtoupper($action)=='CHECKENTRY' ) {
    
    if (!empty($_SESSION['SCHEDULES'])) {
        echo 1;
    } else {
        echo 0;
    }
} else if ( strtoupper($action)=='CHECKOPENSCHEDULE' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/Schedule.php');
    
    // get parameters
    $schedID  = $_GET['schedID'];
    $schedule = new Schedule($schedID);
    
    if (!isInOriginal($schedID)) {
        if ($schedule->rstatus) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        // bypass the checking for close schedule since it was already counted.
        echo 1;
    }
} else if ( strtoupper($action)=='CHECKOPENSCHEDULEHS' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    
    // get parameters
    $schedID  = $_GET['schedID'];
    $schedule = new Schedule($schedID);
    
    if (!isInOriginal($schedID)) {
        if ($schedule->rstatus) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        // bypass the checking for close schedule since it was already counted.
        echo 1;
    }
} else if ( strtoupper($action)=='CHECKOPENSCHEDULEELEM' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    
    // get parameters
    $schedID  = $_GET['schedID'];
    $schedule = new Schedule($schedID);
    
    if (!isInOriginal($schedID)) {
        if ($schedule->rstatus) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        // bypass the checking for close schedule since it was already counted.
        echo 1;
    }
} else if ( strtoupper($action)=='DOUBLECHECKOPENSCHEDULE' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/Schedule.php');
    
    $schedule = new Schedule();
    
    $closed_scheds = "";
    
    if ($_SESSION['SCHEDULES']) {
        foreach ($_SESSION['SCHEDULES'] as $sched) {
            $schedule->schedID = $sched['schedID'];
            $schedule->retrieveSchedule();
            
            // make sure the sched is not in the current enrollment
            // for edit
            if (!isInOriginal( $sched['schedID'])) {
                if (!$schedule->rstatus) {
                    if ($closed_scheds) {
                        $closed_scheds .= ",".$sched['schedCode'];
                    } else {
                        $closed_scheds .= $sched['schedCode'];
                    }
                }
            }
        }
    }
    
    echo $closed_scheds;
} else if ( strtoupper($action)=='DOUBLECHECKOPENSCHEDULEHS' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    
    $schedule = new Schedule();
    
    $closed_scheds = "";
    
    if ($_SESSION['SCHEDULES']) {
        foreach ($_SESSION['SCHEDULES'] as $sched) {
            $schedule->schedID = $sched['schedID'];
            $schedule->retrieveSchedule();
            
            // make sure the sched is not in the current enrollment
            // for edit
            if (!isInOriginal( $sched['schedID'])) {
                if (!$schedule->rstatus) {
                    if ($closed_scheds) {
                        $closed_scheds .= ",".$sched['schedCode'];
                    } else {
                        $closed_scheds .= $sched['schedCode'];
                    }
                }
            }
        }
    }
    
    echo $closed_scheds;
} else if ( strtoupper($action)=='DOUBLECHECKOPENSCHEDULEELEM' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    
    $schedule = new Schedule();
    
    $closed_scheds = "";
    
    if ($_SESSION['SCHEDULES']) {
        foreach ($_SESSION['SCHEDULES'] as $sched) {
            $schedule->schedID = $sched['schedID'];
            $schedule->retrieveSchedule();
            
            // make sure the sched is not in the current enrollment
            // for edit
            if (!isInOriginal( $sched['schedID'])) {
                if (!$schedule->rstatus) {
                    if ($closed_scheds) {
                        $closed_scheds .= ",".$sched['schedCode'];
                    } else {
                        $closed_scheds .= $sched['schedCode'];
                    }
                }
            }
        }
    }
    
    echo $closed_scheds;
} else if ( strtoupper($action)=='DOUBLECHECKOPENSCHEDULEPRESCHOOL' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    
    $schedule = new Schedule();
    
    $closed_scheds = "";
    
    if ($_SESSION['SCHEDULES']) {
        foreach ($_SESSION['SCHEDULES'] as $sched) {
            $schedule->schedID = $sched['schedID'];
            $schedule->retrieveSchedule();
            
            // make sure the sched is not in the current enrollment
            // for edit
            if (!isInOriginal( $sched['schedID'])) {
                if (!$schedule->rstatus) {
                    if ($closed_scheds) {
                        $closed_scheds .= ",".$sched['schedCode'];
                    } else {
                        $closed_scheds .= $sched['schedCode'];
                    }
                }
            }
        }
    }
    
    echo $closed_scheds;
} else if ( strtoupper($action)=='DOUBLECHECKOPENBLOCKSECTIONHS' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Schedules/BlockSectionHS.php');
    require_once('../Schedules/BlockSectionSubjectHS.php');
    
    $secID = $_GET['secID'];
    
    $blocksection = new BlockSection($secID);
    
    echo $blocksection->rstatus;
} else if ( strtoupper($action)=='DOUBLECHECKOPENBLOCKSECTIONELEM' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Schedules/BlockSectionElem.php');
    require_once('../Schedules/BlockSectionSubjectElem.php');
    
    $secID = $_GET['secID'];
    
    $blocksection = new BlockSection($secID);
    
    echo $blocksection->rstatus;
} else if ( strtoupper($action)=='DOUBLECHECKOPENBLOCKSECTIONPRESCHOOL' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Schedules/BlockSectionElem.php');
    require_once('../Schedules/BlockSectionSubjectElem.php');
    
    $secID = $_GET['secID'];
    
    $blocksection = new BlockSection($secID);
    
    echo $blocksection->rstatus;
} else if ( strtoupper($action)=='ADDSCHEDULE' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/Schedule.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    // check for duplicates 
    if ( !isDuplicate($schedID) ) {
        $data = array();
        $schedule = new Schedule($schedID);
        $subj = new Subject($schedule->subjID);
    
        $data['schedID']       = $schedule->schedID;
        $data['schedCode']     = $schedule->schedCode;
        $data['courseCode']    = $schedule->courseCode;
        $data['subjID']        = $schedule->subjID;
        $data['subjCode']      = $schedule->subjCode;
        $data['starttime']     = $schedule->startTime;
        $data['startdTime']    = $schedule->startdTime;
        $data['endtime']       = $schedule->endTime;
        $data['enddTime']      = $schedule->enddTime;
        
        $data['time_display']  = date("g:i",strtotime($schedule->startdTime))."-".date("g:i A",strtotime($schedule->enddTime));
        
        // days for display ex. MWF, TTH, SAT, SUN
        if ($schedule->onMon) {
            $data['days_display']  .= "M";    
        }
        
        if ($schedule->onTue) {
            if ($schedule->onThu) {
                $data['days_display']  .= "T";
            } else {
                $data['days_display']  .= "Tue";
            }
        }
        
        if ($schedule->onWed) {
            $data['days_display']  .= "W";
        }
        
        if ($schedule->onThu) {
            if ($schedule->onTue) {
                $data['days_display']  .= "Th";
            } else {
                $data['days_display']  .= "Thu";
            }
        }
        
        if ($schedule->onFri) {
            $data['days_display']  .= "F";
        }
        
        if ($schedule->onSat) {
            $data['days_display']  .= "Sat";
        }
        
        if ($schedule->onSun) {
            $data['days_display']  .= "Sun";
        }
        
        // numerical presentation of days separated with comma (,)
        $data['days']   = $schedule->onMon.",".$schedule->onTue.",".$schedule->onWed.",".$schedule->onThu.",".$schedule->onFri.",".$schedule->onSat.",".$schedule->onSun.",";
    
        $data['onMon']  = $schedule->onMon;
        $data['onTue']  = $schedule->onTue;
        $data['onWed']  = $schedule->onWed;
        $data['onThu']  = $schedule->onThu;
        $data['onFri']  = $schedule->onFri;
        $data['onSat']  = $schedule->onSat;
        $data['onSun']  = $schedule->onSun;
        
        $data['room']   = $schedule->room;
        $data['units']  = $subj->units; 
        $data['units']  = $schedule->units; 
    
        // need duplicate checking
        $_SESSION['SCHEDULES'][]=$data;
    
        echo displaySchedules();
    }
} else if ( strtoupper($action)=='ADDSCHEDULEHS' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    // check for duplicates 
    if ( !isDuplicate($schedID) ) {
        $data = array();
        $schedule = new Schedule($schedID);
        $subj = new Subject($schedule->subjID);
    
        $data['schedID']       = $schedule->schedID;
        $data['schedCode']     = $schedule->schedCode;
        $data['subjID']        = $schedule->subjID;
        $data['subjCode']      = $schedule->subjCode;
        $data['starttime']     = $schedule->startTime;
        $data['startdTime']    = $schedule->startdTime;
        $data['endtime']       = $schedule->endTime;
        $data['enddTime']      = $schedule->enddTime;
        
        $data['time_display']  = date("g:i",strtotime($schedule->startdTime))."-".date("g:i A",strtotime($schedule->enddTime));
        
        // days for display ex. MWF, TTH, SAT, SUN
        if ($schedule->onMon) {
            $data['days_display']  .= "M";    
        }
        
        if ($schedule->onTue) {
            if ($schedule->onThu) {
                $data['days_display']  .= "T";
            } else {
                $data['days_display']  .= "Tue";
            }
        }
        
        if ($schedule->onWed) {
            $data['days_display']  .= "W";
        }
        
        if ($schedule->onThu) {
            if ($schedule->onTue) {
                $data['days_display']  .= "Th";
            } else {
                $data['days_display']  .= "Thu";
            }
        }
        
        if ($schedule->onFri) {
            $data['days_display']  .= "F";
        }
        
        if ($schedule->onSat) {
            $data['days_display']  .= "Sat";
        }
        
        if ($schedule->onSun) {
            $data['days_display']  .= "Sun";
        }
        
        // numerical presentation of days separated with comma (,)
        $data['days']   = $schedule->onMon.",".$schedule->onTue.",".$schedule->onWed.",".$schedule->onThu.",".$schedule->onFri.",".$schedule->onSat.",".$schedule->onSun.",";
    
        $data['onMon']  = $schedule->onMon;
        $data['onTue']  = $schedule->onTue;
        $data['onWed']  = $schedule->onWed;
        $data['onThu']  = $schedule->onThu;
        $data['onFri']  = $schedule->onFri;
        $data['onSat']  = $schedule->onSat;
        $data['onSun']  = $schedule->onSun;
        
        $data['room']   = $schedule->room;
        $data['units']  = $subj->units; 
    
        // need duplicate checking
        $_SESSION['SCHEDULES'][]=$data;
    
        echo displaySchedules_HS_Elem();
    }
} else if ( strtoupper($action)=='ADDSCHEDULEELEM' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    // check for duplicates 
    if ( !isDuplicate($schedID) ) {
        $data = array();
        $schedule = new Schedule($schedID);
        $subj = new Subject($schedule->subjID);
    
        $data['schedID']       = $schedule->schedID;
        $data['schedCode']     = $schedule->schedCode;
        $data['subjID']        = $schedule->subjID;
        $data['subjCode']      = $schedule->subjCode;
        $data['starttime']     = $schedule->startTime;
        $data['startdTime']    = $schedule->startdTime;
        $data['endtime']       = $schedule->endTime;
        $data['enddTime']      = $schedule->enddTime;
        
        $data['time_display']  = date("g:i",strtotime($schedule->startdTime))."-".date("g:i A",strtotime($schedule->enddTime));
        
        // days for display ex. MWF, TTH, SAT, SUN
        if ($schedule->onMon) {
            $data['days_display']  .= "M";    
        }
        
        if ($schedule->onTue) {
            if ($schedule->onThu) {
                $data['days_display']  .= "T";
            } else {
                $data['days_display']  .= "Tue";
            }
        }
        
        if ($schedule->onWed) {
            $data['days_display']  .= "W";
        }
        
        if ($schedule->onThu) {
            if ($schedule->onTue) {
                $data['days_display']  .= "Th";
            } else {
                $data['days_display']  .= "Thu";
            }
        }
        
        if ($schedule->onFri) {
            $data['days_display']  .= "F";
        }
        
        if ($schedule->onSat) {
            $data['days_display']  .= "Sat";
        }
        
        if ($schedule->onSun) {
            $data['days_display']  .= "Sun";
        }
        
        // numerical presentation of days separated with comma (,)
        $data['days']   = $schedule->onMon.",".$schedule->onTue.",".$schedule->onWed.",".$schedule->onThu.",".$schedule->onFri.",".$schedule->onSat.",".$schedule->onSun.",";
    
        $data['onMon']  = $schedule->onMon;
        $data['onTue']  = $schedule->onTue;
        $data['onWed']  = $schedule->onWed;
        $data['onThu']  = $schedule->onThu;
        $data['onFri']  = $schedule->onFri;
        $data['onSat']  = $schedule->onSat;
        $data['onSun']  = $schedule->onSun;
        
        $data['room']   = $schedule->room;
        $data['units']  = $subj->units; 
    
        // need duplicate checking
        $_SESSION['SCHEDULES'][]=$data;
    
        echo displaySchedules_HS_Elem();
    }

} else if ( strtoupper($action)=='ADDSUBJECT' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    
    // get parameters
    $subjID = $_GET['subjID'];
    $fgrade = $_GET['fgrade'];
    
    $subj = new Subject($subjID);

    $data['subjID']     = $subj->subjID;
    $data['subjCode']   = $subj->subjCode;
    $data['courseCode'] = $subj->courseCode;
    $data['units']      = $subj->units;
    $data['fgrade']     = $fgrade;

    // need duplicate checking
    $_SESSION['SCHEDULES'][]=$data;

    echo displaySubjects();

} else if ( strtoupper($action)=='SETBLOCKSECTION' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/Schedule.php');
    require_once('../Schedules/BlockSectionSubjectCol.php');
    require_once('../Schedules/BlockSectionCol.php');
    
    // get parameters
    $secID = $_GET['secID'];
    
    $blocksection = new BlockSection($secID);
    
    // check for duplicates 
    if ( $blocksection->subjs ) {
        foreach ($blocksection->subjs as $sched) {
            $data = array();
            $schedule = new Schedule($sched['schedID']);
            $subj = new Subject($schedule->subjID);
        
            $data['schedID']       = $schedule->schedID;
            $data['schedCode']     = $schedule->schedCode;
            $data['courseCode']    = $schedule->courseCode;
            $data['subjID']        = $schedule->subjID;
            $data['subjCode']      = $schedule->subjCode;
            $data['starttime']     = $schedule->startTime;
            $data['startdTime']    = $schedule->startdTime;
            $data['endtime']       = $schedule->endTime;
            $data['enddTime']      = $schedule->enddTime;
            
            $data['time_display']  = date("g:i",strtotime($schedule->startdTime))."-".date("g:i A",strtotime($schedule->enddTime));
            
            // days for display ex. MWF, TTH, SAT, SUN
            if ($schedule->onMon) {
                $data['days_display']  .= "M";    
            }
            
            if ($schedule->onTue) {
                if ($schedule->onThu) {
                    $data['days_display']  .= "T";
                } else {
                    $data['days_display']  .= "Tue";
                }
            }
            
            if ($schedule->onWed) {
                $data['days_display']  .= "W";
            }
            
            if ($schedule->onThu) {
                if ($schedule->onTue) {
                    $data['days_display']  .= "Th";
                } else {
                    $data['days_display']  .= "Thu";
                }
            }
            
            if ($schedule->onFri) {
                $data['days_display']  .= "F";
            }
            
            if ($schedule->onSat) {
                $data['days_display']  .= "Sat";
            }
            
            if ($schedule->onSun) {
                $data['days_display']  .= "Sun";
            }
            
            // numerical presentation of days separated with comma (,)
            $data['days']   = $schedule->onMon.",".$schedule->onTue.",".$schedule->onWed.",".$schedule->onThu.",".$schedule->onFri.",".$schedule->onSat.",".$schedule->onSun.",";
        
            $data['onMon']  = $schedule->onMon;
            $data['onTue']  = $schedule->onTue;
            $data['onWed']  = $schedule->onWed;
            $data['onThu']  = $schedule->onThu;
            $data['onFri']  = $schedule->onFri;
            $data['onSat']  = $schedule->onSat;
            $data['onSun']  = $schedule->onSun;
            
            $data['room']   = $schedule->room;
            $data['units']  = $subj->units; 
        
            // need duplicate checking
            $_SESSION['SCHEDULES'][]=$data;
        }
        echo displaySchedules();
    }
} else if ( strtoupper($action)=='SETBLOCKSECTIONHS' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Schedules/BlockSectionSubjectHS.php');
    require_once('../Schedules/BlockSectionHS.php');
    
    // get parameters
    $secID = $_GET['secID'];
    
    $blocksection = new BlockSection($secID);
    
    // check for duplicates 
    if ( $blocksection->subjs ) {
        foreach ($blocksection->subjs as $sched) {
            $data = array();
            $schedule = new Schedule($sched['schedID']);
            $subj = new Subject($schedule->subjID);
        
            $data['schedID']       = $schedule->schedID;
            $data['schedCode']     = $schedule->schedCode;
            $data['subjID']        = $schedule->subjID;
            $data['subjCode']      = $schedule->subjCode;
            $data['starttime']     = $schedule->startTime;
            $data['startdTime']    = $schedule->startdTime;
            $data['endtime']       = $schedule->endTime;
            $data['enddTime']      = $schedule->enddTime;
            
            $data['time_display']  = date("g:i",strtotime($schedule->startdTime))."-".date("g:i A",strtotime($schedule->enddTime));
            
            // days for display ex. MWF, TTH, SAT, SUN
            if ($schedule->onMon) {
                $data['days_display']  .= "M";    
            }
            
            if ($schedule->onTue) {
                if ($schedule->onThu) {
                    $data['days_display']  .= "T";
                } else {
                    $data['days_display']  .= "Tue";
                }
            }
            
            if ($schedule->onWed) {
                $data['days_display']  .= "W";
            }
            
            if ($schedule->onThu) {
                if ($schedule->onTue) {
                    $data['days_display']  .= "Th";
                } else {
                    $data['days_display']  .= "Thu";
                }
            }
            
            if ($schedule->onFri) {
                $data['days_display']  .= "F";
            }
            
            if ($schedule->onSat) {
                $data['days_display']  .= "Sat";
            }
            
            if ($schedule->onSun) {
                $data['days_display']  .= "Sun";
            }
            
            // numerical presentation of days separated with comma (,)
            $data['days']   = $schedule->onMon.",".$schedule->onTue.",".$schedule->onWed.",".$schedule->onThu.",".$schedule->onFri.",".$schedule->onSat.",".$schedule->onSun.",";
        
            $data['onMon']  = $schedule->onMon;
            $data['onTue']  = $schedule->onTue;
            $data['onWed']  = $schedule->onWed;
            $data['onThu']  = $schedule->onThu;
            $data['onFri']  = $schedule->onFri;
            $data['onSat']  = $schedule->onSat;
            $data['onSun']  = $schedule->onSun;
            
            $data['room']   = $schedule->room;
            $data['units']  = $subj->units; 
        
            // need duplicate checking
            $_SESSION['SCHEDULES'][]=$data;
        }
        echo displaySchedules_HS_Elem();
    }
} else if ( strtoupper($action)=='SETBLOCKSECTIONELEM' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    require_once('../Schedules/BlockSectionSubjectElem.php');
    require_once('../Schedules/BlockSectionElem.php');
    
    // get parameters
    $secID = $_GET['secID'];
    
    $blocksection = new BlockSection($secID);
    
    // check for duplicates 
    if ( $blocksection->subjs ) {
        foreach ($blocksection->subjs as $sched) {
            $data = array();
            $schedule = new Schedule($sched['schedID']);
            $subj = new Subject($schedule->subjID);
        
            $data['schedID']       = $schedule->schedID;
            $data['schedCode']     = $schedule->schedCode;
            $data['subjID']        = $schedule->subjID;
            $data['subjCode']      = $schedule->subjCode;
            $data['starttime']     = $schedule->startTime;
            $data['startdTime']    = $schedule->startdTime;
            $data['endtime']       = $schedule->endTime;
            $data['enddTime']      = $schedule->enddTime;
            
            $data['time_display']  = date("g:i",strtotime($schedule->startdTime))."-".date("g:i A",strtotime($schedule->enddTime));
            
            // days for display ex. MWF, TTH, SAT, SUN
            if ($schedule->onMon) {
                $data['days_display']  .= "M";    
            }
            
            if ($schedule->onTue) {
                if ($schedule->onThu) {
                    $data['days_display']  .= "T";
                } else {
                    $data['days_display']  .= "Tue";
                }
            }
            
            if ($schedule->onWed) {
                $data['days_display']  .= "W";
            }
            
            if ($schedule->onThu) {
                if ($schedule->onTue) {
                    $data['days_display']  .= "Th";
                } else {
                    $data['days_display']  .= "Thu";
                }
            }
            
            if ($schedule->onFri) {
                $data['days_display']  .= "F";
            }
            
            if ($schedule->onSat) {
                $data['days_display']  .= "Sat";
            }
            
            if ($schedule->onSun) {
                $data['days_display']  .= "Sun";
            }
            
            // numerical presentation of days separated with comma (,)
            $data['days']   = $schedule->onMon.",".$schedule->onTue.",".$schedule->onWed.",".$schedule->onThu.",".$schedule->onFri.",".$schedule->onSat.",".$schedule->onSun.",";
        
            $data['onMon']  = $schedule->onMon;
            $data['onTue']  = $schedule->onTue;
            $data['onWed']  = $schedule->onWed;
            $data['onThu']  = $schedule->onThu;
            $data['onFri']  = $schedule->onFri;
            $data['onSat']  = $schedule->onSat;
            $data['onSun']  = $schedule->onSun;
            
            $data['room']   = $schedule->room;
            $data['units']  = $subj->units; 
        
            // need duplicate checking
            $_SESSION['SCHEDULES'][]=$data;
        }
        echo displaySchedules_HS_Elem();
    }
} else if ( strtoupper($action)=='SETBLOCKSECTIONPRESCHOOL' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    require_once('../Schedules/BlockSectionSubjectPreschool.php');
    require_once('../Schedules/BlockSectionPreschool.php');
    
    // get parameters
    $secID = $_GET['secID'];
    
    $blocksection = new BlockSection($secID);
    
    // check for duplicates 
    if ( $blocksection->subjs ) {
        foreach ($blocksection->subjs as $sched) {
            $data = array();
            $schedule = new Schedule($sched['schedID']);
            $subj = new Subject($schedule->subjID);
        
            $data['schedID']       = $schedule->schedID;
            $data['schedCode']     = $schedule->schedCode;
            $data['subjID']        = $schedule->subjID;
            $data['subjCode']      = $schedule->subjCode;
            $data['starttime']     = $schedule->startTime;
            $data['startdTime']    = $schedule->startdTime;
            $data['endtime']       = $schedule->endTime;
            $data['enddTime']      = $schedule->enddTime;
            
            $data['time_display']  = date("g:i",strtotime($schedule->startdTime))."-".date("g:i A",strtotime($schedule->enddTime));
            
            // days for display ex. MWF, TTH, SAT, SUN
            if ($schedule->onMon) {
                $data['days_display']  .= "M";    
            }
            
            if ($schedule->onTue) {
                if ($schedule->onThu) {
                    $data['days_display']  .= "T";
                } else {
                    $data['days_display']  .= "Tue";
                }
            }
            
            if ($schedule->onWed) {
                $data['days_display']  .= "W";
            }
            
            if ($schedule->onThu) {
                if ($schedule->onTue) {
                    $data['days_display']  .= "Th";
                } else {
                    $data['days_display']  .= "Thu";
                }
            }
            
            if ($schedule->onFri) {
                $data['days_display']  .= "F";
            }
            
            if ($schedule->onSat) {
                $data['days_display']  .= "Sat";
            }
            
            if ($schedule->onSun) {
                $data['days_display']  .= "Sun";
            }
            
            // numerical presentation of days separated with comma (,)
            $data['days']   = $schedule->onMon.",".$schedule->onTue.",".$schedule->onWed.",".$schedule->onThu.",".$schedule->onFri.",".$schedule->onSat.",".$schedule->onSun.",";
        
            $data['onMon']  = $schedule->onMon;
            $data['onTue']  = $schedule->onTue;
            $data['onWed']  = $schedule->onWed;
            $data['onThu']  = $schedule->onThu;
            $data['onFri']  = $schedule->onFri;
            $data['onSat']  = $schedule->onSat;
            $data['onSun']  = $schedule->onSun;
            
            $data['room']   = $schedule->room;
            $data['units']  = $subj->units; 
        
            // need duplicate checking
            $_SESSION['SCHEDULES'][]=$data;
        }
        echo displaySchedules_HS_Elem();
    }
} else if ( strtoupper($action)=='CHECKCONFLICT' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/Schedule.php');
    require_once('../Schedules/BlockSectionSubjectCol.php');
    require_once('../Schedules/BlockSectionCol.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    $sched = new Schedule($schedID);
    
    $target['start'] = $sched->startdTime;
    $target['end']   = $sched->enddTime;
    $target['onMon'] = $sched->onMon;
    $target['onTue'] = $sched->onTue;
    $target['onWed'] = $sched->onWed;
    $target['onThu'] = $sched->onThu;
    $target['onFri'] = $sched->onFri;
    $target['onSat'] = $sched->onSat;
    $target['onSun'] = $sched->onSun;
    
    $blocksection = new BlockSection();
    echo $blocksection->isConflict($target, $_SESSION['SCHEDULES']);
    
} else if ( strtoupper($action)=='CHECKCONFLICTHS' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Schedules/BlockSectionSubjectHS.php');
    require_once('../Schedules/BlockSectionHS.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    $sched = new Schedule($schedID);
    
    $target['start'] = $sched->startdTime;
    $target['end']   = $sched->enddTime;
    $target['onMon'] = $sched->onMon;
    $target['onTue'] = $sched->onTue;
    $target['onWed'] = $sched->onWed;
    $target['onThu'] = $sched->onThu;
    $target['onFri'] = $sched->onFri;
    $target['onSat'] = $sched->onSat;
    $target['onSun'] = $sched->onSun;
    
    $blocksection = new BlockSection();
    echo $blocksection->isConflict($target, $_SESSION['SCHEDULES']);
    
} else if ( strtoupper($action)=='CHECKCONFLICTELEM' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    require_once('../Schedules/BlockSectionSubjectElem.php');
    require_once('../Schedules/BlockSectionElem.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    $sched = new Schedule($schedID);
    
    $target['start'] = $sched->startdTime;
    $target['end']   = $sched->enddTime;
    $target['onMon'] = $sched->onMon;
    $target['onTue'] = $sched->onTue;
    $target['onWed'] = $sched->onWed;
    $target['onThu'] = $sched->onThu;
    $target['onFri'] = $sched->onFri;
    $target['onSat'] = $sched->onSat;
    $target['onSun'] = $sched->onSun;
    
    $blocksection = new BlockSection();
    echo $blocksection->isConflict($target, $_SESSION['SCHEDULES']);
    
} else if ( strtoupper($action)=='REMSCHEDULE' ) {
    // get parameters
    $schedID = $_GET['schedID'];

    if ($_SESSION['SCHEDULES']) {
        $ctr = 0;
        foreach ($_SESSION['SCHEDULES'] as $row) {
            if ($row['schedID'] == $schedID) {
                // found schedule here
                $found = 1;  
                
                for ($r=$ctr; $r < count($_SESSION['SCHEDULES']); $r++) {
                    $_SESSION['SCHEDULES'][$r] = $_SESSION['SCHEDULES'][$r+1];
                }
                
                // clear the last record since the target was record already
                unset ($_SESSION['SCHEDULES'][count($_SESSION['SCHEDULES'])-1]);
                
                break;                        
            }
            $ctr++;
        }
    }

    echo displaySchedules();

} else if ( strtoupper($action)=='REMSCHEDULEHS' ) {
    // get parameters
    $schedID = $_GET['schedID'];

    if ($_SESSION['SCHEDULES']) {
        $ctr = 0;
        foreach ($_SESSION['SCHEDULES'] as $row) {
            if ($row['schedID'] == $schedID) {
                // found schedule here
                $found = 1;  
                
                for ($r=$ctr; $r < count($_SESSION['SCHEDULES']); $r++) {
                    $_SESSION['SCHEDULES'][$r] = $_SESSION['SCHEDULES'][$r+1];
                }
                
                // clear the last record since the target was record already
                unset ($_SESSION['SCHEDULES'][count($_SESSION['SCHEDULES'])-1]);
                
                break;                        
            }
            $ctr++;
        }
    }

    echo displaySchedules_HS_Elem();
    
} else if ( strtoupper($action)=='REMSCHEDULEELEM' ) {
    // get parameters
    $schedID = $_GET['schedID'];

    if ($_SESSION['SCHEDULES']) {
        $ctr = 0;
        foreach ($_SESSION['SCHEDULES'] as $row) {
            if ($row['schedID'] == $schedID) {
                // found schedule here
                $found = 1;  
                
                for ($r=$ctr; $r < count($_SESSION['SCHEDULES']); $r++) {
                    $_SESSION['SCHEDULES'][$r] = $_SESSION['SCHEDULES'][$r+1];
                }
                
                // clear the last record since the target was record already
                unset ($_SESSION['SCHEDULES'][count($_SESSION['SCHEDULES'])-1]);
                
                break;                        
            }
            $ctr++;
        }
    }

    echo displaySchedules_HS_Elem();
    
} else if ( strtoupper($action)=='REMSCHEDULEPRESCHOOL' ) {
    // get parameters
    $schedID = $_GET['schedID'];

    if ($_SESSION['SCHEDULES']) {
        $ctr = 0;
        foreach ($_SESSION['SCHEDULES'] as $row) {
            if ($row['schedID'] == $schedID) {
                // found schedule here
                $found = 1;  
                
                for ($r=$ctr; $r < count($_SESSION['SCHEDULES']); $r++) {
                    $_SESSION['SCHEDULES'][$r] = $_SESSION['SCHEDULES'][$r+1];
                }
                
                // clear the last record since the target was record already
                unset ($_SESSION['SCHEDULES'][count($_SESSION['SCHEDULES'])-1]);
                
                break;                        
            }
            $ctr++;
        }
    }

    echo displaySchedules_HS_Elem();
    
} else if ( strtoupper($action)=='REMSUBJECT' ) {
    // get parameters
    $subjID = $_GET['subjID'];

    if ($_SESSION['SCHEDULES']) {
        $ctr = 0;
        foreach ($_SESSION['SCHEDULES'] as $row) {
            if ($row['subjID'] == $subjID) {
                // found schedule here
                $found = 1;  
                
                for ($r=$ctr; $r < count($_SESSION['SCHEDULES']); $r++) {
                    $_SESSION['SCHEDULES'][$r] = $_SESSION['SCHEDULES'][$r+1];
                }
                
                // clear the last record since the target was record already
                unset ($_SESSION['SCHEDULES'][count($_SESSION['SCHEDULES'])-1]);
                
                break;                        
            }
            $ctr++;
        }
    }

    echo displaySubjects();
} else if ( strtoupper($action)=='GETSCHEDULESHS' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    
    // get parameters
    $schYear  = $_GET['schYear'];
    
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' AND ";
    } 

    $where[0]['rstatus'] = "='1'";
        
    $schedule = new Schedule();
    $result  = $schedule->retrieveAllSchedules($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
    
} else if ( strtoupper($action)=='GETSCHEDULESELEM' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    
    // get parameters
    $schYear  = $_GET['schYear'];
    
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' AND ";
    } 

    $where[0]['rstatus'] = "='1'";
        
    $schedule = new Schedule();
    $result  = $schedule->retrieveAllSchedules($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( strtoupper($action)=='CHECKDUPLICATE' ) {
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    echo isDuplicate($schedID);
    
} else if ( strtoupper($action)=='CHECKDUPLICATESUBJ' ) {
    
    // get parameters
    $subjID = $_GET['subjID'];
    
    echo isDuplicateSubject($subjID);

} else if ( strtoupper($action)=='CHECKSCHEDCODE' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/Subject.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/Schedule.php');
    
    // get parameters
    $schYear   = $_GET['schYear'];
    $semCode   = $_GET['semCode'];
    $schedCode = $_GET['schedCode'];
    $sched = new Schedule();
    
    unset($conds);
    $conds[0]['schedules.schYear']="= '$schYear' AND ";
    $conds[0]['schedules.semCode']="= '$semCode' AND ";
    $conds[0]['schedules.schedCode']="= '$schedCode'";
    
    $result = $sched->retrieveAllSchedulesAssociated($conds);
    
    if (count($result)>0) {
        echo $result[0]['schedID'];
    } else {
        echo 0;
    } 

} else if ( strtoupper($action)=='CHECKSCHEDCODEHS' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    
    // get parameters
    $schYear   = $_GET['schYear'];
    $schedCode = $_GET['schedCode'];
    $sched = new Schedule();
    
    unset($conds);
    $conds[0]['schedules.schYear']="= '$schYear' AND ";
    $conds[0]['schedules.schedCode']="= '$schedCode'";
    $result = $sched->retrieveAllSchedulesAssociated($conds);
    
    if (count($result)>0) {
        echo $result[0]['schedID'];
    } else {
        echo 0;
    } 
 
} else if ( strtoupper($action)=='CHECKSCHEDCODEELEM' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    
    // get parameters
    $schYear   = $_GET['schYear'];
    $schedCode = $_GET['schedCode'];
    $sched = new Schedule();
    
    unset($conds);
    $conds[0]['schedules.schYear']="= '$schYear' AND ";
    $conds[0]['schedules.schedCode']="= '$schedCode'";
    $result = $sched->retrieveAllSchedulesAssociated($conds);
    
    if (count($result)>0) {
        echo $result[0]['schedID'];
    } else {
        echo 0;
    } 
} else if ( strtoupper($action)=='CHECKSCHEDCODEPRESCHOOL' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    
    // get parameters
    $schYear   = $_GET['schYear'];
    $schedCode = $_GET['schedCode'];
    $sched = new Schedule();
    
    unset($conds);
    $conds[0]['schedules.schYear']="= '$schYear' AND ";
    $conds[0]['schedules.schedCode']="= '$schedCode'";
    $result = $sched->retrieveAllSchedulesAssociated($conds);
    
    if (count($result)>0) {
        echo $result[0]['schedID'];
    } else {
        echo 0;
    } 
} else if ( strtoupper($action)=='CHECKSUBJECTLEVELHS' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    $sched = new Schedule($schedID);
    if ($sched->subjID) {
        $subj = new Subject($sched->subjID);
        echo $subj->yrLevel;
    } else {
        echo 0;
    } 
} else if ( strtoupper($action)=='CHECKSUBJECTLEVELELEM' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    $sched = new Schedule($schedID);
    
    if ($sched->subjID) {
        $subj = new Subject($sched->subjID);
        echo $subj->yrLevel;
    } else {
        echo 0;
    } 
} else if ( strtoupper($action)=='CHECKSUBJECTLEVELPRESCHOOL' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    $sched = new Schedule($schedID);
    
    if ($sched->subjID) {
        $subj = new Subject($sched->subjID);
        echo $subj->yrLevel;
    } else {
        echo 0;
    } 
} else if ( strtoupper($action)=='CHECKDEPARTMENT' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/Schedule.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $semCode = $_GET['semCode'];
    $schedCode = $_GET['schedCode'];
    $sched = new Schedule();
    
    unset($conds);
    $conds[0]['schYear']="= '$schYear' AND ";
    $conds[0]['semCode']="= '$semCode' AND ";
    $conds[0]['schedCode']="= '$schedCode' ";
    $result = $sched->retrieveAllSchedules($conds,"","",0,1);
    
    
    if (count($result)>0) {
        $course =  new Course($result[0]['courseID']);
        
        echo $course->deptID;
    } else {
        echo 0;
    }  
} else if ( strtoupper($action)=='GETDEPARTMENT' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/Subject.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/Schedule.php');
    
    // get parameters
    $courseID = $_GET['courseID'];
    $course   = new Course($courseID);
        
    echo $course->deptID;
} else if ( strtoupper($action)=='GETSECTIONS' ) {
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/Schedule.php');
    require_once('../Schedules/BlockSectionCol.php');
    require_once('../Schedules/BlockSectionSubjectCol.php');
    
    // get parameters
    $idno     = $_GET['idno'];
    $schYear  = $_GET['schYear'];
    $semCode  = $_GET['semCode'];
    $courseID = $_GET['courseID'];
    $yrLevel  = $_GET['yrLevel'];

    unset($conds);
    $conds[0]['schYear']  = " = '$schYear' AND ";
    $conds[0]['semCode']  = " = '$semCode' AND ";
    $conds[0]['courseID'] = " = '$courseID' AND ";
    $conds[0]['yrLevel']  = " = '$yrLevel' AND ";
    $conds[0]['rstatus']  = "= 1 ";
        
    $blocksection = new BlockSection();
    $result  = $blocksection->retrieveAllBlockSections($conds);
    
    $control = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                		<td scope="col" class="listViewThS1" width="40%" nowrap>Section</td>
                		<td scope="col" class="listViewThS1" width="30%" nowrap>Course</td>
                		<td scope="col" class="listViewThS1" width="30%" nowrap>Year</td>
                	</tr>
                	<!-- Start of subject Listing -->';
    if ($result) {
        $ctr=0;
        foreach ($result as $row) {
            $control .= "
                	<tr onmouseover=\"setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');\" onmouseout=\"setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');\" onmousedown=\"setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');\" height=\"20\">";
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top"><a href="javascript: setBlockSection(\''.$row['secID'].'\',\''.$row['secName'].'\');" class="listViewTdLinkS1">'.$row['secName'].'</a></td>';
                		
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top">'.$row['courseCode'].'</td>';
                		
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top">'.$row['schYear'].'</td>';
                        
    	   $control .= '</tr>
                	<tr>
                		<td colspan="20" class="listViewHRS1"></td>
                	</tr>';
    	
    	   $ctr++;
        }
    }
    $control .= '   <!-- End of subject Listing -->
                    </tbody>
                </table>';
    
    echo $control;

} else if ( strtoupper($action)=='GETSECTIONSHS' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Schedules/BlockSectionHS.php');
    require_once('../Schedules/BlockSectionSubjectHS.php');
    
    // get parameters
    $idno     = $_GET['idno'];
    $schYear  = $_GET['schYear'];
    $yrLevel  = $_GET['yrLevel'];

    unset($conds);
    $conds[0]['schYear']  = " = '$schYear' AND ";
    $conds[0]['yrLevel']  = " = '$yrLevel' AND ";
    $conds[0]['rstatus']  = "= 1 "; // open schedule
        
    $blocksection = new BlockSection();
    $result  = $blocksection->retrieveAllBlockSections($conds);
    
    $control = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                		<td scope="col" class="listViewThS1" width="40%" nowrap>Section</td>
                		<td scope="col" class="listViewThS1" width="20%" nowrap>Year</td>
                		<td scope="col" class="listViewThS1" width="40%" nowrap>No. Enrolled</td>
                	</tr>
                	<!-- Start of subject Listing -->';
    if ($result) {
        $ctr=0;
        foreach ($result as $row) {
            $control .= "
                	<tr onmouseover=\"setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');\" onmouseout=\"setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');\" onmousedown=\"setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');\" height=\"20\">";
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top"><a href="javascript: setBlockSection(\''.$row['secID'].'\',\''.$row['secName'].'\');" class="listViewTdLinkS1">'.$row['secName'].'</a></td>';
                		
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top">'.$row['yrLevel'].'</td>';
                        
                        
                        $control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top">'.$row['noEnrolled'].'</td>';
                		
                        
    	   $control .= '</tr>
                	<tr>
                		<td colspan="20" class="listViewHRS1"></td>
                	</tr>';
    	
    	   $ctr++;
        }
    }
    $control .= '   <!-- End of subject Listing -->
                    </tbody>
                </table>';
    
    echo $control;
    
} else if ( strtoupper($action)=='GETSECTIONSHS2' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Schedules/BlockSectionHS.php');
    require_once('../Schedules/BlockSectionSubjectHS.php');
    
    // get parameters
    $schYear  = $_GET['schYear'];
    $yrLevel  = $_GET['yrLevel'];

    unset($conds);
    $conds[0]['schYear']  = " = '$schYear' AND ";
    $conds[0]['yrLevel']  = " = '$yrLevel' ";
        
    $blocksection = new BlockSection();
    $result  = $blocksection->retrieveAllBlockSections($conds);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;
    
} else if ( strtoupper($action)=='GETSECTIONSELEM' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    require_once('../Schedules/BlockSectionElem.php');
    require_once('../Schedules/BlockSectionSubjectElem.php');
    
    // get parameters
    $idno     = $_GET['idno'];
    $schYear  = $_GET['schYear'];
    $yrLevel  = $_GET['yrLevel'];

    unset($conds);
    $conds[0]['schYear']  = " = '$schYear' AND ";
    $conds[0]['yrLevel']  = " = '$yrLevel' AND ";
    $conds[0]['rstatus']  = "= 1 "; // open schedule
        
    $blocksection = new BlockSection();
    $result  = $blocksection->retrieveAllBlockSections($conds);
    
    $control = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                		<td scope="col" class="listViewThS1" width="40%" nowrap>Section</td>
                		<td scope="col" class="listViewThS1" width="20%" nowrap>Grade</td>
                		<td scope="col" class="listViewThS1" width="40%" nowrap>No. Enrolled</td>
                	</tr>
                	<!-- Start of subject Listing -->';
    if ($result) {
        $ctr=0;
        foreach ($result as $row) {
            $control .= "
                	<tr onmouseover=\"setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');\" onmouseout=\"setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');\" onmousedown=\"setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');\" height=\"20\">";
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top"><a href="javascript: setBlockSection(\''.$row['secID'].'\',\''.$row['secName'].'\');" class="listViewTdLinkS1">'.$row['secName'].'</a></td>';
                		
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top">'.$row['yrLevel'].'</td>';
                        
                        $control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top">'.$row['noEnrolled'].'</td>';
                		
                        
    	   $control .= '</tr>
                	<tr>
                		<td colspan="20" class="listViewHRS1"></td>
                	</tr>';
    	
    	   $ctr++;
        }
    }
    $control .= '   <!-- End of subject Listing -->
                    </tbody>
                </table>';
    
    echo $control;

} else if ( strtoupper($action)=='GETSECTIONSELEM2' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    require_once('../Schedules/BlockSectionElem.php');
    require_once('../Schedules/BlockSectionSubjectElem.php');
    
    // get parameters
    $schYear  = $_GET['schYear'];
    $yrLevel  = $_GET['yrLevel'];

    unset($conds);
    $conds[0]['schYear']  = " = '$schYear' AND ";
    $conds[0]['yrLevel']  = " = '$yrLevel' ";
        
    $blocksection = new BlockSection();
    $result  = $blocksection->retrieveAllBlockSections($conds);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;
    
} else if ( strtoupper($action)=='GETSECTIONSPRESCHOOL' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    require_once('../Schedules/BlockSectionPreschool.php');
    require_once('../Schedules/BlockSectionSubjectPreschool.php');
    
    // get parameters
    $idno     = $_GET['idno'];
    $schYear  = $_GET['schYear'];
    $yrLevel  = $_GET['yrLevel'];

    unset($conds);
    $conds[0]['schYear']  = " = '$schYear' AND ";
    $conds[0]['yrLevel']  = " = '$yrLevel' AND ";
    $conds[0]['rstatus']  = "= 1 "; // open schedule
        
    $blocksection = new BlockSection();
    $result  = $blocksection->retrieveAllBlockSections($conds);
    
    $control = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                		<td scope="col" class="listViewThS1" width="40%" nowrap>Section</td>
                		<td scope="col" class="listViewThS1" width="20%" nowrap>Grade</td>
                		<td scope="col" class="listViewThS1" width="40%" nowrap>No. Enrolled</td>
                	</tr>
                	<!-- Start of subject Listing -->';
    if ($result) {
        $ctr=0;
        foreach ($result as $row) {
            $control .= "
                	<tr onmouseover=\"setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');\" onmouseout=\"setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');\" onmousedown=\"setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');\" height=\"20\">";
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top"><a href="javascript: setBlockSection(\''.$row['secID'].'\',\''.$row['secName'].'\');" class="listViewTdLinkS1">'.$row['secName'].'</a></td>';
                		
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top">'.$row['yrLevel'].'</td>';
                        
                        $control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top">'.$row['noEnrolled'].'</td>';
                		
                        
    	   $control .= '</tr>
                	<tr>
                		<td colspan="20" class="listViewHRS1"></td>
                	</tr>';
    	
    	   $ctr++;
        }
    }
    $control .= '   <!-- End of subject Listing -->
                    </tbody>
                </table>';
    
    echo $control;

} else if ( strtoupper($action)=='GETSECTIONSPRESCHOOL2' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    require_once('../Schedules/BlockSectionPreschool.php');
    require_once('../Schedules/BlockSectionSubjectPreschool.php');
    
    // get parameters
    $schYear  = $_GET['schYear'];
    $yrLevel  = $_GET['yrLevel'];

    unset($conds);
    $conds[0]['schYear']  = " = '$schYear' AND ";
    $conds[0]['yrLevel']  = " = '$yrLevel' ";
        
    $blocksection = new BlockSection();
    $result  = $blocksection->retrieveAllBlockSections($conds);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    
    echo $res;
    
} else if ( strtoupper($action)=='CHECKPREREQUISITES' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Config/ConfigCol.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/Subject.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/Schedule.php');
    require_once('../Students/StudentCol.php');
    require_once('../Grades/TOR.php');
    
    // get parameters
    $idno      = $_GET['idno'];
    $schedCode = $_GET['schedCode'];
    $schYear   = $_GET['schYear'];
    $semCode   = $_GET['semCode'];
    $sched = new Schedule();
    $prerequisite = new Prerequisite();
    
    unset($conds);
    $conds[0]['schedCode']="= '$schedCode' AND ";
    $conds[0]['schYear']="= '$schYear' AND ";
    $conds[0]['semCode']="= '$semCode' ";
    
    $result = $sched->retrieveAllSchedules($conds,"","",0,1);
    if (count($result)>0) {
        echo $prerequisite->checkPrerequisites($result[0]['subjID'],$idno);
    } else {
        echo 0;
    }       
    
    
} else {
    echo 0;
}


/**
 * This will check if the newly added schedule is already exist
 *
 * @param unknown_type $schedID
 * @return unknown
 */
function isDuplicate($schedID) 
{
    $found = 0;
    if ($_SESSION['SCHEDULES']) {
        $ctr = 0;
        foreach ($_SESSION['SCHEDULES'] as $row) {
            if ($row['schedID'] == $schedID) {
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
 * This will check if the newly added schedule is already exist
 *
 * @param unknown_type $schedID
 * @return unknown
 */
function isDuplicateSubject($subjID) 
{
    $found = 0;
    if ($_SESSION['SCHEDULES']) {
        $ctr = 0;
        foreach ($_SESSION['SCHEDULES'] as $row) {
            if ($row['subjID'] == $subjID) {
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
 * This will check if the subject is from original list of subject(edit enrollment)
 * if exist in original list it allows if the schedule is already closed
 * because its already counted.
 *
 * @param unknown_type $schedID
 * @return unknown
 */
function isInOriginal($schedID) 
{
    $found = 0;
    if ($_SESSION['ORIGINAL_SCHEDULES']) {
        $ctr = 0;
        foreach ($_SESSION['ORIGINAL_SCHEDULES'] as $row) {
            if ($row['schedID'] == $schedID) {
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
 * This will display the schedule table of the section (College Level)
 *
 * @return unknown
 */
function displaySchedules()
{
    $display  = '
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr height="20">
    		<td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
    		<td scope="col" class="listViewThS1" width="15%" nowrap>Code</td>
    		<td scope="col" class="listViewThS1" width="10%" nowrap>Course</td>
    		<td scope="col" class="listViewThS1" width="20%" nowrap>Subject</td>
    		<td scope="col" class="listViewThS1" width="20%" nowrap>Time</td>
    		<td scope="col" class="listViewThS1" width="10%" nowrap>Days</td>
    		<td scope="col" class="listViewThS1" width="10%" nowrap>Room</td>
    		<td scope="col" class="listViewThS1" width="10%" nowrap>Units</td>
    	</tr>
    ';
    
    if ($_SESSION['SCHEDULES']) {
        $total_units = 0;
        foreach ($_SESSION['SCHEDULES'] as $data) {
            $total_units += $data['units'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSchedule(\''.$data['schedID'].'\');" /></td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['schedCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['courseCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['subjCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['time_display'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['days_display'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['room'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['units'].'&nbsp;</td>';
    		
        	$display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        }
        
        $display .= '<tr height="20">
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp; <input type="hidden" name="temptotalunits" id="temptotalunits" value="'.$total_units.'"> </td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total</b></td>
                		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>'.number_format($total_units,1,".",",").'</b></td>
                	</tr>';
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}

/**
 * This will display the schedule table of the section (HS/Elem Level)
 *
 * @return unknown
 */
function displaySchedules_HS_Elem()
{
    $display  = '
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr height="20">
		<td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Code</td>
		<td scope="col" class="listViewThS1" width="30%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Time</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Days</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Room</td>
	</tr>
    ';
    
    if ($_SESSION['SCHEDULES']) {
        $total_units = 0;
        foreach ($_SESSION['SCHEDULES'] as $data) {
            $total_units += $data['units'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSchedule(\''.$data['schedID'].'\');" /></td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['schedCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['subjCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['time_display'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['days_display'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['room'].'&nbsp;</td>';
            
//            $display  .= '    <td scope="row" ';
//            if ($ctr%2==0) {
//                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
//            } else {
//                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
//            }
//            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['units'].'&nbsp;</td>';
    		
        	$display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        }
//        $display .= '<tr height="20">
//                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
//                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
//                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
//                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
//                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
//                		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total</b></td>
//                		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>'.number_format($total_units,1,".",",").'</b></td>
//                	</tr>';
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}



/**
 * This will display the schedule table of the section (College Level)
 *
 * @return unknown
 */
function displaySubjects()
{
    $display  = '
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr height="20">
    		<td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
    		<td scope="col" class="listViewThS1" width="10%" nowrap>Course</td>
    		<td scope="col" class="listViewThS1" width="50%" nowrap>Subject</td>
    		<td scope="col" class="listViewThS1" width="15%" nowrap>Units</td>
    		<td scope="col" class="listViewThS1" width="20%" nowrap>Grade</td>
    	</tr>
    ';
    
    if ($_SESSION['SCHEDULES']) {
        $total_units = 0;
        foreach ($_SESSION['SCHEDULES'] as $data) {
            $total_units += $data['units'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removePayment(\''.$data['subjID'].'\');" /></td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['courseCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['subjCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['units'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['fgrade'].'&nbsp;</td>';
    		
        	$display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        }
        $display .= '<tr height="20">
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total</b></td>
                		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>'.number_format($total_units,1,".",",").'</b></td>
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
                	</tr>';
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}




?>
