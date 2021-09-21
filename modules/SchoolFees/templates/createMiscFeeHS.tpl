<form name="frmMiscFee" id="frmMiscFee" method="post" action="index.php?module=SchoolFees&action=saveMiscFeeHS" >

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="checkDuplicate();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=SchoolFees&action=listMiscFeeHS')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create Miscellaneous Fee: High School</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" width="80%"><slot> {$SCHOOLYEAR} </slot></td>
    </tr>
	<tr>
        <td class="dataLabel" width="18%"><slot>Year Level <span class="required">*</span></slot></td>
        <td class="dataField" width="82%"><slot>{$YEARLEVEL}</slot></td>
	</tr>
	<tr>
        <td class="dataLabel" width="18%"><slot>Particular <span class="required">*</span></slot></td>
        <td class="dataField" width="82%"><slot><input type="text" name="particular" id="particular" size="40" maxlength="50" onkeypress="return keyRestrict(event, 7);" /></slot></td>
	</tr>
    <tr>
        <td class="dataLabel"><slot>Amount <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
          <input type="text" name="amount" id="amount" size="16" maxlength="8" onkeypress="return keyRestrict(event, 1);" />
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>
