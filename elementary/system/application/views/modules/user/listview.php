<form id="frmUserList" name="frmUserList" method="POST" action="index.php?user/listview">

<table class="moduleTitle" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td valign="top"><img width="16" height="16" border="0" alt="view_inline" style="margin-top: 3px; margin-right: 3px;" src="images/view_inline.gif"/></td>
		<td width="100%"><h2>User</h2></td>
	</tr>
</tbody>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td nowrap="nowrap"><h3><img src="images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;Users</h3></td><td width="100%"><img src="images/blank.gif" alt="" height="1" width="1"></td>
</tr>
</table>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<tr height="20">
	<td scope="col" class="listViewThS1" nowrap>Last name</td>
	<td scope="col" class="listViewThS1" nowrap>First name</td>
	<td scope="col" class="listViewThS1" nowrap>Middle name</td>
	<td scope="col" class="listViewThS1" nowrap>Group</td>
	<td scope="col" class="listViewThS1" nowrap>Local</td>
	<td scope="col" class="listViewThS1" nowrap>Telephone No.</td>
	<td scope="col" class="listViewThS1" nowrap>Status</td>
	<td scope="col" class="listViewThS1" nowrap>Apply</td>		
</tr>
<tr height="20">
	<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="lastName" id="lastName" value="<?php echo $lastName; ?>"/></td>
	<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="firstName" id="firstName" value="<?php echo $firstName; ?>"/></td>
	<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="middleName" id="middleName" value="<?php echo $middleName; ?>"/></td>
	<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
	<slot>
		<select name="groupID">
			<option value="">--------</option>
			<option <?php if($groupID == '1') { echo 'selected'; } ?> value="1">Admin</option>
			<option <?php if($groupID == '2') { echo 'selected'; } ?> value="2">Requestor</option>
			<option <?php if($groupID == '3') { echo 'selected'; } ?> value="3">OJT</option>
		</select>
	</slot>
	</td>
	<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="localNum" id="localNum" size="10" value="<?php echo $localNum; ?>"/></td>
	<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="telNum" id="telNum" size="10" value="<?php echo $telNum; ?>"/></td>
	<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
	<slot>
	<select name="rstatus">
		<option value="">--------</option>
		<option value="1" <?php if($rstatus == '1') { echo 'selected'; } ?>>Active</option>
		</select>
	</slot>
	</td>
	<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="submit" name="cmdFilter" id="cmdFilter" value="Filter"/></td>
</tr>
<tr>
	<td colspan="20" height="1" class="listViewHRS1"></td>
</tr>
<?php foreach ($record as $row): ?>
<tr onMouseOver="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onMouseOut="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onMouseDown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><span sugar="sugar0b"><a href="index.php?user/view/<?php echo $row->userID ?>" class="listViewTdLinkS1"> <?php echo $row->lastName?></a></span> &nbsp;</td>
	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><span sugar="sugar0b"><a href="index.php?user/view/<?php echo $row->userID ?>" class="listViewTdLinkS1"> <?php echo $row->firstName?></a></span> &nbsp;</td>
	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><span sugar="sugar0b"><a href="index.php?user/view/<?php echo $row->userID ?>" class="listViewTdLinkS1"> <?php echo $row->middleName?></a></span> &nbsp;</td>
	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><?php echo $row->groupID?> &nbsp;</td>
	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><?php echo $row->localNum?> &nbsp;</td>		
	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><?php echo $row->telNum?> &nbsp;</td>
	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap ><?php echo $row->rstatus?> &nbsp;</td>
	<td scope="row" class="evenListRowS1" bgcolor="#fdfdfd" nowrap > &nbsp;</td>
</tr>
<tr>
	<td colspan="20" height="1" class="listViewHRS1"></td>
</tr>
<?php endforeach; ?>
<tr>
	<td colspan="20" height="20">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td class="listViewPaginationTdS1" align="left" nowrap="nowrap" width="30%">&nbsp;&nbsp;<a href="#" onClick="popUp('index.php?module=Students&action=printStudentsCol')" id="print_link"><img src="images/print.gif" alt="Export" align="absmiddle" border="0" height="9" width="11">&nbsp;Print</a></td>
            <td class="listViewPaginationTdS1" align="right" nowrap="nowrap" width="70%"><img src="images/start_off.gif" alt="Next" align="absmiddle" border="0" height="9" width="11">&nbsp; Start&nbsp;&nbsp;<img src="images/previous_off.gif" alt="End" align="absmiddle" border="0" height="9" width="11">&nbsp; Previous&nbsp;&nbsp;<span class="pageNumbers">( 1 - 10 of 10 )</span>&nbsp;&nbsp;  Next &nbsp;<img src="images/next_off.gif" alt="Next" align="absmiddle" border="0" height="9" width="11">&nbsp;&nbsp;  End	&nbsp;<img src="images/end_off.gif" alt="End" align="absmiddle" border="0" height="9" width="11"></td>
        </tr>
        </tbody>
        </table>
	</td>
</tr>
</table>
</form>