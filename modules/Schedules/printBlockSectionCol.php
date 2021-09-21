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
require_once('modules/Departments/Department.php');
require_once('modules/Config/ConfigCol.php');  
require_once('modules/Courses/Course.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');
require_once('modules/Schedules/Schedule.php');
require_once('modules/Schedules/BlockSectionSubjectCol.php');
require_once('modules/Schedules/BlockSectionCol.php');

global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$config = new Config();

    $secID = $_GET['secID'];
    
    $blocksection = new BlockSection($secID);

    $sugar_smarty->assign('secID', $secID );
    $sugar_smarty->assign('secName', $blocksection->secName );
    $sugar_smarty->assign('schYear', $blocksection->schYear );
    
    switch ($blocksection->semCode) 
    {
        case 1:
            $sugar_smarty->assign('semCode', "1st");    
            break;
        case 2:
            $sugar_smarty->assign('semCode', "2nd");
            break;
        case 4:
            $sugar_smarty->assign('semCode', "Summer");
    }
    
    $sugar_smarty->assign('courseID', $blocksection->courseID );
    $sugar_smarty->assign('courseCode', $blocksection->courseCode );
    $sugar_smarty->assign('yrLevel', $blocksection->yrLevel );
    $sugar_smarty->assign('remarks', $blocksection->remarks );
    $sugar_smarty->assign('preparedBy', $blocksection->preparedBy );
    $sugar_smarty->assign('preparedName', $blocksection->preparedName );

    if ($blocksection->rstatus) {
        $sugar_smarty->assign('status', "Open" );
    } else {
        $sugar_smarty->assign('status', "<font color='red'>Closed</font>" );
    }


    if ($blocksection->subjs) {
        $ctr=0;
        foreach($blocksection->subjs as $row) {
            $data[$ctr]['schedCode'] = $row['sched']->schedCode;
            $data[$ctr]['subjCode'] = $row['sched']->subjCode;
            $data[$ctr]['time'] = date("g:i",strtotime($row['sched']->startdTime))."-".date("g:i A",strtotime($row['sched']->enddTime));
            $data[$ctr]['room'] = $row['sched']->room;
            $data[$ctr]['units'] = $row['sched']->units;
            
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
    
    $sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
    
    // list for subject
    $sugar_smarty->assign('scheds', $data);
    $sugar_smarty->assign('total_units', $blocksection->getTotalUnits($data));
    echo $sugar_smarty->fetch('modules/Schedules/templates/printBlockSectionCol.tpl');
    
?>

<script language="javascript">

function printNow() 
{
    document.getElementById('myDiv').style.display="none";
    document.getElementById('myDivAccount').style.display="none";
    window.print();
    window.close();
}

function displayAccount() 
{
    if (document.getElementById('chkAccount').checked) {
        document.getElementById('myAccount').style.display="block";
    } else {
        document.getElementById('myAccount').style.display="none";
    }
}

</script>