<form name="frmGenerateEnrollmentStatusCol" id="frmGenerateEnrollmentStatusCol" method="post" onSubmit="return check_form('frmGenerateEnrollmentStatusCol')">

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Generate College Enrollment Status</h4></th>
    </tr>
    <tr>
        <td class="dataLabel" colspan="4"></td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" ><slot> {$SCHOOLYEAR}</slot></td>
        <td class="dataLabel" ><slot>Semester <span class="required">*</span></slot></td>
        <td class="dataField" ><slot> {$SEMESTERS}
        </slot></td>
        <td class="dataLabel" ><slot>Status </slot></td>
		<td class="dataField" >
			<select name="rstatus" id="rstatus">
	        <option value="">--------------------</option>
	        <option value="1" {if $rstatus eq "1"} selected {/if}>Pending </option>
	        <option value="2" {if $rstatus eq "2"} selected {/if}>Validated </option>
	        <option value="0" {if $rstatus eq "0"} selected {/if}>Withdrawn </option>
	        </select> 
        <td class="dataField" ><slot><input class="button" type="submit" name="cmdGo" id="cmdGo" value="Go"/></slot></td>
        </td>
	</tr>
    </table>
</td></tr>
</table>
</p>
<div id="enrollments" name="students">
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	{if $cmdGo eq 1}
		<tr height="20">
			<td scope="col" class="listViewThS1" nowrap>Department </td>
			<td scope="col" class="listViewThS1" nowrap>Course </td>
			<td scope="col" class="listViewThS1" nowrap>1 </td>
			<td scope="col" class="listViewThS1" nowrap>2 </td>
			<td scope="col" class="listViewThS1" nowrap>3 </td>
			<td scope="col" class="listViewThS1" nowrap>4 </td>
			<td scope="col" class="listViewThS1" nowrap>5 </td>
			<td scope="col" class="listViewThS1" nowrap>Total </td>
		</tr>
		
		{section name=i loop=$list}
		<!-- Start of registrant Listing -->
			<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
				
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].deptCode}&nbsp;</td>
				
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].courseCode}&nbsp;</td>
				
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].1}&nbsp;</td>
				
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].2}&nbsp;</td>
		
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].3}&nbsp;</td>
		
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].4}&nbsp;</td>
				
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top">{$list[i].5}&nbsp;</td>
				
				<td scope="row"
		        {if i%2 eq 0}
		            class="evenListRowS1" bgcolor="#fdfdfd" 
		        {else}
		            class="oddListRowS1" bgcolor="#ffffff" 
		        {/if}
		        align="left" bgcolor="#fdfdfd" valign="top"><b>{$list[i].total}</b>&nbsp;</td>
				
			</tr>
			<tr>
				<td colspan="20" class="listViewHRS1"></td>
			</tr>
		<!-- End of registrant Listing -->
		{/section}
		<tr>
			<td colspan="20" class="listViewHRS1"></td>
		</tr>
		
		<tr height="20">
		    <td scope="col" class="evenListRowS1" nowrap align="right">&nbsp;</td>
		    <td scope="col" class="evenListRowS1" nowrap align="left"><b>Grand Total: </b></td>
			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.1}</b></td>
			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.2}</b></td>
			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.3}</b></td>
			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.4}</b></td>
			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.5}</b></td>
			<td scope="col" class="evenListRowS1" nowrap><b>{$grand.total}</b></td>
		</tr>
	{/if}
</tbody>
</table>
</div>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
		<td colspan="20" height="20">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="listViewPaginationTdS1" align="left" nowrap="nowrap" width="30%">&nbsp;&nbsp;
					<div id="printer">
					<a href="#" onclick="popUp('index.php?module=Reports&action=printEnrollmentStatusCol&schYear={$schYear}&semCode={$semCode}&rstatus={$rstatus}&sugar_body_only=1');"" id="print_link"><img src="themes/Sugar/images/print.gif" alt="Export" align="absmiddle" border="0" height="9" width="11">&nbsp;Print</a>
					</div>
					</td>
				</tr>
			</tbody>
			</table>
	    </td>
	</tr>
</table>

</form>