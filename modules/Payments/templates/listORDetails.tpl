<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;College OR Series</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap>ID </td>
		<td scope="col" class="listViewThS1" nowrap>Fiscal Year</td>
		<td scope="col" class="listViewThS1" nowrap>First OR #</td>
		<td scope="col" class="listViewThS1" nowrap>Last OR #</td>
		<td scope="col" class="listViewThS1" nowrap>Cashier </td>
		<td scope="col" class="listViewThS1" nowrap>Status </td>
		<td scope="col" class="listViewThS1" nowrap>Apply </td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php?module=Payments&action=listORSeries">
	    <input type="hidden" name="module" value="Payments" />
	    <input type="hidden" name="action" value="listORSeries" />
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="id" id="id" value="{$id}"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="fiscalYear" id="fiscalYear" value="{$fiscalYear}"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="firstORNO" id="firstORNO" value="{$firstORNO}"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="lastORNO" id="lastORNO" value="{$lastORNO}"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
    		<select name="cashier" id="cashier">
            <option value="">---------------------------</option>
            {section name=i loop=$user_list}
            <option value="{$user_list[i].id}" {if $user_list[i].id eq $cashier} selected {/if}>{$user_list[i].last_name}, {$user_list[i].first_name}</option>
            {/section}
            </select>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
    		<select name="rstatus" id="rstatus">
            <option value="">----------------</option>
            <option value="0" {if $rstatus eq '0'} selected {/if}> Cancelled </option>
            <option value="1" {if $rstatus eq '1'} selected {/if}> Open </option>
            <option value="2" {if $rstatus eq '2'} selected {/if}> Used</option>
            </select>
		</td>
	    <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="submit" name="cmdFilter" id="cmdFilter" value="Filter"/></td>
		</form>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	{if $list neq ""}
		{section name=i loop=$list}
		<!-- Start of students Listing -->
		<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		
			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Payments&action=viewORSeries&id={$list[i].id}" class="listViewTdLinkS1">{$list[i].id}</a></span></td>
			
			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Payments&action=viewORSeries&id={$list[i].id}" class="listViewTdLinkS1">{$list[i].fiscalYear}</a></span></td>

			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Payments&action=viewORSeries&id={$list[i].id}" class="listViewTdLinkS1">{$list[i].firstORNO}</a></span></td>
			
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Payments&action=viewORSeries&id={$list[i].id}" class="listViewTdLinkS1">{$list[i].lastORNO}</a></span></td>

			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].cashierName}</td>
			
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].rstatus eq 1} Open {elseif $list[i].rstatus eq 2} Used {else} Cancelled {/if}</td>

			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 	
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b">&nbsp;</span></td>
	
		</tr>
		<tr>
			<td colspan="20" class="listViewHRS1"></td>
		</tr>
		<!-- End of student Listing -->
		{/section}
	{else}
    	<tr>
    		<td colspan="20" class="oddListRowS1">
            	<table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tbody>
            	<tr>
            		<td nowrap="nowrap" align="center"><b><i>No results found.</i></b></td>
            	</tr>
            	</tbody>
            	</table>
    		</td>
    	</tr>
	{/if}
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<tr>
		<td colspan="20" height="20">
		{$pagination}
		</td>
	</tr>
</tbody>
</table>

</p>

