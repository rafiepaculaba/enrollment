
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
<!--		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;College Account</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>-->
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
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    {if $logo == 1}
    <tr>
        <td align="center" colspan="4"><img src="themes/Sugar/images/logo_temp.jpg" height="70" width="70"/></td>
    </tr>
    {/if}
    <tr>
        <td class="tabDetailViewDL" colspan="4" align="center">
        <slot>
            <b>{$schName}</b><br>{$schAddress}<br>{$schContact}
        </slot>
        </td>
    </tr>
    <tr><th  colspan="4" align="center"><br><b><u>Statement of Account</u></b> <br><br></th></tr>
    <tr>
        <td class="tabDetailViewDL" colspan="4"><slot>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>{$idno}</td>
                    <td>{$lname} , {$fname} {$mname}</td>
                    <td>{$courseCode}-{$yrLevel}</td>
                    <td>{$semester} 
                    {if $semCode neq 4}
                    Sem 
                    {/if}
                     {$schYear}</td>
                </tr>
        </slot></td>
    </tr>
    <tr>
        <td colspan="4">
            <hr>
            <table border="0" cellpadding="0" cellspacing="0" width="50%">
                <tr>
                    <td width="50%" align="right">&nbsp;</td>
                    <td align="right" width="10%">&nbsp;</td>
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td class="tabDetailViewDL" align="left"><slot>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Old Balance  </td>
                    <td class="tabDetailViewDL"><font style="text-decoration: line-through"><b>P</b></font></slot></td>
                    <td class="tabDetailViewDF" align="right"><slot>{$oldBalance|number_format:2:".":","}</slot></td>
                </tr>
                {if $fees neq ""}
                    <tr><th class="tabDetailViewDL" colspan="4" align="left">Fees:</th></tr>
                    {section name=i loop=$fees}
                    <tr>
                        <td class="tabDetailViewDL" align="left"><slot>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {$fees[i].particular} </td>
                        <td class="tabDetailViewDL"><font style="text-decoration: line-through"><b>P</b></font></slot></td>
                        <td class="tabDetailViewDF" align="right"><slot>{$fees[i].amount|number_format:2:".":","}</slot></td>
                    </tr>
                    {/section}
                {/if}
                
                {if $lab_fees neq ""}
                    <tr><th class="tabDetailViewDL" colspan="4" align="left">Laboratory:</th></tr>
                    {section name=i loop=$lab_fees}
                    <tr>
                        <td class="tabDetailViewDL" align="left"><slot>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {$lab_fees[i].particular}</td>
                        <td class="tabDetailViewDL"><font style="text-decoration: line-through"><b>P</b></font></slot></td>
                        <td class="tabDetailViewDF" align="right"><slot>{$lab_fees[i].amount|number_format:2:".":","}</slot></td>
                    </tr>
                    {/section}
                {/if}
                
                {if $add_adjustments neq ""}
                    <tr><th class="tabDetailViewDL" colspan="4" align="left">Additional Fees:</th></tr>
                    {section name=i loop=$add_adjustments}
                    <tr>
                        <td class="tabDetailViewDL" align="left"><slot>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {$add_adjustments[i].particular} </td>
                        <td class="tabDetailViewDL"><font style="text-decoration: line-through"><b>P</b></font></slot></td>
                        <td class="tabDetailViewDF" align="right"><slot>{$add_adjustments[i].amount|number_format:2:".":","}</slot></td>
                    </tr>
                    {/section}
                {/if}

                {if $less_adjustments neq ""}
                    <tr><th class="tabDetailViewDL" colspan="4" align="left">Less Adjustments: </th></tr>
                    {section name=i loop=$less_adjustments}
                    <tr>
                        <td class="tabDetailViewDL" align="left"><slot>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {$less_adjustments[i].particular} </slot></td>
                        <td class="tabDetailViewDL"><font style="text-decoration: line-through"><b>P</b></font></slot></td>
                        <td class="tabDetailViewDF" align="right"><slot>{$less_adjustments[i].amount|number_format:2:".":","}</slot></td>
                    </tr>
                    {/section}
                {/if}
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left">Total Fees:</th></tr>
                <tr>
                    <td class="tabDetailViewDL" align="left"><slot>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total Fees  </td>
                    <td class="tabDetailViewDL"><font style="text-decoration: line-through"><b>P</b></font></slot></td>
                    <td class="tabDetailViewDF" align="right"><slot>{$totalFee|number_format:2:".":","}</slot></td>
                </tr>
                <tr><th class="tabDetailViewDL" colspan="4" align="left">Total Payments:</th></tr>
                <tr>
                    <td class="tabDetailViewDL" align="left"><slot>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total Payment </td>
                    <td class="tabDetailViewDL"><font style="text-decoration: line-through"><b>P</b></font></slot></td>
                    <td class="tabDetailViewDF" align="right"><slot>{$payment|number_format:2:".":","}</slot></td>
                </tr>
                <tr><th class="tabDetailViewDL" colspan="4" align="left">Balance:</th></tr>
                <tr>
                    <td class="tabDetailViewDL" align="left"><slot>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Balance  </td>
                    <td class="tabDetailViewDF"><font style="text-decoration: line-through"><b>P</b></font></slot></td>
                    <td class="tabDetailViewDF" align="right"><slot>{$balance|number_format:2:".":","}</slot></td>
                </tr>
            </table>
        </td>
    </tr>
</table>


</p>
