
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
    {if $logo == 1}
    <tr>
        <td align="center" colspan="6"><img src="themes/Sugar/images/logo_temp.jpg" height="70" width="70"/></td>
    </tr>
        {/if}
    <tr>
        <td class="tabDetailViewDL" colspan="6" align="center">
        <slot>
        	<b>{$schName}</b><br>{$schAddress}<br>{$schContact}
        </slot>
        </td>
    </tr>
    <tr><th  colspan="6" align="center"><br><b><u>Summary of Income: {$SEMCODE} {$SCHYEAR}</u></b> <br><br></th></tr>
    </table>
</td></tr>
</table>
</p>

<p>
<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
<tbody>
		<tr height="20">
			<td scope="col" class="listViewThS1" nowrap><b>Course</b> </td>
			{section name=i loop=$columns}
			<td scope="col" class="listViewThS1" nowrap><div align="right"><b>{$columns[i]}</b></div> </td>
			{/section}
			<td scope="col" class="listViewThS1" nowrap><div align="right"><b>Total</b></div> </td>
		</tr>
		
		{section name=i loop=$list}
		<!-- Start of registrant Listing -->
			<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
				
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].course}&nbsp;</td>
				
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="right" bgcolor="#fdfdfd" valign="top">{$list[i].Registration|number_format:2:".":","}&nbsp;</td>
				
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="right" bgcolor="#fdfdfd" valign="top">{$list[i].Tuition|number_format:2:".":","}&nbsp;</td>
				
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="right" bgcolor="#fdfdfd" valign="top">{$list[i].Miscellaneous|number_format:2:".":","}&nbsp;</td>
		
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="right" bgcolor="#fdfdfd" valign="top">{$list[i].Laboratory|number_format:2:".":","}&nbsp;</td>
		
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="right" bgcolor="#fdfdfd" valign="top">{$list[i].total|number_format:2:".":","}&nbsp;</td>
				
			</tr>
			<tr>
				<td colspan="20" class="listViewHRS1"></td>
			</tr>
		<!-- End of registrant Listing -->
		{/section}
		<tr>
			<td colspan="20" class="listViewHRS1"></td>
		</tr>
		
		<tr height="20">
		    <td scope="col" class="evenListRowS1" nowrap align="left"><b>Grand Total: </b></td>
			<td scope="col" class="evenListRowS1" nowrap align="right"><b>{$grand.Registration|number_format:2:".":","}</b></td>
			<td scope="col" class="evenListRowS1" nowrap align="right"><b>{$grand.Tuition|number_format:2:".":","}</b></td>
			<td scope="col" class="evenListRowS1" nowrap align="right"><b>{$grand.Miscellaneous|number_format:2:".":","}</b></td>
			<td scope="col" class="evenListRowS1" nowrap align="right"><b>{$grand.Laboratory|number_format:2:".":","}</b></td>
			<td scope="col" class="evenListRowS1" nowrap align="right"><b>{$grand.Total|number_format:2:".":","}</b></td>
		</tr>
</tbody>
</table>
</p>