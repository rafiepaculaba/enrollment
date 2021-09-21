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
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>Miscellaneous Details</h2></td>
	</tr>
</tbody>
</table>
<?php  $current_user = $_SESSION['current_user']; 
//var_dump($current_user);
		foreach ($current_user as $row)	:
?>
<table width="100%" border="0" cellpadding="1" cellspacing="0">
<tr>
    <td>
       <div style="width: 100%; height:180px; overflow: auto;" id="divSectionList">
        <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        	<tr height="20">
        		<td scope="col" class="listViewThS1" width="70%" nowrap>Particular</td>
        		<td scope="col" class="listViewThS1" width="5%" nowrap>&nbsp;</td>
        		<td scope="col" class="listViewThS1" width="25%" nowrap><div align="center">Amount</div></td>
        	</tr>
        	<!-- Start of misc Listing -->
        	<?php 
        		$account = $this->User_model->retrieveAccounts($row->accID);
        		if($account){
        			$this->yr = $account[0]->schYear;
        		}
        		$this->db->where('schYear', $this->yr); 
	        	$this->db->where('courseID', $row->courseID); 
	        	$this->db->where('yrLevel', $row->yrLevel); 
        		$miscellaneous = $this->User_model->retrieveMiscellaneous();
        		if($miscellaneous){
        			foreach ($miscellaneous as $misc) {
        	?>
        	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
        		<td scope="row" 
                {if i%2 eq 0}
                    class="evenListRowS1" bgcolor="#fdfdfd" 
                {else}
                    class="oddListRowS1" bgcolor="#ffffff" 
                {/if}
                align="left" bgcolor="#fdfdfd" valign="top"><?php echo $misc->particular; ?></td>
        		
        		<td scope="row" 
                {if i%2 eq 0}
                    class="evenListRowS1" bgcolor="#fdfdfd" 
                {else}
                    class="oddListRowS1" bgcolor="#ffffff" 
                {/if}
                align="left" bgcolor="#fdfdfd" valign="top"><font style="text-decoration: line-through"><b>P</b></font></td>
        		
        		<td scope="row"
                {if i%2 eq 0}
                    class="evenListRowS1" bgcolor="#fdfdfd" 
                {else}
                    class="oddListRowS1" bgcolor="#ffffff" 
                {/if}
                align="right" bgcolor="#fdfdfd" valign="top"><?php echo $misc->amount; ?></td>
        	</tr>
        	<tr>
        		<td colspan="20" class="listViewHRS1" height="1"></td>
        	</tr>
        	<?php 
        			}
        		} 
        	?>
        	<!-- End of misc Listing -->
        </tbody>
        </table>
        
        </div>
    </td>
</tr>
</table>
<?php endforeach; ?>