
<form name="frmAdd" id="frmAdd" method="post" action="index.php?module=Account&action=adjustmentAccountElem" onsubmit="return check_form('frmAdd');">
<input id="accID" name="accID" value="{$accID}" type="hidden">

<table width="100%" border="0" cellpadding="1" cellspacing="0">
    <tr>
        <td>
            <table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                <tr height="20">
            		<td scope="col" class="dataLabel" width="30%" nowrap>Adjustment Type <span class="required">*</span></td>
            		<td scope="col" class="dataField" width="70%" nowrap> <input type="text" name="feeType" readonly id="feeType" value="{$feeType}" /></td>
            	</tr>
            	<tr height="20">
            		<td scope="col" class="dataLabel" width="30%" nowrap>Particular <span class="required">*</span></td>
            		<td scope="col" class="dataField" width="70%" nowrap> <input type="text" name="particular" id="particular" size="50" onkeypress="return keyRestrict(event, 7);" /></td>
            	</tr>
            	<tr height="20">
            		<td scope="col" class="dataLabel" width="30%" nowrap>Amount <span class="required">*</span></td>
            		<td scope="col" class="dataField" width="70%" nowrap> <input type="text" name="amount" id="amount" size="" onkeypress="return keyRestrict(event, 1);" /></td>
            	</tr>
            </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
        <hr>
        <input class="button" type="submit" name="submit" id="submit" value="  Add  " onclick="save();"/> <input class="button" type="button" name="cmdCancelAdd" id="cmdCancelAdd" value="Close" onclick="javascript: window.close();"/>
     	</td>
    </tr>
</table>
</form>
