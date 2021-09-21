<form name="frmCreateUserRole" id="frmCreateUserRole" method="POST" action="index.php?role/save" >
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>User Roles</h2></td>
	</tr>
</tbody>
</table>

<p>
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td>
		 <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="" />
         <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="" />
    </td>
    <td nowrap="nowrap" align="right">
		<span class="required">*</span>	Indicates required field
	</td>
</tr>
</table>
</p>

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<th class="dataField" colspan="6" align="left"><h4 class="dataLabel">Create Role</h4></th>
</tr>
<tr>
	<td class="dataLabel" width="10%" height="20"><slot>Name: <span class="required">*</span></slot></td>
	<td class="dataField" width="90%">
	<slot>
	<input name="roleName" id="roleName" size="40" maxlength="100" value="" type="text">
	</slot>
	</td>
</tr>
<tr>
	<td class="dataLabel" width="10%" height="20" valign="top"><slot>Description: <span class="required">*</span></slot></td>
	<td class="dataField" width="90%">
	<slot>
	<textarea name="description" id="description" rows="5" cols="50"></textarea>
	</slot>
	</td>
</tr>
</table>
</p>
</form>

<script language="javascript">
addToValidate('frmCreateUserRole','roleName', '', true, 'User Role Name');
addToValidate('frmCreateUserRole','description', '', true, 'Description');

$('#cmdCancel').click(
    function() 
    {
        window.location='index.php?role/listview';
    }
    );
    
$('#cmdSave').click(
    function() 
    {
        if (check_form('frmCreateUserRole')) {
            $.post(base_url+'index.php?role/isExist/'+$('#roleName').val(),
                    function(data) {
                        if (data==1) {
                            alert('Duplicate Role Name');
                        } else {
                            // execute saving
                            document.getElementById('frmCreateUserRole').submit();
                        }
                    }
                )
        }
    }
    );
 

$('#roleName').keypress(
    function(event) 
    {
        return check_keyrestrict_5(event);
    }
    );

$('#description').keypress(
    function(event) 
    {
        return check_keyrestrict_5(event);
    }
    );
</script>