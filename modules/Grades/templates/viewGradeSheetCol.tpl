<p>

<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Grades&action=listGradesheetsCol');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdEdit" type="button" id="cmdEdit" value="Edit" onclick="redirect('index.php?module=Grades&action=editGradeSheetCol&gsID={$gsID}');" />
    {/if}
        
    {if $hasDelete eq 1 }
	<input class="button" name="cmdDelete" type="button" id="cmdDelete" value="Delete" onclick="deleteGradeSheet('{$gsID}');" />
    {/if}
    
    {if $hasApprove eq 1 }
	<input class="button" name="cmdApprove" type="button" id="cmdApprove" value="Approve" onclick="approveGradeSheet('{$gsID}');" />
    {/if}
    
    {if $hasPost eq 1 }
	<input class="button" name="cmdPost" type="button" id="cmdPost" value="Post to TOR" onclick="postGradeSheet('{$gsID}');" />
    {/if}
  </tr>
</table> 

<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDF" colspan="5" align="left"><h4 class="tabDetailViewDL">College Grade Sheet: ({$status})</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="30%"><slot> {$schYear}</slot></td>
        <td class="tabDetailViewDL" width="20%"><slot>Semester :</slot></td>
        <td class="tabDetailViewDF" width="30%"><slot> {$semCode}</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Instructor :</slot></td>
        <td class="tabDetailViewDF" colspan="3"><slot>{$instructor}</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Sched Code :</slot></td>
        <td class="tabDetailViewDF" colspan="3"><slot>{$schedCode}</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Subject :</slot></td>
        <td class="tabDetailViewDF" colspan="3"><slot>{$subject}</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Units :</slot></td>
        <td class="tabDetailViewDF"><slot>{$units}</slot></td>
        <td class="tabDetailViewDL"><slot>Room :</slot></td>
        <td class="tabDetailViewDF"><slot>{$room}</slot> </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Time :</slot></td>
        <td class="tabDetailViewDF"><slot>{$time}</slot> </td>
        <td class="tabDetailViewDL"><slot>Days :</slot></td>
        <td class="tabDetailViewDF"><slot>{$days}</slot> </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" valign="top"><slot>Remarks :</slot></td>
        <td class="tabDetailViewDF" colspan="3"><slot>{$remarks}</slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
	    <td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
	    <td scope="col" class="listViewThS1" width="5%" nowrap>Prelim</td>
	    <td scope="col" class="listViewThS1" width="5%" nowrap>Midterm</td>
	    <td scope="col" class="listViewThS1" width="5%" nowrap>Pre-Final</td>
	    <td scope="col" class="listViewThS1" width="5%" nowrap>Final</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>ID No.</td>
		<td scope="col" class="listViewThS1" width="40%" nowrap>Student Name</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Course</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Year</td>
	</tr>
	
	 {php}  $ctr=1; {/php}
	 {section name=i loop=$list}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{php} echo  $ctr; {/php}.</td>
		
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].pregrade}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].mgrade}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].prefigrade}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].fgrade}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].idno}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].lname}, {$list[i].fname} {$list[i].mname}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].courseCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].yrLevel}</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	{php}  $ctr++; {/php}
	<!-- End of registrant Listing -->
	{/section}
	
</tbody>
</table>