
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap">
		&nbsp;
    		<div id="myDiv" name="myDiv" style="display:block">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<td nowrap="nowrap" align="right"><input type="button" class="button" value="Print Now" id="cmdPrint" name="cmdPrint" onclick="printNow();" />&nbsp;&nbsp;<input type="button" class="button" value="Close" id="cmdClose" name="cmdClose" onclick="javascript: window.close();" /></td>
            	</tr>
            </table>
            </div>
		</td>
	</tr>
</table>

<p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td colspan="4" align="center">
        <slot>
        {$schName}<br>{$schAddress}<br>{$schContact}
        </slot>
        </td>
    </tr>
    <tr><th  colspan="4" align="center"><br><b><u>Statement of Account for {$term}</u></b> <br><br></th></tr>
    <tr>
        <td colspan="4"><slot>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>({$gender}) &nbsp;&nbsp;&nbsp; {$idno}</td>
                    <td>{$lname} , {$fname} {$mname}</td>
                    <td>{$courseCode}-{$yrLevel}</td>
                    <td>{$semester} 
                    {if $semCode neq 4}
                    Sem 
                    {/if}
                    {$schYear}</td>
                </tr>
            </table>                
        </slot>
        <hr>
        </td>
    </tr>
    <tr>
        <td colspan="2" width="40%" valign="top">
            <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr height="20">
            	   <td scope="col" class="listViewThS1" nowrap><b>Instructor</b></td>
            		<td scope="col" class="listViewThS1" nowrap><b>Subject</b></td>
            		<td scope="col" class="listViewThS1" nowrap align="center"><b>Units</b></td>
            	</tr>
                {section name=i loop=$subjects}
                    <tr height="20">
                    	<td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                		<td>{$subjects[i].subjCode}</td>
                		<td align="center">{$subjects[i].units}</td>
                	</tr>
            	{/section}
            	<tr height="30">
                		<td colspan="2" align="right"><b> Total Units:</b></td>
                		<td align="center"><b>{$ttlUnits}</b></td>
                	</tr>
            </table>
            <br>
            
        </td>
        <td colspan="2" align="right">
            
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr><td width="70%">
            
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr><th colspan="4" align="left"><b>Old Account:</b></th></tr>
                <tr>
                    <td width="10%"><slot>&nbsp;</slot></td>
                    <td width="40%"><slot>Old Balance </slot></td>
                    <td width="20%" align="right"><slot><b>{$oldBalance|number_format:2}</b></slot></td>
                    <td width="30%"><slot>&nbsp;</slot></td>
                </tr>
            
                <tr><th colspan="4" align="left"><b>Fees:</b></th></tr>
                <tr>
                    <td width="10%"><slot>&nbsp;</slot></td>
                    <td width="40%"><slot>Tuition/Computer Subj </slot></td>
                    <td width="20%" align="right"><slot><b>{$tuitionFee|number_format:2}</b></slot></td>
                    <td width="30%"><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Laboratory </slot></td>
                    <td align="right"><slot><b>{$labFee|number_format:2}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Registration </slot></td>
                    <td align="right"><slot><b>{$regFee|number_format:2}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Miscellaneous </slot></td>
                    <td align="right"><slot><b>{$miscFee|number_format:2}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr><th colspan="4" align="left"><b>Adjustments:</b></th></tr>
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Add </slot></td>
                    <td align="right"><slot><b>{$addAdj|number_format:2}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Less </slot></td>
                    <td align="right"><slot><b>{$lessAdj|number_format:2}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td align="left" colspan="2"><slot></slot></td>
                    <td align="right"><slot><b>---------------</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td align="left" colspan="2"><slot><b>Total Fees </b></slot></td>
                    <td align="right"><slot><b>{$totalFees|number_format:2}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td align="left" colspan="2"><slot><b>Total Payment</b> </slot></td>
                    <td align="right"><slot><b>{$ttlPayment|number_format:2}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td align="left" colspan="2"><slot><b>Balance</b> </slot></td>
                    <td align="right"><slot><b>{$balance|number_format:2}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td align="left" colspan="2"><slot><b>Amount Due for {$term}</b></slot></td>
                    <td align="right"><slot><b>{$ttlDue|number_format:2}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
            </table>
            </td>
            <td width="30%">
            Cashier/<br>Accounting Stamp
            </td></tr>
            </table>
        </td>
    </tr>
</table>
</p>


<hr/>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>Examination Date: {$examDate}</td>
    </tr>
     <tr>
        <td>Note: This may serve as exam permit once padi. No permit, No exam.</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Run Date: {$rundate} </td>
    </tr>
</table>    

