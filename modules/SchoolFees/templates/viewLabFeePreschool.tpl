<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=SchoolFees&action=listLabFeePreschool');" />
    
    {if $hasEdit eq 1 }
    	<input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=SchoolFees&action=editLabFeePreschool&schedID={$schedID}');" />
    {/if}
  </tr>
</table>  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
        <td class="tabDetailViewDL" width="18%"><slot>Sched Code :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$schedCode}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>School Year :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$schYear}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Year Level :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$yrLevel}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Subject :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$subjCode}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Instructor :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$profName} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Room :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$room}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Maximum Capacity :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$maxCapacity}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Number Enrolled :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$noEnrolled}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Start Time :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$startTime}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>EndTime :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$endTime}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Remarks :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$remarks}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Days :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$days}  &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Amount :</slot></td>
        <td class="tabDetailViewDF" width="82%"><slot>{$amount|number_format:2:".":","} &nbsp;</slot></td>
    </tr>
    </tr>
</table>
</p>