<table class="listView"  width="100%" cellspacing="0" cellpadding="0" border="0">
  <?php foreach ($roles as $value):?>
	<tr onMouseOver="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onMouseOut="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onMouseDown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '') ;" height="20">
		<td scope="row" class="evenListRowS1" valign="top" bgcolor="#fdfdfd" ><?php echo $value->roleID;?></td>
		<td scope="row" class="evenListRowS1" valign="top" ><?php echo $value->roleName;?></td>
		<td scope="row" class="evenListRowS1" valign="top" ><?php echo $value->description;?></td>
	</tr>
	<?php endforeach;?>
</table>
</p>

  