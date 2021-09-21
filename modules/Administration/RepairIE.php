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
/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/
require_once('modules/InboundEmail/InboundEmail.php');

if(!isset($db) || empty($db)) {
	require_once ('include/database/DBManager.php');
	require_once ('include/database/DBManagerFactory.php');
	$db = & DBManager :: getInstance();
	$dbmann = DBManager :: getInstance();
}

$badAccts = array();

$q = "SELECT id, name, email_password FROM inbound_email WHERE deleted=0 AND status='Active'";
$r = $db->query($q);

while($a = $db->fetchByAssoc($r)) {
	$ieX = new InboundEmail();
	$ieX->retrieve($a['id']);
	if(!$ieX->repairAccount()) {
		// none of the iterations worked.  flag for display
		$badAccts[$a['id']] = $a['name'];
	}
}

if(empty($badAccts)) {
	echo $mod_strings['LBL_REPAIR_IE_SUCCESS'];
} else {
	echo "<div class='error'>{$mod_strings['LBL_REPAIR_IE_FAILURE']}</div><br />";
	foreach($badAccts as $id => $acctName) {
		echo "<a href='index.php?module=InboundEmail&action=EditView&record={$id}' target='_blank'>{$acctName}</a><br />";
	}
}

?>
