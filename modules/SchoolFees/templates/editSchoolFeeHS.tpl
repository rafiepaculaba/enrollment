<form method="post" name="frmSchoolFee" id="frmSchoolFee" action="index.php?module=SchoolFees&action=saveSchoolFeeHS&feeID={$feeID}">
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave"  type="button" id="cmdSave" value=" Save " onclick="onSubmit();"/>
    <input class="button" name="cmdCancel" type="button"  id="cmdCancel" value=" Cancel " onclick="history.back();" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit High School - School Fee</h4></th>
    </tr>
    <tr>
        <td class="dataLabel"><slot>School Year </slot></td>
        <td class="dataField" width="82%"><slot>{$SCHOOLYEAR}</slot></td>
    </tr>
	<tr>
        <td class="dataLabel" width="18%"><slot>Year Level </slot></td>
        <td class="dataField" width="82%"></slot>{$YEARLEVEL}</slot></td>
	</tr>
    <tr>
        <td class="dataLabel"><slot>Particular </slot></td>
        <td class="dataField"><slot><input type="text" name="item" id="item"  size="50" value="{$item}" maxlength="100" onkeypress="return keyRestrict(event, 7);" readonly/></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Amount <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input type="text" name="amount" id="amount" size="50" value="{$amount}"  maxlength="8" onkeypress="return keyRestrict(event, 1);" /></slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

</form>