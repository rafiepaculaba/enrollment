<p>
<ul class="tablist">
<li class="active" id="tab_li_Payment_info">
<a class="current" id="tab_link_Payment_info" href="index.php?module=Payments&action=viewPayment&paymentID={$paymentID}">Payment Form</a>
</li>	
<li id="tab_li_log">
<a id="tab_link_log" href="index.php?module=Payments&action=listPaymentColLogs&paymentID={$paymentID}">View Logs</a>
</li>	
</ul>
</p>

<table width="100%" border="0">
  <tr>
    <td>
   <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Payments&action=listPayments');" />
    
	{if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Payments&action=editPayment&paymentID={$paymentID}');" />
    {/if}
    
	{if $hasCancel eq 1 }
    <input class="button" name="cmdcancel" type="button" id="cmdcancel" value=" Cancel Payment " onclick="cancelPayment('{$paymentID}','{$idno}','{$accID}','{$schYear}','{$semCode}','{$termi}','{$amount}');" />
    {/if}
  </tr>
</table>  

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<th class="tabDetailViewDL" align="left" colspan="2" ><slot> <h4 class="tabDetailViewDL"> Status {if $rstatus eq 1} <font> (Active) </font>{/if} {if $rstatus eq 0} <font color="Red"> (Cancelled) </font>{/if} </h4></slot></th>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>OR No. :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$ORno} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$idno} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF"><slot>{$studName} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF"><slot>{$schYear} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Semester :</slot></td>
        <td class="tabDetailViewDF"><slot>{$semCoded} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Term :</slot></td>
        <td class="tabDetailViewDF"><slot>{$term} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Date :</slot></td>
        <td class="tabDetailViewDF"><slot>{$date} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Amount :</slot></td>
        <td class="tabDetailViewDF"><slot>{$amount|number_format:2:".":","} &nbsp;</slot></td>
    </tr>
</table>
</p>
