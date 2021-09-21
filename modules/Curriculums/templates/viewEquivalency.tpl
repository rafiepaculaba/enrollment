<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Curriculums&action=listEquivalency');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Curriculums&action=editEquivalency&eqID={$eqID}');" />
    {/if}
        
    {if $hasDelete eq 1 }
	<input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteEquivalency('{$eqID}');" />
    {/if}
  </tr>
</table>  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
     <tr>
        <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Equivalency</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Curriculum :</slot></td>
        <td class="tabDetailViewDF" width="62%"><slot>{$curName}&nbsp; </slot></td>
        <td class="tabDetailViewDF" width="10%"><slot>&nbsp; </slot></td>
        <td class="tabDetailViewDF" width="10%"><slot>&nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Subject :</slot></td>
        <td class="tabDetailViewDF"><slot>{$subjCode} - {$subjDescTitle}&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Units :</slot></td>
        <td class="tabDetailViewDF"><slot>{$subjUnits}&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Equivalent Subject :</slot></td>
        <td class="tabDetailViewDF"><slot>{$eqSubjCode} - {$eqSubjDescTitle}&nbsp; </slot></td>
        <td class="tabDetailViewDL"><slot>Units :</slot></td>
        <td class="tabDetailViewDF"><slot>{$eqSubjUnits}&nbsp; </slot></td>
    </tr>
</table>
</p>