
/**
 * filename:  ajax.js
 * 
 * descriptioin: This file contains the functions to create/manipulate xmlHttp object
 * date created: 12/20/2007
 * created by: BluMango Dev Team
 */

/************************************ start ajax.js ***********************************/

// xmlHttp object
var xmlHttp;

// temp variable to contain the container object
var container;


/**
* function: NewXMlHttpObject()
* description: instantiate a xmlHttp object
**/
function NewXmlHttpObject()
{
    xmlHttp = null;
    
    if (typeof XMLHttpRequest != "undefined") {
        xmlHttp = new XMLHttpRequest();
    }
    
    if (!xmlHttp && typeof ActiveXObject != "undefined"){
        try	{
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e){
            try{
                xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e2){
                try {
                    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP.4.0");
                } catch (e3){
                    xmlHttp=null;
                }
            }
        }
    }
    
    if(!xmlHttp && window.createRequest) {
        xmlHttp = window.createRequest();
    }
    
    return xmlHttp;
}

/**
* function: ajaxQuery()
* description: instantiate a xmlHttp object
* parameters: 
*   url - url of the action
*   method - method of the process
*   passValue - var=value conbination
*   ident - html object that will holds the result
*   handle - function that will process the result
**/
function ajaxQuery(url,method,passValue,ident,handle) 
{
    var contentType = "application/x-www-form-urlencoded; charset=UTF-8";
    
    xmlHttp     = NewXmlHttpObject();
    container   = ident
    
    if (xmlHttp==null){
        alert ("Browser does not support HTTP Request");
        return;
    }
    
    eval("xmlHttp.onreadystatechange="+handle);
    
    if (method.toUpperCase()=="POST") {
        xmlHttp.open(method,url,true);
        xmlHttp.setRequestHeader("Content-Type", contentType);
        xmlHttp.setRequestHeader("Content-length", passValue.length);
        xmlHttp.send(passValue);
    } else {
        url+="?sid="+Math.random();
        url+=passValue?"&"+passValue:"";
        xmlHttp.open(method,url,true);
        xmlHttp.send(null);
    }
}

/************************************ end ajax.js ***********************************/