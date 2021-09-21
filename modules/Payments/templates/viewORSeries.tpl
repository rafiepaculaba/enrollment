
<table width="100%" border="0">
  <tr>
    <td>
   <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Payments&action=listORSeries');" />
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Payments&action=editORSeries&id={$id}');" />
    {/if}
    
    {if $hasDelete eq 1 }
    <input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteORSeries('{$id}');" />
    {/if}
  </tr>
</table>  

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>OR ID :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot>{$id} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Fical Year: </slot></td>
        <td class="tabDetailViewDF"><slot>{$fiscalYear} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>First OR No.: </slot></td>
        <td class="tabDetailViewDF"><slot>{$firstORNO} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Last OR No.: </slot></td>
        <td class="tabDetailViewDF"><slot>{$lastORNO} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Cashier: </slot></td>
        <td class="tabDetailViewDF"><slot>{$cashierName} &nbsp;</slot></td>
    </tr>
</table>
</p>
