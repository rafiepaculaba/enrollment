<form method="post" name="frmCourse" id="frmCourse" action="index.php?module=Courses&action=saveCourse&courseID={$courseID}" onsubmit="return check_form('frmCourse')" >
<input type="hidden" name="courseID" id="courseID" value="{$courseID}" />
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave"  type="submit" id="cmdSave" value=" Save " />
    <input class="button" name="cmdCancel" type="button"  id="cmdCancel" value=" Cancel " onclick="history.back();" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit Course</h4></th>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Department <span class="required">*</span></slot></td>
        <td class="dataField" colspan="3" width="82%">
        <slot>
        <select name="deptID" id="deptID" >      
        <option value="">----------------------------------</option>
        {section name=i loop=$dept_list}
        <option value="{$dept_list[i].deptID}"
		{if $dept_list[i].deptID eq $deptID}
		selected
		{/if}
        >{$dept_list[i].deptCode}</option>
        {/section}
        </select>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Course Code </slot></td>
        <td class="dataField"><slot><input type="text" name="courseCode"  id="courseCode" value="{$courseCode}" maxlength="10" onkeypress="return keyRestrict(event, 13);" readonly/></slot> (readonly)</td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Course Name <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input type="text" name="courseName" id="courseName"  size="50" value="{$courseName}" maxlength="70" onkeypress="return keyRestrict(event, 13);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Dean <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input type="text" name="dean" id="dean" size="50" value="{$dean}" maxlength="36" onkeypress="return keyRestrict(event, 12);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel" valign="top"><slot>Remarks </slot></td>
        <td class="dataField">
        <slot>
		<textarea name="remarks" id="remarks" cols="47" onKeyPress="return limitLength(event,'remarks',150);" >{$remarks}</textarea>
		</slot>
		</td>
    </tr>
    </table>
</td></tr>
</table>
</p>

</form>