<?php
/**
 * Edited
 * Filename: ReportCol.php
 * Date: 	 March 18, 2008
 * 
 * Author: 	 Erwin Dacua
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
	    parent::Database(3); // college level
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
	
	
	function collectionReportCollege($result)
	{
	    $form = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap>Course</td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">1<sup>st</sup></div></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">2<sup>nd</sup></div></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">3<sup>rd</sup></div></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">4<sup>th</sup></div></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">5<sup>th</sup></div></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">Total</div></td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$row) {
    	       if ($key!="gtotal" || $key=='0') {
            	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
                   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= 'align="left" valign="top">'.$row['course'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[1],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[2],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[3],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[4],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[5],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row['total'],2).'</td>';
            	 
            	   $form .= '</tr>';
                   $form .= '<tr>';
                   $form .= '	<td colspan="20" class="listViewHRS1"></td>';
                   $form .= '</tr>';
                   
                   $ctr++;
    	       }
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="left"><b>Grand Total: (Php) </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][1],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][2],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][3],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][4],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][5],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal']['total'],2).'</b></td>
                	</tr>
                </tbody>
                </table>';
    	
    	
    	return $form;
	}
	
	
	function printCollectionReportCollege($result)
	{
	    $form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap align="center"><b>Course</b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>1<sup>st</sup></b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>2<sup>nd</sup></b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>3<sup>rd</sup></b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>4<sup>th</sup></b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>5<sup>th</sup></b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>Total</b></td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$row) {
    	       if ($key!="gtotal" || $key=='0') {
            	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
                   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= 'align="left" valign="top">'.$row['course'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[1],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[2],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[3],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[4],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[5],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row['total'],2).'</td>';
            	 
            	   $form .= '</tr>';
                   $form .= '<tr>';
                   $form .= '	<td colspan="20" class="listViewHRS1"></td>';
                   $form .= '</tr>';
                   
                   $ctr++;
    	       }
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="right"><b>Grand Total: (Php) </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][1],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][2],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][3],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][4],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][5],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal']['total'],2).'</b></td>
                	</tr>
                </tbody>
                </table>';
    	
    	
    	return $form;
	}
	
	function receivableReportCollege($result)
	{
	    $form = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap>Course</td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">1<sup>st</sup></div></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">2<sup>nd</sup></div></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">3<sup>rd</sup></div></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">4<sup>th</sup></div></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">5<sup>th</sup></div></td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">Total</div></td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$row) {
    	       if ($key!="gtotal" || $key=='0') {
            	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
                   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= 'align="left" valign="top">'.$row['course'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[1],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[2],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[3],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[4],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[5],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row['total'],2).'</td>';
            	 
            	   $form .= '</tr>';
                   $form .= '<tr>';
                   $form .= '	<td colspan="20" class="listViewHRS1"></td>';
                   $form .= '</tr>';
                   
                   $ctr++;
    	       }
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="left"><b>Grand Total: (Php) </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][1],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][2],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][3],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][4],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][5],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal']['total'],2).'</b></td>
                	</tr>
                </tbody>
                </table>';
    	
    	
    	return $form;
	}
	
	
	function printReceivableReportCollege($result)
	{
	    $form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap align="center"><b>Course</b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>1<sup>st</sup></b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>2<sup>nd</sup></b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>3<sup>rd</sup></b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>4<sup>th</sup></b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>5<sup>th</sup></b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><b>Total</b></td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=1;
    	   foreach ($result as $key=>$row) {
    	       if ($key!="gtotal" || $key=='0') {
            	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
                   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= 'align="left" valign="top">'.$row['course'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[1],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[2],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[3],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[4],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[5],2).'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row['total'],2).'</td>';
            	 
            	   $form .= '</tr>';
                   $form .= '<tr>';
                   $form .= '	<td colspan="20" class="listViewHRS1"></td>';
                   $form .= '</tr>';
                   
                   $ctr++;
    	       }
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="right"><b>Grand Total: (Php) </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][1],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][2],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][3],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][4],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'][5],2).'</b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal']['total'],2).'</b></td>
                	</tr>
                </tbody>
                </table>';
    	
    	
    	return $form;
	}
		
	function teachersLoadCol($result)
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
	
	function printTeachersLoadCol($result)
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
    	       
    	   }
	    }
	    
    	return $form;
	}

	
    function cashierReportCollege($result, $border=0)
    {
        $form = '<table class="listView" border="'.$border.'" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap>OR #</td>
                		<td scope="col" class="listViewThS1" nowrap>ID no.</td>
                		<td scope="col" class="listViewThS1" nowrap>Student</td>
                		<td scope="col" class="listViewThS1" nowrap>Course</td>
                		<td scope="col" class="listViewThS1" nowrap>Type</td>
                		<td scope="col" class="listViewThS1" nowrap><div align="right">Amount</div></td>
                	</tr>';
        
        if ($result) {
            $ctr=1;
            $total = 0;
    	   foreach ($result as $key=>$row) {
    	   		   $total+=$row['amount'];
            	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
                   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= 'align="left" valign="top">'.$row['orno'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$row['idno'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$row['lname'].', '.$row['fname'].' '.$row['mname'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$row['courseCode'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="left" valign="top">'.$row['type'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row['amount'],2).'</td>';
            	   
            	   $form .= '</tr>';
                   $form .= '<tr>';
                   $form .= '	<td colspan="20" class="listViewHRS1"></td>';
                   $form .= '</tr>';
                  
                   $ctr++;
    	   }
    	   
    	    $form .= '<tr height="20">';
            $form .= '	<td class="evenListRowS1" colspan="4">&nbsp;</td>';
    	    $form .= '	<td class="evenListRowS1" align="center"><b>Total: Php</b></td>';
            $form .= '	<td class="evenListRowS1"><div align="right"><b>'.number_format($total,2).'</b></div></td>';
            $form .= '</tr>';
    	    
        }
        
    	return $form;
    }

    function cashSummaryReportCollege($result)
    {
	    $form = '<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" width="40%" nowrap>Cashier</td>
                		<td scope="col" class="listViewThS1" width="30%" nowrap> <div align="right" > Total Amount </div></td>
                		<td scope="col" class="listViewThS1" width="30%"nowrap>&nbsp;</td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=0;
    	   foreach ($result as $key=>$row) {
    	        if ($key!="gtotal" || $key=='0') {
            	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
                   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= 'align="left" valign="top">'.$row['user_name'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= 'align="right" valign="top">'.number_format($row[$ctr],2).'</td>';

            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' valign="top">&nbsp;</td>';
            	   
            	   $form .= '</tr>';
                   $form .= '<tr>';
                   $form .= '	<td colspan="20" class="listViewHRS1"></td>';
                   $form .= '</tr>';
                   
                   $ctr++;
    	        }
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="right"><b>Grand Total: (Php) </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'],2).'</b></td>
                	</tr>
                </tbody>
                </table>';
    	return $form;
    }

	function printCashSummaryReportCollege($result)
	{
	    $form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                	    <td scope="col" class="listViewThS1" nowrap align="center"><b>Cashier</b></td>
                		<td scope="col" class="listViewThS1" nowrap align="center"><div align="right"><b>Total Amount</b></div></td>
                	</tr>';
	    
	    if ($result) {
	        $ctr=0;
    	   foreach ($result as $key=>$row) {
    	       if ($key!="gtotal" || $key=='0') {
            	   $form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
                   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= 'align="left" valign="top">'.$row['user_name'].'</td>';
            	   
            	   $form .= '<td scope="row" ';
            	   if ($ctr%2==0) {
            	       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
            	   } else {
            	       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
            	   } 
            	   $form .= ' align="right" valign="top">'.number_format($row[$ctr],2).'</td>';
            	   
            	   $form .= '</tr>';
                   $form .= '<tr>';
                   $form .= '	<td colspan="20" class="listViewHRS1"></td>';
                   $form .= '</tr>';
                   
                   $ctr++;
    	       }
    	   }
	    }
	    
    	$form .= '<tr height="20">
                	    <td scope="col" class="evenListRowS1" nowrap align="right"><b>Grand Total: (Php) </b></td>
                		<td scope="col" class="evenListRowS1" nowrap align="right"><b>'.number_format($result['gtotal'],2).'</b></td>
                	</tr>
                </tbody>
                </table>';
    	
    	return $form;
	}
	
	function enrollmentListCollege($records, $courseName, $semCode, $yrLevel, $schName, $schAddress, $schContact, $schRegion)
	{
		
		switch ($semCode) {
			case 1 : 
				$semester = "1<sup>st</sup> Sem ";
				break;
			case 2 : 
				$semester = "2<sup>nd</sup> Sem ";
				break;
			case 4 : 
				$semester = "Summer";
				break;
		}

		switch ($yrLevel) {
			case 1 : 
				$yearLevel = "First Year ";
				break;
			case 2 : 
				$yearLevel = "Second Year ";
				break;
			case 3 : 
				$yearLevel = "Third Year ";
				break;
			case 4 : 
				$yearLevel = "Fourth Year ";
				break;
			case 5 : 
				$yearLevel = "Fifth Year ";
				break;
		}
		$form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
				    <tr>
				      <td width="879"><table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
				        <tr>
				          <td>School : </td>
				          <td><u><b>'.$schName.'&nbsp;</b></u></td>
				          <td>Course : </td>
				          <td><u><b>'.$courseName.'&nbsp;</b></u></td>
				          <td>Year Level : </td>
				          <td><u><b>'.$yearLevel.'&nbsp;</b></u></td>
				          <td>Term : </td>
				          <td><u><b>'.$semester.'&nbsp;</b></u></td>
				        </tr>
				        <tr>
				          <td>Address :</td>
				          <td>'.$schAddress.'&nbsp;</td>
				          <td>Tel No. </td>
				          <td>'.$schContact.'&nbsp;</td>
				          <td>Region :</td>
				          <td colspan="3" >'.$schRegion.'&nbsp;</td>
				        </tr>
				      </table></td>
				    </tr>
				    <tr>
				      <td><table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
				        <tr>
				          <td align="center"><u><b>NAME OF STUDENT </b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>Subjects</b></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>TOTAL</b></u></td>
				        </tr>';
		
		if ($records) {
	        $ctr=0;
	        $ctrm=1;
	        $ctrf=1;
	        $index1 = 1;
	       
			//for male
			foreach ($records as $key=>$row) {
				if($row['gender'] == 'M') {
					if($ctrm == 1) {
						$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
	    	   			$form .= ' <td align="center"><u><b>MALES</b></u></td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td align="center">&nbsp;</td>
					          </tr>
					          ';
	    	   			$ctrm++;
	    	   		}
	    	   		
					$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';	
					$form .= '<td scope="row" ';
					if ($ctr%2==0) {
					   $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
					} else {
					   $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
					} 
					$form .= 'align="left" valign="top">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					<td width="10%">'.$index1.'&nbsp;</td>
					<td width="30%">'.$row['lname'].'&nbsp;</td>
					<td width="5%">,</td>
					<td width="35%">'.$row['fname'].'&nbsp;</td>
					<td width="20%">'.$row['mname'].'&nbsp;</td>
					</tr>
					</table>
					</td>';
		        	   
					$enrollmentDetail = new EnrollmentDetail();
					$where[0]['enID'] = "='".$row['enID']."' "; 
					$enrollmentDetailrecords = $enrollmentDetail->retrieveAllEnrollmentDetails($where, "");
					$ctr2 = 0;
					$ttlUnits = 0;
					$reset = 1;
					foreach ($enrollmentDetailrecords as $key2=>$row2) {
						$ttlUnits += $row2['sched']->units;
						
						if ($reset <= 6) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0) {
								if ($key2 != count($enrollmentDetailrecords)-1) {
									$form .= '	<td align="center">&nbsp;</td>';
								}
						 		if ($key2 != count($enrollmentDetailrecords)-1) {
						 			$form .= 	'<tr>';		
								}	
							}
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 0) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 1) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 2) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 3) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 4) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 5) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}
							
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}
						
						if ($reset >= 7 && $reset <= 12) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1 && $reset != 12  && $key2 != 10) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
							}
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 6) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 7) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 8) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 9) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 10) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 11) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}

							if ($key2%5 == 0 && $key2 != 0 && $key2 != 10 && $key2 != count($enrollmentDetailrecords)-1 ) {
							 	
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
							
							if($key2 == 11) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}

						if ($reset >= 13) {

							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0) {
							 	if ($key2 != count($enrollmentDetailrecords)-1) {
									$form .= '	<td align="center">&nbsp;</td>';
								}
						 		if ($key2 != count($enrollmentDetailrecords)-1) {
						 			$form .= 	'<tr>';		
						 		}	
							}
							
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 12) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 13) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 14) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 15) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 16) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 17) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   &nbsp;</td>';
							}
						}					
						
		        	   	$reset++;
					}
					$ctr++;
					$ctrm++;
					$index1++;
				}

			}
			$index2 = 1;
			//for female
			foreach ($records as $key=>$row) {
				if($row['gender'] == 'F') {
					if($ctrf == 1) {
						$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
	    	   			$form .= ' <td align="center"><u><b>FEMALES</b></u></td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td align="center">&nbsp;</td>
					          </tr>
					          ';
	    	   			$ctrf++;
	    	   		}
	    	   		
					$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';	
					$form .= '<td scope="row" ';
					if ($ctr%2==0) {
					   $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
					} else {
					   $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
					} 
					$form .= 'align="left" valign="top">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					<td width="10%">'.$index2.'&nbsp;</td>
					<td width="30%">'.$row['lname'].'&nbsp;</td>
					<td width="5%">,</td>
					<td width="35%">'.$row['fname'].'&nbsp;</td>
					<td width="20%">'.$row['mname'].'&nbsp;</td>
					</tr>
					</table>
					</td>';
		        	   
					$enrollmentDetail = new EnrollmentDetail();
					$where[0]['enID'] = "='".$row['enID']."' "; 
					$enrollmentDetailrecords = $enrollmentDetail->retrieveAllEnrollmentDetails($where, "");
					$ctr2 = 0;
					$ttlUnits = 0;
					$reset = 1;
					foreach ($enrollmentDetailrecords as $key2=>$row2) {
						$ttlUnits += $row2['sched']->units;
						
						if ($reset <= 6) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0) {
								if ($key2 != count($enrollmentDetailrecords)-1) {
									$form .= '	<td align="center">&nbsp;</td>';
								}
						 		if ($key2 != count($enrollmentDetailrecords)-1) {
						 			$form .= 	'<tr>';		
								}	
							}
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 0) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 1) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 2) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 3) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 4) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 5) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}
							
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}
						
						if ($reset >= 7 && $reset <= 12) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1 && $reset != 12  && $key2 != 10) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
							}
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 6) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 7) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 8) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 9) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 10) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 11) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}

							if ($key2%5 == 0 && $key2 != 0 && $key2 != 10 && $key2 != count($enrollmentDetailrecords)-1 ) {
							 	
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
							
							if($key2 == 11) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}

						if ($reset >= 13) {

							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0) {
							 	if ($key2 != count($enrollmentDetailrecords)-1) {
									$form .= '	<td align="center">&nbsp;</td>';
								}
						 		if ($key2 != count($enrollmentDetailrecords)-1) {
						 			$form .= 	'<tr>';		
						 		}	
							}
							
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 12) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 13) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 14) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 15) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 16) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 17) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   &nbsp;</td>';
							}
						}					
						
		        	   	$reset++;
					}
					$ctr++;
					$ctrf++;
					$index2++;
				}

			}
		
    	   
    	   $form .='   		</tr>
						      </table></td>
						    </tr>
						  </table>';
    	   
	    }

    	return $form;
	}
	
	function printEnrollmentListCollege($records, $courseName, $yrLevel, $semCode, $schName, $schAddress, $schContact, $schRegion)
	{

		switch ($semCode) {
			case 1 : 
				$semester = "1<sup>st</sup> Sem ";
				break;
			case 2 : 
				$semester = "2<sup>nd</sup> Sem ";
				break;
			case 4 : 
				$semester = "Summer";
				break;
		}
		
		switch ($yrLevel) {
			case 1 : 
				$yearLevel = "First Year ";
				break;
			case 2 : 
				$yearLevel = "Second Year ";
				break;
			case 3 : 
				$yearLevel = "Third Year ";
				break;
			case 4 : 
				$yearLevel = "Fourth Year ";
				break;
			case 5 : 
				$yearLevel = "Fifth Year ";
				break;
		}
		$form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
				    <tr>
				      <td width="879"><table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
				        <tr>
				          <td>School : </td>
				          <td><u><b>'.$schName.'&nbsp;</b></u></td>
				          <td>Course : </td>
				          <td><u><b>'.$courseName.'&nbsp;</b></u></td>
				          <td>Year Level : </td>
				          <td><u><b>'.$yearLevel.'&nbsp;</b></u></td>
				          <td>Term : </td>
				          <td><u><b>'.$semester.'&nbsp;</b></u></td>
				        </tr>
				        <tr>
				          <td>Address :</td>
				          <td>'.$schAddress.'&nbsp;</td>
				          <td>Tel No. </td>
				          <td>'.$schContact.'&nbsp;</td>
				          <td>Region :</td>
				          <td colspan="3" >'.$schRegion.'&nbsp;</td>
				        </tr>
				      </table></td>
				    </tr>
				    <tr>
				      <td><table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
				        <tr>
				          <td align="center"><u><b>NAME OF STUDENT </b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Units</b></u></td>
				          <td><u><b>TOTAL</b></u></td>
				        </tr>';
		
		if ($records) {
	        $ctr=0;
	        $ctrm=1;
	        $ctrf=1;
	        $index1 = 1;
	       
			//for male
			foreach ($records as $key=>$row) {
				if($row['gender'] == 'M') {
					if($ctrm == 1) {
						$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
	    	   			$form .= ' <td align="center"><u><b>MALES</b></u></td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td align="center">&nbsp;</td>
					          </tr>
					          ';
	    	   			$ctrm++;
	    	   		}
	    	   		
					$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';	
					$form .= '<td scope="row" ';
					if ($ctr%2==0) {
					   $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
					} else {
					   $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
					} 
					$form .= 'align="left" valign="top">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					<td width="10%">'.$index1.'&nbsp;</td>
					<td width="30%">'.$row['lname'].'&nbsp;</td>
					<td width="5%">,</td>
					<td width="35%">'.$row['fname'].'&nbsp;</td>
					<td width="20%">'.$row['mname'].'&nbsp;</td>
					</tr>
					</table>
					</td>';
		        	   
					$enrollmentDetail = new EnrollmentDetail();
					$where[0]['enID'] = "='".$row['enID']."' "; 
					$enrollmentDetailrecords = $enrollmentDetail->retrieveAllEnrollmentDetails($where, "");
					$ctr2 = 0;
					$ttlUnits = 0;
					$reset = 1;
					foreach ($enrollmentDetailrecords as $key2=>$row2) {
						$ttlUnits += $row2['sched']->units;
						
						if ($reset <= 6) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0) {
								if ($key2 != count($enrollmentDetailrecords)-1) {
									$form .= '	<td align="center">&nbsp;</td>';
								}
						 		if ($key2 != count($enrollmentDetailrecords)-1) {
						 			$form .= 	'<tr>';		
								}	
							}
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 0) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 1) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 2) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 3) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 4) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 5) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}
							
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}
						
						if ($reset >= 7 && $reset <= 12) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1 && $reset != 12  && $key2 != 10) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
							}
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 6) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 7) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 8) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 9) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 10) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 11) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}

							if ($key2%5 == 0 && $key2 != 0 && $key2 != 10 && $key2 != count($enrollmentDetailrecords)-1 ) {
							 	
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
							
							if($key2 == 11) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}

						if ($reset >= 13) {

							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0) {
							 	if ($key2 != count($enrollmentDetailrecords)-1) {
									$form .= '	<td align="center">&nbsp;</td>';
								}
						 		if ($key2 != count($enrollmentDetailrecords)-1) {
						 			$form .= 	'<tr>';		
						 		}	
							}
							
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 12) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 13) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 14) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 15) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 16) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 17) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   &nbsp;</td>';
							}
						}					
						
		        	   	$reset++;
					}
					$ctr++;
					$ctrm++;
					$index1++;
				}

			}
			$index2 = 1;
			//for female
			foreach ($records as $key=>$row) {
				if($row['gender'] == 'F') {
					if($ctrf == 1) {
						$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
	    	   			$form .= ' <td align="center"><u><b>FEMALES</b></u></td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td align="center">&nbsp;</td>
					          </tr>
					          ';
	    	   			$ctrf++;
	    	   		}
	    	   		
					$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';	
					$form .= '<td scope="row" ';
					if ($ctr%2==0) {
					   $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
					} else {
					   $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
					} 
					$form .= 'align="left" valign="top">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					<td width="10%">'.$index2.'&nbsp;</td>
					<td width="30%">'.$row['lname'].'&nbsp;</td>
					<td width="5%">,</td>
					<td width="35%">'.$row['fname'].'&nbsp;</td>
					<td width="20%">'.$row['mname'].'&nbsp;</td>
					</tr>
					</table>
					</td>';
		        	   
					$enrollmentDetail = new EnrollmentDetail();
					$where[0]['enID'] = "='".$row['enID']."' "; 
					$enrollmentDetailrecords = $enrollmentDetail->retrieveAllEnrollmentDetails($where, "");
					$ctr2 = 0;
					$ttlUnits = 0;
					$reset = 1;
					foreach ($enrollmentDetailrecords as $key2=>$row2) {
						$ttlUnits += $row2['sched']->units;
						
						if ($reset <= 6) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0) {
								if ($key2 != count($enrollmentDetailrecords)-1) {
									$form .= '	<td align="center">&nbsp;</td>';
								}
						 		if ($key2 != count($enrollmentDetailrecords)-1) {
						 			$form .= 	'<tr>';		
								}	
							}
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 0) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 1) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 2) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 3) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 4) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 5) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}
							
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}
						
						if ($reset >= 7 && $reset <= 12) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1 && $reset != 12  && $key2 != 10) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
							}
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 6) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 7) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 8) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 9) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 10) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 11) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}

							if ($key2%5 == 0 && $key2 != 0 && $key2 != 10 && $key2 != count($enrollmentDetailrecords)-1 ) {
							 	
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
							
							if($key2 == 11) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}

						if ($reset >= 13) {

							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
							if ($key2%5 == 0 && $key2 != 0) {
							 	if ($key2 != count($enrollmentDetailrecords)-1) {
									$form .= '	<td align="center">&nbsp;</td>';
								}
						 		if ($key2 != count($enrollmentDetailrecords)-1) {
						 			$form .= 	'<tr>';		
						 		}	
							}
							
							
							if($key2 == count($enrollmentDetailrecords)-1) {
								if($key2 == 12) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 13) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 14) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 15) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 16) {
									$form .= '	<td>&nbsp;</td>
							  					<td align="center">&nbsp;</td>
							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								} else if ($key2 == 17) {
									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
								}
							}
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   &nbsp;</td>';
							}
						}					
						
		        	   	$reset++;
					}
					$ctr++;
					$ctrf++;
					$index2++;
				}

			}
		
    	   
    	   $form .='   		</tr>
						      </table></td>
						    </tr>
						  </table>';
    	   
	    }

    	return $form;
	}	
	
	function promotionaryListCollege($records, $courseName, $yrLevel, $semCode, $schName, $schAddress, $schContact, $schRegion)
	{
		
		switch ($semCode) {
			case 1 : 
				$semester = "1<sup>st</sup> Sem ";
				break;
			case 2 : 
				$semester = "2<sup>nd</sup> Sem ";
				break;
			case 4 : 
				$semester = "Summer";
				break;
		}

		switch ($yrLevel) {
			case 1 : 
				$yearLevel = "First Year ";
				break;
			case 2 : 
				$yearLevel = "Second Year ";
				break;
			case 3 : 
				$yearLevel = "Third Year ";
				break;
			case 4 : 
				$yearLevel = "Fourth Year ";
				break;
			case 5 : 
				$yearLevel = "Fifth Year ";
				break;
		}
		$form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
				    <tr>
				      <td width="879"><table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
				        <tr>
				          <td>School : </td>
				          <td><u><b>'.$schName.'&nbsp;</b></u></td>
				          <td>Course : </td>
				          <td><u><b>'.$courseName.'&nbsp;</b></u></td>
				          <td>Year Level : </td>
				          <td><u><b>'.$yearLevel.'&nbsp;</b></u></td>
				          <td>Term : </td>
				          <td><u><b>'.$semester.'&nbsp;</b></u></td>
				        </tr>
				        <tr>
				          <td>Address :</td>
				          <td>'.$schAddress.'&nbsp;</td>
				          <td>Tel No. </td>
				          <td>'.$schContact.'&nbsp;</td>
				          <td>Region :</td>
				          <td colspan="3" >'.$schRegion.'&nbsp;</td>
				        </tr>
				      </table></td>
				    </tr>
				    <tr>
				      <td><table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
				        <tr>
				          <td align="center"><u><b>NAME OF STUDENT </b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          <td><u><b>Subjects</b></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          
				        </tr>';//<td><u><b>TOTAL</b></u></td>
		
		if ($records) {
	        $ctr=0;
	        $ctrm=1;
	        $ctrf=1;
	        $index1 = 1;
	       
			//for male
			foreach ($records as $key=>$row) {
				if($row['gender'] == 'M') {
					if($ctrm == 1) {
						$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
	    	   			$form .= ' <td align="center"><u><b>MALES</b></u></td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          
					          </tr>
					          ';//<td align="center">&nbsp;</td>
	    	   			$ctrm++;
	    	   		}
	    	   		
					$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';	
					$form .= '<td scope="row" ';
					if ($ctr%2==0) {
					   $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
					} else {
					   $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
					} 
					$form .= 'align="left" valign="top">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					<td width="10%">'.$index1.'&nbsp;</td>
					<td width="30%">'.$row['lname'].'&nbsp;</td>
					<td width="5%">,</td>
					<td width="35%">'.$row['fname'].'&nbsp;</td>
					<td width="20%">'.$row['mname'].'&nbsp;</td>
					</tr>
					</table>
					</td>';
		        	   
					$enrollmentDetail = new EnrollmentDetail();
					$where[0]['enID'] = "='".$row['enID']."' "; 
					$enrollmentDetailrecords = $enrollmentDetail->retrieveAllEnrollmentDetails($where, "");
					$ctr2 = 0;
					$ttlUnits = 0;
					$reset = 1;
					
					foreach ($enrollmentDetailrecords as $key2=>$row2) {
						//$ttlUnits += $row2['sched']->units;
						
						if ($reset <= 6) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b>'.$row2['fgrade'].'&nbsp;</b></td>';
//							if ($key2%5 == 0 && $key2 != 0) {
//								if ($key2 != count($enrollmentDetailrecords)-1) {
//									$form .= '	<td align="center">&nbsp;</td>';
//								}
//						 		if ($key2 != count($enrollmentDetailrecords)-1) {
//						 			$form .= 	'<tr>';		
//								}	
//							}
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 0) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 1) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 2) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 3) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 4) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 5) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}
							
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}
						
						if ($reset >= 7 && $reset <= 12) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b>'.$row2['fgrade'].'&nbsp;</b></td>';
//							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1 && $reset != 12  && $key2 != 10) {
//								$form .= '	<td align="center">&nbsp;</td>
//											<tr>';
//							}
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 6) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 7) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 8) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 9) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 10) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 11) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}

							if ($key2%5 == 0 && $key2 != 0 && $key2 != 10 && $key2 != count($enrollmentDetailrecords)-1 ) {
							 	
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
							
							if($key2 == 11) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}

						if ($reset >= 13) {

							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b>'.$row2['fgrade'].'&nbsp;</b></td>';
//							if ($key2%5 == 0 && $key2 != 0) {
//							 	if ($key2 != count($enrollmentDetailrecords)-1) {
//									$form .= '	<td align="center">&nbsp;</td>';
//								}
//						 		if ($key2 != count($enrollmentDetailrecords)-1) {
//						 			$form .= 	'<tr>';		
//						 		}	
//							}
//							
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 12) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 13) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 14) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 15) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 16) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 17) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   &nbsp;</td>';
							}
						}					
						
		        	   	$reset++;
					}
					$ctr++;
					$ctrm++;
					$index1++;
				}

			}
			$index2 = 1;
			//for female
			foreach ($records as $key=>$row) {
				if($row['gender'] == 'F') {
					if($ctrf == 1) {
						$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
	    	   			$form .= ' <td align="center"><u><b>FEMALES</b></u></td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td align="center">&nbsp;</td>
					          </tr>
					          ';
	    	   			$ctrf++;
	    	   		}
	    	   		
					$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';	
					$form .= '<td scope="row" ';
					if ($ctr%2==0) {
					   $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
					} else {
					   $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
					} 
					$form .= 'align="left" valign="top">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					<td width="10%">'.$index2.'&nbsp;</td>
					<td width="30%">'.$row['lname'].'&nbsp;</td>
					<td width="5%">,</td>
					<td width="35%">'.$row['fname'].'&nbsp;</td>
					<td width="20%">'.$row['mname'].'&nbsp;</td>
					</tr>
					</table>
					</td>';
		        	   
					$enrollmentDetail = new EnrollmentDetail();
					$where[0]['enID'] = "='".$row['enID']."' "; 
					$enrollmentDetailrecords = $enrollmentDetail->retrieveAllEnrollmentDetails($where, "");
					$ctr2 = 0;
					$ttlUnits = 0;
					$reset = 1;
					foreach ($enrollmentDetailrecords as $key2=>$row2) {
						$ttlUnits += $row2['sched']->units;
						
						if ($reset <= 6) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b>'.$row2['fgrade'].'&nbsp;</b></td>';
//							if ($key2%5 == 0 && $key2 != 0) {
//								if ($key2 != count($enrollmentDetailrecords)-1) {
//									$form .= '	<td align="center">&nbsp;</td>';
//								}
//						 		if ($key2 != count($enrollmentDetailrecords)-1) {
//						 			$form .= 	'<tr>';		
//								}	
//							}
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 0) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 1) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 2) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 3) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 4) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 5) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}
							
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}
						
						if ($reset >= 7 && $reset <= 12) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b>'.$row2['fgrade'].'&nbsp;</b></td>';
//							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1 && $reset != 12  && $key2 != 10) {
//								$form .= '	<td align="center">&nbsp;</td>
//											<tr>';
//							}
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 6) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 7) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 8) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 9) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 10) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 11) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}

							if ($key2%5 == 0 && $key2 != 0 && $key2 != 10 && $key2 != count($enrollmentDetailrecords)-1 ) {
							 	
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
							
							if($key2 == 11) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}

						if ($reset >= 13) {

							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center">'.$row2['sched']->units.'&nbsp;</td>';
//							if ($key2%5 == 0 && $key2 != 0) {
//							 	if ($key2 != count($enrollmentDetailrecords)-1) {
//									$form .= '	<td align="center">&nbsp;</td>';
//								}
//						 		if ($key2 != count($enrollmentDetailrecords)-1) {
//						 			$form .= 	'<tr>';		
//						 		}	
//							}
//							
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 12) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 13) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 14) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 15) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 16) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 17) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   &nbsp;</td>';
							}
						}					
						
		        	   	$reset++;
					}
					$ctr++;
					$ctrf++;
					$index2++;
				}

			}
		
    	   
    	   $form .='   		</tr>
						      </table></td>
						    </tr>
						  </table>';
    	   
	    }

    	return $form;
	}
	
	function printPromotionaryListCollege($records, $courseName, $yrLevel, $semCode, $schName, $schAddress, $schContact, $schRegion)
	{
		
		switch ($semCode) {
			case 1 : 
				$semester = "1<sup>st</sup> Sem ";
				break;
			case 2 : 
				$semester = "2<sup>nd</sup> Sem ";
				break;
			case 4 : 
				$semester = "Summer";
				break;
		}
		
		switch ($yrLevel) {
			case 1 : 
				$yearLevel = "First Year ";
				break;
			case 2 : 
				$yearLevel = "Second Year ";
				break;
			case 3 : 
				$yearLevel = "Third Year ";
				break;
			case 4 : 
				$yearLevel = "Fourth Year ";
				break;
			case 5 : 
				$yearLevel = "Fifth Year ";
				break;
		}
		$form = '<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
				    <tr>
				      <td width="879"><table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
				        <tr>
				          <td>School : </td>
				          <td><u><b>'.$schName.'&nbsp;</b></u></td>
				          <td>Course : </td>
				          <td><u><b>'.$courseName.'&nbsp;</b></u></td>
				          <td>Year Level : </td>
				          <td><u><b>'.$yearLevel.'&nbsp;</b></u></td>
				          <td>Term : </td>
				          <td><u><b>'.$semester.'&nbsp;</b></u></td>
				        </tr>
				        <tr>
				          <td>Address :</td>
				          <td>'.$schAddress.'&nbsp;</td>
				          <td>Tel No. </td>
				          <td>'.$schContact.'&nbsp;</td>
				          <td>Region :</td>
				          <td colspan="3" >'.$schRegion.'&nbsp;</td>
				        </tr>
				      </table></td>
				    </tr>
				    <tr>
				      <td><table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
				        <tr>
				          <td align="center"><u><b>NAME OF STUDENT </b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          <td><u><b>Subjects</b></u></td>
				          <td align="center"><u><b>Grade</b></u></td>
				          
				        </tr>';//<td><u><b>TOTAL</b></u></td>
		
		if ($records) {
	        $ctr=0;
	        $ctrm=1;
	        $ctrf=1;
	        $index1 = 1;
	       
			//for male
			foreach ($records as $key=>$row) {
				if($row['gender'] == 'M') {
					if($ctrm == 1) {
						$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
	    	   			$form .= ' <td align="center"><u><b>MALES</b></u></td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          
					          </tr>
					          ';//<td align="center">&nbsp;</td>
	    	   			$ctrm++;
	    	   		}
	    	   		
					$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';	
					$form .= '<td scope="row" ';
					if ($ctr%2==0) {
					   $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
					} else {
					   $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
					} 
					$form .= 'align="left" valign="top">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					<td width="10%">'.$index1.'&nbsp;</td>
					<td width="30%">'.$row['lname'].'&nbsp;</td>
					<td width="5%">,</td>
					<td width="35%">'.$row['fname'].'&nbsp;</td>
					<td width="20%">'.$row['mname'].'&nbsp;</td>
					</tr>
					</table>
					</td>';
		        	   
					$enrollmentDetail = new EnrollmentDetail();
					$where[0]['enID'] = "='".$row['enID']."' "; 
					$enrollmentDetailrecords = $enrollmentDetail->retrieveAllEnrollmentDetails($where, "");
					$ctr2 = 0;
					$ttlUnits = 0;
					$reset = 1;
					foreach ($enrollmentDetailrecords as $key2=>$row2) {
						$ttlUnits += $row2['sched']->units;
						
						if ($reset <= 6) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b><b>'.$row2['fgrade'].'&nbsp;</b></b></td>';
//							if ($key2%5 == 0 && $key2 != 0) {
//								if ($key2 != count($enrollmentDetailrecords)-1) {
//									$form .= '	<td align="center">&nbsp;</td>';
//								}
//						 		if ($key2 != count($enrollmentDetailrecords)-1) {
//						 			$form .= 	'<tr>';		
//								}	
//							}
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 0) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 1) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 2) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 3) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 4) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 5) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}
							
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}
						
						if ($reset >= 7 && $reset <= 12) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b>'.$row2['fgrade'].'&nbsp;</b></td>';
//							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1 && $reset != 12  && $key2 != 10) {
//								$form .= '	<td align="center">&nbsp;</td>
//											<tr>';
//							}
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 6) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 7) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 8) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 9) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 10) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 11) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}

							if ($key2%5 == 0 && $key2 != 0 && $key2 != 10 && $key2 != count($enrollmentDetailrecords)-1 ) {
							 	
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
							
							if($key2 == 11) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}

						if ($reset >= 13) {

							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b>'.$row2['fgrade'].'&nbsp;</b></td>';
//							if ($key2%5 == 0 && $key2 != 0) {
//							 	if ($key2 != count($enrollmentDetailrecords)-1) {
//									$form .= '	<td align="center">&nbsp;</td>';
//								}
//						 		if ($key2 != count($enrollmentDetailrecords)-1) {
//						 			$form .= 	'<tr>';		
//						 		}	
//							}
//							
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 12) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 13) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 14) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 15) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 16) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 17) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   &nbsp;</td>';
							}
						}					
						
		        	   	$reset++;
					}
					$ctr++;
					$ctrm++;
					$index1++;
				}

			}
			$index2 = 1;
			//for female
			foreach ($records as $key=>$row) {
				if($row['gender'] == 'F') {
					if($ctrf == 1) {
						$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';
	    	   			$form .= ' <td align="center"><u><b>FEMALES</b></u></td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td align="center">&nbsp;</td>
					          </tr>
					          ';
	    	   			$ctrf++;
	    	   		}
	    	   		
					$form .= '<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">';	
					$form .= '<td scope="row" ';
					if ($ctr%2==0) {
					   $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
					} else {
					   $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
					} 
					$form .= 'align="left" valign="top">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					<td width="10%">'.$index2.'&nbsp;</td>
					<td width="30%">'.$row['lname'].'&nbsp;</td>
					<td width="5%">,</td>
					<td width="35%">'.$row['fname'].'&nbsp;</td>
					<td width="20%">'.$row['mname'].'&nbsp;</td>
					</tr>
					</table>
					</td>';
		        	   
					$enrollmentDetail = new EnrollmentDetail();
					$where[0]['enID'] = "='".$row['enID']."' "; 
					$enrollmentDetailrecords = $enrollmentDetail->retrieveAllEnrollmentDetails($where, "");
					$ctr2 = 0;
					$ttlUnits = 0;
					$reset = 1;
					foreach ($enrollmentDetailrecords as $key2=>$row2) {
						//$ttlUnits += $row2['sched']->units;
						
						if ($reset <= 6) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b>'.$row2['fgrade'].'&nbsp;</b></td>';
//							if ($key2%5 == 0 && $key2 != 0) {
//								if ($key2 != count($enrollmentDetailrecords)-1) {
//									$form .= '	<td align="center">&nbsp;</td>';
//								}
//						 		if ($key2 != count($enrollmentDetailrecords)-1) {
//						 			$form .= 	'<tr>';		
//								}	
//							}
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 0) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 1) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 2) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 3) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 4) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 5) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}
							
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}
						
						if ($reset >= 7 && $reset <= 12) {
							
							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b>'.$row2['fgrade'].'&nbsp;</b></td>';
//							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1 && $reset != 12  && $key2 != 10) {
//								$form .= '	<td align="center">&nbsp;</td>
//											<tr>';
//							}
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 6) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 7) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 8) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 9) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 10) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 11) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}

							if ($key2%5 == 0 && $key2 != 0 && $key2 != 10 && $key2 != count($enrollmentDetailrecords)-1 ) {
							 	
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
							
							if($key2 == 11) {
								$form .= '	<td align="center">&nbsp;</td>
											<tr>';
								$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   </td>';
							}
						}

						if ($reset >= 13) {

							$form .= '	<td>'.$row2['sched']->subjCode.'&nbsp;</td>
							  	<td align="center"><b>'.$row2['fgrade'].'&nbsp;</b></td>';
//							if ($key2%5 == 0 && $key2 != 0) {
//							 	if ($key2 != count($enrollmentDetailrecords)-1) {
//									$form .= '	<td align="center">&nbsp;</td>';
//								}
//						 		if ($key2 != count($enrollmentDetailrecords)-1) {
//						 			$form .= 	'<tr>';		
//						 		}	
//							}
//							
//							
//							if($key2 == count($enrollmentDetailrecords)-1) {
//								if($key2 == 12) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 13) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 14) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 15) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 16) {
//									$form .= '	<td>&nbsp;</td>
//							  					<td align="center">&nbsp;</td>
//							  					<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								} else if ($key2 == 17) {
//									$form .= '	<td align="center"><b>'.$ttlUnits.'</b>&nbsp;</td>';
//								}
//							}
							if ($key2%5 == 0 && $key2 != 0 && $key2 != count($enrollmentDetailrecords)-1) {
							 	$form .= '</tr>';
								$form .= '<td scope="row" ';
							   if ($ctr%2==0) {
							       $form .= ' class="evenListRowS1" bgcolor="#fdfdfd"';
							   } else {
							       $form .= ' class="oddListRowS1" bgcolor="#ffffff"';
							   } 
							   $form .= 'align="left" valign="top">
							   <table border="0" cellspacing="0" cellpadding="0">
							   <tr>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   <td>&nbsp;</td>
							   </tr>
							   </table>
							   &nbsp;</td>';
							}
						}					
						
		        	   	$reset++;
					}
					$ctr++;
					$ctrf++;
					$index2++;
				}

			}
		
    	   
    	   $form .='   		</tr>
						      </table></td>
						    </tr>
						  </table>';
    	   
	    }

    	return $form;
	}

	
	
	// summary of income here
	function getIncome($schYear, $semCode, $column, $courseID='', $yrLevel='')
	{
		$query = "SELECT
				    accounts.schYear
				    , accounts.semCode
				    , sum(account_details.amount) as ttl
				    , account_details.feeType
				FROM
				    account_details
				    INNER JOIN accounts 
				        ON (account_details.accID = accounts.accID)
				WHERE (accounts.schYear ='$schYear'
				    AND accounts.semCode ='$semCode'
				    AND account_details.feeType ='$column'";
				    
		if ($courseID)
			$query .="  AND accounts.courseID =$courseID ";
			
		if ($yrLevel)
			$query .="  AND accounts.yrLevel='$yrLevel' ";
				    
		$query .="  )
				GROUP BY accounts.schYear, accounts.semCode";

		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		
    		return $records;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}

}

?>