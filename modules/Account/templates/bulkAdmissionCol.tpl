<form name="frmAdmission" id="frmAdmission" method="post" action="index.php?module=Account&action=printBulkAdmissiontCol">
<p>

<input type="hidden" id="theForm" name="theForm" value="generateAssessment" />

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="10" align="left"><h4 class="dataLabel">Printing Bulk College Admission Slips</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="15%"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" width="15%"><slot>{$SCHOOLYEAR} </slot></td>
        <td class="dataLabel" width="15%"><slot>Semester <span class="required">*</span></slot></td>
        <td class="dataField" width="15%"><slot>{$SEMESTERS} </slot></td>
        <td class="dataLabel" width="10%"><slot>Term <span class="required">*</span></slot></td>
        <td class="dataField" width="20%">
        <slot>{$TERMS} </slot>
        </td>
        <td class="dataLabel" width="10%">&nbsp; </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Course <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
        <select name="courseID" id="courseID">
        <option value="">-------------------</option>
        {section name=i loop=$courseList}
        <option value="{$courseList[i].courseID}"
        {if $courseID eq $courseList[i].courseID} selected {/if} 
        >{$courseList[i].courseCode}</option>
        {/section}
        </select> 
        </slot></td>
        <td class="dataLabel"><slot>Year <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
        <select name="yrLevel" id="yrLevel">
        <option value="">--------------</option>
        <option value="1" {if $yrLevel eq "1"} selected {/if}>1</option>
        <option value="2" {if $yrLevel eq "2"} selected {/if}>2</option>
        <option value="3" {if $yrLevel eq "3"} selected {/if}>3</option>
        <option value="4" {if $yrLevel eq "4"} selected {/if}>4</option>
        <option value="5" {if $yrLevel eq "5"} selected {/if}>5</option>
        </select> 
        </slot></td>
        <td class="dataLabel" colspan="3">
        <input class="button" name="cmdDisplay" type="button" id="cmdDisplay" value=" Show " onclick="display();"/>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>

