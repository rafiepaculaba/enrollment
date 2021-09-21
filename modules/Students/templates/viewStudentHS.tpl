

<p>
<ul class="tablist">
<li class="active" id="tab_li_Student_info">
<a class="current" id="tab_link_Student_info" href="index.php?module=Students&action=viewStudentHS&idno={$idno}">Student Profile</a>
</li>

{if $hasViewForm137 eq 1 }	
<li id="tab_li_TOR">
<a id="tab_link_TOR" href="index.php?module=Students&action=viewForm137HS&idno={$idno}">Form 137</a>
</li>	
{/if}
</ul>
</p>

<table width="100%" border="0">
  <tr>
    <td>
   <input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Students&action=listStudentsHS');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Students&action=editStudentHS&idno={$idno}');" />
    {/if}
    
    {if $hasDelete eq 1 }
    <input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteStudent('{$idno}');" />
    {/if}
  </tr>
</table>  

<p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="70%" valign="top">
        	<p>	
            <table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
                <!--<tr>
                    <td class="tabDetailViewDL" width="25%"><slot>Registration :</slot></td>
                    <td class="tabDetailViewDF" width="75%"><slot>{$regID}&nbsp; </slot></td>
                </tr>-->
                <tr>
                    <td class="tabDetailViewDL" width="25%"><slot>Student ID No. :</slot></td>
                <td class="tabDetailViewDF" width="75%"><slot>{$idno} &nbsp;</slot></td>
                </tr>
                <tr>
                    <td class="tabDetailViewDL"><slot>Complete Name :</slot></td>
                    <td >
                    <slot>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" class="tabDetailViewDF">{$lname} &nbsp;&nbsp;, &nbsp;</td>
                        <td width="30%" class="tabDetailViewDF">{$fname}&nbsp;</td>
                        <td width="40%" class="tabDetailViewDF">{$mname}&nbsp;</td>
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
                    <td class="tabDetailViewDL"><slot>Year Level :</slot></td>
                    <td class="tabDetailViewDF">
                       <slot>{$yrLevel}&nbsp;</slot>
                    </td>
                </tr>
            </table>
            </p>
        </td>    
        <td width="30%" align="center" rowspan="2">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="center">
                    <p>
                    <img src="{$image}" width="{$img_width}" height="{$img_height}" />
                    </p>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                    <form enctype="multipart/form-data" name="frmStudent" id="frmStudent" method="post" action="index.php?module=Students&action=saveImageHS" >
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                    <input type="hidden" id="theForm" name="theForm" value="changePicture" />
                    <input type="hidden" id="idno" name="idno" value="{$idno}" />
                    <input name="uploadedfile" type="file" class="button" /> <input type="submit" name="cmdChange" value="Go" />
                    </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <tr>
        <td width="70%" valign="top">
        	<p>
			<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
			    <tr>
			        <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Personal Info</h4></th>
			    </tr>
			    <tr>
			        <td class="tabDetailViewDL" width="25%"><slot>Age :</slot></td>
			        <td class="tabDetailViewDF"><slot>{$age}&nbsp;</slot></td>
			        <td class="tabDetailViewDL"><slot>Birthday :</slot></td>
			        <td class="tabDetailViewDF"><slot>{$bday}&nbsp;</slot></td>
			    </tr>
			    <tr>
			        <td class="tabDetailViewDL"><slot>Gender :</slot></td>
			        <td class="tabDetailViewDF"><slot>{$gender}&nbsp;</slot></td>
			        <td class="tabDetailViewDL"><slot>Civil Status :</slot></td>
			        <td class="tabDetailViewDF"><slot>{$cstatus}&nbsp;</slot></td>
			    </tr>
			    <tr>
			        <td class="tabDetailViewDL"><slot>Nationality :</slot></td>
			        <td class="tabDetailViewDF"><slot>{$nationality}&nbsp;</slot></td>
			        <td class="tabDetailViewDL">&nbsp;</td>
			        <td class="tabDetailViewDF">&nbsp;</td>
			    </tr>
			</table>
			</p>
        </td>
    </tr>
</table>
</p>
  


<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="tabDetailViewDL" colspan="4" align="left"><h4 class="tabDetailViewDL">Preliminary Education</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Primary :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>{$primary_edu}&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="18%"><slot>School Year  :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>{$primary_schYear}&nbsp;</slot></td>
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
        <td class="tabDetailViewDF"><slot>{$permanentAddr}&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Current Address :</slot></td>
        <td class="tabDetailViewDF"><slot>{$currentAddr}&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Contact No. :</slot></td>
        <td class="tabDetailViewDF"><slot>{$phone}&nbsp;</slot></td>
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
        <td class="tabDetailViewDF" width="32%"><slot>{$fatherName}&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="18%"><slot>Occupation :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>{$fatherOccupation}&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Father's Telephone :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>{$fatherContact}&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="18%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Mother's Name :</slot></td>
        <td class="tabDetailViewDF"><slot>{$motherName}&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Occupation :</slot></td>
        <td class="tabDetailViewDF"><slot>{$motherOccupation}&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Mother's Telephone :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>{$motherContact}&nbsp;</slot></td>
        <td class="tabDetailViewDL" width="18%"><slot>&nbsp;</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Guardian's Name :</slot></td>
        <td class="tabDetailViewDF"><slot>{$guardian}&nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Occupation :</slot></td>
        <td class="tabDetailViewDF"><slot>{$guardianOccupation}&nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Guardian's Telephone :</slot></td>
        <td class="tabDetailViewDF" width="32%"><slot>{$guardianContact}&nbsp;</slot></td>
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
        <td class="tabDetailViewDF"><slot>{$entryDocs}&nbsp;</slot></td>
    </tr>
</table>
</p>