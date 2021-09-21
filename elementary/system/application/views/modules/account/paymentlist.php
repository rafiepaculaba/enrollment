<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>PAYMENTS</h2></td>
	</tr>
</tbody>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;List of Payments </h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<?php  $current_user = $_SESSION['current_user']; 
		foreach ($current_user as $row)	:
?>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap>School Year </td>
		<td scope="col" class="listViewThS1" nowrap>Term </td>
		<td scope="col" class="listViewThS1" nowrap>OR #</td>
		<td scope="col" class="listViewThS1" nowrap>ID No.</td>
		<td scope="col" class="listViewThS1" nowrap>Last Name</td>
		<td scope="col" class="listViewThS1" nowrap>First Name</td>
		<td scope="col" class="listViewThS1" nowrap>Middle Name</td>
		<td scope="col" class="listViewThS1" nowrap>Paid On</td>
		</tr>
	<tr>
		<td colspan="20" class="listViewHRS1" height="1"></td>
	</tr>
	<?php  
		$this->db->where('idno', $row->idno);
	 	$payments = $this->User_model->retrieveAllPayment();
	 	
	 	foreach ($payments as $value) {
	?>
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $value->schYear; ?></td>
	
        	<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?account/payment/<?php echo $value->orno;?>" class="listViewTdLinkS1">
        	<?php 
        	if ($value) {
	        	switch ($value->term) {
	        		case 0:
	        			echo "Registration";
	        			break;
	        		case 1:
	        			echo "Prelim";
	        			break;
	        		case 2:
	        			echo "Midterm";
	        			break;
	        		case 3:
	        			echo "PreFinal";
	        			break;
	        		case 4:
	        			echo "Final";
	        			break;	        	
		        	}
	        	}
	        ?>
        	</a></span></td>	
        
			<td scope="row" 
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?account/payment/<?php echo $value->orno;?>" class="listViewTdLinkS1"><?php echo $value->orno; ?></a></span></td>
						
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?account/payment/<?php echo $value->orno;?>" class="listViewTdLinkS1"><?php echo $row->idno; ?></a></span></td>
	
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?account/payment/<?php echo $value->orno;?>" class="listViewTdLinkS1"><?php echo $row->lname; ?></a></span></td>

			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?account/payment/<?php echo $value->orno;?>" class="listViewTdLinkS1"><?php echo $row->fname; ?></a></span></td>

			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?account/payment/<?php echo $value->orno;?>" class="listViewTdLinkS1"><?php echo $row->mname; ?></a></span></td>
						
			<td scope="row"
	        {if i%2 eq 0}
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        {else}
	            class="oddListRowS1" bgcolor="#ffffff" 
	        {/if}
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><?php echo date("m/d/Y" , strtotime($value->dateCreated)); ?></td>
			
		</tr>
		<tr>
			<td colspan="20" class="listViewHRS1" height="1"></td>
		</tr>
		<?php }?>
    	
	<tr>
		<td colspan="20" height="20"></td>
	</tr>
</tbody>
</table>
<?php endforeach; ?>
</p>