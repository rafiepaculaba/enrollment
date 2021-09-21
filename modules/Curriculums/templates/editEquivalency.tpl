<form method="post" name="frmEquivalency" id="frmEquivalency" action="index.php?module=Curriculums&action=saveEquivalency" onsubmit="return check_form('frmEquivalency');" >

<input type="hidden" name="theForm" id="theForm" value="frmEquivalency" />
<input type="hidden" name="eqID" id="eqID" value="{$eqID}" />
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit Equivalency</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Curriculum <span class="required">*</span></slot></td>
        <td class="dataField" width="80%">
        <slot>
        <div id="divCurriculum">
        <select name="curID" id="curID" onchange="getSubjects();">
        <option value="">---------------------------------------------------------------------------------------------------------</option>
        {section name=i loop=$curList}
        <option value="{$curList[i].curID}" {if $curList[i].curID eq $curID} selected {/if}>{$curList[i].curName}</option>
        {/section}
        </select>
        </div>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" valign="top"><slot>Subject <span class="required">*</span></slot></td>
        <td class="dataField">
        <slot>
		<select name="subjID" id="subjID">
        <option value="">---------------------------------------------------------------------------------------------------------</option>
        {section name=i loop=$cursubjectList}
        <option value="{$cursubjectList[i].subjID}" {if $cursubjectList[i].subjID eq $subjID} selected {/if}>{$cursubjectList[i].subjCode} - {$cursubjectList[i].descTitle} ({$cursubjectList[i].units})</option>
        {/section}
        </select>
		</slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel" valign="top"><slot>Equivalent Subject <span class="required">*</span></slot></td>
        <td class="dataField">
        <slot>
    		<select name="eqSubjID" id="eqSubjID">
            <option value="">---------------------------------------------------------------------------------------------------------</option>
            {section name=i loop=$subjectList}
            <option value="{$subjectList[i].subjID}" {if $subjectList[i].subjID eq $eqSubjID} selected {/if}>{$subjectList[i].subjCode} - {$subjectList[i].descTitle} ({$subjectList[i].units})</option>
            {/section}
            </select>
		</slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>

</form>