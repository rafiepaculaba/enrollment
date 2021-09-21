<form name="frmComparativeReport" id="frmComparativeReport" method="post" >
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">College Comparative Report</h4></th>
    </tr>
    <tr>
        <td class="dataLabel"><slot>From Year </slot></td>
        <td class="dataField" ><input type="text" name="fromYear" id="fromYear" value="" size="30" onkeypress="return keyRestrict2(event, 0, 'displayComparative');" /><slot>&nbsp;</slot> </td>
        <td class="dataLabel"><slot>To Year </slot></td>
        <td class="dataField" ><input type="text" name="toYear" id="toYear" value="" size="30" onkeypress="return keyRestrict2(event, 0, 'displayComparative');" /><slot>&nbsp;</slot> </td>
    </tr>
    </table>
</td></tr>
</table>
</p>
<p>
<div id = "comparative" name = "comparative">
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
	<tr height="20">
	    <td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>School Year</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>1st Sem</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>2nd Sem</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Summer</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>&nbsp;</td>
	</tr>
</tbody>
</table>
</div>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
		<td colspan="20" height="20">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="listViewPaginationTdS1" align="left" nowrap="nowrap" width="30%">&nbsp;&nbsp;
					<div id="printer">
					<a href="#" onclick="popUp('index.php?module=Reports&action=classRosterCol&schedID={$SCHEDLIST[i].schedID}&sugar_body_only=1');"" id="print_link"><img src="themes/Sugar/images/print.gif" alt="Export" align="absmiddle" border="0" height="9" width="11">&nbsp;Print</a>
					</div>
					</td>
				</tr>
			</tbody>
			</table>	    
	    </td>
	</tr>
</table>

</p>
</form>