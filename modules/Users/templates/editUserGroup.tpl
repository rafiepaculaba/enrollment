<form method="post" action="index.php?module=Users&action=saveUserGroup">
<input name="groupID" id="groupID" value="{$groupID}" type="hidden" />
<input name="gstatus" id="gstatus" value="{$gstatus}" type="hidden" />
<p> <!-- Start of Adding/Removing Crew -->

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
	<td style="padding-bottom: 2px;">
	<input title="Save [Alt+S]" accesskey="S" class="button" onclick="this.form.action.value='Save';" name="cmdsave" value="  Save  " type="submit"> 
	<input title="Cancel [Alt+X]" accesskey="X" class="button" onclick="javascript: window.location='index.php?module=Users&action=viewUserGroup&groupID={$groupID}'" name="button" value="  Cancel  " type="button"></td>
	<td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
</tr></tbody>
</table>

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<th class="dataField" colspan="6" align="left"><h4 class="dataLabel">Edit User Group</h4></th>
</tr>
<tr>
	<td class="dataLabel" height="20" width="10%"><slot>Name: <span class="required">*</span></slot></td>
	<td class="dataField" width="90%">
	<slot>
	<input name="gname" id="gname" size="40" maxlength="100" value="{$gname}" type="text" />
	</slot>
	</td>
</tr>
<tr>
	<td class="dataLabel" height="20" width="10%"><slot>Description: <span class="required">*</span></slot></td>
	<td class="dataField" width="90%">
	<slot>
	<textarea name="gdesc" id="gdesc" rows="5" cols="50">{$gdesc}</textarea>
	</slot>
	</td>
</tr>
</tbody>
</table>
</p> 

</form>