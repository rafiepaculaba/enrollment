<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>View group</h2></td>
	</tr>
</tbody>
</table>

<table  border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
    	<td>
    		 <input class="button" name="cmdBacktoList" type="button" id="cmdBacktoList" value="Back To List"/>
    		 <input class="button" name="cmdEdit" type="submit" id="cmdEdit" value="Edit" />
             <input class="button" name="cmdDelete" type="button" id="cmdDelete" value="Delete"/>
        </td>
    </tr>
</table>
</p>

<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="4" align="left" class="tabDetailViewDL"><h4 class="tabDetailViewDL">User Group</h4></th>
	</tr>
	<tr>
		<td class="tabDetailViewDL" align="right" ><slot>Group Name : </slot></td>
      	<td class="tabDetailViewDF" width="82%"><slot><?php echo $groupName; ?> &nbsp;</slot></td>
	</tr>		
	<tr>
		<td class="tabDetailViewDL" align="right" ><slot>Description : </slot></td>
		<td class="tabDetailViewDF" width="82%"><slot><?php echo $description; ?> &nbsp;</slot></td>
	</tr>
</table>

<form name="frmDeleteRole" id="frmDeleteRole" method="POST" action="index.php?user_group/deleteRole" >
<input type="hidden" name="groupID" id="groupID" value="<?php echo $groupID; ?>" >
    <table class="h3Row" border="0" cellpadding="0" cellspacing="0" width="100%">
    
    	<tr>
    		<td> 
                <input class="button" name="cmdDeleteRole" type="submit" id="cmdDeleteRole" value="Delete Role"/>       
        		<input class="button" name="cmdAddRole" type="button" id="cmdAddRole" value="Add Role"/>
    		</td>
    	</tr>
    </table>
    
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    
        <tr>
            <tr height="20">
            	<td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
            	<td scope="col" class="listViewThS1" nowrap>Role Name</td>
            	<td scope="col" class="listViewThS1" nowrap>Description</td>
            	<td scope="col" class="listViewThS1" nowrap>Apply</td>		
            </tr>
            
            <tr>
            	<td colspan="20" height="1" class="listViewHRS1"></td>
            </tr>
            
            <?php 
            if ($records) {
                foreach ($records as $row) { 
            ?>
                    <tr onMouseOver="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onMouseOut="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onMouseDown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '') ;" height="20">
                	<td scope="row"
                    {if i%2 eq 0}
                        class="evenListRowS1" bgcolor="#fdfdfd" 
                    { else 
                        class="oddListRowS1" bgcolor="#ffffff"
                    align="left" bgcolor="#fdfdfd" valign="top" >
                	<input type="checkbox" name="chkRole[]" value="<?php echo $row->roleID; ?>" /></td>
                	
                	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><span sugar="sugar0b"><?php echo $row->roleName?></a></span> &nbsp;</td>
                	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><span sugar="sugar0b"><?php echo $row->description?></a></span> &nbsp;</td>
                	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap > &nbsp;</td>
                    </tr>
                    
                    <tr>
                    	<td colspan="20" height="1" class="listViewHRS1"></td>
                    </tr>
            <?php 
                }
             } 
             ?>
    </table>

</form>



<!--Javascripts-->
	
<script language="javascript">
    $('#cmdDelete').click(
    function() 
    {
        reply=confirm("Do you really want to delete this group?");
        
        if (reply==true)
            window.location='index.php?user_group/delete/<?php echo $groupID; ?>';
    }
    );

	$('#cmdBacktoList').click(
    function()
    {
        window.location='index.php?user_group/listview';
    }
    );
    
    $('#cmdAddRole').click(
     function() 
    {
        window.open('index.php?role/viewPopup/<?php echo $groupID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=450,height=250,left=0,top=0');
    }
    );
    
    $('#cmdEdit').click(
     function() 
    {
        window.location='index.php?user_group/edit/<?php echo $groupID; ?>';
    }
    );

    

</script>