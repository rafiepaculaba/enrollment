<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;Preschool SUBJECTS</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="20%" nowrap>Subject Code</td>
		<td scope="col" class="listViewThS1" width="40%" nowrap>Descriptive Title</td>
		<td scope="col" class="listViewThS1" width="30%" nowrap>Grade Level</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Apply</td>
		</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="POST" action="index.php?module=Subjects&action=listSubjectsPreschool">
		<td scope="row" class="evenListRowS1" width="20%" nowrap  class="listViewPaginationTdS1"><input type="text" name="subjCode" id="subjCode" value="{$subjCode}" size="" maxlength="10" onkeypress="return keyRestrict(event, 17);" /></td>
		<td scope="row" class="evenListRowS1" width="40%" nowrap  class="listViewPaginationTdS1"><input type="text" name="descTitle" id="descTitle" value="{$descTitle}" size="50" maxlength="100" onkeypress="return keyRestrict(event, 13);"/></td>
		<td scope="row" class="evenListRowS1" width="30%" nowrap  class="listViewPaginationTdS1">{$YEARLEVEL}</td>
	    <td scope="row" class="evenListRowS1" width="10%" nowrap  class="listViewPaginationTdS1"><input type="submit" name="cmdFilter" id="cmdFilter" value="Filter" /></td>
		</form>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	{if $list neq ""}
		{section name=i loop=$list}
		<!-- Start of Subjects Listing -->
		<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		
			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Subjects&action=viewSubjectPreschool&subjID={$list[i].subjID}" class="listViewTdLinkS1">{$list[i].subjCode}</a></span></td>
			
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].descTitle}</td>	
			
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].yrLevel eq 1} Nursery 1 {elseif $list[i].yrLevel eq 2}  Nursery 2 {elseif $list[i].yrLevel eq 3}  Kinder 1 {elseif $list[i].yrLevel eq 4}  Kinder 2 {else} Special {/if}</td>	
	
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
		<!-- End of Subject Listing -->
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
