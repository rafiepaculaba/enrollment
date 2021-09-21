<form name="frmSubjectPreschool" id="frmSubjectPreschool" method="post" action="index.php?module=Subjects&action=saveSubjectPreschool">

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="checkDuplicatePreschool();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=Subjects&action=listSubjectsPreschool')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create Preschool Subject</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Grade Level <span class="required">*</span></slot></td>
        <td class="dataField" colspan="3" width="82%"><slot>{$YEARLEVEL}</slot></td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Subject Code <span class="required">*</span></slot></td>
        <td class="dataField" width="80%">
        <slot>
        <input type="text" name="subjCode" id="subjCode" size="14"  maxlength="20" onkeypress="return keyRestrict(event, 17);" />
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Descriptive Title  <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
        <input type="text" name="descTitle" id="descTitle"  size="50" maxlength="100" onkeypress="return keyRestrict(event, 15);" />
        </slot></td>
    </tr>
    <tr>
	    <td class="dataLabel" valign="top"><slot>Subject Description </slot></td>
	    <td class="dataField"><slot>
	      <label>
	      	<textarea name="subjDesc" id="subjDesc" cols="47"  onKeyPress="return limitLength(event,'subjDesc',150);"></textarea>
	      </label>
	    </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Units </slot></td>
        <td class="dataField"><slot>
        <input type="text" name="units" id="units" maxlength="4" size="14" onkeypress="return keyRestrict(event, 1);" />
        </slot></td>
    </tr>    
    <tr>
        <td class="dataLabel"><slot>Type </slot></td>
        <td class="dataField"><slot>
          <label><slot><input type="radio" name="type" id="type1" value="1" checked /> Lec </slot></label> &nbsp;&nbsp;
          <label><slot><input type="radio" name="type" id="type2" value="2" /> Lab </slot></label>
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>
