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
require_once('modules/Account/AccountDetailPreschool.php');
require_once('modules/Account/AccountPreschool.php');
require_once('modules/Account/AssessmentPreschool.php');

require_once('modules/Subjects/SubjectPreschool.php');
require_once('modules/Schedules/SchedulePreschool.php');
require_once('modules/Schedules/BlockSectionSubjectPreschool.php');
require_once('modules/Schedules/BlockSectionPreschool.php');
require_once('modules/Enrollments/EnrollmentDetailPreschool.php');
require_once('modules/Enrollments/EnrollmentPreschool.php');

global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

    $config = new Config();
    $assessment = new Assessment();
    
    // parameters
    $schYear = trim($_GET['schYear']);
    $term    = trim($_GET['term']);
    $yrLevel = trim($_GET['yrLevel']);
    
    // filters
    $where=array();
    $where[0]['assessments.schYear'] = "='".$schYear."' AND ";
    $where[0]['assessments.term']    = "='".$term."' AND ";
    $where[0]['assessments.yrLevel'] = "='".$yrLevel."' ";
    $list_assessment = $assessment->retrieveAllAssessmentsAssociated($where);
    
    // configurations
    $schName    = $config->getConfig('School Name');
    $schAdd     = $config->getConfig('School Address');
    $schContact = $config->getConfig('Contact');
    if ($assessment->semCode < 4) {
        // regular semester
        $total_terms = $config->getConfig('Semestral Terms');
    } else {
        // summer
        $total_terms = $config->getConfig('Summer Terms');
    }

    
    if ($list_assessment) {
        $output_assessments = array();
        
        foreach ($list_assessment as $ass) {
            $assessment->assID = $ass['assID'];
            $assessment->retrieveAssessment();
            
            // get the enrollment data
            $enID = $assessment->getEnrollmentID();
            $enrollment = new Enrollment($enID);
            
            if ($enrollment->subjs) {
                $data_subjs = array();
                $ctr=0;
                foreach ($enrollment->subjs as $row) {
                    $data_subjs[$ctr]['subjCode']=$row['sched']->subjCode;
                    $data_subjs[$ctr]['units']=$row['sched']->units;
                    $ctr++;
                }
            }
            
        	$student = new Student($assessment->idno);
        	
        	$output_assessments[] = generatePrinting();
        	
        }
    }

    //p($output_assessments);
echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td nowrap="nowrap">
    		<div id="myDiv" name="myDiv" style="display:block">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<td nowrap="nowrap" align="right"><input type="button" class="button" value="Print Now" id="cmdPrint" name="cmdPrint" onclick="printNow();" />&nbsp;&nbsp;<input type="button" class="button" value="Close" id="cmdClose" name="cmdClose" onclick="javascript: window.close();" /><br></td>
            	</tr>
            </table>
            </div>
		</td>
	</tr>
</table>';

if ($output_assessments) {
    $ctr=1;
    foreach ($output_assessments as $ass) {
        
        echo $ass;
        echo "<hr/>";
        if ($ctr%3==0) {
            echo "<br><br><br>";
        }     
        
        $ctr++;
        
    }
} else {
    echo "<b>No assessments found!</b>";
}
	
//    $sugar_smarty->assign("assessments",$output_assessments);
//	$sugar_smarty->fetch('modules/Account/templates/printBulkAssessmentPreschool.tpl');

	

