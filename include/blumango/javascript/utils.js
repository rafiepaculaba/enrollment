/**
 * filename: utils.js
 * 
 * descriptioin: This file containing utility functions
 * date created: 12/20/2007
 * created by: BluMango Dev Team
 */

/************************************ start utils.js ***********************************/

/**
 * function: $(id)
 * parameter: string html object id
 *
 * description: a shortcut, this is equivalent to document.getElementById()
 **/
function $(id)
{
    return document.getElementById(id);
}


/**
 * function: redirect(url)
 * parameter: string url
 *
 * description: this will redirect the page to the url specified
 **/
function redirect(url) 
{
    window.location=url;
}


/**
 * function: trim(s)
 * parameter: string s
 *
 * description: this will trim a string format
 **/
function trim(s) 
{
	if(typeof(s) == 'undefined')  
		return s;
	while (s.substring(0,1) == " ") {
		s = s.substring(1, s.length);
	}
	while (s.substring(s.length-1, s.length) == ' ') {
		s = s.substring(0,s.length-1);
	}

	return s;
}


/**
 * function: formatMoney()
 * parameter: string num
 * 
 * description: this will format the string to money format
 **/
function formatMoney(num) 
{
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
	   num = "0";
	   
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	
	if(cents<10)
	   cents = "0" + cents;
	   
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	   num = num.substring(0,num.length-(4*i+3)) + num.substring(num.length-(4*i+3));
	   
	return (((sign)?'':'-') + '' + num + '.' + cents);
}


/**
 * function: displayError()
 * parameter: string err
 * 
 * description: to display the error message instead of alert
 **/
function displayError(err) 
{
	document.getElementById("bigcontainer").className="errorbox";
	document.getElementById("bigcontainer").style.display="block";
	document.getElementById("bigcontainer").style.background="url(include/blumango/images/msg_error.gif) 5px center no-repeat";
	document.getElementById("msgcontainer").innerHTML="<font color='red'>"+err+"</font>";
	
	setTimeout("clearError()",5000);
}


/**
 * function: displayInfo()
 * parameter: string msg
 * 
 * description: to display the user message info instead of alert
 **/
function displayInfo(msg)
{
	document.getElementById("bigcontainer").className="confirmbox";
	document.getElementById("bigcontainer").style.display="block";
	document.getElementById("bigcontainer").style.background="url(include/blumango/images/msg_info.gif) 5px center no-repeat;";
	document.getElementById("msgcontainer").innerHTML="<font color='blue'>"+msg+"</font>";
	
	setTimeout("clearError()",5000);
}


/**
 * function: displayInfo()
 * parameter: string msg
 * 
 * description: to display the user message for successfully save/update
 **/
function displaySuccessful(msg)
{
	document.getElementById("bigcontainer").className="notificationbox";
	document.getElementById("bigcontainer").style.display="block";
	document.getElementById("bigcontainer").style.background="url(include/blumango/images/msg_check.gif) 5px center no-repeat;";
	document.getElementById("msgcontainer").innerHTML=msg;
	
	setTimeout("clearError()",5000);
}


/**
 * function: clearError()
 * parameter: none
 * 
 * description: this will clear the msgbox
 **/
function clearError() 
{
	document.getElementById("bigcontainer").style.display="none";
}


/**
 * function: validateLength()
 * parameter:   string obj
 *              number min
 *              number max
 *              string name_display
 *              boolean required
 *      
 * description: this will validate the charater length
 **/
function validateLength(obj, min, max, name_display, required) 
{
	msg='';
	if (required==false && (document.getElementById(obj).value=='') ) 
		return msg;  // meaning, need not to check	
		
	if ( (document.getElementById(obj).value.length < min) || (document.getElementById(obj).value.length > max) ) {
		// invalid length
		msg = 'Valid entries for '+name_display+' are between '+min+' and '+max+' characters.';
	}

	return msg;
}


/**
 * function: setDefaulDate()
 * parameter:   string fld
 *              string default_value
 *      
 * description: this will set the default value of the date obj
 **/
function setDetfaultDate(fld, blank, default_date) 
{
	$(fld).value= trim($(fld).value);
	
	if ($(fld).value) {
		if (!isDate($(fld).value))
			$(fld).value=default_date;
	} else {
		if (!blank)
			$(fld).value=default_date;
		else
			$(fld).value="";
	}
}


/**
 * function: addCommas()
 * parameter:   string nStr
 *      
 * description: this will add comma to the string format
 **/
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}


/**
 * function: encode()
 * parameter:   string Str
 *      
 * description: this will encode the unencoded string input
 **/
function encode(str) 
{
	var unencoded = str;
	return escape(unencoded);
}


/**
 * function: decode()
 * parameter:  string Str
 *      
 * description: this will decode the encoded string input
 **/
function decode(str) 
{
	var encoded = str;
	return unescape(encoded.replace(/\+/g,  " "));
}


/**
 * function: getFormElements()
 * parameter:  string obj (form id)
 *      
 * description: this will return all object under the form and its value as single string
 **/
function getFormElements(obj) 
{
  var poststr = "";
                
	for(i=0; i<$(obj).length; i++) {
		if (i==0)
			poststr = $(obj).elements[i].name + "=" + encode($(obj).elements[i].value);
		else
			poststr += "&" + $(obj).elements[i].name + "=" + encode($(obj).elements[i].value);
	}
	
  return poststr;
}


//Initialize combo box

/**
 * function: initializeCombo()
 * parameter:  string container (combo id)
 *      
 * description: this will Initialize combo box
 **/
function initializeCombo(container, default_text)
{
	var y=document.createElement('option');
	$(container).innerHTML = '';
	y.setAttribute('value','');
	y.text=default_text;
	var x=$(container);
	//x.add(y,null); // IE only  }
	if (navigator.appName=="Microsoft Internet Explorer") {
		x.add(y); // IE only  
	} else {
		x.add(y,null);
	}
	return;
}



function html_entity_decode(str) 
{
  var ta=document.createElement("textarea");
  ta.innerHTML=str.replace(/</g,"&lt;").replace(/>/g,"&gt;");
  return ta.value;
}

/************************************ end utils.js ***********************************/