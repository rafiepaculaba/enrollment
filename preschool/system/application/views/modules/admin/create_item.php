<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>Item</h2></td>
	</tr>
</tbody>
</table>

<p>
<form name="frmCreateItem" id="frmCreateItem" method="POST" action="index.php?admin/save_item" onsubmit="return check_form('frmCreateItem');">
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td>
		 <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " />
         <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="window.location='index.php?ph/listview'" />
    </td>
    <td nowrap="nowrap" align="right">
		<span class="required">*</span>	Indicates required field
	</td>
</tr>
</table>
</p>

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="4" align="left" class="dataLabel"><h4 class="dataLabel">New Test Item</h4></th>
	</tr>
	<tr>
		<td class="dataLabel" align="right" width="18%"><slot>Item Code <span class="required">*</span></slot></td>
      	<td class="dataField" width="82%"><slot><input type="text" name="itemCode" value="" onkeypress="return keyRestrict(event,5);"/></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Item Name <span class="required">*</span></slot></td>
      	<td class="dataField" ><slot><input type="text"  name="itemName" id="itemName" value="" size="40" onkeypress="return keyRestrict(event,3) ;" /></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Description <span class="required">*</span></slot></td>
      	<td class="dataField" ><slot><textarea name="desc" cols="35" rows="2"> </textarea  ></slot></td>
	</tr>
	
</table>
</form>
</p>

<script>
addToValidate('frmCreateItem','itemCode', '', true, 'Item Code');
addToValidate('frmCreateItem','itemName', '', true, 'Item Name');
addToValidate('frmCreateItem','desc', '', true, 'Description');
</script>