<?php
if (!$_SESSION){
    session_start();
}

// ajax action
$action = $_GET['action'];

if ( strtoupper($action)=='GENERATEENROLLMENTSTATUS' ) {
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
	require_once('../Enrollments/EnrollmentDetailCol.php');
	require_once('../Enrollments/EnrollmentCol.php');
    
    // get parameters
    $schYear = $_GET['schYear'];
    $semCode = $_GET['semCode'];
    
   	$course = new Course();
	
	$course_list = $course->retrieveAllCourses($conds,'');
	
	$enroll = new Enrollment();
	$report = array();
	foreach ($course_list as $key=>$value) {
		$report[$value['courseCode']]=array();
		
		$report[$value['courseCode']]['deptCode']=$value['deptCode'];
	    $courseID = $report[$value['courseCode']]['courseID']=$value['courseID'];
	    $report[$value['courseCode']]['courseCode']=$value['courseCode'];
	    $ctr=1;
	    while ($ctr<=5) {
	    // SELECT sum( idno ) AS total_enrollees FROM enrollments WHERE schYear = '2008-2009' AND semCode = '1' AND yrLevel = '1' AND rstatus >1
	    $tables[] = 'enrollments';

	    $fields[' sum( idno ) AS total_enrollees ']	= "";
	    
	    $where[0]['schYear'] 	= "='$schYear' AND ";
	    $where[0]['semCode']    = "='$semCode' AND ";
	    $where[0]['courseID']   = "='$courseID' AND ";
	    $where[0]['yrLevel']    = "='$ctr' AND ";
	    $where[0]['rstatus']    = " > '1'";
	    
	    $enroll->tables = $tables;
	    $enroll->fields = $fields;
	    $enroll->conds  = $where;
	    $enroll->order  = $orderby;
	    $enroll->multi_orders = $multi_orders;
	            
	    // building an select query
	    $query = $enroll->Select();  // generate delete sql query
	    $enroll->reset();            // reset all variables in query generator
	    
		try {
		    $enroll->db->beginTransaction();
	    	$result   = $enroll->db->query($query);
			$records  = $result->fetchAll(PDO::FETCH_BOTH);
			$enroll->db->commit();
		} catch (PDOException $e) {
		    echo "SQL query error.";
		}
		if(trim($records[0]['total_enrollees']) != '' || $records[0]['total_enrollees'] != NULL){
        	$report[$value['courseCode']][$ctr]=$records[0]['total_enrollees'];
		} else {
			$report[$value['courseCode']][$ctr]= 0;
			$records[0]['total_enrollees'] = 0;
		}
		
        $report[$value['courseCode']]['total'] += $records[0]['total_enrollees'];
        //$report[$value['courseCode']]['total'] += $report[$value['courseCode']][$records[0]['total_enrollees']];
        
        unset($tables);
        
        $ctr++;
	    }
		
	}
	echo displayEnrollmentStatus($report);
	
} else {
    
    echo 0;
}


/**
 * This will display the schedule table of the section (Elem Level)
 *
 * @return unknown
 */
function displayEnrollmentStatus($enrollments)
{
    $display  = '
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
		<tr height="20">
		    <td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
			<td scope="col" class="listViewThS1" nowrap>Department </td>
			<td scope="col" class="listViewThS1" nowrap>Course </td>
			<td scope="col" class="listViewThS1" nowrap>1 </td>
			<td scope="col" class="listViewThS1" nowrap>2 </td>
			<td scope="col" class="listViewThS1" nowrap>3 </td>
			<td scope="col" class="listViewThS1" nowrap>4 </td>
			<td scope="col" class="listViewThS1" nowrap>5 </td>
			<td scope="col" class="listViewThS1" nowrap>Total </td>
		</tr>
    ';
    
    if ($enrollments) {
        $ctr = 1;
        foreach ($enrollments as $data) {
            //$total_units += $data['units'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    
    	   $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top"  >&nbsp; </td>';
    	   
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" >'.$data['deptCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" >'.$data['courseCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" >'.$data['1'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" >'.$data['2'].'&nbsp;</td>';

            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" >'.$data['3'].'&nbsp;</td>';

            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" >'.$data['4'].'&nbsp;</td>';

            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" >'.$data['5'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" >'.$data['total'].'&nbsp;</td>';
            
            $display  .= '</tr>';
        	$display  .= '<tr >';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        	
        	$ctr ++;
        }
    }
    
    $display .= '</tbody></table>';
    
    return $display;
}


?>
