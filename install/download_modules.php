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
require_once('ModuleInstall/PackageManager/PackageManagerDisplay.php');
if( !isset( $install_script ) || !$install_script ){
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}
///////////////////////////////////////////////////////////////////////////////
////    PREFILL $sugar_config VARS
if(empty($sugar_config['upload_dir'])) {
    $sugar_config['upload_dir'] = 'cache/upload/';
}
if(empty($sugar_config['upload_maxsize'])) {
    $sugar_config['upload_maxsize'] = 8192000;
}
if(empty($sugar_config['upload_badext'])) {
    $sugar_config['upload_badext'] = array('php', 'php3', 'php4', 'php5', 'pl', 'cgi', 'py', 'asp', 'cfm', 'js', 'vbs', 'html', 'htm');
}
////    END PREFILL $sugar_config VARS
///////////////////////////////////////////////////////////////////////////////
require_once('include/utils/zip_utils.php');
require_once('include/utils/file_utils.php');
require_once('include/upload_file.php');
require_once('include/dir_inc.php');
require_once('log4php/LoggerManager.php');

$GLOBALS['log'] = LoggerManager::getLogger('SugarCRM');

///////////////////////////////////////////////////////////////////////////////
////    PREP VARS FOR LANG PACK
    $base_upgrade_dir       = $sugar_config['upload_dir'] . "upgrades";
    $base_tmp_upgrade_dir   = $base_upgrade_dir."/temp";
///////////////////////////////////////////////////////////////////////////////    

///////////////////////////////////////////////////////////////////////////////
////    HANDLE FILE UPLOAD AND PROCESSING
$errors = array();
$uploadResult = '';
//commitModules();
if(isset($_REQUEST['languagePackAction']) && !empty($_REQUEST['languagePackAction'])) {
    switch($_REQUEST['languagePackAction']) {
        case 'upload':
        $perform = false;
        $tempFile = '';
        if(isset($_REQUEST['release_id']) && $_REQUEST['release_id'] != ""){
            require_once('ModuleInstall/PackageManager/PackageManager.php');
            $pm = new PackageManager();
            $tempFile = $pm->download($_REQUEST['release_id'], getcwd().'/'.$sugar_config['upload_dir']);    
            $perform = true;
            //$base_filename = urldecode($tempFile);
        }else{
            $file = new UploadFile('language_pack');
            if($file->confirm_upload()){
            $perform = true; 
             if(strpos($file->mime_type, 'zip') !== false) { // only .zip files
                    if(langPackFinalMove($file)) {
                        $perform = true; 
                    }
                    else {
                        $errors[] = $mod_strings['ERR_LANG_UPLOAD_3'];   
                    }
                } else {
                    $errors[] = $mod_strings['ERR_LANG_UPLOAD_2'];
                } 
            }
        }
            
    
            if($perform) { // check for a real file               
                        $uploadResult = $mod_strings['LBL_LANG_SUCCESS'];
                        $result = langPackUnpack('langpack', $tempFile);                   
            } else {
                $errors[] = $mod_strings['ERR_LANG_UPLOAD_1'];
            }
            
            if(count($errors) > 0) {
                foreach($errors as $error) {
                    $uploadResult .= $error."<br />";
                }
            }       
            break; // end 'validate'
        case 'commit':
            $sugar_config = commitModules(false, 'langpack');
            break;
        case 'uninstall': // leaves zip file in "uploaded" state
            $sugar_config = uninstallLanguagePack();
            break;
        case 'remove':
            removeLanguagePack();
            break;
        default:
            break;                   
    }
}
////    END HANDLE FILE UPLOAD AND PROCESSING
///////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////
////    PRELOAD DISPLAY DATA
$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_filesize_bytes = return_bytes($upload_max_filesize);
$fileMaxSize ='';
define('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES', 6 * 1024 * 1024);
if($upload_max_filesize_bytes < constant('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES')) {
    $GLOBALS['log']->debug("detected upload_max_filesize: $upload_max_filesize");
    $fileMaxSize = '<p class="error">'.$mod_strings['ERR_UPLOAD_MAX_FILESIZE']."</p>\n";
}
$availablePatches = getLangPacks(false);
$installedLanguagePacks = getInstalledLangPacks();
$errs = '';
if(isset($validation_errors)) {
    if(count($validation_errors) > 0) {
        $errs  = '<div id="errorMsgs">';
        $errs .= "<p>{$mod_strings['LBL_SYSOPTS_ERRS_TITLE']}</p>";
        $errs .= '<ul>';

        foreach($validation_errors as $error) {
            $errs .= '<li>' . $error . '</li>';
        }

        $errs .= '</ul>';
        $errs .= '</div>';
    }
}

