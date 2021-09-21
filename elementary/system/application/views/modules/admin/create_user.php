<form name="frmCreateUser" id="frmCreateUser" method="POST" action="index.php?admin/save_user" onsubmit="return check_form('frmCreateUser');">
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
		 <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " />
         <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="window.location='index.php?admin/list_user'" />
    </td>
    <td nowrap="nowrap" align="right">
		<span class="required">*</span>	Indicates required field
	</td>
</tr>
</table>
</p>

<?php
if($this->validation->error_string) {
	
	$userName 		= trim($this->input->get_post('userName'));
	$userPswd 		= trim($this->input->get_post('userPswd'));
	$reuserPswd 	= trim($this->input->get_post('reuserPswd'));
	$deptID 		= trim($this->input->get_post('deptID'));
	$groupID 		= trim($this->input->get_post('groupID'));
	$lastName 		= trim($this->input->get_post('lastName'));
	$firstName 		= trim($this->input->get_post('firstName'));
	$middleName 	= trim($this->input->get_post('middleName'));
	$telNum 		= trim($this->input->get_post('telNum'));
	$localNum		= trim($this->input->get_post('localNum'));
}
?>

</div>
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="2" align="left" class="dataLabel"><h4 class="dataLabel">Create User</h4></th>
	</tr>
	<tr>
		<td class="dataLabel" width="18%" align="right"><slot>User name <span class="required">*</span></slot></td>
      	<td class="dataField" width="82%"><slot><input type="text" name="userName" value="<?php if($this->validation->error_string) { echo $userName;} ?>" onkeypress="return keyRestrict(event, 3);"/></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Password <span class="required">*</span></slot></td>
      	<td class="dataField" ><slot><input type="password" size="40" name="userPswd" value="<?php if($this->validation->error_string) {echo $userName;} ?>" onkeypress="return keyRestrict(event, 3);"/></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Re-type Password <span class="required">*</span></slot></td>
      	<td class="dataField" ><slot><input type="password" size="40" name="reuserPswd" value="<?php if($this->validation->error_string) { echo $userName; } ?>" onkeypress="return keyRestrict(event, 3);"/></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Department <span class="required">*</span></slot></td>
      	<td class="dataField" >
      	<slot>
      		<select name="deptID">
      			<option value="">----------------------------------</option>
      			<option <?php if($this->validation->error_string) { if ($deptID == '1') echo 'selected'; } ?> value="1" >CDP</option>
      			<option <?php if($this->validation->error_string) { if ($deptID == '2') echo 'selected'; } ?> value="2" >DOH</option>
      		</select>
      	</slot>
      	</td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>User group <span class="required">*</span></slot></td>
      	<td class="dataField" >
      	<slot>
      		<select name="groupID">
      			<option value="">----------------------------------</option>
      			<option <?php if($this->validation->error_string) { if ($groupID == '1') echo 'selected'; } ?> value="1">Admin</option>
      			<option <?php if($this->validation->error_string) { if ($groupID == '2') echo 'selected'; } ?> value="2">Requestor</option>
      			<option <?php if($this->validation->error_string) { if ($groupID == '3') echo 'selected'; } ?> value="2">OJT</option>
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
                <td width="30%"><slot><input name="lastName" id="lastName" size="25" maxlength="25" value="<?php if($this->validation->error_string) { echo $lastName; } ?>" onkeypress="return keyRestrict(event, 3);" type="text"></slot>&nbsp;,</td>
                <td width="30%"><slot><input name="firstName" id="firstName" size="25" maxlength="25" value="<?php if($this->validation->error_string) { echo $firstName; } ?>" onkeypress="return keyRestrict(event, 3);" type="text"></slot></td>
                <td width="40%"><slot><input name="middleName" id="middleName" size="25" maxlength="25" value="<?php if($this->validation->error_string) { echo $middleName; } ?>" onkeypress="return keyRestrict(event, 3);" type="text"></slot></td>
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
                <td width="30%"><slot><input name="telNum" id="telNum" size="25" maxlength="25" value="<?php if($this->validation->error_string) { echo $telNum; } ?>" onkeypress="return keyRestrict(event, 5);" type="text"></slot></td>
                <td width="30%"><slot><input name="localNum" id="localNum" size="25" maxlength="25" value="<?php if($this->validation->error_string) { echo $localNum; } ?>" onkeypress="return keyRestrict(event, 5);" type="text"></slot></td>
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

<script>
addToValidate('frmCreateUser','userName', '', true, 'User Name');
addToValidate('frmCreateUser','userPswd', '', true, 'Password');
addToValidate('frmCreateUser','reuserPswd', '', true, 'Password Confirmation');
addToValidate('frmCreateUser','deptID', '', true, 'Department');
addToValidate('frmCreateUser','groupID', '', true, 'User Group');
addToValidate('frmCreateUser','lastName', '', true, 'Last Name');
addToValidate('frmCreateUser','firstName', '', true, 'First Name');
addToValidate('frmCreateUser','middleName', '', true, 'Middle Name');
</script>