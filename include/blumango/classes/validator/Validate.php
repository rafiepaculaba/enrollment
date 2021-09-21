<?php
/**
 * class: Validator
 * 
 * descriptioin: This class is for validiting inputs in comformance level.
 * date created: 12/20/2007
 * created by: BluMango Dev Team
 */

class Validate
{
	
	/*****************************************************************
	FunctionName	:isEmail
	Input			: String
	OutPut			: True/ False
	Description 	: Returns false if invalid mail-id, else true
	******************************************************************/
	function isEmail($sEMail)
	{
		$nLen=strlen(trim($sEMail));
		
		if($nLen==0)
			return FALSE;

		$sFirstChr=$sEMail{0};
		$sLastChr=$sEMail{$nLen-1};
		/***** email id should not start or end with @,.,- ***/
		if(is_integer(strpos("@.-",$sFirstChr)) || is_integer(strpos("@.-",$sLastChr)))
		{
			return FALSE;
		}

		/***** email id should not start or end with number ***/
		if (is_integer($sFirstChr) || is_integer($sLastChr))
		{
			return FALSE;
		}

		/**** check for 2 '..','--','__','@@'in mail Id ***/
		if((is_integer(strpos(trim($sEMail),".."))) || (is_integer(strpos(trim($sEMail),"--"))) || (is_integer(strpos(trim($sEMail),"__"))) || (is_integer(strpos(trim($sEMail),"@@"))))
		{
			return FALSE;
		}
		
		$sValidChar="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.-_@";

		for ($n=0;$n<strlen($sEMail);$n++)
		{
			$sCharToCheck="";
			/***** Check for valid caharacters *******/
			if (!is_integer(strpos($sValidChar,$sEMail[$n])))
			{
				return FALSE;
			}
			
			/***** Check if more than 1 @ are there *******/
			if (substr_count(trim($sEMail),"@")!=1)
			{
				return FALSE;
			}

			/***** Check if more atleast 1 . *******/
			if (substr_count(trim($sEMail),".")==0)
			{
				return FALSE;
			}

			/***** Check if any of the follow. string is there *******/
			$sCharToCheck=$sPrevChar.trim($sEMail[$n]);
			switch($sCharToCheck) {
				case '.@' :
				case '@.' :
				case '-@' :
				case '@-' :
				case '_@' :
				case '@_' :
						return FALSE;
						break;
			}

			$sPrevChar=trim($sEMail[$n]);
		}

		return TRUE;
	}

	/*****************************************************************
	FunctionName :isDate
	Input :Date String (MM/DD/YYYY format)
	OutPut :error/1
	Description :If Valid date returns 1 else error
	******************************************************************/
	function isDate($sDate)
	{
	     if (trim($sDate)=="")
		 {
	         return FALSE;
		 }

	     $sDate = split ('[/.-]', $sDate);

		 // if (!checkdate($sDate[1],$sDate[2],$sDate[0]))
	     if (!checkdate($sDate[0],$sDate[1],$sDate[2]))
		 {
	         return FALSE;
		 }
	     else
		 {
	         return TRUE;
		 }
	}

	
	/*****************************************************************************************
	FunctionName  : isAlphaNum
	Input         : String 
	OutPut        : Returns True If string is Alphanumeric and False not Alphanumeric
	Explanation   : Used to check whether the input string is Alphanumeric or not
	*****************************************************************************************/
	function isAlphaNum($sStr,$strCode=2) 
	{ 
		$strcheckOK[0] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.'; // alpha only
		$strcheckOK[1] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.-";	// alpha num only
		$strcheckOK[2] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789,.-/!@#$%^&*()?\'"'; // with special chars
		
		$checkOK=$strcheckOK[$strCode];
		
		$checkStr = $sStr;
		$allValid = TRUE;
		for ($i = 0;  $i < strlen($checkStr);  $i++)
		{
			$ch = $checkStr[$i];
			for ($j = 0;  $j < strlen($checkOK);  $j++) {
				if ($ch == $checkOK[$j] || $ch == ' ' || ( 241==ord($ch) ) || ( 209==ord($ch) ) )
				break;
			}
				
			if ($j == strlen($checkOK) ) {
				$allValid = FALSE;
				break;
			}
			
		}
		
		return $allValid;
			
	}

	/*****************************************************************************************
	FunctionName  : isNum
	Input         : String 
	OutPut        : Returns True If string is numeric and False not numeric
	Explanation   : Used to check whether the input string is numeric or not
	*****************************************************************************************/
	function isNum($sStr) 
	{ 
		
		if(ereg("^[[:digit:]]+$", $sStr))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	/*****************************************************************************************
	FunctionName  : isFloat
	Input         : String 
	OutPut        : Returns True If string is float and False not float
	Explanation   : Used to check whether the input string is float or not
	*****************************************************************************************/
	function isFloat($value) {
		
		if(ereg("^[-+]?[0-9]+(\.[0-9]+)?$", $value))
		{
			return TRUE;
		}
		else
		{
			
			return FALSE;
		}
	}


	/*****************************************************************************************
	FunctionName  : getLength
	Input         : String 
	OutPut        : Returns length of the string passsed to this function
	Explanation   : Used to calcualte length of the string
	*****************************************************************************************/
	function getLength($str)
	{
		$len = 0;
		for ($i=0;$i<strlen($str);$i++)
		{
			if (substr($str,$i,1) <= 255 )
			{
			    $len += 1;
			}
			else
			{
				$len += 2;
			}
		}
		return $len;
	}
	
	/*****************************************************************************************
	FunctionName  : check_data
	OutPut        : Returns error msg if finds an error.
	Explanation   : Used to check individual input
	*****************************************************************************************/
	function check_data($value, $type='', $data_name='Data',$strCode=2) {
		$value = trim($value);
		
		$errmsg="";
		switch ( strtolower($type) ) {
		case 'email':
			if ( !$this->isEmail($value) )
				$errmsg = "<br>$data_name is invalid!";
			break;
		case 'date':
			if ( !$this->isDate($value) )
				$errmsg = "<br>$data_name is invalid!";
			break;
		case 'numeric':
			if ( !$this->isNum($value) )
				$errmsg = "<br>$data_name is invalid!";
			break;
		case 'float':
			if ( !$this->isFloat($value) )
				$errmsg = "<br>$data_name is invalid!";
			break;
		case 'alphanumeric':
			if ( !$this->isAlphaNum($value,$strCode) )
				$errmsg = "<br>$data_name is invalid!";
			break;	
		default:
			if ( !$this->isAlphaNum($value,$strCode) )
				$errmsg = "<br>$data_name is invalid! - $value";
		}
		
		return $errmsg;
	}
}


?>