<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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



require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/Calls/Call.php');
require_once('modules/Calls/Dashlets/MyCallsDashlet/MyCallsDashlet.data.php');
        
class MyCallsDashlet extends DashletGeneric { 
    function MyCallsDashlet($id, $def = null) {
        global $current_user, $app_strings, $dashletData;

        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_LIST_MY_CALLS', 'Calls');
        $this->searchFields = $dashletData['MyCallsDashlet']['searchFields'];     
        if(empty($def['filters'])){
			if(isset($this->searchFields['status'])){
				if(!empty($this->searchFields['status']['default'])){
                    $this->filters['status'] = $this->searchFields['status']['default'];
                }
			}
        }
        $this->columns = $dashletData['MyCallsDashlet']['columns'];
        $this->columns['set_accept_links']= array('width'    => '10', 
                                              'label'    => translate('LBL_ACCEPT_THIS', 'Meetings'),
                                              'sortable' => false,
                                              'related_fields' => array('status'),
                                              'default' => 'true');
        $this->seedBean = new Call();        
    }
    
    
    function process() {
        global $current_language, $app_list_strings, $image_path, $current_user;            
        $mod_strings = return_module_language($current_language, 'Calls');
        
        if($this->myItemsOnly) { // handle myitems only differently
            $lvsParams = array(
                           'custom_from' => ' INNER JOIN calls_users ON calls.id = calls_users.call_id ',
                           'custom_where' => ' AND calls_users.deleted = 0 AND (calls.assigned_user_id = \'' . $current_user->id . '\' OR calls_users.user_id = \'' . $current_user->id . '\') ',
                           'distinct' => true
                           );
        } else {
            $lvsParams = array();
        }
        $this->myItemsOnly = false; 
        
        parent::process($lvsParams);
   
        $keys = array();
        foreach($this->lvs->data['data'] as $num => $row) {
            $keys[] = $row['ID'];
        }
        

       if(!empty($keys)){ 
            $query = "SELECT call_id, accept_status FROM calls_users WHERE user_id = '" . $current_user->id . "' AND call_id IN ('" . implode("','", $keys ). "')";
            $result = $GLOBALS['db']->query($query);
            
            while($row = $GLOBALS['db']->fetchByAssoc($result)) {
                 $rowNums = $this->lvs->data['pageData']['idIndex'][$row['call_id']]; // figure out which rows have this guid
                 foreach($rowNums as $rowNum) {
                    $this->lvs->data['data'][$rowNum]['ACCEPT_STATUS'] = $row['accept_status'];
                 }
            }
       }
        
        foreach($this->lvs->data['data'] as $rowNum => $row) {
            if(empty($this->lvs->data['data'][$rowNum]['DURATION_HOURS']))  $this->lvs->data['data'][$rowNum]['DURATION'] = '0' . $mod_strings['LBL_HOURS_ABBREV'];
            else $this->lvs->data['data'][$rowNum]['DURATION'] = $this->lvs->data['data'][$rowNum]['DURATION_HOURS'] . $mod_strings['LBL_HOURS_ABBREV'];
            
            if(empty($this->lvs->data['data'][$rowNum]['DURATION_MINUTES']) || empty($this->seedBean->minutes_values[$this->lvs->data['data'][$rowNum]['DURATION_MINUTES']])) {
                $this->lvs->data['data'][$rowNum]['DURATION'] .= '00';
            }
            else {
                $this->lvs->data['data'][$rowNum]['DURATION'] .= $this->seedBean->minutes_values[$this->lvs->data['data'][$rowNum]['DURATION_MINUTES']];
            } 
            if ($this->lvs->data['data'][$rowNum]['STATUS'] == "Planned")
            {
                if ($this->lvs->data['data'][$rowNum]['ACCEPT_STATUS'] == '' ||
                    $this->lvs->data['data'][$rowNum]['ACCEPT_STATUS'] == 'none')                
                {
                    $this->lvs->data['data'][$rowNum]['SET_ACCEPT_LINKS'] = "<div id=\"accept".$this->id."\"><a title=\"".
                        "\" href=\"javascript:SUGAR.util.retrieveAndFill('index.php?module=Activities&to_pdf=1&action=SetAcceptStatus&id=".$this->id."&object_type=Call&object_id=".$this->lvs->data['data'][$rowNum]['ID'] . "&accept_status=accept', null, null, SUGAR.sugarHome.retrieveDashlet, '{$this->id}');\">". 
                        get_image($image_path."accept_inline","alt='".$app_list_strings['dom_meeting_accept_options']['accept'].
                        "' border='0'"). "</a>&nbsp;<a title=\"".$app_list_strings['dom_meeting_accept_options']['tentative'].
                        "\" href=\"javascript:SUGAR.util.retrieveAndFill('index.php?module=Activities&to_pdf=1&action=SetAcceptStatus&id=".$this->id."&object_type=Call&object_id=".$this->lvs->data['data'][$rowNum]['ID'] . "&accept_status=tentative', null, null, SUGAR.sugarHome.retrieveDashlet, '{$this->id}');\">". 
                        get_image($image_path."tentative_inline","alt='".$app_list_strings['dom_meeting_accept_options']['tentative']."' border='0'").
                        "</a>&nbsp;<a title=\"".$app_list_strings['dom_meeting_accept_options']['decline'].
                        "\" href=\"javascript:SUGAR.util.retrieveAndFill('index.php?module=Activities&to_pdf=1&action=SetAcceptStatus&id=".$this->id."&object_type=Call&object_id=".$this->lvs->data['data'][$rowNum]['ID'] . "&accept_status=decline', null, null, SUGAR.sugarHome.retrieveDashlet, '{$this->id}');\">". 
                        get_image($image_path."decline_inline","alt='".$app_list_strings['dom_meeting_accept_options']['decline'].
                        "' border='0'")."</a></div>";
                }    
                else
                {
                    $this->lvs->data['data'][$rowNum]['SET_ACCEPT_LINKS'] = $app_list_strings['dom_meeting_accept_status'][$this->lvs->data['data'][$rowNum]['ACCEPT_STATUS']];
                    
                }
            }
            
            $this->lvs->data['data'][$rowNum]['DURATION'] .= $mod_strings['LBL_MINSS_ABBREV'];
        }
      $this->displayColumns[]= "set_accept_links";    
    }
    
    function displayOptions() {
        $this->processDisplayOptions();
        $this->configureSS->assign('strings', array('general' => $GLOBALS['mod_strings']['LBL_DASHLET_CONFIGURE_GENERAL'],
                                     'filters' => $GLOBALS['mod_strings']['LBL_DASHLET_CONFIGURE_FILTERS'],
                                     'myItems' => translate('LBL_LIST_MY_CALLS', 'Calls'),
                                     'displayRows' => $GLOBALS['mod_strings']['LBL_DASHLET_CONFIGURE_DISPLAY_ROWS'],
                                     'title' => $GLOBALS['mod_strings']['LBL_DASHLET_CONFIGURE_TITLE'],
                                     'save' => $GLOBALS['app_strings']['LBL_SAVE_BUTTON_LABEL']));
        return $this->configureSS->fetch($this->configureTpl);
    }
}

?>
