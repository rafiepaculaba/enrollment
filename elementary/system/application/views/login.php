<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link REL="SHORTCUT ICON" HREF="images/glint.ico">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>NeTFUSION QuickEnroll<?php //echo $title; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link title="color:sugar" type="text/css" rel="stylesheet" href="css/colors.sugar.css?s=4.5.1g&c=" />
<link title="color:blue" type="text/css" rel="alternate stylesheet" href="css/colors.blue.css?s=4.5.1g&c="/>
<link title="color:green" type="text/css" rel="alternate stylesheet" href="css/colors.green.css?s=4.5.1g&c="/>
<link title="color:purple" type="text/css" rel="alternate stylesheet" href="css/colors.purple.css?s=4.5.1g&c="/>
<link title="color:ocher" type="text/css" rel="alternate stylesheet" href="css/colors.ocher.css?s=4.5.1g&c="/>
<link type="text/css" rel="stylesheet" href="css/fonts.normal.css" />
<!--
<script src="javascript/menu.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/sugar_3.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/style.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/cookie.js" type="text/javascript"></script>
<script language="javascript">

// set from cookie
SUGAR.themes.changeColor(Get_Cookie('Sugar_color_style'));

</script>-->
</head>

<body>

<!--start of header-->
<table width="800" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
<div style="width:800px;">
	<div style="float: left;width: 800px;height: 69px;background-image:url(../themes/Sugar/Login_images/quickenroll-login_01.jpg);"></div>
	<div style="float: left;width: 800px;height: 340px;background-image:url(../themes/Sugar/Login_images/quickenroll-login_022.jpg);"></div>	
	<div style="float: left;width: 88px;height: 158px;background-image:url(../themes/Sugar/Login_images/quickenroll-login_03.jpg);"></div>
	<div style="float: left;width: 205px;height: 158px;background-image:url(../themes/Sugar/Login_images/quickenroll-login_04.jpg);">
	<!--Start of Login Form-->	  	  
	  
	 	<form method="POST"	action="index.php?login/authenticate">
	    <table width="90%" cellpadding="0" align="center">
          <tr>
            <td colspan="2" style="height: 5px;"></td>
          </tr>
          <tr>
            <td colspan="2"><div align="center"><span class="style4">Please enter your username and password.</span></div></td>
          </tr>
          <tr>
            <td colspan="2"><span id="post_error" class="error"/><?php if($error){ echo $error; } ?></span></td>
            <td>          
          </tr>
          <tr>
            <td width="44%"><span class="style11">User Name</span></td>
          	<td width="56%"><input name="uname" type="text" id="uname" maxlength="20" tabindex="1" value="" /></td>
          </tr>
          <tr>
            <td width="44%"><span class="style11">Password</span></td>
          	<td width="56%"><input name="pswd" type="password" id="pswd" maxlength="20" tabindex="2" value=""/></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
				
            <td><input title="Login [Alt+L]" accessKey="Login [Alt+L]" id="login_button" class="button" type="submit" value=" Login " name="Login" tabindex="3" /></td>
          </tr>
        </table>
        </form>
	<!--End of login form-->
		</div>
		<div style="float: left;width: 507px;height: 158px;background-image:url(../themes/Sugar/Login_images/quickenroll-login_05.jpg);"></div>
		<div style="float: left;width: 800px;height: 33px;background-image:url(../themes/Sugar/Login_images/quickenroll-login_06.jpg);">
		<div style="font-family: Arial, Helvetica, sans-serif;font-size:11px;color:#FFFFFF;float:left;margin-left:240px;margin-top:8px;"><a href="http://www.blumango.com" target="_blank"><font color="#FFFFFF">BluMango Technologies Inc.</font></a> &copy; 2005-2008 All Rights Reserved.</div>
	
		</div>
	</div>
	    </td>
	  </tr>
	</table>
</td>
</tr>
	<!--
<tr>    
	<td colspan="3" align="center"><center><span class="style4"><a href="http://www.emssinc.com" target="_blank">BluMango Technologies Inc.</a> &copy; 2005-2008 All Rights Reserved.</span></center><br /></td>
</tr>-->
</table>

</body>
</html>
<!--end of footer file-->