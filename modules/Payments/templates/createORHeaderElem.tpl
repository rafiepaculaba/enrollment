<form name="frmORHeader" id="frmORHeader" method="post" action="index.php?module=Payments&action=saveORHeaderElem" >
<input type="hidden" name="current_term" id="current_term" value="{$current_term}" />
<input type="hidden" name="schYear" id="schYear" value="{$school_year}">
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="onCheckEntry();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Payments&action=listORHeaderElem')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody><tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create Payment </h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%">Current Term &nbsp;</td>
        <td class="dataField" width="32%"><input type="text" name="paymentterm" value="{$payment_term}" size="19" readonly></td>
        <td class="dataLabel" align="right" width="17%"><slot>OR No. <span class="required">*</span> </slot></td>
        <td class="dataField" width="33%">
            <input name="orno" id="orno" value="{$orno}" maxlength="15" onkeypress="return keyRestrict(event, 0);" type="text">
        </td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Student ID No. <span class="required">*</span>  </slot></td>
        <td class="dataField" width="32%">
            <input name="idno" id="idno" size="19" maxlength="15" type="text" onkeypress="return keyRestrict2(event, 14,'checkStudent');" onchange="clearDetail();" >
            <input type="button" name="cmdLookup" id="cmdLookup" value="=" onclick="popUp('index.php?module=Payments&action=listStudentsElem&sugar_body_only=1')" />
        </td>
        <td class="dataLabel" align="right" width="17%">Year</td>
        <td class="dataField" width="33%">
            <input name="yrLevel" id="yrLevel" value="{$yrLevel}" maxlength="15" type="text" readonly>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Complete Name </slot></td>

        <td class="dataField" colspan="3">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td width="30%"><slot><input name="lname" id="lname" size="25" maxlength="25" value="" onkeypress="return keyRestrict(event, 12);" type="text" readonly></slot>&nbsp;,</td>
                <td width="30%"><slot><input name="fname" id="fname" size="25" maxlength="25" value="" onkeypress="return keyRestrict(event, 12);" type="text" readonly></slot></td>
                <td width="40%"><slot><input name="mname" id="mname" size="25" maxlength="25" value="" onkeypress="return keyRestrict(event, 12);" type="text" readonly></slot></td>
            </tr>
            </tbody></table>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>&nbsp;</slot></td>
        <td class="dataField" colspan="3" valign="top">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td width="30%">Last Name</td>
                <td width="30%">First Name</td>
                <td width="40%">Middle Name</td>
            </tr>
            </tbody></table>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Account Balance  </slot></td>
        <td class="dataField" width="32%">
            <div id="acctBalance"></div>
        </td>
        <td class="dataLabel" align="right" width="17%">&nbsp;</td>
        <td class="dataLabel" width="33%">
            &nbsp;
        </td>
    </tr>
    </tbody></table>
</td></tr>
</tbody></table>
</p>
<p>
<table class="tabForm" border="0" cellpadding="0" border="1" cellspacing="0" width="100%">
<tbody>
<tr>
    <td class="dataLabel" width="18%">Particular </td>
    <td class="dataField" width="32%">
        <select id="particular" name="particular">
        <option value="" > ------------------------------ </option>
        {section name=i loop=$schoolfee_list}
        <option value="{$schoolfee_list[i].account_code}" >{$schoolfee_list[i].account_name}</option>
        {/section}
    </td>
    <td class="dataLabel" width="17%">Amount </td>
    <td class="dataField" width="23%">
        <input name="amount" id="amount" maxlength="15" onkeypress="return keyRestrict(event, 1);" type="text">
    </td>
    <td class="dataField" align="center" width="10%">
        <input class="button" type="button" name="addItem" id="addItem" value="Add Item" onclick="onCheckDuplicate();">
    </td>
</tr>
</tbody>
</table>
</p>
<p>
<div id="divItem">
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr height="20">
    		<td scope="col" class="listViewThS1" width="5%" nowrap="nowrap">&nbsp;</td>
    		<td scope="col" class="listViewThS1" width="45%" nowrap="nowrap">Particular</td>
    		<td scope="col" class="listViewThS1" width="50%" nowrap="nowrap">Amount</td>
    	</tr>
    </tbody>
</table>
</div>
</p>
</form>
