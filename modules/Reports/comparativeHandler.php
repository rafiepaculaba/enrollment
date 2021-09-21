<?php
if (!$_SESSION){
    session_start();
}

// ajax action
$action = $_GET['action'];

if ( strtoupper($action)=='DISPLAYCOMPARATIVE' ) {
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
	require_once('../Payments/Payment.php');
	require_once('../Account/Account.php');
	require_once('../Administration/SchoolFeeCol.php');
	require_once('../Payments/RegistrationPayment.php');
    
    // get parameters
    $fromYear 	= $_GET['fromYear'];
    $toYear 	= $_GET['toYear'];

    $prevtoYear = $_GET['toYear'];
    
    echo displayDifferences($fromYear, $toYear, $prevtoYear);
    

}  else {
    echo 0;
}


/**
 * This will display the schedule table of the section (College Level)
 *
 * @return unknown
 */
function displayDifferences($fromYear, $toYear, $prevtoYear)
{
    $display  = '
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr height="20">
    	    <td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
    		<td scope="col" class="listViewThS1" width="20%" nowrap>School Year</td>
    		<td scope="col" class="listViewThS1" width="20%" nowrap>1st Sem</td>
    		<td scope="col" class="listViewThS1" width="20%" nowrap>2nd Sem</td>
    		<td scope="col" class="listViewThS1" width="20%" nowrap>Summer</td>
    		<td scope="col" class="listViewThS1" width="15%" nowrap>&nbsp;</td>
    	</tr>
    ';
//    if ($differences) {
        $ctr = 1;
        //foreach ($differences as $data) {
            $total_units += $data['units'];
    	   $display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
    	    
    	   $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="2%">&nbsp;</td>';
    	   

            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['schYear'].'&nbsp;</td>';
            
/*            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['lname'].', '.$data['fname'].' '.$data['mname'].'&nbsp;</td>';
*/            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['semCode'].'&nbsp;</td>';
            
            $display  .= '    <td scope="row" ';
            if ($ctr%2==0) {
                $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
            } else {
                $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
            }
            $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['rstatus'].'&nbsp;</td>';
            
        	$display  .= '</tr>';
        	$display  .= '<tr>';
        	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
        	$display  .= '</tr>';
        	
        	$ctr ++;
        //}
    }
    
    $display .= '</tbody></table>';
    
    return $display;
//}


?>
