
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
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">My Prospectus</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Course :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot>
		<?php  
			$course = $this->User_model->retrieveCourse($row->courseID);
		   		echo $course[0]->courseCode; 
		?>
        </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Curriculum Name :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
        	$curriculum = $this->User_model->retrieveCurriculum($row->curID);
        	if($curriculum){
				echo $curriculum[0]->curName;
        	}
		?>
        &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Major :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
        	if($curriculum){
        		echo $curriculum[0]->major; 
        	}
        ?>&nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Effectivity Year :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
        	if($curriculum){
        		echo $curriculum[0]->effectivity; 
        	}
        ?>&nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Remarks :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
        	if($curriculum){
        		echo $curriculum[0]->remarks; 
        	}
        ?>&nbsp; </slot></td>
    </tr>
</table>
</p>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="10%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="50%" nowrap>Descriptive Title</td>
		<td scope="col" class="listViewThS1" width="40%" nowrap>Units</td>
	</tr>
</tbody>
</table>


<?php 
//		$curriculumDetail = $this->User_model->retrieveCurriculumDetail($curriculum[0]->curID);
?>
<!-------------------------------------- 1st Year 1st Semester -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div11Handle" onclick="hideShowDiv('div11');" />&nbsp; 
	        1<sup>st</sup> Year Level - 
			1<sup>st</sup> Semester
	    </h4></th>
	</tr>
