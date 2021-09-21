<form name="frmSchedule" id="frmSchedule" method="post" action="index.php?module=Schedules&action=saveSchedule">
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="validateTime();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=Schedules&action=listSchedules')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td>
	    <table border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tr>
		        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create College Schedule</h4></th>
		    </tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>School Year <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
			        {$SCHOOLYEAR}
		        </slot>
		        </td>
		   	</tr>
	    </table>
	</td></tr>
</table>
</p>
</form>