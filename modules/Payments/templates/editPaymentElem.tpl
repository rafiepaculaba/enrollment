<form name="frmPaymentElem" id="frmPaymentElem" method="post" action="index.php?module=Payments&action=savePaymentElem">

<input type="hidden" name="paymentID" id="paymentID" value="{$paymentID}" />
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />
<input type="hidden" name="assID" id="assID" value="{$assID}"/>
<input type="hidden" name="assaccID" id="assaccID" value="{$assaccID}"/>
<input type="hidden" name="prevamount" id="prevamount" value="{$amount}"/>
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
<tr>
<td width="50%" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit Elementary Payment</h4></th>
    </tr>
        <tr>
        <td class="dataLabel" width="10%"><slot>School Year  </slot></td>
        <td class="dataField" width="50%">
        <slot>{$SCHOOLYEAR}
        </slot>
        </td>
    </tr>
	<tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Student Information</h4></th>
    </tr>
    <tr>
        <td class="dataLabel"  width="40%"><slot>OR # <span class="required">*</span> </slot></td>
        <td class="dataField" >
        <slot>
        	<input type="text" name="ORno" id="ORno" value="{$ORno}" size="" maxlength="10" onkeypress="return keyRestrict(event, 1);"/>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"  width="40%"><slot>ID No. </slot></td>
        <td class="dataField" >
        <slot>
        <input type="text" name="idno" id="idno" value="{$idno}" size="" maxlength="15" onkeypress="return keyRestrict(event, 2); " readonly/>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>Complete Name </slot></td>
        <td class="dataField" >
        <slot> <input type="text" name="name" id="name" value="{$name}" size="30" maxlength="50" onkeypress="return keyRestrict(event, 3);" readonly /> </slot>
        </td>
    </tr>
	<tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td class="dataField" colspan="2" align="left"><h4 class="dataLabel">Term and Amount </h4></td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>Term </slot></td>
        <td class="dataField">
        <slot>{$TERMS}</slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>Amount <span class="required">*</span> </slot></td>
        <td class="dataField" >
        <slot> <input type="text" name="amount" id="amount" value="{$amount}" size="" maxlength="8" onkeypress="return keyRestrict(event, 1);" /> </slot>
        </td>
    </tr>
    </table>
</td>
<td width="" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%"">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Statement of Account</h4></th>
    </tr>
	<tr>
        <td class="tabDetailViewDL" width="28%"><slot>Account No. :</slot> </td>
        <td class="tabDetailViewDF" id="accID"><slot>{$assaccID} &nbsp;</slot></td>
    </tr>
	<tr>
        <td class="tabDetailViewDL" ><slot>Assessment ID :</slot></td>
        <td class="tabDetailViewDF" width="" id="assID_td"><slot>{$assID_td} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" ><slot>Amount Paid (Php):</slot></td>
        <td class="tabDetailViewDF" id="amtPaid"><slot>{$assamtPaid} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" ><slot>Total Balance (Php):</slot></td>
        <td class="tabDetailViewDF" id="balance"><slot>{$assbalance} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" align="left"><h4 class="dataLabel">Total Due (Php): </h4></td>
        <td class="tabDetailViewDF" id="ttlDue"><slot>{$assttlDue} &nbsp;</slot></td>
    </tr>
</table>
</td>
</tr>
</table>
</p>
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="isFloatAmount();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="history.back();" />
    </td>
  </tr>
</table>  

</form>