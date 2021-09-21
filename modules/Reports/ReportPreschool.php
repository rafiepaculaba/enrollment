<?php
/**
 * Edited
 * Filename: ReportPreschool.php
 * Date: 	 June 30, 2008
 * 
 * Author: 	 Rafie D. Paculaba
 * 
 */

/**
 * Class: Report
 * Description: This class is a model of the object - Report
 * 				Implementing the active record pattern of database record
 */

class ReportClass extends Database 
{
	var $rstatus;
	
	
	/**
	 * Report() constructor of the Report class
	 *
	 * @return Report
	 */
	function ReportClass() 
	{
	    // calling the parent class
	    parent::Database(4); // Preschool level
	}
	
	function adhocQuery($query)
	{
	    if ($query) {
    		$this->db->beginTransaction();
        	$result  = $this->db->query($query);
    		$records = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
	    }
		
		return $records;
	}
	
	
	function collectionReportCollege($result,$total)
	{
	    $form = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap width="30%"><b>Grade</b></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">Total (Php)</div></td>
                		<td scope="col" class="listViewThS1" nowrap width="50%">&nbsp;</td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$value) {
    	       switch ($key) {
    	       case 1: 
    	           $key = "Nursery 1";
    	           break;
               case 2: 
    	           $key = "Nursery 2";
    	           break;
               case 3: 
    	           $key = "Kinder 1";
    	           break;
               case 4: 
    	           $key = "Kinder 2";
    	           break;
    	       default:
    	           $key ="Special Grade";
    	           break;    	     
    	       }
    	       
        	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
               
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= 'align="left" valign="top">'.$key.'</td>';
        	   
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= ' align="right" valign="top">'.number_format($value,2).'</td>';
        	   
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= ' align="left" valign="top">&nbsp;</td>';
        	   
        	   $form .= '</tr>';
        	   
               $form .= '<tr>';
               $form .= '	<td colspan="20" class="listViewHRS1"></td>';
               $form .= '</tr>';
                   
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="right"><b>Grand Total: (Php) </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($total,2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap>&nbsp;</td>
                	</tr>
                </tbody>
                </table>';
    	
    	
    	return $form;
	}
	
	
	function printCollectionReportCollege($result,$total)
	{
	    $form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap align="center"><b>Grade</b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>Total (Php)</b></td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$value) {
    	        switch ($key) {
    	       case 1: 
    	           $key = "Nursery 1";
    	           break;
               case 2: 
    	           $key = "Nursery 2";
    	           break;
               case 3: 
    	           $key = "Kinder 1";
    	           break;
               case 4: 
    	           $key = "Kinder 2";
    	           break;
    	       default:
    	           $key ="Special Grade";
    	           break;    	     
    	       }
    	       
        	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
               
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= 'align="left" valign="top">'.$key.'</td>';
        	   
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= ' align="right" valign="top">'.number_format($value,2).'</td>';
        	   
        	   $form .= '</tr>';
               $form .= '<tr>';
               $form .= '	<td colspan="20" class="listViewHRS1"></td>';
               $form .= '</tr>';
                   
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="right"><b>Grand Total: (Php) </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($total,2).'</b></td>
                	</tr>
                </tbody>
                </table>';
    	
    	
    	return $form;
	}
	
	function receivableReportPreschool($result,$total)
	{
	    $form = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap width="30%"><b>Grade</b></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">Total (Php)</div></td>
                		<td scope="col" class="listViewThS1" nowrap width="50%">&nbsp;</td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$value) {
    	       switch ($key) {
    	       case 1: 
    	           $key = "Nursery 1";
    	           break;
               case 2: 
    	           $key = "Nursery 2";
    	           break;
               case 3: 
    	           $key = "Kinder 1";
    	           break;
               case 4: 
    	           $key = "Kinder 2";
    	           break;
    	       default:
    	           $key ="Special Grade";
    	           break;    	     
    	       }
    	       
        	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
               
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= 'align="left" valign="top">'.$key.'</td>';
        	   
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= ' align="right" valign="top">'.number_format($value,2).'</td>';
        	   
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= ' align="left" valign="top">&nbsp;</td>';
        	   
        	   $form .= '</tr>';
        	   
               $form .= '<tr>';
               $form .= '	<td colspan="20" class="listViewHRS1"></td>';
               $form .= '</tr>';
                   
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="right"><b>Grand Total: (Php) </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($total,2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap>&nbsp;</td>
                	</tr>
                </tbody>
                </table>';
    	
    	
    	return $form;
	}
	
	
	function printReceivableReportPreschool($result,$total)
	{
	    $form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap align="center"><b>Grade</b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>Total (Php)</b></td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$value) {
    	       switch ($key) {
    	       case 1: 
    	           $key = "Nursery 1";
    	           break;
               case 2: 
    	           $key = "Nursery 2";
    	           break;
               case 3: 
    	           $key = "Kinder 1";
    	           break;
               case 4: 
    	           $key = "Kinder 2";
    	           break;
    	       default:
    	           $key ="Special Grade";
    	           break;    	     
    	       }
    	       
        	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
               
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= 'align="left" valign="top">'.$key.'</td>';
        	   
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= ' align="right" valign="top">'.number_format($value,2).'</td>';
        	   
        	   $form .= '</tr>';
               $form .= '<tr>';
               $form .= '	<td colspan="20" class="listViewHRS1"></td>';
               $form .= '</tr>';
                   
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="right"><b>Grand Total: (Php) </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($total,2).'</b></td>
                	</tr>
                </tbody>
                </table>';
    	
    	
    	return $form;
	}
		
	function generateEnrollmentStatusPreschool($result,$total)
	{
	    $form = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap width="30%"><b>Year Level</b></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">Number Enrolled</div> </td>
                		<td scope="col" class="listViewThS1" nowrap width="50%">&nbsp;</td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$value) {
    	       switch ($key) {
    	       case 1: 
    	           $key = "Nursery 1";
    	           break;
               case 2: 
    	           $key = "Nursery 2";
    	           break;
               case 3: 
    	           $key = "Kinder 1";
    	           break;
               case 4: 
    	           $key = "Kinder 2";
    	           break;
    	       default:
    	           $key ="Special Grade";
    	           break;    	     
    	       }
    	       
        	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
               
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= 'align="left" valign="top">'.$key.'</td>';
        	   
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= ' align="right" valign="top">'.number_format($value).'</td>';
        	   
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= ' align="left" valign="top">&nbsp;</td>';
        	   
        	   $form .= '</tr>';
        	   
               $form .= '<tr>';
               $form .= '	<td colspan="20" class="listViewHRS1"></td>';
               $form .= '</tr>';
                   
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="right"><b>Grand Total: </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($total).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap>&nbsp;</td>
                	</tr>
                </tbody>
                </table>';
    	
    	
    	return $form;
	}
	
	function printEnrollmentStatusPreschool($result,$total)
	{
	    $form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap align="center"><b>Year Level</b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>Number Enrolled </b></td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$value) {
    	       switch ($key) {
    	       case 1: 
    	           $key = "Nursery 1";
    	           break;
               case 2: 
    	           $key = "Nursery 2";
    	           break;
               case 3: 
    	           $key = "Kinder 1";
    	           break;
               case 4: 
    	           $key = "Kinder 2";
    	           break;
    	       default:
    	           $key ="Special Grade";
    	           break;    	     
    	       }

        	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
               
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= 'align="left" valign="top">'.$key.'</td>';
        	   
        	   $form .= '<td scope="row" ';
        	   if ($ctr%2==0) {
        	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
        	   } else {
        	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
        	   } 
        	   $form .= ' align="center" valign="top">'.number_format($value).'</td>';
        	   
        	   $form .= '</tr>';
               $form .= '<tr>';
               $form .= '	<td colspan="20" class="listViewHRS1"></td>';
               $form .= '</tr>';
                   
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="right"><b>Grand Total:  </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="center"><b>'.number_format($total).'</b></td>
                	</tr>
                </tbody>
                </table>';
    	
    	
    	return $form;
	}
	
	function teachersLoadPreschool($result)
	{
	    $form = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap>Sched Code</td>
                		<td scope="col" class="listViewThS1" nowrap>Subject </td>
                		<td scope="col" class="listViewThS1" nowrap>Time </td>
                		<td scope="col" class="listViewThS1" nowrap>Days </td>
                		<td scope="col" class="listViewThS1" nowrap>Room</td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$row) {
    	       //if ($key=='0') {
            	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
                   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= 'align="left" valign="top">'.$row['schedCode'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$row['subjCode']." ".$row['descTitle'].'</td>';
            	   
            	   //change time format
            	    $startTime = date("h:i A",strtotime($row['startTime']));
            	    $endTime = date("h:i A",strtotime($row['endTime']));

            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$startTime." - ".$endTime.'</td>';
            	   
            	   //format for days
            	   if ($row['onMon'] == 1) {
            	   	$days .= 'M'; 
            	   }
                   if ($row['onTue'] == 1) {
                    	if ($row['onThu'] == 1) {
                    		$days .= 'T'; 
                    	} else {
                    		$days .= "Tue";
                    	}
                    }
            	   if ($row['onWed'] == 1) {
            	   	$days .= 'W'; 
            	   }
                   if ($row['onThu'] == 1) {
                    	if ($row['onTue'] == 1) {
                    		$days .= 'Th'; 
                    	} else {
                    		$days .= "Thu";
                    	}
                    }
            	   if ($row['onFri'] == 1) {
            	   	$days .= 'F'; 
            	   }
            	   if ($row['onSat'] == 1) {
            	   	$days .= 'Sat'; 
            	   }
            	   if ($row['onSun'] == 1) {
            	   	$days .= 'Sun'; 
            	   }
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$days.'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$row['room'].'</td>';

            	   $form .= '</tr>';
                   $form .= '<tr>';
                   $form .= '	<td colspan="20" class="listViewHRS1"></td>';
                   $form .= '</tr>';
                   
                   $days = '';
                   $ctr++;
    	       //}
    	   }
	    }
	    
    	return $form;
	}
	
	function printTeachersLoadPreschool($result)
	{
	    $form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap><b>Sched Code</b></td>
                		<td scope="col" class="listViewThS1" nowrap><b>Subject</b> </td>
                		<td scope="col" class="listViewThS1" nowrap><b>Time</b> </td>
                		<td scope="col" class="listViewThS1" nowrap><b>Days</b> </td>
                		<td scope="col" class="listViewThS1" nowrap><b>Room</b></td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$row) {
    	       //if ($key=='0') {
            	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
                   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= 'align="left" valign="top">'.$row['schedCode'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$row['subjCode']." ".$row['descTitle'].'</td>';
            	   
            	   //change time format
            	    $startTime = date("h:i A",strtotime($row['startTime']));
            	    $endTime = date("h:i A",strtotime($row['endTime']));

            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$startTime." - ".$endTime.'</td>';
            	   
            	   //format for days
            	   if ($row['onMon'] == 1) {
            	   	$days .= 'M'; 
            	   }
                   if ($row['onTue'] == 1) {
                    	if ($row['onThu'] == 1) {
                    		$days .= 'T'; 
                    	} else {
                    		$days .= "Tue";
                    	}
                    }
            	   if ($row['onWed'] == 1) {
            	   	$days .= 'W'; 
            	   }
                   if ($row['onThu'] == 1) {
                    	if ($row['onTue'] == 1) {
                    		$days .= 'Th'; 
                    	} else {
                    		$days .= "Thu";
                    	}
                    }
            	   if ($row['onFri'] == 1) {
            	   	$days .= 'F'; 
            	   }
            	   if ($row['onSat'] == 1) {
            	   	$days .= 'Sat'; 
            	   }
            	   if ($row['onSun'] == 1) {
            	   	$days .= 'Sun'; 
            	   }
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$days.'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$row['room'].'</td>';

            	   $form .= '</tr>';
                   $form .= '<tr>';
                   $form .= '	<td colspan="20" class="listViewHRS1"></td>';
                   $form .= '</tr>';
                   
                   $days = '';
                   $ctr++;
    	       //}
    	   }
	    }
	    
    	return $form;
	}
}
?>