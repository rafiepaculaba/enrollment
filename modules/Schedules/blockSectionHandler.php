<?php
if (!$_SESSION){
    session_start();
}

// ajax action
$action = $_GET['action'];

if ( strtoupper($action)=='GETSCHEDULES' ) {
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
    $courseID = $_GET['courseID'];
    $schYear  = $_GET['schYear'];
    $semCode  = $_GET['semCode'];
    $yrLevel  = $_GET['yrLevel'];

    if ($courseID) {
        $where[0]['schedules.courseID'] = "='$courseID' AND ";
    } 
    
    if ($schYear) {
        $where[0]['schedules.schYear'] = "='$schYear' AND ";
    } 
    
    if ($semCode) {
        $where[0]['schedules.semCode'] = "='$semCode' AND ";
    } 
    
    if ($yrLevel) {
        $where[0]['schedules.yrLevel'] = "='$yrLevel' AND ";
    } 
    
    $where[0]['schedules.rstatus'] = "='1'";
        
    $schedule = new Schedule();
    $result  = $schedule->retrieveAllSchedulesSubjectCourseAssociated($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

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
        $schedule = new Schedule($schedID);
        $subj = new Subject($schedule->subjID);
    
        $data['schedID']       = $schedule->schedID;
        $data['schedCode']     = $schedule->schedCode;
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
    
        echo displaySchedules();
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
    
} else if ( strtoupper($action)=='GETSCHEDULESHS' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $yrLevel = $_GET['yrLevel'];
    
    if ($schYear) {
        $where[0]['schedules.schYear'] = "='$schYear' AND ";
    } 
    
    if ($yrLevel) {
        $where[0]['schedules.yrLevel'] = "='$yrLevel' AND ";
    } 

    $where[0]['schedules.rstatus'] = "='1'";
        
    $schedule = new Schedule();
    //$result  = $schedule->retrieveAllSchedules($where);
    $result  = $schedule->retrieveAllSchedulesSubjectAssociated($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
    
} else if ( strtoupper($action)=='GETSCHEDULESELEM' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $yrLevel = $_GET['yrLevel'];
    
    if ($schYear) {
        $where[0]['schedules.schYear'] = "='$schYear' AND ";
    } 
    
    if ($yrLevel) {
        $where[0]['schedules.yrLevel'] = "='$yrLevel' AND ";
    } 

    $where[0]['schedules.rstatus'] = "='1'";
        
    $schedule = new Schedule();
    //$result  = $schedule->retrieveAllSchedules($where);
    $result  = $schedule->retrieveAllSchedulesSubjectAssociated($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( strtoupper($action)=='GETSCHEDULESPRESCHOOL' ) {
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $yrLevel = $_GET['yrLevel'];
    
    if ($schYear) {
        $where[0]['schedules.schYear'] = "='$schYear' AND ";
    } 
    
    if ($yrLevel) {
        $where[0]['schedules.yrLevel'] = "='$yrLevel' AND ";
    } 

    $where[0]['schedules.rstatus'] = "='1'";
        
    $schedule = new Schedule();
    //$result  = $schedule->retrieveAllSchedules($where);
    $result  = $schedule->retrieveAllSchedulesSubjectAssociated($where);
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;

} else if ( strtoupper($action)=='ADDSCHEDULEHS' ) {
    
    require_once('../../commonAjax.php');
//    require_once('../Departments/Department.php');
//    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
//    require_once('../Curriculums/Prerequisite.php');
//    require_once('../Curriculums/CurriculumSubject.php');
//    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/ScheduleHS.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    // check for duplicates 
    if ( !isDuplicate($schedID) ) {
        $schedule = new Schedule($schedID);
        $subj = new Subject($schedule->subjID);
    
        $data['schedID']       = $schedule->schedID;
        $data['schedCode']     = $schedule->schedCode;
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
    
        echo displaySchedules();
    }
} else if ( strtoupper($action)=='ADDSCHEDULEELEM' ) {
    
    require_once('../../commonAjax.php');
//    require_once('../Departments/Department.php');
//    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
//    require_once('../Curriculums/Prerequisite.php');
//    require_once('../Curriculums/CurriculumSubject.php');
//    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/ScheduleElem.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    // check for duplicates 
    if ( !isDuplicate($schedID) ) {
        $schedule = new Schedule($schedID);
        $subj = new Subject($schedule->subjID);
    
        $data['schedID']       = $schedule->schedID;
        $data['schedCode']     = $schedule->schedCode;
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
    
        echo displaySchedules();
    }
} else if ( strtoupper($action)=='ADDSCHEDULEPRESCHOOL' ) {
    
    require_once('../../commonAjax.php');
//    require_once('../Departments/Department.php');
//    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
//    require_once('../Curriculums/Prerequisite.php');
//    require_once('../Curriculums/CurriculumSubject.php');
//    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/SchedulePreschool.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    // check for duplicates 
    if ( !isDuplicate($schedID) ) {
        $schedule = new Schedule($schedID);
        $subj = new Subject($schedule->subjID);
    
        $data['schedID']       = $schedule->schedID;
        $data['schedCode']     = $schedule->schedCode;
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
    
        echo displaySchedules();
    }
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
} else if ( strtoupper($action)=='CHECKDUPLICATE' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    require_once('../Curriculums/Curriculum.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Schedules/BlockSectionSubjectHS.php');
    require_once('../Schedules/BlockSectionHS.php');
    
    // get parameters
    $schedID = $_GET['schedID'];
    
    echo isDuplicate($schedID);
} else if ( strtoupper($action)=='CHECKDUPLICATESECTION' ) {
    
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
    $schYear = $_GET['schYear'];
    $semCode = $_GET['semCode'];
    $yrLevel = $_GET['yrLevel'];
    $secName = $_GET['secName'];
    
    $blocksection = new BlockSection();
    
    $where[0]['schYear'] = "='$schYear' AND  ";
    $where[0]['semCode'] = "='$semCode' AND  ";
    $where[0]['yrLevel'] = "='$yrLevel' AND  ";
    $where[0]['secName'] = "='$secName' ";
    
    $result = $blocksection->retrieveAllBlockSections($where);
    
    $duplicate = 0;
    if ($result) {
        foreach ($result as $record) {
            $duplicate = 1;
            break;
        }
    }
    
    if ($duplicate) {
        echo 1;
    } else {
        echo 0;
    }
} else if ( strtoupper($action)=='CHECKDUPLICATESECTIONHS' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Schedules/BlockSectionSubjectHS.php');
    require_once('../Schedules/BlockSectionHS.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $yrLevel = $_GET['yrLevel'];
    $secName = $_GET['secName'];
    
    $blocksection = new BlockSection();
    
    $where[0]['schYear'] = "='$schYear' AND  ";
    $where[0]['yrLevel'] = "='$yrLevel' AND  ";
    $where[0]['secName'] = "='$secName' ";
    
    $result = $blocksection->retrieveAllBlockSections($where);
    
    $duplicate = 0;
    if ($result) {
        foreach ($result as $record) {
            $duplicate = 1;
            break;
        }
    }
    
    if ($duplicate) {
        echo 1;
    } else {
        echo 0;
    }
} else if ( strtoupper($action)=='CHECKDUPLICATESECTIONELEM' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    require_once('../Schedules/BlockSectionSubjectElem.php');
    require_once('../Schedules/BlockSectionElem.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $yrLevel = $_GET['yrLevel'];
    $secName = $_GET['secName'];
    
    $blocksection = new BlockSection();
    
    $where[0]['schYear'] = "='$schYear' AND  ";
    $where[0]['yrLevel'] = "='$yrLevel' AND  ";
    $where[0]['secName'] = "='$secName' ";
    
    $result = $blocksection->retrieveAllBlockSections($where);
    
    $duplicate = 0;
    if ($result) {
        foreach ($result as $record) {
            $duplicate = 1;
            break;
        }
    }
    
    if ($duplicate) {
        echo 1;
    } else {
        echo 0;
    }   
} else if ( strtoupper($action)=='CHECKDUPLICATESECTIONPRESCHOOL' ) {
    
    require_once('../../commonAjax.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    require_once('../Schedules/BlockSectionSubjectPreschool.php');
    require_once('../Schedules/BlockSectionPreschool.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $yrLevel = $_GET['yrLevel'];
    $secName = $_GET['secName'];
    
    $blocksection = new BlockSection();
    
    $where[0]['schYear'] = "='$schYear' AND  ";
    $where[0]['yrLevel'] = "='$yrLevel' AND  ";
    $where[0]['secName'] = "='$secName' ";
    
    $result = $blocksection->retrieveAllBlockSections($where);
    
    $duplicate = 0;
    if ($result) {
        foreach ($result as $record) {
            $duplicate = 1;
            break;
        }
    }
    
    if ($duplicate) {
        echo 1;
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
    		<td scope="col" class="listViewThS1" width="20%" nowrap>Subject</td>
    		<td scope="col" class="listViewThS1" width="20%" nowrap>Time</td>
    		<td scope="col" class="listViewThS1" width="15%" nowrap>Days</td>
    		<td scope="col" class="listViewThS1" width="15%" nowrap>Room</td>
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

?>
