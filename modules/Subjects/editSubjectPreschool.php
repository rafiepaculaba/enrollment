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
require_once('modules/Subjects/SubjectPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("Edit Preschool Subject");
if ($access->check_access($current_user->id,$accessCode)) {
	
	$subjID = $_GET['subjID'];
	
	$subj = new Subject();
	
	$subj->subjID = $subjID;
	$subj->retrieveSubject(1); // locked
	
	$sugar_smarty->assign('subjID', $subj->subjID );
	$sugar_smarty->assign('yrLevel', $subj->yrLevel );
	$sugar_smarty->assign('subjCode', $subj->subjCode );
	$sugar_smarty->assign('descTitle', $subj->descTitle );
	$sugar_smarty->assign('subjDesc', $subj->subjDesc );
	$sugar_smarty->assign('units', $subj->units );
	$sugar_smarty->assign('type', $subj->type );
	$sugar_smarty->assign('rstatus', $subj->rstatus );
	
	$yearLevel='<select name="yrLevel" id="yrLevel" disabled>'."\n";
    $yearLevel.='<option value="">----------------</option>'."\n";
    if ($preschool_yrs) {
        foreach ($preschool_yrs as $key=>$value) {
            if ($key==$subj->yrLevel) {
                $yearLevel .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $yearLevel .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $yearLevel.='</select>';
    $sugar_smarty->assign('YEARLEVEL', $yearLevel);

    echo $sugar_smarty->fetch('modules/Subjects/templates/editSubjectPreschool.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
	
?>

<script>
addToValidate('frmSubjectPreschool','yrLevel', '', true, 'Grade Level');
addToValidate('frmSubjectPreschool','subjCode', '', true, 'Subject Code');
addToValidate('frmSubjectPreschool','descTitle', '', true, 'Descriptive Title');
</script>

<script language="javascript">
function onSubmit()
{
    if (check_form('frmSubjectPreschool')) {
    	
    	$('yrLevel').disabled = false;
    	$('type1').disabled = false;
    	$('type2').disabled = false;
    	
    	$('frmSubjectPreschool').submit();
    }
}
// set focus
$('descTitle').focus();
</script>