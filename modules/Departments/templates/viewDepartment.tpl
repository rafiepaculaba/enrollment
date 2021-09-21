<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Departments&action=listDepartments');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Departments&action=editDepartment&deptID={$deptID}');" />
    {/if}
        
    {if $hasDelete eq 1 }
	<input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteDepartment('{$deptID}');" />
    {/if}
  </tr>
</table>  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Department Code :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$deptCode} &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Department Name :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$deptName} &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Department Chairman :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$deptChairman} &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Remarks :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$remarks}&nbsp; </slot></td>
    </tr>
</table>
</p>