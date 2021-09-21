<form name="frmCollectionReport" id="frmCollectionReport" method="post" action="index.php?module=Reports&action=collectionReportHS" onsubmit="return check_form('frmCollectionReport')" >
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">High School Collection Report</h4></th>
    </tr>
    <tr>
        <td class="dataLabel"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField"><slot> {$SCHOOLYEAR}</slot></td>
        <td class="dataLabel"><slot>Period <span class="required">*</span></slot></td>
        <td class="dataField"><slot> {$TERMS}</slot></td>
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
					<a href="#" onclick="popUp('index.php?module=Reports&action=printCollectionReportHS&schYear={$schYear}&term={$term}&sugar_body_only=1');"" id="print_link"><img src="themes/Sugar/images/print.gif" alt="Export" align="absmiddle" border="0" height="9" width="11">&nbsp;Print</a>
					</div>
					</td>
				</tr>
			</tbody>
			</table>	    
	    </td>
	</tr>
</table>

</form>