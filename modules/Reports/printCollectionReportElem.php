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
require_once('modules/Config/ConfigElem.php');
require_once('modules/Reports/ReportElem.php');

global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

    $config = new Config();

    // get the default school year
    $schYear = $_GET['schYear'];
    $term    = $_GET['term'];
    
    /**
     * get the collections
     */
    $reportClass = new ReportClass();
    $result = array();
    
    $ctr=1;
    while ($ctr<=7) {
        
        if ($ctr==7) {
            $index="Special";
        } else {
            $index=$ctr;
        }
        
        if ($term=='Registration') {
            
            if ($ctr<7) {
                //$query = "SELECT sum( rp.amount ) AS total_amount FROM registration_payments rp, enrollments e WHERE e.idno=rp.idno AND rp.schYear = '$schYear' AND rp.schYear=e.schYear AND e.yrLevel = '$ctr' AND rp.rstatus = 1 AND e.rstatus>0";
                //$query = "select sum(registration_payments.amount) as total_amount from registration_payments where  registration_payments.schYear='$schYear' and registration_payments.semCode='$semCode' and registration_payments.idno in (select distinct enrollments.idno from enrollments where enrollments.schYear='$schYear' and enrollments.yrLevel='$ctr'";
                $query = "select sum(registration_payments.amount) as total_amount from registration_payments where  registration_payments.schYear='$schYear' and registration_payments.idno in (select distinct enrollments.idno from enrollments where enrollments.schYear='$schYear' and enrollments.yrLevel='$ctr')";
            } else {
                //$query = "SELECT sum( rp.amount ) AS total_amount FROM registration_payments rp, enrollments e WHERE e.idno=rp.idno AND rp.schYear = '$schYear' AND rp.schYear=e.schYear AND e.yrLevel = 'S' AND rp.rstatus = 1 AND e.rstatus>0";
                $query = "select sum(registration_payments.amount) as total_amount from registration_payments where  registration_payments.schYear='$schYear' and registration_payments.idno in (select distinct enrollments.idno from enrollments where enrollments.schYear='$schYear' and enrollments.yrLevel='S')";
            }
            
            $records = $reportClass->adhocQuery($query);
    		
            if ($records[0]['total_amount']) {
    	       $result[$index] = $records[0]['total_amount'];	
            } else {
    	       $result[$index] = 0;	
            }
    	    
        } else {
            if ($ctr<7) {
                //$query="SELECT sum( p.amount ) AS total_amount FROM payments p, enrollments e WHERE e.idno=p.idno AND p.schYear = '$schYear' AND p.term = '$term' AND p.schYear=e.schYear AND e.yrLevel = '$ctr' AND p.rstatus = 1 AND e.rstatus>0";
                $query = "select sum(payments.amount) as total_amount from payments where  payments.schYear='$schYear' and  payments.term='$term' and payments.idno in (select distinct enrollments.idno from enrollments where enrollments.schYear='$schYear'and enrollments.yrLevel='$ctr')";
            } else {
                //$query="SELECT sum( p.amount ) AS total_amount FROM payments p, enrollments e WHERE e.idno=p.idno AND p.schYear = '$schYear' AND p.term = '$term' AND p.schYear=e.schYear AND e.yrLevel = 'S' AND p.rstatus = 1 AND e.rstatus>0";
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
    
    $sugar_smarty->assign('RESULT', $reportClass->printCollectionReportElementary($result,$total));
      
	$sugar_smarty->assign('SCHYEAR', $schYear);
	$sugar_smarty->assign('TERM', $term);
	
	$sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
	
    echo $sugar_smarty->fetch('modules/Reports/templates/printCollectionReportElem.tpl');	
?>

<script type='text/javascript'>
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}
</script>
