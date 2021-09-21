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
            <td class="evenListRowS1"><slot>Semester : </slot> </td>
            <td class="evenListRowS1"><slot><b>{$semCode}</b> </slot> </td>
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
    <td colspan="2" valign="top">
    <br>
    <h3><img src="themes/Sugar/images/view_status.gif" alt="Enrollment Status" border="0">&nbsp;Enrollment Status</h3>
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    		<tr height="20">
    			<td scope="col" class="listViewThS1" nowrap>Course </td>
    			<td scope="col" class="listViewThS1" nowrap>1 </td>
    			<td scope="col" class="listViewThS1" nowrap>2 </td>
    			<td scope="col" class="listViewThS1" nowrap>3 </td>
    			<td scope="col" class="listViewThS1" nowrap>4 </td>
    			<td scope="col" class="listViewThS1" nowrap>5 </td>
    			<td scope="col" class="listViewThS1" nowrap>Total </td>
    		</tr>
    		
    		{section name=i loop=$list}
    		<!-- Start of registrant Listing -->
    			<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
    				
    				<td scope="row"
    		        {if i%2 eq 0}
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        {else}
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        {/if}
    		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].courseCode}&nbsp;</td>
    				
    				<td scope="row"
    		        {if i%2 eq 0}
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        {else}
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        {/if}
    		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].1}&nbsp;</td>
    				
    				<td scope="row"
    		        {if i%2 eq 0}
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        {else}
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        {/if}
    		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].2}&nbsp;</td>
    		
    				<td scope="row"
    		        {if i%2 eq 0}
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        {else}
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        {/if}
    		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].3}&nbsp;</td>
    		
    				<td scope="row"
    		        {if i%2 eq 0}
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        {else}
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        {/if}
    		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].4}&nbsp;</td>
    				
    				<td scope="row"
    		        {if i%2 eq 0}
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        {else}
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        {/if}
    		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].5}&nbsp;</td>
    				
    				<td scope="row"
    		        {if i%2 eq 0}
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        {else}
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        {/if}
    		        align="left" bgcolor="#fdfdfd" valign="top"><b>{$list[i].total}</b>&nbsp;</td>
    				
    			</tr>
    			<tr>
    				<td colspan="20" class="listViewHRS1"></td>
    			</tr>
    		<!-- End of registrant Listing -->
    		{/section}
    		<tr>
    			<td colspan="20" class="listViewHRS1"></td>
    		</tr>
    		
    		<tr height="20">
    		    <td scope="col" class="evenListRowS1" nowrap align="left"><b>Grand Total: </b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.1}</b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.2}</b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.3}</b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.4}</b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.5}</b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.total}</b></td>
    		</tr>
    </tbody>
    </table>
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
            <td class="evenListRowS1"><slot><b>{$ttl_withdrawals|number_format:0}</b> </slot> </td>
        </tr>
        <tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
        <tr>
            <td class="evenListRowS1"><slot>New Students/Transferees : </slot> </td>
            <td class="evenListRowS1"><slot><b>{$ttl_new|number_format:0}</b> </slot> </td>
        </tr>
        </table>
    </td>
    <td align="left" width="50%" valign="top">
        <h3><img src="themes/Sugar/images/PatchUpgrades.gif" alt="Enrollment Courses Rank" border="0">&nbsp;Top 3 Courses by population</h3>
        <table class="listView2" border="0" cellpadding="0" cellspacing="0" width="300">
        <tr height="20">
    		<td scope="col" class="listViewThS1" nowrap>Rank</td>
    		<td scope="col" class="listViewThS1" nowrap>Course</td>
    		<td scope="col" class="listViewThS1" nowrap>Enrollments </td>
    	</tr>
    	{php}$rank=1;{/php}
    	{section name=i loop=$top_rank}
        <tr>
            <td class="evenListRowS1"><slot>{php}echo $rank++;{/php} </slot> </td>
            <td class="evenListRowS1"><slot>{$top_rank[i].courseCode} </slot> </td>
            <td class="evenListRowS1"><slot>{$top_rank[i].total|number_format:0} </slot> </td>
        </tr>
        <tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
    	{/section}
        </table>
    </td>
</tr>
<tr>
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
            <td class="evenListRowS1"><slot><b>Total :</b></slot> </td>
            <td class="evenListRowS1" align="right"><slot><b> Php&nbsp;&nbsp;&nbsp;{$collection_total|number_format:2}</b> </slot> </td>
        </tr>
        </table>
    </td>
    <td align="left" width="50%" valign="top">
        &nbsp;
    </td>
</tr>
{/if}
</table>

