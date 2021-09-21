<form name="frmEditReservation" id="frmEditReservation" action="index.php?enrollment/edit" method="POST">
<input type="hidden" name="resID" id="resID" value="<?php echo $resID; ?>">
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>RESERVATION</h2></td>
	</tr>
</tbody>
</table>

<p>
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save "/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel "/>
  </tr>
</table> 
<?php  $current_user = $_SESSION['current_user']; 
		foreach ($current_user as $row)	:
?>
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="10" align="left"><h4 class="tabDetailViewDL">Edit Reservation</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="15%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="20%"><slot>
        <?php 
        	//get schYear
    		$this->db->where('configID', 5);
    		$schYear = $this->User_model->retrieveConfigurations();

    		//get semCode
    		$this->db->where('configID', 9);
    		$sem = $this->User_model->retrieveConfigurations();
    		
    		$reservation = $this->Reservation_model->retrieveReservations($schYear[0]->definition, $sem[0]->definition, $row->idno);
    		if($reservation) {
	    		echo $reservation[0]->schYear;
    		}
    	?>
       </td>
        <td class="tabDetailViewDL" width="15%"><slot>Semester :</slot></td>
        <td class="tabDetailViewDF" width="20%"><slot>
        <?php 
	        if($reservation) {
	        switch ($reservation[0]->semCode) {
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
	    }
		?>
        </slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
    </tr>
     <tr>
        <td class="tabDetailViewDL"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
        if($reservation) {
        	echo $reservation[0]->idno; 
        }
        ?></slot></td>
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
        <td class="tabDetailViewDL"><slot>Course :</slot></td>
        <td class="tabDetailViewDF" > <slot>
        <?php 
        	if($reservation) {
	        	$course = $this->User_model->retrieveCourse($reservation[0]->courseID);
	        	if($course) {
	        		echo $course[0]->courseCode; 
	        	}
        	}
        ?></slot>  </td>
        <td class="tabDetailViewDL"><slot>Year Level :</slot></td>
        <td class="tabDetailViewDF" > <slot>
        <?php 
        	if($reservation) {
        		echo $reservation[0]->yrLevel; 
        	}
        ?></slot>  </td>
        <td class="tabDetailViewDL"><slot> </slot></td>
        <td class="tabDetailViewDL"><slot> </slot></td>
    </tr>
</table>
</p>
<br>
<table class="" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/Subjects.gif"/></td>
		<td width="100%"><h2>Offered Subjects</h2></td>
	</tr>
</tbody>
</table>
<?php 
	$curriculum = $this->User_model->retrieveCurriculum($row->curID);
	
		$this->db->where('curID', $curriculum[0]->curID);
		$this->db->where('yrLevel', 1);
		$this->db->where('semCode', 1);
		$this->subject11 = $this->User_model->retrieveAllCurriculumSubj();
		if (count($this->subject11) > 0) {
?>
<!-------------------------------------- START: displays advised subjects for 1st yr 1st sem -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div11Handle" onclick="hideShowDiv('div11');" />&nbsp; 
	        1<sup>st</sup> Year Level - 1<sup>st</sup> Semester
	    </h4></th>
	</tr>
</table>

<div id="div11" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">&nbsp;</th>
		<th class="dataField" align="left">Subject</th>
		<th class="dataField" align="left">Descriptive Title</th>
		<th class="dataField" align="left">Units</th>
		<th class="dataField" align="left">Adviser</th>
	</tr>
	<?php
		foreach ($this->subject11 as $curriculum_subject) {
			if (count($this->subject11) > 0) {
				
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);

				if (!($this->User_model->checkTORs($curriculum_subject->subjID,$row->idno))) { 
	?>
					<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="2%"><img src="images/view.gif" border="0" align="absmiddle" id="viewSched<?php echo $subject[0]->subjID;?>" name="viewSched"></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><a class="listViewTdLinkS1" id="viewSchedA<?php echo $subject[0]->subjID;?>" name="viewSchedA"><?php echo $subject[0]->subjCode;?> </a></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="50%"><?php echo $subject[0]->descTitle;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="20" class="listViewHRS1" height="1"></td>
					</tr>
	<?php
			    	$this->subjTotal += $subject[0]->units;
				}
	?>
<script language="javascript">
    $('#viewSched<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules_edit/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
    $('#viewSchedA<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules_edit/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
</script>
	<!-- End of registrant Listing -->
	<?php 
				}
			}
		}
		$this->db->where('curID', $curriculum[0]->curID);
		$this->db->where('yrLevel', 1);
		$this->db->where('semCode', 2);
		$this->subject12 = $this->User_model->retrieveAllCurriculumSubj();
			
		if (count($this->subject12) > 0) {
	?>
</tbody></table>
</div>
<!-------------------------------------- END: displays advised subjects for 1st yr 1st sem -------------------------------------->


<!-------------------------------------- START: displays advised subjects for 1st yr 2nd sem -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div12Handle" onclick="hideShowDiv('div12');" />&nbsp; 
	        1<sup>st</sup> Year Level - 2<sup>nd</sup> Semester
	    </h4></th>
	</tr>
</table>

<div id="div12" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">&nbsp;</th>
		<th class="dataField" align="left">Subject</th>
		<th class="dataField" align="left">Descriptive Title</th>
		<th class="dataField" align="left">Units</th>
		<th class="dataField" align="left">Adviser</th>
	</tr>
	<?php
		foreach ($this->subject12 as $curriculum_subject) {
			if (count($this->subject12) > 0) {
				
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
				if ((!($this->User_model->checkTORs($curriculum_subject->subjID,$row->idno))) and (!($this->User_model->retrievePrerequisites($curriculum_subject->curID,$curriculum_subject->subjID)))) { 
	?>
					<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="2%"><img src="images/view.gif" border="0" align="absmiddle" id="viewSched<?php echo $subject[0]->subjID;?>" name="viewSched"></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><a class="listViewTdLinkS1" id="viewSchedA<?php echo $subject[0]->subjID;?>" name="viewSchedA"><?php echo $subject[0]->subjCode;?> </a></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="50%"><?php echo $subject[0]->descTitle;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="20" class="listViewHRS1" height="1"></td>
					</tr>
	<?php
			           $this->subjTotal += $subject[0]->units;
	            }
	?>
<script language="javascript">
    $('#viewSched<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules_edit/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
    $('#viewSchedA<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules_edit/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
</script>
	<!-- End of registrant Listing -->
	<?php 
				}
			}
		}
		$this->db->where('curID', $curriculum[0]->curID);
		$this->db->where('yrLevel', 2);
		$this->db->where('semCode', 1);
		$this->subject21 = $this->User_model->retrieveAllCurriculumSubj();
			
		if (count($this->subject21) > 0) {
	?>
	</tbody></table>
</div>
<!-------------------------------------- END: displays advised subjects for 1st yr 2nd sem -------------------------------------->


<!-------------------------------------- START: displays advised subjects for 2nd yr 1st sem -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div21Handle" onclick="hideShowDiv('div21');" />&nbsp; 
	        2<sup>nd</sup> Year Level - 1<sup>st</sup> Semester
	    </h4></th>
	</tr>
</table>

<div id="div21" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">&nbsp;</th>
		<th class="dataField" align="left">Subject</th>
		<th class="dataField" align="left">Descriptive Title</th>
		<th class="dataField" align="left">Units</th>
		<th class="dataField" align="left">Adviser</th>
	</tr>
	<?php
		foreach ($this->subject21 as $curriculum_subject) {
			if (count($this->subject21) > 0) {
				
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
				if ((!($this->User_model->checkTORs($curriculum_subject->subjID,$row->idno))) and (!($this->User_model->retrievePrerequisites($curriculum_subject->curID,$curriculum_subject->subjID)))) { 
	?>
					<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="2%"><img src="images/view.gif" border="0" align="absmiddle" id="viewSched<?php echo $subject[0]->subjID;?>" name="viewSched"></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><a class="listViewTdLinkS1" id="viewSchedA<?php echo $subject[0]->subjID;?>" name="viewSchedA"><?php echo $subject[0]->subjCode;?> </a></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="50%"><?php echo $subject[0]->descTitle;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="20" class="listViewHRS1" height="1"></td>
					</tr>
	<?php
			           $this->subjTotal += $subject[0]->units;
	            }
	?>
<script language="javascript">
    $('#viewSched<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
    $('#viewSchedA<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
</script>
	<!-- End of registrant Listing -->
	<?php 
				}
			}
		}
		$this->db->where('curID', $curriculum[0]->curID);
		$this->db->where('yrLevel', 2);
		$this->db->where('semCode', 2);
		$this->subject22 = $this->User_model->retrieveAllCurriculumSubj();
			
		if (count($this->subject22) > 0) {
	?>
	</tbody></table>
</div>
<!-------------------------------------- END: displays advised subjects for 2nd yr 1st sem -------------------------------------->


<!-------------------------------------- START: displays advised subjects for 2nd yr 2nd sem -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div22Handle" onclick="hideShowDiv('div22');" />&nbsp; 
	        2<sup>nd</sup> Year Level - 2<sup>nd</sup> Semester
	    </h4></th>
	</tr>
</table>

<div id="div22" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">&nbsp;</th>
		<th class="dataField" align="left">Subject</th>
		<th class="dataField" align="left">Descriptive Title</th>
		<th class="dataField" align="left">Units</th>
		<th class="dataField" align="left">Adviser</th>
	</tr>
	<?php
		foreach ($this->subject22 as $curriculum_subject) {
			if (count($this->subject22) > 0) {
				
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
				if ((!($this->User_model->checkTORs($curriculum_subject->subjID,$row->idno))) and (!($this->User_model->retrievePrerequisites($curriculum_subject->curID,$curriculum_subject->subjID)))) { 
	?>
					<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="2%"><img src="images/view.gif" border="0" align="absmiddle" id="viewSched<?php echo $subject[0]->subjID;?>" name="viewSched"></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><a class="listViewTdLinkS1" id="viewSchedA<?php echo $subject[0]->subjID;?>" name="viewSchedA"><?php echo $subject[0]->subjCode;?> </a></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="50%"><?php echo $subject[0]->descTitle;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="20" class="listViewHRS1" height="1"></td>
					</tr>
	<?php
			           $this->subjTotal += $subject[0]->units;
	            }
	?>
<script language="javascript">
    $('#viewSched<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
    $('#viewSchedA<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
</script>
	<!-- End of registrant Listing -->
	<?php 
				}
			}
		}
		$this->db->where('curID', $curriculum[0]->curID);
		$this->db->where('yrLevel', 3);
		$this->db->where('semCode', 1);
		$this->subject31 = $this->User_model->retrieveAllCurriculumSubj();
			
		if (count($this->subject31) > 0) {
	?>
	</tbody></table>
</div>
<!-------------------------------------- END: displays advised subjects for 2nd yr 2nd sem -------------------------------------->


<!-------------------------------------- START: displays advised subjects for 3rd yr 1st sem -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div31Handle" onclick="hideShowDiv('div31');" />&nbsp; 
	        3<sup>rd</sup> Year Level - 1<sup>st</sup> Semester
	    </h4></th>
	</tr>
</table>

<div id="div31" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">&nbsp;</th>
		<th class="dataField" align="left">Subjectsssss</th>
		<th class="dataField" align="left">Descriptive Title</th>
		<th class="dataField" align="left">Units</th>
		<th class="dataField" align="left">Adviser</th>
	</tr>
	<?php
		foreach ($this->subject31 as $curriculum_subject) {
			if (count($this->subject31) > 0) {
				
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
				if ((!($this->User_model->checkTORs($curriculum_subject->subjID,$row->idno))) and (!($this->User_model->retrievePrerequisites($curriculum_subject->curID,$curriculum_subject->subjID)))) { 
	?>
					<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="2%"><img src="images/view.gif" border="0" align="absmiddle" id="viewSched<?php echo $subject[0]->subjID;?>" name="viewSched"></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><a class="listViewTdLinkS1" id="viewSchedA<?php echo $subject[0]->subjID;?>" name="viewSchedA"><?php echo $subject[0]->subjCode;?> </a></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="50%"><?php echo $subject[0]->descTitle;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="20" class="listViewHRS1" height="1"></td>
					</tr>
	<?php
			           $this->subjTotal += $subject[0]->units;
	            }
	?>
<script language="javascript">
    $('#viewSched<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules_edit/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
    $('#viewSchedA<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules_edit/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
</script>
	<!-- End of registrant Listing -->
	<?php 
				}
			}
		}
		$this->db->where('curID', $curriculum[0]->curID);
		$this->db->where('yrLevel', 3);
		$this->db->where('semCode', 2);
		$this->subject32 = $this->User_model->retrieveAllCurriculumSubj();
			
		if (count($this->subject32) > 0) {
	?>
	</tbody></table>
</div>
<!-------------------------------------- END: displays advised subjects for 3rd yr 1st sem -------------------------------------->


<!-------------------------------------- START: displays advised subjects for 3rd yr 2nd sem -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div32Handle" onclick="hideShowDiv('div32');" />&nbsp; 
	        3<sup>rd</sup> Year Level - 2<sup>nd</sup> Semester
	    </h4></th>
	</tr>
</table>

<div id="div32" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">&nbsp;</th>
		<th class="dataField" align="left">Subject</th>
		<th class="dataField" align="left">Descriptive Title</th>
		<th class="dataField" align="left">Units</th>
		<th class="dataField" align="left">Adviser</th>
	</tr>
	<?php
		foreach ($this->subject32 as $curriculum_subject) {
			if (count($this->subject32) > 0) {
				
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
				if ((!($this->User_model->checkTORs($curriculum_subject->subjID,$row->idno))) and (!($this->User_model->retrievePrerequisites($curriculum_subject->curID,$curriculum_subject->subjID)))) { 
	?>
					<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="2%"><img src="images/view.gif" border="0" align="absmiddle" id="viewSched<?php echo $subject[0]->subjID;?>" name="viewSched"></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><a class="listViewTdLinkS1" id="viewSchedA<?php echo $subject[0]->subjID;?>" name="viewSchedA"><?php echo $subject[0]->subjCode;?> </a></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="50%"><?php echo $subject[0]->descTitle;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="20" class="listViewHRS1" height="1"></td>
					</tr>
	<?php
			           $this->subjTotal += $subject[0]->units;
	            }
	?>
<script language="javascript">
    $('#viewSched<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules_edit/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
    $('#viewSchedA<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules_edit/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
</script>
	<!-- End of registrant Listing -->
	<?php 
				}
			}
		}
		$this->db->where('curID', $curriculum[0]->curID);
		$this->db->where('yrLevel', 4);
		$this->db->where('semCode', 1);
		$this->subject41 = $this->User_model->retrieveAllCurriculumSubj();
			
		if (count($this->subject41) > 0) {
	?>
	</tbody></table>
</div>
<!-------------------------------------- END: displays advised subjects for 3rd yr 2nd sem -------------------------------------->


<!-------------------------------------- START: displays advised subjects for 4th yr 1st sem -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div41Handle" onclick="hideShowDiv('div41');" />&nbsp; 
	        4<sup>th</sup> Year Level - 1<sup>st</sup> Semester
	    </h4></th>
	</tr>
</table>

<div id="div41" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">&nbsp;</th>
		<th class="dataField" align="left">Subject</th>
		<th class="dataField" align="left">Descriptive Title</th>
		<th class="dataField" align="left">Units</th>
		<th class="dataField" align="left">Adviser</th>
	</tr>
	<?php
		foreach ($this->subject41 as $curriculum_subject) {
			if (count($this->subject41) > 0) {
				
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
				if ((!($this->User_model->checkTORs($curriculum_subject->subjID,$row->idno))) and (!($this->User_model->retrievePrerequisites($curriculum_subject->curID,$curriculum_subject->subjID)))) { 
	?>
					<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="2%"><img src="images/view.gif" border="0" align="absmiddle" id="viewSched<?php echo $subject[0]->subjID;?>" name="viewSched"></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><a class="listViewTdLinkS1" id="viewSchedA<?php echo $subject[0]->subjID;?>" name="viewSchedA"><?php echo $subject[0]->subjCode;?> </a></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="50%"><?php echo $subject[0]->descTitle;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="20" class="listViewHRS1" height="1"></td>
					</tr>
	<?php
			           $this->subjTotal += $subject[0]->units;
	            }
	?>
<script language="javascript">
    $('#viewSched<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
    $('#viewSchedA<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
</script>
	<!-- End of registrant Listing -->
	<?php 
				}
			}
		}
		$this->db->where('curID', $curriculum[0]->curID);
		$this->db->where('yrLevel', 4);
		$this->db->where('semCode', 2);
		$this->subject42 = $this->User_model->retrieveAllCurriculumSubj();
			
		if (count($this->subject42) > 0) {
	?>
	</tbody></table>
</div>
<!-------------------------------------- END: displays advised subjects for 4th yr 1st sem -------------------------------------->


<!-------------------------------------- START: displays advised subjects for 4th yr 2nd sem -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div42Handle" onclick="hideShowDiv('div42');" />&nbsp; 
	        4<sup>th</sup> Year Level - 2<sup>nd</sup> Semester
	    </h4></th>
	</tr>
</table>

<div id="div42" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">&nbsp;</th>
		<th class="dataField" align="left">Subject</th>
		<th class="dataField" align="left">Descriptive Title</th>
		<th class="dataField" align="left">Units</th>
		<th class="dataField" align="left">Adviser</th>
	</tr>
	<?php
		foreach ($this->subject42 as $curriculum_subject) {
			if (count($this->subject42) > 0) {
				
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
				if ((!($this->User_model->checkTORs($curriculum_subject->subjID,$row->idno))) and (!($this->User_model->retrievePrerequisites($curriculum_subject->curID,$curriculum_subject->subjID)))) { 
	?>
					<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="2%"><img src="images/view.gif" border="0" align="absmiddle" id="viewSched<?php echo $subject[0]->subjID;?>" name="viewSched"></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><a class="listViewTdLinkS1" id="viewSchedA<?php echo $subject[0]->subjID;?>" name="viewSchedA"><?php echo $subject[0]->subjCode;?> </a></td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="50%"><?php echo $subject[0]->descTitle;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
						<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="20" class="listViewHRS1" height="1"></td>
					</tr>
	<?php
			           $this->subjTotal += $subject[0]->units;
	            }
	?>
<script language="javascript">
    $('#viewSched<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
    $('#viewSchedA<?php echo $subject[0]->subjID;?>').click(
	    function() 
	    {
	        window.open('index.php?enrollment/schedules/<?php echo $subject[0]->subjID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=550,height=350,left=0,top=0');
	    }
    );
</script>
	<!-- End of registrant Listing -->
	<?php 
				}
			}
		}
	?>
	</tbody></table>
</div>
<!-------------------------------------- END: displays advised subjects for 4th yr 2nd sem -------------------------------------->

<!-------------------------------------- START: displays total units -------------------------------------->
<div id="div11" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="2%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total units : </b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b><?php echo number_format($this->subjTotal,1); $this->subjTotal=0;?></b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
</tbody></table>
</div>
<br>
<table class="" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/Schedules.gif"/></td>
		<td width="100%"><h2>Class Schedule</h2></td>
	</tr>
</tbody>
</table>
<!-------------------------------------- END: displays total units -------------------------------------->

<!-------------------------------------- displays class schedules -------------------------------------->
<br>
<div id="reserveSchedule" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr height="20">
		<th class="dataField" align="left">&nbsp;</th>
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
	 	$this->db->where('resID', $reservation[0]->resID);
		$schedule = $this->Reservation_detail_model->retrieveAll();
		if ($schedule) {	 	
	    	foreach ($schedule as $subj) {
	?>	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" align="left" valign="top" width="2%"><a name="removeSchedule"><img src="images/delete_inline.gif" border="0" align="absmiddle" id="removeSchedule"></a></td>
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
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total units advised for this term : </b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"> <b><?php echo number_format($this->subjTotal,1); $this->subjTotal=0;?></b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
	</tr>
</tbody></table>
</div>
</form>
<?php endforeach; ?>


<script language="javascript">

$('#cmdSave').click(
 	function() {
 		
	    if (check_form('frmEditReservation')) {
	    	document.getElementById('frmEditReservation').submit();
	    }
 	}
);

$('#removeSchedule').click(
function () {
		$.post(base_url+'index.php?enrollment/deleteSched/'+$('#$schedule[0]->resDetrailID').val(),
		  function(data){
		     document.getElementById('reserveSchedule').innerHTML = data;
		  }
		);
    }  
);

$('#cmdCancel').click(
    function() 
    {
    window.location='index.php?enrollment/view/<?php echo $this->Reservation_model->resID; ?>';
    }
);
</script>
