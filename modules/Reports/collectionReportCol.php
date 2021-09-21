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
require_once('modules/Config/RecordLog.php');
require_once('modules/Reports/ReportCol.php');

echo "\n<p>\n";
echo get_module_title('collectionReports-college', $mod_strings['LBL_MODULE_TITLE_CR_COL'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Collection Report Col");
if ($access->check_access($current_user->id,$accessCode)) {
    
    // declare all instances
    $orheader       = new ORHeader();
    $ordetails      = new ORDetails();
    $config         = new Config();
    $reportClass    = new ReportClass();
    
    $term=trim($_POST['term']);
    
    if ($_POST['theForm']) {
        // filter result
        // get the default Cofiguration
        $schYear        = $default_schYear = $_POST['schYear'];
        $semCode        = $default_semCode = $_POST['semCode'];
        $tuition        = $config->getConfig('Tuition Account Code');
        $registration   = $config->getConfig('Reg Account Code');
        $miscellaneous  = $config->getConfig('Misc Account Code');
        $laboratory     = $config->getConfig('Lab Account Code');
        
        /**
         * get the collections
         */
        // get all courses
        $course = new Course();
        $courses = $course->retrieveAllCourses();
        
        $result = array();
        $index=0;
        foreach ($courses as $course) {
            $result[$index]=array();
            //$report[$index]['dept']=$course['deptCode'];
            $result[$index]['course']=$course['courseCode'];
            
            $ctr=1;
            while ($ctr<=5) {
            	//$query1 = " SELECT sum( orheader.totalAmount ) AS total_amount FROM orheader WHERE orheader.dateCreated >= '$fdate' AND orheader.dateCreated <= '$tdate' AND orheader.cashier = '$id' AND orheader.rstatus=1 ";
                //$query      = "Select sum(ordetails.amount) as total_amount From orheader, ordetails, students Where orheader.orno=ordetails.orno and orheader.idno=students.idno and orheader.schYear='$schYear' and orheader.semCode='$semCode' and orheader.term=$term and students.courseID='".$course['courseID']."' and students.yrLevel=$ctr and orheader.rstatus=1";
                $query      = "Select sum(orheader.totalAmount) as total_amount From orheader, students Where orheader.idno=students.idno and orheader.schYear='$schYear' and orheader.semCode='$semCode' and orheader.term=$term and students.courseID='".$course['courseID']."' and students.yrLevel=$ctr and orheader.rstatus=1";
                $records    = $reportClass->adhocQuery($query);
                
                if ($records[0]['total_amount']) {
        	       $result[$index][$ctr] = $records[0]['total_amount'];	
                } else {
        	       $result[$index][$ctr] = 0;	
                }
            	    
                $result[$index]['total'] += $result[$index][$ctr];
                $result['gtotal'][$ctr]  += $result[$index][$ctr];
                $result['gtotal']['total']  += $result[$index][$ctr];
                
                $ctr++;
            }
            
            $index++;
        }
        
        $sugar_smarty->assign('RESULT', $reportClass->collectionReportCollege($result));
        
    } else {
        // get the default school year
        $default_schYear = $config->getConfig('School Year');
        
        // get the default semester
        $default_semCode = $config->getConfig('Semester');
        
        $sugar_smarty->assign('RESULT', "");
    }
    
    
    $semesters='<select name="semCode" id="semCode" onchange="getTerms();">'."\n";
    $semesters.='<option value="">-----------------------------</option>'."\n";
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

    $terms ='<select name="term" id="term">'."\n";
	$terms.='<option value="">-------------------</option>'."\n";
	
	if ($term=="0") {
	   $terms.='<option value="0" selected>Registration</option>'."\n";
	} else {
	   $terms.='<option value="0">Registration</option>'."\n";
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
	$sugar_smarty->assign('semCode', $default_semCode);
	$sugar_smarty->assign('term', $term);
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Reports/templates/collectionReportCol.tpl');	
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
addToValidate('frmCollectionReport','semCode', '', true, 'Semester');
addToValidate('frmCollectionReport','term', '', true, 'Period');
</script>

<script language="javascript">

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=500,left = 0,top = 0');");
}


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
	    	initializeCombo('term',"-------------------");
			theTerm = parseInt(ret);
			if (theTerm<=4) {
			    
			    if (theTerm==1) {
			        var y=document.createElement('option');
    				y.text="Registration";			
    				y.setAttribute('value',"Registration");		
    				var x=$('term');
    
    				if (navigator.appName=="Microsoft Internet Explorer") {
    					x.add(y); // IE only  
    				} else {
    					x.add(y,null);
    				}
				
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
			        var y=document.createElement('option');
    				y.text="Registration";			
    				y.setAttribute('value',"Registration");		
    				var x=$('term');
    
    				if (navigator.appName=="Microsoft Internet Explorer") {
    					x.add(y); // IE only  
    				} else {
    					x.add(y,null);
    				}
    				
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
                    var y=document.createElement('option');
    				y.text="Registration";			
    				y.setAttribute('value',"Registration");		
    				var x=$('term');
    
    				if (navigator.appName=="Microsoft Internet Explorer") {
    					x.add(y); // IE only  
    				} else {
    					x.add(y,null);
    				}
                    
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
                    var y=document.createElement('option');
    				y.text="Registration";			
    				y.setAttribute('value',"Registration");		
    				var x=$('term');
    
    				if (navigator.appName=="Microsoft Internet Explorer") {
    					x.add(y); // IE only  
    				} else {
    					x.add(y,null);
    				}
    				
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
			    var y=document.createElement('option');
				y.text="Registration";			
				y.setAttribute('value',"Registration");		
				var x=$('term');

				if (navigator.appName=="Microsoft Internet Explorer") {
					x.add(y); // IE only  
				} else {
					x.add(y,null);
				}
			    
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


// get the correspoding terms
//getTerms();

// set focus
$('schYear').focus();

</script>