function generatePrinting() 
{
    global $config;
    global $assessment;
    global $student;
    global $data_subjs;
    global $term;
    global $schYear;
    
    global $schName;
    global $schAdd;
    global $schContact;
    
    $output = "";

$output .= '<p>';
$output .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" height="300">';
$output .= '    <tr>';
$output .= '        <td colspan="4" align="center">';
$output .= '        <slot>';
$output .= '        '.$schName.'<br>'.$schAdd.'<br>'.$schContact;
$output .= '        </slot>';
$output .= '        </td>';
$output .= '    </tr>';
$output .= '    <tr><th  colspan="4" align="center"><br><b><u>Statement of Account</u></b> <br><br></th></tr>';
$output .= '    <tr>';
$output .= '        <td colspan="4"><slot>';
$output .= '            <table border="0" cellpadding="0" cellspacing="0" width="100%">';
$output .= '                <tr>';
$output .= '                    <td>'.$student->idno.'</td>';
$output .= '                    <td>'.$student->lname.' , '.$student->fname.' '.$student->mname.'</td>';

$grade = "Grade ".$student->yrLevel;
if ($grade=='S') {
    $grade="Special Grade";
}

$output .= '                    <td>'.$grade.'</td>';
$output .= '                    <td>';
$output .= $schYear;
$output .= '                    </td>';
$output .= '                </tr>';
$output .= '            </table>';                
$output .= '        </slot>';
$output .= '        <hr>';
$output .= '        </td>';
$output .= '    </tr>';
$output .= '    <tr>';
$output .= '        <td colspan="2" width="50%" valign="top">';
$output .= '            <table class="listView" border="0" cellpadding="0" cellspacing="0" width="100%">';
$output .= '            	<tr height="20">';
$output .= '            		<td scope="col" class="listViewThS1" width="50%" nowrap><b>Subject</b></td>';
$output .= '            		<td scope="col" class="listViewThS1" width="50%" nowrap><b>Signature</b></td>';
$output .= '            	</tr>';

if ($data_subjs) {
    foreach ($data_subjs as $subj) {
        $output .= '                    <tr height="20">';
        $output .= '                		<td>'.$subj['subjCode'].'</td>';
        $output .= '                		<td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>';
        $output .= '                	</tr>';
    }
}

$output .= '            </table>';
$output .= '        </td>';
$output .= '        <td colspan="2">';
$output .= '            <table border="0" cellpadding="0" cellspacing="0" width="100%">';

$output .= '                <tr><th colspan="4" align="left"><b>Old Account:</b></th></tr>';
$output .= '                <tr>';
$output .= '                    <td width="10%"><slot>&nbsp;</slot></td>';
$output .= '                    <td width="40%"><slot>Old Balance </slot></td>';
$output .= '                    <td width="20%" align="right"><slot><b>'.number_format($assessment->oldBalance,2).'</b></slot></td>';
$output .= '                    <td width="30%"><slot>&nbsp;</slot></td>';
$output .= '                </tr>';

$output .= '                <tr><th colspan="4" align="left"><b>Fees:</b></th></tr>';
$output .= '                <tr>';
$output .= '                    <td width="10%"><slot>&nbsp;</slot></td>';
$output .= '                    <td width="40%"><slot>Tuition </slot></td>';
$output .= '                    <td width="20%" align="right"><slot><b>'.number_format($assessment->tuitionFee,2).'</b></slot></td>';
$output .= '                    <td width="30%"><slot>&nbsp;</slot></td>';
$output .= '                </tr>';
$output .= '                <tr>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                    <td><slot>Laboratory </slot></td>';
$output .= '                    <td align="right"><slot><b>'.number_format($assessment->labFee,2).'</b></slot></td>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                </tr>';
$output .= '                <tr>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                    <td><slot>Registration </slot></td>';
$output .= '                    <td align="right"><slot><b>'.number_format($assessment->regFee,2).'</b></slot></td>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                </tr>';
$output .= '                <tr>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                    <td><slot>Miscellaneous </slot></td>';
$output .= '                    <td align="right"><slot><b>'.number_format($assessment->miscFee,2).'</b></slot></td>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                </tr>';
$output .= '                <tr><th colspan="4" align="left"><b>Adjustments:</b></th></tr>';
$output .= '                <tr>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                    <td><slot>Add </slot></td>';
$output .= '                    <td align="right"><slot><b>'.number_format($assessment->addAdj,2).'</b></slot></td>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                </tr>';
$output .= '                <tr>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                    <td><slot>Less </slot></td>';
$output .= '                    <td align="right"><slot><b>'.number_format($assessment->lessAdj,2).'</b></slot></td>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                </tr>';
$output .= '                <tr><th colspan="4" align="left"><b>Total Fees:</b></th></tr>';
$output .= '                <tr>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                    <td><slot>Total Fees </slot></td>';
$output .= '                    <td align="right"><slot><b>'.number_format($assessment->totalFees,2).'</b></slot></td>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                </tr>';
$output .= '                <tr><th colspan="4" align="left"><b>Total Payments:</b></th></tr>';
$output .= '                <tr>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                    <td><slot>Total Payment </slot></td>';
$output .= '                    <td align="right"><slot><b>'.number_format($assessment->ttlPayment,2).'</b></slot></td>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                </tr>';
$output .= '                <tr><th colspan="4" align="left"><b>Balance:</b></th></tr>';
$output .= '                <tr>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                    <td><slot>Balance </slot></td>';
$output .= '                    <td align="right"><slot><b>'.number_format($assessment->balance,2).'</b></slot></td>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                </tr>';
$output .= '                <tr><th colspan="4" align="left"><b>Due for '.$term.':</b></th></tr>';
$output .= '                <tr>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                    <td><slot>Amount Due </slot></td>';
$output .= '                    <td align="right"><slot><b>'.number_format($assessment->ttlDue,2).'</b></slot></td>';
$output .= '                    <td><slot>&nbsp;</slot></td>';
$output .= '                </tr>';
$output .= '            </table>';
$output .= '        </td>';
$output .= '    </tr>';
$output .= '</table>';
$output .= '</p>';


return $output;
}


?>


<script language="javascript">

function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}

</script>