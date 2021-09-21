{*
/**
 * The contents of this file are subject to the SugarCRM Public License Version
 * 1.1.3 ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.  See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *    (i) the "Powered by SugarCRM" logo and
 *    (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * The Original Code is: SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) 2004-2006 SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 */
 
*}

<table id='fileviewtable'>
	<tr height='20'>
		{counter start=0 name="colCounter" print=false assign="colCounter"}
		<td scope='col' width='5' class='listViewThS1' nowrap>view/hide</td>
		{foreach from=$displayColumns key=colHeader item=params}
			{if $params.show}
			<td scope='col' width='{$params.width}%' class='listViewThS1' nowrap>
				<span sugar="sugar{$colCounter}"><div style='white-space: nowrap;'width='100%' align='{$params.align|default:'left'}'>
					{sugar_translate label=$params.label module='Administration'}
				</div></span sugar='sugar{$colCounter}'>
			</td>
			{/if}
				{counter name="colCounter"}
		{/foreach}
		<td scope='col' width='5' class='listViewThS1' nowrap>Select</td>
	</tr>
		{foreach name=rowIteration from=$data key=package_id item=package}
		{if $smarty.foreach.rowIteration.iteration is odd}
			{assign var='_bgColor' value=$bgColor[0]}
			{assign var='_rowColor' value=$rowColor[0]}
		{else}
			{assign var='_bgColor' value=$bgColor[1]}
			{assign var='_rowColor' value=$rowColor[1]}
		{/if}

			<tr id='package_tr_{$package_id}' height='20' onmouseover="setPointer(this, '{$package_id}', 'over', '{$_bgColor}', '{$bgHilite}', '');" onmouseout="setPointer(this, '{$package[$params.id]|default:$package.package_id}', 'out', '{$_bgColor}', '{$bgHilite}', '');" onmousedown="setPointer(this, '{$package_id}', 'click', '{$_bgColor}', '{$bgHilite}', '');">
			<td scope='row' align='left' valign=top class='{$_rowColor}S1' bgcolor='{$_bgColor}'><a class="listViewTdToolsS1" onclick="PackageManager.toggle_div('{$package_id}')" valign=top class='{$_rowColor}S1' bgcolor='{$_bgColor}'><span id='span_toggle_package_{$package_id}'><img src='{$imagePath}advanced_search.gif' width='8' height='8' alt='Advanced' border='0'>&nbsp;</span></a></td>
			{counter start=0 name="colCounter" print=false assign="colCounter"}
			{foreach from=$displayColumns key=col item=params}
				<td scope='row' align='{$params.align|default:'left'}' valign=top class='{$_rowColor}S1' bgcolor='{$_bgColor}'><span sugar="sugar{$colCounter}b">
					{if $params.show}
					{$package.$col}
					{/if}
				</span sugar='sugar{$colCounter}b'>
				</td>
				{counter name="colCounter"}
			{/foreach}
			<td scope='row' align='left' valign=top class='{$_rowColor}S1' bgcolor='{$_bgColor}'><a class="listViewTdToolsS1" onclick="PackageManager.select_package('{$package_id}')" valign=top class='{$_rowColor}S1' bgcolor='{$_bgColor}'>Select</a></td>
	    	</tr>
	    	<tr><td colspan="5"><table id='release_table_{$package_id}' style='display:none'>
	    	{foreach name=releaseIteration from=$package.releases key=release_id item=release}
		    	<tr id='release_tr_{$release_id}' height='20' onmouseover="setPointer(this, '{$release_id}', 'over', '{$_bgColor}', '{$bgHilite}', '');" onmouseout="setPointer(this, '{$release.release_id}', 'out', '{$_bgColor}', '{$bgHilite}', '');" onmousedown="setPointer(this, '{$release_id}', 'click', '{$_bgColor}', '{$bgHilite}', '');">
				{counter start=0 name="colCounter" print=false assign="colCounter"}
				{foreach from=$secondaryDisplayColumns key=col item=params}
					<td scope='row' align='{$params.align|default:'left'}' valign=top class='{$_rowColor}S1' bgcolor='{$_bgColor}'><span sugar="sugar{$colCounter}b">
						{$release.$col}
					</span sugar='sugar{$colCounter}b'>
					</td>
					{counter name="colCounter"}
				{/foreach}
				<td scope='row' align='left' valign=top class='{$_rowColor}S1' bgcolor='{$_bgColor}'><a class="listViewTdToolsS1" onclick="PackageManager.select_release('{$release_id}')" valign=top class='{$_rowColor}S1' bgcolor='{$_bgColor}'>Select</a></td>
		    	</tr>
		    {/foreach}
		    </table></td></tr>
	 	<tr><td colspan='20' class='listViewHRS1'></td></tr>
	{/foreach}
	
</table>
