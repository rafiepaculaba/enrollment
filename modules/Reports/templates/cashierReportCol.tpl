<form name="frmCashierReportCol" id="frmCashierReportCol" method="post" action="index.php?module=Reports&action=cashierReportCol" onsubmit="return check_form('frmCashierReportCol')" >
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">College Cashier Report</h4></th>
    </tr>
    <tr>
        <td class="dataLabel"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField"><slot> {$SCHOOLYEAR}</slot></td>
        <td class="dataLabel"><slot>Semester <span class="required">*</span></slot></td>
        <td class="dataField" colspan="2"><slot> {$SEMESTERS}</slot></td>
    </tr>
        <tr>
        <td class="dataLabel"><slot>Date <span class="required">*</span></slot></td>
        <td class="dataField">
	        <input name="date" id="date" size="15" maxlength="10" value="{$date}" type="text" onkeypress="return keyRestrict(event, 8);" />
	        <img src="themes/Sugar/images/jscalendar.gif" alt="Date Issued" id="jscal_trigger" align="absmiddle" /> 
		</td>
        <td class="dataLabel"><slot>Cashier/Accounting <span class="required">*</span></slot></td>
        <td class="dataField"><slot> 		    		
	        <select name="cashier" id="cashier" >
            {if $isCashierGroup eq 0}
				<option value="">-----------------------------</option>
			{/if}
	        {section name=i loop=$user_list}
	        	<option {if $user_list[i].id eq $cashier} selected {/if} value="{$user_list[i].id}">{$user_list[i].last_name}, {$user_list[i].first_name}</option>
	        {/section}
            </select>
		</slot></td>
		<td class="dataLabel"><slot><input type="submit" name="cmdView" id="cmdView" value=" Go " /></slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

{if $RESULT neq ''}
	{$RESULT}
{else}
	<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            	<tr height="20">
            	    <td scope="col" class="listViewThS1" nowrap>OR #</td>
            		<td scope="col" class="listViewThS1" nowrap>ID no.</td>
            		<td scope="col" class="listViewThS1" nowrap>Student</td>
            		<td scope="col" class="listViewThS1" nowrap>Course</td>
            		<td scope="col" class="listViewThS1" nowrap>Type</td>
            		<td scope="col" class="listViewThS1" nowrap>Amount</td>
            	</tr>
            </tbody>
     </table>
{/if}

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
		<td colspan="20" height="20">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="listViewPaginationTdS1" align="left" nowrap="nowrap" width="30%">&nbsp;&nbsp;
					<div id="printer">
					<a href="#" onclick="popUp('index.php?module=Reports&action=printCashierReportCol&schYear={$schYear}&semCode={$semCode}&date={$date}&cashier={$cashier}&sugar_body_only=1');"" id="print_link"><img src="themes/Sugar/images/print.gif" alt="Export" align="absmiddle" border="0" height="9" width="11">&nbsp;Print</a>
					</div>
					</td>
				</tr>
			</tbody>
			</table>	    
	    </td>
	</tr>
</table>

</form>