<form name="frmAssessment" id="frmAssessment" method="post" action="index.php?module=Account&action=printBulkAssessmentPreschool">
<p>

<input type="hidden" id="theForm" name="theForm" value="generateAssessment" />

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="10" align="left"><h4 class="dataLabel">Printing Bulk Preschool Assessments</h4></th>
    </tr>
    <tr>
        <td class="dataLabel"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField"><slot>{$SCHOOLYEAR} </slot></td>
        <td class="dataLabel"><slot>Grade <span class="required">*</span></slot></td>
        <td class="dataField"><slot>{$YEARLEVEL}</slot></td>
        <td class="dataLabel"><slot>Term <span class="required">*</span></slot></td>
        <td class="dataField"><slot>{$TERMS} </slot></td>
        <td class="dataLabel">
        <input class="button" name="cmdDisplay" type="button" id="cmdDisplay" value=" Show " onclick="display();"/>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>

