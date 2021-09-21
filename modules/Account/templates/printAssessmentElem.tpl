
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
    <tr><th  colspan="4" align="center"><br><b><u>Statement of Account</u></b> <br><br></th></tr>
    <tr>
        <td colspan="4"><slot>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>{$idno}</td>
                    <td>{$lname} , {$fname} {$mname}</td>
                    <td>Grade {$yrLevel} </td>
                    <td>{$schYear}</td>
                </tr>
            </table>                
        </slot>
        <hr>
        </td>
    </tr>
    <tr>
        <td colspan="2" width="50%" valign="top">
            <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr height="20">
            		<td scope="col" class="listViewThS1" width="50%" nowrap><b>Subject</b></td>
            		<td scope="col" class="listViewThS1" width="50%" nowrap><b>Signature</b></td>
            	</tr>
                {section name=i loop=$subjects}
                    <tr height="20">
                		<td>{$subjects[i].subjCode}</td>
                		<td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                	</tr>
            	{/section}
            </table>
        </td>
        <td colspan="2">
            
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
                    <td width="40%"><slot>Tuition </slot></td>
                    <td width="20%" align="right"><slot><b>{$tuitionFee}</b></slot></td>
                    <td width="30%"><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Laboratory </slot></td>
                    <td align="right"><slot><b>{$labFee}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Registration </slot></td>
                    <td align="right"><slot><b>{$regFee}</b></slot></td>
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
                    <td align="right"><slot><b>{$addAdj}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Less </slot></td>
                    <td align="right"><slot><b>{$lessAdj}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr><th colspan="4" align="left"><b>Total Fees:</b></th></tr>
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Total Fees </slot></td>
                    <td align="right"><slot><b>{$totalFees}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr><th colspan="4" align="left"><b>Total Payments:</b></th></tr>
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Total Payment </slot></td>
                    <td align="right"><slot><b>{$ttlPayment}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr><th colspan="4" align="left"><b>Balance:</b></th></tr>
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Balance </slot></td>
                    <td align="right"><slot><b>{$balance}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <tr><th colspan="4" align="left"><b>Due for {$term} Period:</b></th></tr>
                <tr>
                    <td><slot>&nbsp;</slot></td>
                    <td><slot>Amount Due </slot></td>
                    <td align="right"><slot><b>{$ttlDue}</b></slot></td>
                    <td><slot>&nbsp;</slot></td>
                </tr>
                
                <!--<th colspan="4" align="left"><h4>Total Payments:</h4></th>
                <tr>
                    <td width="20%"><slot>Amount Paid </slot></td>
                    <td width="30%"><slot><b>{$amtPaid}</b></slot></td>
                    <td width="50%">&nbsp;</td>
                </tr>-->
            </table>
        </td>
    </tr>
</table>


</p>
