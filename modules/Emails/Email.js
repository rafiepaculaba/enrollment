/**
 * EditView javascript for Email
 *
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



var uploads_arr=new Array();
var uploads_count_map=new Object();
var uploads_count = -1;
var current_uploads_id = -1;
var append = false; // FCKEd has method InsertHTML which inserts at cursor point - plain does not
//following varaibles store references to input fields grouped with the clicked email selection button (select).
var current_contact = '';
var current_contact_id = '';
var current_contact_email = '';
var current_contact_name = '';
var uploadIndex = 0;
var select_image = SUGAR.language.get('app_strings', 'LBL_ONLY_IMAGE_ATTACHMENT');

function toggleRawEmail() {
	var raw = document.getElementById('rawEmail');
	var button = document.getElementById('rawButton');
	
	if(raw.style.display == '') {
		raw.style.display = 'none';
		button.value = showRaw;
	} else {
		raw.style.display = '';
		button.value = hideRaw;
	}
}

///////////////////////////////////////////////////////////////////////////////
////	DOCUMENT HANDLING HELPERS

function deletePriorAttachment(id) {
	var rem = document.getElementById('removeAttachment');
	
	if(rem.value != '') {
		rem.value += "::";
	}
	rem.value += id;
	
	document.getElementById('noteDiv'+id).style.display = 'none';
}


function setDocument(target, documentId, documentName,docRevId) {	
	var docId = eval("window.opener.document.forms.EditView.documentId" + target);
	var docName = window.opener.document.getElementById('documentName' + target);
	var docRevisionId = window.opener.document.getElementById('document' + target);
    docId.value = documentId;
	docName.value = documentName;
	docRevisionId.value = docRevId;
	window.close();
}

function setDocumentToCampaignTemplate(target, documentId, documentName,docRevId) {	
//	var docId = eval("window.opener.document.forms.EditView.documentId" + target);
	var docId = window.opener.document.getElementById('documentId' + target);
	//var docName = eval("window.opener.document.EditView.documentName" + target);
	var docName = window.opener.document.getElementById('documentName' + target);
	
	var docId = window.opener.document.getElementById('documentId');
	var docName = window.opener.document.getElementById('documentName');
	var docRevisionId = window.opener.document.getElementById('docRevId');
	
    docId.value = documentId;
    //docId.onchange('docUpload(); form_reset_doc();');
	docName.value = documentName;
	docRevisionId.value = docRevId;
	docName.onchange('docUpload(); form_reset_doc();');	
	//alert(docName.onchange);	
	window.close();
}

function selectDocument(target) {
	URL="index.php?module=Emails&action=PopupDocuments&target=" + target;
	windowName = 'selectDocument';
	windowFeatures = 'width=800' + ',height=600' + ',resizable=1,scrollbars=1';

	win = window.open(URL, windowName, windowFeatures);
	if(window.focus) {
		// put the focus on the popup if the browser supports the focus() method
		win.focus();
	}
}

function addDocument() {
	for(var i=0;i<10;i++) {
		var elem = document.getElementById('document'+i);
		if(elem.style.display == 'none') {
		  	elem.style.display='block';
			break;
		}
	}
}

function deleteDocument(index) {
	var elem = document.getElementById('document'+index);
	document.getElementById('documentId'+index).value = "";
	document.getElementById('documentName'+index).value = "";
	elem.style.display='none';
}

// attachment functions below
function deleteFile(index) {
	//get div element
	var elem = document.getElementById('file'+index);
	//get upload widget
	var ea_input = document.getElementById('email_attachment'+index);

	//get the parent node
	var Parent = ea_input.parentNode;

	//create replacement node
	var ea = document.createElement('input');
    ea.setAttribute('id', 'email_attachment' + index);
    ea.setAttribute('name', 'email_attachment' + index);
    ea.setAttribute('tabindex', '120');
    ea.setAttribute('size', '40');    
    ea.setAttribute('type', 'file');

	//replace the old node with the new one
    Parent.replaceChild(ea, ea_input);

	//hide the div element
	elem.style.display='none';

}

function addFile() {
	for(var i=0;i<10;i++) {
		var elem = document.getElementById('file'+i);
		if(elem.style.display == 'none') {
		  	elem.style.display='block';
			break;
		}
	}
}
////	END DOCUMENT HANDLING HELPERS
///////////////////////////////////////////////////////////////////////////////

///// New file upload code

function multiFiles( list_target){
	// Where to write the list
    this.list_target = list_target;
	//this.list_target = document.getElementById(list_target);
	// How many elements?
	this.count = 0;
	// How many elements?
	this.id = 0;
	// Is there a maximum?
		 		    
	//alert("test");
	/**
	 * Add a new file input element
	 */
	this.addElement = function( element ){
		// Make sure it's a file input element
		if( element.tagName == 'INPUT' && element.type == 'file' ){
  		    var currCount =this.id++;
			// Element name -- what number am I?
			//element.name = 'file_' + this.id++;
		   	 element.name = 'email_attachment' + currCount;
		   	 element.id   = 'email_attachment' + currCount;		   

			// Add reference to this object
			element.multi_selector = this;			           
			// What to do when a file is selected			
   			
	       element.onchange = function(){	
    
	        //AJAX call begins	            
	        var callback = {
		     upload:function(r) {					
		     //console.log("response object: %o", r);            
             var rets = JSON.parse(r.responseText);
		     } 
	        } 

	      var url ='index.php?module=EmailTemplates&action=AttachFiles';	  	  
		 YAHOO.util.Connect.setForm(document.getElementById("upload_form"), true,true);								        
         YAHOO.util.Connect.asyncRequest('POST', url, callback,null);
      //AJAX call ends
      	        
               //var theForm = document.getElementById('upload_form');	
                 var theForm = document.getElementById('EditView');	
           
                     	 
				// New file input
				var new_element = document.createElement( 'input' );
				new_element.type = 'file';
		   	   // new_element.name = 'email_attachment' +up++;

				// Add new element
				this.parentNode.insertBefore( new_element, this );                
				// Apply 'update' to element
				this.multi_selector.addElement( new_element );
				// Update list
				this.multi_selector.addListRow( this );
				// Hide this: we can't use display:none because Safari doesn't like it
                 //this.style.display='none';
                //display none works fine for FF and IE
                this.style.display = 'none';
                //later for Safari add following
				//this.style.position = 'absolute';
				//this.style.left = '-5000px';		     
		};			        			
			// File element counter
			this.count++;
			// Most recent element
			this.current_element = element;	
								
		} else {
			// This can only be applied to file input elements!
			alert( 'Error: not a file input element' );
		};
	};

	/**
	 * Add a new row to the list of files
	 */
	this.addListRow = function( element ){    
		// Row div
		var new_row = document.createElement( 'div' );
          
		// Delete button
		var new_row_button_remove = document.createElement( 'input' );
        new_row_button_remove.type = 'button';
        new_row_button_remove.value = 'Remove';
		
		var new_row_file_name = document.createElement( 'input' );
		new_row_file_name.type = 'text';
		new_row_file_name.size = '40';

		var new_row_chk_box = document.createElement( 'input' );
		new_row_chk_box.setAttribute('id','checkBoxFile[]');
		new_row_chk_box.setAttribute('name','checkBoxFile[]');
		new_row_chk_box.type = 'checkbox';
		new_row_chk_box.checked =false;	
		new_row_chk_box.disabled =true;
		     
	   var new_row_attach_file = document.createElement( 'input' );
	   new_row_attach_file.type = 'image';
       new_row_attach_file.value ='/themes/Sugar/images/company_logo.png';	
       new_row_attach_file.disabled ='true';	

    var imgElement = document.createElement("img");
	imgElement.setAttribute("src", "themes/Sugar/images/Accounts.gif");	
	imgElement.setAttribute("align","absmiddle");
	imgElement.setAttribute("alt","File");
	imgElement.setAttribute("border","0");
	imgElement.setAttribute("height","18");
	imgElement.setAttribute("width","16");
	
	var new_row_button_embed = document.createElement("img");
	new_row_button_embed.setAttribute("src", "themes/Sugar/images/attachment.gif");	
	new_row_button_embed.setAttribute("align","absmiddle");
	new_row_button_embed.setAttribute("alt","Embed");
	new_row_button_embed.setAttribute("border","0");
	new_row_button_embed.setAttribute("height","20");
	new_row_button_embed.setAttribute("width","20");
	
	
	
       /*  
		var new_row_button_embed = document.createElement( 'input' );
        new_row_button_embed.type = 'button';
		new_row_button_embed.value = 'Embed';
       */
		// References
		new_row.element = element;
        element.size='40';
		// Delete function
		new_row_button_remove.onclick= function(){	
			// Remove element from form
			this.parentNode.element.parentNode.removeChild( this.parentNode.element );			
			var filename = this.parentNode.element.value;
			var filename =  filename.replace(/\\/g,'/')
			var text = filename.split("/");									
			nbr_elements = text.length;			
	    	if(text[nbr_elements-1].indexOf('gif')>=0 || text[nbr_elements-1].indexOf('bmp') >= 0 || text[nbr_elements-1].indexOf('png') >= 0
	    	   || text[nbr_elements-1].indexOf('jpg') >= 0 || text[nbr_elements-1].indexOf('GIF')>=0 || text[nbr_elements-1].indexOf('BMP') >= 0
	    	   || text[nbr_elements-1].indexOf('PNG') >= 0 || text[nbr_elements-1].indexOf('JPG') >= 0)
	    	   {
	    		var imglocation = unescape(document.location.pathname.substr(1));
	    		imglocation = imglocation.substring(0,imglocation.lastIndexOf('/')+1);                          
                imglocation='/'+imglocation+'cache/images/';
                image='<img src="'+imglocation+unescape(text[nbr_elements-1])+'" alt="" />';
                imageAlt='<img alt="" src="'+imglocation+unescape(text[nbr_elements-1])+'" />';                	    		    	                	    		    	
                cidIm = '<img src="cid:'+unescape(text[nbr_elements-1])+'" alt="" />';
                cidImAlt = '<img alt="" src="cid:'+unescape(text[nbr_elements-1])+'" />';                
				var oEditor = FCKeditorAPI.GetInstance('body_html');				
				var currValFCK = oEditor.GetXHTML('');
	            if(currValFCK.indexOf(image) != -1 || currValFCK.indexOf(imageAlt) != -1 || currValFCK.indexOf(cidIm) != -1 
	               || currValFCK.indexOf(cidImAlt) != -1){
				  while(currValFCK.indexOf(image) != -1 || currValFCK.indexOf(imageAlt) != -1 ||
				        currValFCK.indexOf(cidIm) != -1 || currValFCK.indexOf(cidImAlt) != -1 ){			
				  //check where the space is and keep replacing with $#32
				   currValFCK = currValFCK.replace(image,'&#32');
				   currValFCK = currValFCK.replace(imageAlt,'&#32');
				   currValFCK = currValFCK.replace(cidIm,'&#32');
				   currValFCK = currValFCK.replace(cidImAlt,'&#32');                				   
				  }
				}
				oEditor.SetHTML(currValFCK,'');
	    	}
			// Remove this row from the list
			this.parentNode.parentNode.removeChild( this.parentNode );

			// Decrement counter
			this.parentNode.element.multi_selector.count--;

			// Re-enable input element (if it's disabled)
			this.parentNode.element.multi_selector.current_element.disabled = false;

			// Appease Safari
			// without it Safari wants to reload the browser window
			// which nixes your already queued uploads
			
			return false;
		};
		
		new_row_button_embed.onclick= function(){			
    	
	    	var filename =  element.value.replace(/\\/g,'/')
			var text = filename.split("/");									
			nbr_elements = text.length;

			//check if the file name has a space			
	    	text[nbr_elements-1]=text[nbr_elements-1].replace(/ /g,'&#32');
			
			if(text[nbr_elements-1].indexOf('gif')>=0 || text[nbr_elements-1].indexOf('bmp') >= 0 || text[nbr_elements-1].indexOf('png') >= 0
	    	   || text[nbr_elements-1].indexOf('jpg') >= 0 || text[nbr_elements-1].indexOf('GIF')>=0 || text[nbr_elements-1].indexOf('BMP') >= 0
	    	   || text[nbr_elements-1].indexOf('PNG') >= 0 || text[nbr_elements-1].indexOf('JPG') >= 0)						
               {	 		
	 			 cid='cid:'+text[nbr_elements-1];	
	             var imglocation = unescape(document.location.pathname.substr(1));                          
	             imglocation = imglocation.substring(0,imglocation.lastIndexOf('/')+1);                          
	             imglocation='/'+imglocation+'cache/images/';
	             embedImage="<img src="+imglocation+unescape(text[nbr_elements-1])+">";
	     		 var oEditor = FCKeditorAPI.GetInstance('body_html');             
	             embedImage = embedImage; 
	             embedImage1="<img src=cid:"+text[nbr_elements-1]+">";
		     	 oEditor.InsertHtml(embedImage1);
		         oEditor.InsertHtml(embedImage);
		         this.parentNode.childNodes[2].checked='true'; 
               } 
              else{
              	 alert(select_image);	
              } 

		};

		// Set row value
	/*	
		var oas = new ActiveXObject("Scripting.FileSystemObject");
        var d = document.a.b.value;
        var e = oas.getFile(d);
        var f = e.size;
        alert(f + " bytes");
		alert(element);
		*/
        //new_row_file_name.value =element.value; 
        new_row_file_name_tab = element.value.split("\\");
        //alert(new_row_file_name_tab);
        nbr_elements = new_row_file_name_tab.length;
        new_row_file_name.value = new_row_file_name_tab[nbr_elements-1]; 
         
		//new_row.innerHTML = element.value;
        //add all the elements
        //new_row.appendChild(new_row_attach_file);
        new_row.appendChild(imgElement);
        new_row.appendChild(new_row_button_embed);
        new_row.appendChild(new_row_chk_box);
		new_row.appendChild( new_row_file_name);
		// Add button
		new_row.appendChild( new_row_button_remove);		
		// Add it to the list
		this.list_target.appendChild( new_row );
		//document.getElementById(list_target).appendChild(new_row);		
	};
};


