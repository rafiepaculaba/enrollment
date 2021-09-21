<?php
if (!$_SESSION){
    session_start();
}

// ajax action
$action = $_GET['action'];

if ( strtoupper($action)=='GETSCHEDULESCOL' ) {
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
    $profID  = $_GET['profID'];
    
    
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' ";
        
        if ($semCode) {
            $where[0][' AND semCode'] = "='$semCode' ";
        } 
        
        if ($profID) {
            $where[0][' AND profID'] = "='$profID' ";
        } 
    } else {
        if ($semCode) {
            $where[0]['semCode'] = "='$semCode' ";
            
            if ($profID) {
                $where[0][' AND profID'] = "='$profID' ";
            } 
        } else {
            $where[0]['profID'] = "='$profID' ";
        }
    }

    $schedule = new Schedule();
    $result   = $schedule->retrieveAllSchedules($where);
    
    $j = new Services_JSON;
    
    if (count($result)) {
        $res = $j->encode($result);    
    } else {
        $res = 0;
    }
    echo $res;
    
} else if ( strtoupper($action)=='GETSCHEDULESHS' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $profID  = $_GET['profID'];
    
    
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' ";
        
        if ($profID) {
            $where[0][' AND profID'] = "='$profID' ";
        } 
    } else {
        if ($profID) {
            $where[0]['profID'] = "='$profID' ";
        } 
    }

    $schedule = new Schedule();
    $result   = $schedule->retrieveAllSchedules($where);
    
    $j = new Services_JSON;
    
    if (count($result)) {
        $res = $j->encode($result);    
    } else {
        $res = 0;
    }
    echo $res;
    
} else if ( strtoupper($action)=='GETSCHEDULESELEM' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $profID  = $_GET['profID'];
    
    
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' ";
        
        if ($profID) {
            $where[0][' AND profID'] = "='$profID' ";
        } 
    } else {
        if ($profID) {
            $where[0]['profID'] = "='$profID' ";
        } 
    }

    $schedule = new Schedule();
    $result   = $schedule->retrieveAllSchedules($where);
    
    $j = new Services_JSON;
    
    if (count($result)) {
        $res = $j->encode($result);    
    } else {
        $res = 0;
    }
    echo $res;
    
} else if ( strtoupper($action)=='GETSCHEDULESPRESCHOOL' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $profID  = $_GET['profID'];
    
    
    if ($schYear) {
        $where[0]['schYear'] = "='$schYear' ";
        
        if ($profID) {
            $where[0][' AND profID'] = "='$profID' ";
        } 
    } else {
        if ($profID) {
            $where[0]['profID'] = "='$profID' ";
        } 
    }

    $schedule = new Schedule();
    $result   = $schedule->retrieveAllSchedules($where);
    
    $j = new Services_JSON;
    
    if (count($result)) {
        $res = $j->encode($result);    
    } else {
        $res = 0;
    }
    echo $res;
    
} else if ( strtoupper($action)=='CHECKDUPLICATE' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/Schedule.php');
    require_once('../Grades/Gradesheet.php');
    
    // get parameters
    $profID   = $_GET['profID'];
    $schedID  = $_GET['schedID'];
    $schYear  = $_GET['schYear'];
    $semCode  = $_GET['semCode'];
    
    $gs = new GradeSheet();
    
    echo $gs->isExist($schYear, $semCode ,$schedID, $profID);

} else if ( strtoupper($action)=='CHECKDUPLICATEHS' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    require_once('../Grades/GradesheetHS.php');
    
    // get parameters
    $profID   = $_GET['profID'];
    $schedID  = $_GET['schedID'];
    $schYear  = $_GET['schYear'];
    
    $gs = new GradeSheet();
    
    echo $gs->isExist($schYear, $schedID, $profID);
    
} else if ( strtoupper($action)=='CHECKDUPLICATEELEM' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    require_once('../Grades/GradesheetElem.php');
    
    // get parameters
    $profID   = $_GET['profID'];
    $schedID  = $_GET['schedID'];
    $schYear  = $_GET['schYear'];
    
    $gs = new GradeSheet();
    
    echo $gs->isExist($schYear, $schedID, $profID);
    
} else if ( strtoupper($action)=='CHECKDUPLICATEPRESCHOOL' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    require_once('../Grades/GradesheetPreschool.php');
    
    // get parameters
    $profID   = $_GET['profID'];
    $schedID  = $_GET['schedID'];
    $schYear  = $_GET['schYear'];
    
    $gs = new GradeSheet();
    
    echo $gs->isExist($schYear, $schedID, $profID);
    
} else if ( strtoupper($action)=='GETSUBJECT' ) {
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
    
    $where[0]['schedID'] = "='$schedID' ";

    $schedule = new Schedule();
    $result   = $schedule->retrieveAllSchedulesSubjectCourseAssociated($where);
    
    if ($result) {
        
        // format time
        $data[0] = $result[0];
        $data[0]['time'] = date("g:i",strtotime($result[0]['startTime']))."-".date("g:i A",strtotime($result[0]['endTime']));
//        $data[0]['room'] = $result[0]['room'];
        
        $subj = new Subject($data[0]['subjID']);
        
        $data[0]['units'] = $subj->units;
        $data[0]['desc']  = $subj->descTitle;
        
        // days formation
        if ($result[0]['onMon']) {
            $data[0]['days']  .= "M";    
        }
        
        if ($result[0]['onTue']) {
            if ($result[0]['onThu']) {
                $data[0]['days']  .= "T";
            } else {
                $data[0]['days']  .= "Tue";
            }
        }
        
        if ($result[0]['onWed']) {
            $data[0]['days']  .= "W";
        }
        
        if ($result[0]['onThu']) {
            if ($result[0]['onTue']) {
                $data[0]['days']  .= "Th";
            } else {
                $data[0]['days']  .= "Thu";
            }
        }
        
        if ($result[0]['onFri']) {
            $data[0]['days']  .= "F";
        }
        
        if ($result[0]['onSat']) {
            $data[0]['days']  .= "Sat";
        }
        
        if ($result[0]['onSun']) {
            $data[0]['days']  .= "Sun";
        }
          
    }
    
    
    $j = new Services_JSON;
    $res = $j->encode($data);
    echo $res;
    
} else if ( strtoupper($action)=='GETSUBJECTHS' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleHS.php');
    
    // get parameters
    $schedID  = $_GET['schedID'];
    
    $where[0]['schedID'] = "='$schedID' ";

    $schedule = new Schedule();
    $result   = $schedule->retrieveAllSchedulesSubjectAssociated($where);
    
    if ($result) {
        
        // format time
        $data[0] = $result[0];
        $data[0]['time'] = date("g:i",strtotime($result[0]['startTime']))."-".date("g:i A",strtotime($result[0]['endTime']));
//        $data[0]['room'] = $result[0]['room'];
        
        $subj = new Subject($data[0]['subjID']);
        $data[0]['units'] = $subj->units;
        $data[0]['desc']  = $subj->descTitle;
        
        // days formation
        if ($result[0]['onMon']) {
            $data[0]['days']  .= "M";    
        }
        
        if ($result[0]['onTue']) {
            if ($result[0]['onThu']) {
                $data[0]['days']  .= "T";
            } else {
                $data[0]['days']  .= "Tue";
            }
        }
        
        if ($result[0]['onWed']) {
            $data[0]['days']  .= "W";
        }
        
        if ($result[0]['onThu']) {
            if ($result[0]['onTue']) {
                $data[0]['days']  .= "Th";
            } else {
                $data[0]['days']  .= "Thu";
            }
        }
        
        if ($result[0]['onFri']) {
            $data[0]['days']  .= "F";
        }
        
        if ($result[0]['onSat']) {
            $data[0]['days']  .= "Sat";
        }
        
        if ($result[0]['onSun']) {
            $data[0]['days']  .= "Sun";
        }
          
    }
    
    
    $j = new Services_JSON;
    $res = $j->encode($data);
    echo $res;    

} else if ( strtoupper($action)=='GETSUBJECTELEM' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/ScheduleElem.php');
    
    // get parameters
    $schedID  = $_GET['schedID'];
    
    $where[0]['schedID'] = "='$schedID' ";

    $schedule = new Schedule();
    $result   = $schedule->retrieveAllSchedulesSubjectAssociated($where);
    
    if ($result) {
        
        // format time
        $data[0] = $result[0];
        $data[0]['time'] = date("g:i",strtotime($result[0]['startTime']))."-".date("g:i A",strtotime($result[0]['endTime']));
        
        $subj = new Subject($data[0]['subjID']);
        $data[0]['units'] = $subj->units;
        $data[0]['desc']  = $subj->descTitle;
        
        // days formation
        if ($result[0]['onMon']) {
            $data[0]['days']  .= "M";    
        }
        
        if ($result[0]['onTue']) {
            if ($result[0]['onThu']) {
                $data[0]['days']  .= "T";
            } else {
                $data[0]['days']  .= "Tue";
            }
        }
        
        if ($result[0]['onWed']) {
            $data[0]['days']  .= "W";
        }
        
        if ($result[0]['onThu']) {
            if ($result[0]['onTue']) {
                $data[0]['days']  .= "Th";
            } else {
                $data[0]['days']  .= "Thu";
            }
        }
        
        if ($result[0]['onFri']) {
            $data[0]['days']  .= "F";
        }
        
        if ($result[0]['onSat']) {
            $data[0]['days']  .= "Sat";
        }
        
        if ($result[0]['onSun']) {
            $data[0]['days']  .= "Sun";
        }
          
    }
    
    
    $j = new Services_JSON;
    $res = $j->encode($data);
    echo $res;  

} else if ( strtoupper($action)=='GETSUBJECTPRESCHOOL' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Schedules/SchedulePreschool.php');
    
    // get parameters
    $schedID  = $_GET['schedID'];
    
    $where[0]['schedID'] = "='$schedID' ";

    $schedule = new Schedule();
    $result   = $schedule->retrieveAllSchedulesSubjectAssociated($where);
    
    if ($result) {
        
        // format time
        $data[0] = $result[0];
        $data[0]['time'] = date("g:i",strtotime($result[0]['startTime']))."-".date("g:i A",strtotime($result[0]['endTime']));
        
        $subj = new Subject($data[0]['subjID']);
        $data[0]['units'] = $subj->units;
        $data[0]['desc']  = $subj->descTitle;
        
        // days formation
        if ($result[0]['onMon']) {
            $data[0]['days']  .= "M";    
        }
        
        if ($result[0]['onTue']) {
            if ($result[0]['onThu']) {
                $data[0]['days']  .= "T";
            } else {
                $data[0]['days']  .= "Tue";
            }
        }
        
        if ($result[0]['onWed']) {
            $data[0]['days']  .= "W";
        }
        
        if ($result[0]['onThu']) {
            if ($result[0]['onTue']) {
                $data[0]['days']  .= "Th";
            } else {
                $data[0]['days']  .= "Thu";
            }
        }
        
        if ($result[0]['onFri']) {
            $data[0]['days']  .= "F";
        }
        
        if ($result[0]['onSat']) {
            $data[0]['days']  .= "Sat";
        }
        
        if ($result[0]['onSun']) {
            $data[0]['days']  .= "Sun";
        }
          
    }
    
    
    $j = new Services_JSON;
    $res = $j->encode($data);
    echo $res;  

} else if ( strtoupper($action)=='CHECKDUPLICATECOL' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Students/StudentCol.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Grades/Gradesheet.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $semCode = $_GET['semCode'];
    $profID  = $_GET['profID'];
    $schedID = $_GET['schedID'];

    if ($idno) {
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
} else if ( strtoupper($action)=='GETCLASSROSTER' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Students/StudentCol.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Grades/Gradesheet.php');
    
    // get parameters
    $schedID = $_GET['schedID'];

    $gs = new GradeSheet();
    
    $tables[] = 'enrollments';
    $tables[] = 'enrollment_details';
    $tables[] = 'students';
    $tables[] = 'courses';
    
    $multi_orders['students.lname'] = "ASC";
    $multi_orders['students.fname'] = "ASC";
    
    $fields['students.*']                = "";
    $fields['enrollment_details.mgrade'] = "";
    $fields['enrollment_details.fgrade'] = "";
    $fields['courses.courseCode']        = "";
    
    $where[0]['enrollment_details.schedID'] = "='$schedID' AND ";
    $where[0]['enrollment_details.enID']    = "=enrollments.enID AND ";
    $where[0]['students.courseID']          = "=courses.courseID AND ";
    $where[0]['enrollments.idno']           = "=students.idno AND ";
    $where[0]['enrollments.rstatus']        = "=2";
    
    $gs->tables = $tables;
    $gs->fields = $fields;
    $gs->conds  = $where;
    $gs->order  = $orderby;
    $gs->multi_orders = $multi_orders;
            
    // building an select query
    $query = $gs->Select();  // generate delete sql query
    $gs->reset();            // reset all variables in query generator
    
	try {
	    $gs->db->beginTransaction();
    	$result   = $gs->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$gs->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error.";
	}
	
    echo displayStudents($records);

} else if ( strtoupper($action)=='GETCLASSROSTERHS' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentHS.php');
    require_once('../Subjects/SubjectHS.php');
    require_once('../Users/User2.php');
    require_once('../Grades/GradesheetHS.php');
    
    // get parameters
    $schedID = $_GET['schedID'];

    $gs = new GradeSheet();
    
    $tables[] = 'enrollments';
    $tables[] = 'enrollment_details';
    $tables[] = 'students';
    
    $multi_orders['students.lname'] = "ASC";
    $multi_orders['students.fname'] = "ASC";
    
    $fields['students.*']                       = "";
    $fields['enrollment_details.firstgrade']    = "";
    $fields['enrollment_details.secondgrade']   = "";
    $fields['enrollment_details.thirdgrade']    = "";
    $fields['enrollment_details.fourthgrade']   = "";
    $fields['enrollment_details.fgrade']        = "";
    
    $where[0]['enrollment_details.schedID'] = "='$schedID' AND ";
    $where[0]['enrollment_details.enID']    = "=enrollments.enID AND ";
    $where[0]['enrollments.idno']           = "=students.idno AND ";
    $where[0]['enrollments.rstatus']        = "=2";
    
    $gs->tables = $tables;
    $gs->fields = $fields;
    $gs->conds  = $where;
    $gs->order  = $orderby;
    $gs->multi_orders = $multi_orders;
            
    // building an select query
    $query = $gs->Select();  // generate delete sql query
    $gs->reset();            // reset all variables in query generator
    
	try {
	    $gs->db->beginTransaction();
    	$result   = $gs->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$gs->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error.";
	}
	
    echo displaySchedules_HS($records);

} else if ( strtoupper($action)=='GETCLASSROSTERELEM' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentElem.php');
    require_once('../Subjects/SubjectElem.php');
    require_once('../Users/User2.php');
    require_once('../Grades/GradesheetElem.php');
    
    // get parameters
    $schedID = $_GET['schedID'];

    $gs = new GradeSheet();
    
    $tables[] = 'enrollments';
    $tables[] = 'enrollment_details';
    $tables[] = 'students';
    
    $multi_orders['students.lname'] = "ASC";
    $multi_orders['students.fname'] = "ASC";
    
    $fields['students.*']                       = "";
    $fields['enrollment_details.firstgrade']    = "";
    $fields['enrollment_details.secondgrade']   = "";
    $fields['enrollment_details.thirdgrade']    = "";
    $fields['enrollment_details.fourthgrade']   = "";
    $fields['enrollment_details.fgrade']        = "";
    
    $where[0]['enrollment_details.schedID'] = "='$schedID' AND ";
    $where[0]['enrollment_details.enID']    = "=enrollments.enID AND ";
    $where[0]['enrollments.idno']           = "=students.idno AND ";
    $where[0]['enrollments.rstatus']        = "=2"; // validated
    
    $gs->tables = $tables;
    $gs->fields = $fields;
    $gs->conds  = $where;
    $gs->order  = $orderby;
    $gs->multi_orders = $multi_orders;
            
    // building an select query
    $query = $gs->Select();  // generate delete sql query
    $gs->reset();            // reset all variables in query generator
    
	try {
	    $gs->db->beginTransaction();
    	$result   = $gs->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$gs->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error.";
	}
	
    echo displaySchedules_Elem($records);
    
} else if ( strtoupper($action)=='GETCLASSROSTERPRESCHOOL' ) {
    require_once('../../commonAjax.php');
    
    require_once('../Students/StudentPreschool.php');
    require_once('../Subjects/SubjectPreschool.php');
    require_once('../Users/User2.php');
    require_once('../Grades/GradesheetPreschool.php');
    
    // get parameters
    $schedID = $_GET['schedID'];

    $gs = new GradeSheet();
    
    $tables[] = 'enrollments';
    $tables[] = 'enrollment_details';
    $tables[] = 'students';
    
    $multi_orders['students.lname'] = "ASC";
    $multi_orders['students.fname'] = "ASC";
    
    $fields['students.*']                       = "";
    $fields['enrollment_details.firstgrade']    = "";
    $fields['enrollment_details.secondgrade']   = "";
    $fields['enrollment_details.thirdgrade']    = "";
    $fields['enrollment_details.fourthgrade']   = "";
    $fields['enrollment_details.fgrade']        = "";
    
    $where[0]['enrollment_details.schedID'] = "='$schedID' AND ";
    $where[0]['enrollment_details.enID']    = "=enrollments.enID AND ";
    $where[0]['enrollments.idno']           = "=students.idno AND ";
    $where[0]['enrollments.rstatus']        = "=2"; // validated
    
    $gs->tables = $tables;
    $gs->fields = $fields;
    $gs->conds  = $where;
    $gs->order  = $orderby;
    $gs->multi_orders = $multi_orders;
            
    // building an select query
    $query = $gs->Select();  // generate delete sql query
    $gs->reset();            // reset all variables in query generator
    
	try {
	    $gs->db->beginTransaction();
    	$result   = $gs->db->query($query);
		$records  = $result->fetchAll(PDO::FETCH_BOTH);
		$gs->db->commit();
	} catch (PDOException $e) {
	    echo "SQL query error.";
	}
	
    echo displaySchedules_Elem($records);
    
} else {
    echo 0;
}


/**
 * This will display the schedule table of the section (College Level)
 *
 * @return unknown
 */
function displayStudents($students)
{
    $display  = '
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr height="20">
    	    <td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
    	    <td scope="col" class="listViewThS1" width="5%" nowrap>Prelim</td>
    	    <td scope="col" class="listViewThS1" width="5%" nowrap>Midterm</td>
    	    <td scope="col" class="listViewThS1" width="5%" nowrap>Pre-Final</td>
    	    <td scope="col" class="listViewThS1" width="5%" nowrap>Final</td>
    		<td scope="col" class="listViewThS1" width="15%" nowrap>ID No.</td>
    		<td scope="col" class="listViewThS1" width="40%" nowrap>Student Name</td>
    		<td scope="col" class="listViewThS1" width="10%" nowrap>Course</td>
    		<td scope="col" class="listViewThS1" width="10%" nowrap>Year</td>
    	</tr>
    ';
    
    if ($students) {
        $ctr = 1;
        foreach ($students as $data) {
            $total_units += $data['units'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    
    	   $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="2%">'.$ctr.'.</td>';
    	   
    	    $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            
        	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="stud_pre'.$data['recID'].'" name="stud_pre'.$data['recID'].'" value="'.$data['pregrade'].'"  onkeypress="return keyRestrict(event, 16);" /></td>';

            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            
        	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="stud_mid'.$data['recID'].'" name="stud_mid'.$data['recID'].'" value="'.$data['mgrade'].'"  onkeypress="return keyRestrict(event, 16);" /></td>';

        	$display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            
        	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="stud_prefi'.$data['recID'].'" name="stud_prefi'.$data['recID'].'" value="'.$data['prefigrade'].'"  onkeypress="return keyRestrict(event, 16);" /></td>';
        	
        	$display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            
        	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="stud'.$data['recID'].'" name="stud'.$data['recID'].'" value="'.$data['fgrade'].'"  onkeypress="return keyRestrict(event, 16);" /></td>';
            
        	
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['idno'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['lname'].', '.$data['fname'].' '.$data['mname'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['courseCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['yrLevel'].'&nbsp;</td>';
            
        	$display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        	
        	$ctr ++;
        }
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}

/**
 * This will display the schedule table of the section (HS Level)
 *
 * @return unknown
 */
function displaySchedules_HS($students)
{
    $display  = '
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr height="20">
    	    <td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
    		<td scope="col" class="listViewThS1" nowrap>ID No.</td>
    		<td scope="col" class="listViewThS1" nowrap>Student Name</td>
    		<td scope="col" class="listViewThS1" nowrap>Year</td>
    		<td scope="col" class="listViewThS1" nowrap>1st</td>
    		<td scope="col" class="listViewThS1" nowrap>2nd</td>
    		<td scope="col" class="listViewThS1" nowrap>3rd</td>
    		<td scope="col" class="listViewThS1" nowrap>4th</td>
    		<td scope="col" class="listViewThS1" nowrap>Final</td>
    	</tr>
    ';
    
    if ($students) {
        $ctr = 1;
        foreach ($students as $data) {
            $total_units += $data['units'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    
    	   $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="2%">'.$ctr.'.</td>';
    	   
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['idno'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['lname'].', '.$data['fname'].' '.$data['mname'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['yrLevel'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            
            if ($data['firstgrade']>0) {
            	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studfirst'.$data['recID'].'" name="studfirst'.$data['recID'].'" value="'.$data['firstgrade'].'"  onkeypress="return keyRestrict(event, 2);" /></td>';
            } else {
            	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studfirst'.$data['recID'].'" name="studfirst'.$data['recID'].'" value=""  onkeypress="return keyRestrict(event, 2);" /></td>';
            }
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            
            if ($data['secondgrade']>0) {
            	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studsecond'.$data['recID'].'" name="studsecond'.$data['recID'].'" value="'.$data['secondgrade'].'"  onkeypress="return keyRestrict(event, 2);" /></td>';
            } else {
            	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studsecond'.$data['recID'].'" name="studsecond'.$data['recID'].'" value=""  onkeypress="return keyRestrict(event, 2);" /></td>';
            }
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            
            if ($data['thirdgrade']>0) {
            	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studthird'.$data['recID'].'" name="studthird'.$data['recID'].'" value="'.$data['thirdgrade'].'"  onkeypress="return keyRestrict(event, 2);" /></td>';
            } else {
            	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studthird'.$data['recID'].'" name="studthird'.$data['recID'].'" value=""  onkeypress="return keyRestrict(event, 2);" /></td>';
            }
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            
            if ($data['fourthgrade']>0) {
            	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studfourth'.$data['recID'].'" name="studfourth'.$data['recID'].'" value="'.$data['fourthgrade'].'"  onkeypress="return keyRestrict(event, 2);" /></td>';
            } else {
            	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studfourth'.$data['recID'].'" name="studfourth'.$data['recID'].'" value=""  onkeypress="return keyRestrict(event, 2);" /></td>';
            }
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            
            if ($data['fgrade']>0) {
            	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="stud'.$data['recID'].'" name="stud'.$data['recID'].'" value="'.$data['fgrade'].'"  onkeypress="return keyRestrict(event, 2);" /></td>';
            } else {
            	$display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="stud'.$data['recID'].'" name="stud'.$data['recID'].'" value=""  onkeypress="return keyRestrict(event, 2);" /></td>';
            }
            
        	$display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        	
        	$ctr ++;
        }
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}



/**
 * This will display the schedule table of the section (Elem Level)
 *
 * @return unknown
 */
function displaySchedules_Elem($students)
{
    $display  = '
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr height="20">
    	    <td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
    		<td scope="col" class="listViewThS1" nowrap>ID No.</td>
    		<td scope="col" class="listViewThS1" nowrap>Student Name</td>
    		<td scope="col" class="listViewThS1" nowrap>Grade</td>
    		<td scope="col" class="listViewThS1" nowrap>1<sup>st</sup></td>
    		<td scope="col" class="listViewThS1" nowrap>2<sup>nd</sup></td>
    		<td scope="col" class="listViewThS1" nowrap>3<sup>rd</sup></td>
    		<td scope="col" class="listViewThS1" nowrap>4<sup>th</sup></td>
    		<td scope="col" class="listViewThS1" nowrap>Final</td>
    	</tr>
    ';
    
    if ($students) {
        $ctr = 1;
        foreach ($students as $data) {
            $total_units += $data['units'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    
    	   $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="2%">'.$ctr.'.</td>';
            
    	   
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['idno'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['lname'].', '.$data['fname'].' '.$data['mname'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['yrLevel'].'&nbsp;</td>';
            
             $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studfirst'.$data['recID'].'" name="studfirst'.$data['recID'].'" value="'.$data['firstgrade'].'"  onkeypress="return keyRestrict(event, 2);" /></td>';
            
             $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studsecond'.$data['recID'].'" name="studsecond'.$data['recID'].'" value="'.$data['secondgrade'].'"  onkeypress="return keyRestrict(event, 2);" /></td>';
            
             $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studthird'.$data['recID'].'" name="studthird'.$data['recID'].'" value="'.$data['thirdgrade'].'"  onkeypress="return keyRestrict(event, 2);" /></td>';
            
             $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="studfourth'.$data['recID'].'" name="studfourth'.$data['recID'].'" value="'.$data['fourthgrade'].'"  onkeypress="return keyRestrict(event, 2);" /></td>';
            
             $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><input type="text" size="10" maxlength="4" id="stud'.$data['recID'].'" name="stud'.$data['recID'].'" value="'.$data['fgrade'].'"  onkeypress=  "return keyRestrict(event, 2);" /></td>';
            
            
        	$display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        	
        	$ctr ++;
        }
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}





?>
