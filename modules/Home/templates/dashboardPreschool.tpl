<table border="0" cellpadding="0" cellspacing="0" width="700">
<tr>
    <td align="left" width="50%" valign="top">
        <h3><img src="themes/Sugar/images/Dashboard.gif" alt="Current Enrollment" border="0">&nbsp;Current Enrollment</h3>
        <table class="listView2" border="0" cellpadding="0" cellspacing="0"  width="300">
        <tr>
            <td class="evenListRowS1"><slot>School Year : </slot> </td>
            <td class="evenListRowS1"><slot><b>{$schYear} </b></slot> </td>
        </tr>
        <tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
        <tr>
            <td class="evenListRowS1"><slot>Date : </slot> </td>
            <td class="evenListRowS1"><slot><b>{php} echo date("l dS F, Y", time()); {/php}</b> </slot> </td>
        </tr>
        </table>
    </td>
    <td align="left" width="50%" valign="top">
        <h3><img src="themes/Sugar/images/OfflineClient.gif" alt="Overall Enrollment" border="0">&nbsp;Enrollment Information at a glance</h3>
        <table class="listView2" border="0" cellpadding="0" cellspacing="0"  width="300">
        <tr>
            <td class="evenListRowS1"><slot>Overall Total Enrollment : </slot> </td>
            <td class="evenListRowS1"><slot><b>{$overall}</b> </slot> </td>
        </tr>
        </table>
    </td>
</tr>
<tr>
    <td valign="top" colspan="2">
    <br>
    <h3><img src="themes/Sugar/images/view_status.gif" alt="Enrollment Status" border="0">&nbsp;Enrollment Status</h3>
    {$RESULT}
    <br>
    </td>
</tr>
{if $isAdmin eq 1}
<tr>
    <td align="left" width="50%" valign="top">
        
        <h3><img src="themes/Sugar/images/Meetings.gif" alt="Enrollment Status" border="0">&nbsp;Stats</h3>
        <table class="listView2" border="0" cellpadding="0" cellspacing="0" width="300">
        <tr>
            <td class="evenListRowS1"><slot>Withdraw Enrollments : </slot> </td>
            <td class="evenListRowS1"><slot><b>{$ttl_withdrawals}</b> </slot> </td>
        </tr>
        <tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
        <tr>
            <td class="evenListRowS1"><slot>New Students/Transferees : </slot> </td>
            <td class="evenListRowS1"><slot><b>{$ttl_new}</b> </slot> </td>
        </tr>
        </table>
    </td>
    <td align="left" width="50%" valign="top">
        <h3><img src="themes/Sugar/images/Price_List.gif" alt="Total Collection" border="0">&nbsp;Total Collection</h3>
        <table class="listView2" border="0" cellpadding="0" cellspacing="0" width="300">
        <tr height="20">
    		<td scope="col" class="listViewThS1" nowrap>Term</td>
    		<td scope="col" class="listViewThS1" nowrap><div align="right">Collection</div> </td>
    	</tr>
        {section name=i loop=$collection}
        <tr>
            <td class="evenListRowS1"><slot>{$collection[i].term} </slot> </td>
            <td class="evenListRowS1" align="right"><slot>{$collection[i].ttl|number_format:2} </slot> </td>
        </tr>
        <tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
    	{/section}
    	<tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
        <tr>
            <td class="evenListRowS1"><slot><b>Total : </b></slot> </td>
            <td class="evenListRowS1" align="right"><slot><b>Php &nbsp;&nbsp;&nbsp;{$collection_total|number_format:2}</b> </slot> </td>
        </tr>
        </table>
    </td>
</tr>
{/if}
</table>

