<form name="frmEnrollment" id="frmEnrollment" method="post" action="index.php?module=Enrollments&action=saveOldEnrollmentCol" >
<p>

<input type="hidden" id="theForm" name="theForm" value="createEnrollment" />
<input type="hidden" id="curID" name="curID" value="{$curID}" />

<input type="hidden" id="yrLvl" name="yrLvl" value="" />
<input type="hidden" id="course" name="course" value="" />

<table border="0" width="100%">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="saveEnrollment();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Enrollments&action=listOldEnrollmentsCol')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Add Old Enrollment</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="15%" valign="top"><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" width="35%"><slot>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <td>{$SCHOOLYEAR}</td>
        <td class="dataLabel" valign="top"><slot>Semester <span class="required">*</span></slot></td>
        <td>{$SEMESTERS}</td>
        </tr>
        </table>        
        </slot></td>
        <td class="dataLabel" width="15%" valign="top"><!--<slot>Date <span class="required">*</span></slot>-->&nbsp;</td>
        <td class="dataField" width="35%">
        <slot> 
        &nbsp;
        <!--<input name="date" id="date" size="15" maxlength="10" value="{$date}" type="text" onkeypress="return keyRestrict(event, 8);" />
        <img src="themes/Sugar/images/jscalendar.gif" alt="Date Last Attended" id="jscal_trigger" align="absmiddle" /> -->
        </slot>
        </td>
    </tr>
    
    <tr>
        <td class="dataLabel" height="50" valign="bottom"><slot>ID No. <span class="required">*</span></slot> </td>
        <td class="dataField" colspan="3" valign="bottom"><slot>
        <input type="text" name="idno" id="idno" size="19" maxlength="15" onkeypress="return keyRestrict2(event, 14,'onCheckEnrollment');"/> </slot>  
        <input type="button" name="cmdLookup" id="cmdLookup" value="=" onclick="popUp('index.php?module=Enrollments&action=listStudents&sugar_body_only=1')" />
        </td>
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
        <td class="dataLabel" valign="bottom"><slot>Course <span class="required">*</span></slot> </td>
        <td class="dataField" valign="bottom" colspan="3">
        
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <td> 
        <slot>
        <input type="hidden" name="deptID" id="deptID" value="" />
        <select name="courseID" id="courseID" onchange="getSubjects();">
        <option value="">---------------------------</option>
        {section name=i loop=$courseList}
        <option value="{$courseList[i].courseID}" {if $courseList[i].courseID eq $courseID} selected {/if}>{$courseList[i].courseCode}</option>
        {/section}
        </select>
        </slot>
        </td>
        <td class="dataLabel">Year Level <span class="required">*</span></td>
        <td>
        <slot>
        <select name="yrLevel" id="yrLevel">
        <option value="">-------------</option>
        <option value="1" {if $yrLevel eq 1} selected {/if}>1</option>
        <option value="2" {if $yrLevel eq 2} selected {/if}>2</option>
        <option value="3" {if $yrLevel eq 3} selected {/if}>3</option>
        <option value="4" {if $yrLevel eq 4} selected {/if}>4</option>
        <option value="5" {if $yrLevel eq 5} selected {/if}>5</option>
        </select>
        </slot>
        </td>
        </tr>
        </table>  
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
    <tr>
		<th class="dataField" colspan="10" align="left"><h4 class="dataLabel"> Add Subject</h4></th>
    </tr>
    
    <tr>
        <td class="dataLabel" width="15%" valign="top">Subject </td>
		<td class="dataField" width="20%" valign="top">
		<slot>
		<select name="subjID" id="subjID">
        <option value="">--------------------------</option>
        {section name=i loop=$subjList}
        <option value="{$subjList[i].subjID}">{$subjList[i].subjCode}</option>
        {/section}
        </select>
		</slot>
		</td>
		<td class="dataLabel" width="15%" valign="top">Grade </td>
		<td class="dataField" width="20%" valign="top">
		<slot>
		<input type="text" name="fgrade" id="fgrade" size="5" maxlength="5" onkeypress="return keyRestrict(event, 16);"/>
		</slot>
		</td>
		<td class="dataField" width="30%" valign="top">
		<slot><input name="cmdAdd" id="cmdAdd" class="button" type="button" value="  Add  " onclick="onCheckDuplicate();" /></slot>
		</td>
	</tr>
</table>
</p>
</form>

<div id="divSchedules">
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	
	<tr height="20">
		<td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Course</td>
		<td scope="col" class="listViewThS1" width="50%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Units</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Grade</td>
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
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Enrollments&action=listOldEnrollmentsCol')" />
    </td>
  </tr>
</table>  
</p>



