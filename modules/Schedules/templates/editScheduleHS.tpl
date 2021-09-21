<form method="post" name="frmScheduleHS" id="frmScheduleHS" action="index.php?module=Schedules&action=saveScheduleHS" >
<input type="hidden" name="schedID" id="schedID" value="{$schedID}" />
<input type="hidden" name="rstatus" id="rstatus" value="{$rstatus}" />
<input type="hidden" name="prevschedCode" id="prevschedCode" value="{$schedCode}" />
<input type="hidden" name="prevroom" id="prevroom" value="{$room}" />
<input type="hidden" name="prevschYear" id="prevschYear" value="{$schYear}" />
<input type="hidden" name="prevshh" id="prevshh" value="{$shh}" />
<input type="hidden" name="prevsmm" id="prevsmm" value="{$smm}" />
<input type="hidden" name="prevsamp" id="prevsamp" value="{$samp}" />
<input type="hidden" name="prevehh" id="prevehh" value="{$ehh}" />
<input type="hidden" name="prevemm" id="prevemm" value="{$emm}" />
<input type="hidden" name="preveamp" id="preveamp" value="{$eamp}" />
<input type="hidden" name="prevonMon" id="prevonMon" value="{$onMon}" />
<input type="hidden" name="prevonTue" id="prevonTue" value="{$onTue}" />
<input type="hidden" name="prevonWed" id="prevonWed" value="{$onWed}" />
<input type="hidden" name="prevonThu" id="prevonThu" value="{$onThu}" />
<input type="hidden" name="prevonFri" id="prevonFri" value="{$onFri}" />
<input type="hidden" name="prevonSat" id="prevonSat" value="{$onSat}" />
<input type="hidden" name="prevonSun" id="prevonSun" value="{$onSun}" />
<input type="hidden" name="noEnrolled" id="noEnrolled" value="{$noEnrolled}" />

<table width="100%" border="0">
  <tr>
    <td>
    <input class="button" name="cmdSave" type="button" id="cmdSave" value=" Save " onclick="validateTime();"/>
    <input class="button" name="cmdCancel" type="button" id="cmdCancel" value=" Cancel " onclick="history.back();" />
    </td>
    <td align="right" nowrap="nowrap"><span class="required">*</span> Indicates required field</td>
  </tr>
</table>  

<p>
<table class="tabForm" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td>
	    <table border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tr>
		        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel">Edit High School Schedule</h4></th>
		    </tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>School Year <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%"><slot>{$SCHOOLYEAR}</slot></td>
		   	</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Year Level <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%"><slot>{$YEARLEVEL}</slot></td>
			</tr>
			<tr><td class="dataLabel" colspan="2"> </td></tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Subject <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
			    		<select name="subjID" id="subjID" >
			            <option value="">----------------------------------------------------------------------------------------------</option>
			            {section name=i loop=$subject_list}
			            <option value="{$subject_list[i].subjID}" {if $subject_list[i].subjID eq $subjID} selected {/if}>{$subject_list[i].subjCode}{$subject_list[i].descTitle}{if $subject_list[i].type eq 2} (Lab){/if}</option>
			            {/section}
			            </select>
		        </slot>
			</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Teacher </slot></td>
		        <td class="dataField" width="82%">
		        <slot>
		    		<select name="profID" id="profID"  >
		            <option value="">----------------------------------------------------------------------------------------------</option>
		            {section name=i loop=$user_list}
		            <option value="{$user_list[i].id}" {if $user_list[i].id eq $profID}selected{/if}>{$user_list[i].last_name}, {$user_list[i].first_name}</option>
		            {/section}
		            </select>
		        </slot>
			</tr>
			<tr>
		        <td class="dataLabel" width="18%"><slot>Sched Code <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
					<input type="text" name="schedCode" id="schedCode" size="18" value="{$schedCode}" maxlength="10" onkeypress="return keyRestrict(event, 0);" />
		        </slot>
			</tr>
<!--			<tr>
		        <td class="dataLabel" width="18%"><slot>Max Capacity <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
					<input type="text" name="maxCapacity" id="maxCapacity" value="{$maxCapacity}" maxlength="5" size="7" onkeypress="return keyRestrict(event, 0);" />
		        </slot>
			</tr>
