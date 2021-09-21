<link href="css/style.css" rel="stylesheet" type="text/css" />
<link title="color:sugar" type="text/css" rel="stylesheet" href="css/colors.sugar.css?s=4.5.1g&c=" />
<link title="color:blue" type="text/css" rel="alternate stylesheet" href="css/colors.blue.css?s=4.5.1g&c="/>
<link title="color:green" type="text/css" rel="alternate stylesheet" href="css/colors.green.css?s=4.5.1g&c="/>
<link title="color:purple" type="text/css" rel="alternate stylesheet" href="css/colors.purple.css?s=4.5.1g&c="/>
<link title="color:ocher" type="text/css" rel="alternate stylesheet" href="css/colors.ocher.css?s=4.5.1g&c="/>
<link type="text/css" rel="stylesheet" href="css/fonts.normal.css" />
<link type="text/css" rel="stylesheet" href="css/message.css" />

<script src="javascript/menu.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/validate.js" type="text/javascript"></script>
<script src="javascript/cpd.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/style.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/cookie.js" type="text/javascript"></script>
<script src="javascript/jquery-1.2.6.js" type="text/javascript"></script>
<script src="javascript/validate.js" type="text/javascript"></script>
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>Offerings for 
		<?php 
			$subject = $this->User_model->retrieveSubjects($this->uri->segment(3));
				echo $subject[0]->subjCode;
		?>
		</h2></td>
	</tr>
</tbody>
</table>
<!-------------------------------------- displays schedules for the particular subject -------------------------------------->
<br>

<div id="div11" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">Section</th>
		<th class="dataField" align="left">Schedule</th>
		<th class="dataField" align="left">Room</th>
		<th class="dataField" align="left">Enrolled</th>
		<th class="dataField" align="left">Teacher</th>
	</tr>
	<?php  	
		
		$schedule = $this->User_model->retrieveSchedulesSubj($subject[0]->subjID);
    	foreach ($schedule as $sched) {
	?>
	<!-- Start of schedule Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%">
		 <?php
		 	$block_section = $this->User_model->retrieveAllSections();
		 	$block_section_details = $this->User_model->retrieveBlockSectionDetails($sched->schedID);
		 	if ($block_section_details) {
		 		$block_section_sched = $this->User_model->retrieveAllSections($block_section_details[0]->secID);
				if ($block_section_sched[0]->secName){
				 	echo $block_section_sched[0]->secName;
				}
		 	}
   	     ?>
		</td>
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="25%">
		<a class="listViewTdLinkS1" href="index.php?enrollment/refresher/<?php echo $sched->schedID; ?>/<?php echo $subject[0]->subjID; ?>/<?php 
    		if ($block_section_details) {
		 		$block_section_sched = $this->User_model->retrieveAllSections($block_section_details[0]->secID);
				if ($block_section_sched[0]->secName){
				 	echo $block_section_sched[0]->secID;
				}
		 	}
    	?>">
		<?php
		$this->days = '';
		if($sched->onMon) {
			$this->days =  "M";
		} 
		
		if($sched->onTue) {
			if($sched->onThu) {
				$this->days .=  "T";
			} else {
				$this->days .=  "Tue";
			}
		} 
		
		if($sched->onWed) {
			$this->days .=  "W";
		} 
		
		if($sched->onThu) {
			if($sched->onTue) {
				$this->days .=  "Th";
			} else {
				$this->days .=  "Thu";
			}
		} 
		
		if($sched->onFri) {
			$this->days .=  "F";
		}
		
		if($sched->onSat) {
			$this->days .=  "Sat";
		} 
		
		if($sched->onSun) {
			$this->days .=  "Sun";
		}
		
		echo $this->days;
		
		?>
		<?php echo date("g:i" , strtotime($sched->startTime)); ?>-<?php echo date("g:i" , strtotime($sched->endTime)); ?>&nbsp;<?php echo date("A"); ?>
		</a></td>
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><?php echo $sched->room; ?></td>
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><?php echo $sched->noEnrolled; ?>/<?php echo $sched->maxCapacity; ?></td>
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="30%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php 
	 	}
	?>
	<!-- End of schedule Listing -->
	
	</tbody></table>
</div>