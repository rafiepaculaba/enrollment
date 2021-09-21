/**
 * filename: validate.js
 * 
 * descriptioin: This file containing functions for validating client side
 * date created: 12/20/2007
 * created by: BluMango Dev Team
 */

/************************************ start validate.js ***********************************/

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
 * function: limitLength()
 * parameter: event e
 *            string object  
 *            number lex_max
 *
 * description: this will limit the number of charaters to be input in the textbox/textarea
 **/
function limitLength(e, obj,len_max) 
{
	var keynum
	var keychar
	var numcheck
	
	if ( keyRestrict(e, 7) ) {
		if (document.getElementById(obj).value.length >= len_max) {
			if (navigator.appName=="Microsoft Internet Explorer") 
				keynum = e.keycode;
			else
				keynum = e.which;
				
			if (keynum==0 || keynum==8 || keynum==13)
				return true;
			return false;
		}
		
		return true;
	} else
		return false;
	
}


/**
 * function: acceptFloatOnly()
 * parameter: event e
 *
 * description: this will limit type of charaters to be input in the textbox/textarea - float combo characters
 **/
function acceptFloatOnly(e)  
{
   	var key;
	var keychar;
	var reg;
	
	if(window.event) {
    	// for IE, e.keyCode or window.event.keyCode can be
    	used
    	key = e.keyCode;
	}
	else if(e.which) {
    	// netscape
    	key = e.which;
	}
	
	if (key ==0 || key ==8 || key ==13) {
		return true;
	}
	
	keychar = String.fromCharCode(key);
	reg = /[0-9.\-]/ ;
	
	return reg.test(keychar);
}


/**
 * function: getKeyCode()
 * parameter: event e
 *
 * description: this will get the keycode of the input
 **/
function getKeyCode(e)
{
    if (window.event)
        return window.event.keyCode;
    else if (e)
        return e.which;
    else
        return null;
}


/**
 * function: keyRestrict()
 * parameter: event e
 *            number validchars_code
 *
 * description: this will other keys outside the selected valid chars
 **/
function keyRestrict(e, validchars_code) 
{
    var strCheckOK = new Array();
    strCheckOK[0] = "0123456789"; // numbers only
    strCheckOK[1] = "0123456789."; // positive numbers only
    strCheckOK[2] = "0123456789.-"; // for float with negative
    strCheckOK[3] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz "+ String.fromCharCode(241); // alpha only
    strCheckOK[4] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz&(),:;.-'/\"\\ "+ String.fromCharCode(241); // alpha with basic esp char only
    strCheckOK[5] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789 "+ String.fromCharCode(241);	// alpha num only
    strCheckOK[6] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&,:;.-#/'\"\\ "+ String.fromCharCode(241);	// alpha num with basic esp char only
    strCheckOK[7] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_&,:;-./!@#$%^*()?'\"\\ "+ String.fromCharCode(241); // with special chars	
    strCheckOK[8] = "0123456789/"; // for dates
    strCheckOK[9] = "0123456789-/ "; // mobile phone
    strCheckOK[10] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#*-/ "+ String.fromCharCode(241); // fax/telephone phone
    strCheckOK[11] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_@."; // email address
    strCheckOK[12] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.- "+ String.fromCharCode(241); // name of a person
    strCheckOK[13] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&,:;.-#/'\"\\ ";	// alpha num with basic esp char only
    strCheckOK[14] = "0123456789-/"; // id numbers
    strCheckOK[15] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&,:;.-#/'\"\\ ()"+ String.fromCharCode(241);	// for descriptive title
    strCheckOK[16] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.";	// for grades ex. 1.5, NC, DR
    strCheckOK[17] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789. ";	// for grades ex. 1.5, NC, DR
    
    var key='', keychar='';
    
    key = getKeyCode(e);
       
    if (validchars_code==-1) {
    	if (key>0) return false;
    	else	   return true;
    }
    if (key == null) return true;

    if (key==13) return false;
        
       
    keychar = String.fromCharCode(key);
    keychar = keychar.toLowerCase();
    validchars = strCheckOK[validchars_code];
     
    validchars=validchars.toLowerCase();
    
    if (validchars.indexOf(keychar) != -1)
    	return true;
    if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
    	return true;
    
    return false;
}


/**
 * function: keyRestrict()
 * parameter: event e
 *            number validchars_code
 *
 * description: this will other keys outside the selected valid chars
 **/
function keyRestrict2(e, validchars_code,callBackFunction) 
{
    key = getKeyCode(e);
    // check for callback function
    if (key==13) {
        if (keyRestrict(e, validchars_code)) {
        
        } else {
            
        }
        
        callBackFunction += "()";
        
        eval(callBackFunction);
        
        return false;
    } else {
        return keyRestrict(e, validchars_code);
    }
    
    
}

/**
 * function: isFloatValue()
 * parameter: string
 *
 * description: this will evaluate if the parameter is float type
 **/
function isFloatValue(str) 
{
    ctr=0;
	for(i=0;i<str.length;i++) {
		
		//if (str.charCodeAt(i)==".") {
		if (str[i]=='.') {
			ctr++;
		}
	}
	
	if (ctr>1) {
	    return false;
	} else {
		return true;	
	}
}


/**
 * function: initializeCombo()
 * parameter:  string container (combo id)
 *      
 * description: this will Initialize combo box
 **/
function initializeCombo(container, default_text)
{
	var y=document.createElement('option');
	document.getElementById(container).innerHTML = '';
	y.setAttribute('value','');
	y.text=default_text;
	var x=document.getElementById(container);
	//x.add(y,null); // IE only  }
	if (navigator.appName=="Microsoft Internet Explorer") {
		x.add(y); // IE only  
	} else {
		x.add(y,null);
	}
	return;
}

function check_keyrestrict_1(event)
{
    return keyRestrict(event,1);
}

function check_keyrestrict_3(event)
{
    return keyRestrict(event,3);
}

function check_keyrestrict_5(event)
{
    return keyRestrict(event,5);
}

function check_keyrestrict_6(event)
{
    return keyRestrict(event,6);
}

function check_keyrestrict_7(event)
{
    return keyRestrict(event,7);
}

function check_keyrestrict_8(event)
{
    return keyRestrict(event,8);
}

function check_keyrestrict_9(event)
{
    return keyRestrict(event,9);
}

function check_keyrestrict_10(event)
{
    return keyRestrict(event,10);
}

function check_keyrestrict_11(event)
{
    return keyRestrict(event,11);
}

function check_keyrestrict_12(event)
{
    return keyRestrict(event,12);
}

function check_keyrestrict_13(event)
{
    return keyRestrict(event,13);
}

function check_keyrestrict_14(event)
{
    return keyRestrict(event,14);
}

function check_keyrestrict_15(event)
{
    return keyRestrict(event,15);
}

function check_keyrestrict_16(event)
{
    return keyRestrict(event,16);
}

function check_keyrestrict_17(event)
{
    return keyRestrict(event,17);
}

function check_keyrestrict_18(event)
{
    return keyRestrict(event,18);
}
/************************************ end validate.js ***********************************/
