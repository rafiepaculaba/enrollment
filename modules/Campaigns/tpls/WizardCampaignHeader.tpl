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

	<!-- Begin Campaign Diagnostic Link -->	
	{$CAMPAIGN_DIAGNOSTIC_LINK}
	<!-- End Campaign Diagnostic Link -->
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td  colspan="3"><h3>{$MOD.LBL_WIZ_NEWSLETTER_TITLE_STEP1} </h3></div></td>
		<td colspan="1">&nbsp;</td>
		</tr>
		<tr><td class="datalabel" colspan="3">{$MOD.LBL_WIZARD_HEADER_MESSAGE}<br></td><td>&nbsp;</td></tr>
		<tr><td class="datalabel" colspan="4">&nbsp;</td></tr>
		<tr>
		<td width="17%" class="dataLabel"><span sugar='slot1'>{$MOD.LBL_NAME} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span sugar='slot'></td>
		<td width="33%" class="dataField"><span sugar='slot1b'><input id='name' name='wiz_step1_name' title='{$MOD.LBL_NAME}' {$DISABLED} tabindex='1' size='50' maxlength='50' type="text" value="{$CAMP_NAME}" ></span sugar='slot'></td>
		<td width="15%" class="dataLabel"><span sugar='slot2'>{$APP.LBL_ASSIGNED_TO}</span sugar='slot'></td>
		<td width="35%" class="dataField"><span sugar='slot2b'><input class="sqsEnabled" tabindex="2" autocomplete="off" id="assigned_user_name" name="wiz_step1_assigned_user_name"  title='{$APP.LBL_ASSIGNED_TO}' type="text" value="{$ASSIGNED_USER_NAME}"><input id='assigned_user_id' name='wiz_step1_assigned_user_id' type="hidden" value="{$ASSIGNED_USER_ID}" />
		<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" accessKey="{$APP.LBL_SELECT_BUTTON_KEY}" type="button" tabindex='2' class="button" value='{$APP.LBL_SELECT_BUTTON_LABEL}' name=btn1
				onclick='open_popup("Users", 600, 400, "", true, false, {$encoded_users_popup_request_data});' /></span sugar='slot'>
		</td>
		</tr>
		<tr>
		<td width="15%" class="dataLabel"><span sugar='slot3'>{$MOD.LBL_CAMPAIGN_STATUS} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span sugar='slot'></td>
		<td width="35%" class="dataField"><span sugar='slot3b'><select tabindex='1' id='status' name='wiz_step1_status' title='{$MOD.LBL_CAMPAIGN_STATUS}'>{$STATUS_OPTIONS}</select></span sugar='slot'></td>







		</tr>
		<tr>
		<td class="dataLabel"><span sugar='slot5'>{$MOD.LBL_CAMPAIGN_START_DATE} </span sugar='slot'></td>
		<td class="dataField"><span sugar='slot5b'><input id='start_date' name='wiz_step1_start_date' title='{$MOD.LBL_CAMPAIGN_START_DATE}' onblur="parseDate(this, '{$CALENDAR_DATEFORMAT}');"  type="text" tabindex='1' size='11' maxlength='10' value="{$CAMP_START_DATE}"> <img src="themes/{$THEME}/images/jscalendar.gif" alt="{$APP.LBL_ENTER_DATE}" id="start_date_trigger" align="absmiddle"> <span class="dateFormat">{$USER_DATEFORMAT}</span></span sugar='slot'></td>
		<td class="dataLabel"><span sugar='slot6'>{$MOD.LBL_CAMPAIGN_TYPE} </td>
		<td><span sugar='slot6b'><{$SHOULD_TYPE_BE_DISABLED} id='campaign_type' title='{$MOD.LBL_CAMPAIGN_TYPE}' name='wiz_step1_campaign_type' >{$CAMPAIGN_TYPE_OPTIONS}</select></span sugar='slot'></td>
		</tr>
		<tr>
		<td class="dataLabel"><span sugar='slot7'>{$MOD.LBL_CAMPAIGN_END_DATE} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span sugar='slot'></td>
		<td class="dataField"><span sugar='slot7b'><input id='end_date' name='wiz_step1_end_date' title='{$MOD.LBL_CAMPAIGN_END_DATE}' onblur="parseDate(this, '{$CALENDAR_DATEFORMAT}');"  type="text" tabindex='1' size='11' maxlength='10' value="{$CAMP_END_DATE}"> <img src="themes/{$THEME}/images/jscalendar.gif" alt="{$APP.LBL_ENTER_DATE}" id="end_date_trigger" align="absmiddle"> <span class="dateFormat">{$USER_DATEFORMAT}</span></span sugar='slot'></td>
		<td class="dataLabel"><span sugar='slot8'>{$FREQUENCY_LABEL} </span sugar='slot'></td>
		<td><span sugar='slot8b'><{$HIDE_FREQUENCY_IF_NEWSLETTER} tabindex='1' id='frequency' name='wiz_step1_frequency' title='{$MOD.LBL_CAMPAIGN_FREQUENCY}'>{$FREQ_OPTIONS}</select></span sugar='slot'></td>
		</tr>
		<tr>
		<td width="15%" class="dataLabel"><span sugar='slot9'>&nbsp;</span></span sugar='slot'></td>
		<td width="35%" class="dataField"><span sugar='slot9b'>&nbsp;</span sugar='slot'></td>
		<td class="dataLabel"><span sugar='slot10'>&nbsp;</span sugar='slot'></td>
		<td><span sugar='slot10b'>&nbsp;</span sugar='slot'></td>
		<tr>
		</tr>
		<td valign="top" class="dataLabel"><span sugar='slot10'>{$MOD.LBL_CAMPAIGN_CONTENT}</span sugar='slot'></td>
		<td colspan="4"><span sugar='slot10a'><textarea id='content' name='wiz_step1_content' title='{$MOD.LBL_CAMPAIGN_CONTENT}' tabindex='3' cols="110" rows="5">{$CONTENT}</textarea></span sugar='slot'></td>
		</tr>
		<tr>
		<td class="dataLabel">&nbsp;</td>
		<td>&nbsp;</td>
		<td class="dataLabel">&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
	</table><p>

	{literal}
	<script type="text/javascript">
		Calendar.setup ({{/literal}
			inputField : "start_date", ifFormat : "{$CALENDAR_DATEFORMAT}", showsTime : false, button : "start_date_trigger", singleClick : true, step : 1
			{literal}
		});
		
		Calendar.setup ({{/literal}
			inputField : "end_date", ifFormat : "{$CALENDAR_DATEFORMAT}", showsTime : false, button : "end_date_trigger", singleClick : true, step : 2
		{literal}
		});
	

    /*
     * this is the custom validation script that will validate the fields on step1 of wizard
     */
    
    function validate_step1(){
        //loop through and check for empty strings ('  ')
        requiredTxt = SUGAR.language.get('app_strings', 'ERR_MISSING_REQUIRED_FIELDS');
        var stepname = 'wiz_step_1_';
        var has_error = 0;
        var fields = new Array();
        fields[0] = 'name'; 
        fields[1] = 'status';
        fields[2] = 'end_date';



        
        var field_value = ''; 
        for (i=0; i < fields.length; i++){
            if(document.getElementById(fields[i]) !=null){
                field_value = trim(document.getElementById(fields[i]).value);
                if(field_value.length<1){
                //throw error if string is empty            
                add_error_style('wizform', fields[i], requiredTxt +' ' +document.getElementById(fields[i]).title );
                has_error = 1;
                }
            }
        }
        if(has_error == 1){
            //error has been thrown, return false
            return false;
        }
        //add fields to validation and call generic validation script 
        if(validate['wizform']!='undefined'){delete validate['wizform']};
        addToValidate('wizform', 'name', 'alphanumeric', true,  document.getElementById('name').title);



        addToValidate('wizform', 'status', 'alphanumeric', true,  document.getElementById('status').title);
        addToValidate('wizform', 'end_date', 'date', true,  document.getElementById('end_date').title);
        addToValidate('wizform', 'start_date', 'date', false,  document.getElementById('start_date').title);
        addToValidate('wizform', 'currency_id', 'alphanumeric', false,  document.getElementById('currency_id').title);

        return check_form('wizform');
    }    





	</script>
	{/literal}

