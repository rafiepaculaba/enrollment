<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;College Courses</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		
		<td scope="col" class="listViewThS1" width="20%" nowrap>Department</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Course Code</td>
		<td scope="col" class="listViewThS1" width="50%" nowrap>Course Name</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Apply</td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php">
	    <input type="hidden" name="module" value="Courses" />
	    <input type="hidden" name="action" value="listCourses" />
	    
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		 <slot>
        <select name="deptID" id="deptID">
        <option value="">---------------</option>
        {section name=i loop=$deptlist}
        <option value="{$deptlist[i].deptID}" {if $deptlist[i].deptID eq $departmentID} selected {/if}>{$deptlist[i].deptCode}</option>
        {/section}
        </select>
        </slot>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="courseCode" id="courseCode" size="20" value="{$courseCode}" onkeypress="return keyRestrict(event, 13);"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="courseName" id="courseName" size="60" value="{$courseName}" onkeypress="return keyRestrict(event, 13);"/></td>
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
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].deptCode}</td>	   
		
			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Courses&action=viewCourse&courseID={$list[i].courseID}" class="listViewTdLinkS1">{$list[i].courseCode}</a></span></td>
			
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Courses&action=viewCourse&courseID={$list[i].courseID}" class="listViewTdLinkS1">{$list[i].courseName}</a></span></td>
			
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
