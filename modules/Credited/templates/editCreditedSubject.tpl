<form name="frmCreditedSubject" id="frmCreditedSubject" method="post" action="index.php?module=Credited&action=saveCreditedSubject" >
<input type="hidden" name="creID" id="creID" value="{$creID}" />
<input type="hidden" name="curID" id="curID" value="{$curID}" />
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="onSubmit();"/>
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit Credited Subject</h4></th>
    </tr>
   	<tr>
        <td class="dataLabel"><slot>School Year </slot></td>
        <td class="dataField""><slot> {$SCHOOLYEAR}</slot></td>
	</tr>
	<tr>
        <td class="dataLabel">Semester </td>
        <td class="dataField"">{$SEMESTERS}</td>
	</tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>ID No.  </slot></td>
        <td class="dataField" width="82%">
        <slot>
        <input type="text" name="idno" id="idno" value="{$idno}" size="" maxlength="15" onkeypress="return keyRestrict(event, 2);" readonly/>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>Complete Name </slot></td>
        <td class="dataField" colspan="3">
        <slot> <input type="text" name="name" id="name" value="{$name}" size="30" maxlength="50" onkeypress="return keyRestrict(event, 12);" readonly /> </slot>
        </td>
    </tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
        <td class="dataLabel" width="18%"><slot>Year Level </slot></td>
        <td class="dataField" width="82%">
        <slot>
	        <select name="yrLevel" id="yrLevel" disabled>
	        <option value="">-------------------</option>    
	        <option value="1" {if $yrLevel eq 1} selected {/if}>1</option>
	        <option value="2" {if $yrLevel eq 2} selected {/if}>2</option>
	        <option value="3" {if $yrLevel eq 3} selected {/if}>3</option>
	        <option value="4" {if $yrLevel eq 4} selected {/if}>4</option>
	        <option value="5" {if $yrLevel eq 5} selected {/if}>5</option>
	        </select>
        </slot>
        </td>
	</tr>
	<tr>
        <td class="dataLabel" width="18%"><slot>Credited Subject </slot></td>
        <td class="dataField" width="82%">
        <slot>
			<div id="divSubjects">
	    		<select name="subjID" id="subjID" disabled>
	            <option value="">---------------------------------</option>
	            {section name=i loop=$subject_list}
	            <option value="{$subject_list[i].subjID}" {if $subject_list[i].subjID eq $subjID} selected {/if}>{$subject_list[i].subjCode} {$subject_list[i].descTitle}</option>
	            {/section}
	            </select>
	        </div>
        </slot>
	    </td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
        <td class="dataLabel"><slot>Final Grade <span class="required">*</span></slot></td>
        <td class="dataField""><slot> <input type="text" name="fgrade" id="fgrade" size="" value="{$fgrade}" maxlength="20" onkeypress="return keyRestrict(event, 2);" /> </slot></td>
	</tr>	
	<tr>
        <td class="dataLabel"><slot>Equivalent Subject <span class="required">*</span></slot></td>
        <td class="dataField""><slot> <input type="text" name="eqSubj" id="eqSubj" value="{$eqSubj}" size="" maxlength="20" onkeypress="return keyRestrict(event, 13);" /> </slot></td>
	</tr>
	<tr>
        <td class="dataLabel"><slot>Equivalent Units <span class="required">*</span></slot></td>
        <td class="dataField""><slot> <input type="text" name="eqUnits" id="eqUnits" value="{$eqUnits}" size="" maxlength="5" onkeypress="return keyRestrict(event, 2);" /> </slot></td>
	</tr>
	<tr>
        <td class="dataLabel"><slot>School <span class="required">*</span></slot></td>
        <td class="dataField""><slot> <input type="text" name="school" id="school" value="{$school}" size="50" maxlength="30" onkeypress="return keyRestrict(event, 7);" /> </slot></td>
	</tr>
    <tr>
        <td class="dataLabel" valign="top"><slot>Remarks </slot></td>
        <td class="dataField"><slot>
          <label>
          <textarea name="remarks" id="remarks" cols="47" onKeyPress="return limitLength(event,'remarks',150);">{$remarks}</textarea>
          </label>
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>