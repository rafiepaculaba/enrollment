<p>
<ul class="tablist">
<li class="active" id="tab_li_Payment_info">
<a class="current" id="tab_link_Payment_info" href="index.php?module=Payments&action=viewORHeaderPreschool&paymentID={$paymentID}">Payment Form</a>
</li>	
<li id="tab_li_log">
<a id="tab_link_log" href="index.php?module=Payments&action=listPaymentPreschoolLogs&paymentID={$paymentID}">View Logs</a>
</li>	
</ul>
</p>

<table width="100%" border="0">
  <tr>
    <td>
   <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Payments&action=listORHeaderPreschool');" />
    
   {if $hasCancel eq 1 }
   {if $rstatus neq 0} 
    <input class="button" name="cmdcancel" type="button" id="cmdcancel" value="  Cancel Payment " onclick="cancelORHeader('{$paymentID}','{$schYear}','{$idno}','{$amount}','{$orno}');" />
   {/if}
   {/if}
    
   {if $hasDelete eq 1 }
   {if $rstatus eq 0} 
    <input class="button" name="cmddelete" type="button" id="cmddelete" value="  Delete Payment " onclick="deleteORHeader('{$paymentID}','{$schYear}','{$idno}','{$amount}','{$orno}');" />
   {/if}
   {/if}
    
   {if $hasPrint eq 1 }
    <input class="button" name="cmdprint" type="button" id="cmdprint" value="Print" onclick="popUp('index.php?module=Payments&action=printORHeaderPreschool&paymentID={$paymentID}&sugar_body_only=1');" />
    {/if}

    {if $hasPrint eq 1 }
    <input class="button" name="cmdprint" type="button" id="cmdprint" value="Split Print" onclick="popUp('index.php?module=Payments&action=printSplitORHeaderPreschool&paymentID={$paymentID}&sugar_body_only=1');" />
    {/if}

  </tr>
</table>  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody><tr>
        <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL"> Official Receipt {if $rstatus eq 0} <font color="Red"> (Cancelled) </font>{/if} </h4></slot></th></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>School Year: </slot></td>
        <td class="tabDetailViewDF" width="32%">{$schYear} &nbsp;</td>
        <td class="tabDetailViewDL" align="right" width="17%"><slot>&nbsp; </slot></td>
        <td class="tabDetailViewDF" width="33%">&nbsp;</td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Student ID No.: </slot></td>
        <td class="tabDetailViewDF" width="32%">{$idno}&nbsp;</td>
        <td class="tabDetailViewDL" align="right" width="17%"><slot>OR No.: </slot></td>
        <td class="tabDetailViewDF" width="33%">{$orno}&nbsp;</td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Year &nbsp;</slot></td>
        <td class="tabDetailViewDF" width="32%">{$yrLevel}&nbsp;</td>
        <td class="tabDetailViewDL" align="right" width="17%"><slot> Date/Time: </slot></td>
        <td class="tabDetailViewDF" width="33%">{$dateCreated|date_format}&nbsp;&nbsp;{$timeCreated}</td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Complete Name: </slot></td>

        <td class="tabDetailViewDF" colspan="3">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td width="30%"><slot><b>{$lname}</b>&nbsp;,</td>
                <td width="30%"><slot><b>{$fname}</b>&nbsp;</slot></td>
                <td width="40%"><slot><b>{$mname}</b>&nbsp;</slot></td>
            </tr>
            </tbody></table>
        </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" colspan="3" valign="top">
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
        <td class="tabDetailViewDL" width="18%"><slot>Account Balance: </slot></td>
        <td class="tabDetailViewDF" width="32%">{$balance} &nbsp;</td>
        <td class="tabDetailViewDL" align="right" width="17%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="33%"> &nbsp;</td>
    </tr>
    </tbody></table>
</td></tr>
</tbody></table>
</p>
<p>
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
