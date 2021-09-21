<?php /* Smarty version 2.6.11, created on 2008-12-26 08:18:27
         compiled from modules/Schedules/templates/createSchedule.tpl */ ?>
<form name="frmSchedule" id="frmSchedule" method="post" action="index.php?module=Schedules&action=saveSchedule">
<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="validateTime();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onClick="redirect('index.php?module=Schedules&action=listSchedules')" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td>
	    <table border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tr>
		        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Create College Schedule</h4></th>
		    </tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>School Year <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
			        <?php echo $this->_tpl_vars['SCHOOLYEAR']; ?>

		        </slot>
		        </td>
		   	</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Semester <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%"><slot><?php echo $this->_tpl_vars['SEMESTERS']; ?>
</slot>
		   	</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Year Level <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%"><slot><?php echo $this->_tpl_vars['YEARLEVEL']; ?>
</slot>
		        </td>
			</tr>
			<tr><td class="dataLabel" colspan="2"></td></tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Course <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
		        <select name="courseID" id="courseID" onchange="getCurriculums()" >
		        <option value="">------------------------------</option>    
		        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['course_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		        <option value="<?php echo $this->_tpl_vars['course_list'][$this->_sections['i']['index']]['courseID']; ?>
"><?php echo $this->_tpl_vars['course_list'][$this->_sections['i']['index']]['courseCode']; ?>
</option>
		        <?php endfor; endif; ?>
		        </select>
		        </slot>
		        </td>
			</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Curriculum <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
					<div id="divCurriculums">
			    		<select name="curID" id="curID"  onchange="getSubjects()">
			            <option value="">----------------------------------------------------------------------------------------------</option>
			            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['curriculum_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			            <option value="<?php echo $this->_tpl_vars['curriculum_list'][$this->_sections['i']['index']]['curID']; ?>
"><?php echo $this->_tpl_vars['curriculum_list'][$this->_sections['i']['index']]['curName']; ?>
 - <?php echo $this->_tpl_vars['curriculum_list'][$this->_sections['i']['index']]['major']; ?>
 </option>
			            <?php endfor; endif; ?>
			            </select>
			        </div>
		        </slot>
			</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Subject <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
					<div id="divSubjects">
			    		<select name="subjID" id="subjID" >
			            <option value="">----------------------------------------------------------------------------------------------</option>
			            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['subject_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			            <option value="<?php echo $this->_tpl_vars['subject_list'][$this->_sections['i']['index']]['curID']; ?>
"><?php echo $this->_tpl_vars['subject_list'][$this->_sections['i']['index']]['subjCode']; ?>
 <?php echo $this->_tpl_vars['subject_list'][$this->_sections['i']['index']]['descTitle']; ?>
 <?php if ($this->_tpl_vars['subject_list'][$this->_sections['i']['index']]['type'] == 2): ?> (Lab)<?php endif; ?></option>
			            <?php endfor; endif; ?>
			            </select>
			        </div>
		        </slot>
		        </td>
			</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Instructor </slot></td>
		        <td class="dataField" width="82%">
		        <slot>
		    		<select name="profID" id="profID"  >
		            <option value="">----------------------------------------------------------------------------------------------</option>
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
"><?php echo $this->_tpl_vars['user_list'][$this->_sections['i']['index']]['last_name']; ?>
, <?php echo $this->_tpl_vars['user_list'][$this->_sections['i']['index']]['first_name']; ?>
</option>
		            <?php endfor; endif; ?>
		            </select>
		        </slot>
			</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Sched Code <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
					<input type="text" name="schedCode" id="schedCode" size="18" maxlength="10" onkeypress="return keyRestrict(event, 0);" />
		        </slot>
			</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Max Capacity <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
					<input type="text" name="maxCapacity" id="maxCapacity" maxlength="5" size="7" onkeypress="return keyRestrict(event, 0);" />
		        </slot>
			</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Room <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
					<input type="text" name="room" id="room" maxlength="10" size="7" onkeypress="return keyRestrict(event, 5);" />
		        </slot>
			</tr>
			<tr>
		        <td colspan="3" align="left" width="100%">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="dataLabel" width="18%"><slot>Start Time <span class="required">*</span></slot></td>
							<td class="dataField" width="6%"><slot>
								<select name="shh" id="shh"  >
					            <option value="">--------</option>
					            <option value="1">1</option>
					            <option value="2">2</option>
					            <option value="3">3</option>
					            <option value="4">4</option>
					            <option value="5">5</option>
					            <option value="6">6</option>
					            <option value="7">7</option>
					            <option value="8">8</option>
					            <option value="9">9</option>
					            <option value="10">10</option>
					            <option value="11">11</option>
					            <option value="12">12</option>
					            </select>
							</slot></td>
							<td class="dataField" width="1%"><slot><b>: </b></slot></td>
							<td class="dataField" width="5%"><slot>
								<input type="text" name="smm" id="smm" size="6" value="00" maxlength="2" onkeypress="return keyRestrict(event, 0);" />
							</slot></td>
							<td class="dataField" width="70%"><slot>
								<select name="samp" id="samp"  >
								<option value="">-----</option>
					            <option value="AM">AM</option>
					            <option value="PM">PM</option>
					            </select>
							</slot></td>
						</tr>
						<tr>
							<td class="dataLabel" width="18%"><slot>&nbsp;</slot></td>
							<td class="dataField" width="6%"><slot>hh</slot></td>
							<td class="dataField" width="1%"><slot>&nbsp;</slot></td>
							<td class="dataField" width="5%"><slot>mm</slot></td>
							<td class="dataField" width="70%"><slot>am/pm</slot></td>
						</tr>
						<tr>
							<td class="dataLabel" width="18%"><slot>End Time <span class="required">*</span></slot></td>
							<td class="dataField" width="6%"><slot>
								<select name="ehh" id="ehh"  >
					            <option value="">--------</option>
					            <option value="1">1</option>
					            <option value="2">2</option>
					            <option value="3">3</option>
					            <option value="4">4</option>
					            <option value="5">5</option>
					            <option value="6">6</option>
					            <option value="7">7</option>
					            <option value="8">8</option>
					            <option value="9">9</option>
					            <option value="10">10</option>
					            <option value="11">11</option>
					            <option value="12">12</option>
					            </select>
							</slot></td>
							<td class="dataField" width="1%"><slot><b>: </b></slot></td>
							<td class="dataField" width="5%"><slot>
								<input type="text" name="emm" id="emm" size="6" maxlength="2" value="00" onkeypress="return keyRestrict(event, 0);" />
							</slot></td>
							<td class="dataField" width="70%"><slot>
								<select name="eamp" id="eamp"  >
								<option value="">-----</option>
					            <option value="AM">AM</option>
					            <option value="PM">PM</option>
					            </select>
							</slot></td>
						</tr>
						<tr>
							<td class="dataLabel" width="18%"><slot>&nbsp;</slot></td>
							<td class="dataField" width="6%"><slot>hh</slot></td>
							<td class="dataField" width="1%"><slot>&nbsp;</slot></td>
							<td class="dataField" width="5%"><slot>mm</slot></td>
							<td class="dataField" width="70%"><slot>am/pm</slot></td>
						</tr>
						<tr>
						</tr>
					</table>
				</tr>
			    <tr>
		        <td class="dataLabel" valign="top"><slot>Remarks </slot></td>
		        <td class="dataField"><slot>
		          <label>
		          <textarea name="remarks" id="remarks" cols="47"  onKeyPress="return limitLength(event,'remarks',150);"></textarea>
		          </label>
		        </slot></td>
			    </tr>
				<tr>
		        <td class="dataLabel" colspan="2">
		        	<fieldset><legend>Days </legend>
					<table border="0" cellpadding="0" cellspacing="0" width="600">
					<tr>
					<td class="dataLabel"><slot><label><input name="onMon" id="onMon" value="" type="checkbox" />Monday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onTue" id="onTue" value="" type="checkbox" />Tuesday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onWed" id="onWed" value="" type="checkbox" />Wednesday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onThu" id="onThu" value="" type="checkbox" />Thursday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onFri" id="onFri" value="" type="checkbox" />Friday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onSat" id="onSat" value="" type="checkbox" />Saturday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onSun" id="onSun" value="" type="checkbox" />Sunday</label></slot></td>
					</tr>
					</table>
					</fieldset>
				</td>
				</tr>
		    </table>
	</td></tr>
</table>
</p>
</form>