
<table width="100%" border="0">
  <tr>
    <td>
   <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Account&action=listAssessmentsElem');" />
    
	{if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Account&action=editAssessmentElem&assID={$assID}');" />
    {/if}
    
    <input class="button" name="cmdprint" type="button" id="cmdprint" value="Print" onclick="popUp('index.php?module=Account&action=printAssessmentElem&assID={$assID}&sugar_body_only=1');" />    
    
  </tr>
</table>  

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <th class="tabDetailViewDL" colspan="4" align="center"><h4 class="tabDetailViewDL">Statement of Account</h4></th>
    <tr>
        <td class="tabDetailViewDL" width="15%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="35%"><slot>{$schYear} &nbsp;</slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" width="35%"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF"><slot>{$idno} &nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Term :</slot></td>
        <td class="tabDetailViewDF"><slot>{$term} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF"><slot>{$lname} , {$fname} {$mname} &nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Grade :</slot></td>
        <td class="tabDetailViewDF"><slot>{$yrLevel} &nbsp;</slot></td>
    </tr>
    <tr>
<!--        <td class="tabDetailViewDL">&nbsp;</td>-->
        <td colspan="4">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Old Account:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL" width="100"><slot>Old Balance </slot></td>
                    <td class="tabDetailViewDF" width="100" align="right"><slot><b>{$oldBalance|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
            
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Fees:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL" width="100"><slot>Tuition </slot></td>
                    <td class="tabDetailViewDF" width="100" align="right"><slot><b>{$tuitionFee|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr>
                    <td class="tabDetailViewDL"><slot>Laboratory </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$labFee|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr>
                    <td class="tabDetailViewDL"><slot>Registration </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$regFee|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr>
                    <td class="tabDetailViewDL"><slot>Miscellaneous </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$miscFee|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Adjustments:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Add </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$addAdj|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr>
                    <td class="tabDetailViewDL"><slot>Less </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$lessAdj|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Total Fees:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Total Fees </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$totalFees|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Total Payments:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Total Payment </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$ttlPayment}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Balance:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Balance </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$balance|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Due for {$term} Period:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Amount Due </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$ttlDue|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Total Payments:</h4></th>
                <tr>
                    <td class="tabDetailViewDL"><slot>Amount Paid </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>{$amtPaid|number_format:2}</b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
            </table>

        </td>
    </tr>
</table>


</p>
