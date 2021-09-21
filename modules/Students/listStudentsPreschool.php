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
global $preschool_yrs;

require_once('include/Sugar_Smarty.php');
require_once('common.php');
require_once('modules/Students/StudentPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Preschool Student");
if ($access->check_access($current_user->id,$accessCode)) {
    $stud = new Student();
    
    $limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
    $offset = $_GET['offset']? $_GET['offset']:0;
    
    if ($_GET['cmdFilter']) {
        $idno   = $_GET['idno'];
        $lname  = $_GET['lname'];
        $fname  = $_GET['fname'];
        $mname  = $_GET['mname'];
        $yrLevel  = $_GET['yrLevel'];
    } else {
        $idno   = $_SESSION[$_GET['module'].'Preschool_idno'];
        $lname  = $_SESSION[$_GET['module'].'Preschool_lname'];
        $fname  = $_SESSION[$_GET['module'].'Preschool_fname'];
        $mname  = $_SESSION[$_GET['module'].'Preschool_mname'];
        $yrLevel  = $_SESSION[$_GET['module'].'Preschool_yrLevel'];
    }
    
    // set session variables
    $_SESSION[$_GET['module'].'Preschool_idno']   = $idno;
    $_SESSION[$_GET['module'].'Preschool_lname']  = $lname;
    $_SESSION[$_GET['module'].'Preschool_fname']  = $fname;
    $_SESSION[$_GET['module'].'Preschool_mname']  = $mname;
    $_SESSION[$_GET['module'].'Preschool_yrLevel']  = $yrLevel;
    
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
    
//    $allStudents = $stud->retrieveAllStudents($conds);
    $allStudents = $stud->countAllStudents($conds);
    $list        = $stud->retrieveAllStudents($conds,"lname","ASC",$offset, $limit);
    
    $total_rec=$allStudents;
//    if ($allStudents)
//    	$total_rec=count($allStudents);
//    else 
//    	$total_rec=0;
    
    // for printing query settings
    $_SESSION['PRINT_CONDS']  = $conds;
    $_SESSION['PRINT_OFFSET'] = $offset;
    $_SESSION['PRINT_LIMIT']  = $limit;
    
    //$export_link = "index.php?module=Students&action=export&level=3";
    $print_link = "index.php?module=Students&action=printStudentsPreschool&sugar_body_only=1";
    
    $main_url="index.php?module=Students&action=listStudentsPreschool&idno=$idno&lname=$lname&fname=$fname&mname=$mname&yrLevel=$yrLevel";
    
    // check if the list is empty
    if (!count($list)) {
        $list = "";
    }
    
    
    // year levels
    $yrLevel_object = '<select name="yrLevel" id="yrLevel">'."\n";
    $yrLevel_object .= '<option value="">--------</option>'."\n";
    foreach ($preschool_yrs as $key=>$val) {
        if ($key==$yrLevel)
            $yrLevel_object .= '<option value="'.$key.'" selected>'.$val.'</option>'."\n";
        else
            $yrLevel_object .= '<option value="'.$key.'">'.$val.'</option>."\n"';
    }
    $yrLevel_object .= '</select>'."\n";
    $sugar_smarty->assign('yrLevel_object', $yrLevel_object );
    
    
    $sugar_smarty->assign('idno', $idno );
    $sugar_smarty->assign('lname', $lname );
    $sugar_smarty->assign('fname', $fname );
    $sugar_smarty->assign('mname', $mname );
    $sugar_smarty->assign('yrLevel', $yrLevel );
    $sugar_smarty->assign('list', $list );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit,$export_link,$print_link) );
    
    echo $sugar_smarty->fetch('modules/Students/templates/listStudentsPreschool.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script type='text/javascript'>
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=500,left = 0,top = 0');");
}

// set focus
$('idno').focus();
</script>