<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>CURRENT GRADES</h2></td>
	</tr>
</tbody>
</table>

<p>

<?php  $current_user = $_SESSION['current_user']; 
		foreach ($current_user as $row)	:
?>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <th class="tabDetailViewDL" colspan="4" align="center"><h4 class="tabDetailViewDL">Current Grades</h4></th>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="30%"><slot>
		<?php 
			$enrollment = $this->User_model->retrieveEnrollment($row->idno);
			if($enrollment){
		    	echo $enrollment[0]->schYear; 
			}
		?>
        </slot></td>
        <td class="tabDetailViewDL" width="20%"><slot>Grade :</slot></td>
        <td class="tabDetailViewDF" width="30%"><slot><?php echo $row->yrLevel; ?></slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->idno; ?></slot></td>
        <td class="tabDetailViewDL" width="20%"><slot>Section/Block :</slot></td>
        <td class="tabDetailViewDF" width="30%"><slot>
        <?php
        	if ($enrollment) {
	         	$block_section = $this->User_model->retrieveBlockSection($enrollment[0]->secID);
	         	if($block_section){
					echo $block_section[0]->secName;				
	         	}				
			}
		?>
        </slot> </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF" colspan="3"><slot><?php echo $row->lname.', '.$row->fname.' '.$row->mname; ?></slot></td>
    </tr>
    
    
    </table>
</td></tr>
</table>
</p>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
	    <td scope="col" class="listViewThS1" width="5%" nowrap>1<sup>st</sup> </td>
	    <td scope="col" class="listViewThS1" width="5%" nowrap>2<sup>nd</sup> </td>
	    <td scope="col" class="listViewThS1" width="5%" nowrap>3<sup>rd</sup> </td>
	    <td scope="col" class="listViewThS1" width="5%" nowrap>4<sup>th</sup> </td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Subject Code</td>
		<td scope="col" class="listViewThS1" width="30%" nowrap>Descriptive Title</td>
<!--		<td scope="col" class="listViewThS1" width="20%" nowrap>Instructor</td>-->
		<td scope="col" class="listViewThS1" width="10%" nowrap>Schedule</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Days</td>
		<td scope="col" class="listViewThS1" width="5%" nowrap>Room</td>
		<td scope="col" class="listViewThS1" width="5%" nowrap>Units</td>
	</tr>
	
	<!-- Start of registrant Listing -->
	<?php
		if($enrollment){
			$grades = $this->User_model->retrieveEnrollmentDetail($enrollment[0]->enID);
	    	foreach ($grades as $value) {
	    		if ($value) {
	?>
	
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $value->firstgrade; ?></td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $value->secondgrade; ?></td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $value->thirdgrade; ?></td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $value->fourthgrade; ?></td>
		
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
		
	<!--	<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"></td>-->
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">
		<?php 
			$schedules = $this->User_model->retrieveSchedules($value->schedID);
				echo date("g:i" , strtotime($schedules[0]->startTime)); ?>-<?php echo date("g:i" , strtotime($schedules[0]->endTime))?>&nbsp;<?php echo date("A")
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
        align="left" bgcolor="#fdfdfd" valign="top">
		<?php echo $schedules[0]->room; ?>
		</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $subject[0]->units; ?></td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php 
				$this->subjTotal += $subject[0]->units;
				} 
			}
		}
	?>
	<tr>
		<td bgcolor="#fdfdfd" align="right" valign="top" class="evenListRowS1" scope="row" colspan="9"><b>TOTAL UNITS : </b>&nbsp;&nbsp;&nbsp;&nbsp; </td>
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><b><?php echo number_format($this->subjTotal,1); ?></b></td>
	</tr>

	<!-- End of registrant Listing -->
</tbody>
</table>

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <th class="tabDetailViewDL" colspan="4" align="center"><h4 class="tabDetailViewDL">Behavioral Assessments</h4></th>
    <tr>
        <td class="tabDetailViewDF" colspan="4"><slot>
        <ul type="square"><li>Helpful</li></ul> 
        <ul type="square"><li>Respectful</li></ul> 
        <ul type="square"><li>Polite</li></ul> 
        <ul type="square"><li>Diligent</li></ul> 
        <ul type="square"><li>Participative</li></ul> 
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>
<?php endforeach; ?>