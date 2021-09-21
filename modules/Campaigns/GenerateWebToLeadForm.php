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
/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('include/formbase.php');
require_once('modules/Campaigns/Campaign.php');
require_once('modules/Administration/Administration.php');
require_once('modules/Leads/Lead.php');
require_once('include/utils.php');
require_once('include/utils/db_utils.php');
require_once ('modules/EditCustomFields/FieldsMetaData.php');


global $app_list_strings, $app_strings,$mod_strings;

$site_url = $sugar_config['site_url'];
$web_form_header = $mod_strings['LBL_LEAD_DEFAULT_HEADER'];
$web_form_description = $mod_strings['LBL_DESCRIPTION_TEXT_LEAD_FORM'];
$web_form_submit_label = $mod_strings['LBL_DEFAULT_LEAD_SUBMIT'];
$web_form_required_fileds_msg = $mod_strings['LBL_PROVIDE_WEB_TO_LEAD_FORM_FIELDS'];
$web_required_symbol = $app_strings['LBL_REQUIRED_SYMBOL'];
$web_post_url = $site_url.'/WebToLeadCapture.php';
$web_redirect_url = '';
$web_notify_campaign = '';
$web_assigned_user = '';
$web_team_user = '';
$web_form_footer = '';

//_ppd($web_required_symbol);
if(!empty($_REQUEST['web_header'])){
	$web_form_header= $_REQUEST['web_header'];
}
if(!empty($_REQUEST['web_description'])){
	$web_form_description= $_REQUEST['web_description'];
}
if(!empty($_REQUEST['web_submit'])){
	$web_form_submit_label=to_html($_REQUEST['web_submit']);	
}
if(!empty($_REQUEST['post_url'])){
	$web_post_url= $_REQUEST['post_url'];
}
if(!empty($_REQUEST['redirect_url']) && $_REQUEST['redirect_url'] !="http://"){
	$web_redirect_url= $_REQUEST['redirect_url'];
}
if(!empty($_REQUEST['notify_campaign'])){
	$web_notify_campaign = $_REQUEST['notify_campaign'];
}
if(!empty($_REQUEST['web_footer'])){
	$web_form_footer= $_REQUEST['web_footer'];
}
if(!empty($_REQUEST['campaign_id'])){
	$web_form_campaign= $_REQUEST['campaign_id'];
}
if(!empty($_REQUEST['assigned_user_id'])){
	$web_assigned_user = $_REQUEST['assigned_user_id'];
}







 $lead = new Lead(); 
 $fieldsMetaData = new FieldsMetaData();
 $xtpl=new XTemplate ('modules/Campaigns/WebToLeadForm.html');
 $xtpl->assign("MOD", $mod_strings);
 $xtpl->assign("APP", $app_strings);
 $Web_To_Lead_Form_html="<form action='$web_post_url' name='WebToLeadForm' method='POST'>";
 $Web_To_Lead_Form_html .= "<table width='100%' style='border-top: 1px solid; 
border-bottom: 1px solid; 
padding: 10px 6px 12px 10px; 
background-color: rgb(233, 243, 255); 
font-size: 12px; 
background-repeat: repeat-x; 
background-position: center top;'>";

$Web_To_Lead_Form_html .= "<tr align='center' style='color: rgb(0, 105, 225); font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 18px; font-weight: bold; margin-bottom: 0px; margin-top: 0px;'><TD COLSPAN='4'><b><h2>$web_form_header</h2></b></TD></tr>";
$Web_To_Lead_Form_html .= "<tr align='center' style='color: rgb(0, 105, 225); font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 2px; font-weight: normal; margin-bottom: 0px; margin-top: 0px;'><TD COLSPAN='4'>&nbsp</TD></tr>"; 
$Web_To_Lead_Form_html .= "<tr align='left' style='color: rgb(0, 105, 225); font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 12px; font-weight: normal; margin-bottom: 0px; margin-top: 0px;'><TD COLSPAN='4'>$web_form_description</TD></tr>";
$Web_To_Lead_Form_html .= "<tr align='center' style='color: rgb(0, 105, 225); font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 8px; font-weight: normal; margin-bottom: 0px; margin-top: 0px;'><TD COLSPAN='4'>&nbsp</TD></tr>"; 
     
 //$Web_To_Lead_Form_html .= "\n<p>\n";