function docUpload() {

	//var theForm = document.getElementById('EditView');
	//var theForm = document.getElementById('upload_form');
        //AJAX call begins	            
        var rets ='';
	        var callback = {
		     upload:function(r) {					
		     //console.log("response object: %o", r);			
             rets = JSON.parse(r.responseText);
		     } 
	        } 

	      var url ='index.php?module=EmailTemplates&action=AttachDocuments';	  	  
		 //YAHOO.util.Connect.setForm(document.getElementById("upload_form"), true,true);								        
         YAHOO.util.Connect.asyncRequest('POST', url, callback,null);
      //AJAX call ends

	var element = document.getElementById('documentName');
	//alert(element.value);     
	var element1 = document.getElementById('documentId');
    var element2 = document.getElementById('docRevId');
	//alert(element1.value);     
	var elm = document.createElement('div');     
	elm.setAttribute('id','file'+uploadIndex);

	var sugarDoc = document.createElement('input');
    sugarDoc.setAttribute('type', 'label');    
    sugarDoc.setAttribute('disabled', 'true');
    sugarDoc.setAttribute('font', 'bold');
    sugarDoc.setAttribute('value',"Sugar Document"); 
    
        
    var new_row_button_embed_doc = document.createElement( 'input' );
    new_row_button_embed_doc.type = 'button';
    new_row_button_embed_doc.value = 'Embed';      
    
    var new_row_chk_box = document.createElement( 'input' );
    new_row_chk_box.setAttribute('id','checkBoxDoc'+uploadIndex);
    new_row_chk_box.setAttribute('name','checkBoxDoc'+uploadIndex);
	new_row_chk_box.type = 'checkbox';
	new_row_chk_box.checked =false;	 
    new_row_chk_box.disabled='true';	 	
    
   
	var eah = document.createElement('input');
    eah.setAttribute('id', 'documentId'+uploadIndex);
    eah.setAttribute('name', 'documentId'+uploadIndex);
    eah.setAttribute('tabindex', '120');    
    eah.setAttribute('type', 'hidden');
    eah.setAttribute('value',element1.value);  

    
	var attId = document.createElement('input');
    attId.setAttribute('id', 'docRevId'+uploadIndex);
    attId.setAttribute('name', 'docRevId'+uploadIndex);
    attId.setAttribute('tabindex', '120');    
    attId.setAttribute('type', 'hidden');
    attId.setAttribute('value',element2.value);  
         
	var ea = document.createElement('input');
    ea.setAttribute('id', 'document[]');
    ea.setAttribute('name', 'document[]');
    ea.setAttribute('tabindex', '120');
    ea.setAttribute('size', '40');    
    ea.setAttribute('type', 'text');
    //ea.setAttribute('disabled',true);
    ea.setAttribute('value',element.value);  
      
    var eai = document.createElement('input');
    eai.setAttribute('type', 'button');    
    //eai.setAttribute('onclick', 'deleteFile('+uploadIndex+');');
    eai.setAttribute('value', 'Remove');
    eai.onclick=function(){
    	var filename = this.parentNode.childNodes[4].value;
	    	if(filename != null){
	    		var imglocation = unescape(document.location.pathname.substr(1));
	    		imglocation = imglocation.substring(0,imglocation.lastIndexOf('/')+1);                          
                imglocation='/'+imglocation+'cache/upload/';
                image='<img src="'+imglocation+unescape(filename)+'" alt="" />';
                imageAlt='<img alt="" src="'+imglocation+unescape(filename)+'" />';                	    		    	                	    		    	
                cidIm = '<img src="cid:'+unescape(filename)+'" alt="" />';
                cidImAlt = '<img alt="" src="cid:'+unescape(filename)+'" />';                
				var oEditor = FCKeditorAPI.GetInstance('body_html');				
				var currValFCK = oEditor.GetXHTML('');
	            if(currValFCK.indexOf(image) != -1 || currValFCK.indexOf(imageAlt) != -1 || currValFCK.indexOf(cidIm) != -1 
	               || currValFCK.indexOf(cidImAlt) != -1){
				  while(currValFCK.indexOf(image) != -1 || currValFCK.indexOf(imageAlt) != -1 ||
				        currValFCK.indexOf(cidIm) != -1 || currValFCK.indexOf(cidImAlt) != -1 ){			
				  //check where the space is and keep replacing with $#32
				   currValFCK = currValFCK.replace(image,'&#32');
				   currValFCK = currValFCK.replace(imageAlt,'&#32');
				   currValFCK = currValFCK.replace(cidIm,'&#32');
				   currValFCK = currValFCK.replace(cidImAlt,'&#32');                				   
				  }
				}
				oEditor.SetHTML(currValFCK,'');
	    	}
    	this.parentNode.parentNode.removeChild(this.parentNode);
    }
    
    
    var new_row_button_embed = document.createElement("img");
	new_row_button_embed.setAttribute("src", "themes/Sugar/images/attachment.gif");	
	new_row_button_embed.setAttribute("align","absmiddle");
	new_row_button_embed.setAttribute("alt","Embed");
	new_row_button_embed.setAttribute("border","0");
	new_row_button_embed.setAttribute("height","20");
	new_row_button_embed.setAttribute("width","20");
	new_row_button_embed.onclick= function(){
        //retrieve the documentid
   	 this.parentNode.childNodes[2].checked='true';
				
      var documentRevisionId = this.parentNode.childNodes[4].value;
            //alert(this.parentNode);
             var imglocation = unescape(document.location.pathname.substr(1));                          
             imglocation = imglocation.substring(0,imglocation.lastIndexOf('/')+1);                          
             imglocation='/'+imglocation+'cache/upload/';
             embedImage='<img src='+imglocation+documentRevisionId+'>';
     		 var oEditor = FCKeditorAPI.GetInstance('body_html');
             embedImage1='<img src=cid:'+documentRevisionId+'>';	    	
	    	 oEditor.InsertHtml(embedImage1);
	         oEditor.InsertHtml(embedImage); 	
	 	
	/* 	
	var text = element.value;						
	thelink = "<a href='" + text + "''" + ">"+text+"</a>";
	//thelink = "<img src=cid:'" + text + "''" + ">rets[0]</img>";
	
    var oEditor = FCKeditorAPI.GetInstance('body_html');    
	oEditor.InsertHtml(thelink);
	*/
	
	};
	
   var SugarDoc = document.createElement("img");
   SugarDoc.setAttribute("src", "themes/Sugar/images/sugar_document.png");	
   SugarDoc.setAttribute("align","absmiddle");
   SugarDoc.setAttribute("alt","Embed");
   SugarDoc.setAttribute("border","0");
   SugarDoc.setAttribute("height","20");
   SugarDoc.setAttribute("width","20");

	
    //elm.appendChild(eah);  
    elm.appendChild(SugarDoc); 
    elm.appendChild(new_row_button_embed);
    elm.appendChild(new_row_chk_box);
    elm.appendChild(eah);
    elm.appendChild(attId);
    elm.appendChild(ea);
    elm.appendChild(eai);
    elm.style.display = 'block';    
    
     var rN= document.getElementById('attachments_div');
     rN.appendChild(elm);
     uploadIndex++;
}

