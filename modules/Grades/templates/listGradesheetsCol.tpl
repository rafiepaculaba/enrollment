<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;College Grade Sheets</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		
		<td scope="col" class="listViewThS1" nowrap>GS #</td>
		<td scope="col" class="listViewThS1" nowrap>Sched Code</td>
		<td scope="col" class="listViewThS1" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" nowrap>Instructor</td>
		<td scope="col" class="listViewThS1" nowrap>School Year</td>
		<td scope="col" class="listViewThS1" nowrap>Semester</td>
		<td scope="col" class="listViewThS1" nowrap>Status</td>
		<td scope="col" class="listViewThS1" nowrap>Apply</td>
		
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php">
	    <input type="hidden" name="module" value="Grades" />
	    <input type="hidden" name="action" value="listGradesheetsCol" />
	    
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="gsID" id="gsID" size="5" value="{$gsID}" maxlength="15" onkeypress="return keyRestrict(event, 0);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="schedCode" id="schedCode" size="10" value="{$schedCode}" maxlength="15" onkeypress="return keyRestrict(event, 0);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="subjCode" id="subjCode" size="15" value="{$subjCode}" maxlength="15" onkeypress="return keyRestrict(event, 13);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<select name="profID" id="profID">
		{if  $isInstructor eq 0}
            <option value="">--------------------</option>
        {/if}
        {section name=i loop=$profList}
        <option value="{$profList[i].id}"
        {if $profID eq $profList[i].id} selected {/if} 
        >{$profList[i].last_name}, {$profList[i].first_name}</option>
        {/section}
        </select> 
		</td>
		<td scope="col" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">{$SCHOOLYEAR}</td>
		<td scope="col" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">{$SEMESTERS}</td>
		<td scope="col" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<select name="rstatus" id="rstatus">
        <option value="">---------</option>
        <option value="1" {if $rstatus eq 1} selected {/if} >Pending</option>
        <option value="2" {if $rstatus eq 2} selected {/if} >Approved</option>
        <option value="3" {if $rstatus eq 3} selected {/if} >Posted</option>
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
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Grades&action=viewGradeSheetCol&gsID={$list[i].gsID}" class="listViewTdLinkS1">{$list[i].gsID}</a></span></td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
    		align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Grades&action=viewGradeSheetCol&gsID={$list[i].gsID}" class="listViewTdLinkS1">{$list[i].schedCode}</a></span></td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
    		align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Grades&action=viewGradeSheetCol&gsID={$list[i].gsID}" class="listViewTdLinkS1">{$list[i].subjCode}</a></span></td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
    		align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Grades&action=viewGradeSheetCol&gsID={$list[i].gsID}" class="listViewTdLinkS1">{$list[i].profName}</a></span></td>
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" valign="top">{$list[i].schYear}</td>
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" valign="top"> {if $list[i].semCode eq 1} 1st {elseif $list[i].semCode eq 2} 2nd {elseif $list[i].semCode eq 4} Summer {/if} </td>   
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" valign="top"> {if $list[i].rstatus eq 1} Pending {elseif $list[i].rstatus eq 2} Approved {elseif $list[i].rstatus eq 3} Posted {/if} </td>   
    	
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" valign="top">&nbsp;</td>
    			
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

