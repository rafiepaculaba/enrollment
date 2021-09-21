
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>HOME</h2></td>
	</tr>
</tbody>
</table>

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