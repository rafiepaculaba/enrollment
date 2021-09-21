
<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>PERSONAL INFORMATION</h2></td>
	</tr>
</tbody>
</table>
 
<?php  $current_user = $_SESSION['current_user']; 
//var_dump($current_user);
		foreach ($current_user as $row)	:
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="70%" valign="top">
        	<p><table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
            <th class="tabDetailViewDL" colspan="4" align="center"><h4 class="tabDetailViewDL">Personal Information</h4></th>
             
            <tr>
                <td class="tabDetailViewDL" width="25%"><slot>Student ID No. :</slot></td>
                <td class="tabDetailViewDF" width="75%"><slot> <?php echo $row->idno; ?>&nbsp;</slot></td>
            </tr>
            <tr>
                <td class="tabDetailViewDL"><slot>Complete Name :</slot></td>
                <td>
                <slot>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="30%" class="tabDetailViewDF"><?php echo $row->lname; ?>&nbsp;&nbsp;, &nbsp;</td>
                    <td width="30%" class="tabDetailViewDF"><?php echo $row->fname; ?>&nbsp;</td>
                    <td width="40%" class="tabDetailViewDF"><?php echo $row->mname; ?>&nbsp;</td>
                </tr>
                </table>
                </slot>
                </td>
            </tr>
            <tr>
                <td class="tabDetailViewDL"><slot>&nbsp;</slot></td>
                <td class="tabDetailViewDF">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%">Last Name</td>
                        <td width="30%">First Name</td>
                        <td width="40%">Middle Name</td>
                    </tr>
                    </table>
                </td>
            </tr>
            <tr>
			        <td class="tabDetailViewDL" width="25%"><slot>Grade :</slot></td>
			        <td class="tabDetailViewDF" colspan="3">
			        <slot>
			        <?php echo $row->yrLevel; ?>
			        </slot>
			        </td>
			    </tr>
            </table>
            </p>
        </td>
        
        <td width="30%" align="center" rowspan="2">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="center">
                    <?php 
                        $allowed_filetypes = array('.jpg','.JPG','.JPEG','.gif','.GIF','.bmp','.BMP','.png','.BMP','.PNG');            
			            $image = "../uploads/".$row->gender."_no_image.jpg";
			            foreach ($allowed_filetypes as $value) {
			                if (is_file("../uploads/preschool_students/".$row->idno.$value)) {
			                    $image = "../uploads/preschool_students/".$row->idno.$value;
			                    break;
			                }	
			            }
                    	if(is_file($image)){
                    		echo '<p><img src="'.$image.'" width="150" height="150" /></p>';
                    	} else {
                    		echo '<p><img src="'.$image.'" width="150" height="150" /></p>';
                    	}
                    ?>
                    </td>
                </tr>
                
            </table>
        </td>
    </tr>
</table>
</p>

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Personal Info</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Age :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot><?php echo $row->age; ?></slot></td>
        <td class="tabDetailViewDL" width="18%"><slot>Birthday :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot><?php echo $row->bday; ?></slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Gender :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
	        if($row) {
	        switch ($row->gender) {
	         	case "F":
	         		echo "Female";
	         		break;
	         	case "M":
	         		echo "Male";
	         		break;
		        }
		    }
		  ?> 	
        </slot></td>
        <td class="tabDetailViewDL"><slot>Civil Status :</slot></td>
        <td class="tabDetailViewDF"><slot>
        <?php 
	        if($row) {
	        switch ($row->cstatus) {
	         	case "S":
	         		echo "Single";
	         		break;
	         	case "M":
	         		echo "Married";
	         		break;
		        }
		    }
		  ?> 	
        </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Nationality :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->nationality; ?></slot></td>
        <td class="tabDetailViewDL">&nbsp;</td>
        <td class="tabDetailViewDF">&nbsp;</td>
    </tr>
</table>
</p>

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDF" colspan="4" align="left"><h4 class="tabDetailViewDL">Contact and Address</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Permanent Address :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->permanentAddr; ?></slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Current Address :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->currentAddr; ?>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Contact No. :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->phone; ?>&nbsp;</slot></td>
    </tr>
</table>
</p>
  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDF" colspan="4" align="left"><h4 class="tabDetailViewDL">Parents</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Father's Name :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot><?php echo $row->fatherName; ?>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="18%"><slot>Occupation :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot><?php echo $row->fatherOccupation; ?>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Father's Telephone :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot><?php echo $row->fatherContact; ?>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="18%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Mother's Name :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->motherName; ?>&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Occupation :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->motherOccupation; ?>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Mother's Telephone :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot><?php echo $row->motherContact; ?>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="18%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Guardian's Name :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->guardian; ?>&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Occupation :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->guardianOccupation; ?>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Guardian's Telephone :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot><?php echo $row->guardianContact; ?>&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="18%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>&nbsp;</slot></td>
    </tr>
</table>
</p>
  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDF" colspan="4" align="left"><h4 class="tabDetailViewDL">Documents</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Document Entry :</slot></td>
        <td class="tabDetailViewDF"><slot><?php echo $row->entryDocs; ?>&nbsp;</slot></td>
    </tr>
</table>
<?php endforeach; ?>
</p>