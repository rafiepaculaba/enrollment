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
require_once('modules/Students/StudentCol.php');
require_once('modules/Payments/PaymentType.php');
require_once('modules/Payments/Payment.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Col Payment");
if ($access->check_access($current_user->id,$accessCode)) {
	
	// get all default setting from configs
    $config = new Config();
	$payment = new Payment();
	
	$limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
	$offset = $_GET['offset']? $_GET['offset']:0;
	
	if ($_GET['cmdFilter']) {	
		$paymentID 		= $_GET['paymentID'];
		$schYear   		= $_GET['schYear'];
		$semCode   		= $_GET['semCode'];
		$term   		= $_GET['term'];
		$idno   		= $_GET['idno'];
		$ORno   		= $_GET['ORno'];
		$lname   		= $_GET['lname'];
		$fname   		= $_GET['fname'];
		$mname   		= $_GET['mname'];
		$rstatus   		= $_GET['rstatus'];
	} else {
		$paymentID     	= $_SESSION[$_GET['module'].'Col_paymentID'];
		$schYear     	= $_SESSION[$_GET['module'].'Col_schYear'];
		$semCode     	= $_SESSION[$_GET['module'].'Col_semCode'];
		$term     		= $_SESSION[$_GET['module'].'Col_term'];
		$idno     		= $_SESSION[$_GET['module'].'Col_idno'];
		$ORno     		= $_SESSION[$_GET['module'].'Col_ORno'];
		$lname     		= $_SESSION[$_GET['module'].'Col_lname'];
		$fname     		= $_SESSION[$_GET['module'].'Col_fname'];
		$mname     		= $_SESSION[$_GET['module'].'Col_mname'];
		$rstatus     	= $_SESSION[$_GET['module'].'Col_rstatus'];
	}

	if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'Col_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }
    if (!isset($_GET['semCode']) && !isset($_SESSION[$_GET['module'].'Col_semCode'])) {
        // get the default semester
        $semCode = $config->getConfig('Semester');
    }

	//set session variables
	$_SESSION[$_GET['module'].'Col_paymentID']	= $paymentID;
	$_SESSION[$_GET['module'].'Col_schYear']	= $schYear;
	$_SESSION[$_GET['module'].'Col_semCode']	= $semCode;
	$_SESSION[$_GET['module'].'Col_term']		= $term;
	$_SESSION[$_GET['module'].'Col_idno']		= $idno;
	$_SESSION[$_GET['module'].'Col_ORno']		= $ORno;
	$_SESSION[$_GET['module'].'Col_lname']		= $lname;
	$_SESSION[$_GET['module'].'Col_fname']		= $fname;
	$_SESSION[$_GET['module'].'Col_mname']		= $mname;
	$_SESSION[$_GET['module'].'Col_rstatus']	= $rstatus;
    
    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND payments.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['payments.schYear'] = " = '$schYear' ";
        }
    }
	
    if ($semCode) {
        if (count($conds[0])) {
            $conds[0][' AND payments.semCode'] = " = '$semCode' ";
        } else {
            $conds[0]['payments.semCode'] = " = '$semCode' ";
        }
    }
	
    if (trim($paymentID)!='') {
        if (count($conds[0])) {
            $conds[0][' AND payments.paymentID'] = " = '$paymentID' ";
        } else {
            $conds[0]['payments.paymentID'] = " = '$paymentID' ";
        }
    }
    
    if (trim($ORno)!='') {
        if (count($conds[0])) {
            $conds[0][' AND payments.ORno'] = " = '$ORno' ";
        } else {
            $conds[0]['payments.ORno'] = " = '$ORno' ";
        }
    }

    if (trim($idno)!='') {
        if (count($conds[0])) {
            $conds[0][' AND payments.idno'] = " = '$idno' ";
        } else {
            $conds[0]['payments.idno'] = " = '$idno' ";
        }
    }

    if (trim($lname)!='') {
        if (count($conds[0])) {
            $conds[0][' AND students.lname'] = " like '$lname%' ";
        } else {
            $conds[0]['students.lname'] = " like '$lname%' ";
        }
    }

    if (trim($fname)!='') {
        if (count($conds[0])) {
            $conds[0][' AND students.fname'] = " like '$fname%' ";
        } else {
            $conds[0]['students.fname'] = " like '$fname%' ";
        }
    }

    if (trim($mname)!='') {
        if (count($conds[0])) {
            $conds[0][' AND students.mname'] = " like '$mname%' ";
        } else {
            $conds[0]['students.mname'] = " like '$mname%' ";
        }
    }

    if ($term) {
        if (count($conds[0])) {
            $conds[0][' AND payments.term'] = " = '$term' ";
        } else {
            $conds[0]['term'] = " = '$term' ";
        }
    }

    if (trim($rstatus)!='') {
        if (count($conds[0])) {
            $conds[0][' AND payments.rstatus'] = " = '$rstatus' ";
        } else {
            $conds[0]['payments.rstatus'] = " = '$rstatus' ";
        }
    }
    
