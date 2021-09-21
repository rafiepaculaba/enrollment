<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
<td nowrap="nowrap"><h3><img src="images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;Roles</h3></td><td width="100%"><img src="images/blank.gif" alt="" height="1" width="1"></td>
    </tr>
</table>

<table class="h3Row" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td> 
		    <input type="button" name="cmdDelete" id="cmdDelete" class="button" value=" Delete " />
		    <input type="button" name="cmdShowRole" id="cmdShowRole" class="button" value="Add Role" />
		</td>
	</tr>
</table>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
    
        <tr height="20">
        	<td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
        	<td scope="col" class="listViewThS1" nowrap>Role Name</td>
        	<td scope="col" class="listViewThS1" nowrap>Description</td>
        </tr>
        <tr>
        	<td colspan="20" height="1" class="listViewHRS1"></td>
        </tr>
        
        <?php foreach ($rolerecords as $row): ?>
        <tr onMouseOver="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onMouseOut="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onMouseDown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
        	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><span sugar="sugar0b"><input name="chkDelete[]" value="236" type="checkbox"> &nbsp;</td>
        	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><span sugar="sugar0b"><a href="#" class="listViewTdLinkS1"> <?php echo $row->roleName?></a></span> &nbsp;</td>
        	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><span sugar="sugar0b"><a href="#" class="listViewTdLinkS1"> <?php echo $row->description?></a></span> &nbsp;</td>
        </tr>
        <tr>
        	<td colspan="20" height="1" class="listViewHRS1"></td>
        </tr>
        <?php endforeach; ?>
        
        <tr>
        	<td colspan="20" height="20">
        	</td>
        </tr>
</table>
</form>

<!--popup:add of competitors brand here-->
<div style="width: 500px; height: 300px; visibility:hidden; display:none" id="windowcontent">
	<form name="frmAddRole" id="frmAddRole" method="POST" action="index.php?role/view/<?php echo ''; ?>"> 
    <input type="hidden" name="groupID" value="<?php echo ''; ?>" />
	<table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr>
	        <td>
	           <div style="width: 100%; height:230px; overflow: auto;">
	        	<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
                	<tr height="20">
                		<td scope="col" class="listViewThS1" width="15%" nowrap>&nbsp;</td>
                		<td scope="col" class="listViewThS1" width="35%" nowrap>Role Name</td>
                		<td scope="col" class="listViewThS1" width="50%" nowrap>Description</td>
                	</tr>
                	<?php foreach ($rolerecords as $row): ?>
                	<!-- Start of roles Listing -->
                	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
                		<td scope="row"
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top"><input type="checkbox" name="chkAdd[]" value="<?php echo $row->roleID ?>" /></td>
                		<td scope="row" 
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $row->roleName?></td>
                		<td scope="row" 
                        {if i%2 eq 0}
                            class="evenListRowS1" bgcolor="#fdfdfd" 
                        {else}
                            class="oddListRowS1" bgcolor="#ffffff" 
                        {/if}
                        align="left" valign="top"><?php echo $row->description?></td>
                	</tr>
                	<tr>
                		<td colspan="20" class="listViewHRS1"></td>
                	</tr>
                	<!-- End of roles Listing -->
                	<?php endforeach; ?>
                </tbody>
                </table>
                </div>
	        </td>
        </tr>
        <tr>
	        <td>
	        <hr>
	        <input class="button" type="submit" name="cmdAddRole" id="cmdOk" value="  OK  "/>
	        &nbsp;&nbsp;
	        <input class="button" type="button" name="cmdCancel" id="cmdCancel" value="Cancel" onclick="hiddenFloatingDiv('windowcontent');"/>
	     	</td>
        </tr>
        </table>
       </form>
</div>

<!--Javascripts-->
<script language="javascript">
    $('#cmdShowRole').click(
    function()
    {
        
//        displayWindow = window.open("","WDWindow")  
        displayWindow('windowcontent','Add Roles');
    }
    );
    

    function displayWindow(divId,title) {
        
    var w, h, l, t;
    w = 500;
    h = 300;
    l = screen.width/4;
    t = screen.height/4;
    
    if (navigator.appName=="Microsoft Internet Explorer") {
        l = 300 + document.body.scrollLeft;
        t = h + document.body.scrollTop;
    } else {
        l = 300 + document.body.scrollLeft;
        t = h + document.body.scrollTop;
    }
    
    // with title		        
    displayFloatingDiv(divId, title, w, h, l, t);
    }

</script>
	
