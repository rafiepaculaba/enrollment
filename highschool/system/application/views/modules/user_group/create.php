<form name="frmCreateUserGroup" id="frmCreateUserGroup" method="POST" action="index.php?user_group/save" >
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>User Group</h2></td>
	</tr>
</tbody>
</table>

<p>
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td>
		 <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " />
         <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " />
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
<th class="dataField" colspan="6" align="left"><h4 class="dataLabel">Create User Group</h4></th>
</tr>
<tr>
	<td class="dataLabel" width="18%" height="20"><slot>User Group Name: <span class="required">*</span></slot></td>
	<td class="dataField" width="82%">
	<slot>
	<input name="groupName" id="groupName" size="40" maxlength="100" value="" type="text">
	</slot>
	</td>
</tr>
<tr>
	<td class="dataLabel" height="20" valign="top"><slot>Description: <span class="required">*</span></slot></td>
	<td class="dataField" >
	<slot>
	<textarea name="description" id="description" rows="5" cols="50"></textarea>
	</slot>
	</td>
</tr>
</table>
</p>
</form>

<script language="javascript">
addToValidate('frmCreateUserGroup','groupName', '', true, 'User Group Name');
addToValidate('frmCreateUserGroup','description', '', true, 'Description');


$('#cmdCancel').click(
    function() 
    {
        window.location='index.php?user_group/listview';
    }
    );
    
$('#cmdSave').click(
    function() 
    {
        if (check_form('frmCreateUserGroup')) {
            $.post(base_url+'index.php?user_group/isExist/'+$('#groupName').val(), 
                    function(data) {
                        if (data==1) {
                            alert('Duplicate User Group Name');
                        } else {
                            // execute saving
                            document.getElementById('frmCreateUserGroup').submit();
                        }
                    }
                )
        }
    }
    );
 

$('#groupName').keypress(
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