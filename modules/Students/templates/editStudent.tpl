<form name="frmStudent" id="frmStudent" method="post" action="index.php?module=Students&action=saveStudent" onsubmit="return check_form('frmStudent')">

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
        <td class="dataField" width="32%"><slot><input type="text" name="idno" id="idno" readonly value="{$idno}" size="25" maxlength="15" onkeypress="return keyRestrict(event, 14);" /> (readonly)</slot></td>
        <td class="dataLabel" width="18%"><slot><!--Picture--> &nbsp; </slot></td>
        <td class="dataField" width="32%">
        <slot> &nbsp;
<!--        <input name="uploadedfile" type="file" class="button" />-->
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Complete Name <span class="required">*</span></slot></td>
        <td class="dataField" colspan="3">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%"><slot><input type="text" name="lname" id="lname" size="25" maxlength="25" value="{$lname}" onkeypress="return keyRestrict(event, 12);" /></slot>&nbsp;,</td>
                <td width="30%"><slot><input type="text" name="fname" id="fname" size="25" maxlength="25" value="{$fname}" onkeypress="return keyRestrict(event, 12);" /></slot></td>
                <td width="40%"><slot><input type="text" name="mname" id="mname" size="25" maxlength="25" value="{$mname}" onkeypress="return keyRestrict(event, 12);" /></slot></td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>&nbsp;</slot></td>
        <td class="dataField" valign="top" colspan="3">
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
        <td class="dataField" width="32%"><slot><input type="text" name="age" id="age" size="9" value="{$age}" maxlength="3" onkeypress="return keyRestrict(event, 0);" /></slot></td>
        <td class="dataLabel" width="18%"><slot>Birthday <span class="required">*</span></slot></td>
        <td class="dataField" width="32%">
        <slot>
        {$month_object} {$day_object}
        <input type="text" name="year" id="year" size="8" maxlength="4" value="{$year}" onkeypress="return keyRestrict(event, 0);" />
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Gender <span class="required">*</span></slot></td>
        <td class="dataField">
        <slot>
        <select name="gender" id="gender">
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
        <select name="cstatus" id="cstatus">
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
        <td class="dataLabel"><slot>Nationality <!--<span class="required">*</span>--></slot></td>
        <td class="dataField">
        <slot><input type="text" name="nationality" id="nationality" size="20" value="{$nationality}" maxlength="20" onkeypress="return keyRestrict(event, 12);" /></slot>
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
        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Course and Year</h4></th>
    </tr>
    
    <tr>
        <td class="dataLabel" width="18%"><slot>Course <span class="required">*</span></slot></td>
        <td class="dataField" width="32%">
        <slot>
        <select name="courseID" id="courseID" onchange="getCurriculums();">
        <option value="">----------------------------------------</option>
        {section name=i loop=$courseList}
        <option value="{$courseList[i].courseID}" {if $courseList[i].courseID eq $courseID} selected {/if}>{$courseList[i].courseCode}</option>
        {/section}
        </select>
        </slot>
        </td>
        <td class="dataLabel" width="18%"><slot>Year <span class="required">*</span></slot></td>
        <td class="dataField" width="32%">
        <slot>
        <!--<select name="yrLevel" id="yrLevel">
        <option value="">--------</option>
        <option value="1" {if $yrLevel eq "1"} selected {/if}>1</option>
        <option value="2" {if $yrLevel eq "2"} selected {/if}>2</option>
        <option value="3" {if $yrLevel eq "3"} selected {/if}>3</option>
        <option value="4" {if $yrLevel eq "4"} selected {/if}>4</option>
        <option value="5" {if $yrLevel eq "5"} selected {/if}>5</option>
        </select>-->
        {$yrLevel_object}
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Curriculum <!--<span class="required">*</span>--></slot></td>
        <td class="dataField" colspan="3" width="82%">
        <slot>
        <select name="curID" id="curID">
        <option value="">----------------------------------------</option>
        {section name=i loop=$curList}
        {if $curList[i].major neq ""}    
            <option value="{$curList[i].curID}" {if $curList[i].curID eq $curID} selected {/if}>{$curList[i].curName} major in {$curList[i].major}</option>
        {else}
            <option value="{$curList[i].curID}" {if $curList[i].curID eq $curID} selected {/if}>{$curList[i].curName}</option>
        {/if}
        {/section}
        </select>
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
        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Preliminary Education</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Primary </slot></td>
        <td class="dataField" width="32%"><slot><input type="text" name="primary_edu" id="primary_edu" value="{$primary_edu}" size="50" maxlength="100" onkeypress="return keyRestrict(event, 6);" /></slot></td>
        <td class="dataLabel" width="18%"><slot>School Year </slot></td>
        <td class="dataField" width="32%"><slot><input type="text" name="primary_schYear" id="primary_schYear" value="{$primary_schYear}" maxlength="10" onkeypress="return keyRestrict(event, 14);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Intermediate </slot></td>
        <td class="dataField"><slot><input type="text" name="interm_edu" id="interm_edu" value="{$interm_edu}" size="50" maxlength="100" onkeypress="return keyRestrict(event, 6);" /></slot></td>
        <td class="dataLabel"><slot>School Year </slot></td>
        <td class="dataField"><slot><input type="text" name="interm_shcYear" id="interm_shcYear" value="{$interm_shcYear}" maxlength="10" onkeypress="return keyRestrict(event, 14);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Secondary </slot></td>
        <td class="dataField"><slot><input type="text" name="hs_edu" id="hs_edu" value="{$hs_edu}" size="50" maxlength="100" onkeypress="return keyRestrict(event, 6);" /></slot></td>
        <td class="dataLabel"><slot>School Year </slot></td>
        <td class="dataField"><slot><input type="text" name="hs_schYear" id="hs_schYear" value="{$hs_schYear}" maxlength="10" onkeypress="return keyRestrict(event, 14);" /></slot></td>
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
        <td class="dataLabel" width="18%"><slot>Permanent Address <span class="required">*</span> </slot></td>
        <td class="dataField"><slot><input type="text" name="permanentAddr" id="permanentAddr" size="50" value="{$permanentAddr}" maxlength="150" onkeypress="return keyRestrict(event, 6);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Current Address </slot></td>
        <td class="dataField"><slot><input type="text" name="currentAddr" id="currentAddr" size="50" value="{$currentAddr}" maxlength="150" onkeypress="return keyRestrict(event, 6);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Contact No. </slot></td>
        <td class="dataField"><slot><input type="text" name="phone" id="phone" size="50" value="{$phone}" maxlength="25" onkeypress="return keyRestrict(event, 10);" /></slot></td>
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
        <td class="dataLabel" width="18%"><slot>Document Entry </slot></td>
        <td class="dataField"><slot>
        
        <!--<input type="text" name="entryDocs" id="entryDocs" size="40" value="{$entryDocs}" maxlength="50" onkeypress="return keyRestrict(event, 6);" />-->
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
        />Birth Cert</label>&nbsp;&nbsp;&nbsp;&nbsp;
        <label><input type="checkbox" name="docs[]" value="HD" 
        {if $docHD eq 1}
        	checked
        {/if}
        />HD</label>&nbsp;&nbsp;&nbsp;&nbsp;
        <label><input type="checkbox" name="docs[]" value="TOR" 
        {if $docTOR eq 1}
        	checked
        {/if}
        />TOR</label>
        
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