<form name="frmRegistration" id="frmRegistration" method="post" action="index.php?module=Registrations&action=saveRegistrationElem" onsubmit="return check_form('frmRegistration')">

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
        <td class="dataLabel" width="18%"><slot>Complete Name <span class="required">*</span></slot></td>
        <td class="dataField" width="82%">
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
        <td class="dataField">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%">Last Name</td>
                <td width="30%">First Name</td>
                <td width="40%">Middle Name</td>
            </tr>
            </table>
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
        <td class="dataLabel" width="18%"><slot>Age <span class="required">*</span></slot></td>
        <td class="dataField" width="32%"><slot><input type="text" name="age" id="age" size="9" value="{$age}" maxlength="2" onkeypress="return keyRestrict(event, 0);" /></slot></td>
        <td class="dataLabel" width="18%"><slot>Birthday <span class="required">*</span></slot></td>
        <td class="dataField" width="32%">
        <slot>
        {$month_object}
        
        {$day_object}
        
        <input type="text" name="year" id="year" size="8" value="{$year}" maxlength="4" onkeypress="return keyRestrict(event, 0);" />
        </slot>
        </td>
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
        <slot><input type="text" name="nationality" id="nationality" value="{$nationality}" size="25" maxlength="20" onkeypress="return keyRestrict(event, 12);"/></slot>
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
        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Documents</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Document Entry </slot></td>
        <td class="dataField"><slot><input type="text" name="entryDocs" id="entryDocs" size="40" maxlength="50" value="{$entryDocs}" onkeypress="return keyRestrict(event, 6);"/></slot></td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Last School Attended </slot></td>
        <td class="dataField"><slot><input type="text" name="lastSchool" id="lastSchool" size="40" maxlength="70" value="{$lastSchool}" onkeypress="return keyRestrict(event, 6);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Last Attended </slot></td>
        <td class="dataField">
        <slot>
        <input name="sch_last_attended" id="sch_last_attended" tabindex="5" size="15" maxlength="10" value="{$sch_last_attended}" type="text" onkeypress="return keyRestrict(event, 8);"/>
        <img src="themes/Sugar/images/jscalendar.gif" alt="Date Last Attended" id="jscal_trigger" align="absmiddle" /> 
        </slot>
        </td>
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