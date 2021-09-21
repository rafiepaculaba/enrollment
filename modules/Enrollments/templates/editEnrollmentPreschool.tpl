<form name="frmEnrollment" id="frmEnrollment" method="post" action="index.php?module=Enrollments&action=saveEnrollmentPreschool" >
<p>

<input type="hidden" id="theForm" name="theForm" value="editEnrollment" />
<input type="hidden" id="enID" name="enID" value="{$enID}" />
<input type="hidden" id="curID" name="curID" value="{$curID}" />

<input type="hidden" id="yrLvl" name="yrLvl" value="" />
<input type="hidden" id="course" name="course" value="" />

<table border="0" width="100%">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="saveEnrollment();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Enrollments&action=viewEnrollmentPreschool&enID={$enID}')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit Enrollment</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" width="15%" valign="top"><slot>School Year  </slot></td>
        <td class="dataField" width="35%"><slot>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <td>{$SCHOOLYEAR}</td>
        <td class="dataLabel" valign="top">&nbsp;  </td>
        <td>&nbsp;</td>
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
        <td class="dataLabel" height="50" valign="bottom"><slot>ID No. </slot> </td>
        <td class="dataField" colspan="3" valign="bottom"><slot><input type="text" name="idno" id="idno" value="{$idno}" readonly size="25" maxlength="15" onkeypress="return keyRestrict2(event, 14,'onCheckEnrollment');"/> </slot>  </td>
    </tr>
    
    <tr>
        <td class="dataLabel"><slot>Student Name </slot> </td>
        <td class="dataField" colspan="3" valign="bottom">
        
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="30%"><slot><input type="text" name="lname" id="lname" size="25" value="{$lname}" maxlength="25" readonly onkeypress="return keyRestrict(event, 12);" /></slot>&nbsp;,</td>
                <td width="30%"><slot><input type="text" name="fname" id="fname" size="25" value="{$fname}" maxlength="25" readonly onkeypress="return keyRestrict(event, 12);" /></slot></td>
                <td width="40%"><slot><input type="text" name="mname" id="mname" size="25" value="{$mname}" maxlength="25" readonly onkeypress="return keyRestrict(event, 12);" /></slot></td>
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
        <td class="dataLabel" height="50" valign="bottom"><slot>Level  <span class="required">*</span></slot> </td>
        <td class="dataField" valign="bottom"><slot>{$YEARLEVEL}</slot></td>
        <td class="dataLabel" valign="bottom"><slot>Section </slot></td>
        <td class="dataField" valign="bottom">
        <slot>
        <input type="hidden" name="secID" id="secID" value="{$secID}"/> &nbsp;
        <input type="text" name="secName" id="secName" size="10" value="{$secName}" maxlength="25" readonly onkeypress="return keyRestrict(event, 0);"/> &nbsp;
        </slot>
        </td>
    </tr>
   
    </table>
</td></tr>
</table>
</p>


<!--<form name="frmAddSchedule" id="frmAddSchedule" method="post">-->
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
<!--</form>-->

<div id="divSchedules">
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Code</td>
		<td scope="col" class="listViewThS1" width="30%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="20%" nowrap>Time</td>
		<td scope="col" class="listViewThS1" width="15%" nowrap>Days</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Room</td>
<!--		<td scope="col" class="listViewThS1" width="10%" nowrap>Units</td>-->
	</tr>
	{section name=i loop=$list}
	<!-- Start of students Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><img src="themes/Sugar/images/delete_inline.gif" alt="Remove" onclick="removeSchedule('{$list[i].schedID}');" /></td>
	
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].schedCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"> {$list[i].time_display}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].days_display}</td>
		
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].room}</td>
		<!--
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].units}</td>-->
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of student Listing -->
	{/section}
	</tr>
	<!--
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top"><b>{$total_units|number_format:1:".":","}</b></td>
	</tr>-->
</tbody>
</table>
</div>


<p>
<hr>
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="saveEnrollment();" />
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="redirect('index.php?module=Enrollments&action=viewEnrollmentPreschool&enID={$enID}')" />
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
                		<td scope="col" class="listViewThS1" width="30%" nowrap>Year</td>
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

