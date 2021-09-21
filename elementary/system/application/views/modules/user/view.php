<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>User </h2></td>
	</tr>
</tbody>
</table>


<!--<form name="frmViewUser" id="frmViewUser" method="POST" action="index.php?user/edit/<?php echo $userID;?>" >-->
<input type="hidden" name="userID" value="<?php echo $userID; ?>">
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td>
		 <input class="button" name="cmdBacktoList" type="button" id="cmdBacktoList" value="Back To List" />
		 <input class="button" name="cmdEdit" type="button" id="cmdEdit" value="Edit" />
         <input class="button" name="cmdDelete" type="button" id="cmdDelete" value="Delete"/>
    </td>
</tr>
</table>
<br>

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="2" align="left" class="tabDetailViewDL"><h4 class="tabDetailViewDL">View User</h4></th>
	</tr>
	<tr>
		<td class="tabDetailViewDL" width="18%" align="right"><slot>User name : </slot></td>
      	<td class="tabDetailViewDF" width="82%"><slot><?php echo $userName; ?> &nbsp;</slot></td>
    </tr>
	<tr>
		<td class="tabDetailViewDL" align="right" ><slot>User group : </slot></td>
      	<td class="tabDetailViewDF" ><?php echo $groupName; ?>&nbsp;</td>
	</tr>
</table>
</p>

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr >
		<th colspan="4" align="left" class="tabDetailViewDL"><h4 class="tabDetailViewDL">Personal Info</h4></th>
	</tr>
	<tr>
        <td class="tabDetailViewDL" width="18%"><slot>Complete Name : </slot></td>
        <td class="tabDetailViewDF" width="82%"colspan="3">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%"><slot><?php echo $lastName; ?></slot>&nbsp;,</td>
                <td width="30%"><slot><?php echo $firstName; ?></slot></td>
                <td width="40%"><slot><?php echo $middleName; ?></slot></td>
            </tr>
            </tbody></table>
        </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" colspan="3" valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%">Last Name</td>
                <td width="30%">First Name</td>
                <td width="40%">Middle Name</td>
            </tr>
            </tbody></table>
        </td>
    </tr>
	<tr>
        <td class="tabDetailViewDL" width="18%"><slot>Contact : </slot></td>
        <td class="tabDetailViewDF" width="82%"colspan="3">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%"><slot><?php echo $localNum; ?>&nbsp;</slot></td>
                <td width="30%"><slot><?php echo $telNum; ?> &nbsp;</slot></td>
                <td width="40%"><slot>&nbsp;</slot></td>
            </tr>
            </tbody></table>
        </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" colspan="3" valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td width="30%">Local</td>
                <td width="30%">Tel No.</td>
                <td width="40%">&nbsp;</td>
            </tr>
            
            </tbody>
            </table>
        </td>
    </tr>
</table>
</p>

<!--listview of Roles begin here-->
<form name="frmDeleteRole" id="frmDeleteRole" method="POST" action="index.php?user/deleteRole" >
<input type="hidden" name="userID" id="userID" value="<?php echo $userID; ?>" >
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
            </tr>
            
            <tr>
            	<td colspan="20" height="1" class="listViewHRS1"></td>
            </tr>
            
            <?php 
            if ($records) {
                foreach ($records as $row):  
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
                    </tr>
                    
                    <tr>
                    	<td colspan="20" height="1" class="listViewHRS1"></td>
                    </tr>
            <?php 
                endforeach;
             } 
             ?>
    </table>

</form>
</form>

<script language="javascript">
$('#cmdDelete').click(
    function()
    {
    deleteUser();
    }
    );

    function deleteUser()
    {
        reply=confirm("Do you really want to delete this User?");
        
        if (reply==true)
            window.location='index.php?user/delete/<?php echo $userID; ?>'
    }

$('#cmdBacktoList').click(
    function()
    {
    window.location='index.php?user/listview';
    }
    );
    
$('#cmdAddRole').click(
     function() 
    {
        window.open('index.php?user/viewPopup/<?php echo $userID;?>','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=450,height=250,left=0,top=0');
    }
    );
    
    
$('#cmdEdit').click(
     function() 
    {
        window.location='index.php?user/edit/<?php echo $userID; ?>';
    }
    );

</script>
