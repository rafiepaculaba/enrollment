<form name="frmStudent" id="frmStudent" method="post" action="index.php?module=Students&action=saveStudentHS" onsubmit="return check_form('frmStudent')">

<input type="hidden" id="theForm" name="theForm" value="editStudent" />
<input type="hidden" name="recID" id="recID" value="{$recID}" />
<input type="hidden" name="regID" id="regID" value="{$regID}" />
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit Student</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Student ID No. </slot></td>
        <td class="dataField" colspan="3" width="82%"><slot><input type="text" name="idno" readonly id="idno" value="{$idno}" size="25" maxlength="15" onkeypress="return keyRestrict(event, 14);" /> (readonly)</slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Complete Name <span class="required">*</span></slot></td>
        <td class="dataField" colspan="3">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%"><slot><input type="text" name="lname" id="lname" value="{$lname}" size="25" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></slot>&nbsp;,</td>
                <td width="30%"><slot><input type="text" name="fname" id="fname" value="{$fname}" size="25" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></slot></td>
                <td width="40%"><slot><input type="text" name="mname" id="mname" value="{$mname}" size="25" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></slot></td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>&nbsp;</slot></td>
        <td class="dataField" colspan="3" valign="top">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%">Last Name</td>
                <td width="30%">First Name</td>
                <td width="40%">Middle Name</td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Year Level <span class="required">*</span></slot></td>
        <td class="dataField" colspan="3">
         <slot>
        <!--<select name="yrLevel" id="yrLevel">
        <option value="">--------</option>
        <option value="1" {if $yrLevel eq "1"} selected {/if}>1</option>
        <option value="2" {if $yrLevel eq "2"} selected {/if}>2</option>
        <option value="3" {if $yrLevel eq "3"} selected {/if}>3</option>
        <option value="4" {if $yrLevel eq "4"} selected {/if}>4</option>
        <option value="S" {if $yrLevel eq "S"} selected {/if}>Special</option>
        </select>-->
        {$yrLevel_object}
        </slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Personal Info</h4></th>
    </tr>
    <tr>
     	<td class="dataLabel" width="18%"><slot>Birthday <span class="required">*</span></slot></td>
        <td class="dataField" width="32%">
        <slot>
        {$month_object}{$day_object}
        <input type="text" name="year" id="year" size="8" maxlength="4" value="{$year}" onkeypress="return keyRestrict(event, 0);" />
        </slot>
        </td>
        <td class="dataLabel" width="18%">&nbsp;</td>
        <td class="dataField" width="32%">&nbsp;</td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Gender <span class="required">*</span></slot></td>
        <td class="dataField">
        <slot>
        <select name="gender">
        <option value="M"
        {if $gender eq "M"}
            selected
        {/if}
        >Male</option>
        <option value="F"
        {if $gender eq "F"}
            selected
        {/if}
        >Female</option>
        </select>
        </slot>
        </td>
        <td class="dataLabel"><slot>Civil Status <span class="required">*</span></slot></td>
        <td class="dataField">
        <slot>
        <select name="cstatus">
        <option value="S"
        {if $cstatus eq "S"}
            selected
        {/if}
        >Single</option>
        <option value="M"
        {if $cstatus eq "M"}
            selected
        {/if}
        >Married</option>
        </select>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Nationality <span class="required">*</span></slot></td>
        <td class="dataField">
        <slot><input type="text" name="nationality" id="nationality" size="20" value="{$nationality}" onkeypress="return keyRestrict(event, 12);" /></slot>
        </td>
        <td class="dataLabel">&nbsp;</td>
        <td class="dataField">&nbsp;</td>
    </tr>
    </table>
