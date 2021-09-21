
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>Home</h2></td>
	</tr>
</tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="700">
<tr>
    <td align="left" width="50%" valign="top">
        <h3><img src="images/Dashboard.gif" alt="Current Enrollment" border="0">&nbsp;Welcome to Netfusion Quickenroll</h3>
        <table border="0" cellpadding="0" cellspacing="0" >
        <tr>
        <td><br><p>The Netfusion Quickenroll is pleased to introduce its newly enhanced website feature &#45; Online Enrollment Reservation. This feature allows students to conveniently reserve or secure their position in the incoming enrollment anywhere they are located.</p><br>
		<p>Online Enrollment Reservation is specifically available for the convenience of students and faculty. Consequently, it would now be quicker, easier and more secure for students and the administration to track down all necessary information regarding enrollment through the Online Enrollment Reservation.</p><br>
		</td>
        </tr>
        </table>
    </td>
</tr>
</table>
<h3><img src="images/bday.jpg" alt="Current Enrollment" border="0">&nbsp;Celebrants for the Month of <?php echo date("F"); ?></h3>
<table border="0" cellpadding="0" cellspacing="0"  >
        <tr height="20">
    		<td scope="col" class="listViewThS1" nowrap>Student</td>
    		<td scope="col" class="listViewThS1" nowrap ><center>Birthdate</center> </td>
    	</tr>
    	<tr>
    		<td class="evenListRowS1" colspan="2">
			<div style="border-style: solid; border-color: rgb(128, 128, 128) rgb(255, 255, 255) rgb(255, 255, 255) rgb(128, 128, 128); border-width: 1px; font-family: sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 13.3px; line-height: normal; font-size-adjust: none; font-stretch: normal; -x-system-font: none; width: 27.7em;">
			<div style="border-style: solid; border-color: rgb(64, 64, 64) rgb(212, 208, 200) rgb(212, 208, 200) rgb(64, 64, 64); border-width: 1px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; overflow: auto; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 20em;">
			<table border="0" cellpadding="0" cellspacing="0" width="350" >
					<tr>
			            <td class="evenListRowS1">
			            <?php 
			            	$month = date('m');
			            
			            	$this->db->where("DATE_FORMAT(bday, '%m')=",$month); 
			            	$this->db->select("DATE_FORMAT(bday, '%m/%d/%Y') as bday, idno, lname, fname, mname");
			            	$this->db->order_by("bday", "asc"); 
			            	
			            	$student = $this->User_model->retrieveAllStudents();
			            	foreach ($student as $row): 
			            ?>
			            </td>
			        </tr>
					<tr>
							<td class="" style="padding:1px 1px 1px 1px"><slot><b><font color="#12539c">&nbsp;&nbsp;<?php echo $row->lname.', '.$row->fname.' '.$row->mname; ?></font></b></slot></td>
							<td class=""><slot><b><font color="#12539c"><?php echo date("d F, Y " , strtotime($row->bday)); ?></font></b></slot></td>
					</tr>
					<tr>
			            <td><?php endforeach; ?></td>
			        </tr>
			</table>
			</div>
			</div>
			</td>
		</tr>
</table>
<br>