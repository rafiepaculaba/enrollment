<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * Upgrade Wizard
 *
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
 */



require_once('modules/Administration/UpgradeWizardCommon.php');
require_once('ModuleInstall/PackageManager/PackageManagerDisplay.php');
global $mod_strings;
$uh = new UpgradeHistory();

function unlinkTempFiles() {
	global $sugar_config;
	@unlink($_FILES['upgrade_zip']['tmp_name']);
	@unlink(getcwd().'/'.$sugar_config['upload_dir'].$_FILES['upgrade_zip']['name']);
}

// make sure dirs exist
foreach( $subdirs as $subdir ){
    mkdir_recursive( "$base_upgrade_dir/$subdir" );
}

// get labels and text that are specific to either Module Loader or Upgrade Wizard
if( $view == "module") {
	$uploaddLabel = $mod_strings['LBL_UW_UPLOAD_MODULE'];
	$descItemsQueued = $mod_strings['LBL_UW_DESC_MODULES_QUEUED'];
	$descItemsInstalled = $mod_strings['LBL_UW_DESC_MODULES_INSTALLED'];
}
else {
	$uploaddLabel = $mod_strings['LBL_UPLOAD_UPGRADE'];
	$descItemsQueued = $mod_strings['DESC_FILES_QUEUED'];
	$descItemsInstalled = $mod_strings['DESC_FILES_INSTALLED'];
}

//
// check that the upload limit is set to 6M or greater
//

define('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES', 6 * 1024 * 1024);  // 6 Megabytes

$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_filesize_bytes = return_bytes($upload_max_filesize);
if($upload_max_filesize_bytes < constant('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES'))
{
	$GLOBALS['log']->debug("detected upload_max_filesize: $upload_max_filesize");
	print('<p class="error">' . $mod_strings['MSG_INCREASE_UPLOAD_MAX_FILESIZE'] . ' '
		. get_cfg_var('cfg_file_path') . "</p>\n");
}

//
// process "run" commands
//

