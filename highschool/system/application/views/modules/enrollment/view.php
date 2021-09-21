<form name="frmEditReservation" id="frmEditReservation" action="index.php?enrollment/edit" method="POST">
<input type="hidden" name="resID" id="resID" value="<?php echo $resID; ?>">
<p>
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdEdit" type="button" id="cmdEdit" value=" Edit "/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel "/>
  </tr>
</table> 
<?php  $current_user = $_SESSION['current_user']; 
		foreach ($current_user as $row)	:
?>
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="10" align="left"><h4 class="tabDetailViewDL"></h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="15%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="20%"><slot><?php echo $schYear; ?></slot><input type="hidden" name="schYear" id="schYear" value="<?php echo $schYear; ?>"></td>
        <td class="tabDetailViewDL" width="15%"><slot>Semester :</slot></td>
        <td class="tabDetailViewDF" width="20%"><slot>
        <?php 
        switch ($semCode) {
         	case 1:
         		echo "1<sup>st</sup>";
         		break;
         	case 2:
         		echo "2<sup>nd</sup>";
         		break;
         	case 4:
         		echo "Summer";
         		break;
         } 
		?>
        </slot><input type="hidden" name="semCode" id="semCode" value="<?php echo $semCode; ?>"></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
    </tr>
     <tr>
        <td class="tabDetailViewDL"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $idno; ?></slot><input type="hidden" name="idno" id="idno" value="<?php echo $idno; ?>"></td>
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
                <input type="hidden" name="lname" id="lname" value="<?php echo $row->lname; ?>">
                <input type="hidden" name="fname" id="fname" value="<?php echo $row->fname; ?>">
                <input type="hidden" name="mname" id="mname" value="<?php echo $row->mname; ?>">
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
        <td class="tabDetailViewDL"><slot>Course :</slot></td>
        <td class="tabDetailViewDF" > <slot>
        <?php 
        	$course = $this->User_model->retrieveCourse($row->courseID);
        	echo $course[0]->courseCode; 
        ?></slot>  </td>
        <td class="tabDetailViewDL"><slot>Year Level :</slot></td>
        <td class="tabDetailViewDF" > <slot><?php echo $yrLevel; ?></slot>  </td>
        <td class="tabDetailViewDL"><slot> </slot></td>
        <td class="tabDetailViewDL"><slot> </slot></td>
    </tr>
</table>
</p>

<!-------------------------------------- displays class schedules -------------------------------------->
<br>
<div id="div11" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">Subject</th>
		<th class="dataField" align="left">Descriptive Title</th>
		<th class="dataField" align="left">Units</th>
		<th class="dataField" align="left">Section</th>
		<th class="dataField" align="left">Schedule</th>
		<th class="dataField" align="left">Room</th>
		<th class="dataField" align="left">Teacher</th>
	</tr>
	<?php 
	 	//retrieving reservation details
	 	$this->db->where('resID', $resID);
		$schedule = $this->Reservation_detail_model->retrieveAll();
		if ($schedule) {	 	
	    	foreach ($schedule as $subj) {
	?>	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%">
		<?php 
			$subject = $this->User_model->retrieveSubjects($subj->subjID);
			echo $subject[0]->subjCode;
		?></td>
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="30%"><?php echo $subject[0]->descTitle; ?></td>
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="5%"><?php echo $subject[0]->units; ?></td>
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%">
		<?php 
			if ($subj->secID) {
				$block_section = $this->User_model->retrieveBlockSection($subj->secID);
				echo $block_section[0]->secName;
			}
		?>
		</td>
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="15%">
		<?php
		$schedule = $this->User_model->retrieveSchedules($subj->schedID);
		
		$this->days = '';
		if($schedule[0]->onMon) {
			$this->days =  "M";
		} 
		
		if($schedule[0]->onTue) {
			if($schedule[0]->onThu) {
				$this->days .=  "T";
			} else {
				$this->days .=  "Tue";
			}
		} 
		
		if($schedule[0]->onWed) {
			$this->days .=  "W";
		} 
		
		if($schedule[0]->onThu) {
			if($schedule[0]->onTue) {
				$this->days .=  "Th";
			} else {
				$this->days .=  "Thu";
			}
		} 
		
		if($schedule[0]->onFri) {
			$this->days .=  "F";
		} 
		
		if($schedule[0]->onSat) {
			$this->days .=  "Sat";
		} 
		
		if($schedule[0]->onSun) {
			$this->days .=  "Sun";
		}
		
		echo $this->days;
		
		?>
		<?php echo date("g:i" , strtotime($schedule[0]->startTime)); ?>-<?php echo date("g:i" , strtotime($schedule[0]->endTime)); ?>&nbsp;<?php echo date("A"); ?>
		</td>
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="5%"><?php echo $schedule[0]->room; ?></td>
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="15%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<!-- End of registrant Listing -->
	<?php 
			$this->subjTotal += $subject[0]->units;
		 	}
		 }
	?>
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total units advised for this term : </b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"> <b><?php echo number_format($this->subjTotal,1); $this->subjTotal=0;?></b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
	</tr>
</tbody></table>
</div>
</form>
<?php endforeach; ?>


<script language="javascript">
$('#cmdEdit').click(
 	function() {
 		
	    if (check_form('frmEditReservation')) {
	    	document.getElementById('frmEditReservation').submit();
	    }
 	}
);
</script>