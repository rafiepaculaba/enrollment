
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
    {if $logo == 1}
    <tr>
        <td align="center" colspan="6"><img src="themes/Sugar/images/logo_temp.jpg" height="70" width="70"/></td>
    </tr>
    {/if}
    <tr>
        <td class="tabDetailViewDL" colspan="6" align="center">
        <slot>
        	<b>{$schName}</b><br>{$schAddress}<br>{$schContact}
        </slot>
        </td>
    </tr>
    <tr><th  colspan="6" align="center"><br><b><u>College Instructor's Load</u></b> <br><br></th></tr>
    <tr>
        <td class="tabDetailViewDL" width="70"><slot>Instructor : </slot></td>
        <td  class="tabDetailView" width="200"><slot> <u>{$NAME}</u> </slot></td>
        <td class="tabDetailViewDL" width="100"><slot></slot></td>
        <td class="tabDetailViewDF" width="150" align="left"><slot></slot></td>
        <td class="tabDetailViewDL" width="100"><slot></slot></td>
        <td class="tabDetailViewDF" width="150" align="left"><slot>{$SEMCODE} {$schYear}</slot></td>
    </tr>
    </table>
</td></tr>
</table>
</p>

{$RESULT}
