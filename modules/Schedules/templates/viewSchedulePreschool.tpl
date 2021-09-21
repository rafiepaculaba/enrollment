<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Schedules&action=listSchedulesPreschool');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Schedules&action=editSchedulePreschool&schedID={$schedID}');" />
    {/if}
        
    {if $hasDelete eq 1 }
	<input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteSchedule('{$schedID}');" />
    {/if}
  </tr>
</table>  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<th class="tabDetailViewDL" align="left" colspan="2" ><slot> <h4 class="tabDetailViewDL"> Status  {if $rstatus eq 1} <font> (Open) </font>{/if} {if $rstatus eq 0} <font color="Red"> (Closed) </font>{/if} </h4></slot></th>    
	<tr>
        <td class="tabDetailViewDL" width="18%"><slot>Sched Code :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$schedCode} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$schYear} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Grade Level :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$yrLevel} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Subject :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$subjCode} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Teacher :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$profName} &nbsp;</slot></td>
    </tr>
<!--    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Maximum Capacity :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$maxCapacity} &nbsp;</slot></td>
    </tr>
-->    <tr>
        <td class="tabDetailViewDL" width="18%"><slot># Enrolled :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$noEnrolled}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Room :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$room} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Start Time :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$startTime} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>EndTime :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$endTime} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Remarks :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$remarks} &nbsp;</slot></td>
    </tr>
   <tr>
   <td class="tabDetailViewDL" colspan="2"><slot>
    	<fieldset><legend>Days </legend>
		<table border="0" cellpadding="0" cellspacing="0" width="600">
		<tr>
		<td class="dataLabel"><input name="onMon" id="onMon" value="" type="checkbox" {if $onMon eq 1 } checked {/if} disabled/><slot>Monday</slot></td>
		<td class="dataLabel"><input name="onTue" id="onTue" value="" type="checkbox" {if $onTue eq 1 } checked {/if} disabled/><slot>Tuesday</slot></td>
		<td class="dataLabel"><input name="onWed" id="onWed" value="" type="checkbox" {if $onWed eq 1 } checked {/if} disabled/><slot>Wednesday</slot></td>
		<td class="dataLabel"><input name="onThu" id="onThu" value="" type="checkbox" {if $onThu eq 1 } checked {/if} disabled/><slot>Thursday</slot></td>
		<td class="dataLabel"><input name="onFri" id="onFri" value="" type="checkbox" {if $onFri eq 1 } checked {/if} disabled/><slot>Friday</slot></td>
		<td class="dataLabel"><input name="onSat" id="onSat" value="" type="checkbox" {if $onSat eq 1 } checked {/if} disabled/><slot>Saturday</slot></td>
		<td class="dataLabel"><input name="onSun" id="onSun" value="" type="checkbox" {if $onSun eq 1 } checked {/if} disabled/><slot>Sunday</slot></td>
		</tr>
		</table>
		</fieldset>
	</slot></td>
    </tr>
</table>
</p>