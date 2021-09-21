<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
    	<td nowrap="nowrap"><h3><img src="images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;Role</h3></td><td width="100%"><img src="images/blank.gif" alt="" height="1" width="1"></td>
    </tr>
</table>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link title="color:sugar" type="text/css" rel="stylesheet" href="css/colors.sugar.css?s=4.5.1g&c=" />
<link title="color:blue" type="text/css" rel="alternate stylesheet" href="css/colors.blue.css?s=4.5.1g&c="/>
<link title="color:green" type="text/css" rel="alternate stylesheet" href="css/colors.green.css?s=4.5.1g&c="/>
<link title="color:purple" type="text/css" rel="alternate stylesheet" href="css/colors.purple.css?s=4.5.1g&c="/>
<link title="color:ocher" type="text/css" rel="alternate stylesheet" href="css/colors.ocher.css?s=4.5.1g&c="/>
<link type="text/css" rel="stylesheet" href="css/fonts.normal.css" />
<link type="text/css" rel="stylesheet" href="css/message.css" />
<script src="javascript/menu.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/validate.js" type="text/javascript"></script>
<script src="javascript/cpd.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/style.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/cookie.js" type="text/javascript"></script>
<script src="javascript/jquery-1.2.6.js" type="text/javascript"></script>
<script src="javascript/validate.js" type="text/javascript"></script>

<form id="cmdAddRole" name="cmdAddRole" method="POST" action="index.php?user/displayRole">
<input type="hidden" name="userID" id="userID" value="<?php echo $userID; ?>" />
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr height="20">
    	<td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
    	<td scope="col" class="listViewThS1" nowrap>Role Name</td>
    	<td scope="col" class="listViewThS1" nowrap>Description</td>
    </tr>
    <tr>
    	<td colspan="20" height="1" class="listViewHRS1"></td>
    </tr>
    
    <?php foreach ($record as $row): ?>
    <tr onMouseOver="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onMouseOut="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onMouseDown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
    	<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        { else }
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" >
    	<input type="checkbox" name="chkRole[]" value="<?php echo $row->roleID ?>" /></td>
    	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><span sugar="sugar0b"><class="listViewTdLinkS1"> <?php echo $row->roleName?></a></span> &nbsp;</td>
    	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><span sugar="sugar0b"><class="listViewTdLinkS1"> <?php echo $row->description?></a></span> &nbsp;</td>
    </tr>
    <tr>
    	<td colspan="20" height="1" class="listViewHRS1"></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td>
            <input class="button" type="submit" name="cmdAddRole" id="cmdOk" value="  OK  "/>&nbsp;&nbsp;
            <input class="button" type="button" name="cmdClose" id="cmdClose" value="Cancel"/>
        </td>
    </tr>
</table>

</form>
<!--Javascripts-->
	
<script language="javascript">

 $('#cmdClose').click(
     function() 
    {
        window.close();
    }
    );

</script>
	
