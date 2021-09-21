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
 * *******************************************************************************/
/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 *********************************************************************************/

if(!isset($db) || empty($db)) {
	$db = & DBManager :: getInstance();
}

$modulesWithEmail = array(
	'Accounts' => 'accounts',
	'Contacts' => 'contacts',
	'Leads' => 'leads',
	'Prospects' => 'prospects',
	'Users' => 'users',
);

$i = 0;
foreach($modulesWithEmail as $module => $table) {
	$q = "SELECT id, email1, email2 FROM {$table}";
	$r = $db->query($q);
	$i++;
	
	while($a = $db->fetchByAssoc($r)) {
		$cleanEmail1 = trim($a['email1']);
		$cleanEmail2 = trim($a['email2']);
		
		$q2 = "UPDATE {$table} SET email1 = '{$cleanEmail1}', email2 = '{$cleanEmail2}' WHERE id = '{$a['id']}'";
		$r2 = $db->query($q2);
		$i++;
	}
}

echo "[ {$i} ] {$mod_strings['LBL_CLEAN_EMAIL_ADDRESSES_RESULT']}";
