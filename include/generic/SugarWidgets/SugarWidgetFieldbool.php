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

class SugarWidgetFieldBool extends SugarWidgetReportField
{

 function queryFilterEquals(&$layout_def)
 {

		$bool_val = $layout_def['input_name0'][0];
		if ($bool_val == 'yes' || $bool_val == '1')
		{
			return "(".$this->_get_column_select($layout_def)." LIKE 'on' OR ".$this->_get_column_select($layout_def)."='1')\n";
		} else {
			return "(".$this->_get_column_select($layout_def)." is null OR ".$this->_get_column_select($layout_def)."='off' OR ".$this->_get_column_select($layout_def)."='0')\n";
		}
 }

	function & displayListPlain($layout_def)
	{
		$on_or_off = 'CHECKED';
		$value = $this->_get_list_value($layout_def);
		if ( empty($value) ||  $value == 'off')
		{
			$on_or_off = '';
		}
		$cell = "<input name='checkbox_display' class='checkbox' type='checkbox' disabled $on_or_off>";
		return  $cell;
	}
 function queryFilterStarts_With(&$layout_def)
 {
    return $this->queryFilterEquals($layout_def);
 }    
    

}

?>
