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
require_once('modules/Subjects/SubjectPreschool.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/SchedulePreschool.php');
require_once('modules/Schedules/BlockSectionSubjectPreschool.php');
require_once('modules/Schedules/BlockSectionPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_BLOCK_PRESCHOOL'], false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Preschool Block Section");

if ($access->check_access($current_user->id, $accessCode)) {

    $secID = $_GET['secID'];
    
    $blocksection = new BlockSection($secID);

    if ($blocksection->yrLevel=='S') {
        $sugar_smarty->assign('yrLevel', "Special" );
    } else {
    	
    	switch ($blocksection->yrLevel)
    	{
    		case 1:
    			$yrLevel = "Nursery 1";
    			break;
    		case 2:
    			$yrLevel = "Nursery 2";
    			break;
    		case 3:
    			$yrLevel = "Kinder 1";
    			break;
    		case 4:
    			$yrLevel = "Kinder 2";
    			break;
    		default:
    			$yrLevel = "Special";
    			break;	
    	}
    	
        $sugar_smarty->assign('yrLevel', $yrLevel );
    }
    
    $sugar_smarty->assign('secID', $secID );
    $sugar_smarty->assign('secName', $blocksection->secName );
    $sugar_smarty->assign('schYear', $blocksection->schYear );
//    $sugar_smarty->assign('yrLevel', $blocksection->yrLevel );
    $sugar_smarty->assign('maxCapacity', $blocksection->maxCapacity );
    $sugar_smarty->assign('noEnrolled', $blocksection->noEnrolled );
    $sugar_smarty->assign('remarks', $blocksection->remarks );
    $sugar_smarty->assign('preparedBy', $blocksection->preparedBy );
    $sugar_smarty->assign('preparedName', $blocksection->preparedName );
    
    if ($blocksection->rstatus) {
        $sugar_smarty->assign('status', "Open" );
    } else {
        $sugar_smarty->assign('status', "<font color='red'>Closed</font>" );
    }
    
    $subj = new Subject($schedule->subjID);
    
    if ($blocksection->subjs) {
        $ctr=0;
        foreach($blocksection->subjs as $row) {
            $data[$ctr]['schedCode'] = $row['sched']->schedCode;
            $data[$ctr]['subjCode']  = $row['sched']->subjCode;
            $data[$ctr]['time']      = date("g:i",strtotime($row['sched']->startdTime))."-".date("g:i A",strtotime($row['sched']->enddTime));
            $data[$ctr]['room']      = $row['sched']->room;
            
            $subj->subjID = $row['sched']->subjID;
            $subj->retrieveSubject();
            
            $data[$ctr]['units']     = $subj->units;
            
            // days formation
            if ($row['sched']->onMon) {
                $data[$ctr]['days']  .= "M";    
            }
            
            if ($row['sched']->onTue) {
                if ($row['sched']->onThu) {
                    $data[$ctr]['days']  .= "T";
                } else {
                    $data[$ctr]['days']  .= "Tue";
                }
            }
            
            if ($row['sched']->onWed) {
                $data[$ctr]['days']  .= "W";
            }
            
            if ($row['sched']->onThu) {
                if ($row['sched']->onTue) {
                    $data[$ctr]['days']  .= "Th";
                } else {
                    $data[$ctr]['days']  .= "Thu";
                }
            }
            
            if ($row['sched']->onFri) {
                $data[$ctr]['days']  .= "F";
            }
            
            if ($row['sched']->onSat) {
                $data[$ctr]['days']  .= "Sat";
            }
            
            if ($row['sched']->onSun) {
                $data[$ctr]['days']  .= "Sun";
            }
            
            $ctr++;
        }
    }

    // list for subject
    $sugar_smarty->assign('scheds', $data);
    $sugar_smarty->assign('total_units', $blocksection->getTotalUnits($data));

    // to check if the user has an access in edit
    $accessCode = $access->getAccessCode("Edit Preschool Block Section");
    $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
    
    // to check if the user has an access in delete
    $accessCode = $access->getAccessCode("Delete Preschool Block Section");
    $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );
    
    
    echo $sugar_smarty->fetch('modules/Schedules/templates/viewBlockSectionPreschool.tpl');
    
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">

function deleteBlockSection(secID)
{
    reply=confirm("Do you really want to delete the section?");
    
    if (reply==true)
        redirect('index.php?module=Schedules&action=deleteBlockSectionPreschool&secID='+secID);
}

</script>
