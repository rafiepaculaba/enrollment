<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>User </h2></td>
	</tr>
</tbody>
</table>

<p>
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td>
		 <input class="button" name="cmdEdit" type="button" id="cmdEdit" value=" Save " onclick="" />
         <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="" />
    </td>
    <td nowrap="nowrap" align="right">
		<span class="required">*</span>	Indicates required field
	</td>
</tr>
</table>
</p>

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<th class="dataField" colspan="6" align="left"><h4 class="dataLabel">Create Role</h4></th>
</tr>
<tr>
	<td class="dataLabel" width="10%" height="20"><slot>Name: <span class="required">*</span></slot></td>
	<td class="dataField" width="90%">
	<slot>
	<input name="gname" id="gname" size="40" maxlength="100" value="" type="text">
	</slot>
	</td>
</tr>
<tr>
	<td class="dataLabel" width="10%" height="20"><slot>Description: <span class="required">*</span></slot></td>
	<td class="dataField" width="90%">
	<slot>
	<textarea name="gdesc" id="gdesc" rows="5" cols="50"></textarea>
	</slot>
	</td>
</tr>
</table>
</p>

