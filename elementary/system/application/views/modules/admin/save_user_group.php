<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>Save User</h2></td>
	</tr>
</tbody>
</table>

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
	<?php if ($flag == '1') { ?>
		<th colspan="4" align="left" class="dataLabel"><h4 class="dataLabel">Record successfully updated</h4></th>
	<?php } else { ?>
	<th colspan="4" align="left" class="dataLabel"><h4 class="dataLabel">Record successfully saved</h4></th>
	<?php } ?>
	</tr>
</table>
<?php 
	echo '<meta HTTP-EQUIV="REFRESH" content="1; url=index.php?admin/view_user_group/'.$this->User_Group_model->groupID.'">'
?>
</p>