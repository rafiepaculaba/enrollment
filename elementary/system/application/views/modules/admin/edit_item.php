<?php foreach ($record as $row): ?>
<form name="frmEditItem" id="frmEditItem" method="POST" action="index.php?admin/save_item/<?php echo $row->itemID; ?>" onsubmit="return check_form('frmEditItem');">

<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>Item</h2></td>
	</tr>
</tbody>
</table>

<p>
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td>
		 <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save "/>
         <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="window.location='index.php?admin/view_item/<?php echo $row->itemID; ?>'"/>
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
		<th colspan="4" align="left" class="dataLabel"><h4 class="dataLabel">Edit Test Item</h4></th>
	</tr>
	<tr>
		<td class="dataLabel" align="right" width="18%"><slot>Item Code <span class="required">*</span></slot></td>
      	<td class="dataField" width="82%"><slot><input type="text" name="itemCode" value="<?php echo $row->itemCode; ?>" /></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Item Name <span class="required">*</span></slot></td>
      	<td class="dataField" width="82%"><slot><input type="text" name="itemName" value="<?php echo $row->itemName; ?>" /></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Description <span class="required">*</span></slot></td>
      	<td class="dataField" width="82%"><slot><input type="text" name="desc" value="<?php echo $row->desc; ?>" /></slot></td>
	</tr>
</table>
</p>
<?php endforeach; ?>

<script>
addToValidate('frmEditItem','itemCode', '', true, 'Item Code');
addToValidate('frmEditItem','itemName', '', true, 'Item Name');
addToValidate('frmEditItem','desc', '', true, 'Description');
</script>