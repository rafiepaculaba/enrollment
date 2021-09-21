<form name="frmCurriculum" id="frmCurriculum" method="post" action="index.php?module=Curriculums&action=saveCurriculum">
<p>

<input type="hidden" id="theForm" name="theForm" value="createCurriculum" />
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Save " onclick="return check_form('frmCurriculum');" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Curriculums&action=listCurriculums')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create Curriculum</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="18%"><slot>Course <span class="required">*</span></slot>
        </td>
        <td class="dataField" width="82%">
        <slot> 
        <select name="courseID" id="courseID" onchange="getSubjects();">
        <option value="">--------------------------------</option>
        {section name=i loop=$courseList}
        <option value="{$courseList[i].courseID}">{$courseList[i].courseCode}</option>
        {/section}
        </select>
        </slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Curriculum Name <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input name="curName" type="text" id="curName" size="50" maxlength="100" onkeypress="return keyRestrict(event, 13);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Major </slot></td>
        <td class="dataField"><slot><input name="major" type="text" id="major" size="50" maxlength="50" onkeypress="return keyRestrict(event, 12);" /></slot>
        </td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Effectivity Year <span class="required">*</span></slot></td>
        <td class="dataField"><slot><input name="effectivity" type="text" id="effectivity" maxlength="4" onkeypress="return keyRestrict(event, 0);" /></slot></td>
    </tr>
    <tr>
        <td class="dataLabel"><slot>Remarks </slot></td>
        <td class="dataField">
        <slot><textarea name="remarks" id="remarks" cols="45" onkeypress="return limitLength(event, 'remarks',150);" onkeypress="return keyRestrict(event, 12);"></textarea></slot>
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
		 <input type="button" class="button" name="addPrereq" value=" = " onclick="displayWindow('windowcontent','Prerequisites')" />
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
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div11Handle" onclick="hideShowDiv('div11');" />&nbsp; 1st Year Level - 1st Semester</h4></th>
    </tr>
</table>
<div id="div11" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div12Handle" onclick="hideShowDiv('div12');" />&nbsp; 1st Year Level - 2nd Semester</h4></th>
    </tr>
</table>
<div id="div12" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div14Handle" onclick="hideShowDiv('div14');" />&nbsp; 1st Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div14" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div21Handle" onclick="hideShowDiv('div21');" />&nbsp; 2nd Year Level - 1st Semester</h4></th>
    </tr>
</table>
<div id="div21" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div22Handle" onclick="hideShowDiv('div22');" />&nbsp; 2nd Year Level - 2nd Semester</h4></th>
    </tr>
</table>
<div id="div22" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div24Handle" onclick="hideShowDiv('div24');" />&nbsp; 2nd Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div24" style="display:block">

</div>


<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div31Handle" onclick="hideShowDiv('div31');" />&nbsp; 3rd Year Level - 1st Semester</h4></th>
    </tr>
</table>
<div id="div31" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div32Handle" onclick="hideShowDiv('div32');" />&nbsp; 3rd Year Level - 2nd Semester</h4></th>
    </tr>
</table>
<div id="div32" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div34Handle" onclick="hideShowDiv('div34');" />&nbsp; 3rd Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div34" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div41Handle" onclick="hideShowDiv('div41');" />&nbsp; 4th Year Level - 1st Semester</h4></th>
    </tr>
</table>
<div id="div41" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div42Handle" onclick="hideShowDiv('div42');" />&nbsp; 4th Year Level - 2nd Semester</h4></th>
    </tr>
</table>
<div id="div42" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div44Handle" onclick="hideShowDiv('div44');" />&nbsp; 4th Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div44" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div51Handle" onclick="hideShowDiv('div51');" />&nbsp; 5th Year Level - 1st Semester</h4></th>
    </tr>
</table>
<div id="div51" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div52Handle" onclick="hideShowDiv('div52');" />&nbsp; 5th Year Level - 2nd Semester</h4></th>
    </tr>
</table>
<div id="div52" style="display:block">

</div>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div54Handle" onclick="hideShowDiv('div54');" />&nbsp; 5th Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div54" style="display:block">

</div>
<hr>
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="goSubmitForm('frmCurriculum');" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Curriculums&action=listCurriculums')" />
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

