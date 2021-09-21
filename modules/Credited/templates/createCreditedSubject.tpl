<form name="frmCreditedSubject" id="frmCreditedSubject" method="post" action="index.php?module=Credited&action=saveCreditedSubject" >
<input type="hidden" name="curID" id="curID" value="{$curID}" />
<input type="hidden" name="courseID" id="courseID" value="{$courseID}" />
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="checkDuplicate();"/>
    <input class="button" name="cmdCancel" type="button"  id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=Credited&action=listCreditedSubjects')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create Credited Subject</h4></th>
    </tr>
	<tr>
        <td class="dataLabel"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField""><slot> {$SCHOOLYEAR}</slot></td>
	</tr>
	<tr>
        <td class="dataLabel">Semester <span class="required">*</span></td>
        <td class="dataField"">{$SEMESTERS}</td>
	</tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>ID No. <span class="required">*</span> </slot></td>
        <td class="dataField" width="82%">
        <slot>
        <input type="text" name="idno" id="idno" value="" size="" maxlength="15" onkeypress="return keyRestrict2(event, 14, 'displayStudentInfo');"/>
        <input type="button" name="cmdLookup" id="cmdLookup" value="=" onclick="popUp('index.php?module=Credited&action=listStudents&sugar_body_only=1')" />
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>Complete Name </slot></td>
        <td class="dataField" colspan="3">
        <slot> <input type="text" name="name" id="name" size="40" maxlength="50" onkeypress="return keyRestrict(event, 12);" readonly /> </slot>
        </td>
    </tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
        <td class="dataLabel" width="18%"><slot>Year Level <span class="required">*</span></slot></td>
        <td class="dataField" width="82%"><slot>{$YEARLEVEL}</slot></td>
	</tr>
	<tr>
        <td class="dataLabel" width="18%"><slot>Credited Subject <span class="required">*</span></slot></td>
        <td class="dataField" width="82%">
        <slot>
			<div id="divSubjects">
	    		<select name="subjID" id="subjID" >
	            <option value="">----------------------------------------------------------------------------------------------</option>
	            {section name=i loop=$subj_list}
	            <option value="{$subj_list[i].curID}">{$subj_list[i].subjCode}{$subj_list[i].descTitle}</option>
	            {/section}
	            </select>
	        </div>
        </slot>
	    </td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
        <td class="dataLabel"><slot>Final Grade <span class="required">*</span></slot></td>
        <td class="dataField""><slot> <input type="text" name="fgrade" id="fgrade" size="" maxlength="20" onkeypress="return keyRestrict(event, 2);" /> </slot></td>
	</tr>	
	<tr>
        <td class="dataLabel"><slot>Equivalent Subject <span class="required">*</span></slot></td>
        <td class="dataField""><slot> <input type="text" name="eqSubj" id="eqSubj" size="" maxlength="20" onkeypress="return keyRestrict(event, 13);" /> </slot></td>
	</tr>
	<tr>
        <td class="dataLabel"><slot>Equivalent Units <span class="required">*</span></slot></td>
        <td class="dataField""><slot> <input type="text" name="eqUnits" id="eqUnits" size="" maxlength="5" onkeypress="return keyRestrict(event, 2);" /> </slot></td>
	</tr>
	<tr>
        <td class="dataLabel"><slot>School <span class="required">*</span></slot></td>
        <td class="dataField""><slot> <input type="text" name="school" id="school" size="50" maxlength="30" onkeypress="return keyRestrict(event, 7);" /> </slot></td>
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