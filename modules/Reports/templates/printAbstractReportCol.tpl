
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap">
    		<div id="myDiv" name="myDiv" style="display:block">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<td nowrap="nowrap" align="right"><input type="button" class="button" value="Print Now" id="cmdPrint" name="cmdPrint" onclick="printNow();" /> &nbsp;&nbsp;<input type="button" class="button" value="Close" id="cmdClose" name="cmdClose" onclick="javascript: window.close();" /> </td>
            	</tr>
            </table>
            </div>
		</td>
	</tr>
</table>

<p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="tabDetailViewDL" colspan="4" align="center">
        <slot>
        {$schName}<br>{$schAddress}<br>{$schContact}
        </slot>
        </td>
    </tr>
    <tr><th  colspan="6" align="center"><br><b><u>Abstract Collection Report</u></b> <br><br></th></tr>
    <tr>
        <td class="tabDetailViewDL" width="100"><slot>Date: </slot></td>
        <td  class="tabDetailView" width="150"><slot> <u>{$date}</u> To <u>{$todate}</u> </slot></td>
        <td class="tabDetailViewDL" width="100"><slot>Cashier: </slot></td>
        <td class="tabDetailViewDF" width="150" align="left"><slot><u>{$cashier}</u></slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>


{if $RESULT neq ''}
	<table class="listView" border="1" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        	<tr height="20">
        	    <td scope="col" class="listViewThS1" nowrap>OR #</td>
        		<td scope="col" class="listViewThS1" nowrap>Student</td>
        		{section name=i loop=$schoolfee_list}
        			<td scope="col" class="listViewThS1" nowrap><div align="right">{$schoolfee_list[i].account_name}</div></td>
        		{/section}
        		<td scope="col" class="listViewThS1" nowrap><div align="right">Total<div></td>
        	</tr>
        	
        	 {section name=i loop=$RESULT}
			<!-- Start of result Listing -->
			<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
				<td scope="row" 
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">{$RESULT[i].orno}</td>
				
				
				<td scope="row" 
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">{$RESULT[i].idno} - {$RESULT[i].lname}, {$RESULT[i].fname}</td>
				
				{section name=s loop=$RESULT[i].fees}
				<td scope="row" 
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top"><div align="right">{$RESULT[i].fees[s]}&nbsp;</div></td>
				{/section}
				
				<td scope="row" 
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top"><div align="right">{$RESULT[i].totalAmount|number_format:2}</div></td>
			</tr>
			<tr>
				<td colspan="20" class="listViewHRS1"></td>
			</tr>
			<!-- End of result Listing -->
			{/section}
			
			<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
				<td scope="row" colspan="2"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top" align="right"><b>GRAND TOTAL</b></td>
				
				{section name=i loop=$TOTAL}
				<td scope="row" 
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">
				<div align="right"><b>
				{if $TOTAL[i] gt 0}
					{$TOTAL[i]|number_format:2}
				{else}
					&nbsp;
				{/if}
				</b></div>
				</td>
				{/section}
				
				<td scope="row" 
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top"><div align="right"><b>{$GTOTAL|number_format:2}</b></div></td>
			</tr>
        	
        </tbody>
     </table>
{/if}
