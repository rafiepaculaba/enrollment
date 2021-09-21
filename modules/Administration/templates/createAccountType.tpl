<form name="frmAccountType" id="frmAccountType" method="post" action="index.php?module=Administration&action=saveChartAccountType" onsubmit="return check_form('frmAccountType');">
<p>

<input type="hidden" id="theForm" name="theForm" value="createAccountType" />

<table border="0" width="100%">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="javascript: history.back();" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="10" align="left"><h4 class="dataLabel">Add Account Type</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="15%"><slot>Parent Type </slot></td>
        <td class="dataField" width="85%">
        <slot>
        <select name="parentID" id="parentID">
        <option value="-1">------------Select Type-----------</option>
        	{section name=i loop=$types}
        	   <option value="{$types[i].id}">{$types[i].name}</option>
        	{/section}
        </select>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" width="15%"><slot>Type Name <span class="required">*</span></slot></td>
        <td class="dataField" width="85%">
        <slot><input type="text" size="30" name="typeName" id="typeName" /></slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>

