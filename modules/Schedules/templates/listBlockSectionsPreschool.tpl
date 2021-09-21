<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;Preschool Block Sections</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap>School Year</td>
	    <td scope="col" class="listViewThS1" nowrap>Grade</td>
		<td scope="col" class="listViewThS1" nowrap>Section ID</td>
		<td scope="col" class="listViewThS1" nowrap>Section</td>
		<td scope="col" class="listViewThS1" nowrap># Enrolled</td>
		<td scope="col" class="listViewThS1" nowrap>Status</td>
		<td scope="col" class="listViewThS1" nowrap>Apply</td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php">
	    <input type="hidden" name="module" value="Schedules" />
	    <input type="hidden" name="action" value="listBlockSectionsPreschool" />
	    <td scope="row" class="evenListRowS1" nowrap class="listViewPaginationTdS1">{$SCHOOLYEAR}</td>
        <td scope="row" class="evenListRowS1" nowrap class="listViewPaginationTdS1">{$YEARLEVEL}</td>
		<td scope="row" class="evenListRowS1" nowrap class="listViewPaginationTdS1"><input type="text" name="secID" id="secID" value="{$secID}" size="5" maxlength="6" /></td>
		<td scope="row" class="evenListRowS1" nowrap class="listViewPaginationTdS1"><input type="text" name="secName" id="secName" value="{$secName}" size="25" maxlength="20" /></td>
		<td scope="row" class="evenListRowS1" nowrap class="listViewPaginationTdS1">&nbsp;</td>
		<td scope="row" class="evenListRowS1" nowrap class="listViewPaginationTdS1">
		<select name="rstatus" id="rstatus">
        <option value="">--------</option>
        <option value="1" {if $rstatus eq "1"} selected {/if}>Open</option>
        <option value="0" {if $rstatus eq "0"} selected {/if}>Closed</option>
        </select>
		</td>
		<td scope="row" class="evenListRowS1" nowrap class="listViewPaginationTdS1"><input type="submit" name="cmdFilter" id="cmdFilter" value="Filter"/></td>
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
            align="left" bgcolor="#fdfdfd" valign="top">  {$list[i].schYear} </td>
    	
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
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Schedules&action=viewBlockSectionPreschool&secID={$list[i].secID}" class="listViewTdLinkS1">{$list[i].secID}</a></span></td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Schedules&action=viewBlockSectionPreschool&secID={$list[i].secID}" class="listViewTdLinkS1">{$list[i].secName}</a></span></td>
    		
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top">{$list[i].noEnrolled} </td>
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top">
    		{if $list[i].rstatus eq '1'}
    		  Open
    		{else}
    		  <font color="Red">Closed</font>
    		{/if}
    		</td>
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
    		
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

