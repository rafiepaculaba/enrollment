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
require_once('modules/Students/StudentElem.php');
require_once('modules/Registrations/RegistrationElem.php');


echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']."", false);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

if (isset($_POST['recID'])) {
    $idno = $_POST['idno'];
    $stud = new Student($idno);
} else {
    $stud = new Student();
}

$err = 0;
// target path for image
$target_path = "uploads/elem_students/";

// clear the transactions
//if ( $ug->db->beginTransaction() ) {
//   $ug->db->rollBack();
//}

// check if comes from correct form
if ( isset($_POST['theForm']) ) {
    
    if (isset($_POST['recID'])) {
        $stud->recID = $_POST['recID'];
    }
	
	if ($stud->recID) {
	    // update existing record
	    
	    $stud->idno           = trim($_POST['idno']);
        $stud->fname          = trim($_POST['fname']);
        $stud->lname          = trim($_POST['lname']);
        $stud->mname          = trim($_POST['mname']);
        $stud->yrLevel        = trim($_POST['yrLevel']);
        $stud->gender         = trim($_POST['gender']);
        
        $stud->bday           = date("Y-m-d", strtotime($_POST['month']."/".$_POST['day']."/".$_POST['year']));
        
        // calculate the age
        $stud->age            = getAge($stud->bday);
        
        $stud->permanentAddr  = trim($_POST['permanentAddr']);
        $stud->currentAddr    = trim($_POST['currentAddr']);
        $stud->phone          = trim($_POST['phone']);
        $stud->cstatus        = trim($_POST['cstatus']);
        $stud->nationality    = trim($_POST['nationality']);
        $stud->motherName     = trim($_POST['motherName']);
        $stud->fatherName     = trim($_POST['fatherName']);
        $stud->guardian       = trim($_POST['guardian']);
        
        $stud->motherOccupation  = trim($_POST['motherOccupation']);
        $stud->fatherOccupation  = trim($_POST['fatherOccupation']);
        $stud->guardianOccupation= trim($_POST['guardianOccupation']);
        
        $stud->motherContact  = trim($_POST['motherContact']);
        $stud->fatherContact  = trim($_POST['fatherContact']);
        $stud->guardianContact= trim($_POST['guardianContact']);
        
        $stud->entryDocs      = trim($_POST['entryDocs']);
        
        
//        if (trim(basename( $_FILES['uploadedfile']['name']))!="") {
//            // update image
//            
//            $allowed_filetypes = array('.jpg','.gif','.bmp','.png','.JPG','.JPEG','.GIF','.BMP','.PNG'); // These will be the types of file that will pass the validation.
//            $max_filesize = 524288; // Maximum filesize in BYTES (currently 0.5MB).
//            
//            $filename = basename( $_FILES['uploadedfile']['name']);  // Get the name of the file (including file extension).
//            $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
//            
//            $target_path = $target_path . trim($_POST['idno']).$ext; 
//            
//            // Check if the filetype is allowed, if not DIE and inform the user.
//            if(!in_array($ext,$allowed_filetypes))
//              $err = 1;
//         
//            // Now check the filesize, if it is too large then DIE and inform the user.
//            if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
//              $err = 1;
//         
//            // Check if we can upload to the specified path, if not DIE and inform the user.
//            if(!is_writable($target_path))
//              $err = 1;
//            
//            if (!$err) {
//                // delete file
//                unlink($myFile);
//                
//                // upload now the file
//                move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
//            }
//        }
	    
	    // update student record
	    if ($stud->updateStudent()) {
	        $msg = "Record successfully updated!";
    		$sugar_smarty->assign('class', 'notificationbox');
	    } else {
	        $msg = "Record was not successfully updated!";
    	    $sugar_smarty->assign('class', 'errorbox');
	    }
	} else {
	    // create new record

	    $stud->idno           = trim($_POST['idno']);
        $stud->regID          = trim($_POST['regID']);
        $stud->fname          = trim($_POST['fname']);
        $stud->lname          = trim($_POST['lname']);
        $stud->mname          = trim($_POST['mname']);
        $stud->yrLevel        = trim($_POST['yrLevel']);
        $stud->gender         = trim($_POST['gender']);
        
        $stud->bday           = date("Y-m-d", strtotime($_POST['month']."/".$_POST['day']."/".$_POST['year']));
        
        // calculate the age
        $stud->age            = getAge($stud->bday);
        
        $stud->permanentAddr  = trim($_POST['permanentAddr']);
        $stud->currentAddr    = trim($_POST['currentAddr']);
        $stud->phone          = trim($_POST['phone']);
        $stud->cstatus        = trim($_POST['cstatus']);
        $stud->nationality    = trim($_POST['nationality']);
        $stud->motherName     = trim($_POST['motherName']);
        $stud->fatherName     = trim($_POST['fatherName']);
        $stud->guardian       = trim($_POST['guardian']);
        
        $stud->motherOccupation  = trim($_POST['motherOccupation']);
        $stud->fatherOccupation  = trim($_POST['fatherOccupation']);
        $stud->guardianOccupation= trim($_POST['guardianOccupation']);
        
        $stud->motherContact  = trim($_POST['motherContact']);
        $stud->fatherContact  = trim($_POST['fatherContact']);
        $stud->guardianContact= trim($_POST['guardianContact']);
        
        $stud->entryDocs      = trim($_POST['entryDocs']);
        $stud->entryDate      = date("Y-m-d",time());
        
        
        if (trim(basename( $_FILES['uploadedfile']['name']))!="") {
            // uploade images
            
            $allowed_filetypes = array('.jpg','.gif','.bmp','.png','.JPG','.JPEG','.GIF','.BMP','.PNG'); // These will be the types of file that will pass the validation.
            $max_filesize = 524288; // Maximum filesize in BYTES (currently 0.5MB).
            
            $filename = basename( $_FILES['uploadedfile']['name']);  // Get the name of the file (including file extension).
            $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
            
            
            $target_path = $target_path . trim($_POST['idno']).$ext; 
            
             // Check if the filetype is allowed, if not DIE and inform the user.
            if(!in_array($ext,$allowed_filetypes))
              $err = 1;
         
            // Now check the filesize, if it is too large then DIE and inform the user.
            if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
              $err = 1;
         
            // Check if we can upload to the specified path, if not DIE and inform the user.
            if(!is_writable($target_path))
              $err = 1;
            
            // upload now the file
            move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
        }
	    
	    // new student record
    	if ($stud->createStudent()) {
    	    $reg = new Registration($stud->regID);
    	    $reg->rstatus = 0;
    	    $reg->updateRegistration();
    	    
    		$msg = "Record successfully saved!";
    		$sugar_smarty->assign('class', 'notificationbox');
    	} else {
    	    $msg = "Record was not successfully saved!";
    	    $sugar_smarty->assign('class', 'errorbox');
    	}
	}
	
	$sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="JavaScript">
setTimeout("redirect('index.php?module=Students&action=viewStudentElem&idno=<?php echo $stud->idno; ?>')",3000);
</script>