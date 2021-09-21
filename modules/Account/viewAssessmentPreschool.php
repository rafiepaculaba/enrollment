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
require_once('modules/Config/ConfigPreschool.php'); 
require_once('modules/Students/StudentPreschool.php');
require_once('modules/Users/User2.php');
require_once('modules/Account/AccountPreschool.php');
require_once('modules/Account/AssessmentPreschool.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_ASSESSMENT'], $mod_strings['LBL_MODULE_TITLE_ASSESSMENT_PRESCHOOL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Preschool Assessment");
if ($access->check_access($current_user->id,$accessCode)) {
    $config     = new Config();

	$assID   = $_GET['assID'];
	$assessment = new Assessment($assID);
	
	if ( $assID ) {
    	
    	$sugar_smarty->assign('assID', $assessment->assID );
    	$sugar_smarty->assign('schYear', $assessment->schYear );
    	
	   	if ($assessment->yrLevel=='S') {
            $sugar_smarty->assign('yrLevel', "Special" );
        } else {
        	
        	switch ($assessment->yrLevel)
        	{
        		case 1:
        			$yrLevel = "Nursery 1";
        			break;
        		case 2:
        			$yrLevel = "Nursery 2";
        			break;
        		case 3:
        			$yrLevel = "Kinder 1";
        			break;
        		case 4:
        			$yrLevel = "Kinder 2";
        			break;
        		default:
        			$yrLevel = "Special";
        			break;	
        	}
        	
            $sugar_smarty->assign('yrLevel', $yrLevel );
        }
    	
    	//$sugar_smarty->assign('yrLevel', $assessment->yrLevel );
    	
        if ($assessment->yrLevel=='S')
    	   $sugar_smarty->assign('yrLevel', "Special" );
    	
    	$sugar_smarty->assign('idno', $assessment->idno );
       
        if ($assessment->term==1)
            $sugar_smarty->assign('term',$assessment->term."<sup>st</sup>" );
        else if ($assessment->term==2)
            $sugar_smarty->assign('term',$assessment->term."<sup>nd</sup>" );
        else if ($assessment->term==3)            
            $sugar_smarty->assign('term',$assessment->term."<sup>rd</sup>" );
        else
            $sugar_smarty->assign('term',$assessment->term."<sup>th</sup>" );
    	
    	$student = new Student($assessment->idno);
    	
    	$sugar_smarty->assign('lname', $student->lname );
    	$sugar_smarty->assign('fname', $student->fname );
    	$sugar_smarty->assign('mname', $student->mname );
    	$sugar_smarty->assign('courseCode', $student->courseCode );
    	
    	$sugar_smarty->assign('oldBalance', $assessment->oldBalance );
    	$sugar_smarty->assign('tuitionFee', $assessment->tuitionFee );
    	$sugar_smarty->assign('labFee', $assessment->labFee );
    	$sugar_smarty->assign('regFee', $assessment->regFee );
    	$sugar_smarty->assign('miscFee', $assessment->miscFee );
    	$sugar_smarty->assign('addAdj', $assessment->addAdj );
    	$sugar_smarty->assign('lessAdj', $assessment->lessAdj );
    	$sugar_smarty->assign('totalFees', $assessment->totalFees );
    	$sugar_smarty->assign('ttlPayment', $assessment->ttlPayment );
    	$sugar_smarty->assign('amtPaid', $assessment->amtPaid );
    	$sugar_smarty->assign('balance', $assessment->balance );
    	$sugar_smarty->assign('ttlDue', $assessment->ttlDue );
    	
        // to check if the user has an access in edit
        if ( $assessment->schYear==$config->getConfig('School Year') ) {
	        $accessCode = $access->getAccessCode("Edit Preschool Assessment");
	        $sugar_smarty->assign('hasEdit', $access->check_access($current_user->id, $accessCode) );
        }
        
        echo $sugar_smarty->fetch('modules/Account/templates/viewAssessmentPreschool.tpl');
	} else {
	    $msg = "Assessment ID not found!";
	    $sugar_smarty->assign('class', 'errorbox');
	    $sugar_smarty->assign('display', 'block');
	    $sugar_smarty->assign('msg', $msg );
	    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	}
	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script language="javascript">

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=700,height=400,left = 0,top = 0');");
}

</script>
