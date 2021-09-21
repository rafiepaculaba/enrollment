<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap">
		&nbsp;
    		<div id="myDiv" name="myDiv" style="display:block">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<td nowrap="nowrap" align="right"><input type="button" class="button" value="Print Now" id="cmdPrint" name="cmdPrint" onclick="printNow();" />&nbsp;&nbsp;<input type="button" class="button" value="Close" id="cmdClose" name="cmdClose" onclick="javascript: window.close();" /></td>
            	</tr>
            </table>
            </div>
		</td>
	</tr>
</table>

<p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td colspan="4" align="center">
        <slot>
        <b><font size="2">{$schName}</font></b><br>{$schAddress}<br>{$schContact}
        </slot>
        </td>
    </tr>
    <tr><th  colspan="4" align="center"><br><b><font size="2">{$term} Examination Permit </font></b> <br><br></th></tr>
    <tr>
        <td colspan="4"><slot>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td><font size="2"><b>({$gender})&nbsp;{$idno}</b></font></td>
                    <td><font size="2"><b>{$lname} , {$fname} {$mname} </b></font></td>
                    <td><font size="2"><b>{$yrLevel} </b></font></td>
                    <td><font size="2">&nbsp;</td>
                </tr>
            </table>                
        </slot>
        </td>
    </tr>
</table>
<hr>
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="240">
    <tr>
        <td valign="top">
            <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr height="20">
            		<td scope="col" class="listViewThS1" nowrap><b>Instructor</b></td>
            		<td scope="col" class="listViewThS1" nowrap><b>Subject</b></td>
            		<td scope="col" class="listViewThS1" nowrap><b>Description</b></td>
            		<td scope="col" class="listViewThS1" nowrap><b>Time</b></td>
            		<td scope="col" class="listViewThS1" nowrap><b>Days</b></td>
            		<td scope="col" class="listViewThS1" nowrap><b>Room</b></td>
            		<td scope="col" class="listViewThS1" nowrap><b>Units</b></td>
            	</tr>
                {section name=i loop=$subjects}
                    <tr height="20">
                		<td><b>__________</b></td>
                		<td>{$subjects[i].subjCode}</td>
                		<td>{$subjects[i].descTitle}</td>
                		<td>{$subjects[i].time}</td>
                		<td>{$subjects[i].days}</td>
                		<td>{$subjects[i].room}</td>
                		<td>{$subjects[i].units}</td>
                		<td></td>
                	</tr>
            	{/section}
                <tr height="20">
            		<td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap >&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap >&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap >&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap >&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap >&nbsp;</td>
            	</tr>
                <tr height="20">
            		<td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap >&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap >&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap >&nbsp;</td>
            		<td scope="col" class="listViewThS1" nowrap ><b>Total units:</b></td>
            		<td scope="col" class="listViewThS1" nowrap ><b>{$total_units}</b></td>
            	</tr>
            </table>
        </td>
    </tr>
</table>
</br>
</br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>Examination Date:  {$exam_date}</td>
    </tr>
    <tr>
        <td>Please present this form to your instructor during exam. No permit, No exam.</td>
    </tr>
    <tr height="30">
        <td>{$smarty.now|date_format:"%D"} &nbsp; {$smarty.now|date_format:"%I:%M %p"} &nbsp;&nbsp;&nbsp;&nbsp; /{$secured} &nbsp;&nbsp;&nbsp;&nbsp; Release by ____________________________ </td>
    </tr>
</table>
</p>
