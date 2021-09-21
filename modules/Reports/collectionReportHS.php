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
require_once('modules/Config/ConfigHS.php');
require_once('modules/Reports/ReportHS.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_CUR'], $mod_strings['LBL_MODULE_TITLE_CR_HS'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Collection Report HS");
if ($access->check_access($current_user->id,$accessCode)) {
    
    // get all default setting from configs
    $config = new Config();
    
    $term=trim($_POST['term']);
    
    if ($_POST['theForm']) {
        // filter result
        // get the default school year
        $schYear = $default_schYear = $_POST['schYear'];
        
        /**
         * get the collections
         */
        $reportClass = new ReportClass();

        $result = array();
        
        $ctr=1;
        while ($ctr<=5) {
            
            if ($ctr==5) {
                $index="Special";
            } else {
                $index=$ctr;
            }
            
            if ($term=='Registration') {
                
                if ($ctr<5) {
                    //$query = "SELECT sum( rp.amount ) AS total_amount FROM registration_payments rp, enrollments e WHERE e.idno=rp.idno AND rp.schYear = '$schYear' AND rp.schYear=e.schYear AND e.yrLevel = '$ctr' AND rp.rstatus = 1"; // AND e.rstatus>0";
                    $query = "select sum(registration_payments.amount) as total_amount from registration_payments where  registration_payments.schYear='$schYear' and registration_payments.idno in (select distinct enrollments.idno from enrollments where enrollments.schYear='$schYear' and enrollments.yrLevel='$ctr')";
                } else {
                    //$query = "SELECT sum( rp.amount ) AS total_amount FROM registration_payments rp, enrollments e WHERE e.idno=rp.idno AND rp.schYear = '$schYear' AND rp.schYear=e.schYear AND e.yrLevel = 'S' AND rp.rstatus = 1";  // AND e.rstatus>0";
                    $query = "select sum(registration_payments.amount) as total_amount from registration_payments where  registration_payments.schYear='$schYear' and registration_payments.idno in (select distinct enrollments.idno from enrollments where enrollments.schYear='$schYear' and enrollments.yrLevel='S')";
                }
                
                $records = $reportClass->adhocQuery($query);
        		
                if ($records[0]['total_amount']) {
        	       $result[$index] = $records[0]['total_amount'];	
                } else {
        	       $result[$index] = 0;	
                }
        	    
            } else {
                if ($ctr<5) {
                    //$query="SELECT sum( p.amount ) AS total_amount FROM payments p, enrollments e WHERE e.idno=p.idno AND p.schYear = '$schYear' AND p.term = '$term' AND p.schYear=e.schYear AND e.yrLevel = '$ctr' AND p.rstatus = 1"; // AND e.rstatus>0";
                    $query = "select sum(payments.amount) as total_amount from payments where  payments.schYear='$schYear' and  payments.term='$term' and payments.idno in (select distinct enrollments.idno from enrollments where enrollments.schYear='$schYear'and enrollments.yrLevel='$ctr')";
                } else {
                    //$query="SELECT sum( p.amount ) AS total_amount FROM payments p, enrollments e WHERE e.idno=p.idno AND p.schYear = '$schYear' AND p.term = '$term' AND p.schYear=e.schYear AND e.yrLevel = 'S' AND p.rstatus = 1"; // AND e.rstatus>0";
                    $query = "select sum(payments.amount) as total_amount from payments where  payments.schYear='$schYear' and  payments.term='$term' and payments.idno in (select distinct enrollments.idno from enrollments where enrollments.schYear='$schYear'and enrollments.yrLevel='S')";
                }
                
                $records = $reportClass->adhocQuery($query);
        		
        	    if ($records[0]['total_amount']) {
        	       $result[$index] = $records[0]['total_amount'];	
                } else {
        	       $result[$index] = 0.00;	
                }
            }
            
            $total += $result[$index];
            
            $ctr++;
        }
        
        $sugar_smarty->assign('RESULT', $reportClass->collectionReportCollege($result,$total));
        
    } else {
        // get the default school year
        $default_schYear = $config->getConfig('School Year');
        
        $sugar_smarty->assign('RESULT', "");
    }
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear">'."\n";
	$schYear.='<option value="">-----------------------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	        if ($value==$default_schYear) {
	           $schYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	        } else {
	           $schYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	        }
	    }
	}
	$schYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schYear);
	
	$total_terms = $config->getConfig('Terms');
    $theTerms = $total_terms;

    $terms ='<select name="term" id="term">'."\n";
	$terms.='<option value="">-------------------</option>'."\n";
	
	if ($term=="Registration") {
	   $terms.='<option value="Registration" selected>Registration</option>'."\n";
	} else {
	   $terms.='<option value="Registration">Registration</option>'."\n";
	}
	if ($theTerms) {
	    if (is_array($theTerms)) {
    	    foreach ($theTerms as $key=>$value) {
    	        if ($term==$key) {
                    $terms .= '<option value="'.$key.'" selected>'.$value.'</option>'."\n";
    	        } else {
                    $terms .= '<option value="'.$key.'">'.$value.'</option>'."\n";
    	        }
    	    }
	    } else {
	        $ctr=1;
	        while ($ctr<=$theTerms) {
	            if ($term==$ctr) {
	               $terms .= '<option value="'.$ctr.'" selected>'.$ctr.'</option>'."\n";
	            } else {
	               $terms .= '<option value="'.$ctr.'">'.$ctr.'</option>'."\n";
	            }
	            $ctr++;    
	        }
	    }
	}
	$schYear.='</select>';
	$sugar_smarty->assign('TERMS', $terms);
	
	
	$sugar_smarty->assign('schYear', $default_schYear);
	$sugar_smarty->assign('term', $term);
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Reports/templates/collectionReportHS.tpl');	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>


<script>
addToValidate('frmCollectionReport','schYear', '', true, 'School Year');
addToValidate('frmCollectionReport','term', '', true, 'Period');
</script>

<script language="javascript">

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=500,left = 0,top = 0');");
}

// set focus
$('schYear').focus();

</script>
