
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>Role</h2></td>
	</tr>
</tbody>
</table>

<form name="frmViewRole" id="frmViewRole" method="POST" action="index.php?role/edit/<?php echo $roleID; ?>" >
<input type="hidden" name="roleID" id="roleID" value="<?php echo $roleID; ?>" />
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
    	<td>
    		 <input class="button" name="cmdBacktoList" type="button" id="cmdBacktoList" value="Back To List"/>
    		 <input class="button" name="cmdEdit" type="submit" id="cmdEdit" value="Edit" />
             <input class="button" name="cmdDelete" type="button" id="cmdDelete" value="Delete"/>
        </td>
    </tr>
</table>
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="4" align="left" class="tabDetailViewDL"><h4 class="tabDetailViewDL">View Role</h4></th>
	</tr>
	<tr>
		<td class="tabDetailViewDL" align="right" ><slot>Role Name : </slot></td>
      	<td class="tabDetailViewDF" width="82%"><slot><?php echo $roleName; ?> &nbsp;</slot></td>
	</tr>	
	<tr>
		<td class="tabDetailViewDL" align="right" ><slot>Description : </slot></td>
		<td class="tabDetailViewDF" width="82%"><slot><?php echo $description; ?> &nbsp;</slot></td>
	</tr>
</table>
</form>

<!--Javascripts-->
<script language="javascript">
    $('#cmdDelete').click(
    function()
    {
        reply=confirm("Do you really want to delete this role?");
        
        if (reply==true)
            window.location='index.php?role/delete/<?php echo $roleID; ?>';
    }
    );

	$('#cmdBacktoList').click(
    function()
    {
        window.location='index.php?role/listview';
    }
    );
</script>