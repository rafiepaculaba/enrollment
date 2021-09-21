<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>View Item</h2></td>
	</tr>
</tbody>
</table>

<?php foreach ($record as $row): ?>
<form name="frmCreateItem" id="frmCreateItem" method="POST" action="index.php?admin/edit_item/<?php echo $row->itemID; ?>" >
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td>
		 <input class="button" name="cmdBacktoList" type="button" id="cmdBacktoList" value="Back To List" onclick="window.location='index.php?admin/item_list'"/>
		 <input class="button" name="cmdEdit" type="submit" id="cmdEdit" value="Edit" />
         <input class="button" name="cmdDelete" type="button" id="cmdDelete" value="Delete" onclick="deleteItem();"/>
    </td>
</tr>
</table>
</p>



<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="4" align="left" class="tabDetailViewDL"><h4 class="tabDetailViewDL">Test Item</h4></th>
	</tr>
	<tr>
		<td class="tabDetailViewDL" align="right" width="18%"><slot>Item Code : </slot></td>
		<td class="tabDetailViewDF" width="82%"><slot><?php echo $row->itemCode; ?> &nbsp;</slot></td>
	</tr>
	<tr>
		<td class="tabDetailViewDL" align="right" ><slot>Item Name : </slot></td>
      	<td class="tabDetailViewDF" width="82%"><slot><?php echo $row->itemName; ?> &nbsp;</slot></td>
	</tr>
	<tr>
		<td class="tabDetailViewDL" align="right" ><slot>Description : </slot></td>
		<td class="tabDetailViewDF" width="82%"><slot><?php echo $row->desc; ?> &nbsp;</slot></td>
	</tr>
	
<script language="javascript">
	function deleteItem()
	{
    reply=confirm("Do you really want to delete this Item?");
    
    if (reply==true)
        window.location='index.php?admin/delete_item/<?php echo $row->itemID; ?>'
	}
</script>
	
<?php endforeach; ?>
</table>
</form>
</p>

