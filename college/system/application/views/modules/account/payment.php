
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>STATEMENT OF ACCOUNT</h2></td>
	</tr>
</tbody>
</table>
<br>

<?php  $current_user = $_SESSION['current_user']; 
		foreach ($current_user as $row)	:
?>
<table width="100%" border="0">
  <tr>
    <td>
   <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List"/>
</table>  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<th class="tabDetailViewDL" colspan="4" align="center"><h4 class="tabDetailViewDL">Payment</h4></th>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>OR No. :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>
        <?php 
        	
        	$paymentlist = $this->User_model->retrievePaymentList($this->uri->segment(3));
        	if($paymentlist){
		   		$this->orno = $paymentlist[0]->orno; 
		   		echo $this->orno;
        	}
        	$payment = $this->User_model->retrievePayment($this->orno,$row->idno);
		?></slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot><?php echo $row->idno; ?> &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->lname.', '.$row->fname.' '.$row->mname; ?>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
        	if ($payment) {
	        	echo $payment[0]->schYear; 
        	}
        ?>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Semester :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php     
        	if ($payment) {
	        	switch ($payment[0]->semCode) {
	        		case 1:
	        			echo "1<sup>st</sup>";
	        			break;
	        		case 2:
	        			echo "2<sup>nd</sup>";
	        			break;
	        		case 4:
	        			echo "Summer";
	        			break;
	        	}
        	}
        ?>
		
        &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Term :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
        	if ($payment) {
	        	switch ($payment[0]->term) {
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
        &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Date :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
        	if ($payment) {
        		echo date("m/d/Y " , strtotime($payment[0]->dateCreated)); 
        	}
        ?>
        &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Amount :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
        	if ($payment) {
        		echo number_format($payment[0]->totalAmount,2); 
        	}		
        ?>&nbsp;</slot></td>
    </tr>
</table>
</p>

<?php endforeach; ?>

<script language="javascript" >
$('#cmdback').click(
    function() 
    {
    window.location='index.php?account/paymentlist';
    }
    );
</script>