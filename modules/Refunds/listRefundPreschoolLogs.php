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

global $current_user, $sugar_version, $sugar_config, $image_path;

require_once('config.php');
require_once('include/Sugar_Smarty.php');
require_once('common.php');
require_once('modules/Config/RecordLogPreschool.php');
require_once('modules/Users/User2.php');
require_once('modules/Students/StudentPreschool.php');
require_once('modules/Refunds/RefundPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();
global $current_user;

$refundID = $_GET['refundID'];

$refundLog = new RecordLog();

$where[0]['docType'] = "= 'Preschool Refund' AND ";
$where[0]['recID'] = "=$refundID";
$theLogs = $refundLog->retrieveAllRecordLogs($where);

if ($theLogs) {
	$data = array();
	$ctr=0;
	foreach ($theLogs as $row) {
		$data[$ctr]=$row;
		$data[$ctr]['logDate']=date("F d, Y",strtotime($row['logDate']));
		$data[$ctr]['time']	  =date("h:i A",strtotime($row['logDate']));
		$u = new User2($row['user_id']);
		$data[$ctr]['user']=htmlentities($u->last_name)." , ".htmlentities($u->first_name);
		
		$ctr++;
	}
} else {
	$data = "";
}

$sugar_smarty->assign('refundID', $refundID );
$sugar_smarty->assign('logs', $data );

echo $sugar_smarty->fetch('modules/Refunds/templates/listRefundPreschoolLogs.tpl');
?>
