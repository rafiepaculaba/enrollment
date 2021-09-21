<?php
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
 require_once('include/ListView/ListViewSmarty.php');
 
class ListViewPackages extends ListViewSmarty{
    var $secondaryDisplayColumns;
    /**
     * Constructor  Call ListViewSmarty
     */
    function ListViewPackages(){
        parent::ListViewSmarty();   
    } 
    
    /**
     * Override the setup method in ListViewSmarty since we are not passing in a bean
     * 
     * @param data  the data to display on the page
     * @param file  the template file to parse
     */
    function setup($data, $file){
        $this->data = $data;
        $this->tpl = $file;       
    }
    
    /**
     * Override the display method
     */
    function display(){
        global $odd_bg, $even_bg, $image_path, $app_strings;
        $this->ss->assign('imagePath', $image_path);
        $this->ss->assign('rowColor', array('oddListRow', 'evenListRow'));
        $this->ss->assign('bgColor', array($odd_bg, $even_bg));
        $this->ss->assign('displayColumns', $this->displayColumns);
        $this->ss->assign('secondaryDisplayColumns', $this->secondaryDisplayColumns);
        $this->ss->assign('data', $this->data); 
        return $this->ss->fetch($this->tpl);  
    }  
}
?>
