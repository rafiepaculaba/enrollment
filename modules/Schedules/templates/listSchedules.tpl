<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap" ><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;COLLEGE SCHEDULES</h3></td>
	</tr>
	<tr>
		<td nowrap="nowrap" ><img src="themes/Sugar/images/basic_search.gif" id="divSubjectHandle" onclick="hideShowSubject('divSubject');" alt="Advance Option"/><label onclick="hideShowSubject('divSubject');">&nbsp;Advance Option</label></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
		<td nowrap="nowrap" ><img src="themes/Sugar/images/basic_search.gif" id="divSubjectHandle2" onclick="hideShowSubject('divSubject');" alt="Advance Option"/><label onclick="hideShowSubject('divSubject');">&nbsp;Advance Option</label></td>
	</tr>
</table>

<div id="divSubject" style="display:block">
<form name="frmSelect" id="frmSelect" method="POST" action="index.php">
<input type="hidden" name="module" value="Schedules" />
<input type="hidden" name="action" value="listSchedules" />
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
    <td class="dataLabel" id="chooser_display_tabs_text" align="center" width="15%"><nobr>Check field to display </nobr></td>
    <td class="dataLabel" id="chooser_hide_tabs" align="center" > &nbsp; </td>
</tr>
<tr>
    <td>
        <div style='font:13.3px sans-serif;width:9.5em;border-left:1px solid #808080;border-top:1px solid #808080;border-bottom:1px solid #fff; border-right:1px solid #fff;'>
        <div style='background:#fff; overflow:auto;height:7.1em;border-left:1px solid #404040;border-top:1px solid #404040;border-bottom:1px solid #d4d0c8;border-right:1px solid #d4d0c8;'>
        <label for='room' style='padding-right:3px;display:block;'><input name='checkbox[]' value='room' type='checkbox' id='room' {if $droom eq 1} checked {/if} onclick='highlight_div(this);'>Room </label>
        <label for='#enrolled' style='padding-right:3px;display:block;'><input name='checkbox[]' value='#enrolled' type='checkbox' id='#enrolled' {if $dnoEnrolled eq 1} checked {/if} onclick='highlight_div(this);'># Enrolled </label>
        <label for='maxcapacity' style='padding-right:3px;display:block;'><input name='checkbox[]' value='maxcapacity' type='checkbox' id='maxcapacity' {if $dmaxCapacity eq 1} checked {/if} onclick='highlight_div(this);'>Max Capacity </label>
        <label for='starttime' style='padding-right:3px;display:block;'><input name='checkbox[]' value='starttime' type='checkbox' id='starttime' {if $dstartTime eq 1} checked {/if} onclick='highlight_div(this);'>Start Time </label>
        <label for='endtime' style='padding-right:3px;display:block;'><input name='checkbox[]' value='endtime' type='checkbox' id='endtime' {if $dendTime eq 1} checked {/if} onclick='highlight_div(this);'>End Time </label>
        <label for='remarks' style='padding-right:3px;display:block;'><input name='checkbox[]' value='remarks' type='checkbox' id='remarks' {if $dremarks eq 1} checked {/if} onclick='highlight_div(this);'>Remarks </label>
        <label for='days' style='padding-right:3px;display:block;'><input name='checkbox[]' value='days' type='checkbox' id='days' {if $ddays eq 1} checked {/if} onclick='highlight_div(this);'>Days </label>
        </div>
        </div>
    </td>
</tr>
<tr>
    <td>
        <input type="submit" name="cmdSelect" id="cmdSelect" value="Go" />
    </td>
</tr>
</tbody>
</table>
</p>
</form>
</div>

