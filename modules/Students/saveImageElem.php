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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$err = 0;
// target path for image
$target_path = "uploads/elem_students/";
$idno = trim($_POST['idno']);

// check if comes from correct form
if ( isset($_POST['theForm']) ) {
    
    if (isset($_POST['recID'])) {
        $stud->recID = $_POST['recID'];
    }
	
	if ($idno) {
	    // update existing record
        if (trim(basename( $_FILES['uploadedfile']['name']))!="") {
            // update image
            
            $allowed_filetypes = array('.jpg','.gif','.bmp','.png','.JPG','.JPEG','.GIF','.BMP','.PNG'); // These will be the types of file that will pass the validation.
            $max_filesize = 524288; // Maximum filesize in BYTES (currently 0.5MB).
            
            $filename = basename( $_FILES['uploadedfile']['name']);  // Get the name of the file (including file extension).
            $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
            
            $target_path = $target_path.$idno.$ext; 
            
            // Check if the filetype is allowed, if not DIE and inform the user.
            if(!in_array($ext,$allowed_filetypes)) {
              $err = 1;
              $msg = "Filename Extension is not valid!<br>";
            }
         
            // Now check the filesize, if it is too large then DIE and inform the user.
            if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize) {
              $err = 1;
              $msg .= "Exceed in file size limit!<br>";
            }
              
            // Check if we can upload to the specified path, if not DIE and inform the user.
            //if(!is_writable($target_path)) {
              //$err = 1;
              //echo $msg .= "Image directory is not writable!<br>";
            //}
            
            if (!$err) {
                foreach ($allowed_filetypes as $ext) {
                    $myFile = $target_path . trim($idno).$ext;
                    if (is_file($myFile)) {
	                    // delete file
	                    unlink($myFile);
                    }
                }
                // upload now the file
                if (!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
                    $err = 1;
                    $msg = "Can't save image!";
                } 
            }
        }
        
	    // update student record
	    if ($err) {
	        $msg = "Error:<br>".$msg;
    	    $sugar_smarty->assign('class', 'errorbox');
	    } else {
	        $msg = "Picture successfully changed!";
    	    $sugar_smarty->assign('class', 'notificationbox');
	    }
	}
	
	$sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Students&action=viewStudentElem&idno=<?php echo $idno; ?>')",3000);
</script>