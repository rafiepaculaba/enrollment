<?php /* Smarty version 2.6.11, created on 2008-12-15 03:09:42
         compiled from modules/Account/templates/listAccountsCol.tpl */ ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap"><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;College Student Accounts</h3></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
	</tr>
</table>
<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" nowrap>Sch Year</td>
		<td scope="col" class="listViewThS1" nowrap>Semester</td>
		<td scope="col" class="listViewThS1" nowrap>ID No.</td>
		<td scope="col" class="listViewThS1" nowrap>Last Name</td>
		<td scope="col" class="listViewThS1" nowrap>First Name</td>
		<td scope="col" class="listViewThS1" nowrap>Middle Name</td>
		<td scope="col" class="listViewThS1" nowrap>Gender</td>
		<td scope="col" class="listViewThS1" nowrap>Course</td>
		<td scope="col" class="listViewThS1" nowrap>Year</td>
		<td scope="col" class="listViewThS1" nowrap>&nbsp;</td>
		<td scope="col" class="listViewThS1" nowrap>Apply</td>
		
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php">
	    <input type="hidden" name="module" value="Account" />
	    <input type="hidden" name="action" value="listAccountsCol" />
	    
	    <td scope="col" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><?php echo $this->_tpl_vars['SCHOOLYEAR']; ?>
</td>
		<td scope="col" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><?php echo $this->_tpl_vars['SEMESTERS']; ?>
</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="idno" id="idno" size="15" value="<?php echo $this->_tpl_vars['idno']; ?>
" maxlength="15" onkeypress="return keyRestrict(event, 14);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="lname" id="lname" value="<?php echo $this->_tpl_vars['lname']; ?>
" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="fname" id="fname" value="<?php echo $this->_tpl_vars['fname']; ?>
" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="mname" id="mname" value="<?php echo $this->_tpl_vars['mname']; ?>
" maxlength="25" onkeypress="return keyRestrict(event, 12);" /></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
    		<select name="gender" id="gender">
            <option value="">--------</option>
            <option value="M" <?php if ($this->_tpl_vars['gender'] == 'M'): ?> selected <?php endif; ?> > Male </option>
            <option value="F" <?php if ($this->_tpl_vars['gender'] == 'F'): ?> selected <?php endif; ?> > Female </option>
            </select> 
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<select name="courseID" id="courseID">
        <option value="">--------</option>
        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['courseList']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
        <option value="<?php echo $this->_tpl_vars['courseList'][$this->_sections['i']['index']]['courseID']; ?>
"
        <?php if ($this->_tpl_vars['courseID'] == $this->_tpl_vars['courseList'][$this->_sections['i']['index']]['courseID']): ?> selected <?php endif; ?> 
        ><?php echo $this->_tpl_vars['courseList'][$this->_sections['i']['index']]['courseCode']; ?>
</option>
        <?php endfor; endif; ?>
        </select> 
        </td>
        <td scope="col" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<!--<select name="yrLevel" id="yrLevel">
        <option value="">--------</option>
        <option value="1" <?php if ($this->_tpl_vars['yrLevel'] == '1'): ?> selected <?php endif; ?>>1</option>
        <option value="2" <?php if ($this->_tpl_vars['yrLevel'] == '2'): ?> selected <?php endif; ?>>2</option>
        <option value="3" <?php if ($this->_tpl_vars['yrLevel'] == '3'): ?> selected <?php endif; ?>>3</option>
        <option value="4" <?php if ($this->_tpl_vars['yrLevel'] == '4'): ?> selected <?php endif; ?>>4</option>
        <option value="5" <?php if ($this->_tpl_vars['yrLevel'] == '5'): ?> selected <?php endif; ?>>5</option>
        </select>--> 
		<?php echo $this->_tpl_vars['yrLevel_object']; ?>

		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="submit" name="cmdFilter" id="cmdFilter" value="Filter"/></td>
		
		</form>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	
	<?php if ($this->_tpl_vars['list'] != ""): ?>
    	<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
    	<!-- Start of students Listing -->
    	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
    	       
        	<td scope="row" 
            <?php if (i % 2 == 0): ?>
                class="evenListRowS1" bgcolor="#fdfdfd" 
            <?php else: ?>
                class="oddListRowS1" bgcolor="#ffffff" 
            <?php endif; ?>
            align="left" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['schYear']; ?>
