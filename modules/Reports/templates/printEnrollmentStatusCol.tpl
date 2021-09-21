
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
    <tr><th  colspan="6" align="center"><br><b><u>College Enrollment Status</u></b> <br><br></th></tr>
    <tr>
        <td class="tabDetailViewDL" width="150"><slot></slot></td>
        <td class="tabDetailView" width="150"><slot></slot>{$SEMCODE} {$SCHYEAR}</td>
        <td class="tabDetailViewDL" width="200"><slot></slot></td>
        <td class="tabDetailViewDF" width="50" align="left"><slot>Status:</slot></td>
        <td class="tabDetailViewDL" width="180"><slot>{$rstatus}</slot></td>
        <td class="tabDetailViewDF" width="100" align="left"><slot></slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

<p>
<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap><b>Department </b></td>
		<td scope="col" class="listViewThS1" nowrap><b>Course </b></td>
		<td scope="col" class="listViewThS1" nowrap><b>1 </b></td>
		<td scope="col" class="listViewThS1" nowrap><b>2 </b></td>
		<td scope="col" class="listViewThS1" nowrap><b>3 </b></td>
		<td scope="col" class="listViewThS1" nowrap><b>4 </b></td>
		<td scope="col" class="listViewThS1" nowrap><b>5 </b></td>
		<td scope="col" class="listViewThS1" nowrap><b>Total </b></td>
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
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].deptCode}&nbsp;</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].courseCode}&nbsp;</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].1}&nbsp;</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].2}&nbsp;</td>

		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].3}&nbsp;</td>

		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].4}&nbsp;</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].5}&nbsp;</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].total}&nbsp;</td>

	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<tr height="20">
	    <td scope="col" class="evenListRowS1" nowrap align="right">&nbsp;</td>
	    <td scope="col" class="evenListRowS1" nowrap align="left"><b>Grand Total: </b></td>
		<td scope="col" class="evenListRowS1" nowrap><b>{$grand.1} &nbsp;</b></td>
		<td scope="col" class="evenListRowS1" nowrap><b>{$grand.2} &nbsp;</b></td>
		<td scope="col" class="evenListRowS1" nowrap><b>{$grand.3} &nbsp;</b></td>
		<td scope="col" class="evenListRowS1" nowrap><b>{$grand.4} &nbsp;</b></td>
		<td scope="col" class="evenListRowS1" nowrap><b>{$grand.5} &nbsp;</b></td>
		<td scope="col" class="evenListRowS1" nowrap><b>{$grand.total} &nbsp;</b></td>
	</tr>
</tbody>
</table>
</p>