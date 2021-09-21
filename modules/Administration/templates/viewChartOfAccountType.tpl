<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Administration&action=listChartOfAccounts');" />
    
    {if $hasEdit eq 1 }
        <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Administration&action=editChartOfAccount&acctCode={$account_code}');" />
    {/if}
        
    {if $hasDelete eq 1 }
	   <input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteRecord('{$configID}');" />
    {/if}
  </tr>
</table>

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">View Account Type</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Parent Type :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot>{$parentType}</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Type Name :</slot></td>
        <td class="tabDetailViewDF"><slot>{$typeName}</slot></td>
    </tr>
</table>
</p>