function addUploadFiles(form_name) {	  
	    var chForm = document.getElementById('upload_div');		    
		var theForm = document.getElementById(form_name);				
		var elems = chForm.getElementsByTagName("input");
		
		//get the count of all the email_attachment file elements		
		var count = 0;
		for (var i=0; i<elems.length; i++) {
        if (elems[i].type == "file") {
        	count++;
          }        
        }
		//Use the count to add the documents		
		
        for (var i=0; i<count-1; i++) {        	
    //  	find out all the email_attachments and append to the EditView form
          var el = document.getElementsByName('email_attachment'+i);     
          if(el[0] != null){
	       theForm.appendChild(el[0]);       
          }
       }	
       var chForm = document.getElementById("upload_form");
       var elems = chForm.getElementsByTagName("input");
       for (var i=0; i<elems.length; i++) {        	
    //  	find out all the email_attachments and append to the EditView form
          var el = elems[i];         
          //var el = document.getElementsByName('checkBoxFile[]');     
         	
          if(el.id == 'checkBoxFile[]'){
           //alert(el.name);
	       theForm.appendChild(el);       
          }
       }       				
	}
	
function addUploadDocs(form_name) {
        var chForm = document.getElementById("upload_form");		    
		var theForm = document.getElementById(form_name);
		var attDiv = document.getElementById("attachments_div");
		var elems = chForm.getElementsByTagName("input");
		var elems1 = attDiv.getElementsByTagName("input");
        for (var i=0; i<elems1.length; i++) {
        //if (elems[i].type == "file") {
         var el = elems1[i];                  
        if(el.id=='document[]') { 		 	       	
	    theForm.appendChild(el);
		 }
        }
        for (var i=0; i<elems.length; i++) {
        //if (elems[i].type == "file") {
         var el = elems[i];         
         
        if(el.id=='document[]') { 		 	      	
	    theForm.appendChild(el);
		}
		if(el.id.indexOf('documentId')>=0 || el.id=='document[]') { 		 	
	    theForm.appendChild(el);
		}
      } 		
	}
	
