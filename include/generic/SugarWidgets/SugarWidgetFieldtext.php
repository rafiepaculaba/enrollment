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

class SugarWidgetFieldText extends SugarWidgetFieldVarchar
{
    function SugarWidgetFieldText(&$layout_manager) {
        parent::SugarWidgetFieldVarchar($layout_manager);
        $this->reporter = $this->layout_manager->getAttribute('reporter');  
    }

    function queryFilterEquals(&$layout_def) {
        if( $this->reporter->db->dbType == 'mysql') {
            return parent::queryFilterEquals($layout_def);
        } 
        elseif( $this->reporter->db->dbType == 'mssql') {
            return parent::queryFilterEquals($layout_def);
        }





    }

    function queryFilterNot_Equals_Str(&$layout_def) {
        if( $this->reporter->db->dbType == 'mysql') {
            return parent::queryFilterNot_Equals_Str($layout_def);
        } 
        elseif( $this->reporter->db->dbType == 'mssql') {
            return parent::queryFilterNot_Equals_Str($layout_def);
        }





    }
    
    function queryFilterNot_Empty(&$layout_def) {
        if( $this->reporter->db->dbType == 'mysql') {
            return parent::queryFilterNot_Empty($layout_def);
        } 
        elseif( $this->reporter->db->dbType == 'mssql') {
            return '( '.$this->_get_column_select($layout_def).' IS NOT NULL OR DATALENGTH('.$this->_get_column_select($layout_def).") > 0)\n";
        }





    }
    
    function queryFilterEmpty(&$layout_def) {
        if( $this->reporter->db->dbType == 'mysql') {
            return parent::queryFilterEmpty($layout_def);
        } 
        elseif( $this->reporter->db->dbType == 'mssql') {
            return '( '.$this->_get_column_select($layout_def).' IS NULL OR DATALENGTH('.$this->_get_column_select($layout_def).") = 0)\n";
        }






    }
}

?>
