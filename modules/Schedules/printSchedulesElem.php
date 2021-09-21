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

require_once('include/Sugar_Smarty.php');
require_once('common.php');

require_once('common.php');
require_once('modules/Config/ConfigElem.php');
require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleElem.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$schYear        = $_GET['schYear'];
$droom          = $_GET['droom'];
$dnoEnrolled    = $_GET['dnoEnrolled'];
$dmaxCapacity   = $_GET['dmaxCapacity'];
$dstartTime     = $_GET['dstartTime'];
$dendTime       = $_GET['dendTime'];
$dremarks       = $_GET['dremarks'];
$ddays          = $_GET['ddays'];

$config = new Config();
$sched = new Schedule();

$offset = $_SESSION['PRINT_OFFSET'];
//$limit  = $_SESSION['PRINT_LIMIT'];
$conds  = $_SESSION['PRINT_CONDS'];

$list = $sched->retrieveAllSchedulesAssociated($conds,"","ASC",$offset);//, $limit);
	
//dynamic fields
$sugar_smarty->assign('droom', $droom );
$sugar_smarty->assign('dnoEnrolled', $dnoEnrolled );
$sugar_smarty->assign('dmaxCapacity', $dmaxCapacity );
$sugar_smarty->assign('dstartTime', $dstartTime );
$sugar_smarty->assign('dendTime', $dendTime );
$sugar_smarty->assign('dremarks', $dremarks );
$sugar_smarty->assign('ddays', $ddays );

$sugar_smarty->assign('SCHYEAR', $schYear);
$sugar_smarty->assign('schName', $config->getConfig('School Name') );
$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
$sugar_smarty->assign('schContact', $config->getConfig('Contact') );

$sugar_smarty->assign('list', $list );

echo $sugar_smarty->fetch('modules/Schedules/templates/printSchedulesElem.tpl');
?>
<script type='text/javascript'>
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}

</script>