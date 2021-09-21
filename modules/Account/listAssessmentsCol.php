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

require_once('config.php');
require_once('include/Sugar_Smarty.php');
require_once('modules/Config/ConfigCol.php');  
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Account/Account.php');
require_once('modules/Account/Assessment.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_ASSESSMENT'], $mod_strings['LBL_MODULE_TITLE_ASSESSMENT_COL']."", false);
echo "\n</p>\n";
global $theme;
global $pageLimit;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("List Col Assessment");
if ($access->check_access($current_user->id,$accessCode)) {
    $config     = new Config();
    $assessment = new Assessment();
    
    $limit  = $_GET['limit']?  $_GET['limit']:$pageLimit[$_GET['module']];
    $offset = $_GET['offset']? $_GET['offset']:0;
    
    if ($_GET['cmdFilter']) {
        $idno   = trim($_GET['idno']);
        $lname  = trim($_GET['lname']);
        $fname  = trim($_GET['fname']);
        $mname  = trim($_GET['mname']);
        $term   = trim($_GET['term']);
        $courseID = trim($_GET['courseID']);
        $yrLevel  = trim($_GET['yrLevel']);
        $schYear  = trim($_GET['schYear']);
        $semCode  = trim($_GET['semCode']);
        
        $term     = trim($_GET['term']);
    } else {
        $idno   = $_SESSION[$_GET['module'].'ColAss_idno'];
        $lname  = $_SESSION[$_GET['module'].'ColAss_lname'];
        $fname  = $_SESSION[$_GET['module'].'ColAss_fname'];
        $mname  = $_SESSION[$_GET['module'].'ColAss_mname'];
        $term   = $_SESSION[$_GET['module'].'ColAss_term'];
        $courseID = $_SESSION[$_GET['module'].'ColAss_courseID'];
        $yrLevel  = $_SESSION[$_GET['module'].'ColAss_yrLevel'];
        $schYear  = $_SESSION[$_GET['module'].'ColAss_schYear'];
        $semCode  = $_SESSION[$_GET['module'].'ColAss_semCode'];
        $term     = $_SESSION[$_GET['module'].'ColAss_term'];
    }
    
    
    if (!isset($_GET['schYear']) && !isset($_SESSION[$_GET['module'].'ColAss_schYear'])) {
        // get the default schYear
        $schYear = $config->getConfig('School Year');
    }
    
    if (!isset($_GET['semCode']) && !isset($_SESSION[$_GET['module'].'ColAss_semCode'])) {
        // get the default semester
        $semCode = $config->getConfig('Semester');
    }
    
    // set session variables
    $_SESSION[$_GET['module'].'ColAss_idno']    = $idno;
    $_SESSION[$_GET['module'].'ColAss_lname']   = $lname;
    $_SESSION[$_GET['module'].'ColAss_fname']   = $fname;
    $_SESSION[$_GET['module'].'ColAss_mname']   = $mname;
    $_SESSION[$_GET['module'].'ColAss_courseID']= $courseID;
    $_SESSION[$_GET['module'].'ColAss_yrLevel'] = $yrLevel;
    $_SESSION[$_GET['module'].'ColAss_schYear'] = $schYear;
    $_SESSION[$_GET['module'].'ColAss_semCode'] = $semCode;
    $_SESSION[$_GET['module'].'ColAss_term']    = $term;
    
    if ($schYear) {
        if (count($conds[0])) {
            $conds[0][' AND assessments.schYear'] = " = '$schYear' ";
        } else {
            $conds[0]['assessments.schYear'] = " = '$schYear' ";
        }
    }
    
    if ($semCode) {
        if (count($conds[0])) {
            $conds[0][' AND assessments.semCode'] = " = '$semCode' ";
        } else {
            $conds[0]['assessments.semCode'] = " = '$semCode' ";
        }
    }
    
    if ($term) {
        if (count($conds[0])) {
            $conds[0][' AND assessments.term'] = "= '$term' ";
        } else {
            $conds[0]['assessments.term'] = "= '$term' ";
        }
    }
    
    if (trim($idno)!='') {
        if (count($conds[0])) {
            $conds[0][' AND assessments.idno'] = "= '$idno' ";
        } else {
            $conds[0]['assessments.idno'] = "= '$idno' ";
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
    
    if ($courseID) {
        if (count($conds[0])) {
            $conds[0][' AND assessments.courseID'] = " = '$courseID' ";
        } else {
            $conds[0]['assessments.courseID  '] = " = '$courseID' ";
        }
    }
    
    if ($yrLevel) {
        if (count($conds[0])) {
            $conds[0][' AND assessments.yrLevel'] = " = '$yrLevel' ";
        } else {
            $conds[0]['assessments.yrLevel'] = " = '$yrLevel' ";
        }
    }

    
//    $allAssessments = $assessment->retrieveAllAssessmentsAssociated($conds);
    $allAssessments = $assessment->countAllAssessmentsAssociated($conds);
    $list        = $assessment->retrieveAllAssessmentsAssociated($conds,"assessments.schYear","DESC",$offset, $limit);
    
	$total_rec=$allAssessments;
    
    // this is to convert the term in word = 1:Prelim 2:Midterm 3:PreFinal 4:Final
    if ($list) {
       $theAssessments = array();
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
    	//admission display
        if ($row['rstatus'] == '2') {
           $sugar_smarty->assign('rstatus', $row['rstatus']);
        } else {
           $sugar_smarty->assign('rstatus', '1');
        }
       $theAssessments[]=$row;
       }
    }
    
    $main_url="index.php?module=Account&action=listAssessmentsCol&idno=$idno&lname=$lname&fname=$fname&mname=$mname&courseID=$courseID&term=$term&schYear=$schYear&semCode=$semCode&yrLevel=$yrLevel";
    
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

	//semester
	$semesters='<select name="semCode" id="semCode"  onchange="getTerms();">'."\n";
	$semesters.='<option value="">-------</option>'."\n";
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
	
	$sugar_smarty->assign('SCHOOLYEAR', $schoolYear);
	$sugar_smarty->assign('SEMESTERS', $semesters);
    
    // course list
    $course = new Course();
    $sugar_smarty->assign('courseList', $course->retrieveAllCourses() );
    
    
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
	
	// check if the list is empty
    if (!count($theAssessments)) {
        $theAssessments = "";
    }
    
    $sugar_smarty->assign('list', $theAssessments );
    $sugar_smarty->assign('idno', $idno );
    $sugar_smarty->assign('term', $term );
    $sugar_smarty->assign('lname', $lname );
    $sugar_smarty->assign('fname', $fname );
    $sugar_smarty->assign('mname', $mname );
    $sugar_smarty->assign('courseID', $courseID );
    $sugar_smarty->assign('schYear', $schYear );
    $sugar_smarty->assign('semCode', $semCode );
    $sugar_smarty->assign('yrLevel', $yrLevel );
    $sugar_smarty->assign('pagination',  pageSetup($image_path,$main_url,$offset,$total_rec,$limit,$export_link,$print_link) );
    
    echo $sugar_smarty->fetch('modules/Account/templates/listAssessmentsCol.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>




<script type='text/javascript'>

function getTerms()
{
    get_data="semCode=" + $('semCode').value + "&action=getterms";
    ajaxQuery("modules/Account/accountHandler.php",'GET',get_data,"","onGetTermsHandle");
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
	    	initializeCombo('term',"----------");
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

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=530,left = 0,top = 0');");
}

// set focus
$('idno').focus();
</script>