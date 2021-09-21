
<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Schedules&action=listBlockSectionsPreschool');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Schedules&action=editBlockSectionPreschool&secID={$secID}');" />
    {/if}
        
    {if $hasDelete eq 1 }
	<input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteBlockSection('{$secID}');" />
    {/if}
  </tr>
</table> 

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Block Section 
        {if $status neq ""}
            ({$status})
        {/if}
        </h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="15%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="35%"><slot>{$schYear} </slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" width="35%"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Section Name :</slot></td>
        <td class="tabDetailViewDF"><slot>{$secName} </slot></td>
        <td class="tabDetailViewDL"><slot>Grade :</slot></td>
        <td class="tabDetailViewDF"><slot>{$yrLevel} </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>No. Enrolled :</slot></td>
        <td class="tabDetailViewDF"><slot>{$noEnrolled} </slot></td>
        <td class="tabDetailViewDL"><slot>Max Capacity :</slot></td>
        <td class="tabDetailViewDF"><slot>{$maxCapacity}</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot><!--Remarks-->Adviser  :</slot></td>
        <td class="tabDetailViewDF"><slot>{$remarks} </slot></td>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF"><slot>&nbsp;</slot></td>
    </tr>
</table>
</p>



<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="15%" nowrap>Code</td>
		<td scope="col" class="listViewThS1" width="30%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Time</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Days</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Room</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Units</td>
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
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].time}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].days}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].room}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].units}</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" colspan="5"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>{$total_units|number_format:1:".":","}</b></td>
	</tr>
	</tbody></table>
