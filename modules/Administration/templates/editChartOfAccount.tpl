<form name="frmAccount" id="frmAccount" method="post" action="index.php?module=Administration&action=saveChartAccountMaster">
<p>

<input type="hidden" id="theForm" name="theForm" value="Edit" />

<table border="0" width="100%">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="saveAccount();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="javascript: history.back();" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="10" align="left"><h4 class="dataLabel"> Edit Account Name </h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="15%"><slot>Type </slot></td>
        <td class="dataField" width="85%">
        <slot>
        <!--<select id="typeID">
        <option value="">------------Select Type-----------</option>
        	{section name=i loop=$types}
        	   <option value="{$types[i].id}"
        	   
                {if $types[i].account_type eq $account_type}
        	       selected 
                {/if}
                
        	   >{$types[i].name}</option>
        	{/section}
        </select>-->
        <input type="hidden" size="30" name="typeID" id="typeID" value="{$account_type}" />
        <input type="text" size="30" name="type" id="type" value="{$account_name_type}" readonly />
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" width="15%"><slot>Account Code </slot></td>
        <td class="dataField" width="85%">
        <slot><input type="text" size="30" name="acctCode" id="acctCode" value="{$account_code}" readonly /></slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" width="15%"><slot>Account Name <span class="required">*</span></slot></td>
        <td class="dataField" width="85%">
        <slot><input type="text" size="30" name="acctName" id="acctName" value="{$account_name}" /></slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>

