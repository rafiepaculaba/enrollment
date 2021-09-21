<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
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

class contextMenu {
    var $menuItems;
    var $objectName;

    function contextMenu() {
        $this->menuItems = array();
    }

    function getScript() {
        $json = getJSONobj();
        return "SUGAR.contextMenu.registerObjectType('{$this->objectName}', " . $json->encode($this->menuItems) . ");\n";
    }

    /**
     * adds a menu item to the current contextMenu
     *
     * @param string $text text of the item
     * @param string $action function or pointer to the javascript function to call
     * @param array $params other parameters includes:
     *      url - The URL for the MenuItem's anchor's "href" attribute.
     *      target - The value to be used for the MenuItem's anchor's "target" attribute.
     *      helptext - Additional instructional text to accompany the text for a MenuItem. Example: If the text is
     *                 "Copy" you might want to add the help text "Ctrl + C" to inform the user there is a keyboard
     *                 shortcut for the item.
     *      emphasis - If set to true the text for the MenuItem will be rendered with emphasis (using <em>).
     *      strongemphasis - If set to true the text for the MenuItem will be rendered with strong emphasis (using <strong>).
     *      disabled - If set to true the MenuItem will be dimmed and will not respond to user input or fire events.
     *      selected - If set to true the MenuItem will be highlighted.
     *      submenu - Appends / removes a menu (and it's associated DOM elements) to / from the MenuItem.
     *      checked - If set to true the MenuItem will be rendered with a checkmark.
     */
    function addMenuItem($text, $action, $module = null, $aclAction = null, $params = null) {
        // check ACLs if module and aclAction set otherwise no ACL check
        if(((!empty($module) && !empty($aclAction)) && ACLController::checkAccess($module, $aclAction)) || (empty($module) || empty($aclAction))) {
            $item = array('text' => translate($text),
                          'action' => $action);
            foreach(array('url', 'target', 'helptext', 'emphasis', 'strongemphasis', 'disabled', 'selected', 'submenu', 'checked') as $param) {
                if(!empty($params[$param])) $item[$param] = $params[$param];
            }
            array_push($this->menuItems, $item);
        }
    }

    /**
     * Loads up menu items from files located in include/contextMenus/menuDefs
     * @param string $name name of the object
     */
    function loadFromFile($name) {
        clean_string($name, 'FILE');
        require_once('include/contextMenus/menuDefs/' . $name . '.php');
        $this->loadFromDef($name, $menuDef[$name]);
    }

    /**
     * Loads up menu items from def
     * @param string $name name of the object type
     * @param array $defs menu item definitions
     */
    function loadFromDef($name, $defs) {
        $this->objectName = $name;
        foreach($defs as $def) {
            $this->addMenuItem($def['text'], $def['action'],
                               (empty($def['module']) ? null : $def['module']),
                               (empty($def['aclAction']) ? null : $def['aclAction']),
                               (empty($def['params']) ? null : $def['params']));
        }
    }
}
?>
