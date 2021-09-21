<form name="frmCopyScheduleHS" id="frmCopyScheduleHS" method="post" action="index.php?module=CopySchedules&action=copyAllSchedulesHS" onsubmit="return check_form('frmCopyScheduleHS')">
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Copy Schedules "/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=CopySchedules&action=copySchedulesHS')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td>
	    <table border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tr>
		        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Copy High School Schedule</h4></th>
		    </tr>
		    <tr>
		    <td class="dataField" colspan="4"> &nbsp;</td>
		    </tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Year Level <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%" colspan="3"><slot>{$YEARLEVEL}</slot></td>
		   	</tr>
		    <tr>
		    <td class="dataField" colspan="4"> &nbsp;</td>
		    </tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>From School Year <span class="required">*</span></slot></td>
		        <td class="dataField" width="32%">
		        <slot>
			        {$FROMSCHOOLYEAR}
		        </slot>
		        </td>
		        <td class="dataLabel" width="18%"><slot>To School Year <span class="required">*</span></slot></td>
		        <td class="dataField" width="32%">
		        <slot>
			        {$TOSCHOOLYEAR}
		        </slot>
		        </td>
		   	</tr>
	    </table>
	</td></tr>
</table>
</p>
</form>