</td></tr>
</table>
</p>
  
 
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Preliminary Education</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Primary </slot></td>
        <td class="dataField" width="32%"><slot><input type="text" name="primary_edu" id="primary_edu" value="{$primary_edu}" size="50" maxlength="100" onkeypress="return keyRestrict(event, 6);" /></slot></td>
        <td class="dataLabel" width="18%"><slot>School Year </slot></td>
        <td class="dataField" width="32%"><slot><input type="text" name="primary_schYear" id="primary_schYear" value="{$primary_schYear}" maxlength="10" onkeypress="return keyRestrict(event, 14);" /></slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Contact and Address</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Permanent Address <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input type="text" name="permanentAddr" id="permanentAddr" size="50" value="{$permanentAddr}" onkeypress="return keyRestrict(event, 6);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Current Address </slot></td>
        <td class="dataField"><slot><input type="text" name="currentAddr" id="currentAddr" size="50" value="{$currentAddr}"  onkeypress="return keyRestrict(event, 6);"/></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Contact No. </slot></td>
        <td class="dataField"><slot><input type="text" name="phone" id="phone" size="50" value="{$phone}" onkeypress="return keyRestrict(event, 10);" /></slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>
  
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Parents</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Father's Name  </slot></td>
        <td class="dataField" width="32%"><slot><input type="text" name="fatherName" id="fatherName" value="{$fatherName}" size="40" maxlength="70" onkeypress="return keyRestrict(event, 12);" /></slot></td>
        <td class="dataLabel" width="18%"><slot>Occupation  </slot></td>
        <td class="dataField" width="32%"><slot><input type="text" name="fatherOccupation" id="fatherOccupation" value="{$fatherOccupation}" size="40" maxlength="25" onkeypress="return keyRestrict(event, 6);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Father's Telephone  </slot></td>
        <td class="dataField" width="32%"><slot><input type="text" name="fatherContact" id="fatherContact" value="{$fatherContact}" size="40" maxlength="25" onkeypress="return keyRestrict(event, 10);" /></slot></td>
        <td class="dataLabel" width="18%"><slot>&nbsp;  </slot></td>
        <td class="dataField" width="32%"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Mother's Name  </slot></td>
        <td class="dataField"><slot><input type="text" name="motherName" id="motherName" value="{$motherName}" size="40" maxlength="70" onkeypress="return keyRestrict(event, 12);" /></slot></td>
        <td class="dataLabel"><slot>Occupation  </slot></td>
        <td class="dataField"><slot><input type="text" name="motherOccupation" id="motherOccupation" value="{$motherOccupation}" size="40" maxlength="25" onkeypress="return keyRestrict(event, 6);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Mother's Telephone  </slot></td>
        <td class="dataField" width="32%"><slot><input type="text" name="motherContact" id="motherContact" value="{$motherContact}" size="40" maxlength="25" onkeypress="return keyRestrict(event, 10);" /></slot></td>
        <td class="dataLabel" width="18%"><slot>&nbsp;  </slot></td>
        <td class="dataField" width="32%"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Guardian's Name </slot></td>
        <td class="dataField"><slot><input type="text" name="guardian" id="guardian" value="{$guardian}" size="40" maxlength="70" onkeypress="return keyRestrict(event, 12);" /></slot></td>
        <td class="dataLabel"><slot>Occupation </slot></td>
        <td class="dataField"><slot><input type="text" name="guardianOccupation" id="guardianOccupation" value="{$guardianOccupation}" size="40" maxlength="25" onkeypress="return keyRestrict(event, 6);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Guardian's Telephone  </slot></td>
        <td class="dataField" width="32%"><slot><input type="text" name="guardianContact" id="guardianContact" value="{$guardianContact}" size="40" maxlength="25" onkeypress="return keyRestrict(event, 10);" /></slot></td>
        <td class="dataLabel" width="18%"><slot>&nbsp;  </slot></td>
        <td class="dataField" width="32%"><slot>&nbsp;</slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Documents</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Document Entry  </slot></td>
        <!--<td class="dataField"><slot><input type="text" name="entryDocs" id="entryDocs" size="40" value="{$entryDocs}" maxlength="50" onkeypress="return keyRestrict(event, 6);" /></slot></td>-->
        <td class="dataField"><slot>
        
        <label><input type="checkbox" name="docs[]" value="Form 138" 
        {if $docForm138 eq 1}
        	checked
        {/if}
        />Form 138</label>&nbsp;&nbsp;&nbsp;&nbsp;
        <label><input type="checkbox" name="docs[]" value="Good Moral Cert" 
        {if $docMoral eq 1}
        	checked
        {/if}
        />Good Moral Cert</label>&nbsp;&nbsp;&nbsp;&nbsp;
        <label><input type="checkbox" name="docs[]" value="Birth Cert" 
        {if $docBirth eq 1}
        	checked
        {/if}
        />Birth Cert</label>
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="history.back();" />
    </td>
  </tr>
</table>  

</form>