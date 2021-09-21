<form name="frmORSeries" id="frmORSeries" method="post" action="index.php?module=Payments&action=saveORSeries" >
<input type="hidden" name="id" id="id" value="{$id}">
<input type="hidden" name="prevfirstORNO" id="prevfirstORNO" value="{$firstORNO}">
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}">
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="saveORSeries();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Payments&action=listORSeries')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">New College OR Series</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot> Fiscal Year <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
        <input name="fiscalYear" id="fiscalYear" size="15" maxlength="10" value="{$fiscalYear}" type="text" onkeypress="return keyRestrict(event, 8);" />
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>First No. <span class="required">*</span> </slot></td>
        <td class="dataField" width="82%">
        <slot> <input type="text" name="firstORNO" id="firstORNO" value="{$firstORNO}" size="30" /> </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Last No. <span class="required">*</span> </slot></td>
        <td class="dataField" width="82%">
        <slot> <input type="text" name="lastORNO" id="lastORNO" value="{$lastORNO}" size="30" /> </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Cashier <span class="required">*</span> </slot></td>
        <td class="dataField" width="82%">
    		<select name="cashier" id="cashier">
    		{if $isCashierGroup eq 0}
                <option value="">------------------------------------</option>
            {/if}
            {section name=i loop=$user_list}
            <option value="{$user_list[i].id}" {if $user_list[i].id eq $cashier} selected {/if}>{$user_list[i].last_name}, {$user_list[i].first_name}</option>
            {/section}
            </select>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>