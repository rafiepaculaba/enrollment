<form name="frmAssessment" id="frmAssessment" method="post" action="index.php?module=Account&action=saveAssessmentCol">
<input type="hidden" id="theForm" name="theForm" value="EditAssessment" />
<input type="hidden" id="assID" name="assID" value="{$assID}" />
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Account&action=viewAssessmentCol&assID={$assID}')" />
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
        <td class="dataField" width="35%"><slot> <input type="text" name="semCode" id="semCode" value="{if $semCode eq 1}1st{elseif $semCode eq 2}2nd{else}Summer{/if}" size="" readonly /> </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>ID No. </slot></td>
        <td class="dataField"><slot> <input type="text" name="idno" id="idno" value="{$idno}" size="" readonly /> </slot></td>
        <td class="dataLabel"><slot>Term </slot></td>
        <td class="dataField"><slot> <input type="text" name="term" id="term" value="{$term}" size="" readonly /> </slot></td>
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
                    <slot> <input type="text" name="tuitionFee" id="tuitionFee" value="{$tuitionFee}" size="" readonly/> </slot>
                    </td>
                </tr>
                
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Laboratory </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="labFee" id="labFee" value="{$labFee}" size=""  readonly /> </slot></td>
                </tr>
                
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Registration </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="regFee" id="regFee" value="{$regFee}" size=""  readonly  /> </slot></td>
                </tr>
                
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Miscellaneous </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="miscFee" id="miscFee" value="{$miscFee}" size=""  readonly /> </slot></td>
                </tr>
                
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Adjustments:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Add </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="addAdj" id="addAdj" value="{$addAdj}" size=""  readonly /> </slot></td>
                </tr>
                
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Less </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="lessAdj" id="lessAdj" value="{$lessAdj}" size=""  readonly /> </slot></td>
                </tr>
                
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Total Fees:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Total Fees </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="totalFees" id="totalFees" value="{$totalFees}" size="" readonly/> </slot></td>
                </tr>
                
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Total Payments:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Total Payment </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="ttlPayment" id="ttlPayment" value="{$ttlPayment}" size="" readonly/> </slot></td>
                </tr>
                
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Balance:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Balance </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="balance" id="balance" value="{$balance}" size="" readonly/> </slot></td>
                </tr>
                
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Due for {$term}:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Amount Due </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="ttlDue" id="ttlDue" value="{$ttlDue}" size="" onkeypress="return keyRestrict(event, 2);" /> </slot></td>
                </tr>
                
                <th class="dataLabel" colspan="4" align="left"><h4 class="dataLabel">Total Payments:</h4></th>
                <tr>
                    <td class="dataLabel" width="30%"><slot>&nbsp;&nbsp;&nbsp;&nbsp;Amount Paid </slot></td>
                    <td class="dataField" width="70%"><slot> <input type="text" name="amtPaid" id="amtPaid" value="{$amtPaid}" size=""  readonly /> </slot></td>
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


