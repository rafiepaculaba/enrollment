
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
<!--		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;College Account</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>-->
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
    {if $logo == 1}
    <tr>
        <td align="center" colspan="4"><img src="themes/Sugar/images/logo_temp.jpg" height="70" width="70"/></td>
    </tr>
    {/if}
    <tr>
        <td class="" colspan="4" align="center">
        <slot>
        <b>{$schName}</b><br>{$schAddress}<br>{$schContact}
        </slot>
        <br><br>
        </td>
    </tr>
     <tr><th  colspan="4" align="center"><br><b><u>College Grades</u></b> <br><br></th></tr>
    <tr>
        <td colspan="4"><slot>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>{$idno}</td>
                    <td>{$lname} , {$fname} {$mname}</td>
                    <td>{$courseCode}-{$yrLevel}</td>
                    <td>{$semester} {$schYear}</td>
                </tr>
            </table>                
        </slot></td>
    </tr>
    <tr>
        <td colspan="4">
            <hr>
            
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr>
                		<td scope="col" nowrap><b>Code</b></td>
                		<td scope="col" nowrap><b>Subject</b></td>
                		<td scope="col" nowrap><b>Title</b></td>
                		<td scope="col" nowrap><b>Units</b></td>
                		<td scope="col" nowrap><b>Prelim</b></td>
                		<td scope="col" nowrap><b>Midterm</b></td>
                		<td scope="col" nowrap><b>Pre-Final</b></td>
                		<td scope="col" nowrap><b>Final</b></td>
                	</tr>
                	<tr>
                		<td colspan="8"><hr/></td>
                	</tr>
                    {section name=i loop=$scheds}
                	<!-- Start of registrant Listing -->
                	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');">
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].schedCode}</td>
                		
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].subjCode}</td>
                		
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].descTitle}</td>
                		
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].units}</td>
                		
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].pregrade}</td>
                		                		
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].mgrade}</td>
                		
                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].prefigrade}</td>

                		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top">{$scheds[i].fgrade}</td>
                	</tr>
                	<!-- End of registrant Listing -->
                	{/section}
                	</tbody></table>

        </td>
    </tr>
</table>
</p>
<hr/>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="30%">Date: {$rundate} </td>
        <td align="right" width="40%"> Registrar: </td>
        <td align="right" width="30%"> <u> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        </u></td>
    </tr>
</table>    