<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1"  nowrap>School Year</td>
		<td scope="col" class="listViewThS1"  nowrap>Semester</td>
		<td scope="col" class="listViewThS1"  nowrap>Year Level</td>
		<td scope="col" class="listViewThS1"  nowrap>Course</td>
		<td scope="col" class="listViewThS1"  nowrap>Sched Code </td>
		<td scope="col" class="listViewThS1"  nowrap>Subject </td>
		<td scope="col" class="listViewThS1"  nowrap>Instructor </td>
		{if $droom eq 1}
		  <td scope="col" class="listViewThS1"  nowrap>Room </td>
		{/if}
		{if $dstartTime eq 1}
		  <td scope="col" class="listViewThS1"  nowrap>Start Time </td>
		{/if}
		{if $dendTime eq 1}
		  <td scope="col" class="listViewThS1"  width="70" nowrap>End Time </td>
		{/if}
		{if $ddays eq 1}
		  <td scope="col" class="listViewThS1" width="120" nowrap>Days </td>
		{/if}
		<td scope="col" class="listViewThS1"  nowrap>Status </td>
		<td scope="col" class="listViewThS1"  nowrap>&nbsp; </td>
		{if $dnoEnrolled eq 1}
    	   <td scope="col" class="listViewThS1"  nowrap># Enrolled </td>
    	{/if}
    	{if $dmaxCapacity eq 1}
		  <td scope="col" class="listViewThS1"  nowrap>Max Capacity </td>
		{/if}
		{if $dremarks eq 1}
		  <td scope="col" class="listViewThS1"  nowrap>Remarks </td>
		{/if}
		<td scope="col" class="listViewThS1"  nowrap>Apply</td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php">
	    <input type="hidden" name="module" value="Schedules" />
	    <input type="hidden" name="action" value="listSchedules" />
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">{$SCHOOLYEAR}</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">{$SEMESTERS}</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1" >
		<slot> {$YEARLEVEL}</slot>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1" >
		<slot>
        <select name="courseID" id="courseID" onchange="getSubjects();">
        <option value="">-------------------</option>
        {section name=i loop=$courselist}
        <option value="{$courselist[i].courseID}" {if $courselist[i].courseID eq $courseID} selected {/if}>{$courselist[i].courseCode}</option>
        {/section}
        </select>
        </slot>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="schedCode" id="schedCode" size="15" value="{$schedCode}" maxlength="10" onkeypress="return keyRestrict(event, 0);"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1" >
		<slot>
        <select name="subjID" id="subjID">
        <option value="">-------------------------------------------------------</option>
        {section name=i loop=$subjlist}
        <option value="{$subjlist[i].subjID}" {if $subjlist[i].subjID eq $subjID} selected {/if}>{$subjlist[i].subjCode} &nbsp;{$subjlist[i].descTitle}&nbsp; {if $subjlist[i].type eq 2} (Lab){/if}</option>
        {/section}
        </select>
        </slot>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<slot>
			<select name="profID" id="profID"  >
            {if $isInstructorGroup eq 0}
			<option value="">---------------------------------------</option>
			{/if}
		    {section name=i loop=$user_list}
		    <option value="{$user_list[i].id}" {if $user_list[i].id eq $profID}selected{/if}>{$user_list[i].last_name}, {$user_list[i].first_name}</option>
		    {/section}
		    </select>
		</slot>
		</td>
		{if $droom eq 1}
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="room" id="room" size="7" value="{$room}" maxlength="10" onkeypress="return keyRestrict(event, 5);"/></td>
		{/if}
		{if $dstartTime eq 1}
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		{/if}
		{if $dendTime eq 1}
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		{/if}
		{if $ddays eq 1}
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		{/if}
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
			<select name="rstatus" id="rstatus">
		        <option value="">----------------</option>
		        <option value="0" {if $rstatus eq "0"} selected {/if}> Closed </option>
		        <option value="1" {if $rstatus eq "1"} selected {/if}> Open </option>
		    </select> 
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		{if $dnoEnrolled eq 1}
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp; </td>
		{/if}
		{if $dmaxCapacity eq 1}
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		{/if}
		{if $dremarks eq 1}
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="remarks" id="remarks" value="{$remarks}" maxlength="10" onkeypress="return keyRestrict(event, 7);"/></td>
		{/if}
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
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].schYear}</td>
	
			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].semCode eq 1} 1st Sem {/if} {if $list[i].semCode eq 2} 2nd Sem {/if} {if $list[i].semCode eq 4} Summer {/if}</td>
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].yrLevel}</td>	
	
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
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Schedules&action=viewSchedule&schedID={$list[i].schedID}" class="listViewTdLinkS1">{$list[i].schedCode}</a><span></td>	
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Schedules&action=viewSchedule&schedID={$list[i].schedID}" class="listViewTdLinkS1">{$list[i].subjCode} &nbsp;{$list[i].descTitle} &nbsp; {if $list[i].type eq 2} (Lab){/if}</a></span></td>	
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].profName}</td>	
	
		    {if $droom eq 1}
    			<td scope="row"
    	        {if i%2 eq 0}
    	            class="evenListRowS1" bgcolor="#fdfdfd" 
    	        {else}
    	            class="oddListRowS1" bgcolor="#ffffff" 
    	        {/if}
    	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].room}</td>	
			{/if}

			{if $dstartTime eq 1}
        		<td scope="row"
                {if i%2 eq 0}
                    class="evenListRowS1" bgcolor="#fdfdfd" 
                {else}
                    class="oddListRowS1" bgcolor="#ffffff" 
                {/if}
                align="left" bgcolor="#fdfdfd" valign="top">{$list[i].startTime|date_format:"%I:%M %p"}</td>	
			{/if}

			{if $dendTime eq 1}
    			<td scope="row"
    	        {if i%2 eq 0}
    	            class="evenListRowS1" bgcolor="#fdfdfd" 
    	        {else}
    	            class="oddListRowS1" bgcolor="#ffffff" 
    	        {/if}
    	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].endTime|date_format:"%I:%M %p"}</td>	
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
        		</td>
    		{/if}

    		<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top">{if $list[i].rstatus eq 1} Open {/if} {if $list[i].rstatus eq 0} Closed {/if}</td>	
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><img src="themes/Sugar/images/classroster.gif" border="0" onclick="popUp('index.php?module=Reports&action=classRosterCol&schedID={$list[i].schedID}&sugar_body_only=1');"><span></td>	
	
			{if $dnoEnrolled eq 1}
        		<td scope="row"
                {if i%2 eq 0}
                    class="evenListRowS1" bgcolor="#fdfdfd" 
                {else}
                    class="oddListRowS1" bgcolor="#ffffff" 
                {/if}
                align="center" bgcolor="#fdfdfd" valign="top">{$list[i].noEnrolled}</td>	
			{/if}

			{if $dmaxCapacity eq 1}
    			<td scope="row"
    	        {if i%2 eq 0}
    	            class="evenListRowS1" bgcolor="#fdfdfd" 
    	        {else}
    	            class="oddListRowS1" bgcolor="#ffffff" 
    	        {/if}
    	        align="center" bgcolor="#fdfdfd" valign="top">{$list[i].maxCapacity}</td>	
			{/if}
			
            {if $dremarks eq 1}
    			<td scope="row"
    	        {if i%2 eq 0}
    	            class="evenListRowS1" bgcolor="#fdfdfd" 
    	        {else}
    	            class="oddListRowS1" bgcolor="#ffffff" 
    	        {/if}
    	        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].remarks}</td>	
			{/if}

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
