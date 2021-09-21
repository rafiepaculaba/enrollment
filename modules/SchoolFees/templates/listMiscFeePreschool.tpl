<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;Miscellaneous Fee: Pre-school</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="10%" nowrap>School Year </td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Miscellaneous Fee No. </td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Grade </td>
		<td scope="col" class="listViewThS1" width="40%" nowrap>Particular </td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Amount </td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Apply </td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php?module=SchoolFees&action=listMiscFeePreschool">
	    <input type="hidden" name="module" value="SchoolFees" />
	    <input type="hidden" name="action" value="listMiscFeePreschool" />
		<td scope="row" class="evenListRowS1"nowrap  class="listViewPaginationTdS1"><slot>{$SCHOOLYEAR}</slot></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><slot><input type="text" name="miscID" id="miscID" size="10" maxlength="5" value="{$miscID}"  onkeypress="return keyRestrict(event, 0);" /></slot></td>
        <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
        <slot>{$YEARLEVEL}</slot>
        </td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="particular" id="particular" size="60" value="{$particular}" maxlength="100"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
	    <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="submit" name="cmdFilter" id="cmdFilter" value="Filter"/></td>
		</form>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	{if $list neq ""}
		{section name=i loop=$list}
		<!-- Start of Courses Listing -->
		<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	
			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b">{$list[i].schYear}</td>
	
			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=SchoolFees&action=viewMiscFeePreschool&miscID={$list[i].miscID}" class="listViewTdLinkS1">{$list[i].miscID}</a></span></td>
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].yrLevel}</td>	

			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=SchoolFees&action=viewMiscFeePreschool&miscID={$list[i].miscID}" class="listViewTdLinkS1">{$list[i].particular}</a></span></td>	
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].amount}</td>	

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
		<!-- End of Course Listing -->
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