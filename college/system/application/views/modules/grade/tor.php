<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>TOR</h2></td>
	</tr>
</tbody>
</table>

<?php  $current_user = $_SESSION['current_user']; 
		foreach ($current_user as $row)	:
?>
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <th class="tabDetailViewDL" colspan="4" align="center"><h4 class="tabDetailViewDL">TRANSCRIPT OF RECORDS</h4></th>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot><?php echo $row->idno; ?> &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot><?php echo $row->lname.', '.$row->fname.' '. $row->mname; ?> &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Course :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php  
        	$course = $this->User_model->retrieveCourse($row->courseID);
				echo $course[0]->courseName; 
		?>
        &nbsp;</slot></td>
    </tr>
	</table>
</td></tr>
</table>
</p>


<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
	    <td scope="col" class="listViewThS1" width="30%" nowrap>SUBJECT CODE</td>
	    <td scope="col" class="listViewThS1" width="50%" nowrap>DESCRIPTIVE TITLE</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>GRADE</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>UNITS</td>
	</tr>
	<!-- Start of registrant Listing -->
	<?php 
		$yrLevel_semCode = $this->User_model->retrieveYrLevelSemCode($row->idno);
		foreach ($yrLevel_semCode as $yrLevel_semCode) {
			$subj = $this->User_model->retrieveEnrollmentDetail($yrLevel_semCode->enID);
	?>
	<tr>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><b><u>
		<?php  
        	$course = $this->User_model->retrieveCourse($row->courseID);
				echo $course[0]->courseCode; 
		?>-<?php echo $yrLevel_semCode->yrLevel; ?></b></u>
		</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><b><u>
		<?php 
        switch ($yrLevel_semCode->semCode) {
         	case 1:
         		echo "1<sup>st</sup> Semester";
         		break;
         	case 2:
         		echo "2<sup>nd</sup> Semester";
         		break;
         	case 4:
         		echo "Summer";
         		break;
         } 
		?> - <?php echo $yrLevel_semCode->schYear; ?> </b></u>
		</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php  
		$subj = $this->User_model->retrieveEnrollmentDetail($yrLevel_semCode->enID);
		foreach ($subj as $value) {
	?>
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">
		<?php  
        	$subject = $this->User_model->retrieveSubjects($value->subjID);
				echo $subject[0]->subjCode; 
		?>
		</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $subject[0]->descTitle; ?></td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">
		<?php
        	$grade = $this->User_model->retrieveTOR($row->idno,$value->subjID);	
        	if($grade) {
        		echo $grade[0]->fgrade; 
        	}
		?>
		</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $subject[0]->units; ?></td>
		
	
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	
	<?php 
		$this->subjTotal += $subject[0]->units;
		} 
	?>
	
	<?php } ?>
	
	<tr>
		<td bgcolor="#fdfdfd" align="right" valign="top" class="evenListRowS1" scope="row" colspan="3"><b>TOTAL UNITS : </b>&nbsp;&nbsp;&nbsp;&nbsp; </td>
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><b><?php echo number_format($this->subjTotal,1); ?> </b></td>
	</tr>
	<!-- End of registrant Listing -->
</tbody>
</table>
<?php endforeach; ?>