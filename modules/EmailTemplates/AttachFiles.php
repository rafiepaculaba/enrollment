<?php
 if(!defined('sugarEntry'))define('sugarEntry', true);
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
 //Request object must have these property values:
 //		Module: module name, this module should have a file called TreeData.php
 //		Function: name of the function to be called in TreeData.php, the function will be called statically.
 //		PARAM prefixed properties: array of these property/values will be passed to the function as parameter.
require_once('include/utils/file_utils.php');
require_once('data/SugarBean.php');
require_once('include/JSON.php');
require_once('include/entryPoint.php');
require_once('include/upload_file.php');

session_start();
$ret=array();
$params1=array();
$nodes=array();
global $sugar_config;

//$GLOBALS['log']->fatal("AttachFiles:FILE ARRAY ".$_FILES['uploadfile']);

function authenticate()
{
$GLOBALS['log']->fatal("AttachFiles AJAX :session started");
	global $sugar_config;
 	$user_unique_key = (isset($_SESSION['unique_key'])) ? $_SESSION['unique_key'] : "";
 	$server_unique_key = (isset($sugar_config['unique_key'])) ? $sugar_config['unique_key'] : "";

 	if ($user_unique_key != $server_unique_key) {
		$GLOBALS['log']->debug("JSON_SERVER: user_unique_key:".$user_unique_key."!=".$server_unique_key);
        session_destroy();
        return null;
 	}

 	if(!isset($_SESSION['authenticated_user_id']))
 	{
 		$GLOBALS['log']->debug("JSON_SERVER: authenticated_user_id NOT SET. DESTROY");
        session_destroy();
        return null;
 	}

 	$current_user = new User();

 	$result = $current_user->retrieve($_SESSION['authenticated_user_id']);
 	$GLOBALS['log']->debug("JSON_SERVER: retrieved user from SESSION");

 	if($result == null)
 	{
		$GLOBALS['log']->debug("JSON_SERVER: could get a user from SESSION. DESTROY");
   		session_destroy();
   		return null;
 	}
	return $result;
}

if(!empty($sugar_config['session_dir'])) {
	session_save_path($sugar_config['session_dir']);
	$GLOBALS['log']->debug("JSON_SERVER:session_save_path:".$sugar_config['session_dir']);
}

//get language
$current_language = $sugar_config['default_language'];
// if the language is not set yet, then set it to the default language.
if(isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '') {
	$current_language = $_SESSION['authenticated_user_language'];
} 

//validate user.
$current_user = authenticate();

global $app_strings;
if (empty($app_strings)) {
    //set module and application string arrays based upon selected language
    $app_strings = return_application_language($current_language);
}

//get theme
$theme = $sugar_config['default_theme'];
if(isset($_SESSION['authenticated_user_theme']) && $_SESSION['authenticated_user_theme'] != '') {
	$theme = $_SESSION['authenticated_user_theme'];
}
//set image path
$image_path = 'themes/'.$theme.'/images/';

//process request parameters. consider following parameters.
//function, and all parameters prefixed with PARAM.
//PARAMT_ are tree level parameters.
//PARAMN_ are node level parameters.
//module  name and function name parameters are the only ones consumed
//by this file..
//foreach ($_FILES['uploadfile'] as $key=>$value) {

//$GLOBALS['log']->fatal("AttachFiles: KEY ".$key);
//$GLOBALS['log']->fatal("AttachFiles: Value".$value);

$GLOBALS['log']->fatal($_FILES);

        /*
         $origfilename = $_FILES['email_attachment0']['name'];
         $origfilename1 = $_FILES["email_attachment1"]["name"];
         $filetype = $_FILES["uploadfile"]["type"];
         $filetempname = $_FILES["uploadfile"]["tmp_name"];
         $file_error   = $_FILES["uploadfile"]["error"];
         $filename = explode(".", $_FILES["uploadfile"]["name"]);         
         $filesize =$_FILES["uploadfile"]["size"];
        */
 //$GLOBALS['log']->fatal("Sugar path: config ".$_FILES);
         
         //$filenameext = $filename[count($filename)-1];
         //unset($filename[count($filename)-1]);
         //$filename = implode(".", $filename);
         //$filename = substr($filename, 0, 15).".".$filenameext;
         $file_ext_allow = FALSE;	
	//$GLOBALS['log']->fatal("AttachFiles: FILE1 ".$origfilename." ".$filename);
	//$GLOBALS['log']->fatal("AttachFiles: FILE2 ".$filetempname." ".$filesize);
 /*
         $fp = fopen($filetempname, 'r');
         $content = fread($fp, $filesize);
         $content = addslashes($content);
         fclose($fp); 
*/


// cn: bug 11012 - fixed some MIME types not getting picked up.  Also changed array iterator.
$imgType = array('image/gif', 'image/png', 'image/bmp', 'image/jpeg', 'image/jpg', 'image/pjpeg');
foreach($_FILES as $k => $file) {
	if(in_array(strtolower($_FILES[$k]['type']), $imgType)) {
		$dest = 'cache/images/'.$_FILES[$k]['name'];
		if(is_uploaded_file($_FILES[$k]['tmp_name'])) {
			move_uploaded_file($_FILES[$k]['tmp_name'], $dest);
		}
	}
}

  //if( copy($filetempname,$dest)){
  	//$GLOBALS['log']->fatal($sugar_config['upload_dir']);
  //}
	$ret[0]=$origfilename;
	$ret[1]=$origfilename1;
	//$ret[1]=$filetype;
	//$ret[2]=$filetempname;
	//$ret[3]=$file_error; 
	//$ret[4]= $filesize;
	
	
//$GLOBALS['log']->fatal($ret);
	//$ret[2]=$content;
	
	//$ret[5] = $_FILES["uploadfile"];
	

if (!empty($ret)) {	
	$json = getJSONobj();
	print $json->encode($ret);	
	//return the parameters
}
sugar_cleanup();
exit();
?>
