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
require_once('modules/Students/StudentElem.php');
require_once('modules/Account/AccountDetailElem.php');
require_once('modules/Account/AccountElem.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_ACCT'], $mod_strings['LBL_MODULE_TITLE_ACCT_ELEM'], false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Elem Account");
if ($access->check_access($current_user->id,$accessCode)) {
	
	$accID   = $_GET['accID'];
	$account = new Account($accID);

	if ( $accID ) {
    	
    	$sugar_smarty->assign('accID', $account->accID );
    	$sugar_smarty->assign('schYear', $account->schYear );
    	$sugar_smarty->assign('semCode', $account->semCode );
    	$sugar_smarty->assign('idno', $account->idno );
    	
    	$student = new Student($account->idno);
    	
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
    	$sugar_smarty->assign('courseCode', $student->courseCode );
    	$sugar_smarty->assign('yrLevel', $student->yrLevel );
    	
    	$sugar_smarty->assign('oldBalance', $account->oldBalance );
    	$sugar_smarty->assign('totalFee', $account->totalFee );
    	$sugar_smarty->assign('payment', $account->payment );
    	$sugar_smarty->assign('balance', $account->balance );
    	
    	echo $sugar_smarty->fetch('modules/Account/templates/editAccountElem.tpl');
	} else {
	    $msg = "Account ID not found!";
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

function recalculate()
{
    // calculate the total fees
    totalFee = parseFloat($('oldBalance').value);
    
    <?php
    if (is_array($fees) && $fees) {
        foreach ($fees as $data) {
            echo "totalFee += parseFloat($('feesf_".$data['accDetailID']."').value); \n";
        }
    }
    ?>
    
    <?php
    $ctr=1;
    if (is_array($add_adjustments) && $add_adjustments) {
        foreach ($add_adjustments as $data) {
            echo "totalFee += parseFloat($('addf_".$data['accDetailID']."').value); \n";
            $ctr++;    
        }
    }
    ?>
    
    <?php
    if (is_array($less_adjustments) && $less_adjustments) {
        foreach ($less_adjustments as $data) {
            echo "totalFee -= parseFloat($('lessf_".$data['accDetailID']."').value); \n";
        }
    }
    ?>
    
    $('totalFee').value=totalFee.toFixed(2);
    // calculate the balance
    balance = parseFloat($('totalFee').value) - parseFloat($('payment').value);
    $('balance').value=balance.toFixed(2);
}

<?php
// generate javascript functions
if ($fees) {
    foreach ($fees as $data) {
        echo "function fees_".$data['accDetailID']."()\n";
        echo "{";
        echo "    if (trim(\$('feesf_".$data['accDetailID']."').value)==\"\") { \n";
        echo "        \$('feesf_".$data['accDetailID']."').value=\"0.0\"; \n";
        echo "    } \n";
        echo "\n";    
        echo "    if (!isFloatNumber(\$('feesf_".$data['accDetailID']."').value)) { \n";
        echo "        alert(\"Error: Invalid value in Tuition\"); \n";
        echo "        \$('feesf_".$data['accDetailID']."').value=\"".$data['amount']."\"; \n";
        echo "    } else { \n";
        echo "        $('feesf_".$data['accDetailID']."').value=parseFloat($('feesf_".$data['accDetailID']."').value).toFixed(2); \n";
        echo "    } \n";
        echo "\n";    
        echo "    recalculate(); \n";
        echo "} \n\n";
    }
}

if ($add_adjustments) {
    foreach ($add_adjustments as $data) {
        echo "function add_".$data['accDetailID']."()\n";
        echo "{";
        echo "    if (trim(\$('addf_".$data['accDetailID']."').value)==\"\") { \n";
        echo "        \$('addf_".$data['accDetailID']."').value=\"0.0\"; \n";
        echo "    } \n";
        echo "\n";    
        echo "    if (!isFloatNumber(\$('addf_".$data['accDetailID']."').value)) { \n";
        echo "        alert(\"Error: Invalid value in Tuition\"); \n";
        echo "        \$('addf_".$data['accDetailID']."').value=\"".$data['amount']."\"; \n";
        echo "    } else { \n";
        echo "        $('addf_".$data['accDetailID']."').value=parseFloat($('addf_".$data['accDetailID']."').value).toFixed(2); \n";
        echo "    } \n";
        echo "\n";    
        echo "    recalculate(); \n";
        echo "} \n\n";
    }
}

if ($less_adjustments) {
    foreach ($less_adjustments as $data) {
        echo "function less_".$data['accDetailID']."()\n";
        echo "{";
        echo "    if (trim(\$('lessf_".$data['accDetailID']."').value)==\"\") { \n";
        echo "        \$('lessf_".$data['accDetailID']."').value=\"0.0\"; \n";
        echo "    } \n";
        echo "\n";    
        echo "    if (!isFloatNumber(\$('lessf_".$data['accDetailID']."').value)) { \n";
        echo "        alert(\"Error: Invalid value in Tuition\"); \n";
        echo "        \$('lessf_".$data['accDetailID']."').value=\"".$data['amount']."\"; \n";
        echo "    } else { \n";
        echo "        $('lessf_".$data['accDetailID']."').value=parseFloat($('lessf_".$data['accDetailID']."').value).toFixed(2); \n";
        echo "    } \n";
        echo "\n";    
        echo "    recalculate(); \n";
        echo "} \n\n";
    }
}

?>


</script>