////    PRELOAD DISPLAY DATA
///////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////
////    BEING PAGE OUTPUT
$disabled = "";
$result = "";
$out =<<<EOQ
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Script-Type" content="text/javascript">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <title>{$mod_strings['LBL_WIZARD_TITLE']} {$next_step}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install.css" type="text/css">
   <script type="text/javascript" src="install/installCommon.js"></script><script type="text/javascript" src="include/javascript/cookie.js?s=4.5.0d&c="></script><link rel="stylesheet" type="text/css" media="all" href="themes/Sugar/calendar-win2k-cold-1.css?s=4.5.0d&c="><script>jscal_today = 1161698116000; if(typeof app_strings == "undefined") app_strings = new Array();</script><script type="text/javascript" src="jscalendar/calendar.js?s=4.5.0d&c="></script><script type="text/javascript" src="jscalendar/lang/calendar-en.js?s=4.5.0d&c="></script><script type="text/javascript" src="jscalendar/calendar-setup_3.js?s=4.5.0d&c="></script><script src="include/javascript/yui/YAHOO.js?s=4.5.0d&c="></script><script src="include/javascript/yui/log.js?s=4.5.0d&c="></script><script src="include/javascript/yui/dom.js?s=4.5.0d&c="></script><script src="include/javascript/yui/event.js?s=4.5.0d&c="></script><script src="include/javascript/yui/animation.js?s=4.5.0d&c="></script><script src="include/javascript/yui/connection.js?s=4.5.0d&c="></script><script src="include/javascript/yui/dragdrop.js?s=4.5.0d&c="></script><script src="include/javascript/yui/ygDDList.js?s=4.5.0d&c="></script><script type="text/javascript" src="include/javascript/sugar_3.js?s=4.5.0d&c="></script>
</head>

<body onLoad="document.getElementById('defaultFocus').focus();">
{$fileMaxSize}
  <table cellspacing="0" width="100%" cellpadding="0" border="0" align="center" class="shell">
    <tr>
      <th width="400">{$mod_strings['LBL_STEP']} {$next_step}: {$mod_strings['LBL_MODULE_TITLE']}</th>
      <th width="200" height="30" style="text-align: right;"><a href="http://www.sugarcrm.com" target=
      "_blank"><IMG src="include/images/sugarcrm_login.png" width="120" height="19" alt="SugarCRM" border="0"></a></th>
    </tr>

    <tr>
        <td colspan="2">
            <p>{$mod_strings['LBL_LANG_1']}</p>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="StyleDottedHr">
                <tr>
                    <th colspan="2" align="left">{$mod_strings['LBL_LANG_TITLE']}</th>
                </tr>
                <tr>
                    <td colspan="2">
EOQ;
$form =<<<EOQ1
                    <form name="the_form" enctype="multipart/form-data" 
                        action="install.php" method="post">
                        <input type="hidden" name="current_step" value="{$next_step}">
                        <input type="hidden" name="goto" value="{$mod_strings['LBL_CHECKSYS_RECHECK']}">
                        <input type="hidden" name="languagePackAction" value="upload">
                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabForm">
                        <tr>
                            <td>
                                <table width="450" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
										<td colspan='2'>
											 {$mod_strings['LBL_LANG_UPLOAD']}:<br />
										</td>
									</tr>
									<tr>
                                        <td>
                                           
                                            <input type="file" name="language_pack" size="40" />
                                        </td>
                                        <td valign="bottom">
                                            <input class='button' type=button value="{$mod_strings['LBL_LANG_BUTTON_UPLOAD']}" 
                                                onClick="document.the_form.language_pack_escaped.value = escape( document.the_form.language_pack.value );
                                                         document.the_form.submit();"
                                            />
                                            <input type=hidden name="language_pack_escaped" value="" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {$uploadResult}
                            </td>
                        </tr>
                    </table>
                    </form>
EOQ1;
$out1 =<<<EOQ2
                  </td>
                </tr>
                <tr>
                    <td colspan=2>
                        {$result}
                    </td>
                </tr>
                <!--// Available Upgrades //-->
                <tr>
                    <td align="left" colspan="2">
                        <hr>
                        <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
                            {$availablePatches}
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="right" colspan="2">
                        <hr>
                        <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
                        <tr><td><form action='install.php' method='POST' name='install_form'>
                                <input type='hidden' name='current_step' value="{$next_step}">
                                <input type='hidden' name='goto' value="{$mod_strings['LBL_CHECKSYS_RECHECK']}">
                                <input type='hidden' name='languagePackAction' value='commit'> 
                                <input type='submit' value='Install' class='button'>
                                {$_SESSION['hidden_input']}
                                </form>
                        </td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="2">
                        <hr>
                        <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
                            {$installedLanguagePacks}
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="right" colspan="2">
                        <hr>
                         <form name="the_form1" action="install.php" method="post">
                        <input type="hidden" name="current_step" value="{$next_step}">
                        <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
                            <tr>
                                <td>
                                    <input class="button" type="button" onclick="window.open('http://www.sugarcrm.com/forums/');" value="{$mod_strings['LBL_HELP']}" />
                                </td>
                                <td>
                                   
                                </td>
                                <td>
                                    <input class="button" type="submit" name="goto" value="{$mod_strings['LBL_NEXT']}" id="defaultFocus" {$disabled} />
                                </td>
                            </tr>
                        </table>
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
EOQ2;
$hidden_fields =  "<input type=\"hidden\" name=\"current_step\" value=\"{$next_step}\">";
$hidden_fields .=  "<input type=\"hidden\" name=\"goto\" value=\"{$mod_strings['LBL_CHECKSYS_RECHECK']}\">";
$hidden_fields .=  "<input type=\"hidden\" name=\"languagePackAction\" value=\"commit\">";
//$form2 = PackageManagerDisplay::buildPackageDisplay($form, $hidden_fields, 'install.php', array('langpack'), 'form1', true);
$form2 = PackageManagerDisplay::buildPatchDisplay($form, $hidden_fields, 'install.php', array('langpack'));

echo $out.$form2.$out1;

//unlinkTempFiles('','');
////    END PAGEOUTPUT
///////////////////////////////////////////////////////////////////////////////
?>
