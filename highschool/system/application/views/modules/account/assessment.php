
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>ASSESSMENT</h2></td>
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
    <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" />
    <!--<input class="button" name="cmdprint" type="button" id="cmdprint" value="Print" onclick="popUpPrint('index.php?module=Account&action=printAccountCol&accID={$accID}&sugar_body_only=1');" />    -->
  </tr>
</table>
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <th class="tabDetailViewDL" colspan="4" align="center"><h4 class="tabDetailViewDL">Assessment</h4></th>
    <tr>
        <td class="tabDetailViewDL" width="15%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="35%"><slot>
        <?php 
        	$assessment = $this->User_model->retrieveAssessment($this->uri->segment(3));
        	if($assessment){
		   		echo $assessment[0]->schYear; 
        	}
		?>
        &nbsp;</slot></td>
        <td class="tabDetailViewDL" width="15%"><slot>Year :</slot></td>
        <td class="tabDetailViewDF" width="35%"><slot> <?php echo $row->yrLevel; ?>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->idno; ?>&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Term :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
        if ($assessment) {
		 	switch ($assessment[0]->term) {
			 	case 1:
			 		echo "1<sup>st</sup> Grading";
			 		break;
			 	case 2:
			 		echo "2<sup>nd</sup> Grading";
			 		break;
			 	case 3:
			 		echo "3<sup>rd</sup> Grading";
			 		break;
			 	case 4:
			 		echo "4<sup>th</sup> Grading";
			 		break;
			}
        }
	    ?>
        &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php echo $row->lname.', '.$row->fname.' '.$row->mname;?>
		
        &nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td colspan="4">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Old Account:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL" width="15%"><slot>Old Balance </slot></td>
                    <td class="tabDetailViewDF" align="right" width="35%"><slot><b>
                    <?php 
                    	if ($assessment) {
	                    	echo number_format($assessment[0]->oldBalance,2); 
                    	}
                    ?></b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
            
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Fees:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Tuition </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php 
                    if($assessment){
                    	echo number_format($assessment[0]->tuitionFee,2); 
                    }
                    ?>
                    </b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <!--<tr>
                    <td class="tabDetailViewDL"><slot>Laboratory </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php 
                    if ($assessment){
                    	echo number_format($assessment[0]->labFee,2); 
                    }
                    ?>
                    </b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>-->
                
                <tr>
                    <td class="tabDetailViewDL"><slot>Registration </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php 
                    if($assessment){
                    	echo number_format($assessment[0]->regFee,2); 
                    }
                    ?></b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr>
                    <td class="tabDetailViewDL"><slot>Miscellaneous </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php 
                    if ($assessment){
                    	echo number_format($assessment[0]->miscFee,2); 
                    }
                    ?></b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Adjustments:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Add </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php 
                    if($assessment){
                    	echo number_format($assessment[0]->addAdj,2); 
                    }
                    ?></b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr>
                    <td class="tabDetailViewDL"><slot>Less </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php 
                    if($assessment){
                    	echo number_format($assessment[0]->lessAdj,2); 
                    }
                    ?></b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Total Fees:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Total Fees </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php 
                    if($assessment){
                    	echo number_format($assessment[0]->totalFees,2); 
                    }
                    ?></b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Total Payments:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Total Payment </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php
                    if($assessment){
                    	echo number_format($assessment[0]->ttlPayment,2); 
                    }
                    ?></b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Balance:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Balance </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php 
                    if($assessment){
                    	echo number_format($assessment[0]->balance,2); 
                    }
                    ?></b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Due for 
                <?php
                	if ($assessment) {
			        	switch ($assessment[0]->term) {
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
                ?>:</h4></th></tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Amount Due </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php 
                    if($assessment){
                    	echo number_format($assessment[0]->ttlDue,2); 
                    }
                    ?></b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
                
                <tr><th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Total Payments:</h4></th>
                <tr>
                    <td class="tabDetailViewDL"><slot>Amount Paid </slot></td>
                    <td class="tabDetailViewDF" align="right"><slot><b>
                    <?php 
                    if($assessment){
                    	echo number_format($assessment[0]->amtPaid,2); 
                    }
                    ?></b></slot></td>
                    <td class="tabDetailViewDL">&nbsp;</td>
                </tr>
            </table>

        </td>
    </tr>
</table>

</p>
<?php endforeach; ?>

<script language="javascript" >
$('#cmdback').click(
    function() 
    {
    window.location='index.php?account/assessmentlist';
    }
    );
</script>