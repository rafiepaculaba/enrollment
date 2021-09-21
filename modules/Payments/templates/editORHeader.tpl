<form name="frmORHeader" id="frmORHeader" method="post" action="index.php?module=Payments&action=saveORHeader" >

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="onCheckEntry();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Payments&action=viewORHeader&paymentID={$paymentID}')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody><tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create Student</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" width="32%">{$SCHOOLYEAR}</td>
        <td class="dataLabel" align="right" width="17%"><slot>Semester  <span class="required">*</span></slot></td>
        <td class="dataField" width="33%">{$SEMESTERS}</td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Student ID No. <span class="required">*</span>  </slot></td>
        <td class="dataField" width="32%">
            <input name="idno" id="idno" value="{$idno}" maxlength="15" type="text" onkeypress="return keyRestrict2(event, 14,'checkStudent');" onchange="clearDetail();" >
        </td>
        <td class="dataLabel" align="right" width="17%"><slot>OR No. <span class="required">*</span> </slot></td>
        <td class="dataField" width="33%">
            <input name="orno" id="orno" value="{$orno}" maxlength="15" onkeypress="return keyRestrict(event, 0);" type="text">
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Complete Name </slot></td>
        <td class="dataField" colspan="3">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td width="30%"><slot><input name="lname" id="lname" value="{$lname}" size="25" maxlength="25" value="" onkeypress="return keyRestrict(event, 12);" type="text" readonly></slot>&nbsp;,</td>
                <td width="30%"><slot><input name="fname" id="fname" value="{$fname}" size="25" maxlength="25" value="" onkeypress="return keyRestrict(event, 12);" type="text" readonly></slot></td>
                <td width="40%"><slot><input name="mname" id="mname" value="{$mname}" size="25" maxlength="25" value="" onkeypress="return keyRestrict(event, 12);" type="text" readonly></slot></td>
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
        <option value="{$schoolfee_list[i].account_code}" >{$schoolfee_list[i].item}</option>
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
		<td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" nowrap>Particular</td>
		<td scope="col" class="listViewThS1" nowrap>Amount</td>
	</tr>
    {section name=i loop=$ordetails}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$ordetails[i].particular}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$ordetails[i].amount}</td>
		
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
<tr height="20">
	<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" colspan="2"><b>Total</b></td>
	<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>{$total_amount|number_format:2:".":","}</b></td>
</tr>
</tbody></table>
</p>
</form>