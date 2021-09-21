<form method="post" name="frmDepartment" id="frmDepartment" action="index.php?module=Departments&action=saveDepartment&deptID={$deptID}" onsubmit="return check_form('frmDepartment')" >

<input type="hidden" name="deptID" id="deptID" value="{$deptID}" />
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="history.back();" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit department</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Department Code </slot></td>
        <td class="dataField" width="82%"><slot><input type="text" name="deptCode" id="deptCode" value="{$deptCode}" maxlength="10" onkeypress="return keyRestrict(event, 17);" readonly /></slot> (readonly)</td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Department Name <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input type="text" size="50" name="deptName" id="deptName" value="{$deptName}" maxlength="100" onkeypress="return keyRestrict(event, 13);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Department Chairman <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input type="text" size="50" name="deptChairman" id="deptChairman" value="{$deptChairman}" maxlength="100" onkeypress="return keyRestrict(event, 12);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel" valign="top"><slot>Remarks </slot></td>
        <td class="dataField"><slot>
			<label>
			<textarea name="remarks" id="remarks" cols="47" onKeyPress="return limitLength(event,'remarks',150);" >{$remarks}</textarea>
			</label>		  
			</slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>