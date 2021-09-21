<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=SchoolFees&action=listSchoolFeeHS');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=SchoolFees&action=editSchoolFeeHS&feeID={$feeID}');" />
    {/if}
        
    {if $hasDelete eq 1 }
	<input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteSchoolFee('{$feeID}');" />
    {/if}
  </tr>
</table>  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="2" align="left"><h4 class="tabDetailViewDL">High School School Fee</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>School Year : </slot></td>      
        <td class="tabDetailViewDF" width="82%"><slot>{$schYear} &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Year Level : </slot></td>      
        <td class="tabDetailViewDF" width="82%"><slot>{$yrLevel} &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Item :</slot></td>
        <td class="tabDetailViewDF"><slot>{$item} &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Amount :</slot></td>
        <td class="tabDetailViewDF"><slot>{$amount|number_format:2:".":","} &nbsp; </slot></td>
    </tr>
</table>
</p>