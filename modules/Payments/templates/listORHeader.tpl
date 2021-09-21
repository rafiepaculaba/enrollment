<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;College Official Receipts</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap>School Year</td>
		<td scope="col" class="listViewThS1" nowrap>Semester</td>
		<td scope="col" class="listViewThS1" nowrap>OR No.</td>
		<td scope="col" class="listViewThS1" nowrap>ID No.</td>
		<td scope="col" class="listViewThS1" nowrap>Last Name</td>
		<td scope="col" class="listViewThS1" nowrap>First Name</td>
		<td scope="col" class="listViewThS1" nowrap>Middle Name</td>
		<td scope="col" class="listViewThS1" nowrap>Gender</td>
		<td scope="col" class="listViewThS1" nowrap>Status</td>
		<td scope="col" class="listViewThS1" nowrap>Apply</td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php">
	    <input type="hidden" name="module" value="Payments" />
	    <input type="hidden" name="action" value="listORHeader" />
	    
	    <td scope="col" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">{$SCHOOLYEAR}</td>
		<td scope="col" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">{$SEMESTERS}</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="orno" id="orno" size="15" value="{$orno}" maxlength="15" onkeypress="return keyRestrict(event, 14);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="idno" id="idno" size="15" value="{$idno}" maxlength="15" onkeypress="return keyRestrict(event, 14);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="lname" id="lname" value="{$lname}" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="fname" id="fname" value="{$fname}" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="mname" id="mname" value="{$mname}" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
			<select name="gender" id="gender">
            <option value="">--------</option>
            <option value="M" {if $gender eq 'M'} selected {/if} > Male </option>
            <option value="F" {if $gender eq 'F'} selected {/if} > Female </option>
            </select> 
        </td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
    		<select name="rstatus" id="rstatus">
    	        <option value="">----------------</option>
    	        <option value="0" {if $rstatus eq "0"} selected {/if}> Cancelled </option>
    	        <option value="1" {if $rstatus eq "1"} selected {/if}> Active </option>
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
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Payments&action=viewORHeader&paymentID={$list[i].paymentID}" class="listViewTdLinkS1">{$list[i].orno}</a></span></td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
    		align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Payments&action=viewORHeader&paymentID={$list[i].paymentID}" class="listViewTdLinkS1">{$list[i].idno}</a></span></td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
    		align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Payments&action=viewORHeader&paymentID={$list[i].paymentID}" class="listViewTdLinkS1">{$list[i].lname}</a></span></td>
    		
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
    		align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Payments&action=viewORHeader&paymentID={$list[i].paymentID}" class="listViewTdLinkS1">{$list[i].fname}</a></span></td>

    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
    		align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Payments&action=viewORHeader&paymentID={$list[i].paymentID}" class="listViewTdLinkS1">{$list[i].mname}</a></span></td>

    		<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].gender eq 'M'} Male {else} Female {/if}</td>
    		
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].rstatus eq 0 } Cancelled {/if} {if $list[i].rstatus eq 1 } Active {/if}</td>

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

