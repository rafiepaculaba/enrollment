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
require_once('modules/Config/ConfigCol.php');  
require_once('modules/Students/StudentElem.php');
require_once('modules/Subjects/SubjectElem.php');
require_once('modules/Users/User2.php');
require_once('modules/Schedules/ScheduleElem.php');
require_once('modules/Schedules/BlockSectionSubjectElem.php');
require_once('modules/Schedules/BlockSectionElem.php');
require_once('modules/Enrollments/EnrollmentDetailElem.php');
require_once('modules/Enrollments/EnrollmentElem.php');

require_once('modules/Students/StudentElem.php');
require_once('modules/Account/AccountDetailElem.php');
require_once('modules/Account/AccountElem.php');

global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$enID   = $_GET['enID'];

$enrollment = new Enrollment($enID);
$student = new Student($enrollment->idno);
$account = new Account($student->accID);
$config = new Config();
if ( $enID ) {
    $sugar_smarty->assign('enID', $enID );
    $sugar_smarty->assign('idno', $enrollment->idno );
    $sugar_smarty->assign('lname', $enrollment->lname );
    $sugar_smarty->assign('fname', $enrollment->fname );
    $sugar_smarty->assign('mname', $enrollment->mname );
    $sugar_smarty->assign('schYear', $enrollment->schYear );
    $sugar_smarty->assign('secName', $enrollment->secName );
    
    $sugar_smarty->assign('preparedBy', $enrollment->encodedBy );
    $sugar_smarty->assign('preparedName', $enrollment->encodedName );
    $sugar_smarty->assign('rstatus', $enrollment->rstatus );

    
//    p($enrollment->subjs);
    if ($enrollment->subjs) {
        $ctr=0;
        foreach($enrollment->subjs as $row) {
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
    
    // list for subject
    $sugar_smarty->assign('scheds', $data);
    $sugar_smarty->assign('total_units', $enrollment->getTotalUnits($data));
    
    // summary of account
    $sugar_smarty->assign('accID', $account->accID );
	$sugar_smarty->assign('schYear_acct', $account->schYear );
	$sugar_smarty->assign('idno', $account->idno );
	
//	$student = new Student($account->idno);
	
	if ($account->details) {
	    $fees = array();
	    $less_adjustments= array();
	    $add_adjustments = array();
	    foreach ($account->details as $data) {
	        if (strtoupper($data['feeType'])=="ADD") {
                $add_adjustments[] = $data;        
	        } else if (strtoupper($data['feeType'])=="LESS") {
                $less_adjustments[] = $data;        
	        } else {
	            $fees[] = $data;  
	        }
	    }
	}

	if (count($fees)) {
	   $sugar_smarty->assign('fees', $fees );
	} else {
	   $sugar_smarty->assign('fees', "" );
	}
	
	if (count($less_adjustments)) {
	   $sugar_smarty->assign('less_adjustments', $less_adjustments );
	} else {
	   $sugar_smarty->assign('less_adjustments', "" );
	}
	
	if (count($add_adjustments)) {
	   $sugar_smarty->assign('add_adjustments', $add_adjustments );
	} else {
	   $sugar_smarty->assign('add_adjustments', "" );
	}
	
	$sugar_smarty->assign('lname', $student->lname );
	$sugar_smarty->assign('fname', $student->fname );
	$sugar_smarty->assign('mname', $student->mname );
	
	switch ($enrollment->yrLevel) {
	 	case '1':
            $sugar_smarty->assign('yrLevel', "1<sup>st</sup>" );
	 		break;
	    case '2':
            $sugar_smarty->assign('yrLevel', "2<sup>nd</sup>" );
	 		break;
 		case '3':
            $sugar_smarty->assign('yrLevel', "3<sup>rd</sup>" );
	 		break;
 		case '4':
            $sugar_smarty->assign('yrLevel', "4<sup>th</sup>" );
	 		break;
	 	default:
	 	    $sugar_smarty->assign('yrLevel', "Special" );
	 		break;
	 }
	
	$sugar_smarty->assign('oldBalance', $account->oldBalance );
	$sugar_smarty->assign('totalFee', $account->totalFee );
	$sugar_smarty->assign('payment', $account->payment );
	$sugar_smarty->assign('balance', $account->balance );
    
    $sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
	
	$sugar_smarty->assign('rundate', date("m/d/Y",time()) );

	echo $sugar_smarty->fetch('modules/Enrollments/templates/printStudyLoadElem.tpl');
	echo $sugar_smarty->fetch('modules/Enrollments/templates/printAccountElem.tpl');
} else {
    $msg = "Enrollment No. not found!";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
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