<form name="frmAccount" id="frmAccount" method="post" action="index.php?module=Account&action=saveAccountHS" onsubmit="return check_form('frmAccount')">
<input type="hidden" id="theForm" name="theForm" value="EditAccount" />
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Account&action=viewAccountHS&accID={$accID}')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    
    
    <th class="dataLabel" colspan="4" align="center"><h4 class="dataLabel">Statement of Account</h4></th>
    <tr>
        <td class="dataLabel" width="15%"><slot>School Year </slot></td>
        <td class="dataField" width="35%"><slot> <input type="text" name="schYear" id="schYear" value="{$schYear}" size="" readonly /> </slot></td>
        <td class="dataLabel" width="15%"><slot>&nbsp; </slot></td>
        <td class="dataField" width="35%"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>ID No. </slot></td>
        <td class="dataField"><slot> <input type="text" name="idno" id="idno" value="{$idno}" size="" readonly /> </slot></td>
        <td class="dataLabel"><slot>Account ID </slot></td>
        <td class="dataField"><slot> <input type="text" name="accID" id="accID" value="{$accID}" size="" readonly /> </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Student Name </slot></td>
        <td class="dataField"><slot> <input type="text" size="40" name="studentName" id="studentName" value="{$lname} , {$fname} {$mname}" size="" readonly /> </slot></td>
        <td class="dataLabel"><slot>Year </slot></td>
        <td class="dataField"><slot> <input type="text" name="studentName" id="studentName" value="{$yrLevel}" size="" readonly /> </slot></td>
    </tr>
    <tr>
<!--        <td class="dataLabel">&nbsp;</td>-->
        <td colspan="4">
            <br>

            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Old Account:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Old Balance </slot></td>
                    <td class="dataField" width="70%"><slot><input type="text" name="oldBalance" id="oldBalance" value="{$oldBalance}" size="" readonly /></slot></td>
                </tr>
            
               {if $fees neq ""}
                <tr><th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Fees:</h4></th></tr>
                    {section name=i loop=$fees}
                    <tr>
                        <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;{$fees[i].particular} </slot></td>
                        <td class="dataField" width="70%">
                        <slot> <input type="text" name="feesf_{$fees[i].accDetailID}" id="feesf_{$fees[i].accDetailID}" value="{$fees[i].amount}" size="" onkeypress="return keyRestrict(event, 2);" onchange="fees_{$fees[i].accDetailID}();" /> </slot>
                        </td>
                    </tr>
                    {/section}
                {/if}
                
                {if $add_adjustments neq ""}
                    <tr><th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Additional Fees:</h4></th></tr>
                    {section name=i loop=$add_adjustments}
                    <tr>
                        <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;{$add_adjustments[i].particular} </slot></td>
                        <td class="dataField" width="70%"><slot> <input type="text" name="addf_{$add_adjustments[i].accDetailID}" id="addf_{$add_adjustments[i].accDetailID}" value="{$add_adjustments[i].amount}" size="" onkeypress="return keyRestrict(event, 2);" onchange="add_{$add_adjustments[i].accDetailID}();"  /> </slot></td>
                    </tr>
                    {/section}
                {/if}
                
                
                {if $less_adjustments neq ""}
                    <tr><th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Less Adjustments:</h4></th></tr>
                    {section name=i loop=$less_adjustments}
                    <tr>
                        <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;{$less_adjustments[i].particular} </slot></td>
                        <td class="dataField" width="70%"><slot> <input type="text" name="lessf_{$less_adjustments[i].accDetailID}" id="lessf_{$less_adjustments[i].accDetailID}" value="{$less_adjustments[i].amount}" size="" onkeypress="return keyRestrict(event, 2);" onchange="less_{$less_adjustments[i].accDetailID}();"  /> </slot></td>
                    </tr>
                    {/section}
                {/if}
                
                <tr><th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Total Fees:</h4></th></tr>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Total Fees </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="totalFee" id="totalFee" value="{$totalFee}" size="" readonly/> </slot></td>
                </tr>
                <tr><th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Total Payments:</h4></th></tr>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Total Payment </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="payment" id="payment" value="{$payment}" size=""  readonly/> </slot></td>
                </tr>
                <tr><th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Balance:</h4></th></tr>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Balance </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="balance" id="balance" value="{$balance}" size="" readonly/> </slot></td>
                </tr>
            </table>

        </td>
    </tr>
    
    </table
</td>
</tr>
</table>


</p>


</form>


