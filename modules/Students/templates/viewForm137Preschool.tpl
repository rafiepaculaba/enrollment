
<p>
<ul class="tablist">
<li id="tab_li_Student_info">
<a id="tab_link_Student_info" href="index.php?module=Students&action=viewStudentPreschool&idno={$idno}">Student Profile</a>
</li>	
<li class="active" id="tab_li_TOR">
<a class="current" id="tab_link_TOR" href="index.php?module=Students&action=viewForm137Preschool&idno={$idno}">Form 137</a>
</li>	
</ul>
</p>

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th colspan="5" align="left"><h4 class="tabDetailViewDL">Form 137-B</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot>{$idno} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot>{$name} &nbsp;</slot></td>
    </tr>
</table>   
</p>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		
		<td scope="col" class="listViewThS1" nowrap>SUBJECT</td>
		<td scope="col" class="listViewThS1" nowrap>DESCRIPTIVE TITLE</td>
		<td scope="col" class="listViewThS1" nowrap>1st</td>
		<td scope="col" class="listViewThS1" nowrap>2nd</td>
		<td scope="col" class="listViewThS1" nowrap>3rd</td>
		<td scope="col" class="listViewThS1" nowrap>4th</td>
		<td scope="col" class="listViewThS1" nowrap>FINAL</td>
<!--		<td scope="col" class="listViewThS1" width="10%" nowrap>UNITS</td>-->
	</tr>
	{$body}
</tbody>
</table>