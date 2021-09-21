<form name="frmCashSummaryReport" id="frmCashSummaryReport" method="post" action="index.php?module=Reports&action=cashSummaryReportCol" onsubmit="return check_form('frmCashSummaryReport')" >
<p>
<input type="hidden" id="theForm" name="theForm" value="gradesheet" />
<table width="100%" border="0">
  <tr>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">College Cash Summary Report</h4></th>
    </tr>
    <tr>
        <td class="dataLabel"><slot>From <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
        <input name="fromdate" id="fromdate" size="15" maxlength="10" value="{$fromdate}" type="text" onkeypress="return keyRestrict(event, 8);" />
        <img src="themes/Sugar/images/jscalendar.gif" alt="From Date" id="jscal_trigger1" align="absmiddle" /></slot></td>
        <td class="dataLabel"><slot>To <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
        <input name="todate" id="todate" size="15" maxlength="10" value="{$todate}" type="text" onkeypress="return keyRestrict(event, 8);" />
        <img src="themes/Sugar/images/jscalendar.gif" alt="To Date" id="jscal_trigger2" align="absmiddle" /></slot></td>
        <td class="dataLabel"><slot><input type="submit" name="cmdView" id="cmdView" value=" Go " /></slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

{$RESULT}

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
		<td colspan="20" height="20">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="listViewPaginationTdS1" align="left" nowrap="nowrap" width="30%">&nbsp;&nbsp;
					<div id="printer">
					<a href="#" onclick="popUp('index.php?module=Reports&action=printCashSummaryReportCol&fromdate={$fromdate}&todate={$todate}&sugar_body_only=1');"" id="print_link"><img src="themes/Sugar/images/print.gif" alt="Export" align="absmiddle" border="0" height="9" width="11">&nbsp;Print</a>
					</div>
					</td>
				</tr>
			</tbody>
			</table>	    
	    </td>
	</tr>
</table>

</form>