if( isset( $_REQUEST['run'] ) && ($_REQUEST['run'] != "") ){
    $run = $_REQUEST['run'];

    if( $run == "upload" ){
        $perform = false;
        if(isset($_REQUEST['release_id']) && $_REQUEST['release_id'] != ""){
            require_once('ModuleInstall/PackageManager.php');
            $pm = new PackageManager();
            $tempFile = $pm->download('','',$_REQUEST['release_id'], getcwd().'/'.$sugar_config['upload_dir']);    
            $perform = true;
            $base_filename = urldecode($tempFile);
        }
        else if( empty( $_FILES['upgrade_zip']['tmp_name'] ) ){
            echo $mod_strings['ERR_NO_UPLOAD_FILE'];
        }
        else{
        	if(!move_uploaded_file($_FILES['upgrade_zip']['tmp_name'], getcwd().'/'.$sugar_config['upload_dir'].$_FILES['upgrade_zip']['name'])) {
			unlinkTempFiles();
        		die($mod_strings['ERR_NOT_VALID_UPLOAD']);
        	} else {
			     $tempFile = getcwd().'/'.$sugar_config['upload_dir'].$_FILES['upgrade_zip']['name'];
                 $perform = true;
                 $base_filename = urldecode( $_REQUEST['upgrade_zip_escaped'] );
		    }
        }
        if($perform){
            $manifest_file = extractManifest( $tempFile );
				if(is_file($manifest_file))
				{
                    
            	require_once( $manifest_file );
					validate_manifest( $manifest );

					$upgrade_zip_type = $manifest['type'];

					// exclude the bad permutations
					if( $view == "module" )
					{
						if ($upgrade_zip_type != "module" && $upgrade_zip_type != "theme" && $upgrade_zip_type != "langpack")
						{
						unlinkTempFiles();
						 die($mod_strings['ERR_UW_NOT_ACCEPTIBLE_TYPE']);
						}
					}
					elseif( $view == "default" )
					{
						if($upgrade_zip_type != "patch" )
						{
							unlinkTempFiles();
							die($mod_strings['ERR_UW_ONLY_PATCHES']);
						}
					}

					//$base_filename = urldecode( $_REQUEST['upgrade_zip_escaped'] );
					$base_filename = preg_replace( "#\\\\#", "/", $base_filename );
					$base_filename = basename( $base_filename );

					mkdir_recursive( "$base_upgrade_dir/$upgrade_zip_type" );
					$target_path = "$base_upgrade_dir/$upgrade_zip_type/$base_filename";
					$target_manifest = remove_file_extension( $target_path ) . "-manifest.php";

					if( isset($manifest['icon']) && $manifest['icon'] != "" ){
						 $icon_location = extractFile( $tempFile ,$manifest['icon'] );
						 $path_parts = pathinfo( $icon_location );
						 copy( $icon_location, remove_file_extension( $target_path ) . "-icon." . $path_parts['extension'] );
					}

					if( copy( $tempFile , $target_path ) ){
						 copy( $manifest_file, $target_manifest );
						 echo $base_filename.$mod_strings['LBL_UW_UPLOAD_SUCCESS'];
					}
					else{
						 echo $mod_strings['ERR_UW_UPLOAD_ERROR'];
					}
				}
				else
				{
					unlinkTempFiles();
					die($mod_strings['ERR_UW_NO_MANIFEST']);
				}
		  }
    }
    else if( $run == $mod_strings['LBL_UW_BTN_DELETE_PACKAGE'] ){
        if( !isset($_REQUEST['install_file']) || ($_REQUEST['install_file'] == "") ){
            die($mod_strings['ERR_UW_NO_UPLOAD_FILE']);
        }
        $delete_me = urldecode( $_REQUEST['install_file'] );

        $checkFile = clean_path(trim(strtolower($delete_me)));
        
		if(false !== strpos($checkFile, '.zip')) { // is zip file?
			if(false !== strpos($checkFile, $sugar_config['upload_dir'])) { // is in upload dir?
				if(false === strpos($checkFile, "..")) { // no dir navigation
					if(!file_exists($checkFile)) { // file exists?
						if(unlink($delete_me)) { // successful deletion?
							echo "Package $delete_me has been removed.<br>";
						} else {
							die("Problem removing package $delete_me.");
						}
					} else {
						die("<span class='error'>File to be deleted does not exist.</span>");
					}
				} else {
					die("<span class='error'>Path is trying to navigate folders.</span>");
				}
			} else {
				die("<span class='error'>File is not located in SugarCRM's upload cache directory.</span>");
			}
		} else {
			die("<span class='error'>File is not a zipped archive.</span>");
		}
    }
}