if(!empty($_REQUEST['colsFirst']) && !empty($_REQUEST['colsSecond'])){ 
 if(count($_REQUEST['colsFirst']) < count($_REQUEST['colsSecond'])){
   $columns= count($_REQUEST['colsSecond']);
 }
 if(count($_REQUEST['colsFirst']) > count($_REQUEST['colsSecond']) || count($_REQUEST['colsFirst']) == count($_REQUEST['colsSecond'])){
   $columns= count($_REQUEST['colsFirst']);
 }
}
else if(!empty($_REQUEST['colsFirst'])){
 $columns= count($_REQUEST['colsFirst']);	
}
else if(!empty($_REQUEST['colsSecond'])){
 $columns= count($_REQUEST['colsSecond']);	
}


$required_fields = array();
for($i= 0; $i<$columns;$i++){
	$colsFirstField = '';
	$colsSecondField = '';

	if(!empty($_REQUEST['colsFirst'][$i])){
		$colsFirstField = $_REQUEST['colsFirst'][$i];
	 }	
	if(!empty($_REQUEST['colsSecond'][$i])){
		$colsSecondField = $_REQUEST['colsSecond'][$i];
	 }		
	 		
	if(isset($lead->field_defs[$colsFirstField]) && $lead->field_defs[$colsFirstField] != null)
	{
		 $field_vname = preg_replace('/:$/','',translate($lead->field_defs[$colsFirstField]['vname'],'Leads'));
		 $field_name  = $colsFirstField;
		 $field_label = $field_vname .": ";
		 if(isset($lead->field_defs[$colsFirstField]['custom_type']) && $lead->field_defs[$colsFirstField]['custom_type'] != null){
		 	$field_type= $lead->field_defs[$colsFirstField]['custom_type'];
		 }
		 else{ 
		    $field_type= $lead->field_defs[$colsFirstField]['type'];
		 }
		 $field_required = '';
		 if(isset($lead->field_defs[$colsFirstField]['required']) && $lead->field_defs[$colsFirstField]['required'] != null){
		 	$field_required = $lead->field_defs[$colsFirstField]['required'];
		 	if (! in_array($lead->field_defs[$colsFirstField]['name'], $required_fields)){
		 	  array_push($required_fields,$lead->field_defs[$colsFirstField]['name']); 	  
		     }
		  }
		  if($lead->field_defs[$colsFirstField]['name']=='last_name'){
		 	if (! in_array($lead->field_defs[$colsFirstField]['name'], $required_fields)){
		  	  array_push($required_fields,$lead->field_defs[$colsFirstField]['name']); 	  
		    }
		  }
		 if($field_type=='enum')  $field_options= $lead->field_defs[$colsFirstField]['options'];
	}
	//preg_replace('/:$/','',translate($field_def['vname'],'Leads')
	if(isset($lead->field_defs[$colsSecondField]) && $lead->field_defs[$colsSecondField] != null)
	{
		 $field1_vname= preg_replace('/:$/','',translate($lead->field_defs[$colsSecondField]['vname'],'Leads'));
		 $field1_name= $colsSecondField;
		 $field1_label = $field1_vname .": ";
		 if(isset($lead->field_defs[$colsSecondField]['custom_type']) && $lead->field_defs[$colsSecondField]['custom_type'] != null){
		 	$field1_type= $lead->field_defs[$colsSecondField]['custom_type'];
		 }
		 else{ 
		    $field1_type= $lead->field_defs[$colsSecondField]['type'];
		 }
		 $field1_required = '';
		 if(isset($lead->field_defs[$colsSecondField]['required']) && $lead->field_defs[$colsSecondField]['required'] != null){
		  $field1_required = $lead->field_defs[$colsSecondField]['required'];
		   if (! in_array($lead->field_defs[$colsSecondField]['name'], $required_fields)){
		  	  array_push($required_fields,$lead->field_defs[$colsSecondField]['name']); 	   	  
		    }
		 }
		 if($lead->field_defs[$colsSecondField]['name']=='last_name'){
		 	if (! in_array($lead->field_defs[$colsSecondField]['name'], $required_fields)){
		 	  array_push($required_fields,$lead->field_defs[$colsSecondField]['name']);  
		    }
		 } 
		 if($field1_type=='enum')  $field1_options= $lead->field_defs[$colsSecondField]['options'];
	} 

   	 $Web_To_Lead_Form_html .= "<tr>";         
      	       
    if(isset($lead->field_defs[$colsFirstField]) && $lead->field_defs[$colsFirstField] != null){
	    if($field_type=='enum'){ 	                         
	      $lead_options = '';
	      if(!empty($lead->$field_name)){
	      	$lead_options= get_select_options_with_id($app_list_strings[$field_options], $lead->$field_name);
	      }     
	      else{
	      	$lead_options= get_select_options_with_id($app_list_strings[$field_options], '');
	      }
	      if($field_required){
	        	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field_label</span sugar='slot'><span class='required' style='color: rgb(255, 0, 0);'>$web_required_symbol</span></td>";
	        }
	     else{
	     	  	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field_label</span sugar='slot'></td>";
	         }
	      if(isset($lead->field_defs[$colsFirstField]['isMultiSelect']) && $lead->field_defs[$colsFirstField]['isMultiSelect'] ==1){
	      	$Web_To_Lead_Form_html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'><select id=$field_name multiple='true' name=$field_name tabindex='1'>$lead_options</select></span sugar='slot'></td>";
	      }elseif(ifRadioButton($lead->field_defs[$colsFirstField]['name'])){
            $Web_To_Lead_Form_html .="<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'>";
            foreach($app_list_strings[$field_options] as $field_option){ 
                $Web_To_Lead_Form_html .="<input id='$colsFirstField"."_$field_option' name='radio_grp_$colsFirstField' value='$field_option' type='radio'>";
                $Web_To_Lead_Form_html .="<span ='document.getElementById('".$lead->field_defs[$colsFirstField]."_$field_option').checked =true style='cursor:default'; onmousedown='return false;'>$field_option</span><br>";
            }
            $Web_To_Lead_Form_html .="</span sugar='slot'></td>";
          }else{
	        $Web_To_Lead_Form_html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'><select id=$field_name name=$field_name tabindex='1'>$lead_options</select></span sugar='slot'></td>";
	      }
	     }   
	     if($field_type=='bool'){      
	      if($field_required){
	       		$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field_label</span sugar='slot'><span class='required' style='color: rgb(255, 0, 0);'>$web_required_symbol</span></td>";
	      }
	      else{
	      		$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field_label</span sugar='slot'></td>";
	      }
	      $Web_To_Lead_Form_html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'><input type='checkbox' id=$field_name name=$field_name></span sugar='slot'></td>";
	     } 
	     if( $field_type=='text' ||  $field_type=='varchar' ||  $field_type=='name'
	      ||  $field_type=='phone' || $field_type=='email'){        
	       if($field_name=='last_name' ||   $field_required){	             
	       	   	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field_label</span sugar='slot'><span class='required' style='color: rgb(255, 0, 0);'>$web_required_symbol</span></td>";
	      	  }
	      	else{
	      	   	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field_label</span sugar='slot'></td>";	
	      	 }
	       $Web_To_Lead_Form_html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'><input id=$field_name name=$field_name type='text'></span sugar='slot'></td>";             
	        }
       }
      else{
        	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>&nbsp</span sugar='slot'></td>";
        	$Web_To_Lead_Form_html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'>&nbsp</span sugar='slot'></td>";  
        }      
               
     if(isset($lead->field_defs[$colsSecondField]) && $lead->field_defs[$colsSecondField] != null){
	     if($field1_type=='enum'){ 	                         
          $lead1_options = '';
          if(!empty($lead->$field1_name)){   
	      	$lead1_options= get_select_options_with_id($app_list_strings[$field1_options], $lead->$field1_name);
          } 
          else{
          	$lead1_options= get_select_options_with_id($app_list_strings[$field1_options], '');
          }    
	      	if($field1_required){
	        	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field1_label</span sugar='slot'><span class='required' style='color: rgb(255, 0, 0);'>$web_required_symbol</span></td>";
	        }
	     	else{
	     	  	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field1_label</span sugar='slot'></td>";
	         }	       
	        if(isset($lead->field_defs[$colsSecondField]['isMultiSelect']) && $lead->field_defs[$colsSecondField]['isMultiSelect'] ==1){ 
	      		$Web_To_Lead_Form_html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'><select id=$field1_name name=$field1_name multiple='true' tabindex='1'>$lead1_options</select></span sugar='slot'></td>";
	        }elseif(ifRadioButton($lead->field_defs[$colsSecondField]['name'])){
                $Web_To_Lead_Form_html .="<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'>";
                foreach($app_list_strings[$field1_options] as $field_option){ 
                                    $Web_To_Lead_Form_html .="<input id='$colsSecondField"."_$field_option' name='radio_grp_$colsSecondField' value='$field_option' type='radio'>";
                    $Web_To_Lead_Form_html .="<span ='document.getElementById('".$lead->field_defs[$colsSecondField]."_$field_option').checked =true style='cursor:default'; onmousedown='return false;'>$field_option</span><br>";
                }
                $Web_To_Lead_Form_html .="</span sugar='slot'></td>";
            }else{ 
	      		$Web_To_Lead_Form_html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'><select id=$field1_name name=$field1_name tabindex='1'>$lead1_options</select></span sugar='slot'></td>";
	        }	        
	     }         
	     if($field1_type=='bool'){      
	      if($field1_required){
	       	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field1_label</span sugar='slot'><span class='required' style='color: rgb(255, 0, 0);'>$web_required_symbol</span></td>";
	      }
	      else{
	       	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field1_label</span sugar='slot'></td>";
	      }
	      	$Web_To_Lead_Form_html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'><input id=$field1_name name=$field1_name type='checkbox'></span sugar='slot'></td>";
	     } 
	     if( $field1_type=='text' ||  $field1_type=='varchar' ||  $field1_type=='name'
	      ||  $field1_type=='phone' || $field1_type=='email'){
	      	if($field1_name=='last_name' ||  $field1_required){	             
	       	   	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field1_label</span sugar='slot'><span class='required' style='color: rgb(255, 0, 0);'>$web_required_symbol</span></td>";
	      	  }
	      	else{
	      	   	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>$field1_label</span sugar='slot'></td>";	
	      	 }         
	        $Web_To_Lead_Form_html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'><input id=$field1_name name=$field1_name type='text'></span sugar='slot'></td>";             
	       }
      }
      else{
        	$Web_To_Lead_Form_html .= "<td width='15%' style='text-align: left; font-size: 12px; font-weight: normal;'><span sugar='slot'>&nbsp</span sugar='slot'></td>";
        	$Web_To_Lead_Form_html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'>&nbsp</span sugar='slot'></td>";  
       }            
       $Web_To_Lead_Form_html .= "</tr>";	           	  
}
  
