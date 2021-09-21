
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><!--<img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">-->&nbsp;</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
		<td nowrap="nowrap">
		&nbsp;
    		<div id="myDiv" name="myDiv" style="display:block">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<td nowrap="nowrap" align="right"><input type="button" class="button" value="Print Now" id="cmdPrint" name="cmdPrint" onclick="printNow();" /></td>
            		<td nowrap="nowrap" align="right">&nbsp;&nbsp;<input type="button" class="button" value="Close" id="cmdClose" name="cmdClose" onclick="javascript: window.close();" /></td>
            	</tr>
            </table>
            </div>
		</td>
	</tr>
</table>

<p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="tabDetailViewDL" colspan="6" align="center">
        <slot>
        {$schName}<br>{$schAddress}<br>{$schContact}
        </slot>
        </td>
    </tr>
    <tr><th  colspan="6" align="center"><br><b><u>Elementary Schedules</u></b> <br><br></th></tr>
    <tr>
        <td class="tabDetailViewDL" width="100"><slot>School Year: </slot></td>
        <td  class="tabDetailView" width="150"><slot> <u>{$SCHYEAR}</u> </slot></td>
        <td class="tabDetailViewDL" width="100"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" width="150" align="left"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="100"><slot>&nbsp; </slot></td>
        <td class="tabDetailViewDF" width="150" align="left"><slot>&nbsp;</slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

<p>
<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap><b>School Year</b></td>
		<td scope="col" class="listViewThS1" nowrap><b>Year Level</b></td>
		<td scope="col" class="listViewThS1" nowrap><b>Sched Code </b></td>
		<td scope="col" class="listViewThS1" nowrap><b>Subject </b></td>
		<td scope="col" class="listViewThS1" nowrap><b>Instructor </b></td>
		{if $droom eq 1}
		  <td scope="col" class="listViewThS1" nowrap><b>Room </b></td>
		{/if}
		{if $dstartTime eq 1}
		  <td scope="col" class="listViewThS1" nowrap><b>Start Time </b></td>
		{/if}
		{if $dendTime eq 1}
		  <td scope="col" class="listViewThS1" nowrap><b>End Time </b></td>
		{/if}
		{if $ddays eq 1}
		  <td scope="col" class="listViewThS1" nowrap><b>Days </b></td>
		{/if}
		<td scope="col" class="listViewThS1" nowrap><b>Status </b></td>
		{if $dnoEnrolled eq 1}
		  <td scope="col" class="listViewThS1" nowrap><b># Enrolled </b></td>
		{/if}
		{if $dmaxCapacity eq 1}
		  <td scope="col" class="listViewThS1" nowrap><b>Max Capacity </b></td>
		{/if}
		{if $dremarks eq 1}
		  <td scope="col" class="listViewThS1" nowrap><b>Remarks </b></td>
		{/if}
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	{section name=i loop=$list}
	<!-- Start of students Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].schYear}</span></td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"> {$list[i].yrLevel} </td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].schedCode}</td>

		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].subjCode}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].profName} &nbsp;</td>

	    {if $droom eq 1}
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].room} &nbsp;</td>	
		{/if}

		{if $dstartTime eq 1}
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" bgcolor="#fdfdfd" valign="top">{$list[i].startTime|date_format:"%I:%M %p"} &nbsp;</td>	
		{/if}

		{if $dendTime eq 1}
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].endTime|date_format:"%I:%M %p"}&nbsp;</td>	
		{/if}

		{if $ddays eq 1}
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top" >
    			{if $list[i].onMon eq 1} M {elseif $list[i].onMon eq 0}{/if}
    			{if $list[i].onThu eq 1}
    			     {if $list[i].onTue eq 1} T {elseif $list[i].onTue eq 0}{/if}
    			{elseif $list[i].onThu eq 0}
    			     {if $list[i].onTue eq 1} Tue {elseif $list[i].onTue eq 0}{/if}
    			{/if}
    			{if $list[i].onWed eq 1} W {elseif $list[i].onWed eq 0}{/if}
    			{if $list[i].onTue eq 1}
    			     {if $list[i].onThu eq 1} Th {elseif $list[i].onThu eq 0}{/if}
    			{elseif $list[i].onTue eq 0}
    			     {if $list[i].onThu eq 1} Thu {elseif $list[i].onThu eq 0}{/if}
    			{/if}
                {if $list[i].onFri eq 1} F {elseif $list[i].onFri eq 0}{/if}
                {if $list[i].onSat eq 1} Sat {elseif $list[i].onSat eq 0}{/if}
                {if $list[i].onSun eq 1} Sun {elseif $list[i].onSun eq 0}{/if}
    		&nbsp;</td>
		{/if}

		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].rstatus eq 1} Open {/if} {if $list[i].rstatus eq 0} Closed {/if} &nbsp;</td>

		{if $dnoEnrolled eq 1}
    		<td scope="row"
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="center" bgcolor="#fdfdfd" valign="top">{$list[i].noEnrolled} &nbsp;</td>	
		{/if}

		{if $dmaxCapacity eq 1}
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="center" bgcolor="#fdfdfd" valign="top">{$list[i].maxCapacity} &nbsp;</td>	
		{/if}
		
        {if $dremarks eq 1}
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].remarks} &nbsp;</td>	
		{/if}
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of student Listing -->
	{/section}
</tbody>
</table>

</p>