print( "<p>\n" );
if( $view == "module") {
	print( get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME'].": ".$mod_strings['LBL_MODULE_LOADER_TITLE'], true) );
}
else {
	print( get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME'].": ".$mod_strings['LBL_UPGRADE_WIZARD_TITLE'], true) );
}
print( "</p>\n" );

// upload link
$form =<<<eoq
<form name="the_form" enctype="multipart/form-data" action="{$form_action}" method="post"  >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabForm">
<tr><td>
<table width="450" border="0" cellspacing="0" cellpadding="0">
<tr><td>
{$uploaddLabel}
<input type="file" name="upgrade_zip" size="40" />
</td>
<td>
<input type=button value="{$mod_strings['LBL_UW_BTN_UPLOAD']}" onClick="document.the_form.upgrade_zip_escaped.value = escape( document.the_form.upgrade_zip.value );document.the_form.submit();" />
<input type=hidden name="run" value="upload" />
<input type=hidden name="upgrade_zip_escaped" value="" />
</td>
</tr>
</table></td></tr></table>
</form>
eoq;
$hidden_fields = "<input type=hidden name=\"run\" value=\"upload\" />";
$hidden_fields .= "<input type=hidden name=\"mode\"/>";
$form2 = PackageManagerDisplay::buildPackageDisplay($form, $hidden_fields, $form_action, array('module'));
$form3 =<<<eoq3


eoq3;
echo $form2.$form3;

// scan for new files (that are not installed)
/*print( "$descItemsQueued<br>\n"); 
print( "<ul>\n" );
$upgrade_contents = findAllFiles( "$base_upgrade_dir", array() );
$upgrades_available = 0;

print( "<table>\n" );
print( "<tr><th></th><th align=left>{$mod_strings['LBL_ML_NAME']}</th><th>{$mod_strings['LBL_ML_TYPE']}</th><th>{$mod_strings['LBL_ML_VERSION']}</th><th>{$mod_strings['LBL_ML_PUBLISHED']}</th><th>{$mod_strings['LBL_ML_UNINSTALLABLE']}</th><th>{$mod_strings['LBL_ML_DESCRIPTION']}</th></tr>\n" );
foreach($upgrade_contents as $upgrade_content)
{
	if(!preg_match("#.*\.zip\$#", $upgrade_content))
	{
		continue;
	}
	
	$upgrade_content = clean_path($upgrade_content);
	$the_base = basename($upgrade_content);
	$the_md5 = md5_file($upgrade_content);
	$md5_matches = $uh->findByMd5($the_md5);
	
	if(0 == sizeof($md5_matches))
	{
		$target_manifest = remove_file_extension( $upgrade_content ) . '-manifest.php';
		require_once($target_manifest);

		$name = empty($manifest['name']) ? $upgrade_content : $manifest['name'];
		$version = empty($manifest['version']) ? '' : $manifest['version'];
		$published_date = empty($manifest['published_date']) ? '' : $manifest['published_date'];
		$icon = '';
		$description = empty($manifest['description']) ? 'None' : $manifest['description'];
		$uninstallable = empty($manifest['is_uninstallable']) ? 'No' : 'Yes';
		$type = getUITextForType( $manifest['type'] );
		$manifest_type = $manifest['type'];

		if($view == 'default' && $manifest_type != 'patch')
		{
			continue;
		}

		if($view == 'module'
			&& $manifest_type != 'module' && $manifest_type != 'theme' && $manifest_type != 'langpack')
		{
			continue;
		}

		if(empty($manifest['icon']))
		{
			$icon = getImageForType( $manifest['type'] );
		}
		else
		{
			$path_parts = pathinfo( $manifest['icon'] );
			$icon = "<img src=\"" . remove_file_extension( $upgrade_content ) . "-icon." . $path_parts['extension'] . "\">";
		}

		$upgrades_available++;
		print( "<tr><td>$icon</td><td>$name</td><td>$type</td><td>$version</td><td>$published_date</td><td>$uninstallable</td><td>$description</td>\n" );
		
		$upgrade_content = urlencode($upgrade_content);
		
		$form2 =<<<eoq
            <form action="{$form_action}_prepare" method="post">
            <td><input type=submit name="btn_mode" onclick="this.form.mode.value='Install';this.form.submit();" value="{$mod_strings['LBL_UW_BTN_INSTALL']}" /></td>
            <input type=hidden name="install_file" value="{$upgrade_content}" />
			<input type=hidden name="mode"/>
            </form>

            <form action="{$form_action}" method="post">
            <td><input type=submit name="run" value="{$mod_strings['LBL_UW_BTN_DELETE_PACKAGE']}" /></td>
            <input type=hidden name="install_file" value="{$upgrade_content}" />
            </form>
            </tr>
eoq;
		echo $form2;
    }
}
print( "</table>\n" );

if( $upgrades_available == 0 ){
    print($mod_strings['LBL_UW_NONE']);
}
print( "</ul>\n" );

?>
*/

$GLOBALS['log']->info( "Upgrade Wizard view");

?>
</td>
</tr>
</table></td></tr></table>
