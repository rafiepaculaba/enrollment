
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap">
    		<div id="myDiv" name="myDiv" style="display:block">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<td nowrap="nowrap" align="right"><input type="button" class="button" value="Print Now" id="cmdPrint" name="cmdPrint" onclick="printNow();" /> &nbsp;&nbsp;<input type="button" class="button" value="Close" id="cmdClose" name="cmdClose" onclick="javascript: window.close();" /> </td>
            	</tr>
            </table>
            </div>
		</td>
	</tr>
</table>

<p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
    <table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="tabDetailViewDL" colspan="6" align="center">
        <slot>
        {$schName}<br>{$schAddress}<br>{$schContact}
        </slot>
        </td>
    </tr>
    <tr><th  colspan="6" align="center"><br><b><u>High School Receivable Report</u></b> <br><br></th></tr>
    <tr>
        <td class="tabDetailViewDL" width="80"><slot>School Year: </slot></td>
        <td  class="tabDetailView" width="150"><slot> <u>{$SCHYEAR}</u> </slot></td>
        <td  class="tabDetailView" width="150"><slot> &nbsp;</slot></td>
        <td class="tabDetailViewDL" width="50"><slot>Term </slot></td>
        <td class="tabDetailViewDF" width="150" align="left"><slot>Term {$TERM}</slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

{$RESULT}
