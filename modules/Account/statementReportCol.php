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
require_once('modules/Account/AccountDetailCol.php');
require_once('modules/Account/Account.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Account/Account.php');
require_once('modules/Payments/ORSeries.php');
require_once('modules/Payments/ORHeader.php');
require_once('modules/Payments/ORDetails.php');
require_once('modules/SchoolFees/SchoolFeeCol.php');
require_once('modules/Account/ChartAccountMaster.php');
require_once('modules/Config/ConfigCol.php');
require_once('modules/Reports/ReportCol.php');

echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$config = new Config();
$sugar_smarty = new Sugar_Smarty();

$accID 		= $_GET['accID'];
$schYear 	= $_GET['schYear'];
$semCode 	= $_GET['semCode'];
$lname	 	= $_GET['lname'];
$fname	 	= $_GET['fname'];
$mname	 	= $_GET['mname'];
$courseCode	= $_GET['courseCode'];
$yrLevel	= $_GET['yrLevel'];

$reportClass    = new ReportClass();
$accountMaster  = new ChartAccountMaster();
$acc            = new Account($accID);

$sugar_smarty->assign('accID', $accID);
$sugar_smarty->assign('idno', $acc->idno);
$sugar_smarty->assign('schYear', $acc->schYear);
$sugar_smarty->assign('semCode', $acc->semCode);

$query      = "SELECT DISTINCT ordetails.orno, ordetails.amount, orheader.dateCreated, orheader.term, ordetails.account_code FROM orheader, ordetails, accounts WHERE orheader.schYear = '$schYear' AND orheader.semCode = '$semCode' AND orheader.idno = '".$acc->idno."' AND orheader.orno = ordetails.orno";
$records    = $reportClass->adhocQuery($query);

$ctr = 0;

//get default
$default_semCode = $config->getConfig('Semester');

foreach ($records as $value) {
    
    $account_code = $value['account_code'];
    
    if ($default_semCode==4) {
        $total_terms =  $config->getConfig("Summer Terms");
    } else {
        $total_terms =  $config->getConfig("Semestral Terms");
    }
    
    if ($total_terms==1) {
    	$term = $term_by_1[$value['term']];
    } else if ($total_terms==2) {
    	$term = $term_by_2[$value['term']];
    } else if ($total_terms==3) {
    	$term = $term_by_3[$value['term']];
    } else if ($total_terms==4) {
    	$term = $term_by_4[$value['term']];
    } else {
    	$term = $value['term'];
    }
	
    unset($where);
    $where[0]['account_code'] = "='$account_code'";
    $particular = $accountMaster->retrieveAllChartAccountMaster($where);
    
    $data[$ctr]['particular'] = $particular[0]['account_name'];

//    $data[$ctr]['particular']   = $particular[0]['account_name'];
    $data[$ctr]['orno']         = $value['orno'];
    $data[$ctr]['dateCreated']  = date("m/d/Y",strtotime($value['dateCreated']));
    $data[$ctr]['amount']       = $value['amount'];
    
    $ctr++;
}

$sugar_smarty->assign('list', $data );
$sugar_smarty->assign('mname', $mname);
$sugar_smarty->assign('fname', $fname);
$sugar_smarty->assign('lname', $lname);
$sugar_smarty->assign('courseCode', $courseCode);
$sugar_smarty->assign('yrLevel', $yrLevel);
$sugar_smarty->assign('SCHYEAR', $schYear);
if ($semCode==1) {
   $sugar_smarty->assign('SEMCODE', "1<sup>st</sup> Semester");
} else if ($semCode==2) {
   $sugar_smarty->assign('SEMCODE', "2<sup>nd</sup> Semester");
} else if ($semCode==2) {
   $sugar_smarty->assign('SEMCODE', "3<sup>rd</sup> Semester");
} else {
   $sugar_smarty->assign('SEMCODE', "Summer"); 
}

$sugar_smarty->assign('TERM', $term);

if ($config->getConfig('Logo')) {
    $sugar_smarty->assign('logo', '1' );
} else {
    $sugar_smarty->assign('logo', '0' );
}

$sugar_smarty->assign('schName', $config->getConfig('School Name') );
$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
	
echo $sugar_smarty->fetch('modules/Account/templates/statementReportCol.tpl');
?>

<script language="javascript">
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}

</script>
