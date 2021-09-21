<form name="frmTeachersLoadHS" id="frmTeachersLoadHS" method="post" onSubmit="return check_form('frmTeachersLoadHS')">

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">High School Teacher's Load </h4></th>
    </tr>
    <tr>
        <td class="dataLabel" colspan="4"></td>
    </tr>
    <tr>
        <td class="dataLabel" ><slot>School Year <span class="required">*</span></slot></td>
        <td class="dataField" ><slot> {$SCHOOLYEAR}</slot></td>
        <td class="dataLabel" ><slot>Teacher <span class="required">*</span> </slot></td>
        <td class="dataField" > <slot>
			<select name="profID" id="profID"  >
            {if $isInstructorGroup eq 0}
				<option value="">----------------------------------------------------------</option>
			{/if}
		    	{section name=i loop=$user_list}
		    		<option value="{$user_list[i].id}" {if $user_list[i].id eq $profID}selected{/if}>{$user_list[i].last_name}, {$user_list[i].first_name}</option>
		    	{/section}
		    </select> </slot>
        </td>
        <td class="dataField" ><slot><input class="button" type="submit" name="cmdGo" id="cmdGo" value="Go"/></slot> </td>
        </td>
	</tr>
    </table>
</td></tr>
</table>
</p>
{$RESULT}

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
		<td colspan="20" height="20">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="listViewPaginationTdS1" align="left" nowrap="nowrap" width="30%">&nbsp;&nbsp;
					<div id="printer">
						<a href="#" onclick="popUp('index.php?module=Reports&action=printTeachersLoadHS&schYear={$schYear}&profID={$profID}&sugar_body_only=1');"" id="print_link"><img src="themes/Sugar/images/print.gif" alt="Export" align="absmiddle" border="0" height="9" width="11">&nbsp;Print</a>
					</div>
					</td>
				</tr>
			</tbody>
			</table>
	    </td>
	</tr>
</table>

</form>