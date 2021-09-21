<link href="themes/Sugar/style.css" rel="stylesheet" type="text/css" />
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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td	width="50%" align="left" valign="top">
    	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tr>
		        <td>
		        <b>{$schName}</b>
		        </td>
		        <td >
		        <b>OFFICIAL RECEIPT</b>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        {$schAddress}
		        </td>
		        <td>
		        TIN#: <b>{$TIN}</b>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        {$schContact}
		        </td>
		        <td>
		           OR#: <b>{$orno}</b>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            &nbsp;
		        </td>
		        <td>
		           Date/Time: <b>{$dateCreated|date_format}&nbsp; {$timeCreated|date_format:"%I:%M%p"}</b>
		        </td>
		    </tr>
		    <tr>
		        <td colspan="4">
		        &nbsp;
		        </td>
		    </tr>
		    <tr>
		        <td colspan="4"><slot>
		            <table border="0" cellpadding="0" cellspacing="0" width="100%">
		                <tr>
		                    <td align="center"><b>{$idno}</b></td>
		                    <td align="center"><b>{$lname} , {$fname} {$mname}</b></td>
		                    <td align="center"><b>{$yrLevel}</b></td>
		                    <td align="center">&nbsp;</td>
		                </tr>
		            </table>                
		        </slot>
		        </td>
		    </tr>
		    <tr>
		        <td colspan="4" width="50%" valign="top">
		            <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%" height="180">
		            	<tr height="20">
		            		<td scope="col" width="40%" class="listViewThS1" align="center" nowrap><b>Particular</b></td>
		            		<td scope="col" width="30%" class="listViewThS1" align="left" nowrap><div align="right"><b>Amount</b></div></td>
		            		<td scope="col" width="30%" class="listViewThS1" align="left">&nbsp;</td>
		            	</tr>
		                {section name=i loop=$ordetails}
		                <tr height="20">
		            		<td class="oddListRowS1">{$ordetails[i].particular}</td>
		            		<td align="right">{$ordetails[i].amount|number_format:2}</td>
		            		<td>&nbsp;</td>
		            	</tr>
		            	{/section}
		            	 <tr height="30">
		            		<td align="right"><b>TOTAL &nbsp;</b> </td>
		            		<td align="right"><b>{$totalAmount|number_format:2}</b>
		            		<td>&nbsp;</b>
		            		<input type="hidden" id="total_amount" name="total_amount" value="{$totalAmount}">
		            		</td>
		            	</tr>
		                <tr >
		            		<td>&nbsp;</td>
		            		<td>&nbsp;</td>
		            		<td>&nbsp;</td>
		            	</tr>
		            </table>
		        </td>
		    </tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="340" height="20%">
		<tr valign="top">
			<td colspan="4" > <fieldset><legend> Amount in Peso </legend>
			<b> <div id="container"></div> </b>
			</fieldset>
			</td>
<!--		    <td align="left" ></td>-->
		</tr>
		<tr>
			<td width="20%">Date Printed: </td>
		    <td width="50%">{$smarty.now|date_format:"%D"} - {$smarty.now|date_format:"%I:%M %p"}</td>
		    <td width="10">Teller:</td>
		    <td width="20" class="teller" ><b>{$cashierName}</b></td>
		</tr>
		</table>
    </td>
    <td width="50%" align="right" valign="top">
    	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tr>
		        <td>
		        <b>{$schName}</b>
		        </td>
		        <td >
		        <b>OFFICIAL RECEIPT</b>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        {$schAddress}
		        </td>
		        <td>
		        TIN#: <b>{$TIN}</b>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        {$schContact}
		        </td>
		        <td>
		           OR#: <b>{$orno}</b>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            &nbsp;
		        </td>
		        <td>
		           Date/Time: <b>{$dateCreated|date_format}&nbsp; {$timeCreated|date_format:"%I:%M%p"}</b>
		        </td>
		    </tr>
		    <tr>
		        <td colspan="4">
		        &nbsp;
		        </td>
		    </tr>
		    <tr>
		        <td colspan="4"><slot>
		            <table border="0" cellpadding="0" cellspacing="0" width="100%">
		                <tr>
		                    <td align="center"><b>{$idno}</b></td>
		                    <td align="center"><b>{$lname} , {$fname} {$mname}</b></td>
		                    <td align="center"><b>{$yrLevel}</b></td>
		                    <td align="center">&nbsp;</td>
		                </tr>
		            </table>                
		        </slot>
		        </td>
		    </tr>
		    <tr>
		        <td colspan="4" width="50%" valign="top">
		            <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%" height="180">
		            	<tr height="20">
		            		<td scope="col" width="40%" class="listViewThS1" align="center" nowrap><b>Particular</b></td>
		            		<td scope="col" width="30%" class="listViewThS1" align="left" nowrap ><div align="right"><b>Amount</b></div></td>
		            		<td scope="col" width="30%" class="listViewThS1" align="left">&nbsp;</td>
		            	</tr>
		                {section name=i loop=$ordetails}
		                <tr height="20">
		            		<td class="oddListRowS1">{$ordetails[i].particular}</td>
		            		<td align="right">{$ordetails[i].amount|number_format:2}</td>
		            		<td>&nbsp;</td>
		            	</tr>
		            	{/section}
		            	 <tr height="30">
		            		<td align="right"><b>TOTAL &nbsp;</b> </td>
		            		<td align="right"><b>{$totalAmount|number_format:2}</b>
		            		<td>&nbsp;</b>
		            		<input type="hidden" id="total_amount" name="total_amount" value="{$totalAmount}">
		            		</td>
		            	</tr>
		                <tr >
		            		<td>&nbsp;</td>
		            		<td>&nbsp;</td>
		            		<td>&nbsp;</td>
		            	</tr>
		            </table>
		        </td>
		    </tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" height="20%">
		<tr valign="top">
			<td colspan="4"> <fieldset><legend> Amount in Peso </legend>
			<b> <div id="container2"></div> </b>
			</fieldset>
			</td>
		</tr>
		<tr>
			<td width="20%">Date Printed: </td>
		    <td width="50%">{$smarty.now|date_format:"%D"} - {$smarty.now|date_format:"%I:%M %p"}</td>
		    <td width="10">Teller:</td>
		    <td width="20" class="teller" ><b>{$cashierName}</b></td>
		</tr>
		</table>
    </td>
  </tr>
</table>
