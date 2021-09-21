<form name="frmAccount" id="frmAccount" method="post" action="index.php?module=Account&action=saveAccountCol" onsubmit="return check_form('frmAccount')">
<input type="hidden" id="theForm" name="theForm" value="EditAccount" />
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Account&action=viewAccountCol&accID={$accID}')" />
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
        <td class="dataLabel" width="15%"><slot>Semester </slot></td>
        <td class="dataField" width="35%"><slot> <input type="text" name="semCode" id="semCode" value="{$semCode}" size="" readonly /> </slot></td>
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
        <td class="dataLabel"><slot>Course - Year </slot></td>
        <td class="dataField"><slot> <input type="text" name="studentName" id="studentName" value="{$courseCode}-{$yrLevel}" size="" readonly /> </slot></td>
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
            
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Fees:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Tuition </slot></td>
                    <td class="dataField" width="70%">
                    <slot> <input type="text" name="tuitionFee" id="tuitionFee" value="{$tuitionFee}" size="" onkeypress="return keyRestrict(event, 2);" onchange="onChangeTuition();" /> </slot>
                    </td>
                </tr>
                
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Laboratory </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="labFee" id="labFee" value="{$labFee}" size="" onkeypress="return keyRestrict(event, 2);" onchange="onChangeLab();"  /> </slot></td>
                </tr>
                
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Registration </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="regFee" id="regFee" value="{$regFee}" size="" onkeypress="return keyRestrict(event, 2);" onchange="onChangeReg();"  /> </slot></td>
                </tr>
                
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Miscellaneous </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="miscFee" id="miscFee" value="{$miscFee}" size="" onkeypress="return keyRestrict(event, 2);" onchange="onChangeMisc();"  /> </slot></td>
                </tr>
                
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Adjustments:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Add </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="addAdj" id="addAdj" value="{$addAdj}" size="" onkeypress="return keyRestrict(event, 2);" onchange="onChangeAddAdj();"  /> </slot></td>
                </tr>
                
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Less </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="lessAdj" id="lessAdj" value="{$lessAdj}" size="" onkeypress="return keyRestrict(event, 2);" onchange="onChangeLessAdj();"  /> </slot></td>
                </tr>
                
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Total Fees:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Total Fees </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="totalFee" id="totalFee" value="{$totalFee}" size="" readonly/> </slot></td>
                </tr>
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Total Payments:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Total Payment </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="payment" id="payment" value="{$payment}" size=""  readonly/> </slot></td>
                </tr>
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Balance:</h4></th>
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


