
<form name="frmEditUser" id="frmEditUser" method="POST" action="index.php?user/save/<?php echo $userID; ?>" onsubmit="return check_form('frmEditUser');">
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
		 <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " />
         <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="window.location='index.php?user/view/<?php echo $userID; ?>'"/>
    </td>
    <td nowrap="nowrap" align="right">
		<span class="required">*</span>	Indicates required field
	</td>
</tr>
</table>
</p>
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="2" align="left" class="dataLabel"><h4 class="dataLabel">Edit User</h4></th>
	</tr>
	<tr>
		<td class="dataLabel" width="18%" align="right"><slot>User name <span class="required">*</span></slot></td>
      	<td class="dataField" width="82%"><slot><input type="text" name="userName" value="<?php echo $userName; ?>" readonly/></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Password <span class="required">*</span></slot></td>
      	<td class="dataField" ><slot><input type="password" size="40" name="userPswd" id="userPswd" value="<?php echo $userPswd; ?>" /></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Re-type Password <span class="required">*</span></slot></td>
      	<td class="dataField" ><slot><input type="password" size="40" name="reuserPswd" id="reuserPswd" value="<?php echo $userPswd; ?>" /></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>User group <span class="required">*</span></slot></td>
      	<td class="dataField" >
      	<slot>
      		<select name="groupID">
      			<option value="">----------------------------------</option>
      			<?php foreach ($usergroups as $value):?>
      			<?php if ($groupID == $value->groupID) { ?>
      			   <option value="<?php echo $value->groupID; ?>" selected><?php echo $value->groupName; ?></option>
      			<?php } else {?>
      			   <option value="<?php echo $value->groupID; ?>"><?php echo $value->groupName; ?></option>
      			<?php } endforeach; ?>
      		</select>
      	</slot>
      	</td>
	</tr>
</table>
</p>

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="4" align="left" class="dataLabel"><h4 class="dataLabel">Personal Info</h4></th>
	</tr>
	<tr>
      	<td class="dataField" colspan="6" >&nbsp;</td>
	</tr>
	<tr>
        <td class="dataLabel" width="18%"><slot>Complete Name <span class="required">*</span></slot></td>
        <td class="dataField" width="82%"colspan="3">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%"><slot><input name="lastName" id="lastName" size="25" maxlength="25" value="<?php echo $lastName; ?>" onkeypress="return keyRestrict(event, 12);" type="text"></slot>&nbsp;,</td>
                <td width="30%"><slot><input name="firstName" id="firstName" size="25" maxlength="25" value="<?php echo $firstName; ?>" onkeypress="return keyRestrict(event, 12);" type="text"></slot></td>
                <td width="40%"><slot><input name="middleName" id="middleName" size="25" maxlength="25" value="<?php echo $middleName; ?>" onkeypress="return keyRestrict(event, 12);" type="text"></slot></td>
            </tr>
            </tbody></table>
        </td>
    </tr>
    <tr>

        <td class="dataLabel"><slot>&nbsp;</slot></td>
        <td class="dataField" colspan="3" valign="top">
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
        <td class="dataLabel" width="18%"><slot>Contact </slot></td>
        <td class="dataField" width="82%"colspan="3">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%"><slot><input name="telNum" id="telNum" size="25" maxlength="25" value="<?php echo $localNum; ?>" onkeypress="return keyRestrict(event, 12);" type="text"></slot></td>
                <td width="30%"><slot><input name="localNum" id="localNum" size="25" maxlength="25" value="<?php echo $telNum; ?>" onkeypress="return keyRestrict(event, 12);" type="text"></slot></td>
                <td width="40%"><slot>&nbsp;</slot></td>
            </tr>
            </tbody></table>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>&nbsp;</slot></td>
        <td class="dataField" colspan="3" valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%">Local</td>
                <td width="30%">Tel No.</td>
                <td width="40%">&nbsp;</td>
            </tr>

            </tbody></table>
        </td>
    </tr>
</table>
</form>
</p>

<script language="javascript">
addToValidate('frmEditUser','userName', '', true, 'User Name');
addToValidate('frmEditUser','userPswd', '', true, 'Password');
addToValidate('frmEditUser','reuserPswd', '', true, 'Password Confirmation');
addToValidate('frmEditUser','groupID', '', true, 'User Group');
addToValidate('frmEditUser','lastName', '', true, 'Last Name');
addToValidate('frmEditUser','firstName', '', true, 'First Name');
addToValidate('frmEditUser','middleName', '', true, 'Middle Name');

$('#cmdSave').click(
//  check if password and retypr password matched
    function() { 
        if($('#userPswd').val() == $('#reuserPswd').val()){
            submit_user();
        } else {
            alert('Error: Password did not matched!!!');
        }
    }
    );
    
    
    function submit_user()
    {
        if (check_form('frmEditUser')) {
            $.post(base_url+'index.php?user/isExist/'+$('#userName').val(),
                function(data) {
                        if (data==1) {
                            document.getElementById('frmEditUser').submit();
//                            alert('Duplicate User Name');
                        } else {
                            // execute saving
                            document.getElementById('frmEditUser').submit();
                        }
                    }
                )
        }
    }    

$('#cmdCancel').click(
    function() 
    {
    window.location='index.php?user/listview';
    }
    );

$('#userName').keypress(
    function(event) 
    {
        return check_keyrestrict_5(event);
    }
    );

$('#firstName').keypress(
    function(event) 
    {
        return check_keyrestrict_3(event);
    }
    );
    
$('#middleName').keypress(
    function(event) 
    {
        return check_keyrestrict_3(event);
    }
    );

$('#telNum').keypress(
    function(event) 
    {
        return check_keyrestrict_1(event);
    }
    );

$('#localNum').keypress(
    function(event) 
    {
        return check_keyrestrict_1(event);
    }
    );

</script>