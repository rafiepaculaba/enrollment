<form name="frmPaymentType" id="frmPaymentType" method="post" action="index.php?module=Payments&action=savePaymentType" >

<input type="hidden" name="paymentTypeID" id="paymentTypeID" value="{$paymentTypeID}" />
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />
<input type="hidden" name="prevpaymentName" id="prevpaymentName" value="{$paymentName}" />

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="checkDuplicate();"/>
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit College Payment Type</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Payment Name  <span class="required">*</span></slot></td>
        <td class="dataField" width="82%">
        <slot> <input type="text" name="paymentName" id="paymentName" value="{$paymentName}" size="40"  /> </slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>

</form>