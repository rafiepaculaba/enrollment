<form name="frmAssessment" id="frmAssessment" method="post" action="index.php?module=Account&action=generateAssessmentCol" onsubmit="return check_form('frmAssessment');">
<p>

<input type="hidden" id="theForm" name="theForm" value="generateAssessment" />

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="10" align="left"><h4 class="dataLabel">Generate College Assessments</h4></th>
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
        <td class="dataLabel" width="10%">
        <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Generate "/>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>

