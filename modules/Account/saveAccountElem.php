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
require_once('modules/Account/AccountElemLog.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_ACCT_ELEM'], false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['accID'])) {
    $accID = $_POST['accID'];
    $account = new Account($accID);
} else {
    $account = new Account();
}

// check if comes from correct form
if ( isset($_POST['theForm']) ) {
    
    if (isset($_POST['accID'])) {
        $account->accID = $_POST['accID'];
    }
	
	if ($account->accID) {
	    
	    $account->retrieveAccount();
	    
	    $account_detail = new AccountDetail();
	    
	    // update existing record
	    $account->idno        = $_POST['idno'];
        $account->schYear     = $_POST['schYear'];
        $account->oldBalance  = $_POST['oldBalance'];
        $account->totalFee    = $_POST['totalFee'];
        $account->payment     = $_POST['payment'];
        $account->balance     = $_POST['balance'];

        if ($account->details) {
            foreach ($account->details as $data) {
                $accDetailID = $account_detail->accDetailID = $data['accDetailID'];
                
                if (strtoupper($data['feeType'])=="ADD") {
                      if ( isset($_POST["addf_$accDetailID"]) ) {  
                      	
                      	if ($data['amount']!=$_POST['addf_'.$data['accDetailID']]) {
                      		if ($changes_for_log) {
                      			$changes_for_log .= "<br>";
                      		}
                      		$changes_for_log .= $data['particular'].": ".$data['amount']." to ".$_POST['addf_'.$data['accDetailID']];
                      	}
                      	
                        $account_detail->amount      = $_POST['addf_'.$data['accDetailID']];
                        $account_detail->updateAccountDetail();
                    }
    	        } else if (strtoupper($data['feeType'])=="LESS") {
                      if ( isset($_POST["lessf_$accDetailID"]) ) {
                      	
                      	if ($data['amount']!=$_POST['lessf_'.$data['accDetailID']]) {
                      		if ($changes_for_log) {
                      			$changes_for_log .= "<br>";
                      		}
                      		$changes_for_log .= $data['particular'].": ".$data['amount']." to ".$_POST['lessf_'.$data['accDetailID']];
                      	}
                      	
                        $account_detail->amount      = $_POST['lessf_'.$data['accDetailID']];
                        $account_detail->updateAccountDetail();
                    }
    	        } else {
    	            if ( isset($_POST["feesf_$accDetailID"]) ) {
    	            	
    	            	if ($data['amount']!=$_POST['feesf_'.$data['accDetailID']]) {
                      		if ($changes_for_log) {
                      			$changes_for_log .= "<br>";
                      		}
                      		$changes_for_log .= $data['particular'].": ".$data['amount']." to ".$_POST['feesf_'.$data['accDetailID']];
                      	}
    	            	
                        $account_detail->amount      = $_POST['feesf_'.$data['accDetailID']];
                        $account_detail->updateAccountDetail();
                    }
    	        }
            }
        }
	    
	    // update student record
	    if ($account->updateAccount()) {
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
    		
    		
    		// logging here------------------------------------------------------
		        $accountLog = new AccountLog();
		        $accountLog->recID 	= $account->accID;
		        $accountLog->operation 	= "Edit";
		        $accountLog->changes= $changes_for_log;
		        $accountLog->changeBy= $current_user->id;
		        $accountLog->createAccountLog();
	        //-------------------------------------------------------------------
	        
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	} else {
	    
	    // update existing record
	    $account->idno        = $_POST['idno'];
        $account->schYear     = $_POST['schYear'];
        $account->oldBalance  = $_POST['oldBalance'];
        $account->totalFee    = $_POST['totalFee'];
        $account->payment     = $_POST['payment'];
        $account->balance     = $_POST['balance'];
	    
	    // new student record
    	if ($account->createAccount()) {
    		$msg = "Record successfully saved!";
    		$sugar_smarty->assign('class', 'notificationbox');
    	} else {
    	    $msg = "Record was not successfully saved!";
    	    $sugar_smarty->assign('class', 'errorbox');
    	}
	}
	
	$sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Account&action=viewAccountElem&accID=<?php echo $account->accID; ?>')",3000);
</script>