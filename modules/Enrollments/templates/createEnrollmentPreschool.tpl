<form name="frmEnrollment" id="frmEnrollment" method="post" action="index.php?module=Enrollments&action=saveEnrollmentPreschool" >
<p>

<input type="hidden" id="theForm" name="theForm" value="createEnrollment" />
<input type="hidden" id="yrLvl" name="yrLvl" value="" />
<input type="hidden" id="sy" name="sy" value="" />
<table border="0" width="100%">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="saveEnrollment();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Enrollments&action=listEnrollmentsPreschool')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create Enrollment</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="15%" valign="top"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" width="35%"><slot>{$SCHOOLYEAR}</slot></td>
        <td class="dataLabel" width="15%" valign="top"><slot>Student Type <span class="required">*</span></slot></td>
        <td class="dataField" width="35%">
        <slot> 
       <select name="studType" id="studType" onchange="changeColor();">
        <option value="1">Old</option>
        <option value="2">New</option>
        <option value="3">Transferee</option>
        </select>
        </slot>
        </td>
    </tr>
    
    <tr>
        <td class="dataLabel" height="50" valign="bottom"><slot>ID No. <span class="required">*</span></slot> </td>
        <td class="dataField" colspan="3" valign="bottom"><slot>
        <input type="hidden" name="previdno" id="previdno" /> 
        <input type="text" name="idno" id="idno" size="25" maxlength="15" onkeypress="return keyRestrict2(event, 14,'onCheckEnrollment');" onchange="checkPrevID();" /> 
        <input type="button" name="cmdLookup" id="cmdLookup" value="=" onclick="popUp('index.php?module=Enrollments&action=listStudentsPreschool&sugar_body_only=1')" />
        </slot>  </td>
    </tr>
    
    <tr>
        <td class="dataLabel"><slot>Student Name </slot> </td>
        <td class="dataField" colspan="3" valign="bottom">
        
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%"><slot><input type="text" name="lname" id="lname" size="25" maxlength="25" readonly onkeypress="return keyRestrict(event, 12);" /></slot>&nbsp;,</td>
                <td width="30%"><slot><input type="text" name="fname" id="fname" size="25" maxlength="25" readonly onkeypress="return keyRestrict(event, 12);" /></slot></td>
                <td width="40%"><slot><input type="text" name="mname" id="mname" size="25" maxlength="25" readonly onkeypress="return keyRestrict(event, 12);" /></slot></td>
            </tr>
            </table>
        
        </td>
    </tr>
    <tr>
        <td class="dataLabel">&nbsp;</td>
        <td class="dataField" colspan="3" valign="top">
        
           <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%">Last Name</td>
                <td width="30%">First Name</td>
                <td width="40%">Middle Name</td>
            </tr>
            </table>
        
        </td>
    </tr>
    
    <tr>
        <td class="dataLabel" height="50" valign="bottom"><slot>Level <span class="required">*</span></slot> </td>
        <td class="dataField" valign="bottom"><slot>{$YEARLEVEL}</slot></td>
        <td class="dataLabel" valign="bottom"><slot>Section <span class="required">*</span></slot></td>
        <td class="dataField" valign="bottom">
        <slot>
        <input type="hidden" name="secID" id="secID" size="10" maxlength="25" readonly onkeypress="return keyRestrict(event, 0);"/> &nbsp;
        <input type="text" name="secName" id="secName" size="10" maxlength="25" readonly onkeypress="return keyRestrict(event, 0);"/> &nbsp;
        <input name="cmdBlock" id="cmdBlock" class="button" type="button" value=" = " onclick="displayWindow('windowcontent','Block Sections')" />
        &nbsp;&nbsp;
<!--        <img src="themes/Sugar/images/basic_search.gif" id="divSubjectHandle" title="Add Subject" align="Add Subject" onclick="hideShowSubject('divSubject');" />-->
        </slot>
        </td>
    </tr>
   
    </table>
</td></tr>
</table>
</p>


<!--
<div id="divSubject" style="display:block">
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
		<th class="dataField" colspan="10" align="left"><h4 class="dataLabel"> Add Schedule</h4></th>
    </tr>
    
    <tr>
        <td class="dataLabel" width="15%" valign="top">Sched Code </td>
		<td class="dataField" width="20%" valign="top">
		<slot><input type="text" name="schedCode" id="schedCode" size="25" maxlength="10" onkeypress="return keyRestrict2(event, 0,'onCheckSchedCode');" /></slot>
		</td>
		<td class="dataField" width="25%" valign="top">
		<slot><input name="cmdAdd" id="cmdAdd" class="button" type="button" value="  Add  " onclick="onCheckSchedCode();" /></slot>
		</td>
		<td class="dataLabel" width="40%">
		<slot>&nbsp;</slot>
		</td>
	</tr>
</table>
</p>
</div>-->

<div id="divSchedules">
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Code</td>
		<td scope="col" class="listViewThS1" width="30%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Time</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Days</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Room</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Units</td>
	</tr>
</tbody>
</table>
</div>

<p>
<hr>
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="saveEnrollment();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Enrollments&action=listEnrollmentsPreschool')" />
    </td>
  </tr>
</table>  
</p>

</form>



<!--popup:add of prerequisites here-->
<div style="width: 500px; height: 300px; visibility:hidden; display:none;" id="windowcontent">
	<table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr>
	        <td>
	           <div style="width: 100%; height:180px; overflow: auto;" id="divSectionList">
                <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr height="20">
                		<td scope="col" class="listViewThS1" width="40%" nowrap>Section</td>
                		<td scope="col" class="listViewThS1" width="30%" nowrap>Course</td>
                		<td scope="col" class="listViewThS1" width="30%" nowrap>Grade</td>
                	</tr>
                	<!-- Start of subject Listing -->
                	{section name=i loop=$list}
                	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
                		<td scope="row" 
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top"><a href="index.php?module=Enrollments&action=createEnrollmentCol&idno=&yrLevel=&schYear=&semCode=&secID={$list[i].secID}" class="listViewTdLinkS1">{$list[i].secName}</a></td>
                		
                		<td scope="row"
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].courseCode}</td>
                		
                		<td scope="row"
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].schYear}</td>
                	</tr>
                	<tr>
                		<td colspan="20" class="listViewHRS1"></td>
                	</tr>
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
	        <input class="button" type="button" name="cmdCancel" id="cmdCancel" value="Close" onclick="hiddenFloatingDiv('windowcontent');"/>
	     	</td>
        </tr>
        </table>
</div>
<!--end of popup adding prerequisites-->

