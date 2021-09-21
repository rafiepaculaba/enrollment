<form method="post" name="frmSubject" id="frmSubject" action="index.php?module=Subjects&action=saveSubject" >

<input type="hidden" name="subjID" id="subjID" value="{$subjID}" />
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="onSubmit();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="history.back();" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit College Subject</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Course </slot></td>
        <td class="dataField" colspan="3" width="82%">
        <slot>
        <select name="courseID" id="courseID" disabled>      
        <option value="">---------------------</option>
        {section name=i loop=$course_list}
        <option value="{$course_list[i].courseID}"
		{if $course_list[i].courseID eq $courseID}
		selected
		{/if}
        >{$course_list[i].courseCode}</option>
        {/section}
        </select>
        </slot>
        </td>        
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Subject Code </slot></td>
        <td class="dataField" width="80%">
        <slot>
        <input type="text" name="subjCode" id="subjCode" maxlength="20" size="14" value="{$subjCode}" onkeypress="return keyRestrict(event, 17);" readonly/>
		</slot> (readonly)</td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Descriptive Title <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
        <input type="text" name="descTitle" id="descTitle" size="50" value="{$descTitle}" maxlength="100" onkeypress="return keyRestrict(event, 15);" />
        </slot></td>
    </tr>
    <tr>
	    <td class="dataLabel" valign="top"><slot>Subject Description </slot></td>
	    <td class="dataField"><slot>
	      <label>
	      	<textarea name="subjDesc" id="subjDesc" cols="47"  onKeyPress="return limitLength(event,'subjDesc',150);">{$subjDesc}</textarea>
	      </label>
	    </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Units  <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
        <input type="text" name="units" id="units" size="14" value="{$units}" maxlength="4" onkeypress="return keyRestrict(event, 1);" />
        </slot></td>
    </tr>    
    <tr>
        <td class="dataLabel"><slot>Type </slot></td>
        <td class="dataField"><slot>
          <label><slot><input type="radio" name="type" id="type1" value="1" {if $type eq 1} checked {/if} disabled /> Lec </slot> </label> &nbsp;&nbsp;
          <label><slot><input type="radio" name="type" id="type2" value="2" {if $type eq 2} checked {/if} disabled /> Lab </slot> </label>
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Computer Subject  </slot></td>
        <td class="dataField"><slot>
          <label><slot><input type="radio" name="isCompSubj" id="isCompSubj0" value="0" {if $type eq 1} checked {/if} /> No </slot> </label> &nbsp;&nbsp;
          <label><slot><input type="radio" name="isCompSubj" id="isCompSubj1" value="1" {if $type eq 2} checked {/if} /> Yes </slot> </label>
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

</form>