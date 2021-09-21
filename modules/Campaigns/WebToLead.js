/**
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
 */

//grid functions

var grid2, grid3, grid4, grid3F,grid4F;
var add_all_fields = SUGAR.language.get('app_strings', 'LBL_ADD_ALL_LEAD_FIELDS');
var remove_all_fields = SUGAR.language.get('app_strings', 'LBL_REMOVE_ALL_LEAD_FIELDS');
/*
var WebToLeadForm = function(){	
    //var grid2, grid3, grid4;    
    function getDDText(){
        var count = this.getSelectionCount();
        var indexes = this.getSelectedRowIndexes();
        return selectFields(indexes,this);
    }
    function tenRowsOrMore(grid,indexes,targetGrid,e){    	
    	 var count =0;
            for(var j=Math.round(indexes.length/10);j>=0;j--){              	           	 		              	             	                
            	var indexesN = new Array();
            	var k =0;
            	for(var i=9;i>=0;i--){            	  	
                  if(indexes[j*10+i] != null && indexes[j*10+i] >=0 && count <=indexes.length){     
                    indexesN[k]=indexes[j*10+i];
                    count++;
                    k++;
            	   }
            	 }
            	if(indexesN.length >0){
            	//alert("index len "+ indexesN.length);
            	//alert("index array "+ indexesN);	 
            	grid.transferRows(indexesN, targetGrid, targetGrid.getTargetRow(e), e.ctrlKey); 
            	targetGrid.getDataModel().sort(null,0,'ASC'); 
            	}
          }
    }
  
    function moveRows234(grid, dd, id, e){
        if(grid.id != id) { // if row order, let DDGrid handle it
            if(id=='ddgrid3'){
             var targetGrid = (id == 'ddgrid2' ? grid2: grid3);
             }           
            if(id=='ddgrid4'){
             var targetGrid = (id == 'ddgrid2' ? grid2: grid4);
             }  
            var indexes = grid.getSelectedRowIndexes();                             
            if(indexes.length > 10){  
              tenRowsOrMore(grid,indexes,targetGrid,e)            	
             }              
            else{               	
             grid.transferRows(indexes, targetGrid, targetGrid.getTargetRow(e), e.ctrlKey);
            }
            displayAddRemoveDragButtons(add_all_fields,remove_all_fields);
            grid3F=grid3;            
            grid4F=grid4;
        }
    }
    function moveRows324(grid, dd, id, e){
        if(grid.id != id) { // if row order, let DDGrid handle it
            if(id=='ddgrid2'){
             var targetGrid = (id == 'ddgrid3' ? grid3: grid2);
             }           
            
            if(id=='ddgrid4'){
             var targetGrid = (id == 'ddgrid3' ? grid3: grid4);
             }                                         
            var indexes = grid.getSelectedRowIndexes();
            if(indexes.length >10){
              tenRowsOrMore(grid,indexes,targetGrid,e);
            }
            else{
             grid.transferRows(indexes, targetGrid, targetGrid.getTargetRow(e), e.ctrlKey);
            }
            displayAddRemoveDragButtons(add_all_fields,remove_all_fields);
            grid3F=grid3;            
            grid4F=grid4;
        }
    }
    
    function moveRows432(grid, dd, id, e){
        if(grid.id != id) { // if row order, let DDGrid handle it
            //var targetGrid = (id == 'ddgrid2' ? grid2 : grid3);

           if(id=='ddgrid2'){             
             var targetGrid = (id == 'ddgrid4' ? grid4: grid2);
             }           
            if(id=='ddgrid3'){
             var targetGrid = (id == 'ddgrid4' ? grid4: grid3);
             }                    
            var indexes = grid.getSelectedRowIndexes();
            if(indexes.length >10){
              tenRowsOrMore(grid,indexes,targetGrid,e);
            }
            else{
             grid.transferRows(indexes, targetGrid, targetGrid.getTargetRow(e), e.ctrlKey);
            }
            displayAddRemoveDragButtons(add_all_fields,remove_all_fields);
            grid3F=grid3;            
            grid4F=grid4;
        }
    }    
    
    return {
    	lead_fields : [],
        init : function(){                           
            grid2 = new YAHOO.ext.grid.DDGrid(
                'ddgrid2', 
                new YAHOO.ext.grid.DefaultDataModel(WebToLeadForm.lead_fields),
                new YAHOO.ext.grid.DefaultColumnModel([
           		    {header: 'Available Fields'}           		    
        		])        		        		
            );
            grid2.on('dragdrop', moveRows234);
            grid2.getDragDropText = getDDText;            
            grid2.autoSizeColumns = true; 
            grid2.autoSizeHeaders = true;    
            grid2.trackMouseOver = false; 
            grid2.getDataModel().sort(null,0,'ASC');       
            grid2.render();
                        
            grid3 = new YAHOO.ext.grid.DDGrid(
                'ddgrid3',
                new YAHOO.ext.grid.DefaultDataModel([]),
                new YAHOO.ext.grid.DefaultColumnModel([
                {header: 'Lead Form (First Column)'}                
            	])           	
            );
            
            grid3.on('dragdrop', moveRows324);
            grid3.getDragDropText = getDDText;
            grid3.autoSizeColumns = true; 
            grid3.autoSizeHeaders = true;
            grid2.trackMouseOver = false;
            grid3.render();
            grid3F=grid3;                
                       
            grid4 = new YAHOO.ext.grid.DDGrid(
                'ddgrid4', 
                new YAHOO.ext.grid.DefaultDataModel([]),
                new YAHOO.ext.grid.DefaultColumnModel([
        		{header: 'Lead Form (Second Column) '}
            	])
            );
            grid4.on('dragdrop', moveRows432);
            grid4.getDragDropText = getDDText;
            grid4.autoSizeColumns = true; 
            grid4.autoSizeHeaders = true;            
            grid4.render();               
            grid4F=grid4;
        }
    };       
}();
YAHOO.util.Event.addListener(window, 'load', WebToLeadForm.init);
*/
function addGrids(form_name) {
    //check if any vals selected in grid3 and grid4
    // if none then prompt for validation
    //alert(check_form('WebToLeadCreation'));
  if(!check_form('WebToLeadCreation')){
  	  return false;
  	//stop
  }        
   else{
 	  grid3 = SUGAR_GRID_grid1;
      grid4 = SUGAR_GRID_grid2;   	
      var webFormDiv = document.getElementById('webformfields');         
      //add columns to webformfields div          
      addCols(grid3,'colsFirst',webFormDiv);
      addCols(grid4,'colsSecond',webFormDiv);  
      return true;           
  }      	                                       	  //return check_form(form_name);	
}
function checkFields(REQUIRED_LEAD_FIELDS,LEAD_SELECT_FIELDS){
     grid2 = SUGAR_GRID_grid0;
	 grid3 = SUGAR_GRID_grid1;
	 grid4 = SUGAR_GRID_grid2;
	 //check if all required fields are selected
	 var reqFields = '';
	 for(var i=0; i<grid2.getDataModel().getTotalRowCount(); i++){
	 	if(grid2.getDataModel().getRow([i])[2] !=null){	 		
	 		reqFields = reqFields+grid2.getDataModel().getRow([i])[0]+', ';        
	 	}
	 } 
	 if(reqFields){
	 	reqFields = reqFields.substring(0,reqFields.lastIndexOf(','));
     	alert(REQUIRED_LEAD_FIELDS+' '+reqFields);  
     	return false;   	
     }
	 else if(grid3.getDataModel().getTotalRowCount()==0 && grid4.getDataModel().getTotalRowCount()==0){        
       alert(LEAD_SELECT_FIELDS);
       return false;
      }           
     else{
       return true;
     }    
}

