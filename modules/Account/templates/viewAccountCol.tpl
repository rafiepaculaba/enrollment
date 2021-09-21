<!--dummy form-->
<form name="frmDummy" id="frmDummy" method="post" action="index.php?module=Account&action=viewAccountCol&accID={$accID}">
</form>

<p>
<ul class="tablist">
<li class="active" id="tab_li_Student_info">
<a class="current" id="tab_link_Student_info" href="index.php?module=Account&action=viewAccountCol&accID={$accID}">Account</a>
</li>	
<li id="tab_li_log">
<a id="tab_link_log" href="index.php?module=Account&action=listAccountColLogs&accID={$accID}">View Logs</a>
</li>	
</ul>
</p>

<table width="100%" border="0">
  <tr>
    <td>
   <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Account&action=listAccountsCol');" />
   
	{if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Account&action=editAccountCol&accID={$accID}');" />
    {/if}
    
    <input class="button" name="cmdprint" type="button" id="cmdprint" value="Print" onclick="popUpPrint('index.php?module=Account&action=printAccountCol&accID={$accID}&sugar_body_only=1');" />    
  </tr>
</table>  

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <th class="tabDetailViewDL" colspan="4" align="center"><h4 class="tabDetailViewDL">Statement of Account</h4></th>
    <tr>
        <td class="tabDetailViewDL" width="15%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="35%"><slot>{$schYear} &nbsp;</slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>Semester :</slot></td>
        <td class="tabDetailViewDF" width="35%"><slot>{$semester} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF"><slot>{$idno} &nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Account ID :</slot></td>
        <td class="tabDetailViewDF"><slot>{$accID} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF"><slot>{$lname} , {$fname} {$mname} &nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Course - Year :</slot></td>
        <td class="tabDetailViewDF"><slot>{$courseCode}-{$yrLevel} &nbsp;</slot></td>
    </tr>
    <tr>
        <td colspan="4">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
	                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Old Account:</h4></th></tr>
	                <tr>
	                    <td class="tabDetailViewDL" width="250"><slot>Old Balance   <font style="text-decoration: line-through"><b>P</b></font></slot></td>
	                    <td class="tabDetailViewDF" align="right" width="100"><slot><b>{$oldBalance|number_format:2:".":","}</b></slot></td>
	                    <td class="tabDetailViewDL">&nbsp;</td>
	                </tr>
                {if $fees neq ""}
                    <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Fees:</h4></th></tr>
                    {section name=i loop=$fees}
                    <tr>
                        <td class="tabDetailViewDL" width="250"><slot>{$fees[i].particular}  <font style="text-decoration: line-through"><b>P</b></font></slot></td>
                        <td class="tabDetailViewDF" align="right" width="100"><slot><b>{$fees[i].amount|number_format:2:".":","}</b></slot></td>
                        <td class="tabDetailViewDL">
                        <div align="center">
                        {if $fees[i].particular eq "Tuition"}
                        	Units: {$ttlNonCompSubjUnits|number_format:1:".":","} @  <font style="text-decoration: line-through"><b>P</b></font> {$tuitionperunit|number_format:2:".":","} per unit
                        {elseif $fees[i].particular eq "Computer Subject"}
                        	Units: {$ttlCompSubjUnits|number_format:1:".":","} @  <font style="text-decoration: line-through"><b>P</b></font> {$computerperunit|number_format:2:".":","} per unit
                    	{elseif $fees[i].particular eq "Miscellaneous"}
							<input type="button" id="displayMisc" name="displayMisc" onclick="displayWindow('windowcontent','Miscellaneous Details')" value="Miscellaneous Details" />
                    	{else}
                    		 &nbsp;
                        {/if}
                        </div>
                       </td>
                    </tr>
                    {/section}
                {/if}
                
                {if $lab_fees neq ""}
                    <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Laboratory:</h4></th></tr>
                    {section name=i loop=$lab_fees}
                    <tr>
                        <td class="tabDetailViewDL"><slot>{$lab_fees[i].particular}   <font style="text-decoration: line-through"><b>P</b></font></slot></td>
                        <td class="tabDetailViewDF" align="right"><slot><b>{$lab_fees[i].amount|number_format:2:".":","}</b></slot></td>
                        <td class="tabDetailViewDL">&nbsp;</td>
                    </tr>
                    {/section}
                {/if}
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Additional Fees:  <input type="button" class="button" name="cmdless" value=" + " onclick="popUp('index.php?module=Account&action=adjustmentAccount&accID={$accID}&feeType=Add&sugar_body_only=1');" /> </h4></th></tr>
                {if $add_adjustments neq ""}
                    {section name=i loop=$add_adjustments}
                    <tr>
                        <td class="tabDetailViewDL"><slot>{$add_adjustments[i].particular}   <font style="text-decoration: line-through"><b>P</b></font></slot></td>
                        <td class="tabDetailViewDF" align="right"><slot><b>{$add_adjustments[i].amount|number_format:2:".":","}</b></slot></td>
                        <td class="tabDetailViewDL">&nbsp;</td>
                    </tr>
                    {/section}
                {/if}

                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Less Adjustments:  <input type="button" class="button" name="cmdless" value=" + " onclick="popUp('index.php?module=Account&action=adjustmentAccount&accID={$accID}&feeType=Less&sugar_body_only=1');" /> </h4></th></tr>
                {if $less_adjustments neq ""}
                    {section name=i loop=$less_adjustments}
                    <tr>
                        <td class="tabDetailViewDL"><slot>{$less_adjustments[i].particular}   <font style="text-decoration: line-through"><b>P</b></font></slot></td>
                        <td class="tabDetailViewDF" align="right"><slot><b>{$less_adjustments[i].amount|number_format:2:".":","}</b></slot></td>
                        <td class="tabDetailViewDL">&nbsp;</td>
                    </tr>
                    {/section}
                {/if}
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Total Fees:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL" width="250"><slot>Total Fees   <font style="text-decoration: line-through"><b>P</b></font></slot></td>
                    <td class="tabDetailViewDF" align="right" width="100"><slot><b>{$totalFee|number_format:2:".":","}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Total Payments:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Total Payment   <font style="text-decoration: line-through"><b>P</b></font></slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$payment|number_format:2:".":","}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Balance:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Balance   <font style="text-decoration: line-through"><b>P</b></font></slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$balance|number_format:2:".":","}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
            </table>

        </td>
    </tr>