</table>
<div id="div11" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<!-- Start of registrant Listing -->
	<?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 1);
		$this->db->where('semCode', 1);
		$this->subject11 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject11 as $curriculum_subject) {
			if (count($this->subject11) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj11_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj11_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj11_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj11_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	                               
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj11_legend[$this->ctr]) { echo $this->subj11_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj11_legend[$this->ctr]) { echo $this->subj11_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj11_legend[$this->ctr]) { echo $this->subj11_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj11_legend[$this->ctr]) { echo $this->subj11_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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


<!-------------------------------------- 1st Year 2nd Semester -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div12Handle" onclick="hideShowDiv('div12');" />&nbsp; 
	        1<sup>st</sup> Year Level - 
			2<sup>nd</sup> Semester
        </h4></th>
    </tr>
</table>
<div id="div12" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 1);
		$this->db->where('semCode', 2);
		$this->subject12 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject12 as $curriculum_subject) {
			if (count($this->subject12) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj12_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj12_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj12_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj12_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
    
	<!-- Start of registrant Listing -->
	
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj12_legend[$this->ctr]) { echo $this->subj12_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj12_legend[$this->ctr]) { echo $this->subj12_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj12_legend[$this->ctr]) { echo $this->subj12_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj12_legend[$this->ctr]) { echo $this->subj12_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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

<!-------------------------------------- 1st Year Summer -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div14Handle" onclick="hideShowDiv('div14');" />&nbsp; 
	        1<sup>st</sup> Year Level - 
			Summer
	    </h4></th>
	</tr>
</table>
<div id="div14" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<!-- Start of registrant Listing -->
	<?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 1);
		$this->db->where('semCode', 4);
		$this->subject14 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject14 as $curriculum_subject) {
			if (count($this->subject14) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj14_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj14_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj14_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj14_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	                               
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj14_legend[$this->ctr]) { echo $this->subj14_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj14_legend[$this->ctr]) { echo $this->subj14_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj14_legend[$this->ctr]) { echo $this->subj14_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj14_legend[$this->ctr]) { echo $this->subj14_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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
	
<!-------------------------------------- 2nd Year 1st Semester -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div21Handle" onclick="hideShowDiv('div21');" />&nbsp; 
	        2<sup>nd</sup> Year Level - 
			1<sup>st</sup> Semester
        </h4></th>
    </tr>
</table>
<div id="div21" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
     <?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 2);
		$this->db->where('semCode', 1);
		$this->subject21 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject21 as $curriculum_subject) {
			if (count($this->subject21) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj21_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj21_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj21_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj21_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	<!-- Start of registrant Listing -->
	
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj21_legend[$this->ctr]) { echo $this->subj21_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj21_legend[$this->ctr]) { echo $this->subj21_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj21_legend[$this->ctr]) { echo $this->subj21_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj21_legend[$this->ctr]) { echo $this->subj21_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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
<!-------------------------------------- 2nd Year 2nd Semester -------------------------------------->		
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div22Handle" onclick="hideShowDiv('div22');" />&nbsp; 
	        2<sup>nd</sup> Year Level - 
			2<sup>nd</sup> Semester
	    </h4></th>
	</tr>
</table>
<div id="div22" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 2);
		$this->db->where('semCode', 2);
		$this->subject22 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject22 as $curriculum_subject) {
			if (count($this->subject22) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj22_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj22_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj22_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj22_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	<!-- Start of registrant Listing -->
	
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj22_legend[$this->ctr]) { echo $this->subj22_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj22_legend[$this->ctr]) { echo $this->subj22_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj22_legend[$this->ctr]) { echo $this->subj22_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj22_legend[$this->ctr]) { echo $this->subj22_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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

<!-------------------------------------- 2nd Year Summer -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div24Handle" onclick="hideShowDiv('div24');" />&nbsp; 
	        2<sup>nd</sup> Year Level - 
			Summer
	    </h4></th>
	</tr>
</table>
<div id="div24" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<!-- Start of registrant Listing -->
	<?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 2);
		$this->db->where('semCode', 4);
		$this->subject24 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject24 as $curriculum_subject) {
			if (count($this->subject24) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj24_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj24_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj24_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj24_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	                               
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj24_legend[$this->ctr]) { echo $this->subj24_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj24_legend[$this->ctr]) { echo $this->subj24_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj24_legend[$this->ctr]) { echo $this->subj24_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj24_legend[$this->ctr]) { echo $this->subj24_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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

<!-------------------------------------- 3rd Year 1st Semester -------------------------------------->		
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div31Handle" onclick="hideShowDiv('div31');" />&nbsp; 
	        3<sup>rd</sup> Year Level - 
			1<sup>st</sup> Semester
        </h4></th>
    </tr>
</table>
<div id="div31" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 3);
		$this->db->where('semCode', 1);
		$this->subject31 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject31 as $curriculum_subject) {
			if (count($this->subject31) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj31_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj31_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj31_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj31_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	<!-- Start of registrant Listing -->
	
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj31_legend[$this->ctr]) { echo $this->subj31_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj31_legend[$this->ctr]) { echo $this->subj31_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj31_legend[$this->ctr]) { echo $this->subj31_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj31_legend[$this->ctr]) { echo $this->subj31_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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
<!-------------------------------------- 3rd Year 2nd Semester -------------------------------------->		
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div32Handle" onclick="hideShowDiv('div32');" />&nbsp; 
	        3 <sup>rd</sup> Year Level - 
			2 <sup>nd</sup> Semester
        </h4></th>
    </tr>
</table>
<div id="div32" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 3);
		$this->db->where('semCode', 2);
		$this->subject32 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject32 as $curriculum_subject) {
			if (count($this->subject32) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj32_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj32_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj32_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj32_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	<!-- Start of registrant Listing -->
	
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj32_legend[$this->ctr]) { echo $this->subj32_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj32_legend[$this->ctr]) { echo $this->subj32_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj32_legend[$this->ctr]) { echo $this->subj32_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj32_legend[$this->ctr]) { echo $this->subj32_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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

<!-------------------------------------- 3rd Year Summer -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div34Handle" onclick="hideShowDiv('div34');" />&nbsp; 
	        3<sup>rd</sup> Year Level - 
			Summer
	    </h4></th>
	</tr>
</table>
<div id="div34" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<!-- Start of registrant Listing -->
	<?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 3);
		$this->db->where('semCode', 4);
		$this->subject34 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject34 as $curriculum_subject) {
			if (count($this->subject34) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj34_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj34_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj34_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj34_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	                               
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj34_legend[$this->ctr]) { echo $this->subj34_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj34_legend[$this->ctr]) { echo $this->subj34_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj34_legend[$this->ctr]) { echo $this->subj34_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj34_legend[$this->ctr]) { echo $this->subj34_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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

<!-------------------------------------- 4th Year 1st Semester -------------------------------------->		
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div41Handle" onclick="hideShowDiv('div41');" />&nbsp; 
	        4<sup>th</sup> Year Level - 
			1<sup>st</sup> Semester
        </h4></th>
    </tr>
</table>
<div id="div41" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 4);
		$this->db->where('semCode', 1);
		$this->subject41 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject41 as $curriculum_subject) {
			if (count($this->subject41) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj41_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj41_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj41_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj41_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	<!-- Start of registrant Listing -->
	
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj41_legend[$this->ctr]) { echo $this->subj41_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj41_legend[$this->ctr]) { echo $this->subj41_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj41_legend[$this->ctr]) { echo $this->subj41_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj41_legend[$this->ctr]) { echo $this->subj41_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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
<!-------------------------------------- 4th Year 2nd Semester -------------------------------------->		
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div42Handle" onclick="hideShowDiv('div42');" />&nbsp; 
	        4<sup>th</sup> Year Level - 
			2<sup>nd</sup> Semester
        </h4></th>
    </tr>
</table>
<div id="div42" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    <?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 4);
		$this->db->where('semCode', 2);
		$this->subject42 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject42 as $curriculum_subject) {
			if (count($this->subject42) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj42_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj42_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj42_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj42_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	<!-- Start of registrant Listing -->
	
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj42_legend[$this->ctr]) { echo $this->subj42_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj42_legend[$this->ctr]) { echo $this->subj42_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj42_legend[$this->ctr]) { echo $this->subj42_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj42_legend[$this->ctr]) { echo $this->subj42_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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

<!-------------------------------------- 4th Year Summer -------------------------------------->
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="images/basic_search.gif" id="div44Handle" onclick="hideShowDiv('div44');" />&nbsp; 
	        4<sup>th</sup> Year Level - 
			Summer
	    </h4></th>
	</tr>
</table>
<div id="div44" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<!-- Start of registrant Listing -->
	<?php
		if($curriculum) {
			$this->currID = $curriculum[0]->curID;
		}
		$this->db->where('curID', $this->currID);
		$this->db->where('yrLevel', 4);
		$this->db->where('semCode', 4);
		$this->subject44 = $this->User_model->retrieveAllCurriculumSubj();
		
		foreach ($this->subject44 as $curriculum_subject) {
			if (count($this->subject44) > 0) {
			 	$subject = $this->User_model->retrieveSubjects($curriculum_subject->subjID);
			 	if ($subject){
			 	
			 	// conds for current enrollment
			 	$this->db->where('title', "School Year");
			 	$schYear = $this->User_model->retrieveConfigurations();
			 	
			 	$this->db->where('title', "Semester");
			 	$semCode = $this->User_model->retrieveConfigurations();
			 	
				$this->db->where('idno', $row->idno);
				$this->enroll = $this->User_model->retrieveAllEnrollment();	
				
				$this->db->order_by("enID", "desc"); 
				$this->db->limit(1);
				$this->enrollment = $this->User_model->retrieveEnrollments($this->enroll[0]->idno, $schYear[0]->definition, $semCode[0]->definition);	
				if ($this->enrollment){
					$enID11 = $this->enrollment[0]->enID;
					$this->db->where('enID', $enID11);
				}
				$this->db->where('subjID',$curriculum_subject->subjID);
			 	$this->subj44_legend[$this->ctr] = '';

				if ($this->User_model->retrieveAllEnrollmentDetail()) {
			        // check for current enrollment 
		            $this->subj44_legend[$this->ctr]="clsCurrentEnroll";
	            } else if ( $this->User_model->checkTORs($curriculum_subject->subjID, $this->enroll[0]->idno)) {
	            	$this->subj44_legend[$this->ctr]="clsTaken";
			 	} else {
			 		$myTOR =  $this->User_model->getTOR($this->enroll[0]->idno);
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
                			
                		if ($passed_subjects) {
	                		if ($this->User_model->checkEquivalence($curriculum_subject->subjID,$passed_subjects)) {
	                			$this->subj44_legend[$this->ctr]="clsTaken";
	                		}
                		}
                	}
			 	}
	?>
	                               
	<tr height="20">
		<td scope="row" class="<?php if ($this->subj44_legend[$this->ctr]) { echo $this->subj44_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->subjCode;?> </td>
		<td scope="row" class="<?php if ($this->subj44_legend[$this->ctr]) { echo $this->subj44_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->descTitle;?> </td>
		<td scope="row" class="<?php if ($this->subj44_legend[$this->ctr]) { echo $this->subj44_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%"><?php echo $subject[0]->units;?> </td>
		<td scope="row" class="<?php if ($this->subj44_legend[$this->ctr]) { echo $this->subj44_legend[$this->ctr]; } ?>" align="left" valign="top" width="10%">&nbsp;</td>
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
