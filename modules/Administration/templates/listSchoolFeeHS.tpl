<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;School Fee: High School</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="10%" nowrap>School Year </td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>School Fee No. </td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Year Level</td>
		<td scope="col" class="listViewThS1" width="60%" nowrap>Item </td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Apply </td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php?module=SchoolFees&action=listSchoolFeeHS">
	    <input type="hidden" name="module" value="SchoolFees" />
	    <input type="hidden" name="action" value="listSchoolFeeHS" />
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><slot>{$SCHOOLYEAR}</slot></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><slot><input type="text" name="feeID" id="feeID" size="10" maxlength="5" value="{$feeID}"  onkeypress="return keyRestrict(event, 0);" /></slot></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<select name="yrLevel" id="yrLevel">
        <option value="">--------</option>
        <option value="1" {if $yrLevel eq "1"} selected {/if}>1</option>
        <option value="2" {if $yrLevel eq "2"} selected {/if}>2</option>
        <option value="3" {if $yrLevel eq "3"} selected {/if}>3</option>
        <option value="4" {if $yrLevel eq "4"} selected {/if}>4</option>
        <option value="S" {if $yrLevel eq "S"} selected {/if}>Special</option>
        </select> 
        </td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="item" id="item" size="60" value="{$item}"/></td>
	    <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="submit" name="cmdFilter" id="cmdFilter" value="Filter"/></td>
		</form>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	{section name=i loop=$list}
	<!-- Start of Courses Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">

		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].schYear}</td>
	
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=SchoolFees&action=viewSchoolFeeHS&feeID={$list[i].feeID}" class="listViewTdLinkS1">{$list[i].feeID}</a></span></td>

		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].yrLevel eq "S"} Special {else} {$list[i].yrLevel} {/if}</td>

		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=SchoolFees&action=viewSchoolFeeHS&feeID={$list[i].feeID}" class="listViewTdLinkS1">{$list[i].item}</a></span></td>	

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
