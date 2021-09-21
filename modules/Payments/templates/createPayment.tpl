<form name="frmPayment" id="frmPayment" method="post" action="index.php?module=Payments&action=savePayment" >
<input type="hidden" name="assID" id="assID" value="{$assID}"/>
<input type="hidden" name="accID_input" id="accID_input" value="{$accID_input}"/>
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="isFloatAmount();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Payments&action=listPayments')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td width="65%">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">New College Payment</h4></th>
    </tr>
        <tr>
        <td class="dataLabel" width="10%"><slot>School Year <span class="required">*</span> </slot></td>
        <td class="dataField" width="10%">
        <slot>{$SCHOOLYEAR}
        </slot>
        </td>
        <td class="dataLabel" width="10%"><slot>Semester <span class="required">*</span> </slot></td>
        <td class="dataField" width="70%">
        <slot>{$SEMESTERS}
        </slot>
        </td>
    </tr>
</table>
</td></tr>
</table>
</p>

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="50%" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Student Information</h4></th>
    </tr>
    <tr>
        <td class="dataLabel"  width="40%"><slot>OR # <span class="required">*</span> </slot></td>
        <td class="dataField" >
        <slot>
        	<input type="text" name="ORno" id="ORno" value="" size="" maxlength="10" onkeypress="return keyRestrict(event, 1);"/>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"  width="40%"><slot>ID No. <span class="required">*</span> </slot></td>
        <td class="dataField" >
        <slot>
       		<input type="text" name="idno" id="idno" value="" size="" maxlength="15" onkeypress="return keyRestrict2(event, 2, 'displayStudentInfo');"/>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>Complete Name </slot></td>
        <td class="dataField" >
        <slot> <input type="text" name="name" id="name" value="" size="30" maxlength="50" onkeypress="return keyRestrict(event, 3);" readonly /> </slot>
        </td>
    </tr>
	<tr><td>&nbsp;</td></tr>
    <tr>
        <td class="dataField" colspan="2" align="left"><h4 class="dataLabel">Term and Amount</h4></td>
    </tr>
        <td class="dataLabel" ><slot>Term <span class="required">*</span></slot></td>
        <td class="dataField">
        <slot>{$TERMS}</slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>Amount <span class="required">*</span> </slot></td>
        <td class="dataField" >
        <slot> <input type="text" name="amount" id="amount" value="" maxlength="8" size="" onkeypress="return keyRestrict(event, 1);" /> </slot>
        </td>
    </tr>
    </table>
</td>
<td width="50%" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%"">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Summary of Account</h4></th>
    </tr>
	<tr>
        <td class="tabDetailViewDL" width="30%"><slot>Account No. :</slot> </td>
        <td class="tabDetailViewDF" id="accID"><slot> &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" ><slot>Assessment ID :</slot></td>
        <td class="tabDetailViewDF" id="assID_td"><slot> &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" ><slot>Amount Paid (Php):</slot></td>
        <td class="tabDetailViewDF" id="amtPaid"><slot> &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" ><slot>Total Balance (Php):</slot></td>
        <td class="tabDetailViewDF" id="balance"><slot> &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" align="left"><h4 class="dataLabel">Amount Due (Php): </h4></td>
        <td class="tabDetailViewDF" id="ttlDue"><slot> &nbsp;</slot></td>
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
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Payments&action=listPayments')" />
  </tr>
</table>  
</form>