function form_reset_doc() {
// var theForm = document.getElementById('upload_form');
 var theForm = document.getElementById('upload_div');
 var elems = theForm.getElementsByTagName("input");
 for (var i=0; i<elems.length; i++) {
 if (elems[i].type == "text" || "hidden" ) {
 var el = elems[i];
 if(el.id == 'documentName') {
   var new_el =document.createElement('input');
   new_el.type = 'text';
   new_el.name = el.name;
   new_el.id = el.id;
   new_el.onchange = el.onchange;
   //new_el.DISABLED='true';
   el.parentNode.replaceChild(new_el, el);
//   el.parentNode.insertBefore(new_el, el);
  // el.parentNode.removeChild(el);
   }
 if(el.id == 'documentId') {
   var new_el =document.createElement('input');
   new_el.type = 'hidden';
   new_el.name = el.name;
   new_el.id = el.id;
   //new_el.onchange = el.onchange;
   //new_el.DISABLED='true';
   el.parentNode.replaceChild(new_el, el);
//   el.parentNode.insertBefore(new_el, el);
  // el.parentNode.removeChild(el);
   }     
  }
 }
}
	
	
function selectDoc() {	
	URL="index.php?module=EmailTemplates&action=PopupDocumentsCampaignTemplate&target=" ;
	windowName = 'selectDocument';
	windowFeatures = 'width=800' + ',height=600' + ',resizable=1,scrollbars=1';
	win = window.open(URL, windowName, windowFeatures);
	if(window.focus) {
		// put the focus on the popup if the browser supports the focus() method
		win.focus();
	}
}
///////////////////////////////////////////////////////////////////////////////
////	HTML/PLAIN EDITOR FUNCTIONS
function setEditor() {
	if(document.getElementById('setEditor').checked == false) {
		toggle_textonly();
	}
}

