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
 <tr>
	<td class="tabDetailViewDL2" nowrap><?php echo get_image($image_path.'Repair','alt="'. $mod_strings['LBL_REPAIR_DATABASE'].'" align="absmiddle" border="0"'); ?>&nbsp;<a href="./index.php?module=Administration&action=repairDatabase"><?php echo $mod_strings['LBL_REPAIR_DATABASE']; ?></a></td>
	<td class="tabDetailViewDF2"> <?php echo $mod_strings['LBL_REPAIR_DATABASE_DESC'] ; ?> </td>
</tr>
 ********************************************************************************/



global $app_strings;
global $app_list_strings;
global $mod_strings;
global $theme;
global $currentModule;
global $gridline;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
require_once($theme_path.'layout_utils.php');


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_UPGRADE_TITLE'], false);
echo "\n</p>\n";

?>
<p>
<table width="100%" cellpadding="0" cellspacing="<?php echo $gridline;?>" border="0" class="tabDetailView2">

<tr>
    <td class="tabDetailViewDL2" nowrap><?php echo get_image($image_path.'Rebuild','alt="'. $mod_strings['LBL_REBUILD_HTACCESS'].'" align="absmiddle" border="0"'); ?>&nbsp;<a href="./index.php?module=Administration&action=UpgradeAccess"><?php echo $mod_strings['LBL_REBUILD_HTACCESS']; ?></a></td>
    <td class="tabDetailViewDF2"> <?php echo $mod_strings['LBL_REBUILD_HTACCESS_DESC'] ; ?> </td>
</tr>
<tr>
    <td class="tabDetailViewDL2" nowrap><?php echo get_image($image_path.'Rebuild','alt="'. $mod_strings['LBL_REBUILD_CONFIG'].'" align="absmiddle" border="0"'); ?>&nbsp;<a href="./index.php?module=Administration&action=RebuildConfig"><?php echo $mod_strings['LBL_REBUILD_CONFIG']; ?></a></td>
    <td class="tabDetailViewDF2"> <?php echo $mod_strings['LBL_REBUILD_CONFIG_DESC'] ; ?> </td>
</tr>
</table></p>
