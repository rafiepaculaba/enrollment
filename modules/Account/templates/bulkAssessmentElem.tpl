<form name="frmAssessment" id="frmAssessment" method="post" action="index.php?module=Account&action=printBulkAssessmentElem">
<p>

<input type="hidden" id="theForm" name="theForm" value="generateAssessment" />

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="10" align="left"><h4 class="dataLabel">Printing Bulk Elementary Assessments</h4></th>
    </tr>
    <tr>
        <td class="dataLabel"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField"><slot>{$SCHOOLYEAR} </slot></td>
        <td class="dataLabel"><slot>Grade <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
        <select name="yrLevel" id="yrLevel">
        <option value="">--------------</option>
        <option value="1" {if $yrLevel eq "1"} selected {/if}>1</option>
        <option value="2" {if $yrLevel eq "2"} selected {/if}>2</option>
        <option value="3" {if $yrLevel eq "3"} selected {/if}>3</option>
        <option value="4" {if $yrLevel eq "4"} selected {/if}>4</option>
        <option value="5" {if $yrLevel eq "5"} selected {/if}>5</option>
        <option value="6" {if $yrLevel eq "6"} selected {/if}>6</option>
        <option value="S" {if $yrLevel eq "S"} selected {/if}>Special</option>
        </select> 
        </slot></td>
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

