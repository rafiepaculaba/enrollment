<form name="frmCourse" id="frmCourse" method="post" action="index.php?module=Courses&action=saveCourse" >

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button"  id="cmdSave" value=" Save " onclick="checkDuplicate();"/>
    <input class="button" name="cmdCancel" type="button"  id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=Courses&action=listCourses')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create Course</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Department <span class="required">*</span></slot></td>
        <td class="dataField" colspan="3" width="82%">
        <slot>
        <select name="deptID" id="deptID"  >  
        <option value="">----------------------------------</option>    
        {section name=i loop=$dept_list}
        <option value="{$dept_list[i].deptID}">{$dept_list[i].deptCode}</option>
        {/section}
        </select>
        </slot>
        </td>        
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Course Code <span class="required">*</span></slot></td>
        <td class="dataField" width="80%">
        <slot> 
        <input type="text" name="courseCode" id="courseCode"  maxlength="10" onkeypress="return keyRestrict(event, 13);" />
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Course Name <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input type="text"  name="courseName" size="50" id="courseName" maxlength="70" onkeypress="return keyRestrict(event, 13);" />
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Dean <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
          <input type="text" name="dean" id="dean" size="50"  maxlength="36" onkeypress="return keyRestrict(event, 12);" />
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel" valign="top"><slot>Remarks </slot></td>
        <td class="dataField"><slot>
          <label>
          <textarea name="remarks" id="remarks" cols="47" onKeyPress="return limitLength(event,'remarks',150);"></textarea>
          </label>
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>
