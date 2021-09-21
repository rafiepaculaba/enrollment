<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;Equivalency</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="10%" nowrap>Equivalency ID</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Curriculum ID</td>
		<td scope="col" class="listViewThS1" width="35%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="35%" nowrap>Equivalent Subject</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>&nbsp;</td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php">
	    <input type="hidden" name="module" value="Curriculums" />
	    <input type="hidden" name="action" value="listEquivalency" />
	    
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="eqID" id="eqID" value="{$eqID}" size="10" onkeypress="return keyRestrict(event, 0);"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="curID" id="curID" value="{$curID}" size="20" onkeypress="return keyRestrict(event, 0);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<slot>
		<select name="subjID" id="subjID">
        <option value="">----------------------------------------</option>
        {section name=i loop=$subjectList}
        <option value="{$subjectList[i].subjID}" {if $subjectList[i].subjID eq $subjID} selected {/if}>{$subjectList[i].subjCode}</option>
        {/section}
        </select>
		</slot>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<slot>
		<select name="eqSubjID" id="eqSubjID">
        <option value="">----------------------------------------</option>
        {section name=i loop=$subjectList}
        <option value="{$subjectList[i].subjID}" {if $subjectList[i].subjID eq $eqSubjID} selected {/if}>{$subjectList[i].subjCode}</option>
        {/section}
        </select>
		</slot>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="submit" name="cmdFilter" id="cmdFilter" value="Filter"/></td>
		</form>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	
	{if $list neq ""}
    	{section name=i loop=$list}
    	<!-- Start of departments Listing -->
    	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
    	
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Curriculums&action=viewEquivalency&eqID={$list[i].eqID}" class="listViewTdLinkS1">{$list[i].eqID}</a></span></td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top">{$list[i].curID}</td>	
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top">{$list[i].subjCode} &nbsp; {$list[i].descTitle}</td>
    		
    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top">{$list[i].eqSubjCode} &nbsp; {$list[i].eqSubjDescTitle} </td>
    		
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
    	<!-- End of department Listing -->
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

