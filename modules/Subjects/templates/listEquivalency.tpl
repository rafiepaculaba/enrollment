<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap" colspan="2"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;Equivalence</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<form name="frmDeleteEquivalence" id="frmDeleteEquivalence" method="POST" action="index.php?module=Subjects&action=viewSubject&subjID={$subjID}"> 
<input type="hidden" name="subjID" value="{$subjID}" />
<p>
<table border="0" class="h3Row" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap">
		<input type="submit" name="cmdDeleteSubject" class="button" value="Delete" />&nbsp;
		<input type="button" name="cmdShowSubjects" class="button" value="Add Equivalence" onclick="displayWindow('windowcontent','Add Equivalence')" />
		</td>
	</tr>
</table>
</p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="15%" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" width="35%" nowrap>Subject Code</td>
		<td scope="col" class="listViewThS1" width="50%" nowrap>Descriptive Title</td>
	</tr>
	{section name=i loop=$theEquivalence}
	<!-- Start of UserGroup Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top"><input type="checkbox" name="chkDelete[]" value="{$theEquivalence[i].eqID}" /></td>
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top">{$theEquivalence[i].subjCode}</td>
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" valign="top">{$theEquivalence[i].descTitle}</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of UserGroup Listing -->
	{/section}
</tbody>
</table>
</form>

<!--popup:add of competitors brand here-->
<div style="width: 500px; height: 300px; visibility:hidden; display:none" id="windowcontent">
	<form name="frmAddEquivalence" id="frmAddEquivalence" method="POST" action="index.php?module=Subjects&action=viewSubject&subjID={$subjID}"> 
	<input type="hidden" name="subjID" value="{$subjID}" />
	<table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr>
	        <td>
	           <div style="width: 100%; height:230px; overflow: auto;">
	        	<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
                	<tr height="20">
                		<td scope="col" class="listViewThS1" width="15%" nowrap>&nbsp;</td>
                		<td scope="col" class="listViewThS1" width="35%" nowrap>Subject Code</td>
                		<td scope="col" class="listViewThS1" width="50%" nowrap>Descriptive Title</td>
                	</tr>
                	{section name=r loop=$allSubjects}
                	<!-- Start of roles Listing -->
                	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
                		<td scope="row"
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top"><input type="checkbox" name="chkAdd[]" value="{$allSubjects[r].subjID}" /></td>
                		<td scope="row" 
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top">{$allSubjects[r].subjCode}</td>
                		<td scope="row" 
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" valign="top">{$allSubjects[r].descTitle}</td>
                	</tr>
                	<tr>
                		<td colspan="20" class="listViewHRS1"></td>
                	</tr>
                	<!-- End of roles Listing -->
                	{/section}
                </tbody>
                </table>
                </div>
	        </td>
        </tr>
        <tr>
	        <td>
	        <hr>
	        <input class="button" type="submit" name="cmdAddEquivalence" id="cmdOk" value="  OK  "/>
	        &nbsp;&nbsp;
	        <input class="button" type="button" name="cmdCancel" id="cmdCancel" value="Cancel" onclick="hiddenFloatingDiv('windowcontent');"/>
	     	</td>
        </tr>
        </table>
       </form>
</div>
<!--end of popup adding competitors brand-->

