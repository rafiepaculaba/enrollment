<?php /* Smarty version 2.6.11, created on 2008-12-15 03:09:33
         compiled from modules/Home/templates/dashboardCol.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'modules/Home/templates/dashboardCol.tpl', 144, false),)), $this); ?>
<table border="0" cellpadding="0" cellspacing="0" width="700">
<tr>
    <td align="left" width="50%" valign="top">
        <h3><img src="themes/Sugar/images/Dashboard.gif" alt="Current Enrollment" border="0">&nbsp;Current Enrollment</h3>
        <table class="listView2" border="0" cellpadding="0" cellspacing="0"  width="300">
        <tr>
            <td class="evenListRowS1"><slot>School Year : </slot> </td>
            <td class="evenListRowS1"><slot><b><?php echo $this->_tpl_vars['schYear']; ?>
 </b></slot> </td>
        </tr>
        <tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
        <tr>
            <td class="evenListRowS1"><slot>Semester : </slot> </td>
            <td class="evenListRowS1"><slot><b><?php echo $this->_tpl_vars['semCode']; ?>
</b> </slot> </td>
        </tr>
        <tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
        <tr>
            <td class="evenListRowS1"><slot>Date : </slot> </td>
            <td class="evenListRowS1"><slot><b><?php  echo date("l dS F, Y", time());  ?></b> </slot> </td>
        </tr>
        </table>
    </td>
    <td align="left" width="50%" valign="top">
        <h3><img src="themes/Sugar/images/OfflineClient.gif" alt="Overall Enrollment" border="0">&nbsp;Enrollment Information at a glance</h3>
        <table class="listView2" border="0" cellpadding="0" cellspacing="0"  width="300">
        <tr>
            <td class="evenListRowS1"><slot>Overall Total Enrollment : </slot> </td>
            <td class="evenListRowS1"><slot><b><?php echo $this->_tpl_vars['overall']; ?>
</b> </slot> </td>
        </tr>
        </table>
    </td>
</tr>
<tr>
    <td colspan="2" valign="top">
    <br>
    <h3><img src="themes/Sugar/images/view_status.gif" alt="Enrollment Status" border="0">&nbsp;Enrollment Status</h3>
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    		<tr height="20">
    			<td scope="col" class="listViewThS1" nowrap>Course </td>
    			<td scope="col" class="listViewThS1" nowrap>1 </td>
    			<td scope="col" class="listViewThS1" nowrap>2 </td>
    			<td scope="col" class="listViewThS1" nowrap>3 </td>
    			<td scope="col" class="listViewThS1" nowrap>4 </td>
    			<td scope="col" class="listViewThS1" nowrap>5 </td>
    			<td scope="col" class="listViewThS1" nowrap>Total </td>
    		</tr>
    		
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
    		<!-- Start of registrant Listing -->
    			<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
    				
    				<td scope="row"
    		        <?php if (i % 2 == 0): ?>
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        <?php else: ?>
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        <?php endif; ?>
    		        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['courseCode']; ?>
&nbsp;</td>
    				
    				<td scope="row"
    		        <?php if (i % 2 == 0): ?>
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        <?php else: ?>
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        <?php endif; ?>
    		        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['1']; ?>
&nbsp;</td>
    				
    				<td scope="row"
    		        <?php if (i % 2 == 0): ?>
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        <?php else: ?>
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        <?php endif; ?>
    		        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['2']; ?>
&nbsp;</td>
    		
    				<td scope="row"
    		        <?php if (i % 2 == 0): ?>
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        <?php else: ?>
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        <?php endif; ?>
    		        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['3']; ?>
&nbsp;</td>
    		
    				<td scope="row"
    		        <?php if (i % 2 == 0): ?>
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        <?php else: ?>
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        <?php endif; ?>
    		        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['4']; ?>
&nbsp;</td>
    				
    				<td scope="row"
    		        <?php if (i % 2 == 0): ?>
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        <?php else: ?>
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        <?php endif; ?>
    		        align="left" bgcolor="#fdfdfd" valign="top"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['5']; ?>
&nbsp;</td>
    				
    				<td scope="row"
    		        <?php if (i % 2 == 0): ?>
    		            class="evenListRowS1" bgcolor="#fdfdfd" 
    		        <?php else: ?>
    		            class="oddListRowS1" bgcolor="#ffffff" 
    		        <?php endif; ?>
    		        align="left" bgcolor="#fdfdfd" valign="top"><b><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['total']; ?>
</b>&nbsp;</td>
    				
    			</tr>
    			<tr>
    				<td colspan="20" class="listViewHRS1"></td>
    			</tr>
    		<!-- End of registrant Listing -->
    		<?php endfor; endif; ?>
    		<tr>
    			<td colspan="20" class="listViewHRS1"></td>
    		</tr>
    		
    		<tr height="20">
    		    <td scope="col" class="evenListRowS1" nowrap align="left"><b>Grand Total: </b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b><?php echo $this->_tpl_vars['grand']['1']; ?>
</b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b><?php echo $this->_tpl_vars['grand']['2']; ?>
</b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b><?php echo $this->_tpl_vars['grand']['3']; ?>
</b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b><?php echo $this->_tpl_vars['grand']['4']; ?>
</b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b><?php echo $this->_tpl_vars['grand']['5']; ?>
</b></td>
    			<td scope="col" class="evenListRowS1" nowrap><b><?php echo $this->_tpl_vars['grand']['total']; ?>
</b></td>
    		</tr>
    </tbody>
    </table>
    <br>
    </td>
</tr>
<?php if ($this->_tpl_vars['isAdmin'] == 1): ?>
<tr>
    <td align="left" width="50%" valign="top">
        
        <h3><img src="themes/Sugar/images/Meetings.gif" alt="Enrollment Status" border="0">&nbsp;Stats</h3>
        <table class="listView2" border="0" cellpadding="0" cellspacing="0" width="300">
        <tr>
            <td class="evenListRowS1"><slot>Withdraw Enrollments : </slot> </td>
            <td class="evenListRowS1"><slot><b><?php echo ((is_array($_tmp=$this->_tpl_vars['ttl_withdrawals'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0) : number_format($_tmp, 0)); ?>
</b> </slot> </td>
        </tr>
        <tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
        <tr>
            <td class="evenListRowS1"><slot>New Students/Transferees : </slot> </td>
            <td class="evenListRowS1"><slot><b><?php echo ((is_array($_tmp=$this->_tpl_vars['ttl_new'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0) : number_format($_tmp, 0)); ?>
</b> </slot> </td>
        </tr>
        </table>
    </td>
    <td align="left" width="50%" valign="top">
        <h3><img src="themes/Sugar/images/PatchUpgrades.gif" alt="Enrollment Courses Rank" border="0">&nbsp;Top 3 Courses by population</h3>
        <table class="listView2" border="0" cellpadding="0" cellspacing="0" width="300">
        <tr height="20">
    		<td scope="col" class="listViewThS1" nowrap>Rank</td>
    		<td scope="col" class="listViewThS1" nowrap>Course</td>
    		<td scope="col" class="listViewThS1" nowrap>Enrollments </td>
    	</tr>
    	<?php $rank=1; ?>
    	<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['top_rank']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <tr>
            <td class="evenListRowS1"><slot><?php echo $rank++; ?> </slot> </td>
            <td class="evenListRowS1"><slot><?php echo $this->_tpl_vars['top_rank'][$this->_sections['i']['index']]['courseCode']; ?>
 </slot> </td>
            <td class="evenListRowS1"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['top_rank'][$this->_sections['i']['index']]['total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0) : number_format($_tmp, 0)); ?>
 </slot> </td>
        </tr>
        <tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
    	<?php endfor; endif; ?>
        </table>
    </td>
</tr>
<tr>
    <td align="left" width="50%" valign="top">
        <h3><img src="themes/Sugar/images/Price_List.gif" alt="Total Collection" border="0">&nbsp;Total Collection</h3>
        <table class="listView2" border="0" cellpadding="0" cellspacing="0" width="300">
        <tr height="20">
    		<td scope="col" class="listViewThS1" nowrap>Term</td>
    		<td scope="col" class="listViewThS1" nowrap><div align="right">Collection</div> </td>
    	</tr>
        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['collection']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <tr>
            <td class="evenListRowS1"><slot><?php echo $this->_tpl_vars['collection'][$this->_sections['i']['index']]['term']; ?>
 </slot> </td>
            <td class="evenListRowS1" align="right"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['collection'][$this->_sections['i']['index']]['ttl'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 </slot> </td>
        </tr>
        <tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
    	<?php endfor; endif; ?>
    	<tr>
    		<td colspan="20" class="listViewHRS1"></td>
    	</tr>
        <tr>
            <td class="evenListRowS1"><slot><b>Total :</b></slot> </td>
            <td class="evenListRowS1" align="right"><slot><b> Php&nbsp;&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['collection_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</b> </slot> </td>
        </tr>
        </table>
    </td>
    <td align="left" width="50%" valign="top">
        &nbsp;
    </td>
</tr>
<?php endif; ?>
</table>
