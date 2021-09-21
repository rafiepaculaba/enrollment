<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Credited&action=listCreditedSubjects');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Credited&action=editCreditedSubject&creID={$creID}');" />
    {/if}
        
    {if $hasDelete eq 1 }
	<input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteCreditedSubject('{$creID}');" />
    {/if}
  </tr>
</table>  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
        <td class="tabDetailViewDL" width="18%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$schYear}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Semester :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$semCode}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$idno}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$studName}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Year Level :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$yrLevel}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Credited Subject :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$subjCode}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Final Grade :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$fgrade}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Equivalent Subject :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$eqSubj} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Equivalent Units :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$eqUnits}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>School :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$school}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Remarks :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$remarks}  &nbsp;</slot></td>
    </tr>
</table>
</p>