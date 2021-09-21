<form name="frmBlockSection" id="frmBlockSection" method="post" action="index.php?module=Schedules&action=saveBlockSectionElem">
<p>

<input type="hidden" id="theForm" name="theForm" value="createBlockSection" />
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="onCheckDuplicateSection();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Schedules&action=listBlockSectionsElem')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create Block Section</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="15%"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" width="35%"><slot>{$SCHOOLYEAR} </slot></td>
        <td class="dataLabel" width="15%"><slot>&nbsp;</slot></td>
        <td class="dataField" width="35%"><slot>&nbsp; </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Section Name <span class="required">*</span></slot> </td>
        <td class="dataField"><slot><input type="text" name="secName" id="secName" maxlength="20" onkeypress="return keyRestrict(event, 5);"/> </slot>  </td>
        <td class="dataLabel"><slot>Grade <span class="required">*</span></slot></td>
        <td class="dataField">
        <slot>
        <select name="yrLevel" id="yrLevel" onchange="getSchedules(0);">
        <option value="">-------------</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="S">Special</option>
        </select>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" valign="top"><slot><!--Remarks--> Adviser </slot></td>
        <td class="dataField">
<!--        <slot><textarea name="remarks" id="remarks" cols="35" onkeypress="return limitLength(event, 'remarks',150);"></textarea></slot>-->
        <slot><input type="text" name="remarks" id="remarks" maxlength="70" size="50" onkeypress="return keyRestrict(event, 12);"/></slot>
        </td>
        <td class="dataLabel" valign="top"><slot>Max Capacity <span class="required">*</span></slot></td>
        <td class="dataField" valign="top"><slot><input type="text" name="maxCapacity" id="maxCapacity" size="10" maxlength="3" onkeypress="return keyRestrict(event, 0);"/> </slot>  </td>
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
		<td class="dataField" width="35%">
		<slot>
		<select name="schedID" id="schedID" onclick="check_form('frmBlockSection');">
        <option value="">------------------------------------------</option>
        {section name=i loop=$schedList}
        <option value="{$schedList[i].schedID}">{$schedList[i].schedCode}</option>
        {/section}
        </select>
		</slot>
		<slot><input name="cmdAdd" id="cmdAdd" class="button" type="button" value="  Add  " onclick="onCheckDuplicate();" /></slot>
		</td>
		<td class="dataLabel" width="50%">
		<slot>&nbsp;</slot>
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
</tbody>
</table>
</div>
