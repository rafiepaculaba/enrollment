<form method="post" name="frmSubjectPreschool" id="frmSubjectPreschool" action="index.php?module=Subjects&action=saveSubjectPreschool" onsubmit="return check_form('frmSubjectPreschool')" >

<input type="hidden" name="subjID" id="subjID" value="{$subjID}" />
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " onclick="onSubmit();"  />
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit Preschool Subject</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Grade Level </slot></td>
        <td class="dataField" colspan="3" width="82%"><slot>{$YEARLEVEL} </slot></td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Subject Code </slot></td>
        <td class="dataField" width="80%">
        <slot>
        <input type="text" name="subjCode" id="subjCode" size="14" maxlength="20" value="{$subjCode}" onkeypress="return keyRestrict(event, 17);" readonly/>
		</slot> (readonly) </td>
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
        <td class="dataLabel"><slot>Units </slot></td>
        <td class="dataField"><slot>
        <input type="text" name="units" id="units" size="14" value="{$units}" maxlength="4" onkeypress="return keyRestrict(event, 1);" />
        </slot></td>
    </tr>    
    <tr>
        <td class="dataLabel"><slot>Type </slot></td>
        <td class="dataField"><slot>
          <label><slot><input type="radio" name="type" id="type1" disabled value="1" {if $type eq 1} checked {/if} /> Lec </slot></label> &nbsp;&nbsp;
          <label><slot><input type="radio" name="type" id="type2" disabled value="2" {if $type eq 2} checked {/if} /> Lab </slot></label>
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

</form>