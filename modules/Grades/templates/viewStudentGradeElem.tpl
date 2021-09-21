<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Grades&action=listEnrollmentsElem');" />
    
	<input class="button" name="cmdprint" type="button" id="cmdprint" value="Print" onclick="popUp('index.php?module=Grades&action=printStudentGradeElem&enID={$enID}&sugar_body_only=1');" />
    
  </tr>
</table> 

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="10" align="left"><h4 class="tabDetailViewDL">Final Grade</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="15%" height="40"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="20%"><slot>{$schYear} </slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="20%"><slot>&nbsp; </slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
    </tr>
     <tr>
        <td class="tabDetailViewDL"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF"><slot>{$idno} </slot></td>
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
                <td width="30%" class="tabDetailViewDF"><slot>{$lname}</slot>&nbsp;,</td>
                <td width="30%" class="tabDetailViewDF"><slot>{$fname}</slot>&nbsp;</td>
                <td width="40%" class="tabDetailViewDF"><slot>{$mname}</slot>&nbsp;</td>
            </tr>
            </table>
        
        </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL">&nbsp;</td>
        <td class="tabDetailViewDL" colspan="5" valign="top" height="40">
        
           <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%">Last Name</td>
                <td width="30%">First Name</td>
                <td width="40%">Middle Name</td>
            </tr>
            </table>
        
        </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Grade :</slot></td>
        <td class="tabDetailViewDF"> <slot>{$yrLevel}</slot>  </td>
        <td class="tabDetailViewDL"><slot>Section :</slot></td>
        <td class="tabDetailViewDF"><slot>{$secName}&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL"> <slot>&nbsp;</slot>  </td>
    </tr>
</table>
</p>



<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap>Code</td>
		<td scope="col" class="listViewThS1" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" nowrap>Title</td>
		<td scope="col" class="listViewThS1" nowrap>1st</td>
		<td scope="col" class="listViewThS1" nowrap>2nd</td>
		<td scope="col" class="listViewThS1" nowrap>3rd</td>
		<td scope="col" class="listViewThS1" nowrap>4th</td>
		<td scope="col" class="listViewThS1" nowrap>Final</td>
	</tr>
    {section name=i loop=$scheds}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].schedCode}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].firstgrade}&nbsp;</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].secondgrade}&nbsp;</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].thirdgrade}&nbsp;</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].fourthgrade}&nbsp;</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].fgrade}</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
</tbody>
</table>