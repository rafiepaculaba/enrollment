<form name="frmGradesheet" id="frmGradesheet" method="post" action="index.php?module=Grades&action=saveGradesheetHS">
<p>
<input type="hidden" id="gsID" name="gsID" value="{$gsID}" />
<input type="hidden" id="schedID" name="schedID" value="{$schedID}" />
<input type="hidden" id="theForm" name="theForm" value="gradesheet" />
<table border="0" width="100%">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Grades&action=viewGradeSheetHS&gsID={$gsID}')" />
    </td>
  </tr>
</table>  

<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDF" colspan="5" align="left"><h4 class="tabDetailViewDL">Edit High School Grade Sheet</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="30%"><slot> {$schYear}</slot></td>
        <td class="tabDetailViewDL" width="20%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" width="30%"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Teacher :</slot></td>
        <td class="tabDetailViewDF" colspan="3"><slot>{$teacher}</slot></td>
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
	    <td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
	    <td scope="col" class="listViewThS1" nowrap>1<sup>st</sup></td>
	    <td scope="col" class="listViewThS1" nowrap>2<sup>nd</sup></td>
	    <td scope="col" class="listViewThS1" nowrap>3<sup>rd</sup></td>
	    <td scope="col" class="listViewThS1" nowrap>4<sup>th</sup></td>
	    <td scope="col" class="listViewThS1" nowrap>Final</td>
		<td scope="col" class="listViewThS1" nowrap>ID No.</td>
		<td scope="col" class="listViewThS1" nowrap>Student Name</td>
		<td scope="col" class="listViewThS1" nowrap>Year</td>
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
        align="left" bgcolor="#fdfdfd" valign="top"><input type="text" size="10" maxlength="4" id="studfirst{$list[i].recID}" name="studfirst{$list[i].recID}" value="{$list[i].firstgrade}"  onkeypress="return keyRestrict(event, 2);" /></td>
	    
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><input type="text" size="10" maxlength="4" id="studsecond{$list[i].recID}" name="studsecond{$list[i].recID}" value="{$list[i].secondgrade}"  onkeypress="return keyRestrict(event, 2);" /></td>
	    
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><input type="text" size="10" maxlength="4" id="studthird{$list[i].recID}" name="studthird{$list[i].recID}" value="{$list[i].thirdgrade}"  onkeypress="return keyRestrict(event, 2);" /></td>

		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><input type="text" size="10" maxlength="4" id="studfourth{$list[i].recID}" name="studfourth{$list[i].recID}" value="{$list[i].fourthgrade}"  onkeypress="return keyRestrict(event, 2);" /></td>		
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><input type="text" size="10" maxlength="4" id="stud{$list[i].recID}" name="stud{$list[i].recID}" value="{$list[i].fgrade}"  onkeypress="return keyRestrict(event, 2);" /></td>
		
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
</form>