<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>User </h2></td>
	</tr>
</tbody>
</table>

<?php foreach ($record as $row): ?>
<form name="frmCreateUser" id="frmCreateUser" method="POST" action="index.php?admin/edit_user/<?php echo $row->userID; ?>" >
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td>
		 <input class="button" name="cmdBacktoList" type="button" id="cmdBacktoList" value="Back To List" onclick="window.location='index.php?admin/list_user'"/>
		 <input class="button" name="cmdEdit" type="submit" id="cmdEdit" value="Edit" />
         <input class="button" name="cmdDelete" type="button" id="cmdDelete" value="Delete" onclick="deleteUser();"/>
    </td>
</tr>
</table>
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="2" align="left" class="tabDetailViewDL"><h4 class="tabDetailViewDL">View User</h4></th>
	</tr>
	<tr>
		<td class="tabDetailViewDL" width="18%" align="right"><slot>User name : </slot></td>
      	<td class="tabDetailViewDF" width="82%"><slot><?php echo $row->userName; ?> &nbsp;</slot></td>
    </tr>
	<tr>
		<td class="tabDetailViewDL" align="right" ><slot>Password : </slot></td>
      	<td class="tabDetailViewDF" ><slot><?php echo $row->userPswd; ?>&nbsp;</slot></td>
	</tr>
	<tr>
		<td class="tabDetailViewDL" align="right" ><slot>Department : </slot></td>
      	<td class="tabDetailViewDF" ><?php echo $row->deptID; ?>&nbsp;</td>
	</tr>
	<tr>
		<td class="tabDetailViewDL" align="right" ><slot>User group : </slot></td>
      	<td class="tabDetailViewDF" ><?php echo $row->groupID; ?>&nbsp;</td>
	</tr>
</table>
</p>

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="4" align="left" class="tabDetailViewDL"><h4 class="tabDetailViewDL">Personal Info</h4></th>
	</tr>
	<tr>
        <td class="tabDetailViewDL" width="18%"><slot>Complete Name : </slot></td>
        <td class="tabDetailViewDF" width="82%"colspan="3">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%"><slot><?php echo $row->lastName; ?></slot>&nbsp;,</td>
                <td width="30%"><slot><?php echo $row->firstName; ?></slot></td>
                <td width="40%"><slot><?php echo $row->middleName; ?></slot></td>
            </tr>
            </tbody></table>
        </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" colspan="3" valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%">Last Name</td>
                <td width="30%">First Name</td>
                <td width="40%">Middle Name</td>
            </tr>

            </tbody></table>
        </td>
    </tr>
	<tr>
        <td class="tabDetailViewDL" width="18%"><slot>Contact : </slot></td>
        <td class="tabDetailViewDF" width="82%"colspan="3">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%"><slot><?php echo $row->localNum; ?>&nbsp;</slot></td>
                <td width="30%"><slot><?php echo $row->telNum; ?> &nbsp;</slot></td>
                <td width="40%"><slot>&nbsp;</slot></td>
            </tr>
            </tbody></table>
        </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" colspan="3" valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%">Local</td>
                <td width="30%">Tel No.</td>
                <td width="40%">&nbsp;</td>
            </tr>
            
<script language="javascript">
function deleteUser()
{
    reply=confirm("Do you really want to delete this User?");
    
    if (reply==true)
        window.location='index.php?admin/delete_user/<?php echo $row->userID; ?>'
}
</script>

<?php endforeach; ?>
            </tbody></table>
        </td>
    </tr>
</table>
</form>
</p>