// cn: bug 9690 - unchecked "Send HTML" - we hose the html_div contents
function prepSave() {
	if(document.getElementById('setEditor').checked == false) {
		document.getElementById('html_div').innerHTML = '';
	}
	
}

function toggle_textonly() {
	var altText = document.getElementById('alt_text_div');
	var plain = document.getElementById('text_div');
	var html = document.getElementById('html_div');
	
	var desc = document.getElementById('description');
	var oEditor = FCKeditorAPI.GetInstance('description_html');	
	
	// toggling INTO HTML editting
	if(html.style.display == 'none') {
		html.style.display = 'block';
		if(document.getElementById('toggle_textarea_elem').checked == false) {
			plain.style.display = 'none';
		}
		altText.style.display = 'block';
		
		var plainText = new String(desc.value);
		plainText = plainText.replace(/\n/gi, '<br />');
		oEditor.SetHTML(plainText, false);
	} else {
		// toggling into Plain Text ONLY
		html.style.display = 'none';
		plain.style.display = 'block';
		altText.style.display = 'none';
		
		if(oEditor.EditorDocument) {
			var htmlText = new String(oEditor.GetXHTML());
			htmlText = htmlText.replace(/<br \/>/gi, "\n");
			htmlText = htmlText.replace(/&gt;/gi, ">");
			htmlText = htmlText.replace(/&lt;/gi, "<");
			htmlText = htmlText.replace(/&nbsp;/gi, " ");
			desc.value = stripTags(htmlText);
		}
	}
}

