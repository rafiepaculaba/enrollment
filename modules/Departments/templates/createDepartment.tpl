<form name="frmDepartment" id="frmDepartment" method="post" action="index.php?module=Departments&action=saveDepartment" >
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="checkDuplicate();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=Departments&action=listDepartments')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create Department</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Department Code <span class="required">*</span></slot></td>
        <td class="dataField" width="80%">
        <slot> 
        <input type="text" name="deptCode" id="deptCode" maxlength="10" onkeypress="return keyRestrict(event, 17);" />
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Department Name <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input type="text" name="deptName" size="50" id="deptName" maxlength="70" onkeypress="return keyRestrict(event, 13);" />
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Department Chairman <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
          <input type="text" name="deptChairman" id="deptChairman" size="50" maxlength="70" onkeypress="return keyRestrict(event, 12);" />
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel" valign="top"><slot>Remarks </slot></td>
        <td class="dataField"><slot>
          <label>
          <textarea name="remarks" id="remarks" cols="47" onKeyPress="return limitLength(event,'remarks',100);"></textarea>
          </label>
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>
