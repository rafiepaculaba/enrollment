<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>User</h2></td>
	</tr>
</tbody>
</table>
<p>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" width="11" border="0" height="11">&nbsp;User Groups</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" width="1" height="1"></td>

	</tr>
</tbody></table>
</p>
<p>
<table class="listView" width="100%" border="0" cellpadding="0" cellspacing="0"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="15%" nowrap="nowrap">Group ID</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap="nowrap">User Group Name</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap="nowrap">Description</td>
	</tr>
    <?php foreach ($record as $value):?>
	<!-- Start of UserGroup Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" class="evenListRowS1" valign="top" align="left" ><span sugar="sugar0b"><a href="index.php?user_group/view/<?php echo $value->groupID;?>" class="listViewTdLinkS1"><?php echo $value->groupID;?></a></span></td>
		<td scope="row" class="evenListRowS1" valign="top" align="left" ><span sugar="sugar0b"><a href="index.php?user_group/view/<?php echo $value->groupID;?>" class="listViewTdLinkS1"><?php echo $value->groupName;?></a></span></td>
		<td scope="row" class="evenListRowS1" valign="top" align="left" ><?php echo $value->description;?></td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php endforeach; ?>
	<!-- End of UserGroup Listing -->
	</tbody>

</table>
</p>
