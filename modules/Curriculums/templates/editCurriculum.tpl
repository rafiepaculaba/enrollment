<form name="frmCurriculum" id="frmCurriculum" method="post" action="index.php?module=Curriculums&action=saveCurriculum">
<p>
<input type="hidden" id="theForm" name="theForm" value="createCurriculum" />
<input type="hidden" id="curID" name="curID" value="{$curID}" />
<input type="hidden" id="rstatus" name="rstatus" value="{$rstatus}" />

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " onclick="return check_form('frmCurriculum');" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="javascript: history.back();" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table> 

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit Curriculum</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Course <span class="required">*</span></slot>
        </td>
        <td class="dataField" width="82%">
        <slot> 
        <select name="courseID" id="courseID" onchange="getSubjects();">
        <option value="">--------------------------------</option>
        {section name=i loop=$courseList}
        <option value="{$courseList[i].courseID}" {if $courseList[i].courseID eq $courseID} selected {/if}>{$courseList[i].courseCode}</option>
        {/section}
        </select>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Curriculum Name <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input name="curName" value="{$curName}" type="text" id="curName" size="50" maxlength="100" onkeypress="return keyRestrict(event, 13);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Major </slot></td>
        <td class="dataField"><slot><input name="major" value="{$major}" type="text" id="major" size="50" maxlength="50" onkeypress="return keyRestrict(event, 12);" /></slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Effectivity Year <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input name="effectivity" value="{$effectivity}" type="text" id="effectivity" maxlength="4" onkeypress="return keyRestrict(event, 0);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Remarks </slot></td>
        <td class="dataField">
        <slot><textarea name="remarks" id="remarks" cols="45" onkeypress="return limitLength(event, 'remarks',150);" onkeypress="return keyRestrict(event, 12);">{$remarks}</textarea></slot>
        </td>
    </tr>
    </table>
</td></tr>
</table>
</p>
</form>

<form name="frmAddSubject" id="frmAddSubject" method="post">
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
		<th class="dataField" colspan="2" align="left"><h4 class="dataLabel"> Add Subject</h4></th>
    </tr>
    
    <tr>
        <td class="dataLabel">Subject </td>
		<td class="dataField">
		<slot>
		<select name="subjID" id="subjID">
        <option value="">-----------------------------</option>
        {section name=i loop=$subjectList}
        <option value="{$subjectList[i].subjID}">{$subjectList[i].subjCode}</option>
        {/section}
        </select>
		</slot>
		</td>
		
		<td class="dataLabel">Year Level </td>
		<td class="dataField">
		<slot>
		<select name="yrLevel" id="yrLevel">
		<option value="">----</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		</select>
		</slot>
		</td>
		
		<td class="dataLabel">Semester </td>
		<td class="dataField">
		<slot>
		{$SEMESTERS}
		</slot>
		</td>
		<td class="dataLabel">
		<slot><input name="cmdAdd" id="cmdAdd" class="button" type="button" value="  Add  " onclick="onAddSubject();" /></slot>
		</td>
	</tr>
	<tr>
		<td class="dataLabel">Prerequisites </td>
		<td class="dataField" colspan="6">
		 <slot>
		 <input type="hidden" id="prerequisitesID" name="prerequisitesID" /> 
		 <input type="text" id="prerequisites" name="prerequisites" size="50" readonly /> 
		 <input type="button" class="button" name="addPrereq" value="=" onclick="displayWindow('windowcontent','Prerequisites')" />
		 </slot>
		</td>
	</tr>
    </table>
</td></tr>
</table>
</p>
</form>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="45%" nowrap>Descriptive Title</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Units</td>
		<td scope="col" class="listViewThS1" width="30%" nowrap>Prerequisites</td>
	</tr>
</tbody>
</table>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div11Handle" onclick="hideShowDiv('div11');" />&nbsp; 1<sup>st</sup> Year Level - 1<sup>st</sup> Semester</h4></th>
    </tr>
