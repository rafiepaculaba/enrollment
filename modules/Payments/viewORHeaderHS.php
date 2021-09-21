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
require_once('modules/Subjects/SubjectHS.php');
require_once('modules/Students/StudentHS.php');
require_once('modules/Users/User2.php');
require_once('modules/Payments/ORSeries.php');
require_once('modules/Payments/ORHeaderHS.php');
require_once('modules/Payments/ORDetailsHS.php');
require_once('modules/SchoolFees/SchoolFeeHS.php');
require_once('modules/Account/ChartAccountMaster.php');
require_once('modules/Config/ConfigHS.php');
require_once('modules/Account/AccountDetailHS.php');
require_once('modules/Account/AccountHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View HS OR Header");
if ($access->check_access($current_user->id,$accessCode)) {

	$paymentID = $_GET['paymentID'];
	
	$orheader      = new ORHeader($paymentID);
	$schoolFee     = new SchoolFee();
	$config        = new Config();
	$accountMaster = new ChartAccountMaster();
	
	$currentTerm = $config->getConfig("Current Payment Term");
	
	if ( $orheader ) {

	    $sugar_smarty->assign('paymentID', $orheader->paymentID );
	    $sugar_smarty->assign('orno', $orheader->orno );
	    $student = new Student($orheader->idno);
	    
	    $account = new Account($student->accID);
	    $sugar_smarty->assign('balance', number_format($account->balance,2) );
	    
	    $sugar_smarty->assign('idno', $orheader->idno );
	    $sugar_smarty->assign('lname', $student->lname );
	    $sugar_smarty->assign('fname', $student->fname );
	    $sugar_smarty->assign('mname', $student->mname );
	    $sugar_smarty->assign('yrLevel', $student->yrLevel );
	    
	    $sugar_smarty->assign('accID', $orheader->accID );
	    $sugar_smarty->assign('schYear', $orheader->schYear );
	    $sugar_smarty->assign('term', $orheader->term );
	    $sugar_smarty->assign('dateCreated', $orheader->dateCreated );
	    $sugar_smarty->assign('timeCreated', date("h:i",strtotime($orheader->timeCreated)));
	    $sugar_smarty->assign('totalAmount', $orheader->totalAmount );
	    $sugar_smarty->assign('cashier', $orheader->cashier );
	    $sugar_smarty->assign('rstatus', $orheader->rstatus );

	    if ($orheader->particular) {
            $ctr=0;
            foreach($orheader->particular as $row) {
                
                //display schoolfee item
                $account_code = $row['account_code'];
                unset($where);
                $where[0]['account_code'] = "='$account_code'";
                $particular = $accountMaster->retrieveAllChartAccountMaster($where);
                
                $data[$ctr]['particular'] = $particular[0]['account_name'];
                $data[$ctr]['amount'] = $row['amount'];
                $total_amount += $row['amount']; 

                $ctr++;
            }
        }
        
        // list for subject
        $sugar_smarty->assign('total_amount', $total_amount);
        $sugar_smarty->assign('ordetails', $data);
	    
        if ($currentTerm == $orheader->term ) {
            // to check if the user has an access in edit
            $accessCode = $access->getAccessCode("Edit HS OR Header");
            $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
            
            // to check if the user has an access in delete
            $accessCode = $access->getAccessCode("Cancel HS OR Header");
            $sugar_smarty->assign('hasCancel', $access->check_access($current_user->id, $accessCode) );
            
            // to check if the user has an access in edit
            $accessCode = $access->getAccessCode("Print HS OR Header");
            $sugar_smarty->assign('hasPrint', $access->check_access($current_user->id, $accessCode) );

            // to check if the user has an access in edit
            $accessCode = $access->getAccessCode("Delete HS OR Header");
            $sugar_smarty->assign('hasDelete', $access->check_access($current_user->id, $accessCode) );

        }

	    echo $sugar_smarty->fetch('modules/Payments/templates/viewORHeaderHS.tpl');
	} else {
	    $msg = "Payment Type ID not found!";
	    $sugar_smarty->assign('class', 'errorbox');
	    $sugar_smarty->assign('display', 'block');
	    $sugar_smarty->assign('msg', $msg );
	    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	}
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script language="javascript">
function cancelORHeader(paymentID, schYear, idno, amount, orno)
{
    reply=confirm("Do you really want to cancel this record?");
    
    if (reply==true)
        redirect('index.php?module=Payments&action=cancelORHeaderHS&paymentID=' + paymentID + '&schYear=' + schYear + '&idno=' + idno + '&amount=' + amount + '&orno=' + orno);
}

function deleteORHeader(paymentID, schYear, idno, amount, orno)
{
    reply=confirm("Do you really want to cancel this record?");
    
    if (reply==true)
        redirect('index.php?module=Payments&action=deleteORHeaderHS&paymentID=' + paymentID + '&schYear=' + schYear + '&idno=' + idno + '&amount=' + amount + '&orno=' + orno);
}

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=710,height=460,left = 0,top = 0');");
}
</script>