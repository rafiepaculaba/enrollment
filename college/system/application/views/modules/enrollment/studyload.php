<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>STUDYLOAD</h2></td>
	</tr>
</tbody>
</table>
<!--<br>-->
<?php  $current_user = $_SESSION['current_user']; 
		foreach ($current_user as $row)	:
?>
<!--<table width="100%" border="0">
  <tr>
    <td><input class="button" name="cmdprint" type="button" id="cmdprint" value="Print"/></td>
  </tr>
</table>  
-->
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="10" align="left"><h4 class="tabDetailViewDL">Studyload</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="15%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="20%"><slot> 
		<?php 
			$enrollment = $this->User_model->retrieveEnrollment($row->idno);
			if($enrollment){
				echo $enrollment[0]->schYear;	
			}
		?>
        </slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="20%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
    </tr>
     <tr>
        <td class="tabDetailViewDL"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->idno; ?> </slot></td>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>&nbsp; </slot></td>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" valign="bottom"><slot>Student Name :</slot> </td>
        <td colspan="5" valign="bottom">
        
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%" class="tabDetailViewDF"><slot><?php echo $row->lname; ?></slot>&nbsp;,</td>
                <td width="30%" class="tabDetailViewDF"><slot><?php echo $row->fname; ?></slot>&nbsp;</td>
                <td width="40%" class="tabDetailViewDF"><slot><?php echo $row->mname; ?></slot>&nbsp;</td>
            </tr>
            </table>
         </td>    
    </tr>
    <tr>
        <td class="tabDetailViewDL">&nbsp;</td>
        <td class="tabDetailViewDL" colspan="5" valign="top" height="40">
        
           <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%" align="left">Last Name</td>
                <td width="30%" align="left">First Name</td>
                <td width="40%" align="left">Middle Name</td>
            </tr>
            </table>
        
        </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Year Level :</slot></td>
        <td class="tabDetailViewDF" > <slot><?php echo $row->yrLevel; ?></slot>  </td>
        <td class="tabDetailViewDL" ><slot>Section / Block :</slot></td>
        <td class="tabDetailViewDF" ><slot>
        <?php
        	if ($enrollment) {
	         	$block_section = $this->User_model->retrieveBlockSection($enrollment[0]->secID);
	         	if($block_section){
					echo $block_section[0]->secName;				
	         	}				
			}
		?>
        &nbsp;</slot></td>
       <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td> 
    </tr>
</table>
</p>



<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="10%" nowrap>Code</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Course</td>
		<td scope="col" class="listViewThS1" width="40%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Time</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Days</td>
		<td scope="col" class="listViewThS1" width="5%" nowrap>Room</td>
	</tr>
    	<!-- Start of registrant Listing -->
    <?php  
    	if ($enrollment) {
	    	$enrollment_detail = $this->User_model->retrieveEnrollmentDetail($enrollment[0]->enID);
		 	foreach ($enrollment_detail as $enrollment_detail) {
		 		
		 		$schedules = $this->User_model->retrieveSchedules($enrollment_detail->schedID);
	?>
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $schedules[0]->schedCode; ?></td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">
		<?php  
			$course = $this->User_model->retrieveCourse($schedules[0]->courseID);
		   		echo $course[0]->courseCode;
		?>
		</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">
		<?php  
			$subject = $this->User_model->retrieveSubjects($schedules[0]->subjID);
		   		echo $subject[0]->subjCode.'&nbsp;&nbsp; &#45; &nbsp;&nbsp;'.substr($subject[0]->descTitle,0,50);
		?>
		</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><?php echo date("g:i" , strtotime($schedules[0]->startTime)); ?>-<?php echo date("g:i" , strtotime($schedules[0]->endTime))?>&nbsp;<?php echo date("A")?></td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">
		<?php
		$this->days = '';
		if($schedules[0]->onMon) {
			$this->days =  "M";
		} 
		
		if($schedules[0]->onTue) {
			if($schedules[0]->onThu) {
				$this->days .=  "T";
			} else {
				$this->days .=  "Tue";
			}
		} 
		
		if($schedules[0]->onWed) {
			$this->days .=  "W";
		} 
		
		if($schedules[0]->onThu) {
			if($schedules[0]->onTue) {
				$this->days .=  "Th";
			} else {
				$this->days .=  "Thu";
			}
		} 
		
		if($schedules[0]->onFri) {
			$this->days .=  "F";
		} 
		
		if($schedules[0]->onSat) {
			$this->days .=  "Sat";
		} 
		
		if($schedules[0]->onSun) {
			$this->days .=  "Sun";
		}
		
		echo $this->days;
		
		?>
		</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $schedules[0]->room; ?></td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php 
		 	$this->subjTotal += $subject[0]->units;
		 	}
    	}
	?>
	<!-- End of registrant Listing -->
	</tbody>
</table>

<?php endforeach; ?>
