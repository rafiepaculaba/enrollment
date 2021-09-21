<p>
<ul class="tablist">
<li id="tab_li_Student_info">
<a id="tab_link_Student_info" href="index.php?module=Students&action=viewStudent&idno={$idno}">Student Profile</a>
</li>	
<li id="tab_li_TOR">
<a id="tab_link_TOR" href="index.php?module=Students&action=viewTOR&idno={$idno}">Transcript of Records</a>
</li>	
<li class="active" id="tab_li_Prospectus">
<a class="current" id="tab_link_Prospectus" href="index.php?module=Students&action=viewProspectus&idno={$idno}">Prospectus</a>
</li>	
</ul>
</p>

<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th colspan="5" align="left"><h4 class="tabDetailViewDL">Transcript of Records</h4></th>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>ID No. :</slot></td>
        <td class="tabDetailViewDF" width="80%" colspan="3"><slot>{$idno} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Student Name :</slot></td>
        <td class="tabDetailViewDF" colspan="3"><slot>{$name} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Course :</slot></td>
        <td class="tabDetailViewDF" colspan="3"><slot>{$courseName} &nbsp;</slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="20%"><slot>Curriculum :</slot></td>
        <td class="tabDetailViewDF" width="40%"><slot>{$curName} &nbsp;</slot></td>
        <td class="tabDetailViewDL"><slot>Major :</slot></td>
        <td class="tabDetailViewDF"><slot>{$major} &nbsp;</slot></td>
    </tr>
</table>   
</p>

<table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr height="20">
		<td scope="col" class="listViewThS1" width="10%" nowrap>Subject</td>
		<td scope="col" class="listViewThS1" width="50%" nowrap>Descriptive Title</td>
		<td scope="col" class="listViewThS1" width="10%" nowrap>Units</td>
		<td scope="col" class="listViewThS1" width="30%" nowrap>Prerequisites</td>
	</tr>
</tbody>
</table>

{if $subj11_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div11Handle" onclick="hideShowDiv('div11');" />&nbsp; 1<sup>st</sup> Year Level - 1<sup>st</sup> Semester</h4></th>
    </tr>
</table>
<div id="div11" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj11}
	<!-- Start of registrant Listing -->
<!--	r onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');"-->
	<tr height="20">
		<td scope="row"  class="{$subj11_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj11[i].subjCode}</td>
		
		<td scope="row" class="{$subj11_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj11[i].descTitle}</td>
		
		<td scope="row" class="{$subj11_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj11[i].units}</td>
		
		<td scope="row" class="{$subj11_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj11[i].prerequisites}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj11_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}

{if $subj12_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div12Handle" onclick="hideShowDiv('div12');" />&nbsp; 1<sup>st</sup> Year Level - 2<sup>nd</sup> Semester</h4></th>
    </tr>
</table>
<div id="div12" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj12}
	<!-- Start of registrant Listing -->
	<tr height="20">
		<td scope="row"  class="{$subj12_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj12[i].subjCode}</td>
		
		<td scope="row" class="{$subj12_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj12[i].descTitle}</td>
		
		<td scope="row" class="{$subj12_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj12[i].units}</td>
		
		<td scope="row" class="{$subj12_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj12[i].prerequisites}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj12_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}

{if $subj14_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div14Handle" onclick="hideShowDiv('div14');" />&nbsp; 1<sup>st</sup> Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div14" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj14}
	<!-- Start of registrant Listing -->
	<tr height="20">
		<td scope="row"  class="{$subj14_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj14[i].subjCode}</td>
		
		<td scope="row" class="{$subj14_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj14[i].descTitle}</td>
		
		<td scope="row" class="{$subj14_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj14[i].units}</td>
		
		<td scope="row" class="{$subj14_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj14[i].prerequisites}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj14_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}

