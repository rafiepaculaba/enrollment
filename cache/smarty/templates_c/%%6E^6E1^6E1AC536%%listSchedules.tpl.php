<?php /* Smarty version 2.6.11, created on 2008-12-26 08:18:25
         compiled from modules/Schedules/templates/listSchedules.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'modules/Schedules/templates/listSchedules.tpl', 239, false),)), $this); ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap" ><h3><img src="themes/Sugar/images/h3Arrow.gif" border="0" height="11" width="11">&nbsp;COLLEGE SCHEDULES</h3></td>
	</tr>
	<tr>
		<td nowrap="nowrap" ><img src="themes/Sugar/images/basic_search.gif" id="divSubjectHandle" onclick="hideShowSubject('divSubject');" alt="Advance Option"/><label onclick="hideShowSubject('divSubject');">&nbsp;Advance Option</label></td><td width="100%"><img src="include/images/blank.gif" alt="" height="1" width="1"></td>
		<td nowrap="nowrap" ><img src="themes/Sugar/images/basic_search.gif" id="divSubjectHandle2" onclick="hideShowSubject('divSubject');" alt="Advance Option"/><label onclick="hideShowSubject('divSubject');">&nbsp;Advance Option</label></td>
	</tr>
</table>

<div id="divSubject" style="display:block">
<form name="frmSelect" id="frmSelect" method="POST" action="index.php">
<input type="hidden" name="module" value="Schedules" />
<input type="hidden" name="action" value="listSchedules" />
<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
    <td class="dataLabel" id="chooser_display_tabs_text" align="center" width="15%"><nobr>Check field to display </nobr></td>
    <td class="dataLabel" id="chooser_hide_tabs" align="center" > &nbsp; </td>
</tr>
<tr>
    <td>
        <div style='font:13.3px sans-serif;width:9.5em;border-left:1px solid #808080;border-top:1px solid #808080;border-bottom:1px solid #fff; border-right:1px solid #fff;'>
        <div style='background:#fff; overflow:auto;height:7.1em;border-left:1px solid #404040;border-top:1px solid #404040;border-bottom:1px solid #d4d0c8;border-right:1px solid #d4d0c8;'>
        <label for='room' style='padding-right:3px;display:block;'><input name='checkbox[]' value='room' type='checkbox' id='room' <?php if ($this->_tpl_vars['droom'] == 1): ?> checked <?php endif; ?> onclick='highlight_div(this);'>Room </label>
        <label for='#enrolled' style='padding-right:3px;display:block;'><input name='checkbox[]' value='#enrolled' type='checkbox' id='#enrolled' <?php if ($this->_tpl_vars['dnoEnrolled'] == 1): ?> checked <?php endif; ?> onclick='highlight_div(this);'># Enrolled </label>
        <label for='maxcapacity' style='padding-right:3px;display:block;'><input name='checkbox[]' value='maxcapacity' type='checkbox' id='maxcapacity' <?php if ($this->_tpl_vars['dmaxCapacity'] == 1): ?> checked <?php endif; ?> onclick='highlight_div(this);'>Max Capacity </label>
        <label for='starttime' style='padding-right:3px;display:block;'><input name='checkbox[]' value='starttime' type='checkbox' id='starttime' <?php if ($this->_tpl_vars['dstartTime'] == 1): ?> checked <?php endif; ?> onclick='highlight_div(this);'>Start Time </label>
        <label for='endtime' style='padding-right:3px;display:block;'><input name='checkbox[]' value='endtime' type='checkbox' id='endtime' <?php if ($this->_tpl_vars['dendTime'] == 1): ?> checked <?php endif; ?> onclick='highlight_div(this);'>End Time </label>
        <label for='remarks' style='padding-right:3px;display:block;'><input name='checkbox[]' value='remarks' type='checkbox' id='remarks' <?php if ($this->_tpl_vars['dremarks'] == 1): ?> checked <?php endif; ?> onclick='highlight_div(this);'>Remarks </label>
        <label for='days' style='padding-right:3px;display:block;'><input name='checkbox[]' value='days' type='checkbox' id='days' <?php if ($this->_tpl_vars['ddays'] == 1): ?> checked <?php endif; ?> onclick='highlight_div(this);'>Days </label>
        </div>
        </div>
    </td>
</tr>
<tr>
    <td>
        <input type="submit" name="cmdSelect" id="cmdSelect" value="Go" />
    </td>
</tr>
</tbody>
</table>
</p>
</form>
</div>

<p>
<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1"  nowrap>School Year</td>
		<td scope="col" class="listViewThS1"  nowrap>Semester</td>
		<td scope="col" class="listViewThS1"  nowrap>Year Level</td>
		<td scope="col" class="listViewThS1"  nowrap>Course</td>
		<td scope="col" class="listViewThS1"  nowrap>Sched Code </td>
		<td scope="col" class="listViewThS1"  nowrap>Subject </td>
		<td scope="col" class="listViewThS1"  nowrap>Instructor </td>
		<?php if ($this->_tpl_vars['droom'] == 1): ?>
		  <td scope="col" class="listViewThS1"  nowrap>Room </td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['dstartTime'] == 1): ?>
		  <td scope="col" class="listViewThS1"  nowrap>Start Time </td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['dendTime'] == 1): ?>
		  <td scope="col" class="listViewThS1"  width="70" nowrap>End Time </td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['ddays'] == 1): ?>
		  <td scope="col" class="listViewThS1" width="120" nowrap>Days </td>
		<?php endif; ?>
		<td scope="col" class="listViewThS1"  nowrap>Status </td>
		<td scope="col" class="listViewThS1"  nowrap>&nbsp; </td>
		<?php if ($this->_tpl_vars['dnoEnrolled'] == 1): ?>
    	   <td scope="col" class="listViewThS1"  nowrap># Enrolled </td>
    	<?php endif; ?>
    	<?php if ($this->_tpl_vars['dmaxCapacity'] == 1): ?>
		  <td scope="col" class="listViewThS1"  nowrap>Max Capacity </td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['dremarks'] == 1): ?>
		  <td scope="col" class="listViewThS1"  nowrap>Remarks </td>
		<?php endif; ?>
		<td scope="col" class="listViewThS1"  nowrap>Apply</td>
	</tr>
	<tr height="20">
	    <form name="frmFilter" id="frmFilter" method="GET" action="index.php">
	    <input type="hidden" name="module" value="Schedules" />
	    <input type="hidden" name="action" value="listSchedules" />
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><?php echo $this->_tpl_vars['SCHOOLYEAR']; ?>
</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><?php echo $this->_tpl_vars['SEMESTERS']; ?>
</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1" >
		<slot> <?php echo $this->_tpl_vars['YEARLEVEL']; ?>
</slot>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1" >
		<slot>
        <select name="courseID" id="courseID" onchange="getSubjects();">
        <option value="">-------------------</option>
        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['courselist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <option value="<?php echo $this->_tpl_vars['courselist'][$this->_sections['i']['index']]['courseID']; ?>
" <?php if ($this->_tpl_vars['courselist'][$this->_sections['i']['index']]['courseID'] == $this->_tpl_vars['courseID']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['courselist'][$this->_sections['i']['index']]['courseCode']; ?>
</option>
        <?php endfor; endif; ?>
        </select>
        </slot>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="schedCode" id="schedCode" size="15" value="<?php echo $this->_tpl_vars['schedCode']; ?>
" maxlength="10" onkeypress="return keyRestrict(event, 0);"/></td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1" >
		<slot>
        <select name="subjID" id="subjID">
        <option value="">-------------------------------------------------------</option>
        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['subjlist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <option value="<?php echo $this->_tpl_vars['subjlist'][$this->_sections['i']['index']]['subjID']; ?>
" <?php if ($this->_tpl_vars['subjlist'][$this->_sections['i']['index']]['subjID'] == $this->_tpl_vars['subjID']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['subjlist'][$this->_sections['i']['index']]['subjCode']; ?>
 &nbsp;<?php echo $this->_tpl_vars['subjlist'][$this->_sections['i']['index']]['descTitle']; ?>
&nbsp; <?php if ($this->_tpl_vars['subjlist'][$this->_sections['i']['index']]['type'] == 2): ?> (Lab)<?php endif; ?></option>
        <?php endfor; endif; ?>
        </select>
        </slot>
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
		<slot>
			<select name="profID" id="profID"  >
            <?php if ($this->_tpl_vars['isInstructorGroup'] == 0): ?>
			<option value="">---------------------------------------</option>
			<?php endif; ?>
		    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['user_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		    <option value="<?php echo $this->_tpl_vars['user_list'][$this->_sections['i']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['user_list'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['profID']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['user_list'][$this->_sections['i']['index']]['last_name']; ?>
, <?php echo $this->_tpl_vars['user_list'][$this->_sections['i']['index']]['first_name']; ?>
</option>
		    <?php endfor; endif; ?>
		    </select>
		</slot>
		</td>
		<?php if ($this->_tpl_vars['droom'] == 1): ?>
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="room" id="room" size="7" value="<?php echo $this->_tpl_vars['room']; ?>
" maxlength="10" onkeypress="return keyRestrict(event, 5);"/></td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['dstartTime'] == 1): ?>
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['dendTime'] == 1): ?>
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['ddays'] == 1): ?>
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		<?php endif; ?>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">
			<select name="rstatus" id="rstatus">
		        <option value="">----------------</option>
		        <option value="0" <?php if ($this->_tpl_vars['rstatus'] == '0'): ?> selected <?php endif; ?>> Closed </option>
		        <option value="1" <?php if ($this->_tpl_vars['rstatus'] == '1'): ?> selected <?php endif; ?>> Open </option>
		    </select> 
		</td>
		<td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		<?php if ($this->_tpl_vars['dnoEnrolled'] == 1): ?>
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp; </td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['dmaxCapacity'] == 1): ?>
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1">&nbsp;</td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['dremarks'] == 1): ?>
		  <td scope="row" class="evenListRowS1" nowrap  class="listViewPaginationTdS1"><input type="text" name="remarks" id="remarks" value="<?php echo $this->_tpl_vars['remarks']; ?>
" maxlength="10" onkeypress="return keyRestrict(event, 7);"/></td>
		<?php endif; ?>
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
		<!-- Start of Courses Listing -->
		<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
	
			<td scope="row" 
	        <?php if (i % 2 == 0): ?>
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        <?php else: ?>
	            class="oddListRowS1" bgcolor="#ffffff" 
	        <?php endif; ?>
	        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['schYear']; ?>
</td>
	
			<td scope="row" 
	        <?php if (i % 2 == 0): ?>
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        <?php else: ?>
	            class="oddListRowS1" bgcolor="#ffffff" 
	        <?php endif; ?>
	        align="left" bgcolor="#fdfdfd" valign="top"><?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['semCode'] == 1): ?> 1st Sem <?php endif; ?> <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['semCode'] == 2): ?> 2nd Sem <?php endif; ?> <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['semCode'] == 4): ?> Summer <?php endif; ?></td>
	
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
	        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['courseCode']; ?>
</td>	
	
			<td scope="row"
	        <?php if (i % 2 == 0): ?>
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        <?php else: ?>
	            class="oddListRowS1" bgcolor="#ffffff" 
	        <?php endif; ?>
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Schedules&action=viewSchedule&schedID=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['schedID']; ?>
" class="listViewTdLinkS1"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['schedCode']; ?>
</a><span></td>	
	
			<td scope="row"
	        <?php if (i % 2 == 0): ?>
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        <?php else: ?>
	            class="oddListRowS1" bgcolor="#ffffff" 
	        <?php endif; ?>
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b"><a href="index.php?module=Schedules&action=viewSchedule&schedID=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['schedID']; ?>
" class="listViewTdLinkS1"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['subjCode']; ?>
 &nbsp;<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['descTitle']; ?>
 &nbsp; <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['type'] == 2): ?> (Lab)<?php endif; ?></a></span></td>	
	
			<td scope="row"
	        <?php if (i % 2 == 0): ?>
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        <?php else: ?>
	            class="oddListRowS1" bgcolor="#ffffff" 
	        <?php endif; ?>
	        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['profName']; ?>
</td>	
	
		    <?php if ($this->_tpl_vars['droom'] == 1): ?>
    			<td scope="row"
    	        <?php if (i % 2 == 0): ?>
    	            class="evenListRowS1" bgcolor="#fdfdfd" 
    	        <?php else: ?>
    	            class="oddListRowS1" bgcolor="#ffffff" 
    	        <?php endif; ?>
    	        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['room']; ?>
</td>	
			<?php endif; ?>

			<?php if ($this->_tpl_vars['dstartTime'] == 1): ?>
        		<td scope="row"
                <?php if (i % 2 == 0): ?>
                    class="evenListRowS1" bgcolor="#fdfdfd" 
                <?php else: ?>
                    class="oddListRowS1" bgcolor="#ffffff" 
                <?php endif; ?>
                align="left" bgcolor="#fdfdfd" valign="top"><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['startTime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%I:%M %p") : smarty_modifier_date_format($_tmp, "%I:%M %p")); ?>
</td>	
			<?php endif; ?>

			<?php if ($this->_tpl_vars['dendTime'] == 1): ?>
    			<td scope="row"
    	        <?php if (i % 2 == 0): ?>
    	            class="evenListRowS1" bgcolor="#fdfdfd" 
    	        <?php else: ?>
    	            class="oddListRowS1" bgcolor="#ffffff" 
    	        <?php endif; ?>
    	        align="left" bgcolor="#fdfdfd" valign="top"><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['endTime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%I:%M %p") : smarty_modifier_date_format($_tmp, "%I:%M %p")); ?>
</td>	
			<?php endif; ?>

			<?php if ($this->_tpl_vars['ddays'] == 1): ?>
    			<td scope="row"
    	        <?php if (i % 2 == 0): ?>
    	            class="evenListRowS1" bgcolor="#fdfdfd" 
    	        <?php else: ?>
    	            class="oddListRowS1" bgcolor="#ffffff" 
    	        <?php endif; ?>
    	        align="left" bgcolor="#fdfdfd" valign="top" >
        			<?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onMon'] == 1): ?> M <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onMon'] == 0):  endif; ?>
        			<?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onThu'] == 1): ?>
        			     <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onTue'] == 1): ?> T <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onTue'] == 0):  endif; ?>
        			<?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onThu'] == 0): ?>
        			     <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onTue'] == 1): ?> Tue <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onTue'] == 0):  endif; ?>
        			<?php endif; ?>
        			<?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onWed'] == 1): ?> W <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onWed'] == 0):  endif; ?>
        			<?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onTue'] == 1): ?>
        			     <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onThu'] == 1): ?> Th <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onThu'] == 0):  endif; ?>
        			<?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onTue'] == 0): ?>
        			     <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onThu'] == 1): ?> Thu <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onThu'] == 0):  endif; ?>
        			<?php endif; ?>
                    <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onFri'] == 1): ?> F <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onFri'] == 0):  endif; ?>
                    <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onSat'] == 1): ?> Sat <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onSat'] == 0):  endif; ?>
                    <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onSun'] == 1): ?> Sun <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['onSun'] == 0):  endif; ?>
        		</td>
    		<?php endif; ?>

    		<td scope="row"
	        <?php if (i % 2 == 0): ?>
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        <?php else: ?>
	            class="oddListRowS1" bgcolor="#ffffff" 
	        <?php endif; ?>
	        align="left" bgcolor="#fdfdfd" valign="top"><?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['rstatus'] == 1): ?> Open <?php endif; ?> <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['rstatus'] == 0): ?> Closed <?php endif; ?></td>	
	
			<td scope="row"
	        <?php if (i % 2 == 0): ?>
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        <?php else: ?>
	            class="oddListRowS1" bgcolor="#ffffff" 
	        <?php endif; ?>
	        align="left" bgcolor="#fdfdfd" valign="top"><img src="themes/Sugar/images/classroster.gif" border="0" onclick="popUp('index.php?module=Reports&action=classRosterCol&schedID=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['schedID']; ?>
&sugar_body_only=1');"><span></td>	
	
			<?php if ($this->_tpl_vars['dnoEnrolled'] == 1): ?>
        		<td scope="row"
                <?php if (i % 2 == 0): ?>
                    class="evenListRowS1" bgcolor="#fdfdfd" 
                <?php else: ?>
                    class="oddListRowS1" bgcolor="#ffffff" 
                <?php endif; ?>
                align="center" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['noEnrolled']; ?>
</td>	
			<?php endif; ?>

			<?php if ($this->_tpl_vars['dmaxCapacity'] == 1): ?>
    			<td scope="row"
    	        <?php if (i % 2 == 0): ?>
    	            class="evenListRowS1" bgcolor="#fdfdfd" 
    	        <?php else: ?>
    	            class="oddListRowS1" bgcolor="#ffffff" 
    	        <?php endif; ?>
    	        align="center" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['maxCapacity']; ?>
</td>	
			<?php endif; ?>
			
            <?php if ($this->_tpl_vars['dremarks'] == 1): ?>
    			<td scope="row"
    	        <?php if (i % 2 == 0): ?>
    	            class="evenListRowS1" bgcolor="#fdfdfd" 
    	        <?php else: ?>
    	            class="oddListRowS1" bgcolor="#ffffff" 
    	        <?php endif; ?>
    	        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['remarks']; ?>
</td>	
			<?php endif; ?>

			<td scope="row" 
	        <?php if (i % 2 == 0): ?>
	            class="evenListRowS1" bgcolor="#fdfdfd" 
	        <?php else: ?>
	            class="oddListRowS1" bgcolor="#ffffff" 
	        <?php endif; ?>
	        align="left" bgcolor="#fdfdfd" valign="top"><span sugar="sugar0b">&nbsp;</span></td>
			
		</tr>
		<tr>
			<td colspan="20" class="listViewHRS1"></td>
		</tr>
		<!-- End of Course Listing -->
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