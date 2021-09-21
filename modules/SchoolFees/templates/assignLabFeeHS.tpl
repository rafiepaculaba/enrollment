<form name="frmLabFeeHS" id="frmLabFeeHS" method="post" action="index.php?module=SchoolFees&action=saveLabFeeHS" >

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="saveLabFee();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=SchoolFees&action=listLabFeeHS')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Assign Laboratory Fee: High School</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" width="25%"><slot> {$SCHOOLYEAR} </slot></td>
    </tr>
    <tr>
    <td class="dataLabel" width="15%" colspan="4">
    </tr>
	<tr>
        <td class="dataLabel" width="15%"><slot>Sched Code <span class="required">*</span></slot></td>
        <td class="dataField" colspan="3">
        <slot>
			<div id="divSchedules">
	    		<select name="schedID" id="schedID" onchange="displaySchedule();">
	            <option value="">------------------------------</option>
	            {section name=i loop=$sched_list}
	            <option value="{$sched_list[i].schedID}">{$sched_list[i].schedCode}</option>
	            {/section}
	            </select>
	        </div>
        </slot>
        </td>
	</tr>
    <td class="dataLabel" width="15%" colspan="4">
    <tr>
        <td class="dataField" width="15%" colspan="4" align="left"><h4 class="dataLabel">Schedule Detail </h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Year Level </slot></td>
        <td class="dataField" width="25%"><slot>
          <input type="text" name="yrLevel" id="yrLevel" size="" maxlength="" readonly/>
        </slot></td>
        <td class="dataLabel" width="18%"><slot>Subject </slot></td>
        <td class="dataField" width="39%"><slot>
          <input type="text" name="subjCode" id="subjCode" size="40" maxlength="" readonly/>
        </slot></td>
    </tr>
        <td class="dataLabel"><slot>Max Capacity </slot></td>
        <td class="dataField"><slot>
          <input type="text" name="maxCapacity" id="maxCapacity" size="" maxlength="" readonly/>
        </slot></td>
        <td class="dataLabel"><slot>Instructor </slot></td>
        <td class="dataField"><slot>
          <input type="text" name="profName" id="profName" size="40" maxlength="" readonly/>
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Room </slot></td>
        <td class="dataField"><slot>
          <input type="text" name="room" id="room" size="" maxlength="" readonly/>
        </slot></td>
        <td class="dataLabel"><slot>Days </slot></td>
        <td class="dataField"><slot>
          <input type="text" name="days" id="days" size="40" maxlength="" readonly/>
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Time </slot></td>
        <td class="dataField"><slot>
          <input type="text" name="time" id="time" size="" maxlength="" readonly/>
        </slot></td>
        <td class="dataLabel"><slot>Remarks </slot></td>
        <td class="dataField"><slot>
          <input type="text" name="remarks" id="remarks" size="40" maxlength="" readonly/>
        </slot></td>
    </tr>
    <td class="dataLabel" width="15%" colspan="4">
    <tr>
        <td class="dataLabel"><slot>Amount <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
          <input type="text" name="amount" id="amount" size="" maxlength="8" onkeypress="return keyRestrict(event, 1);" />
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>