function stripTags(str) {
	var theText = new String(str);
	
	if(theText != 'undefined') {
		return theText.replace(/<\/?[^>]+>/gi, '');
	}
}

function toggle_textarea() {
	var checkbox = document.getElementById('toggle_textarea_elem');
	var plain = document.getElementById('text_div');

	if (checkbox.checked == false) {
		plain.style.display = 'none';
	} else {
		plain.style.display = 'block';
	}
}
////	END HTML/PLAIN EDITOR FUNCTIONS
///////////////////////////////////////////////////////////////////////////////




///////////////////////////////////////////////////////////////////////////////
////	EMAIL TEMPLATE CODE
function fill_email(id) {
	var where = "parent_id='" + id + "'";
	var order = '';
	
	if(id == '') {
		// query based on template, contact_id0,related_to
		if(! append) {
			document.EditView.name.value  = '';
			document.EditView.description.value = '';
			document.EditView.description_html.value = '';
		}
		return;
	}
	call_json_method('EmailTemplates','retrieve','record='+id,'email_template_object', appendEmailTemplateJSON);
	args = {"module":"Notes","where":where, "order":order};
	
	if(typeof(global_rpcClient) == 'undefined') {
		global_rpcClient = new SugarRPCClient();
	}

	req_id = global_rpcClient.call_method('get_full_list', args);
	global_request_registry[req_id] = [ejo, 'display'];
}

