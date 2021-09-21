<form name="frmSchoolFeeElem" id="frmSchoolFeeElem" method="post" action="index.php?module=SchoolFees&action=saveSchoolFeeElem" >

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="checkDuplicate();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=SchoolFees&action=listSchoolFeeElem')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create School Fee: Elementary</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" width="80%"><slot> {$SCHOOLYEAR} </slot></td>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Grade Level <span class="required">*</span></slot></td>
        <td class="dataField" colspan="3" width="82%">
        <slot>
        <select name="yrLevel" id="yrLevel" >      
        <option value="">----------------------</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="S">Special</option>
        </select>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Item <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
          <input type="text" name="item" id="item" size="50" maxlength="100" onkeypress="return keyRestrict(event, 7);" />
        </slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Amount <span class="required">*</span></slot></td>
        <td class="dataField"><slot>
          <input type="text" name="amount" id="amount" size="18" maxlength="12" onkeypress="return keyRestrict(event, 1);" />
        </slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>
