<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>FORM 137-A</h2></td>
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
    <th class="tabDetailViewDL" colspan="4" align="center"><h4 class="tabDetailViewDL">FORM 137-A</h4></th>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot><?php echo $row->idno; ?> &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot><?php echo $row->lname.', '.$row->fname.' '. $row->mname; ?> &nbsp;</slot></td>
    </tr>
	</table>
</td></tr>
</table>
</p>


<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
	    <td scope="col" class="listViewThS1" width="15%" nowrap>SUBJECT CODE</td>
	    <td scope="col" class="listViewThS1" width="40%" nowrap>DESCRIPTIVE TITLE</td>
	    <td scope="col" class="listViewThS1" width="8%" nowrap>1<sup>st</sup> </td>
	    <td scope="col" class="listViewThS1" width="8%" nowrap>2<sup>nd</sup> </td>
	    <td scope="col" class="listViewThS1" width="8%" nowrap>3<sup>rd</sup> </td>
	    <td scope="col" class="listViewThS1" width="8%" nowrap>4<sup>th</sup> </td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>FINAL</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>UNITS</td>
	</tr>
	<!-- Start of registrant Listing -->
	<?php 
		$yrLevel = $this->User_model->retrieveYrLevel($row->idno);
		foreach ($yrLevel as $yrLevel) {
			$subj = $this->User_model->retrieveEnrollmentDetail($yrLevel->enID);
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
        switch ($yrLevel->yrLevel) {
         	case 1:
         		echo "Grade 1";
         		break;
         	case 2:
         		echo "Grade 2";
         		break;
         	case 3:
         		echo "Grade 3";
         		break;
         	case 4:
         		echo "Grade 4";
         		break;     
         	case 5:
         		echo "Grade 5";
         		break;     	
         	case 6:
         		echo "Grade 6";
         		break; 	
         	case 7:
         		echo "Grade 7";
         		break; 
         } 
		?> - 
		 <?php
        	if ($yrLevel) {
	         	$block_section = $this->User_model->retrieveBlockSection($yrLevel->secID);
	         	if($block_section){
					echo $block_section[0]->secName;				
	         	}				
			}
		?>
		</b></u>
		</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><b><u>
		S.Y. <?php echo $yrLevel->schYear; ?> </b></u>
		</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php  
		$subj = $this->User_model->retrieveEnrollmentDetail($yrLevel->enID);
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
        	$grade = $this->User_model->retrieveForm137($row->idno,$value->subjID);	
        	if($grade) {
        		echo $grade[0]->firstgrade; 
        	}
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
			if($grade) {
				echo $value->secondgrade;
			}
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
			if($grade) {
				echo $value->thirdgrade;
			}
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
			if($grade) {
				echo $value->fourthgrade;
			}
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
		<td bgcolor="#fdfdfd" align="right" valign="top" class="evenListRowS1" scope="row" colspan="7"><b>TOTAL UNITS : </b>&nbsp;&nbsp;&nbsp;&nbsp; </td>
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