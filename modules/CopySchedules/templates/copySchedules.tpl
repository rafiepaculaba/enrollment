<form name="frmCopyScheduleCol" id="frmCopyScheduleCol" method="post" action="index.php?module=CopySchedules&action=copyAllSchedulesCol" onsubmit="return check_form('frmCopyScheduleCol')">
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="submit" id="cmdSave" value=" Copy Schedules "/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=CopySchedules&action=copySchedules')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td>
	    <table border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tr>
		        <th class="dataField" colspan="4" align="left"><h4 class="dataLabel">Copy College Schedule</h4></th>
		    </tr>
		    <tr>
		    <td class="dataField" colspan="4"> &nbsp;</td>
		    </tr>
			<tr>
		        <td class="dataLabel" width="18%" ><slot>Course <span class="required">*</span></slot></td>
		        <td class="dataField" width="32%" >
		        <slot>
		        <select name="courseID" id="courseID"" >
		        <option value="">------------------------------</option>    
		        {section name=i loop=$course_list}
		        <option value="{$course_list[i].courseID}">{$course_list[i].courseCode}</option>
		        {/section}
		        </select>
		        </slot>
		        </td>
		        <td class="dataLabel" width="18%"><slot>Year Level <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%"><slot>{$YEARLEVEL}</slot>
		        </td>
		   	</tr>
		    <tr>
		    <td class="dataField" colspan="4"> &nbsp;</td>
		    </tr>
			<tr>
    			<td class="tabDetailViewDL" colspan="2">
        			<fieldset><legend> From  </legend>
            			<table border="0" cellpadding="0" cellspacing="0" width="400">
                			<tr>
                		        <td class="dataLabel" ><slot>Semester <span class="required">*</span></slot></td>
                		        <td class="dataField" ><slot>{$FROMSEMESTERS}</slot>
                		        <td class="dataLabel" ><slot> S.Y <span class="required">*</span></slot></td>
                		        <td class="dataField" >
                		        <slot>
                			        {$FROMSCHOOLYEAR}
                		        </slot>
                		        </td>
                		    </tr>
                		 </table>
            	     </fieldset>
            	  </td>
            	  <td class="tabDetailViewDL" colspan="2">
        			<fieldset><legend> To  </legend>
            			<table border="0" cellpadding="0" cellspacing="0" width="400">
                			<tr>
                		        <td class="dataLabel" ><slot>Semester <span class="required">*</span></slot></td>
                		        <td class="dataField" ><slot>{$TOSEMESTERS}</slot>
                		        <td class="dataLabel" ><slot> S.Y <span class="required">*</span></slot></td>
                		        <td class="dataField" >
                		        <slot>
                			        {$TOSCHOOLYEAR}
                		        </slot>
                		        </td>
                		    </tr>
                		 </table>
            	     </fieldset>
    		   	</td>
		   	</tr>
	    </table>
	</td></tr>
</table>
</p>
</form>