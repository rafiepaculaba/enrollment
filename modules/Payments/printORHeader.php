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
require_once('modules/Config/ConfigCol.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');
require_once('modules/Schedules/Schedule.php');
require_once('modules/Schedules/BlockSectionCol.php');
require_once('modules/Schedules/BlockSectionSubjectCol.php');
require_once('modules/Enrollments/EnrollmentDetailCol.php');
require_once('modules/Enrollments/EnrollmentCol.php');
require_once('modules/Payments/Payment.php');
require_once('modules/Account/AccountDetailCol.php');
require_once('modules/Account/Account.php');
require_once('modules/Account/Assessment.php');
require_once('modules/SchoolFees/SchoolFeeCol.php');
require_once('modules/Payments/ORSeries.php');
require_once('modules/Payments/ORHeader.php');
require_once('modules/Payments/ORDetails.php');
require_once('modules/Account/ChartAccountMaster.php');
require_once('modules/Config/ConfigCol.php');
require_once('modules/Config/RecordLog.php');

global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$paymentID   = $_GET['paymentID'];

$or         	= new ORHeader($paymentID);
$config     	= new Config();
$schoolFee  	= new SchoolFee();
$accountMaster 	= new ChartAccountMaster();

if ( $paymentID ) {
	
	$sugar_smarty->assign('assID', $or->paymentID );
	$sugar_smarty->assign('schYear', $or->schYear );
	$sugar_smarty->assign('semCode', $or->semCode );
	$sugar_smarty->assign('yrLevel', $or->yrLevel );
	$sugar_smarty->assign('dateCreated', $or->dateCreated );
	$sugar_smarty->assign('timeCreated', $or->timeCreated );
	$sugar_smarty->assign('orno', $or->orno );
	
	if ($or->semCode==1) {
	   $sugar_smarty->assign('semester', "1<sup>st</sup>" );
	} else if ($or->semCode==2) {
	   $sugar_smarty->assign('semester', "2<sup>nd</sup>" );
	} else if ($or->semCode==3) {
	   $sugar_smarty->assign('semester', "3<sup>rd</sup>" );
	} else if ($or->semCode==4) {
	   $sugar_smarty->assign('semester', "Summer" );
	}
	$sugar_smarty->assign('cashierName', $current_user->last_name );
	
	$sugar_smarty->assign('idno', $or->idno );

	if ($or->semCode < 4) {
       // regular semester
       $total_terms = $config->getConfig('Semestral Terms');
       switch ($total_terms) {
        case 2:
           $term = $term_by_2[$or->term];
            break;
        case 3:
            $term = $term_by_3[$or->term];
            break;
        case 4:
            $term = $term_by_4[$or->term];
            break;
       }

   } else {
       // summer
       $total_terms = $config->getConfig('Summer Terms');
       switch ($total_terms) {
        case 2:
            $term = $term_by_2[$or->term];
            break;
        case 3:
            $term = $term_by_3[$or->term];
            break;
        case 4:
            $term = $term_by_4[$or->term];
            break;
       }
   }
   
    $sugar_smarty->assign('term',$term );
    // get the enrollment data
   if ($or->particular) {
        $ctr=0;
        foreach($or->particular as $row) {
            
            //display schoolfee item
            $account_code = $row['account_code'];
            unset($where);
            $where[0]['account_code'] = "='$account_code'";
            $particular = $accountMaster->retrieveAllChartAccountMaster($where);
            
            $data_subjs[$ctr]['particular'] = $particular[0]['account_name'];
            $data_subjs[$ctr]['amount'] = $row['amount'];
            $total_amount += $row['amount']; 

            $totalAmount = $totalAmount + $or->particular[$ctr]['amount'];

            $ctr++;
        }
    }
    
    $sugar_smarty->assign('ordetails', $data_subjs );
    $sugar_smarty->assign('totalAmount', $totalAmount );
    
	$student = new Student($or->idno);
	
	$sugar_smarty->assign('lname', $student->lname );
	$sugar_smarty->assign('fname', $student->fname );
	$sugar_smarty->assign('mname', $student->mname );
	$sugar_smarty->assign('courseCode', $student->courseCode );
	$sugar_smarty->assign('yrLevel', $student->yrLevel );
	
	$sugar_smarty->assign('schName', $config->getConfig('School Name') );
	$sugar_smarty->assign('schAddress', $config->getConfig('School Address') );
	$sugar_smarty->assign('schContact', $config->getConfig('Contact') );
	$sugar_smarty->assign('TIN', $config->getConfig('TIN') );
    	
	echo $sugar_smarty->fetch('modules/Payments/templates/printORHeader.tpl');
} else {
    $msg = "Account ID not found!";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">

function printNow() {
    document.getElementById('myDiv').style.display="none";
    window.print();
    window.close();
}

function convertmoney()
{
	var wholenum=document.getElementById('total_amount').value;  
	var decimalnum=parseFloat(wholenum) - parseInt(wholenum);
	decimalnum=decimalnum.toFixed(2);
	amt_in_words = converttowords(wholenum);
	amt_in_words += " Pesos";
	
	if (decimalnum>0) {
		// has decimal
		amt_in_words += " and " + converttowords(decimalnum*100) + " Cents";	
	}
	
	document.getElementById('container').innerHTML = "** " + amt_in_words + "** ";
}

function converttowords(junkVal)
{  
    //var junkVal=document.getElementById('total_amount').value;  
    junkVal=Math.floor(junkVal);  
    var obStr=new String(junkVal);  
    numReversed=obStr.split("");  
    actnumber=numReversed.reverse();  
  
    if(Number(junkVal) >=0)  
    {  
        //do nothing  
    }  
    else  
    {  
        alert('wrong Number cannot be converted');  
        return false;  
    }  
    if(Number(junkVal)==0)  
    {  
        document.getElementById('container').innerHTML=obStr+''+'Rupees Zero Only';  
        return false;  
    }  
    if(actnumber.length>9)  
    {  
        alert('Oops!!!! the Number is too big to covertes');  
        return false;  
    }  
  
    var iWords=["Zero", " One", " Two", " Three", " Four", " Five", " Six", " Seven", " Eight", " Nine"];  
    var ePlace=['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];  
    var tensPlace=['dummy', ' Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety' ];  
  
    var iWordsLength=numReversed.length;  
    var totalWords="";  
    var inWords=new Array();  
    var finalWord="";  
    j=0;  
    for(i=0; i<iWordsLength; i++)  
    {  
        switch(i)  
        {  
        case 0:  
            if(actnumber[i]==0 || actnumber[i+1]==1 )  
            {  
                inWords[j]='';  
            }  
            else  
            {  
                inWords[j]=iWords[actnumber[i]];  
            }  
            inWords[j]=inWords[j]+' ';  
            break;  
        case 1:  
            tens_complication();  
            break;  
        case 2:  
            if(actnumber[i]==0)  
            {  
                inWords[j]='';  
            }  
            else if(actnumber[i-1]!=0 && actnumber[i-2]!=0)  
            {  
                inWords[j]=iWords[actnumber[i]]+' Hundred and';  
            }  
            else  
            {  
                inWords[j]=iWords[actnumber[i]]+' Hundred';  
            }  
            break;  
        case 3:  
            if(actnumber[i]==0 || actnumber[i+1]==1)  
            {  
                inWords[j]='';  
            }  
            else  
            {  
                inWords[j]=iWords[actnumber[i]];  
            }  
            inWords[j]=inWords[j]+" Thousand";  
            break;  
        case 4:  
            tens_complication();  
            break;  
        case 5:  
            if(actnumber[i]==0 || actnumber[i+1]==1 )  
            {  
                inWords[j]='';  
            }  
            else  
            {  
                inWords[j]=iWords[actnumber[i]];  
            }  
            inWords[j]=inWords[j]+" Lakh";  
            break;  
        case 6:  
            tens_complication();  
            break;  
        case 7:  
            if(actnumber[i]==0 || actnumber[i+1]==1 )  
            {  
                inWords[j]='';  
            }  
            else  
            {  
                inWords[j]=iWords[actnumber[i]];  
            }  
            inWords[j]=inWords[j]+" Crore";  
            break;  
        case 8:  
            tens_complication();  
            break;  
        default:  
            break;  
        }  
        j++;  
    }  
  
    function tens_complication()  
    {  
        if(actnumber[i]==0)  
        {  
            inWords[j]='';  
        }  
        else if(actnumber[i]==1)  
        {  
            inWords[j]=ePlace[actnumber[i-1]];  
        }  
        else  
        {  
            inWords[j]=tensPlace[actnumber[i]];  
        }  
    }  
    inWords.reverse();  
    for(i=0; i<inWords.length; i++)  
    {  
        finalWord+=inWords[i];  
    }  
//    document.getElementById('container').innerHTML=obStr+''+finalWord;  
    return finalWord;  
}


convertmoney();

//converttowords();


</script>