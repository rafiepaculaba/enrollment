
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>STATEMENT OF ACCOUNT</h2></td>
	</tr>
</tbody>
</table>
<!--<br>-->

<?php  $current_user = $_SESSION['current_user']; 
//var_dump($current_user);
		foreach ($current_user as $row)	:
?>
<!--<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdprint" type="button" id="cmdprint" value="Print" onclick="popUpPrint('index.php?module=Account&action=printAccountCol&accID={$accID}&sugar_body_only=1');" />    
  </tr>
</table>  -->
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <th class="tabDetailViewDL" colspan="4" align="center"><h4 class="tabDetailViewDL">Statement of Account</h4></th>
    <tr>
        <td class="tabDetailViewDL" width="15%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="35%"><slot>
         <?php  
         		$account = $this->User_model->retrieveAccounts($row->accID);
         		if($account) {
					echo $account[0]->schYear; 
         		}
		 ?>
        &nbsp;</slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>Year :</slot></td>
        <td class="tabDetailViewDF" width="35%"><slot><?php echo $row->yrLevel; ?>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->idno; ?>&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Account ID :</slot></td>
        <td class="tabDetailViewDF"><slot> <?php echo $row->accID; ?>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->lname; ?>&nbsp;&nbsp;, &nbsp;<?php echo $row->fname; ?>&nbsp;<?php echo $row->mname; ?></slot></td>
        <td class="tabDetailViewDL"><slot></slot></td>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
    </tr>
    <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Old Account:</h4></th>
    <tr>
        <td class="tabDetailViewDL" width="250"><slot>Old Balance <font style="text-decoration: line-through;"><b>P</b></font></slot></td>
        <td class="tabDetailViewDF" align="right" width="100"><slot><b>
        <?php  
        if($account) {
        	echo number_format($account[0]->oldBalance,2); 
        }
        ?>
        </b></slot></td>
        <td class="tabDetailViewDL">&nbsp;</td>
        <td class="tabDetailViewDL">&nbsp;</td>
    </tr>
      <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Fees:</h4></th>
    <tr>
        <td class="tabDetailViewDL" width="250"><slot>Tuition <font style="text-decoration: line-through;"><b>P</b></font></slot></td>
        <td class="tabDetailViewDF" align="right" width="100"><slot><b>

	       <?php  
        	if($account){
        		$this->accID 	= $account[0]->accID;
        		$this->idno 	= $account[0]->idno;
        		$this->yr 		= $account[0]->schYear;
        	}

        	//retrieve enrollment table
        	$enrollment = $this->User_model->retrieveEnrollment($row->idno);
        	if($enrollment){
	        	$this->nonComSubj = $enrollment[0]->ttlUnits - $this->compSubj;
        	}
        	    	
        	//retrieve school fees
        	$this->db->where('schYear', $this->yr); 
        	$this->db->where('yrLevel', $row->yrLevel); 
        	$this->db->where('item', "Tuition"); 
	        $sch_fee = $this->User_model->retrieveSchool_fees();

	        //retrieve account details   
        	$this->db->where('accID', $this->accID);
			$this->db->where('particular', "Tuition");
	        $account_detail = $this->User_model->retrieveAccountDetail();
	        
	        if($account_detail){
	        	$this->tuition = $this->nonComSubj * $sch_fee[0]->amount;
        		echo number_format($this->tuition,2); 
	        }
        ?>

        </b></slot></td>
        <?php
        	
        ?>
        <td class="tabDetailViewDL" colspan="2">
        <div align="center">

        Total Units: 
        <?php 
//        	if($isCompSubj){
	        	echo number_format($this->nonComSubj,1); 