function appendEmailTemplateJSON() {
	// query based on template, contact_id0,related_to
	if(document.EditView.name.value == '') { // cn: bug 7743, don't stomp populated Subject Line
		document.EditView.name.value = decodeURI(encodeURI(json_objects['email_template_object']['fields']['subject']));
	}

	document.EditView.description.value += decodeURI(encodeURI(json_objects['email_template_object']['fields']['body'])).replace(/<BR>/ig, '\n');
	var oEditor = FCKeditorAPI.GetInstance('description_html');
	
	// cn: bug 10985 - IE6/7 will show inline image at top of screen if we set this with no valid target
	if(document.getElementById('setEditor').checked == true) {
		oEditor.InsertHtml(decodeURI(encodeURI(json_objects['email_template_object']['fields']['body_html'])).replace(/<BR>/ig, '\n').replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"'));
	}

	var htmlDiv = document.getElementById('html_div');
	
	// hide the HTML editor if this is Plain-text only
	if((oEditor.EditorDocument.body.innerHTML == '' || oEditor.EditorDocument.body.innerHTML == '<br>') && htmlDiv.style.display == '') {
		var desc = document.getElementById('description');
		var plainText = new String(desc.value);
		plainText = plainText.replace(/\n/gi, '<br />');
		oEditor.SetHTML(plainText, false);

		// cn: bug 6212
		// if the template is plain-text, then uncheck "Send HTML Email"
		document.getElementById('setEditor').checked = false;
		setEditor();
	}
}

if(typeof SugarClass == "object") {
	SugarClass.inherit("EmailJsonObj","SugarClass");
}
function EmailJsonObj() {
}
EmailJsonObj.prototype.display = function(result) {
	var bean;
	var block = document.getElementById('template_attachments');
	var target = block.innerHTML;
	var full_file_path;

	for(i in result) {
		if(typeof result[i] == 'object') {
			bean = result[i];
			full_file_path = file_path + bean['id']+bean['filename'];
			target += '\n<input type="hidden" name="template_attachment[]" value="' + bean['id'] + '">';
			target += '\n<input type="checkbox" name="temp_remove_attachment[]" value="' + bean['id'] + '"> '+ lnk_remove + '&nbsp;&nbsp;';
			target += '<a href="' + full_file_path + '"target="_blank">' + bean['filename'] + '</a><br>';
		}
	}
	block.innerHTML = target;
}

ejo = new EmailJsonObj();
////	END EMAIL TEMPLATE CODE
///////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////
////	SIGNATURE CODE
function insertSignature(text) {
	if(typeof FCKeditor == undefined) {
	 	var oEditor = FCKeditorAPI.GetInstance('body_html') ;
	  	oEditor.InsertHtml(text);
	} else if (typeof html_editor != undefined) {
   		html_editor.focusEditor();
    
    	if(HTMLArea.is_ie) {
	        html_editor.insertHTML(text + " " );
	    } else {
    	    html_editor.insertNodeAtSelection(document.createTextNode(text + " "));
    	}
	}    
}
////	END SIGNATURE CODE
///////////////////////////////////////////////////////////////////////////////



function fill_form(type, error_text) {
	if(document.getElementById('subjectfield').value == '') {
		var sendAnyways = confirm(lbl_send_anyways);
		if(sendAnyways == false) { return false; }
	}

	if(type == 'out' && document.EditView.to_addrs.value  == '' &&
		document.EditView.cc_addrs.value  == '' &&
		document.EditView.bcc_addrs.value  == '') {
		
		alert(error_text);
		return false;
	}

	var the_form = document.EditView;
	var inputs = the_form.getElementsByTagName('input');
	
	//  this detects if browser needs the following hack or not..
	if(inputs.length > 0) {
		// no need to appendChild to EditView to get file uploads to work
		return check_form('EditView');
	}
	
	if(! check_form('EditView')) {
		return false;
	}
	return true;
}

function setLabels(uploads_arr) {
}



//this function appends the selected email address to the aggregated email address fields.
function set_current_parent(id,email,name,value) {
	current_contact_id.value += id+";";
	current_contact_email.value += email+";";
	current_contact_name.value += name+";";

	if(current_contact.value != '') {
		current_contact.value += "; ";
	}
	
	current_contact.value += name + " <" + email + ">";
//	current_contact.value += value;
}

function set_email_return(popup_reply_data) {
	var form_name = popup_reply_data.form_name;
	var name_to_value_array = popup_reply_data.name_to_value_array;
	for(var i in name_to_value_array) {
		for(var the_key in name_to_value_array[i]) {
			if(the_key == 'toJSON') {
				/* just ignore */
			} else {
				var displayValue = name_to_value_array[i][the_key];
				displayValue=displayValue.replace('&#039;',"'");  //restore escaped single quote.
				displayValue=displayValue.replace('&amp;',"&");  //restore escaped &.
				displayValue=displayValue.replace('&gt;',">");  //restore escaped >.
				displayValue=displayValue.replace('&lt;',"<");  //restore escaped <.
				displayValue=displayValue.replace('&quot; ',"\"");  //restore escaped ".
				
				window.document.forms[form_name].elements[the_key].value += displayValue + '; ';
			}
		}
	}
}

//create references to input fields associated with the select email address button. 
//Clicked button is passed as the parameter to the function. 
function button_change_onclick(obj) {
	var prefix = 'to_';
	if(obj.name.match(/^cc_/i)) {
	    prefix = 'cc_';
	} else if(obj.name.match(/^bcc_/i)) {
		prefix = 'bcc_';
	}
	
	for(var i = 0; i < obj.form.length;i++) {
		child = obj.form[i];
		if(child.name.indexOf(prefix) != 0) {
			continue;
		}

		if(child.name.match(/addrs_emails$/i)) {
			current_contact_email = child;
		} else if(child.name.match(/addrs_ids$/i)) {
			current_contact_id = child;
		} else if(child.name.match(/addrs_names$/i)) {
			current_contact_name = child;
		} else if(child.name.match(/addrs$/i)) {
			current_contact = child;
		}
	}

	var filter = '';
	var acct_name = '';
	
	if(document.EditView.parent_type.value  == 'Accounts' && typeof(document.EditView.parent_name.value) != 'undefined' && document.EditView.parent_name.value != '') {
		filter = "&form_submit=false&query=true&html=Email_picker&account_name=" + escape(document.EditView.parent_name.value);
		acct_name = document.EditView.parent_name.value;
	}

	var popup_request_data =
	{
		"call_back_function" : "set_email_return",
		"form_name" : "EditView",
		"field_to_name_array" :
		{
			"id" : prefix + "addrs_ids",
			"email1" : prefix + "addrs_emails",
			"name" : prefix + "addrs_names",
			"email_and_name1" : prefix + "addrs_field"
		}
	};

	return open_popup("Contacts", 600, 400, filter, true, false, popup_request_data, 'MultiSelect', false, 'popupdefsEmail');
}

//this function clear the value stored in the aggregated email address fields(nodes). 
//it relies on the references set by the button_change_onclick method
function clear_email_addresses() {
	
	if(current_contact != '') {
		current_contact.value = '';
	}
	if(current_contact_id != '') {
		current_contact_id.value = '';
	}
	if(current_contact_email != '') {
		current_contact_email.value = '';
	}
	if(current_contact_name != '') {
		current_contact_name.value = '';
	}
}

function quick_create_overlib(id, theme) {
    return overlib('<a style=\'width: 150px\' class=\'menuItem\' onmouseover=\'hiliteItem(this,"yes");\' onmouseout=\'unhiliteItem(this);\' href=\'index.php?module=Cases&action=EditView&inbound_email_id=' + id + '\'>' +
            "<img border='0' src='themes/" + theme + "/images/Cases.gif' style='margin-right:5px'>" + SUGAR.language.get('Emails', 'LBL_LIST_CASE') + '</a>' +
            "<a style='width: 150px' class='menuItem' onmouseover='hiliteItem(this,\"yes\");' onmouseout='unhiliteItem(this);' href='index.php?module=Leads&action=EditView&inbound_email_id=" + id + "'>" +
                    "<img border='0' src='themes/" + theme + "/images/Leads.gif' style='margin-right:5px'>"
                    + SUGAR.language.get('Emails', 'LBL_LIST_LEAD') + "</a>" +
             "<a style='width: 150px' class='menuItem' onmouseover='hiliteItem(this,\"yes\");' onmouseout='unhiliteItem(this);' href='index.php?module=Contacts&action=EditView&inbound_email_id=" + id + "'>" +
                    "<img border='0' src='themes/" + theme + "/images/Contacts.gif' style='margin-right:5px'>"
                    + SUGAR.language.get('Emails', 'LBL_LIST_CONTACT') + "</a>" +
             "<a style='width: 150px' class='menuItem' onmouseover='hiliteItem(this,\"yes\");' onmouseout='unhiliteItem(this);' href='index.php?module=Bugs&action=EditView&inbound_email_id=" + id + "'>"+
                    "<img border='0' src='themes/" + theme + "/images/Bugs.gif' style='margin-right:5px'>"            
                    + SUGAR.language.get('Emails', 'LBL_LIST_BUG') + "</a>" +
             "<a style='width: 150px' class='menuItem' onmouseover='hiliteItem(this,\"yes\");' onmouseout='unhiliteItem(this);' href='index.php?module=Tasks&action=EditView&inbound_email_id=" + id + "'>" +
                    "<img border='0' src='themes/" + theme + "/images/Tasks.gif' style='margin-right:5px'>"
                   + SUGAR.language.get('Emails', 'LBL_LIST_TASK') + "</a>"
            , CAPTION, SUGAR.language.get('Emails', 'LBL_QUICK_CREATE')
            , STICKY, MOUSEOFF, 3000, CLOSETEXT, '<img border=0 src="themes/' + theme + '/images/close_inline.gif">', WIDTH, 150, CLOSETITLE, SUGAR.language.get('app_strings', 'LBL_ADDITIONAL_DETAILS_CLOSE_TITLE'), CLOSECLICK, FGCLASS, 'olOptionsFgClass', 
            CGCLASS, 'olOptionsCgClass', BGCLASS, 'olBgClass', TEXTFONTCLASS, 'olFontClass', CAPTIONFONTCLASS, 'olOptionsCapFontClass', CLOSEFONTCLASS, 'olOptionsCloseFontClass');
}