//	$allPayments = $payment->retrieveAllStudentPayments($conds);
	$allPayments = $payment->countAllStudentPayments($conds);
	$list        = $payment->retrieveAllStudentPayments($conds,"paymentID","ASC",$offset, $limit);
	
//	if ($allPayments)
//		$total_rec=count($allPayments);
//	else 
//		$total_rec=0;
		
	$total_rec = $allPayments;

	$main_url="index.php?module=Payments&action=listPayments&paymentID=$paymentID&schYear=$schYear&semCode=$semCode&term=$term&ORno=$ORno&idno=$idno&lname=$lname&fname=$fname&mname=$mname&rstatus=$rstatus";
	
	// this is to convert the term in word = 1:Prelim 2:Midterm 3:PreFinal 4:Final
    if ($list) {
       $colpayments = array();
       foreach ($list as $row) {
           if ($row['semCode']<4) {
               // regular semester
               $total_terms = $config->getConfig('Semestral Terms');
               switch ($total_terms) {
                case 2:
                    $row['term'] = $term_by_2[$row['term']];
                    break;
                case 3:
                    $row['term'] = $term_by_3[$row['term']];
                    break;
                case 4:
                    $row['term'] = $term_by_4[$row['term']];
                    break;
               }
               
           } else {
               // summer
               $total_terms = $config->getConfig('Summer Terms');
               switch ($total_terms) {
                case 2:
                    $row['term'] = $term_by_2[$row['term']];
                    break;
                case 3:
                    $row['term'] = $term_by_3[$row['term']];
                    break;
                case 4:
                    $row['term'] = $term_by_4[$row['term']];
                    break;
               }
           }
           
           $colpayments[]=$row;
       }
    }

    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
		$arrSchYear[] = $yr."-".($yr+1);
	}
	
	$schoolYear='<select name="schYear" id="schYear" >'."\n";
	$schoolYear.='<option value="">---------------</option>'."\n";
	if ($arrSchYear) {
	    foreach ($arrSchYear as $value) {
	    	if ($value == $schYear) {
	        	$schoolYear .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$schoolYear .= '<option value="'.$value.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$schoolYear.='</select>';
	$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);
	
	//semester
	$semesters='<select name="semCode" id="semCode" onchange = "getTerms();">'."\n";
	$semesters.='<option value="">---------------</option>'."\n";
	if ($esConfig['semesters']) {
	    foreach ($esConfig['semesters'] as $key=>$value) {
	    	if ($key == $semCode) {
	        	$semesters .= '<option value="'.$key.'" selected>'.$value.'</option>'."\n";
	    	} else {
	        	$semesters .= '<option value="'.$key.'">'.$value.'</option>'."\n";
	    	}
	    }
	}
	$semesters.='</select>';
	
	$sugar_smarty->assign('SEMESTERS', $semesters);

	    // get the default semcode
    $total_terms = 0;
	if ($semCode<4) {
	    if ($semCode) {
            $total_terms = $config->getConfig('Semestral Terms');
	    }
	} else {
	    if ($semCode) {
	       $total_terms = $config->getConfig('Summer Terms');
	    }
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
    
	$terms ='<select name="term" id="term">'."\n";
	$terms.='<option value="">----------</option>'."\n";
	if ($theTerms) {
	    if (is_array($theTerms)) {
    	    foreach ($theTerms as $key=>$value) {
    	       if ($key==$term) {
                $terms .= '<option value="'.$key.'" selected>'.$value.'</option>'."\n";
    	       } else {
                $terms .= '<option value="'.$key.'">'.$value.'</option>'."\n";
    	       }
    	    }
	    } else {
	        $ctr=1;
	        while ($ctr<=$theTerms) {
	            if ($ctr==$term) {
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

    if (!count($colpayments)) {
    	$colpayments = "";
    }

	$sugar_smarty->assign('list', $colpayments );
	$sugar_smarty->assign('paymentID', $paymentID );
	$sugar_smarty->assign('schYear', $schYear );
	$sugar_smarty->assign('semCode', $semCode );
	$sugar_smarty->assign('term', $term );
	$sugar_smarty->assign('ORno', $ORno );
	$sugar_smarty->assign('idno', $idno );
	$sugar_smarty->assign('lname', $lname );
	$sugar_smarty->assign('fname', $fname );
	$sugar_smarty->assign('mname', $mname );
	$sugar_smarty->assign('rstatus', $rstatus );
	$sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit) );
	
	echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
	echo $sugar_smarty->fetch('modules/Payments/templates/listPayments.tpl');
	
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}

?>
<script language="javascript">
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
	    	initializeCombo('term',"---------------------");
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
			
    	} else {
    	    msg="Error: Can't get any response from the server.";
    		displayError(msg);
    	}
    }
}

$('paymentID').focus();
</script>