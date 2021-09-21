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

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME_ASSESSMENT'], $mod_strings['LBL_MODULE_TITLE_ASSESSMENT_HS'], false);
echo "\n</p>\n";
global $theme;
global $esConfig;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("Generate Col Assessment");
if ($access->check_access($current_user->id,$accessCode)) {
    
    // get all default setting from configs
    $config = new Config();
    
    // get the default school year
    $default_schYear = $config->getConfig('School Year');
    
    //school year
	$year = date("Y",time());
	
	$arrSchYear = array();
	for($yr=$config->getConfig('Since Year'); $yr<=$year; $yr++) {
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
	
	// get the default terms
	$total_terms = $config->getConfig('Terms');
	
	$terms ='<select name="term" id="term">'."\n";
	$terms.='<option value="">---------</option>'."\n";
    $ctr=1;
    while ($ctr<=$total_terms) {
        if ($ctr==$term) {
           $terms .= '<option value="'.$ctr.'" selected>'.$ctr.'</option>'."\n";
        } else {
           $terms .= '<option value="'.$ctr.'">'.$ctr.'</option>'."\n";
        }
        $ctr++;    
    }

	$schYear.='</select>';
	$sugar_smarty->assign('TERMS', $terms);
    
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    echo $sugar_smarty->fetch('modules/Account/templates/bulkAssessmentHS.tpl');
} else {
    $msg = "Sorry, you dont have permission to access to this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script>
addToValidate('frmAssessment','schYear', '', true, 'School Year');
addToValidate('frmAssessment','semCode', '', true, 'Semester');
addToValidate('frmAssessment','term', '', true, 'Term');
addToValidate('frmAssessment','courseID', '', true, 'Course');
addToValidate('frmAssessment','yrLevel', '', true, 'Year');
</script>


<script language="javascript">

function display()
{
    
    schYear = $('schYear').value;
    term    = $('term').value;
    yrLevel = $('yrLevel').value;
    msg = "";
    if (!schYear) {
        msg += "\nSchool Year";
    }
    
    if (!yrLevel) {
        msg += "\nYear";
    }
    
    if (!term) {
        msg += "\nTerm";
    }
    
    if (!msg) {
        if (confirm('Bulk printing. \nPress OK to continue then please wait while loading requested assessments.')) {
            popUp('index.php?module=Account&action=printBulkAssessmentHS&schYear='+schYear+'&term='+term+'&yrLevel='+yrLevel+'&sugar_body_only=1');        
        }
    } else {
        alert("Error: Required fields\n"+msg);
    }
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
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=700,height=600,left = 0,top = 0');");
}


</script>
