
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3>&nbsp;</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
		<td nowrap="nowrap">
		&nbsp;
    		<div id="myDiv" name="myDiv" style="display:block">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<td nowrap="nowrap" align="right"><input type="button" class="button" value="Print Now" id="cmdPrint" name="cmdPrint" onclick="printNow();" /></td>
            		<td nowrap="nowrap" align="right">&nbsp;&nbsp;<input type="button" class="button" value="Close" id="cmdClose" name="cmdClose" onclick="javascript: window.close();" /></td>
            	</tr>
            </table>
            </div>
		</td>
	</tr>
</table>

<p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="tabDetailViewDL" colspan="6" align="center">
        <slot>
        {$schName}<br>{$schAddress}<br>{$schContact}
        </slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDF" colspan="5" align="left"><h4 class="tabDetailViewDL">Elementary Class Roster </h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="40%"><slot> {$schYear}</slot></td>
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

<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="5%" nowrap><b>No.</b></td>
		<td scope="col" class="listViewThS1" width="15%" nowrap><b>ID No.</b></td>
		<td scope="col" class="listViewThS1" width="55%" nowrap><b>Student Name</b></td>
		<td scope="col" class="listViewThS1" width="10%" nowrap><b>Year</b></td>
	</tr>
	{php}$ctr=1; {/php}
	 {section name=i loop=$list}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{php} echo $ctr; $ctr++;{/php} &nbsp;</td>

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
	<!-- End of registrant Listing -->
	{/section}
	
</tbody>
</table>