</table>


</p>



<!--popup:add of prerequisites here-->
<div style="width: 500px; height: 300px; visibility:hidden; display:none;" id="windowcontent">
	<table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr>
	        <td>
	           <div style="width: 100%; height:180px; overflow: auto;" id="divSectionList">
                <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                		<td scope="col" class="listViewThS1" width="70%" nowrap>Particular</td>
                		<td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
                		<td scope="col" class="listViewThS1" width="25%" nowrap><div align="center">Amount</div></td>
                	</tr>
                	<!-- Start of subject Listing -->
                	{section name=i loop=$misc}
                	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
                		<td scope="row" 
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top">{$misc[i].particular}</td>
                		
                		<td scope="row" 
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top"><font style="text-decoration: line-through"><b>P</b></font></td>
                		
                		<td scope="row"
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="right" bgcolor="#fdfdfd" valign="top">{$misc[i].amount|number_format:2:".":","}</td>
                	</tr>
                	<tr>
                		<td colspan="20" class="listViewHRS1"></td>
                	</tr>
                	{/section}
                	<!-- End of subject Listing -->
                </tbody>
                </table>
                
                </div>
	        </td>
        </tr>
        <tr>
	        <td>
	        <hr>
	        <input class="button" type="button" name="cmdCancel" id="cmdCancel" value="Close" onclick="hiddenFloatingDiv('windowcontent');"/>
	     	</td>
        </tr>
        </table>
</div>
<!--end of popup adding prerequisites-->


