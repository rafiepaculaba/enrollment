{*
/*********************************************************************************
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
 ********************************************************************************/
/*********************************************************************************

 ********************************************************************************/
*}

{$ROLLOVERSTYLE}
<form  id="wizform" name="wizform" method="POST" action="index.php">
	<input type="hidden" name="module" value="Campaigns">
	<input type="hidden" name="record" value="{$ID}">
	<input type="hidden" id="action" name="action">
	<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
	<input type="hidden" name="return_id" value="{$RETURN_ID}">
	<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
	<input type='hidden' name='campaign_type' value="{$MOD.LBL_NEWSLETTER_FORENTRY}">
	<input type="hidden" id="wiz_total_steps" name="totalsteps" value="{$TOTAL_STEPS}">
	<input type="hidden" id="wiz_current_step" name="currentstep" value='1'>
	<input type="hidden" id="direction" name="wiz_direction" value='exit'>		

<p>
	<div id ='buttons'>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
				<td align="left" width='30%'>
					<table border="0" cellspacing="0" cellpadding="0" ><tr>
						<td><div id="back_button_div"><input id="wiz_back_button" type='button' title="{$APP.LBL_BACK}" class="button" onclick="javascript:navigate('back');"  name="back" value="  {$APP.LBL_BACK}"></div></td>
						<td><div id="cancel_button_div"><input id="wiz_cancel_button" title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value='WizardHome'; this.form.module.value='Campaigns'; this.form.record.value='{$RETURN_ID}';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}"></div></td>
						<td>
						<div id="save_button_div">
							<input id="wiz_submit_button" class="button" onclick="this.form.action.value='WizardNewsletterSave';this.form.direction.value='continue';gatherTrackers();"  accesKey="{$APP.LBL_SAVE_BUTTON_TITLE}" type="{$HIDE_CONTINUE}" name="button" value="{$MOD.LBL_SAVE_CONTINUE_BUTTON_LABEL}" ><input id="wiz_submit_finish_button" class="button" onclick="this.form.action.value='WizardNewsletterSave';this.form.direction.value='exit';gatherTrackers();"  accesKey="{$APP.LBL_SAVE_BUTTON_TITLE}" type="submit" name="button" value="{$MOD.LBL_SAVE_EXIT_BUTTON_LABEL}" >
						</div></td>
						<td><div id="next_button_div"><input id="wiz_next_button" type='button' title="{$APP.LBL_NEXT_BUTTON_LABEL}" class="button" onclick="javascript:navigate('next');" name="button" value="{$APP.LBL_NEXT_BUTTON_LABEL}"></div></td>
					</tr></table>
				</td>
				<td  align="right" width='70%'><div id='wiz_location_message'></td>
				
			</tr>
		</table>
	</div>
</p>
<table class='tabDetailView2' width="100%" border="0" cellspacing="1" cellpadding="0" >
<tr>
<td class='tabDetailViewDL2' rowspan='2' width=10%  style='vertical-align: top;' nowrap>
<div id='nav' >
{$NAV_ITEMS}

</div>

</td>
<td class='tabForm' rowspan='2' width='100%'>
<div id="wiz_message"></div>
<div id=wizard>

{$STEPS}


</div>
</td>
</tr>
</table>
</form>

<script type="text/javascript" src="include/javascript/popup_parent_helper.js?s={$SUGAR_VERSION}&c={$JS_CUSTOM_VERSION}"></script>
<script type="text/javascript" language="javascript" src="modules/Campaigns/wizard.js"></script>
<script type='text/javascript' src='include/javascript/overlibmws.js'></script>
<script type='text/javascript' src='include/javascript/overlibmws_iframe.js'></script>
<div id='overDiv' style='position:absolute; visibility:hidden; z-index:1000;'></div>

{$WIZ_JAVASCRIPT}
{$DIV_JAVASCRIPT}
{$JAVASCRIPT}
<script language="javascript">
{$HILITE_ALL}
</script>

