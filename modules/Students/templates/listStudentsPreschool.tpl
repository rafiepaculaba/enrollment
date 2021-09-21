<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;Preschool Students</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		
		<td scope="col" class="listViewThS1" width="10%" nowrap>ID No.</td>
		<td scope="col" class="listViewThS1" width="25%" nowrap>Last Name</td>
		<td scope="col" class="listViewThS1" width="25%" nowrap>First Name</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Middle Name</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Grade</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Apply</td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php?module=Students&action=listStudentsPreschool">
	    <input type="hidden" name="module" value="Students" />
	    <input type="hidden" name="action" value="listStudentsPreschool" />
	    
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="idno" id="idno" size="" value="{$idno}" maxlength="15" onkeypress="return keyRestrict(event, 14);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="lname" id="lname" value="{$lname}" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="fname" id="fname" value="{$fname}" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="mname" id="mname" value="{$mname}" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></td>
		<td scope="col" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><slot>{$yrLevel_object}</slot></td>
		
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
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Students&action=viewStudentPreschool&idno={$list[i].idno}" class="listViewTdLinkS1">{$list[i].idno}</a></span></td>
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Students&action=viewStudentPreschool&idno={$list[i].idno}" class="listViewTdLinkS1">{$list[i].lname}</a></span></td>
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Students&action=viewStudentPreschool&idno={$list[i].idno}" class="listViewTdLinkS1">{$list[i].fname}</a></span></td>
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Students&action=viewStudentPreschool&idno={$list[i].idno}" class="listViewTdLinkS1">{$list[i].mname}</a></span></td>
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" valign="top">{if $list[i].yrLevel eq 1} Nursery 1 {elseif $list[i].yrLevel eq 2}  Nursery 2 {elseif $list[i].yrLevel eq 3}  Kinder 1 {elseif $list[i].yrLevel eq 4}  Kinder 2 {else} Special {/if}</td>
    		
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

