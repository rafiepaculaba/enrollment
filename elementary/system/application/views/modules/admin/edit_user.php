<?php foreach ($record as $row): ?>
<form name="frmEditUser" id="frmEditUser" method="POST" action="index.php?admin/save_user/<?php echo $row->userID; ?>" onsubmit="return check_form('frmEditUser');">
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
         <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="window.location='index.php?admin/view_user/<?php echo $row->userID; ?>'"/>
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
		<th colspan="2" align="left" class="dataLabel"><h4 class="dataLabel">Create User</h4></th>
	</tr>
	<tr>
		<td class="dataLabel" width="18%" align="right"><slot>User name <span class="required">*</span></slot></td>
      	<td class="dataField" width="82%"><slot><input type="text" name="userName" value="<?php echo $row->userName; ?>" /></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Password <span class="required">*</span></slot></td>
      	<td class="dataField" ><slot><input type="password" size="40" name="userPswd" value="<?php echo $row->userPswd; ?>" /></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Re-type Password <span class="required">*</span></slot></td>
      	<td class="dataField" ><slot><input type="password" size="40" name="reuserPswd" value="<?php echo $row->userPswd; ?>" /></slot></td>
	</tr>
	<tr>
		<td class="dataLabel" align="right" ><slot>Department <span class="required">*</span></slot></td>
      	<td class="dataField" >
      	<slot>
      		<select name="deptID">
      			<option value="">----------------------------------</option>
      			<option <?php if($row->deptID == '1'){echo 'selected';} ?> value="1">CDP</option>
      			<option <?php if($row->deptID == '2'){echo 'selected';} ?> value="2">DOH</option>
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
      			<option <?php if($row->groupID == '1'){echo 'selected';} ?> value="1">Admin</option>
      			<option <?php if($row->groupID == '2'){echo 'selected';} ?> value="2">Requetor</option>
      			<option  <?php if($row->groupID == '3'){echo 'selected';} ?> value="3">OJT</option>
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
                <td width="30%"><slot><input name="lastName" id="lastName" size="25" maxlength="25" value="<?php echo $row->lastName; ?>" onkeypress="return keyRestrict(event, 12);" type="text"></slot>&nbsp;,</td>
                <td width="30%"><slot><input name="firstName" id="firstName" size="25" maxlength="25" value="<?php echo $row->firstName; ?>" onkeypress="return keyRestrict(event, 12);" type="text"></slot></td>
                <td width="40%"><slot><input name="middleName" id="middleName" size="25" maxlength="25" value="<?php echo $row->middleName; ?>" onkeypress="return keyRestrict(event, 12);" type="text"></slot></td>
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
                <td width="30%"><slot><input name="telNum" id="telNum" size="25" maxlength="25" value="<?php echo $row->localNum; ?>" onkeypress="return keyRestrict(event, 12);" type="text"></slot></td>
                <td width="30%"><slot><input name="localNum" id="localNum" size="25" maxlength="25" value="<?php echo $row->telNum; ?>" onkeypress="return keyRestrict(event, 12);" type="text"></slot></td>
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
<?php endforeach; ?>

<script>
addToValidate('frmEditUser','userName', '', true, 'User Name');
addToValidate('frmEditUser','userPswd', '', true, 'Password');
addToValidate('frmEditUser','reuserPswd', '', true, 'Password Confirmation');
addToValidate('frmEditUser','deptID', '', true, 'Department');
addToValidate('frmEditUser','groupID', '', true, 'User Group');
addToValidate('frmEditUser','lastName', '', true, 'Last Name');
addToValidate('frmEditUser','firstName', '', true, 'First Name');
addToValidate('frmEditUser','middleName', '', true, 'Middle Name');
</script>