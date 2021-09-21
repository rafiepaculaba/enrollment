<form name="frmRefundHS" id="frmRefundHS" method="post" action="index.php?module=Refunds&action=saveRefundHS">

<input type="hidden" name="refundID" id="refundID" value="{$refundID}" />
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />
<input type="hidden" name="accID" id="accID" value="{$accID}"/>
<input type="hidden" name="prevamount" id="prevamount" value="{$amount}"/>
<input type="hidden" name="prevbalance" id="prevbalance" value="{$balance}"/>
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="isFloatAmount();"/>
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit High School Refund</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>School year </slot></td>
        <td class="dataField" width="82%">
        <slot>{$SCHOOLYEAR}
        </slot>
        </td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
		<td class="dataLabel" ><slot>ID No. </slot></td>
        <td class="dataField" >
        <slot>
        <input type="text" name="idno" id="idno" value="{$idno}" size="" maxlength="15" onkeypress="return keyRestrict(event, 14);" readonly/>
        </slot>
        </td>
    </tr>
        </tr>
        <tr>
        <td class="dataLabel"><slot>Complete Name </slot></td>
        <td class="dataField">
        <slot> <input type="text" name="name" id="name" value="{$name}" size="25" readonly /> </slot>
        </td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Refundable Amount </slot></td>
        <td class="dataField" width="82%">
        <slot> <input type="text" name="balance" id="balance" value="{$balance}" size="" readonly /> </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Amount <span class="required">*</span> </slot></td>
        <td class="dataField" width="82%">
        <slot> <input type="text" name="amount" id="amount" value="{$amount}" size="" maxlength="8" onkeypress="return keyRestrict(event, 1);"/> </slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>