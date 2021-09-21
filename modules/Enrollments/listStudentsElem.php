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
global $elementary_yrs;

require_once('include/Sugar_Smarty.php');
require_once('common.php');
require_once('modules/Students/StudentElem.php');

global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$stud = new Student();

$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
$offset = $_GET['offset']? $_GET['offset']:0;

// set session variables
$_SESSION[$_GET['module'].'HSpop_idno']   = $idno;
$_SESSION[$_GET['module'].'HSpop_lname']  = $lname;
$_SESSION[$_GET['module'].'HSpop_fname']  = $fname;
$_SESSION[$_GET['module'].'HSpop_mname']  = $mname;
$_SESSION[$_GET['module'].'HSpop_yrLevel']  = $yrLevel;

if ($_GET['cmdFilter']) {
    $idno   = $_GET['idno'];
    $lname  = $_GET['lname'];
    $fname  = $_GET['fname'];
    $mname  = $_GET['mname'];
    $yrLevel  = $_GET['yrLevel'];
} else {
    $idno   = $_SESSION[$_GET['module'].'Elempop_idno'];
    $lname  = $_SESSION[$_GET['module'].'Elempop_lname'];
    $fname  = $_SESSION[$_GET['module'].'Elempop_fname'];
    $mname  = $_SESSION[$_GET['module'].'Elempop_mname'];
    $yrLevel  = $_SESSION[$_GET['module'].'Elempop_yrLevel'];
}

// set session variables
$_SESSION[$_GET['module'].'Elempop_idno']   = $idno;
$_SESSION[$_GET['module'].'Elempop_lname']  = $lname;
$_SESSION[$_GET['module'].'Elempop_fname']  = $fname;
$_SESSION[$_GET['module'].'Elempop_mname']  = $mname;
$_SESSION[$_GET['module'].'Elempop_yrLevel']  = $yrLevel;

if ($idno) {
    $conds[0]['idno'] = "= '$idno' AND ";
}
    
if ($lname) {
   $conds[0]['lname'] = " like '$lname%' AND ";
}

if ($fname) {
   $conds[0]['fname'] = " like '$fname%' AND ";
}

if ($mname) {
   $conds[0]['mname'] = " like '$mname%' AND ";
}

if ($yrLevel) {
   $conds[0]['yrLevel'] = " = '$yrLevel' AND ";
}

$conds[0]['rstatus'] = "= 1 ";

$allStudents = $stud->countAllStudents($conds);
$list        = $stud->retrieveAllStudents($conds,"lname","ASC",$offset, $limit);

$total_rec=$allStudents;

$main_url="index.php?module=Enrollments&action=listStudentsElem&idno=$idno&lname=$lname";

// check if the list is empty
if (!count($list)) {
    $list = "";
}

$sugar_smarty->assign('idno', $idno );
$sugar_smarty->assign('lname', $lname );
$sugar_smarty->assign('yrLevel', $yrLevel );
$sugar_smarty->assign('list', $list );
$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit,$export_link,$print_link) );

echo $sugar_smarty->fetch('modules/Enrollments/templates/listStudentsElem.tpl');
?>



<script type='text/javascript'>
// set the ID no.
function setID(id)
{
	opener.setIDNO(id);
	window.close();
}

// set focus
document.getElementById('idno').focus();
</script>