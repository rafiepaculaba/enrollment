<table width="100%" border="0">
  <tr>
    <td>
   <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Payments&action=listPaymentTypesPreschool');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Payments&action=editPaymentTypePreschool&paymentTypeID={$paymentTypeID}');" />
    {/if}
    
    {if $hasDelete eq 1 }
    <input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deletePaymentTypePreschool('{$paymentTypeID}');" />
    {/if}
  </tr>
</table>  

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Payment Type ID :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot>{$paymentTypeID} </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Payment Name :</slot></td>
        <td class="tabDetailViewDF"><slot>{$paymentName} </slot></td>
    </tr>
</table>
</p>