$Web_To_Lead_Form_html .= "<tr align='center' style='color: rgb(0, 105, 225); font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 18px; font-weight: bold; margin-bottom: 0px; margin-top: 0px;'><TD COLSPAN='4'>&nbsp</TD></tr>";

if(!empty($web_form_footer)){ 
	$Web_To_Lead_Form_html .= "<tr align='center' style='color: rgb(0, 105, 225); font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 18px; font-weight: bold; margin-bottom: 0px; margin-top: 0px;'><TD COLSPAN='4'>&nbsp</TD></tr>";
	$Web_To_Lead_Form_html .= "<tr align='left' style='color: rgb(0, 105, 225); font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 12px; font-weight: normal; margin-bottom: 0px; margin-top: 0px;'><TD COLSPAN='4'>$web_form_footer</TD></tr>";
}

$Web_To_Lead_Form_html .= "<tr align='center'><td colspan='10'><input type='button' onclick='check_webtolead_fields();' class='button' name='Submit' value='$web_form_submit_label'/></td></tr>";

if(!empty($web_form_campaign)){
   $Web_To_Lead_Form_html .= "<tr><td style='display: none'><input type='hidden' id='campaign_id' name='campaign_id' value='$web_form_campaign'></td></tr>";	
}
if(!empty($web_redirect_url)){
	$Web_To_Lead_Form_html .= "<tr><td style='display: none'><input type='hidden' id='redirect_url' name='redirect_url' value='$web_redirect_url'></td></tr>";
}
if(!empty($web_assigned_user)){
	$Web_To_Lead_Form_html .= "<tr><td style='display: none'><input type='hidden' id='assigned_user_id' name='assigned_user_id' value='$web_assigned_user'></td></tr>";
}