</table>
<div id="div11" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj11}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	    <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj11[i].subjID}','{$subj11[i].yrLevel}','{$subj11[i].semCode}');" /></td>
	    
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj11[i].subjCode}  </td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj11[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj11[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj11[i].prerequisites}&nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj11_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj11_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>


<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div12Handle" onclick="hideShowDiv('div12');" />&nbsp; 1<sup>st</sup> Year Level - 2<sup>nd</sup> Semester</h4></th>
    </tr>
</table>
<div id="div12" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj12}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj12[i].subjID}','{$subj12[i].yrLevel}','{$subj12[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj12[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj12[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj12[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj12[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj12_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj12_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div14Handle" onclick="hideShowDiv('div14');" />&nbsp; 1<sup>st</sup> Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div14" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj14}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if} 
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj14[i].subjID}','{$subj14[i].yrLevel}','{$subj14[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj14[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj14[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj14[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj14[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj14_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj14_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div21Handle" onclick="hideShowDiv('div21');" />&nbsp; 2<sup>nd</sup> Year Level - 1<sup>st</sup> Semester</h4></th>
    </tr>
</table>
<div id="div21" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj21}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj21[i].subjID}','{$subj21[i].yrLevel}','{$subj21[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj21[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj21[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj21[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj21[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj21_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj21_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div22Handle" onclick="hideShowDiv('div22');" />&nbsp; 2<sup>nd</sup> Year Level - 2<sup>nd</sup> Semester</h4></th>
    </tr>
</table>
<div id="div22" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj22}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj22[i].subjID}','{$subj22[i].yrLevel}','{$subj22[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj22[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj22[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj22[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj22[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj22_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj22_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div24Handle" onclick="hideShowDiv('div24');" />&nbsp; 2<sup>nd</sup> Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div24" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj24}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj24[i].subjID}','{$subj24[i].yrLevel}','{$subj24[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj24[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj24[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj24[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj24[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj24_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj24_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div31Handle" onclick="hideShowDiv('div31');" />&nbsp; 3<sup>rd</sup> Year Level - 1<sup>st</sup> Semester</h4></th>
    </tr>
</table>
<div id="div31" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj31}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj31[i].subjID}','{$subj31[i].yrLevel}','{$subj31[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj31[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj31[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj31[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj31[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj31_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj31_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div32Handle" onclick="hideShowDiv('div32');" />&nbsp; 3<sup>rd</sup> Year Level - 2<sup>nd</sup> Semester</h4></th>
    </tr>
</table>
<div id="div32" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj32}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj32[i].subjID}','{$subj32[i].yrLevel}','{$subj32[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj32[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj32[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj32[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj32[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj32_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj32_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div34Handle" onclick="hideShowDiv('div34');" />&nbsp; 3<sup>rd</sup> Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div34" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj34}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj34[i].subjID}','{$subj34[i].yrLevel}','{$subj34[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj34[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj34[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj34[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj34[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj34_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj34_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div41Handle" onclick="hideShowDiv('div41');" />&nbsp; 4<sup>th</sup> Year Level - 1<sup>st</sup> Semester</h4></th>
    </tr>
</table>
<div id="div41" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj41}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj41[i].subjID}','{$subj41[i].yrLevel}','{$subj41[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj41[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj41[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj41[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj41[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj41_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj41_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div42Handle" onclick="hideShowDiv('div42');" />&nbsp; 4<sup>th</sup> Year Level - 2<sup>nd</sup> Semester</h4></th>
    </tr>
</table>
<div id="div42" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj42}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj42[i].subjID}','{$subj42[i].yrLevel}','{$subj42[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj42[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj42[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj42[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj42[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj42_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj42_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div44Handle" onclick="hideShowDiv('div44');" />&nbsp; 4<sup>th</sup> Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div44" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj44}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj44[i].subjID}','{$subj44[i].yrLevel}','{$subj44[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj44[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj44[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj44[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj44[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj44_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj44_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div51Handle" onclick="hideShowDiv('div51');" />&nbsp; 5<sup>th</sup> Year Level - 1<sup>st</sup> Semester</h4></th>
    </tr>
</table>
<div id="div51" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj51}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj51[i].subjID}','{$subj51[i].yrLevel}','{$subj51[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj51[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj51[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj51[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj51[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj51_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj51_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div52Handle" onclick="hideShowDiv('div52');" />&nbsp; 5<sup>th</sup> Year Level - 2<sup>nd</sup> Semester</h4></th>
    </tr>
</table>
<div id="div52" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj52}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj52[i].subjID}','{$subj52[i].yrLevel}','{$subj52[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj52[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj52[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj52[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj52[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj52_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj52_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div54Handle" onclick="hideShowDiv('div54');" />&nbsp; 5<sup>th</sup> Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div54" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj54}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	   <td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
	    align="left" bgcolor="#fdfdfd" valign="top" width="5%"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSubject('{$subj54[i].subjID}','{$subj54[i].yrLevel}','{$subj54[i].semCode}');" /></td>
	   
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj54[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="45%">{$subj54[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj54[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj54[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	
	{if $subj54_ctr gt 0}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="5%">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="45%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj54_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	{/if}
	
	</tbody></table>
</div>
<hr>
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="goSubmitForm('frmCurriculum');" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="javascript: history.back();" />
    </td>
  </tr>
</table> 

<!--popup:add of prerequisites here-->
<div style="width: 500px; height: 300px; visibility:hidden; display:none;" id="windowcontent">
	<table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr>
	        <td>
	           <div style="width: 100%; height:180px; overflow: auto;" id="divSubjectList">
	            <input type="hidden" id="ctr_subj" name="ctr_subj" value="{$ctr_subj}" />
                <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                		<td scope="col" class="listViewThS1" width="10%" nowrap>&nbsp;</td>
                		<td scope="col" class="listViewThS1" width="30%" nowrap>Subject</td>
                		<td scope="col" class="listViewThS1" width="60%" nowrap>Descriptive Title</td>
                	</tr>
                	<!-- Start of subject Listing -->
                	{php}
                	   $ctr=0
                	{/php}
                	{section name=i loop=$subjectList}
                	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
                		<td scope="row" 
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top"><input type="checkbox" name="prereq{php}echo $ctr; {/php}" id="prereq{php}echo $ctr; {/php}" value="{$subjectList[i].subjID}-{$subjectList[i].subjCode}" /></td>
                		
                		<td scope="row" 
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top">{$subjectList[i].subjCode}</td>
                		
                		<td scope="row"
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top">{$subjectList[i].descTitle}</td>
                	</tr>
                	<tr>
                		<td colspan="20" class="listViewHRS1"></td>
                	</tr>
                	{php}
                	   $ctr++;
                	{/php}
                	{/section}
                	<!-- End of subject Listing -->
                </tbody>
                </table>
                
                </div>
	        </td>
        </tr>
        <tr>
	        <td>
	        <hr>
	        <input class="button" type="button" name="cmdAddPrerequisites" id="cmdAddPrerequisites" value="Add" onclick="addPrerequisites();"/>
	        <input class="button" type="button" name="cmdCancel" id="cmdCancel" value="Close" onclick="hiddenFloatingDiv('windowcontent');"/>
	     	</td>
        </tr>
        </table>
</div>
<!--end of popup adding prerequisites-->

