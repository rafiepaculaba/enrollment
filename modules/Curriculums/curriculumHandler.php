<?php
if (!$_SESSION){
    session_start();
}

// ajax action
$action = $_GET['action'];

if ( strtoupper($action)=='GETSUBJECTS' ) {
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
    $result  = $subject->retrieveAllSubjects($where,'subjCode');
    
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
} else if ( strtoupper($action)=='GETCURSUBJECTS' ) {
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Users/User2.php');
    require_once('../Curriculums/Prerequisite.php');
    require_once('../Curriculums/CurriculumSubject.php');
    
    // get parameters
    $curID = $_GET['curID'];

    if ($curID) {
        $where[0]['curID'] = "='$curID'";
    } else {
        $where="";
    }
        
    $curSubj = new CurriculumSubject();
    $result  = $curSubj->retrieveAllCurriculumSubjects($where);
//    p($result);
    $j = new Services_JSON;
    $res = $j->encode($result);
    echo $res;
} else if ( strtoupper($action)=='GETPREREQUISITES' ) {
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
    $result  = $subject->retrieveAllSubjects($where,'subjCode');
    
    $control = '
                <input type="hidden" id="ctr_subj" name="ctr_subj" value="'.count($result).'" />
                <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                		<td scope="col" class="listViewThS1" width="10%" nowrap>&nbsp;</td>
                		<td scope="col" class="listViewThS1" width="30%" nowrap>Subject</td>
                		<td scope="col" class="listViewThS1" width="60%" nowrap>Descriptive Title</td>
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
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top"><input type="checkbox" name="prereq'.$ctr.'" id="prereq'.$ctr.'" value="'.$row['subjID'].'-'.$row['subjCode'].'" /></td>';
                		
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top">'.$row['subjCode'].'</td>';
                		
                		$control .= "<td scope=\"row\" ";
                        if ($ctr%2==0) {
                            $control .= 'class="evenListRowS1" bgcolor="#fdfdfd"';
                        } else {
                            $control .= 'class="oddListRowS1" bgcolor="#ffffff"';
                        }
                        
                        $control .= 'align="left" bgcolor="#fdfdfd" valign="top">'.$row['descTitle'].'</td>';
                        
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
} else if ( strtoupper($action)=='ADDSUBJECT' ) {
    require_once('../../commonAjax.php');
    require_once('../Departments/Department.php');
    require_once('../Courses/Course.php');
    require_once('../Subjects/SubjectCol.php');
    require_once('../Curriculums/CurriculumSubject.php');
    
    // get parameters
    $courseID = $_GET['courseID'];
    $subjID   = $_GET['subjID'];
    $yrLevel  = $_GET['yrLevel'];
    $semCode  = $_GET['semCode'];
    $prerequisitesID = $_GET['prerequisitesID'];
    $prerequisites   = $_GET['prerequisites'];
    
    $data['courseID']       = $courseID;
    $data['subjID']         = $subjID;
    
    $subject = new Subject($subjID);
    $data['subjCode']       = $subject->subjCode;
    $data['descTitle']      = $subject->descTitle;
    $data['units']          = $subject->units;
    
    $data['yrLevel']        = $yrLevel;
    $data['semCode']        = $semCode;
    $data['prerequisitesID']= $prerequisitesID;
    $data['prerequisites']  = $prerequisites;
    
    // need duplicate checking
    $_SESSION['SUBJ'.$yrLevel.$semCode][]=$data;

    echo displayCurriculumSubjects($yrLevel,$semCode);
} else if ( strtoupper($action)=='REMSUBJECT' ) {
    // get parameters
    $subjID   = $_GET['subjID'];
    $yrLevel  = $_GET['yrLevel'];
    $semCode  = $_GET['semCode'];
    
    if ($_SESSION['SUBJ'.$yrLevel.$semCode]) {
        foreach ($_SESSION['SUBJ'.$yrLevel.$semCode] as $key=>$row) {
            if ($row['subjID'] == $subjID) {
                // found subject here
                // pop here the record
                for ($r=$key; $r < (count($_SESSION['SUBJ'.$yrLevel.$semCode])-1); $r++) {
                    $_SESSION['SUBJ'.$yrLevel.$semCode][$r] = $_SESSION['SUBJ'.$yrLevel.$semCode][$r+1];
                }
                
                // clear the last record since the target was record already
                unset ($_SESSION['SUBJ'.$yrLevel.$semCode][count($_SESSION['SUBJ'.$yrLevel.$semCode])-1]);
                
                break;                        
            }
        }
    }

    echo displayCurriculumSubjects($yrLevel,$semCode);
} else {
    echo 0;
}


function isDuplicate() 
{
    for($i=1; $i<=$total_yrLevel; $i++) {
        
        for($s=1; ($s<=$total_semCode && $s!=3) ; $s++) {
            if ($_SESSION['SUBJ'.$i.$s]) {
                $ctr = 0;
                foreach ($_SESSION['SUBJ'.$i.$s] as $row) {
                    if ($row['subjID'] == $subjID) {
                        // found subject here
                        $yrLevel = $i;
                        $semCode = $s;
                        $found = 1;  
                        
                        for ($r=$ctr; $r < (count($_SESSION['SUBJ'.$i.$s])-1); $r++) {
                            $_SESSION['SUBJ'.$i.$s][$r] = $_SESSION['SUBJ'.$i.$s][$r+1];
                        }
                        
                        // clear the last record since the target was record already
                        unset ($_SESSION['SUBJ'.$i.$s][count($_SESSION['SUBJ'.$i.$s])-1]);
                        
                        break;                        
                    }
                    $ctr++;
                }
            }
            
            if ($found)
                break;       
        }
        
        if ($found)
            break;
        
    }
}

function displayCurriculumSubjects($yrLevel, $semCode)
{
    if ($yrLevel && $semCode) {
    
        $display  = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>';
        
        if ($_SESSION['SUBJ'.$yrLevel.$semCode]) {
            $total_units = 0;
            foreach ($_SESSION['SUBJ'.$yrLevel.$semCode] as $data) {
                $total_units += $data['units'];
            	$display  .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
            	   $display  .= '    <td scope="row" ';
                    if ($ctr%2==0) {
                        $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
                    } else {
                        $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
                    }
                    $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject(\''.$data['subjID'].'\',\''.$data['yrLevel'].'\',\''.$data['semCode'].'\')" /></td>';
                    
                    $display  .= '    <td scope="row" ';
                    if ($ctr%2==0) {
                        $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
                    } else {
                        $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
                    }
                    $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="10%">'.$data['subjCode'].'&nbsp;</td>';
                    
                    $display  .= '    <td scope="row" ';
                    if ($ctr%2==0) {
                        $display  .= 'class="evenListRowS1" bgcolor="#fdfdfd" ';
                    } else {
                        $display  .= 'class="oddListRowS1" bgcolor="#ffffff" ';
                    }
                    $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="45%">'.$data['descTitle'].'&nbsp;</td>';
                    
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
                    $display  .= 'align="left" bgcolor="#fdfdfd" valign="top" width="30%">'.$data['prerequisites'] .'&nbsp;</td>';
            		
            	$display  .= '</tr>';
            	$display  .= '<tr>';
            	$display  .= '	<td colspan="20" class="listViewHRS1"></td>';
            	$display  .= '</tr>';
            }
            $display .= '<tr height="20">
                    		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
                    		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
                    		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
                    		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>'.number_format($total_units,1,".",",").'</b></td>
                    		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
                    	</tr>';
        }
        
        $display .= '</tbody></table>';
    }
    
    return $display;
}
?>
