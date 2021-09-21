<p>
<ul class="tablist">
<li id="tab_li_Payment_info">
<a id="tab_link_Payment_info" href="index.php?module=Payments&action=viewRegistrationPaymentElem&regPaymentID={$regPaymentID}">Payment Form</a>
</li>	
<li id="tab_li_log">
<a  class="current" id="tab_link_log" href="index.php?module=Payments&action=listRegistrationPaymentElemLogs&regPaymentID={$regPaymentID}">View Logs</a>
</li>	
</ul>
</p>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap>Date</td>
		<td scope="col" class="listViewThS1" nowrap>Time</td>
		<td scope="col" class="listViewThS1" nowrap>Action</td>
		<td scope="col" class="listViewThS1" nowrap>Changes</td>
		<td scope="col" class="listViewThS1" nowrap>User</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	
	{if $logs neq ""}
    	{section name=i loop=$logs}
    	<!-- Start of students Listing -->
    	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
    	       
        	<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" valign="top">{$logs[i].logDate}</td>
        	
        	<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" valign="top">{$logs[i].time}</td>
        	
        	<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" valign="top">{$logs[i].operation}</td>
        	
        	<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" valign="top">{$logs[i].fields}</td>
        	
        	<td scope="row" 
            {if i%2 eq 0}
                class="evenListRowS1" bgcolor="#fdfdfd" 
            {else}
                class="oddListRowS1" bgcolor="#ffffff" 
            {/if}
            align="left" valign="top">{$logs[i].user}</td>
    		
    		
    	</tr>
    	<tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
    	<!-- End of student Listing -->
    	{/section}
    	
	{else}
    	<tr>
    		<td colspan="20" class="oddListRowS1">
            	<table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tbody>
            	<tr>
            		<td nowrap="nowrap" align="center"><b><i>No logs found.</i></b></td>
            	</tr>
            	</tbody>
            	</table>
    		</td>
    	</tr>
	{/if}
	
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
</tbody>
</table>


