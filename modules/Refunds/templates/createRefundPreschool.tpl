<form name="frmRefundPreschool" id="frmRefundPreschool" method="post" action="index.php?module=Refunds&action=saveRefundPreschool" >
<input type="hidden" name="accID" id="accID" value="{$accID}" size=""/>
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="isFloatAmount();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Refunds&action=listRefundsPreschool')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">New Preschool Refund</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>School year <span class="required">*</span> </slot></td>
        <td class="dataField" width="82%">
        <slot>{$SCHOOLYEAR}
        </slot>
        </td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
		<td class="dataLabel" ><slot>ID No. <span class="required">*</span> </slot></td>
        <td class="dataField" >
        <slot>
        <input type="text" name="idno" id="idno" value="" size="" maxlength="15" onkeypress="return keyRestrict2(event, 14, 'displayStudentInfo');" />
        <input type="button" name="cmdLookup" id="cmdLookup" value="=" onclick="popUp('index.php?module=Refunds&action=listStudentsPreschool&sugar_body_only=1')" />
        </slot>
        </td>
    </tr>
        <tr>
        <td class="dataLabel"><slot>Complete Name </slot></td>
        <td class="dataField">
        <slot> <input type="text" name="name" id="name" value="{$name}" size="40" readonly /> </slot>
        </td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Refundable Amount </slot></td>
        <td class="dataField">
        <slot> <input type="text" name="balance" id="balance" value="{$balance}" size="" readonly /> </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Amount <span class="required">*</span> </slot></td>
        <td class="dataField">
        <slot> <input type="text" name="amount" id="amount" value="{$amount}" size="" maxlength="8" onkeypress="return keyRestrict(event, 1);"/> </slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>

</form>