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
    $result   = $schedule->retrieveAllSchedules($where);
    
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
                $data[0]['days']  .= "T";
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

    if ($idno) {
        $where[0]['schedID'] = "='$schedID' ";
    } 
    
    $gs = new GradeSheet();
    
    $tables['enrollments']        = '';
    $tables['enrollment_details'] = '';
    $tables['students']           = '';
    
    $gs->tables = $tables;
            
    
    if (!empty($result)) {
        $j = new Services_JSON;
        $res = $j->encode($result);
    } else {
        $res = 0;
    }
    echo $res;

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
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
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
		<td scope="col" class="listViewThS1" width="15%" nowrap>Code</td>
		<td scope="col" class="listViewThS1" width="30%" nowrap>Subject</td>
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
