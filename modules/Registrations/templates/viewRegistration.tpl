
<table width="100%" border="0">
  <tr>
    <td>
   <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Registrations&action=listRegistrations');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Registrations&action=editRegistration&regID={$regID}');" />
    {/if}
    
    {if $hasDelete eq 1 }
    <input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteRegistration('{$regID}');" />
    {/if}
  </tr>
</table>  

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Registration :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$regID}&nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Complete Name :</slot></td>
        <td >
        <slot>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="30%" class="tabDetailViewDF">{$lname}, &nbsp;</td>
            <td width="30%" class="tabDetailViewDF">{$fname}&nbsp;</td>
            <td width="40%" class="tabDetailViewDF">{$mname}&nbsp;</td>
        </tr>
        </table>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%">Last Name</td>
                <td width="30%">First Name</td>
                <td width="40%">Middle Name</td>
            </tr>
            </table>
        </td>
    </tr>
</table>
</p>

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Personal Info</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Age :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>{$age}&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="18%"><slot>Birthday :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>{$bday}&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Gender :</slot></td>
        <td class="tabDetailViewDF"><slot>{$gender}&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Civil Status :</slot></td>
        <td class="tabDetailViewDF"><slot>{$cstatus}&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Nationality :</slot></td>
        <td class="tabDetailViewDF"><slot>{$nationality}&nbsp;</slot></td>
        <td class="tabDetailViewDL">&nbsp;</td>
        <td class="tabDetailViewDF">&nbsp;</td>
    </tr>
</table>
</p>
  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDF" colspan="4" align="left"><h4 class="tabDetailViewDL">Documents</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Document Entry :</slot></td>
        <td class="tabDetailViewDF"><slot>{$entryDocs}&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Last School Attended :</slot></td>
        <td class="tabDetailViewDF"><slot>{$lastSchool}&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Last Attended :</slot></td>
        <td class="tabDetailViewDF"><slot>{$sch_last_attended}&nbsp;</slot></td>
    </tr>
</table>
</p>