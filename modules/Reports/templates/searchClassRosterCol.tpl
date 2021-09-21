<form name="frmClassRoster" id="frmClassRoster" method="post" >
<p>
<input type="hidden" id="theForm" name="theForm" value="gradesheet" />
<table width="100%" border="0">
  <tr>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Search College Class Roster</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="20%"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" width="30%"><slot> {$SCHOOLYEAR}</slot></td>
        <td class="dataLabel" width="20%"><slot>Semester <span class="required">*</span></slot></td>
        <td class="dataField" width="30%"><slot> {$SEMESTERS}</slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Instructor <span class="required">*</span></slot></td>
        <td class="dataField" colspan="3">
        <slot> 
        <select name="profID" id="profID" onchange="getSchedules();">
        {if $isInstructorGroup eq 0}
        	<option value="">-----------------------------</option>
        {/if}
        
        {section name=i loop=$PROFLIST}
        <option value="{$PROFLIST[i].id}">{$PROFLIST[i].last_name} , {$PROFLIST[i].first_name}</option>
        {/section}
        </select>
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Sched Code <span class="required">*</span></slot></td>
        <td class="dataField" colspan="3">
        <slot>
        <select name="schedID" id="schedID" onchange="getSubject();">
        <option value="">-----------------------------</option>
        {section name=i loop=$SCHEDLIST}
        <option value="{$SCHEDLIST[i].schedID}">{$SCHEDLIST[i].schedCode}</option>
        {/section}
        </select>
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Subject </slot></td>
        <td class="dataField" colspan="3"><input type="text" name="subject" id="subject" value="" size="50" readonly /><slot>&nbsp;</slot> </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Units </slot></td>
        <td class="dataField"><slot><input type="text" name="units" id="units" value="" readonly /></slot> </td>
        <td class="dataLabel"><slot>Room </slot></td>
        <td class="dataField"><slot><input type="text" name="room" id="room" value="" readonly /></slot> </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Time </slot></td>
        <td class="dataField"><slot><input type="text" name="time" id="time" value="" readonly /></slot> </td>
        <td class="dataLabel"><slot>Days </slot></td>
        <td class="dataField"><slot><input type="text" name="days" id="days" value="" readonly /></slot> </td>
    </tr>
    <tr>
        <td class="dataLabel" valign="top"><slot>Remarks </slot></td>
        <td class="dataField" colspan="3" align="left">
        <slot><textarea name="remarks" id="remarks" rows="1" cols="45" onkeypress="return limitLength(event, 'remarks',150);" onkeypress="return keyRestrict(event, 12);" readonly></textarea></slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>


<div id="students" name="students">
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
	    <td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>ID No.</td>
		<td scope="col" class="listViewThS1" width="60%" nowrap>Student Name</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Course</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Year</td>
	</tr>
</tbody>
</table>
</div>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
		<td colspan="20" height="20">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="listViewPaginationTdS1" align="left" nowrap="nowrap" width="30%">&nbsp;&nbsp;
					<div id="printer">
					<a href="#" onclick="popUp('index.php?module=Reports&action=classRosterCol&schedID={$SCHEDLIST[i].schedID}&sugar_body_only=1');"" id="print_link"><img src="themes/Sugar/images/print.gif" alt="Export" align="absmiddle" border="0" height="9" width="11">&nbsp;Print</a>
					</div>
					</td>
				</tr>
			</tbody>
			</table>	    
	    </td>
	</tr>
</table>



</form>