-->			<tr>
		        <td class="dataLabel" width="18%"><slot>Room <span class="required">*</span></slot></td>
		        <td class="dataField" width="82%">
		        <slot>
					<input type="text" name="room" id="room" value="{$room}" maxlength="10" size="7" onkeypress="return keyRestrict(event, 5);" />
		        </slot>
			</tr>
			<tr>
		        <td colspan="3" align="left" width="100%">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="dataLabel" width="18%"><slot>Start Time <span class="required">*</span></slot></td>
							<td class="dataField" width="6%"><slot>
								<select name="shh" id="shh" >
					            <option value="">--------</option>
					            <option value="1" {if $shh eq "1"} selected {/if}>1</option>
					            <option value="2" {if $shh eq "2"} selected {/if}>2</option>
					            <option value="3" {if $shh eq "3"} selected {/if}>3</option>
					            <option value="4" {if $shh eq "4"} selected {/if}>4</option>
					            <option value="5" {if $shh eq "5"} selected {/if}>5</option>
					            <option value="6" {if $shh eq "6"} selected {/if}>6</option>
					            <option value="7" {if $shh eq "7"} selected {/if}>7</option>
					            <option value="8" {if $shh eq "8"} selected {/if}>8</option>
					            <option value="9" {if $shh eq "9"} selected {/if}>9</option>
					            <option value="10" {if $shh eq "10"} selected {/if}>10</option>
					            <option value="11" {if $shh eq "11"} selected {/if}>11</option>
					            <option value="12" {if $shh eq "12"} selected {/if}>12</option>
					            </select>
							</slot></td>
							<td class="dataField" width="1%"><slot><b>: </b></slot></td>
							<td class="dataField" width="5%"><slot>
								<input type="text" name="smm" id="smm" size="6" value="{$smm}" maxlength="2" onkeypress="return keyRestrict(event, 0);" />
							</slot></td>
							<td class="dataField" width="70%"><slot>
								<select name="samp" id="samp" >
								<option value="">-----</option>
					            <option value="AM" {if $samp eq "AM"} selected {/if}>AM</option>
					            <option value="PM" {if $samp eq "PM"} selected {/if}>PM</option>
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
								<select name="ehh" id="ehh" >
					            <option value="">--------</option>
					            <option value="1" {if $ehh eq "1"} selected {/if}>1</option>
					            <option value="2" {if $ehh eq "2"} selected {/if}>2</option>
					            <option value="3" {if $ehh eq "3"} selected {/if}>3</option>
					            <option value="4" {if $ehh eq "4"} selected {/if}>4</option>
					            <option value="5" {if $ehh eq "5"} selected {/if}>5</option>
					            <option value="6" {if $ehh eq "6"} selected {/if}>6</option>
					            <option value="7" {if $ehh eq "7"} selected {/if}>7</option>
					            <option value="8" {if $ehh eq "8"} selected {/if}>8</option>
					            <option value="9" {if $ehh eq "9"} selected {/if}>9</option>
					            <option value="10" {if $ehh eq "10"} selected {/if}>10</option>
					            <option value="11" {if $ehh eq "11"} selected {/if}>11</option>
					            <option value="12" {if $ehh eq "12"} selected {/if}>12</option>
					            </select>
							</slot></td>
							<td class="dataField" width="1%"><slot><b>: </b></slot></td>
							<td class="dataField" width="5%"><slot>
								<input type="text" name="emm" id="emm" size="6" value="{$emm}" maxlength="2" onkeypress="return keyRestrict(event, 0);" />
							</slot></td>
							<td class="dataField" width="70%"><slot>
								<select name="eamp" id="eamp" >
								<option value="">-----</option>
					            <option value="AM" {if $eamp eq "AM"} selected {/if}>AM</option>
					            <option value="PM" {if $eamp eq "PM"} selected {/if}>PM</option>
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
		          <textarea name="remarks" id="remarks" cols="47"  onKeyPress="return limitLength(event,'remarks',150);">{$remarks}</textarea>
		          </label>
		        </slot></td>
			    </tr>
				<tr>
		        <td class="dataLabel" colspan="2">
		        	<fieldset><legend>Days </legend>
					<table border="0" cellpadding="0" cellspacing="0" width="600">
					<tr>
					<td class="dataLabel"><slot><label><input name="onMon" id="onMon" value="" type="checkbox" {if $onMon eq 1 } checked {/if} />Monday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onTue" id="onTue" value="" type="checkbox" {if $onTue eq 1 } checked {/if} />Tuesday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onWed" id="onWed" value="" type="checkbox" {if $onWed eq 1 } checked {/if} />Wednesday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onThu" id="onThu" value="" type="checkbox" {if $onThu eq 1 } checked {/if} />Thursday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onFri" id="onFri" value="" type="checkbox" {if $onFri eq 1 } checked {/if} />Friday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onSat" id="onSat" value="" type="checkbox" {if $onSat eq 1 } checked {/if} />Saturday</label></slot></td>
					<td class="dataLabel"><slot><label><input name="onSun" id="onSun" value="" type="checkbox" {if $onSun eq 1 } checked {/if} />Sunday</label></slot></td>
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