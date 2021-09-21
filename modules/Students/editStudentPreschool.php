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
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Preschool Student");
if ($access->check_access($current_user->id,$accessCode)) {
    $idno = $_GET['idno'];
    
    if (!$idno) {
        $msg = "Opps! no Student ID seleted.";
        $sugar_smarty->assign('class', 'errorbox');
        $sugar_smarty->assign('display', 'block');
        $sugar_smarty->assign('msg', $msg );
        echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    } else {
        
        $stud = new Student($idno);
        
        $sugar_smarty->assign('recID', $stud->recID );
        $sugar_smarty->assign('idno', $stud->idno );
        $sugar_smarty->assign('regID', $stud->regID );
        $sugar_smarty->assign('fname', $stud->fname );
        $sugar_smarty->assign('lname', $stud->lname );
        $sugar_smarty->assign('mname', $stud->mname );
        $sugar_smarty->assign('yrLevel', $stud->yrLevel );
        $sugar_smarty->assign('gender', $stud->gender );
        $sugar_smarty->assign('age', $stud->age );
        
        // bday
        $bday = explode("-",$stud->bday);
        $year = $bday[0];
        $mon  = $bday[1];
        $day  = $bday[2];
        $sugar_smarty->assign('year', $year );
        
        $sugar_smarty->assign('permanentAddr', $stud->permanentAddr );
        $sugar_smarty->assign('currentAddr', $stud->currentAddr );
        $sugar_smarty->assign('phone', $stud->phone );
        $sugar_smarty->assign('cstatus', $stud->cstatus );
        $sugar_smarty->assign('nationality', $stud->nationality );
        $sugar_smarty->assign('fatherName', $stud->fatherName );
        $sugar_smarty->assign('motherName', $stud->motherName );
        $sugar_smarty->assign('guardian', $stud->guardian );
            
        $sugar_smarty->assign('fatherOccupation', $stud->fatherOccupation );
        $sugar_smarty->assign('motherOccupation', $stud->motherOccupation );
        $sugar_smarty->assign('guardianOccupation', $stud->guardianOccupation );
        
        $sugar_smarty->assign('fatherContact', $stud->fatherContact );
        $sugar_smarty->assign('motherContact', $stud->motherContact );
        $sugar_smarty->assign('guardianContact', $stud->guardianContact );
        $sugar_smarty->assign('entryDocs', $stud->entryDocs );
        $sugar_smarty->assign('rstatus', $stud->rstatus );
        
        // months list
        $months=array(
        1=>'January',
        2=>'February',
        3=>'March',
        4=>'April',
        5=>'May',
        6=>'June',
        7=>'July',
        8=>'August',
        9=>'September',
        10=>'October',
        11=>'November',
        12=>'December'
        );
        
        $month_object = '<select name="month">';
        foreach ($months as $key=>$month) {
            if ($key==$mon)
                $month_object .= '<option value="'.$key.'" selected>'.$month.'</option>';
            else
                $month_object .= '<option value="'.$key.'">'.$month.'</option>';
        }
        $month_object .= '</select>';
        
        $sugar_smarty->assign('month_object', $month_object );
        
        
        $day_object = '<select name="day">';
        for($i=1; $i<=31; $i++) {
            if ($i==$day)
                $day_object .= '<option value="'.$i.'" selected>'.$i.'</option>';
            else
                $day_object .= '<option value="'.$i.'">'.$i.'</option>';
        }
        $day_object .= '</select>';
        
        $sugar_smarty->assign('day_object', $day_object );
        
        
        // year levels
	    $yrLevel_object = '<select name="yrLevel" id="yrLevel">'."\n";
	    $yrLevel_object .= '<option value="">--------</option>'."\n";
	    foreach ($preschool_yrs as $key=>$val) {
	        if ($key==$stud->yrLevel)
	            $yrLevel_object .= '<option value="'.$key.'" selected>'.$val.'</option>'."\n";
	        else
	            $yrLevel_object .= '<option value="'.$key.'">'.$val.'</option>."\n"';
	    }
	    $yrLevel_object .= '</select>'."\n";
	    $sugar_smarty->assign('yrLevel_object', $yrLevel_object );
        
        echo $sugar_smarty->fetch('modules/Students/templates/editStudentPreschool.tpl');
    }
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script>
addToValidate('frmStudent','idno', '', true, 'Student ID No.');
addToValidate('frmStudent','lname', '', true, 'Last Name');
addToValidate('frmStudent','fname', '', true, 'First Name');
addToValidate('frmStudent','mname', '', true, 'Middle Name');
addToValidate('frmStudent','yrLevel', '', true, 'Grade');
addToValidate('frmStudent','month', '', true, 'Birth Month');
addToValidate('frmStudent','day', '', true, 'Birth Date');
addToValidate('frmStudent','year', '', true, 'Birth Year');
addToValidate('frmStudent','cstatus', '', true, 'Civil Status');
addToValidate('frmStudent','gender', '', true, 'Gender');
addToValidate('frmStudent','nationality', '', true, 'Nationality');
addToValidate('frmStudent','permanentAddr', '', true, 'Permanent Address');
</script>