$req_fields='';
if(isset($required_fields) && $required_fields != null){
	foreach($required_fields as $req){
 		$req_fields=$req_fields.$req.';';
	}
}
if(!empty($req_fields)){
	$Web_To_Lead_Form_html .= "<tr><td style='display: none'><input type='hidden' id='req_id' name='req_id' value='$req_fields'></td></tr>";
}

$Web_To_Lead_Form_html .= "</table >";
$Web_To_Lead_Form_html .="</form>";

$Web_To_Lead_Form_html .="<script type='text/javascript'> 	
 function check_webtolead_fields(){
 	if(document.getElementById('req_id') != null){
	 	var reqs=document.getElementById('req_id').value;
	 	reqs = reqs.substring(0,reqs.lastIndexOf(';'))		
	    var req_fields = new Array();
	    var req_fields = reqs.split(';');									
		nbr_fields = req_fields.length;	 		    
		var req = true;
		for(var i=0;i<nbr_fields;i++){ 			       
	      if(document.getElementById(req_fields[i]).value.length <=0){       
	   	   req = false;																				
	       break;		
	      }		
	    }    	
		if(req){
			document.WebToLeadForm.submit();
			return true;
		}
		else{
		  alert('$web_form_required_fileds_msg');	  
		  return false;
		 }		
		return false
   }		
   else{
  	document.WebToLeadForm.submit();
   }		 		
}
</script>";

