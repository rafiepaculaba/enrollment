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
global $college_yrs;

require_once('config.php');
require_once('include/Sugar_Smarty.php');

require_once('common.php');
require_once('modules/Students/StudentHS.php');

global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("List HS Student");
if ($access->check_access($current_user->id,$accessCode)) {
    $stud = new Student();
    
    $limit  = 15;
    $offset = $_GET['offset']? $_GET['offset']:0;
    
    if ($_GET['cmdFilter']) {
        $idno       = $_GET['idno'];
        $lname      = $_GET['lname'];
    } else {
        $idno     	= $_SESSION[$_GET['module'].'HSpop_idno'];
        $lname     	= $_SESSION[$_GET['module'].'HSpop_lname'];
    }

	//set session variables
	$_SESSION[$_GET['module'].'HSpop_idno']   = $idno;
	$_SESSION[$_GET['module'].'HSpop_lname']  = $lname;
    
    if ($idno) {
        $conds[0]['idno'] = "= '$idno' AND ";
    }
        
    if ($lname) {
       $conds[0]['lname'] = " like '$lname%' AND ";
    }
    
    $conds[0]['rstatus'] = "= 1 ";
    
//    $allStudents = $stud->retrieveAllStudents($conds);
    $allStudents = $stud->countAllStudents($conds);
    $list        = $stud->retrieveAllStudents($conds,"lname","ASC",$offset, $limit);
    
    $total_rec=$allStudents;
    $main_url="index.php?module=Refunds&action=listStudentsHS&idno=$idno&lname=$lname&sugar_body_only=1";
    
    // check if the list is empty
    if (!count($list)) {
        $list = "";
    }
    
    $sugar_smarty->assign('list', $list );
    $sugar_smarty->assign('idno', $idno );
    $sugar_smarty->assign('lname', $lname );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit,$export_link) );
    
    echo $sugar_smarty->fetch('modules/Refunds/templates/listStudentsHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script type='text/javascript'>
// set focus
document.getElementById('idno').focus();

// set the ID no.
function setID(id)
{
	opener.setIDNO(id);
	window.close();
}
</script>