</td>
    		
    		<td scope="row" 
            <?php if (i % 2 == 0): ?>
                class="evenListRowS1" bgcolor="#fdfdfd" 
            <?php else: ?>
                class="oddListRowS1" bgcolor="#ffffff" 
            <?php endif; ?>
            align="left" valign="top"> <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['semCode'] == 1): ?> 1st <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['semCode'] == 2): ?> 2nd <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['semCode'] == 4): ?> Summer <?php endif; ?> </td>   
    	
    		<td scope="row" 
            <?php if (i % 2 == 0): ?>
                class="evenListRowS1" bgcolor="#fdfdfd" 
            <?php else: ?>
                class="oddListRowS1" bgcolor="#ffffff" 
            <?php endif; ?>
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Account&action=viewAccountCol&accID=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['accID']; ?>
" class="listViewTdLinkS1"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['idno']; ?>
</a></span></td>
    		
    		<td scope="row"
            <?php if (i % 2 == 0): ?>
                class="evenListRowS1" bgcolor="#fdfdfd" 
            <?php else: ?>
                class="oddListRowS1" bgcolor="#ffffff" 
            <?php endif; ?>
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Account&action=viewAccountCol&accID=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['accID']; ?>
" class="listViewTdLinkS1"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['lname']; ?>
</a></span></td>
    		
    		<td scope="row"
            <?php if (i % 2 == 0): ?>
                class="evenListRowS1" bgcolor="#fdfdfd" 
            <?php else: ?>
                class="oddListRowS1" bgcolor="#ffffff" 
            <?php endif; ?>
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Account&action=viewAccountCol&accID=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['accID']; ?>
" class="listViewTdLinkS1"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['fname']; ?>
</a></span></td>
    		
    		<td scope="row"
            <?php if (i % 2 == 0): ?>
                class="evenListRowS1" bgcolor="#fdfdfd" 
            <?php else: ?>
                class="oddListRowS1" bgcolor="#ffffff" 
            <?php endif; ?>
            align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Account&action=viewAccountCol&accID=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['accID']; ?>
" class="listViewTdLinkS1"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['mname']; ?>
</a></span></td>
    		
    		<td scope="row"
            <?php if (i % 2 == 0): ?>
                class="evenListRowS1" bgcolor="#fdfdfd" 
            <?php else: ?>
                class="oddListRowS1" bgcolor="#ffffff" 
            <?php endif; ?>
            align="left" bgcolor="#fdfdfd" valign="top"> <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['gender'] == 'M'): ?> Male <?php else: ?> Female <?php endif; ?></td>
    		
    		<td scope="row" 
            <?php if (i % 2 == 0): ?>
                class="evenListRowS1" bgcolor="#fdfdfd" 
            <?php else: ?>
                class="oddListRowS1" bgcolor="#ffffff" 
            <?php endif; ?>
            align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['courseCode']; ?>
</td>
    		
    		<td scope="row" 
            <?php if (i % 2 == 0): ?>
                class="evenListRowS1" bgcolor="#fdfdfd" 
            <?php else: ?>
                class="oddListRowS1" bgcolor="#ffffff" 
            <?php endif; ?>
            align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['yrLevel']; ?>
</td>
    		
			<td scope="row"
	        <?php if (i % 2 == 0): ?>
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        <?php else: ?>
	            class="oddListRowS1" bgcolor="#ffffff" 
	        <?php endif; ?>
	        align="left" bgcolor="#fdfdfd" valign="top"><img src="themes/Sugar/images/AccountReports.gif" border="0" onclick="popUp('index.php?module=Account&action=statementReportCol&accID=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['accID']; ?>
&schYear=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['schYear']; ?>
&semCode=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['semCode']; ?>
&lname=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['lname']; ?>
&fname=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['fname']; ?>
&mname=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['mname']; ?>
&courseCode=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['courseCode']; ?>
&yrLevel=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['yrLevel']; ?>
&sugar_body_only=1');"><span></td>	
    		    		
    		<td scope="row" 
            <?php if (i % 2 == 0): ?>
                class="evenListRowS1" bgcolor="#fdfdfd" 
            <?php else: ?>
                class="oddListRowS1" bgcolor="#ffffff" 
            <?php endif; ?>
            align="left" bgcolor="#fdfdfd" valign="top">&nbsp;</td>
    		
    	</tr>
    	<tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
    	<!-- End of student Listing -->
    	<?php endfor; endif; ?>
    	
		
	<?php else: ?>
    	<tr>
    		<td colspan="20" class="oddListRowS1">
            	<table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tbody>
            	<tr>
            		<td nowrap="nowrap" align="center"><b><i>No results found.</i></b></td>
            	</tr>
            	</tbody>
            	</table>
    		</td>
    	</tr>
	<?php endif; ?>
	
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<tr>
		<td colspan="20" height="20">
		<?php echo $this->_tpl_vars['pagination']; ?>

		</td>
	</tr>
</tbody>
</table>

</p>
