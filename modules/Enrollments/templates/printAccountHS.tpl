

<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap">
		&nbsp;
    		<div id="myDivAccount" name="myDivAccount" style="display:block">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<td nowrap="nowrap" align="left">
            		<label><input type="checkbox" name="chkAccount" id="chkAccount" value="Include Printing" onclick="displayAccount();" /> Include Account Summary </label>
            		</td>
            	</tr>
            </table>
            </div>
		</td>
	</tr>
</table>

<div id="myAccount" name="myAccount" style="display:none">
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="500">
    <tr><th  colspan="4" align="center"><br><b><u>Account Summary</u></b> <br><br></th></tr>
    <tr>
        <td  colspan="4"><slot>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>{$idno}</td>
                    <td>{$lname} , {$fname} {$mname}</td>
                    <td>{$yrLevel} Year</td>
                    <td>{$schYear_acct}</td>
                </tr>
            </table>                
        </slot></td>
    </tr>
    <tr>
        <td colspan="4">
            <hr>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="40%" align="right"></td>
                    <td align="right" width="30%"></td>
                    <td></td>
                </tr>
                {if $oldBalance gt 0}
                    <tr>
                        <td width="40%" align="right"><slot>Old Balance </slot></td>
                        <td align="right" width="30%"><slot>{$oldBalance|number_format:2:".":","}</slot></td>
                        <td >&nbsp;</td>
                    </tr>
                {/if}
                {if $fees neq ""}
                    <tr><th  colspan="4" align="left">Fees:</th></tr>
                    {section name=i loop=$fees}
                    <tr>
                        <td  align="right"><slot>{$fees[i].particular} </slot></td>
                        <td align="right"><slot>{$fees[i].amount|number_format:2:".":","}</slot></td>
                        <td >&nbsp;</td>
                    </tr>
                    {/section}
                {/if}
                
                {if $add_adjustments neq ""}
                    <tr><th  colspan="4" align="left">Additional Fees:</th></tr>
                    {section name=i loop=$add_adjustments}
                    <tr>
                        <td  align="right"><slot>{$add_adjustments[i].particular} </slot></td>
                        <td align="right"><slot>{$add_adjustments[i].amount|number_format:2:".":","}</slot></td>
                        <td >&nbsp;</td>
                    </tr>
                    {/section}
                {/if}

                {if $less_adjustments neq ""}
                    <tr><th  colspan="4" align="left">Less Adjustments: </th></tr>
                    {section name=i loop=$less_adjustments}
                    <tr>
                        <td  align="right"><slot>{$less_adjustments[i].particular} </slot></td>
                        <td align="right"><slot>{$less_adjustments[i].amount|number_format:2:".":","}</slot></td>
                        <td >&nbsp;</td>
                    </tr>
                    {/section}
                {/if}
                
                <tr><th  colspan="4" align="left">Total Fees:</th></tr>
                <tr>
                    <td  align="right"><slot>Total Fees </slot></td>
                    <td align="right"><slot>{$totalFee|number_format:2:".":","}</slot></td>
                    <td >&nbsp;</td>
                </tr>
                <tr><th  colspan="4" align="left">Total Payments:</th></tr>
                <tr>
                    <td  align="right"><slot>Total Payment </slot></td>
                    <td align="right"><slot>{$payment|number_format:2:".":","}</slot></td>
                    <td >&nbsp;</td>
                </tr>
                <tr><th  colspan="4" align="left">Balance:</th></tr>
                <tr>
                    <td  align="right"><slot>Balance </slot></td>
                    <td align="right"><slot>{$balance|number_format:2:".":","}</slot></td>
                    <td >&nbsp;</td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</p>
</div>