//        	}
	    ?> @ 
	        <font style="text-decoration: line-through;"><b>P</b></font>
        <?php 
	        if($sch_fee){
	        		echo number_format($sch_fee[0]->amount,2); 
		    }
	    ?> per unit
        </div>
        </td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="250"><slot>Registration <font style="text-decoration: line-through;"><b>P</b></font></slot></td>
        <td class="tabDetailViewDF" align="right" width="100"><slot><b>
        <?php  
        if ($account) {
        	$this->db->where('accID', $account[0]->accID);
			$this->db->where('particular', "Registration");
	        $account_detail = $this->User_model->retrieveAccountDetail();
	        if($account_detail){
        		echo number_format($account_detail[0]->amount,2); 
	        }
        }
        ?>
        </b></slot></td>
        <td class="tabDetailViewDL">&nbsp;</td>
        <td class="tabDetailViewDL">&nbsp;</td>
    </tr>
     <tr>
        <td class="tabDetailViewDL" width="250"><slot>Miscellaneous <font style="text-decoration: line-through;"><b>P</b></font></slot></td>
        <td class="tabDetailViewDF" align="right" width="100"><slot><b>
        <?php  
        if ($account) {
        	$this->db->where('accID', $account[0]->accID);
			$this->db->where('particular', "Miscellaneous");
	        $account_detail = $this->User_model->retrieveAccountDetail();
	        if($account_detail){
        		echo number_format($account_detail[0]->amount,2); 
	        }
        }
        ?>
        </b></slot></td>
        <td class="tabDetailViewDL" colspan="2">
        <div align="center">
			<input type="button" id="displayMisc" name="displayMisc" onclick="displayWindow('windowcontent','Miscellaneous Details')" value="Miscellaneous Details" />
    	</div>
    	<script language="javascript">
		    $('#displayMisc').click(
			    function() 
			    {
			        window.open('index.php?account/misc','Popup','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width=350,height=250,left=0,top=0');
			    }
		    );
		</script>
        </td>
    </tr>
  
	<tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Additional Fees:  </h4></th></tr>
	    <?php  
		 	$accountD_add = $this->User_model->retrieveAccountDetail_Add($row->accID);
		 	
		 	foreach ($accountD_add as $add) {
		?>
	    <tr>
	        <td class="tabDetailViewDL"><slot><?php  echo $add->particular; ?> <font style="text-decoration: line-through;"><b>P</b></font></slot></td>
	        <td class="tabDetailViewDF" align="right"><slot><b><?php  echo number_format($add->amount,2); ?></b></slot></td>
	        <td class="tabDetailViewDL">&nbsp;</td>
	        <td class="tabDetailViewDL">&nbsp;</td>
	    </tr>
	    <?php }?>
	<tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Less Adjustments:  </h4></th></tr>
	    <?php  
		 	$accountD_less = $this->User_model->retrieveAccountDetail_Less($row->accID);
		 	
		 	foreach ($accountD_less as $less) {
		?>
		<tr>
	        <td class="tabDetailViewDL"><slot> <?php  echo $less->particular; ?> <font style="text-decoration: line-through;"><b>P</b></font></slot></td>
	        <td class="tabDetailViewDF" align="right"><slot><b><?php  echo number_format($less->amount,2); ?> </b></slot></td>
	        <td class="tabDetailViewDL">&nbsp;</td>
	        <td class="tabDetailViewDL">&nbsp;</td>
	    </tr>
	    <?php }?>
	<tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Total Fees:</h4></th></tr>
	<tr>
	    <td class="tabDetailViewDL" width="250"><slot>Total Fees <font style="text-decoration: line-through;"><b>P</b></font></slot></td>
	    <td class="tabDetailViewDF" align="right" width="100"><slot><b><?php  
	    if($account) {
	    		echo number_format($account[0]->totalFee,2); 
	    }		
	    ?></b></slot></td>
	    <td class="tabDetailViewDL">&nbsp;</td>
	    <td class="tabDetailViewDL">&nbsp;</td>
	</tr>
	<tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Total Payments:</h4></th></tr>
	<tr>
	    <td class="tabDetailViewDL"><slot>Total Payment <font style="text-decoration: line-through;"><b>P</b></font></slot></td>
	    <td class="tabDetailViewDF" align="right"><slot><b><?php
	    if($account) {
	    	echo number_format($account[0]->payment,2); 
	    }
	    ?></b></slot></td>
	    <td class="tabDetailViewDL">&nbsp;</td>
	    <td class="tabDetailViewDL">&nbsp;</td>
	</tr>
	<tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Balance:</h4></th></tr>
	<tr>
	    <td class="tabDetailViewDL"><slot>Balance <font style="text-decoration: line-through;"><b>P</b></font></slot></td>
	    <td class="tabDetailViewDF" align="right"><slot><b><?php  
	    if($account) {
	    	echo number_format($account[0]->balance,2); 
	    }
	    ?></b></slot></td>
	    <td class="tabDetailViewDL">&nbsp;</td>
	    <td class="tabDetailViewDL">&nbsp;</td>
	</tr>
           
</table>
<?php endforeach; ?>
</p>