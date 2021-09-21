
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>MY PROSPECTUS</h2></td>
	</tr>
</tbody>
</table>

<?php  $current_user = $_SESSION['current_user']; 
		foreach ($current_user as $row)	:
?>


<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="10%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="50%" nowrap>Descriptive Title</td>
		<td scope="col" class="listViewThS1" width="40%" nowrap>Units</td>
	</tr>
</tbody>
</table>
<!-------------------------------------- Nursery 1 -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div1Handle" onclick="hideShowDiv('div1');" />&nbsp; 
	        Nursery 1
	    </h4></th>
	</tr>
</table>
<div id="div1" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<!-- Start of registrant Listing -->
	<?php
		$this->db->where('yrLevel', 1);
		$this->subject1 = $this->User_model->retrieveAllSubjects();
		
		foreach ($this->subject1 as $curriculum_subject) {
			if (count($this->subject1) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition);	
				if ($this->enrollment){
					$enID1 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID1);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj1_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj1_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkForm137($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj1_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getForm137($this->enroll[0]->idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row->subjID;
                			} else {
                				$passed_subjects .= ",".$row->subjID;
                			}
                			$r++;
                		}
                	}
			 	}
	?>
	                               
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj1_legend[$this->ctr]) { echo $this->subj1_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj1_legend[$this->ctr]) { echo $this->subj1_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj1_legend[$this->ctr]) { echo $this->subj1_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj1_legend[$this->ctr]) { echo $this->subj1_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php 
				$this->subjTotal += $subject[0]->units;
				}
			}
			$this->ctr++;
		}
	?>
	<!-- End of registrant Listing -->

	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b><?php echo number_format($this->subjTotal,1); $this->subjTotal=0;?></b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
<!-------------------------------------- Nursery 2 -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div2Handle" onclick="hideShowDiv('div2');" />&nbsp; 
	        Nursery 2
	    </h4></th>
	</tr>
</table>
<div id="div2" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<!-- Start of registrant Listing -->
	<?php
		$this->db->where('yrLevel', 2);
		$this->subject1 = $this->User_model->retrieveAllSubjects();
		
		foreach ($this->subject1 as $curriculum_subject) {
			if (count($this->subject1) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition);	
				if ($this->enrollment){
					$enID2 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID2);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj2_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj2_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkForm137($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	//check for taken subjects
	            	$this->subj2_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getForm137($this->enroll[0]->idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row->subjID;
                			} else {
                				$passed_subjects .= ",".$row->subjID;
                			}
                			$r++;
                		}
                	}
			 	}

	?>
	                               
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj2_legend[$this->ctr]) { echo $this->subj2_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj2_legend[$this->ctr]) { echo $this->subj2_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj2_legend[$this->ctr]) { echo $this->subj2_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj2_legend[$this->ctr]) { echo $this->subj2_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php 
				$this->subjTotal += $subject[0]->units;
				}
			}
			$this->ctr++;
		}
	?>
	<!-- End of registrant Listing -->

	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b><?php echo number_format($this->subjTotal,1); $this->subjTotal=0;?></b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>

<!-------------------------------------- Kinder 1 -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div3Handle" onclick="hideShowDiv('div3');" />&nbsp; 
	        Kinder 1
	    </h4></th>
	</tr>
</table>
<div id="div3" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<!-- Start of registrant Listing -->
	<?php

		$this->db->where('yrLevel', 3);
		$this->subject3 = $this->User_model->retrieveAllSubjects();
		
		foreach ($this->subject3 as $curriculum_subject) {
			if (count($this->subject3) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition);	
				if ($this->enrollment){
					$enID3 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID3);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj3_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj3_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkForm137($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	//check for taken subjects
	            	$this->subj3_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getForm137($this->enroll[0]->idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row->subjID;
                			} else {
                				$passed_subjects .= ",".$row->subjID;
                			}
                			$r++;
                		}
                	}
			 	}
	?>
	                               
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj3_legend[$this->ctr]) { echo $this->subj3_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj3_legend[$this->ctr]) { echo $this->subj3_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj3_legend[$this->ctr]) { echo $this->subj3_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj3_legend[$this->ctr]) { echo $this->subj3_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php 
				$this->subjTotal += $subject[0]->units;
				}
			}
			$this->ctr++;
		}
	?>
	<!-- End of registrant Listing -->

	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b><?php echo number_format($this->subjTotal,1); $this->subjTotal=0;?></b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>

<!-------------------------------------- GRADE 2 -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div4Handle" onclick="hideShowDiv('div4');" />&nbsp; 
	        Kinder 2
	    </h4></th>
	</tr>
</table>
<div id="div4" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<!-- Start of registrant Listing -->
	<?php

		$this->db->where('yrLevel', 4);
		$this->subject4 = $this->User_model->retrieveAllSubjects();
		
		foreach ($this->subject4 as $curriculum_subject) {
			if (count($this->subject4) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition);	
				if ($this->enrollment){
					$enID4 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID4);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj4_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj4_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkForm137($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	//check for taken subjects
	            	$this->subj4_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getForm137($this->enroll[0]->idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row->subjID;
                			} else {
                				$passed_subjects .= ",".$row->subjID;
                			}
                			$r++;
                		}
                	}
			 	}
	?>
	                               
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj4_legend[$this->ctr]) { echo $this->subj4_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj4_legend[$this->ctr]) { echo $this->subj4_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj4_legend[$this->ctr]) { echo $this->subj4_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj4_legend[$this->ctr]) { echo $this->subj4_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php 
				$this->subjTotal += $subject[0]->units;
				}
			}
			$this->ctr++;
		}
	?>
	<!-- End of registrant Listing -->

	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b><?php echo number_format($this->subjTotal,1); $this->subjTotal=0;?></b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>


<?php endforeach; ?>

<br>
<table class="listView2" border="0" cellpadding="0" cellspacing="0" width="300" align="right">
<tbody>
    <tr>
        <th colspan="2" align="left"><h4 class="tabDetailViewDL">Legend</h4></th>
    </tr>
    <tr>
		<td align="right">
		    <img src="images/colors.green.icon.gif" alt="green" style="margin: 0pt 3px;" border="0">
		</td>
		<td nowrap > Taken subject(s) </td>
	</tr>
	<tr>
		<td colspan="2" class="listViewHRS1" height="1"></td>
	</tr>
	<tr>
		<td align="right">
    		<img src="images/colors.ocher.icon.gif" alt="ocher" style="margin: 0pt 3px;" border="0">
		</td>
		<td nowrap > Currently enrolled subject(s) </td>
	</tr>
	<tr>
		<td colspan="2" class="listViewHRS1" height="1"></td>
	</tr>
	<tr>
		<td align="right">
    		<img src="images/colors.sugar.icon.gif" alt="ocher" style="margin: 0pt 3px;" border="0">
		</td>
		<td nowrap > Not yet taken subject(s) </td>
	</tr>
</tbody>
</table>

<script language="javascript">
function hideShowDiv(divName)
{
	
    if ( document.getElementById(divName).style.display=="Block" || document.getElementById(divName).style.display=="block" ) {
        document.getElementById(divName).style.display="None";
        document.getElementById(divName+"Handle").src="images/advanced_search.gif";
    } else {
        document.getElementById(divName).style.display="Block";
        document.getElementById(divName+"Handle").src="images/basic_search.gif";
    }
}
</script>
