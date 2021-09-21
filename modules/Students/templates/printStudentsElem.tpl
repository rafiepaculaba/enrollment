<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap" align="right">
		&nbsp;
    		<div id="myDiv" name="myDiv" style="display:block">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<td nowrap="nowrap" align="right"><input type="button" class="button" value="Print Now" id="cmdPrint" name="cmdPrint" onclick="printNow();" />
            		&nbsp;&nbsp;<input type="button" class="button" value="Close" id="cmdClose" name="cmdClose" onclick="javascript: window.close();" /></td>
            	</tr>
            </table>
            </div>
		</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="" colspan="4" align="center">
        <slot>
        {$schName}<br>{$schAddress}<br>{$schContact}
        </slot>
        <br><br>
        </td>
    </tr>
     <tr><th  colspan="4" align="center"><br><b><u>Elementary Students</u></b> <br><br></th></tr>
</table>    

<p>
<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="15%" nowrap><b>ID No.</b></td>
		<td scope="col" class="listViewThS1" width="25%" nowrap><b>Last Name</b></td>
		<td scope="col" class="listViewThS1" width="25%" nowrap><b>First Name</b></td>
		<td scope="col" class="listViewThS1" width="25%" nowrap><b>Middle Name</b></td>
		<td scope="col" class="listViewThS1" width="10%" nowrap><b>Grade</b></td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	{section name=i loop=$list}
	<!-- Start of students Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].idno}</span></td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].lname}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].fname}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].mname}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" valign="top">{$list[i].yrLevel}</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of student Listing -->
	{/section}
</tbody>
</table>

</p>

