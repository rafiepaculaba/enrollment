<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;College Credited Subjects </h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap>School Year </td>
		<td scope="col" class="listViewThS1" nowrap>Semester </td>
		<td scope="col" class="listViewThS1" nowrap>Credited Number </td>
		<td scope="col" class="listViewThS1" nowrap>ID No. </td>
		<td scope="col" class="listViewThS1" nowrap>Credited Subject </td>
		<td scope="col" class="listViewThS1" nowrap>Equivalent Subject</td>
		<td scope="col" class="listViewThS1" nowrap>Equivalent Unit </td>
		<td scope="col" class="listViewThS1" nowrap>Apply </td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php?module=Credited&action=listCreditedSubjects">
	    <input type="hidden" name="module" value="Credited" />
	    <input type="hidden" name="action" value="listCreditedSubjects" />
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">{$SCHOOLYEAR}</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">{$SEMESTERS}</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="creID" id="creID" size="" value="{$creID}" onkeypress="return keyRestrict(event, 2);"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="idno" id="idno" size="" value="{$idno}" onkeypress="return keyRestrict(event, 14);"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
	 	<slot>
        <select name="subjID" id="subjID">
        <option value="">-----------------------------------</option>
        {section name=i loop=$subjlist}
        <option value="{$subjlist[i].subjID}" {if $subjlist[i].subjID eq $subjID} selected {/if}>{$subjlist[i].subjCode}{$subjlist[i].descTitle}{if $subjlist[i].type eq 2} (Lab){/if}</option>
        {/section}
        </select>
        </slot>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="eqSubj" id="eqSubj" value="{$eqSubj}" size="" maxlength="15" onkeypress="return keyRestrict(event, 13);"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="eqUnits" id="eqUnits" value="{$eqUnits}" size="" maxlength="15" onkeypress="return keyRestrict(event, 2);"/></td>
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
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].schYear}</td>
			
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].semCode eq 1} 1st Sem {/if}{if $list[i].semCode eq 2} 2nd Sem {/if} {if $list[i].semCode eq 4} Summer {/if}</td>
			
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Credited&action=viewCreditedSubject&creID={$list[i].creID}" class="listViewTdLinkS1">{$list[i].creID}</a></span></td>
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].idno}</td>
		
			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].subjCode} &nbsp;{$list[i].descTitle}&nbsp;{if $list[i].type eq 2} (Lab){/if}</td>
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].eqSubj}</td>
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].eqUnits}</td>
	
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

