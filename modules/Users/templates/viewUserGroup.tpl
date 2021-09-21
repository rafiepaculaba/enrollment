<table width="100%" border="0">
  <tr>
    <td>
   <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Users&action=listUserGroups');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Users&action=editUserGroup&groupID={$groupID}');" />
    {/if}
    
    {if $hasDelete eq 1 }
    <input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteUserGroup('{$groupID}');" />
    {/if}
  </tr>
</table>   

<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<th colspan="4" class="tabDetailViewDL" align="left" valign="top" width="100%"><h4 class="tabDetailViewDL"><slot>User Group</slot></h4></th>
</tr>
<tr>
	<td class="tabDetailViewDL" height="20" width="10%"><slot>Name: </slot></td>
	<td class="tabDetailViewDF" width="90%"><slot>{$gname}</slot></td>
</tr>
<tr>
	<td class="tabDetailViewDL" height="20" width="10%"><slot>Description: </slot></td>
	<td class="tabDetailViewDF" width="90%"><slot>{$gdesc}</slot></td>
</tr>
</tbody>
</table>

