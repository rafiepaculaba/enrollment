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
require_once('modules/Account/AccountDetailCol.php');
require_once('modules/Account/Account.php');
require_once('modules/Payments/PaymentType.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Config/ConfigCol.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
	$accessCode = $access->getAccessCode("Create Col Payment");
if ($access->check_access($current_user->id,$accessCode)) {
	
	// get all default setting from configs
    $config = new Config();
    
    // get the default semester
    $default_semCode = $config->getConfig('Semester');
    
    $semesters='<select name="semCode" id="semCode" onchange="getTerms();" >'."\n";
    $semesters.='<option value="">------------</option>'."\n";
    if ($esConfig['semesters']) {
        foreach ($esConfig['semesters'] as $key=>$value) {
            if ($key==$default_semCode) {
                $semesters .= '<option value="'.$key.'" selected >'.$value.'</option>'."\n";
            } else {
                $semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
            }
        }
    }
    $semesters.='</select>';
    $sugar_smarty->assign('SEMESTERS', $semesters);
    
     // get the default school year
    $default_schYear = $config->getConfig('School Year');

    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year+1; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schYear='<select name="schYear" id="schYear">'."\n";
	$schYear.='<option value="">-------------------</option>'."\n";
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
	
	// get the default semcode
	if ($default_semCode<4) {
        $total_terms = $config->getConfig('Semestral Terms');
	} else {
	    $total_terms = $config->getConfig('Summer Terms');
	}
    switch ($total_terms) {
     case 1:
        $theTerms = $term_by_1;
        break;
    case 2:
        $theTerms = $term_by_2;
        break;
    case 3:
        $theTerms = $term_by_3;
        break;
    case 4:
        $theTerms = $term_by_4;
        break;
    default:
        $theTerms = $total_terms;
    }

	$terms ='<select name="term" id="term" onchange="displayAccounts();" >'."\n";
	$terms.='<option value="">----------------------------------</option>'."\n";
	if ($theTerms) {
	    if (is_array($theTerms)) {
    	    foreach ($theTerms as $key1=>$value) {
               $terms .= '<option value="'.$key1.'">'.$value.'</option>'."\n";
    	    }
	    } else {
	    	$ctr=1;
		        while ($ctr<=$theTerms) {
		            $terms .= '<option value="'.$ctr.'">'.$ctr.'</option>'."\n";
		            $ctr++;    
		        }
	    }
	}

	$terms.='</select>';
	$sugar_smarty->assign('TERMS', $terms);

	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');	
	echo $sugar_smarty->fetch('modules/Payments/templates/createPayment.tpl');
	calendarSetup('date', 'jscal_trigger');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>

<script>
addToValidate('frmPayment','schYear', '', true, 'School Year');
addToValidate('frmPayment','semCode', '', true, 'Semester');
addToValidate('frmPayment','idno', '', true, 'ID No.');
addToValidate('frmPayment','ORno', '', true, 'Official Receipt No.');
addToValidate('frmPayment','date', '', true, 'Date');
addToValidate('frmPayment','term', '', true, 'Term');
addToValidate('frmPayment','amount', '', true, 'Amount');
</script>

<script language="javascript">
function isFloatAmount()
{
	if (isFloatValue($('amount').value)) {
	//continue
		validatePayment();
	} else {
		//Stop running
		alert("Error: Invalid amount inputed!!");
	}
}

function validatePayment()
{
    get_data="schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&term=" + $('term').value + "&idno=" + $('idno').value + "&action=validatepaymentpaymentcol";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onValidatePaymentHandle");
}

function onValidatePaymentHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
			if(ret == '[]' || ret == '0' ) {

				checkInformation();
			}
			else {
				checkInformation();
			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function checkInformation()
{
    get_data="idno=" + $('idno').value + "&action=checkstudinformationpaymentcol";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onCheckinformationHandle");
	
}

function onCheckinformationHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
			if(ret == '[]' || ret == '0' ) {
				if (($('amount').value == '' || $('schYear').value == '' || $('semCode').value == '' || $('term').value == '' || $('idno').value == '') && ($('assID').value != '')) {
					if (check_form('frmPayment')) {
			    				$('frmPayment').submit();	
			    	}
				} else {
					alert(" Wrong student information displayed.. ");
				}
			}
			else {
	    		myData = ret.parseJSON();
				if ($('name').value == (myData[0].lname + ", " + myData[0].fname + " " + myData[0].mname) && ($('assID').value != '')) {
					if (check_form('frmPayment')) {
			    				$('frmPayment').submit();	
			    	}
				} else if ($('amount').value == '' || $('schYear').value == '' || $('semCode').value == '' || $('term').value == '' || $('idno').value == '' && ($('assID').value != ''))  {
					if (check_form('frmPayment')) {
			    				$('frmPayment').submit();	
			    	}
				} else {
					alert(" Wrong student information displayed.. ");
				}
			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function displayStudentInfo()
{
    get_data="idno=" + $('idno').value + "&action=displaystudentinfos";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onDisplayStudentInfosHandle");
}

function onDisplayStudentInfosHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
			displayStudentInfo2();
			$('assID').value 			= "";
			$('assID_td').innerHTML 	= "-";
			$('amtPaid').innerHTML 		= "-";
			$('accID').innerHTML 		= "-";
			$('accID_input').value		= "";
			$('ttlDue').innerHTML 		= "-";
			$('balance').innerHTML 		= "-";
			$('term').value 			= '';	
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function displayStudentInfo2()
{
    get_data="idno=" + $('idno').value + "&action=displaystudentinfos";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onDisplayStudentInfosHandle2");
}

function onDisplayStudentInfosHandle2()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
    			if(ret == '[]' || ret == '0' ) {
    				alert("ID no. does not exist !!");
    				$('idno').focus();	
    				myData = ret.parseJSON();

				$('name').value= '';	
	   			}
    			else {
		    		myData = ret.parseJSON();
		    		//idnametxt, 
					$('name').value= '';			
					$('name').value=myData[0].lname + ", " + myData[0].fname + " " + myData[0].mname;
					$('term').focus();
    			}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function displayAccounts()
{
	if($('term').value != ''){
	    get_data="schYear=" + $('schYear').value + "&semCode=" + $('semCode').value + "&idno=" + $('idno').value + "&term=" + $('term').value + "&action=displayaccounts";
	    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onDisplayAccountHandle");
	} else {
    			$('assID').value 				= "";
    			$('assID_td').innerHTML 		= "-";
    			$('amtPaid').innerHTML 			= "-";
    			$('accID').innerHTML 			= "-";
    			$('accID_input').value			= "";
				//$('oldBalance').innerHTML 	= "-";
				//$('tuition').innerHTML 		= "-";
				//$('labFee').innerHTML 		= "-";
				//$('regFee').innerHTML 		= "-";
				//$('miscFee').innerHTML 		= "-";
				//$('totalFees').innerHTML 	= "-";
				//$('addAdj').innerHTML 		= "-";
				//$('lessAdj').innerHTML 		= "-";
				//$('ttlPayment').innerHTML 	= "-";
				$('ttlDue').innerHTML 		= "-";
				$('balance').innerHTML 		= "-";
	}
}

function onDisplayAccountHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
    			if(ret == '[]' || ret == '0' || ret == 'null') {
    				alert("No data found !!");
    				$('term').value = '';	
    				$('term').focus();	
    				myData = ret.parseJSON();

    			$('assID').value 			= "";
    			$('assID_td').innerHTML		= "-";
    			$('amtPaid').innerHTML 		= "-";
    			$('accID').innerHTML 		= "-";
    			$('accID_input').value 		= "";
				//$('oldBalance').innerHTML 	= "-";
				//$('tuition').innerHTML 		= "-";
				//$('labFee').innerHTML 		= "-";
				//$('regFee').innerHTML 		= "-";
				//$('miscFee').innerHTML 		= "-";
				//$('totalFees').innerHTML 	= "-";
				//$('addAdj').innerHTML 		= "-";
				//$('lessAdj').innerHTML 		= "-";
				//$('ttlPayment').innerHTML 	= "-";
				$('ttlDue').innerHTML 		= "-";
				$('balance').innerHTML 		= "-";
	   			}
    			else {
	    		myData = ret.parseJSON();
	    		//idnametxt, 
				
	    		var account = 0;
	    		
	    		$('assID').value 			= myData[0].assID;
				$('assID_td').innerHTML 	= myData[0].assID;
				$('amtPaid').innerHTML 	    = myData[0].amtPaid;
				$('accID_input').value 	    = myData[0].accID;
				$('accID').innerHTML 		= myData[0].accID;
				//$('oldBalance').innerHTML 	= myData[0].oldBalance;
				//$('tuition').innerHTML 		= myData[0].tuitionFee;
				//$('labFee').innerHTML 		= myData[0].labFee;
				//$('regFee').innerHTML 		= myData[0].regFee;
				//$('miscFee').innerHTML 		= myData[0].miscFee;
				//$('addAdj').innerHTML 		= myData[0].addAdj;
				//$('lessAdj').innerHTML 		= myData[0].lessAdj;
				$('ttlDue').innerHTML 		= myData[0].ttlDue;
				//$('ttlPayment').innerHTML 	= myData[0].ttlPayment;
				//$('totalFees').innerHTML 	= myData[0].totalFees;
				$('balance').innerHTML 		= myData[0].balance;
				
				}
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

function getTerms()
{
    get_data="semCode=" + $('semCode').value + "&action=getterms";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","ongettermsHandle");
}

function ongettermsHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	if (ret) {
    		//if id no exist
			if (ret != ''){
				$('terms').value = ret;
			}	
    		   	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}


function getTerms()
{
    get_data="semCode=" + $('semCode').value + "&action=getterms";
    ajaxQuery("modules/Payments/paymentHandler.php",'GET',get_data,"","onGetTermsHandle");
}

function onGetTermsHandle()
{
	if (xmlHttp.readyState==4) {
        // Get the data from the server's response in text format
    	var ret = xmlHttp.responseText;
    	var terms_by_1=new Array(2);
    	var terms_by_2=new Array(3);
    	var terms_by_3=new Array(4);
    	var terms_by_4=new Array(5);
    	
    	terms_by_1[0]="";
    	terms_by_2[0]="";
    	terms_by_3[0]="";
    	terms_by_4[0]="";
    	
    	<?php
        	foreach ($term_by_1 as $key=>$value) {
        	   echo 'terms_by_1['.$key.']="'.$value.'";';
        	}
        	
        	foreach ($term_by_2 as $key=>$value) {
        	   echo 'terms_by_2['.$key.']="'.$value.'";';
        	}
        	
        	foreach ($term_by_3 as $key=>$value) {
        	   echo 'terms_by_3['.$key.']="'.$value.'";';
        	}
        	
        	foreach ($term_by_4 as $key=>$value) {
        	   echo 'terms_by_4['.$key.']="'.$value.'";';
        	}
    	?>
    	
    	if (ret) {
	    	initializeCombo('term',"----------------------------------");
			theTerm = parseInt(ret);
			if (theTerm<=4) {
			    
			    if (theTerm==1) {
			        var y=document.createElement('option');
    				y.text=terms_by_1[1];				
    				y.setAttribute('value',1);		
    				var x=$('term');
    
    				if (navigator.appName=="Microsoft Internet Explorer") {
    					x.add(y); // IE only  
    				} else {
    					x.add(y,null);
    				}
			    } else if (theTerm==2) {
			        for(c = 1; c <= theTerm; c++){
        		    	var y=document.createElement('option');
        				y.text=terms_by_2[c];			
        				y.setAttribute('value',c);		
        				var x=$('term');
        
        				if (navigator.appName=="Microsoft Internet Explorer") {
        					x.add(y); // IE only  
        				} else {
        					x.add(y,null);
        				}
    			    }	
                } else if (theTerm==3) {
                    for(c = 1; c <= theTerm; c++){
        		    	var y=document.createElement('option');
        				y.text=terms_by_3[c];			
        				y.setAttribute('value',c);		
        				var x=$('term');
        
        				if (navigator.appName=="Microsoft Internet Explorer") {
        					x.add(y); // IE only  
        				} else {
        					x.add(y,null);
        				}
    			    }
                } else if (theTerm==4) {
			        for(c = 1; c <= theTerm; c++){
        		    	var y=document.createElement('option');
        				y.text=terms_by_4[c];			
        				y.setAttribute('value',c);		
        				var x=$('term');
        
        				if (navigator.appName=="Microsoft Internet Explorer") {
        					x.add(y); // IE only  
        				} else {
        					x.add(y,null);
        				}
    			    }
			    }
			    
			} else {
			    // greater 4 terms
			    
			    for(c = 1; c <= theTerm; c++){
    		    	var y=document.createElement('option');
    				y.text=c;			
    				y.setAttribute('value',c);		
    				var x=$('term');
    
    				if (navigator.appName=="Microsoft Internet Explorer") {
    					x.add(y); // IE only  
    				} else {
    					x.add(y,null);
    				}
			    }	
    			    
			}
			
  			$('name').value 				= "";
  			$('idno').value 				= "";
  			$('assID').value 				= "";
  			$('assID_td').innerHTML 		= "-";
			$('amtPaid').innerHTML 			= "-";
			$('accID').innerHTML 			= "-";
			$('accID_input').value 			= "";
			//$('oldBalance').innerHTML 	= "-";
			//$('tuition').innerHTML 		= "-";
			//$('labFee').innerHTML 		= "-";
			//$('regFee').innerHTML 		= "-";
			//$('miscFee').innerHTML 		= "-";
			//$('totalFees').innerHTML 	= "-";
			//$('addAdj').innerHTML 		= "-";
			//$('lessAdj').innerHTML 		= "-";
			//$('ttlPayment').innerHTML 	= "-";
			$('ttlDue').innerHTML 		= "-";
			$('balance').innerHTML 		= "-";

			
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

$('ORno').focus();
</script>