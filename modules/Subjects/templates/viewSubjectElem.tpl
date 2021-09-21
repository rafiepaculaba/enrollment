<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Subjects&action=listSubjectsElem');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Subjects&action=editSubjectElem&subjID={$subjID}');" />
    {/if}
        
    {if $hasDelete eq 1 }
	<input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteSubject('{$subjID}');" />
    {/if}
  </tr>
</table>  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="tabDetailViewDL"><slot>Grade Level :</slot></td>      
        <td class="tabDetailViewDF"><slot>{$yrLevel} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Subject Code :</slot></td>      
        <td class="tabDetailViewDF"><slot>{$subjCode} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Descriptive Title :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot>{$descTitle} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Subject Description :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot>{$subjDesc} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Units :</slot></td>
        <td class="tabDetailViewDF"><slot>{$units|number_format:1:".":","} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Type :</slot></td>
        <td class="tabDetailViewDF"><slot>{$type} &nbsp;</slot></td>
    </tr>

</table>
</p>