function askLeadQ(direction,REQUIRED_LEAD_FIELDS,LEAD_SELECT_FIELDS){                
            //change current step value to that of the step being navigated to
            if(direction == 'back'){
               var grid_Div = document.getElementById('grid_Div');
               var lead_Div = document.getElementById('lead_queries_Div');
    		  	grid_Div.style.display='block';
                lead_Div.style.display='none';
            }
            if(direction == 'next'){
              if(!checkFields(REQUIRED_LEAD_FIELDS,LEAD_SELECT_FIELDS)){
               	  return false;
               }
              else{
               var lead_Div = document.getElementById('lead_queries_Div');
               var grid_Div = document.getElementById('grid_Div');
               lead_Div.style.display='block';
               grid_Div.style.display='none';
               } 
            }    
    }
 function campaignPopulated(){
    var camp_populated = document.getElementById('campaign_id');
    if(camp_populated.value == 0){ 
      return true;
     };
    return true; 
  }
 
 function selectFields(indexes,grid){
 	var retStr='';
   	for(var i=0;i<indexes.length;i++){
   		retStr=retStr+grid.getRow(indexes[i]).childNodes[0].childNodes[0].innerHTML+','+'\n';
   		retStr=retStr+'\n';
   	}
   	return retStr.substring(0,retStr.lastIndexOf(','));
 }