if(isset($Web_To_Lead_Form_html)) $xtpl->assign("BODY", $Web_To_Lead_Form_html); else $xtpl->assign("BODY", "");
if(isset($Web_To_Lead_Form_html)) $xtpl->assign("BODY_HTML", $Web_To_Lead_Form_html); else $xtpl->assign("BODY_HTML", "");

if( file_exists("include/FCKeditor/fckeditor.php"))
{
  include("include/FCKeditor_Sugar/FCKeditor_Sugar.php") ;
  ob_start();
  $instancename='body_html';
  $oFCKeditor = new FCKeditor_Sugar($instancename) ;
  if( !empty($Web_To_Lead_Form_html)) {
    $oFCKeditor->Value = $Web_To_Lead_Form_html ;
  }
  $oFCKeditor->Create() ;  
  $htmlarea_src =  ob_get_contents();
  $xtpl->assign("HTMLAREA",$htmlarea_src);
  $xtpl->parse("main.htmlarea");
  ob_end_clean();

  $xtpl->assign("INSERT_VARIABLE_ONCLICK", "insert_variable_html(document.EditView.variable_text.value)");
  $xtpl->parse("main.variable_button");
}

$xtpl->parse("main");
$xtpl->out("main");

function ifRadioButton($customFieldName){
	$custRow = null;
	$query="select id,data_type from fields_meta_data where deleted = 0 and name = '$customFieldName'";	        
    $result=$GLOBALS['db']->query($query);
    $row = $GLOBALS['db']->fetchByAssoc($result);            
    if($row != null && $row['data_type'] == 'radioenum'){
    	return $custRow = $row;
    }    
    return $custRow;
}

?>
