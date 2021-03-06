<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
 
require_once('include/EditView/QuickCreate.php');
require_once('modules/Meetings/Meeting.php');
require_once('include/javascript/javascript.php');

class MeetingsQuickCreate extends QuickCreate {
    
    var $javascript;
    
    function process() {
        global $current_user, $timedate, $app_list_strings, $current_language, $mod_strings, $timeMeridiem;
        $mod_strings = return_module_language($current_language, 'Meetings');
        
        parent::process();

        $this->ss->assign("STATUS_OPTIONS", get_select_options_with_id($app_list_strings['meeting_status_dom'], $app_list_strings['meeting_status_default']));
		$this->ss->assign("CALENDAR_DATEFORMAT", $timedate->get_cal_date_format());
		
		
		$this->ss->assign("TIME_FORMAT", '('. $timedate->get_user_time_format().')');
		$this->ss->assign("USER_DATEFORMAT", '('. $timedate->get_user_date_format().')');
		


        
        if($this->viaAJAX) { // override for ajax call
            $this->ss->assign('saveOnclick', "onclick='if(check_form(\"meetingsQuickCreate\")) return SUGAR.subpanelUtils.inlineSave(this.form.id, \"activities\"); else return false;'");
            $this->ss->assign('cancelOnclick', "onclick='return SUGAR.subpanelUtils.cancelCreate(\"subpanel_activities\")';");
        }
        
        $this->ss->assign('viaAJAX', $this->viaAJAX);

        $this->javascript = new javascript();
        $this->javascript->setFormName('meetingsQuickCreate');
        
        $focus = new Meeting();
        $this->javascript->setSugarBean($focus);
        $this->javascript->addAllFields('');

		if (is_null($focus->date_start))
			$focus->date_start = $timedate->to_display_date(gmdate('Y-m-d H:i:s'));
		if (is_null($focus->time_start))
			$focus->time_start = $timedate->to_display_time(gmdate('Y-m-d H:i:s'), true);
		if (!isset ($focus->duration_hours))
			$focus->duration_hours = "1";

		$this->ss->assign("DATE_START", $focus->date_start);
		$this->ss->assign("TIME_START", substr($focus->time_start,0,5));
		$time_start_hour = intval(substr($focus->time_start, 0, 2));
		$time_start_minutes = substr($focus->time_start, 3, 5);
		
		if ($time_start_minutes > 0 && $time_start_minutes < 15) {
			$time_start_minutes = "15";
		} else
			if ($time_start_minutes > 15 && $time_start_minutes < 30) {
				$time_start_minutes = "30";
			} else
				if ($time_start_minutes > 30 && $time_start_minutes < 45) {
					$time_start_minutes = "45";
				} else
					if ($time_start_minutes > 45) {
						$time_start_hour += 1;
						$time_start_minutes = "00";
					}
		
		
		// We default the to assume that the time preference is set to 11:00 (i.e. without meridiem)
		$hours_arr = array ();
		$num_of_hours = 24;
		$start_at = 0;

		$time_pref = $timedate->get_time_format();
		if(strpos($time_pref, 'a') || strpos($time_pref, 'A')) {
		   $num_of_hours = 13;
		   $start_at = 1;	
		} 
		
		/*
		// Seems to be problematic... $time_meridiem is always empty
		if (empty ($time_meridiem)) {
			$num_of_hours = 24;
			$start_at = 0;
		}
		*/
		
		for ($i = $start_at; $i < $num_of_hours; $i ++) {
			$i = $i."";
			if (strlen($i) == 1) {
				$i = "0".$i;
			}
			$hours_arr[$i] = $i;
		}

        $this->ss->assign("TIME_START_HOUR_OPTIONS", get_select_options_with_id($hours_arr, $time_start_hour));
		$this->ss->assign("TIME_START_MINUTE_OPTIONS", get_select_options_with_id($focus->minutes_values, $time_start_minutes));
		$this->ss->assign("DURATION_HOURS", $focus->duration_hours);
		$this->ss->assign("DURATION_MINUTES_OPTIONS", get_select_options_with_id($focus->minutes_values, $focus->duration_minutes));
        // Test to see if time format is 11:00am; otherwise it's 11:00AM 
        if($num_of_hours == 13) {    
        		
		   if (strpos($time_pref, 'a')) {
		   	   
               if(!isset($focus->meridiem_am_values)) {
                  $focus->meridiem_am_values = array('am'=>'am', 'pm'=>'pm');
               } 		
               
               $this->ss->assign("TIME_MERIDIEM", get_select_options_with_id($focus->meridiem_am_values, $time_start_hour < 12 ? 'am' : 'pm'));
               
		   } else {
		       if(!isset($focus->meridiem_AM_values)) {
		          $focus->meridiem_AM_values = array('AM'=>'AM', 'PM'=>'PM');
		       }
		       
		       $this->ss->assign("TIME_MERIDIEM", get_select_options_with_id($focus->meridiem_AM_values, $time_start_hour < 12 ? 'AM' : 'PM'));
               
		   } //if-else
           
        }

        $this->ss->assign('additionalScripts', $this->javascript->getScript(false));
    }   
}
?>
