<form name="frmRegistrationPaymentHS" id="frmRegistrationPaymentHS" method="post" action="index.php?module=Payments&action=saveRegistrationPaymentHS" >

<input type="hidden" name="regPaymentID" id="regPaymentID" value="{$regPaymentID}" />
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit High School Registration Payment</h4></th>
    </tr>
        <tr>
        <td class="dataLabel" width="18%"><slot>School Year  </slot></td>
        <td class="dataField" width="82%">
        <slot>{$SCHOOLYEAR}
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>OR # <span class="required">*</span> </slot></td>
        <td class="dataField" >
        <slot>
        	<input type="text" name="ORno" id="ORno" value="{$ORno}" size="" maxlength="10" onkeypress="return keyRestrict(event, 1);"/>
        </slot>
        </td>
    </tr>
	<tr>
        <td class="dataLabel"><slot>Type </slot></td>
        <td class="dataField"><slot>
          <label><slot><input type="radio" name="type" id="type1" value="1" {if $type eq 1} checked {/if} disabled /> Registration </slot> </label> &nbsp;&nbsp;
          <label><slot><input type="radio" name="type" id="type2" value="2" {if $type eq 2} checked {/if} disabled /> Down Payment </slot> </label>
        </slot></td>
    </tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
    <tr>
        <td class="dataLabel" ><slot>ID No.  </slot></td>
        <td class="dataField" >
        <slot>
        <input type="text" name="idno" id="idno" value="{$idno}" size="" maxlength="15" onkeypress="return keyRestrict(event, 14);" readonly/>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>Complete Name </slot></td>
        <td class="dataField" >
        <slot> <input type="text" name="name" id="name" value="{$name}" size="30" maxlength="50" onkeypress="return keyRestrict(event, 3);" readonly /> </slot>
        </td>
    </tr>
		<td colspan="2">&nbsp;</td>
    <tr>
        <td class="dataLabel" ><slot>Amount <span class="required">*</span> </slot></td>
        <td class="dataField" >
        <slot> <input type="text" name="amount" id="amount" value="{$amount}" size="" maxlength="8" onkeypress="return keyRestrict(event, 1);" /> </slot>
        </td>
    </tr>
    </table>
</td>
</table>
</p>
</form>