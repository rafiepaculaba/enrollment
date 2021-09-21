<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;COLLEGE SUBJECTS</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap>Course</td>
		<td scope="col" class="listViewThS1" nowrap>Subject Code</td>
		<td scope="col" class="listViewThS1" nowrap>Descriptive Title</td>
		<td scope="col" class="listViewThS1" nowrap>Type </td>
		<td scope="col" class="listViewThS1" nowrap>Computer Subject</td>
		<td scope="col" class="listViewThS1" nowrap>Apply</td>
		</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="POST" action="index.php?module=Subjects&action=listSubjects">
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1" >
		<slot>
        <select name="courseID" id="courseID">
        <option value="">---------------------</option>
        {section name=i loop=$courselist}
        <option value="{$courselist[i].courseID}" {if $courselist[i].courseID eq $courseID} selected {/if}>{$courselist[i].courseCode}</option>
        {/section}
        </select>
        </slot>
		</td>
	    <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="subjCode" id="subjCode" size="" value="{$subjCode}" maxlength="10" onkeypress="return keyRestrict(event, 17);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="descTitle" id="descTitle" value="{$descTitle}" maxlength="100" size="50" onkeypress="return keyRestrict(event, 13);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<select name="type" id="type">
        <option value="">------------</option>		
        <option value="1" {if $type eq "1"} selected {/if}>Lec</option>
        <option value="2" {if $type eq "2"} selected {/if}>Lab</option>
        </select> 
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<select name="isCompSubj" id="isCompSubj">
        <option value="">------------</option>		
        <option value="0" {if $isCompSubj eq "0"} selected {/if}>No</option>
        <option value="1" {if $isCompSubj eq "1"} selected {/if}>Yes</option>
        </select> 
		</td>
	    <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="submit" name="cmdFilter" id="cmdFilter" value="Filter" /></td>
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
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].courseCode}</td>	
	
			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Subjects&action=viewSubject&subjID={$list[i].subjID}" class="listViewTdLinkS1">{$list[i].subjCode}</a></span></td>
			
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Subjects&action=viewSubject&subjID={$list[i].subjID}" class="listViewTdLinkS1">{$list[i].descTitle}</a></span></td>	
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].type eq "1"} Lec {else} Lab {/if}</td>
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].isCompSubj	eq "0"} No {else} Yes {/if}</td>

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
