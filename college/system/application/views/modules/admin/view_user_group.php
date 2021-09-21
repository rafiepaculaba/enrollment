<?php foreach ($record as $row): ?>
<form name="frmViewUserGroup" id="frmViewUserGroup" action="index.php/edit_user_group" method="POST" onsubmit="return check_form('frmViewUserGroup');">
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
		 <input class="button" name="cmdBackToList" type="button" id="cmdBackToList" value=" Back To List " />
		 <input class="button" name="cmdEdit" type="submit" id="cmdEdit" value=" Edit " />
         <input class="button" name="cmdDelete" type="button" id="cmdDelete" value=" Delete " />
    </td>
</tr>
</table>
</p>
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<th class="tabDetailViewDL" colspan="6" align="left"><h4 class="tabDetailViewDL">View User Group</h4></th>
</tr>
<tr>
	<td class="tabDetailViewDL" width="10%" height="20"><slot>Name : </td>
	<td class="tabDetailViewDF" width="90%"><slot><?php echo $row->groupName; ?></slot></td>
</tr>
<tr>
	<td class="tabDetailViewDL" width="10%" height="20"><slot>Description :</slot></td>
	<td class="tabDetailViewDF" width="90%"><slot> <?php echo $row->groupDesc; ?>	</slot></td>
</tr>
</table>
</p>
</form>
<?php endforeach; ?>