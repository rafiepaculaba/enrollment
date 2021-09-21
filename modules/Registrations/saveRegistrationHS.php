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
require_once('modules/Registrations/RegistrationHS.php');


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_HS']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['regID'])) {
    $regID = $_POST['regID'];
    $reg = new Registration($regID);
} else {
    $reg = new Registration();
}

// clear the transactions
//if ( $reg->db->beginTransaction() ) {
//   $reg->db->rollBack();
//}

// check if comes from correct form
if ( isset($_POST['cmdSave']) ) {
    
    if (isset($_POST['regID'])) {
        $reg->regID = $_POST['regID'];
    }
	
	if ($reg->regID) {
	    // update existing record
	    
        $reg->fname          = $_POST['fname'];
        $reg->lname          = $_POST['lname'];
        $reg->mname          = $_POST['mname'];
        $reg->gender         = $_POST['gender'];
        $reg->age            = $_POST['age'];
        $reg->bday           = date("Y-m-d", strtotime($_POST['month']."/".$_POST['day']."/".$_POST['year']));
        $reg->cstatus        = $_POST['cstatus'];
        $reg->nationality    = $_POST['nationality'];
        $reg->entryDocs      = $_POST['entryDocs'];
        $reg->lastSchool     = $_POST['lastSchool'];
        
        if ($_POST['sch_last_attended']) {
            $reg->sch_last_attended = date("Y-m-d",strtotime($_POST['sch_last_attended']));
        } else {
            $reg->sch_last_attended = "";
        }
	    
	    // update registrant record
	    if ($reg->updateRegistration()) {
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	    
	    $lastID = $reg->regID;
	} else {
	    // create new record
	    
        $reg->regID          = $_POST['regID'];
        $reg->fname          = $_POST['fname'];
        $reg->lname          = $_POST['lname'];
        $reg->mname          = $_POST['mname'];
        $reg->gender         = $_POST['gender'];
        $reg->age            = $_POST['age'];
        $reg->bday           = date("Y-m-d", strtotime($_POST['month']."/".$_POST['day']."/".$_POST['year']));
        $reg->cstatus        = $_POST['cstatus'];
        $reg->nationality    = $_POST['nationality'];
        $reg->entryDocs      = $_POST['entryDocs'];
        $reg->lastSchool     = $_POST['lastSchool'];
        
        if ($_POST['sch_last_attended']) {
            $reg->sch_last_attended = date("Y-m-d",strtotime($_POST['sch_last_attended']));
        }
        
        $reg->regDate        = date("Y-m-d",time());
        $reg->encodedBy      = $current_user->id;
	    
	    // new student record
    	if ($reg->createRegistration()) {
    		$msg = "Record successfully saved!";
    		$sugar_smarty->assign('class', 'notificationbox');
    	} else {
    	    $msg = "Record was not successfully saved!";
    	    $sugar_smarty->assign('class', 'errorbox');
    	}
    	
    	$lastID = $reg->getLastID();
	}
	
	$sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Registrations&action=viewRegistrationHS&regID=<?php echo $lastID; ?>')",3000);
</script>