//            grid4.render();

function displayAddRemoveDragButtons(Add_All_Fields,Remove_All_Fields){
    var addRemove = document.getElementById("lead_add_remove_button");    
    if(grid2.getDataModel().getTotalRowCount() ==0) {
    addRemove.setAttribute('value',Remove_All_Fields);	
     addRemove.setAttribute('title',Remove_All_Fields);	
    }
    else if(grid3.getDataModel().getTotalRowCount() ==0 && grid4.getDataModel().getTotalRowCount() ==0){
      addRemove.setAttribute('value',Add_All_Fields);	
     addRemove.setAttribute('title',Add_All_Fields);		
   }	
}

function displayAddRemoveButtons(Add_All_Fields,Remove_All_Fields){
    var addRemove = document.getElementById("lead_add_remove_button");    
    if(grid2.getDataModel().getTotalRowCount() >0) {
     addRemove.setAttribute('value',Add_All_Fields);	
     addRemove.setAttribute('title',Add_All_Fields);		
    }
    else{
     addRemove.setAttribute('value',Remove_All_Fields);	
     addRemove.setAttribute('title',Remove_All_Fields);		
    }	
}
function dragDropAllFields(Add_All_Fields,Remove_All_Fields){
   //set the grids to the SUGAR_GRID grids
   
   grid2 = SUGAR_GRID_grid0;
   grid3 = SUGAR_GRID_grid1;
   grid4 = SUGAR_GRID_grid2;
   //move from main grid to columns 1&2
   var addRemove = document.getElementById("lead_add_remove_button");   
   if(addRemove.value==Add_All_Fields && grid2.getDataModel().getTotalRowCount() >0) {
     for(var i=0;i<grid2.getDataModel().getTotalRowCount();i++){
   		//var leadField = grid2.getRow(indexes[i]).childNodes[0].childNodes[0].innerHTML;   		
        if(i%2 ==0){
        	grid3.getDataModel().addRow(grid2.getDataModel().getRow(i));      
        }
        if(i%2 ==1){
        	grid4.getDataModel().addRow(grid2.getDataModel().getRow(i));        
        }   		           	                  	
   	 }
//   	 alert(grid2.getDataModel().getTotalRowCount());
     for(var i=grid2.getDataModel().getTotalRowCount()-1;i>=0;i--){     	     	
        grid2.getDataModel().removeRow(i);             	
     }  	    	 
    }        
   else if(addRemove.value==Remove_All_Fields){ //move back to the main grid if grid is empty and columns populated
   	   var count =0;
       if(grid3.getDataModel().getTotalRowCount() >= grid4.getDataModel().getTotalRowCount()){
       	 count = grid3.getDataModel().getTotalRowCount();
        }
       else{
       	count = grid4.getDataModel().getTotalRowCount();
       }     	
       //put back into grid2 in the same order
   	   for(var i=0;i<count;i++){
       	if(grid3.getDataModel().getRow(i) != null){
       	 grid2.getDataModel().addRow(grid3.getDataModel().getRow(i));              
       	}
       	if(grid4.getDataModel().getRow(i) != null){
       	 grid2.getDataModel().addRow(grid4.getDataModel().getRow(i));              
       	}
   	   }   	   
   	   for(var i=grid3.getDataModel().getTotalRowCount()-1;i>=0;i--){     	     	
        grid3.getDataModel().removeRow(i);             	
       }
        for(var i=grid4.getDataModel().getTotalRowCount()-1;i>=0;i--){     	     	
        grid4.getDataModel().removeRow(i);             	
      }
   } 
   displayAddRemoveButtons(Add_All_Fields,Remove_All_Fields);
}

 
 function addCols(grid,colsNumber,webFormDiv){
   for(var i=0;i<grid.getDataModel().getTotalRowCount();i++){   	
     var selectedEl = grid.getDataModel().getRow(i)[1];
     var webField = document.createElement('input');
     webField.setAttribute('id', colsNumber+i);    
     webField.setAttribute('name',colsNumber+'[]');    
     webField.setAttribute('type', 'hidden');    
     webField.setAttribute('value',selectedEl);
     webFormDiv.appendChild(webField);             
    } 
 }   
 function editUrl(){     
     var chk_url_elm = document.getElementById("chk_edit_url");     
     if(chk_url_elm.checked==true){      
       var url_elm = document.getElementById("post_url");       
        url_elm.disabled=false;
      }
     if(chk_url_elm.checked==false){
       var url_elm = document.getElementById("post_url");
        url_elm.disabled=true;
      }
 }


