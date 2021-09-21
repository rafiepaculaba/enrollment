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
     * get the receivables
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
        
        if ($ctr<5) {
            $query="SELECT sum( ttlDue-amtPaid ) AS total_amount FROM assessments  WHERE term='$term' AND schYear = '$schYear' AND yrLevel = '$ctr' AND rstatus>0 AND ttlDue>amtPaid";
        } else {
            $query="SELECT sum( ttlDue-amtPaid ) AS total_amount FROM assessments  WHERE term='$term' AND schYear = '$schYear' AND yrLevel = '$ctr' AND rstatus>0 AND ttlDue>amtPaid";
        }
        
        $records = $reportClass->adhocQuery($query);
		
	    if ($records[0]['total_amount'] && $records[0]['total_amount'] > 0) {
	       $result[$index] = $records[0]['total_amount'];	
        } else {
	       $result[$index] = 0.00;	
        }
        
        $total += $result[$index];
        
        $ctr++;
    }
    
    $sugar_smarty->assign('RESULT', $reportClass->printReceivableReportCollege($result,$total));
      
	$sugar_smarty->assign('SCHYEAR', $schYear);
	$sugar_smarty->assign('TERM', $term);
	
	$sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
	
    echo $sugar_smarty->fetch('modules/Reports/templates/printReceivableReportHS.tpl');	
?>

<script type='text/javascript'>
function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}
</script>
