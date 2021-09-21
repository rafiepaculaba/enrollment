<form name="frmBlockSection" id="frmBlockSection" method="post" action="index.php?module=Schedules&action=saveBlockSectionCol">
<p>
<input type="hidden" id="theForm" name="theForm" value="createBlockSection" />
<input type="hidden" id="secID" name="secID" value="{$secID}" />
<input type="hidden" id="rstatus" name="rstatus" value="{$rstatus}" />
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " onclick="return check_form('frmBlockSection');" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Schedules&action=viewBlockSectionCol&secID={$secID}')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit Block Section</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="15%"><slot>School Year </slot></td>
        <td class="dataField" width="35%"><slot>{$SCHOOLYEAR} </slot></td>
        <td class="dataLabel" width="15%"><slot>Semester </slot></td>
        <td class="dataField" width="35%"><slot>{$SEMESTERS} </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Section Name </slot> </td>
        <td class="dataField" colspan="3"><slot><input type="text" name="secName" id="secName" value="{$secName}" readonly maxlength="20"/> </slot>  </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Course </slot> </td>
        <td class="dataField">
        <slot> 
        <select name="courseID" id="courseID" onchange="getSchedules();" disabled>
        <option value="">--------------------------------</option>
        {section name=i loop=$courseList}
        <option value="{$courseList[i].courseID}" {if $courseList[i].courseID eq $courseID} selected {/if}>{$courseList[i].courseCode}</option>
        {/section}
        </select>
        </slot>
        </td>
        <td class="dataLabel"><slot>Year </slot></td>
        <td class="dataField">
        <slot>
        <select name="yrLevel" id="yrLevel" disabled>
        <option value="">-------------</option>
        <option value="1" {if $yrLevel eq "1"} selected {/if}>1</option>
        <option value="2" {if $yrLevel eq "2"} selected {/if}>2</option>
        <option value="3" {if $yrLevel eq "3"} selected {/if}>3</option>
        <option value="4" {if $yrLevel eq "4"} selected {/if}>4</option>
        <option value="5" {if $yrLevel eq "5"} selected {/if}>5</option>
        <option value="6" {if $yrLevel eq "6"} selected {/if}>6</option>
        </select>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" valign="top"><slot>Remarks </slot></td>
        <td class="dataField" colspan="3">
        <slot><textarea name="remarks" id="remarks" cols="35" onkeypress="return limitLength(event, 'remarks',150);">{$remarks}</textarea></slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>

<form name="frmAddSchedule" id="frmAddSchedule" method="post">
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
		<th class="dataField" colspan="2" align="left"><h4 class="dataLabel"> Add Schedule</h4></th>
    </tr>
    
    <tr>
        <td class="dataLabel" width="15%">Sched Code </td>
		<td class="dataField" width="85%">
		<slot>
		<select name="schedID" id="schedID">
        <option value="">------------------------------------------</option>
        {section name=i loop=$schedList}
        <option value="{$schedList[i].schedID}">{$schedList[i].schedCode}</option>
        {/section}
        </select>
		</slot>
		<slot><input name="cmdAdd" id="cmdAdd" class="button" type="button" value="  Add  " onclick="onCheckDuplicate();" /></slot>
		</td>
	</tr>
</table>
</p>
</form>

<div id="divSchedules">
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Code</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Time</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Days</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Room</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Units</td>
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
        align="left" bgcolor="#fdfdfd" valign="top"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSchedule('{$list[i].schedID}');" /></td>
	
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
        align="left" bgcolor="#fdfdfd" valign="top"> {$list[i].time_display}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].days_display}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].room}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].units}</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of student Listing -->
	{/section}
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>{$total_units|number_format:1:".":","}</b></td>
	</tr>
</tbody>
</table>
</div>
