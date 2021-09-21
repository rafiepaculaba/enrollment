<form method="post" name="frmConfig" id="frmConfig" action="index.php?module=Config&action=saveConfigElem" onsubmit="return check_form('frmConfig')" >

<input type="hidden" name="configID" id="configID" value="{$configID}" />
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" tabindex="5" type="submit" id="cmdSave" value=" Save " />
    <input class="button" name="cmdCancel" tabindex="6" type="button" id="cmdCancel" value=" Cancel " onclick="history.back();" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit Elementary Configuration</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Title <span class="required">*</span></slot></td>
        <td class="dataField" width="80%"><slot><input type="text" tabindex="1" name="title" id="title" value="{$title}" maxlength="30" size="35"/> </slot> </td>
    </tr>
    <tr>
        <td class="dataLabel" valign="top"><slot>Definition <span class="required">*</span></slot></td>
        <td class="dataField"><slot><textarea name="definition" id="definition" tabindex="2" rows="10" cols="70">{$definition}</textarea></slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

</form>