{if $subj21_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div21Handle" onclick="hideShowDiv('div21');" />&nbsp; 2<sup>nd</sup> Year Level - 1<sup>st</sup> Semester</h4></th>
    </tr>
</table>
<div id="div21" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj21}
	<!-- Start of registrant Listing -->
	<tr height="20">
		<td scope="row"  class="{$subj21_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj21[i].subjCode}</td>
		
		<td scope="row" class="{$subj21_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj21[i].descTitle}</td>
		
		<td scope="row" class="{$subj21_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj21[i].units}</td>
		
		<td scope="row" class="{$subj21_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj21[i].prerequisites}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj21_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}

{if $subj22_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div22Handle" onclick="hideShowDiv('div22');" />&nbsp; 2<sup>nd</sup> Year Level - 2<sup>nd</sup> Semester</h4></th>
    </tr>
</table>
<div id="div22" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj22}
	<!-- Start of registrant Listing -->
	<tr height="20">
		<td scope="row"  class="{$subj22_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj22[i].subjCode}</td>
		
		<td scope="row" class="{$subj22_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj22[i].descTitle}</td>
		
		<td scope="row" class="{$subj22_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj22[i].units}</td>
		
		<td scope="row" class="{$subj22_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj22[i].prerequisites}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj22_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}

{if $subj24_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div24Handle" onclick="hideShowDiv('div24');" />&nbsp; 2<sup>nd</sup> Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div24" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj24}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj24[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj24[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj24[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj24[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj24_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}


{if $subj31_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div31Handle" onclick="hideShowDiv('div31');" />&nbsp; 3<sup>rd</sup> Year Level - 1<sup>st</sup> Semester</h4></th>
    </tr>
</table>
<div id="div31" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj31}
	<!-- Start of registrant Listing -->
	<tr height="20">
		<td scope="row"  class="{$subj31_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj31[i].subjCode}</td>
		
		<td scope="row" class="{$subj31_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj31[i].descTitle}</td>
		
		<td scope="row" class="{$subj31_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj31[i].units}</td>
		
		<td scope="row" class="{$subj31_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj31[i].prerequisites}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj31_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}


{if $subj32_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div32Handle" onclick="hideShowDiv('div32');" />&nbsp; 3<sup>rd</sup> Year Level - 2<sup>nd</sup> Semester</h4></th>
    </tr>
</table>
<div id="div32" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj32}
	<!-- Start of registrant Listing -->
	<tr height="20">
		<td scope="row"  class="{$subj32_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj32[i].subjCode}</td>
		
		<td scope="row" class="{$subj32_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj32[i].descTitle}</td>
		
		<td scope="row" class="{$subj32_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj32[i].units}</td>
		
		<td scope="row" class="{$subj32_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj32[i].prerequisites}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj32_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}


{if $subj34_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div34Handle" onclick="hideShowDiv('div34');" />&nbsp; 3<sup>rd</sup> Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div34" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj34}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj34[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj34[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj34[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj34[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj34_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}


{if $subj41_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div41Handle" onclick="hideShowDiv('div41');" />&nbsp; 4<sup>th</sup> Year Level - 1<sup>st</sup> Semester</h4></th>
    </tr>
</table>
<div id="div41" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj41}
	<!-- Start of registrant Listing -->
	<tr height="20">
		<td scope="row"  class="{$subj41_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj41[i].subjCode}</td>
		
		<td scope="row" class="{$subj41_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj41[i].descTitle}</td>
		
		<td scope="row" class="{$subj41_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj41[i].units}</td>
		
		<td scope="row" class="{$subj41_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj41[i].prerequisites}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj41_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}


{if $subj42_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div42Handle" onclick="hideShowDiv('div42');" />&nbsp; 4<sup>th</sup> Year Level - 2<sup>nd</sup> Semester</h4></th>
    </tr>
</table>
<div id="div42" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj42}
	<!-- Start of registrant Listing -->
	<tr height="20">
		<td scope="row"  class="{$subj42_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj42[i].subjCode}</td>
		
		<td scope="row" class="{$subj42_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj42[i].descTitle}</td>
		
		<td scope="row" class="{$subj42_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj42[i].units}</td>
		
		<td scope="row" class="{$subj42_legend[i]}"
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj42[i].prerequisites}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj42_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}


{if $subj44_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div44Handle" onclick="hideShowDiv('div44');" />&nbsp; 4<sup>th</sup> Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div44" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj44}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj44[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj44[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj44[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj44[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj44_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}


{if $subj51_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div51Handle" onclick="hideShowDiv('div51');" />&nbsp; 5<sup>th</sup> Year Level - 1<sup>st</sup> Semester</h4></th>
    </tr>
</table>
<div id="div51" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj51}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj51[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj51[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj51[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj51[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj51_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}


{if $subj52_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div52Handle" onclick="hideShowDiv('div52');" />&nbsp; 5<sup>th</sup> Year Level - 2<sup>nd</sup> Semester</h4></th>
    </tr>
</table>
<div id="div52" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj52}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj52[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj52[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj52[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj52[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj52_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}


{if $subj54_ctr gt 0}
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th class="dataField" colspan="2" align="left"><h4 class="dataLabel"><img src="themes/Sugar/images/basic_search.gif" id="div54Handle" onclick="hideShowDiv('div54');" />&nbsp; 5<sup>th</sup> Year Level - Summer</h4></th>
    </tr>
</table>
<div id="div54" style="display:block">
    <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
    {section name=i loop=$subj54}
	<!-- Start of registrant Listing -->
	<tr onmouseover="setPointer(this, '0', 'over', '#fdfdfd', '#DEEFFF', '');" onmouseout="setPointer(this, '1', 'out', '#fdfdfd', '#DEEFFF', '');" onmousedown="setPointer(this, '0', 'click', '#fdfdfd', '#DEEFFF', '');" height="20">
		<td scope="row" 
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj54[i].subjCode}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="50%">{$subj54[i].descTitle}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="10%">{$subj54[i].units}</td>
		
		<td scope="row"
        {if i%2 eq 0}
            class="evenListRowS1" bgcolor="#fdfdfd" 
        {else}
            class="oddListRowS1" bgcolor="#ffffff" 
        {/if}
        align="left" bgcolor="#fdfdfd" valign="top" width="30%">{$subj54[i].prerequisites} &nbsp;</td>
		
	</tr>
	<tr>
		<td colspan="20" class="listViewHRS1"></td>
	</tr>
	<!-- End of registrant Listing -->
	{/section}
	<tr height="20">
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="10%">&nbsp;</td>
		<td scope="row" class="evenListRowS1" align="right" bgcolor="#fdfdfd" valign="top" width="50%"><b>Total</b></td>
		<td scope="row" class="evenListRowS1" align="left" bgcolor="#fdfdfd" valign="top" width="10%"><b>{$subj54_total|number_format:1:".":","}</b></td>
		<td scope="row" align="left" bgcolor="#fdfdfd" valign="top" width="30%">&nbsp;</td>
	</tr>
	</tbody></table>
</div>
{/if}

</br>
<table class="listView2" border="0" cellpadding="0" cellspacing="0" width="300" align="right">
<tbody>
    <tr>
        <th colspan="2" align="left"><h4 class="tabDetailViewDL">Legend</h4></th>
    </tr>
    <tr>
		<td align="right">
		    <img src="themes/Sugar/colors.green.icon.gif" alt="green" style="margin: 0pt 3px;" border="0">
		</td>
		<td nowrap > Taken subject(s) </td>
	</tr>
	<tr>
		<td colspan="2" class="listViewHRS1"></td>
	</tr>
	<tr>
		<td align="right">
    		<img src="themes/Sugar/colors.ocher.icon.gif" alt="ocher" style="margin: 0pt 3px;" border="0">
		</td>
		<td nowrap > Currently enroll subject(s) </td>
	</tr>
	<tr>
		<td colspan="2" class="listViewHRS1"></td>
	</tr>
	<tr>
		<td align="right">
    		<img src="themes/Sugar/colors.sugar.icon.gif" alt="ocher" style="margin: 0pt 3px;" border="0">
		</td>
		<td nowrap > Not yet taken subject(s) </td>
	</tr>
</tbody>
</table>
