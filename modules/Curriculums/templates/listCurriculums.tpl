<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;Curricula</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="15%" nowrap>Course</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Curriculum ID</td>
		<td scope="col" class="listViewThS1" width="40%" nowrap>Curriculum Name</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Effectivity</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Major</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Apply</td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php">
	    <input type="hidden" name="module" value="Curriculums" />
	    <input type="hidden" name="action" value="listCurriculums" />
	    
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<select name="courseID" id="courseID">
        <option value="">--------------------</option>
        {section name=i loop=$courseList}
        <option value="{$courseList[i].courseID}"
        {if $courseID eq $courseList[i].courseID} selected {/if} 
        >{$courseList[i].courseCode}</option>
        {/section}
        </select> 
        </td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" size="10" name="curID" id="curID" value="{$curID}" maxlength="3" onkeypress="return keyRestrict(event, 0);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" size="40" name="curName" id="curName" value="{$curName}" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" size="10" name="effectivity" id="effectivity" value="{$effectivity}" onkeypress="return keyRestrict(event, 0);" maxlength="4" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="major" id="major" value="{$major}" /></td>
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
            align="left" bgcolor="#fdfdfd" valign="top">{$list[i].courseCode}</td>
    	
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Curriculums&action=viewCurriculum&curID={$list[i].curID}" class="listViewTdLinkS1">{$list[i].curID}</a></span></td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Curriculums&action=viewCurriculum&curID={$list[i].curID}" class="listViewTdLinkS1">{$list[i].curName}</a></span></td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top">  {$list[i].effectivity} </td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top"> {$list[i].major}</td>
    		
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

