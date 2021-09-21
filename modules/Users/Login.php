<html>
<head>
<title>login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$theme_path="themes/".$theme."/";
require_once($theme_path.'layout_utils.php');

global $app_language, $sugar_config;
//we don't want the parent module's string file, but rather the string file specifc to this subpanel
global $current_language;
$current_module_strings = return_module_language($current_language, 'Users');
require_once('modules/Administration/updater_utils.php');

// Retrieve username and password from the session if possible.
if(isset($_SESSION["login_user_name"])) {
	if (isset($_REQUEST['default_user_name']))
		$login_user_name = $_REQUEST['default_user_name'];
	else
		$login_user_name = $_SESSION['login_user_name'];
} else {
	if(isset($_REQUEST['default_user_name'])) {
		$login_user_name = $_REQUEST['default_user_name'];
	} elseif(isset($_REQUEST['ck_login_id_20'])) {
		$login_user_name = get_user_name($_REQUEST['ck_login_id_20']);
	} else {
		$login_user_name = $sugar_config['default_user_name'];
	}
	$_SESSION['login_user_name'] = $login_user_name;
}

$current_module_strings['VLD_ERROR'] = $GLOBALS['app_strings']["\x4c\x4f\x47\x49\x4e\x5f\x4c\x4f\x47\x4f\x5f\x45\x52\x52\x4f\x52"];

// Retrieve username and password from the session if possible.
if(isset($_SESSION["login_password"])) {
	$login_password = $_SESSION['login_password'];
} else {
	$login_password = $sugar_config['default_password'];
	$_SESSION['login_password'] = $login_password;
}

if(isset($_SESSION["login_error"])) {
	$login_error = $_SESSION['login_error'];
}

//echo get_module_title($current_module_strings['LBL_MODULE_NAME'], $current_module_strings['LBL_LOGIN'], false);
?>
<script type="text/javascript" language="JavaScript">
<!-- Begin
function set_focus() {
	if (document.DetailView.user_name.value != '') {
		document.DetailView.user_password.focus();
		document.DetailView.user_password.select();
	}
	else document.DetailView.user_name.focus();
}

function toggleDisplay(id){

	if(this.document.getElementById(id).style.display=='none'){
		this.document.getElementById(id).style.display='inline'
		if(this.document.getElementById(id+"link") != undefined){
			this.document.getElementById(id+"link").style.display='none';
		}
	document['options'].src = '<?php echo $theme_path ?>images/basic_search.gif';		
	}else{
		this.document.getElementById(id).style.display='none'
		if(this.document.getElementById(id+"link") != undefined){
			this.document.getElementById(id+"link").style.display='inline';
		}
	document['options'].src = '<?php echo $theme_path ?>images/advanced_search.gif';	
	}
}
		//  End -->
	</script>
	
	<style type="text/css">
<!--
.style4 {font-size: 12px}
.style9 {font-size: 11px; color: #FF0000; }
-->
</style>
	
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="800" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
<div class="login_container">
	<div class="school_name"></div>
	<?php 
	$ctr = rand(1,100);
	
	if ($ctr%2==0)  {
		echo '<div class="banner"></div>';
	} else {
		echo '<div class="banner_local"></div>';
	}
	?>
	<div class="spacer"></div>
	<div class="login_bg">
	<!--Start of Login Form-->	  	  
	  
	 <form  action="index.php" method="post" name="DetailView" id="form" onSubmit="return document.getElementById('cant_login').value == ''">
	    <table width="90%" cellpadding="0" align="center">
          <tr>
            <td colspan="2" class="login_table"></td>
          </tr>
          <tr>
            <td colspan="2"><div align="center"><span class="style4"><?php echo $app_strings['NTC_LOGIN_MESSAGE']; ?></span></div></td>
          </tr>

<input type="hidden" name="module" value="Users">
			<input type="hidden" name="action" value="Authenticate">
			<input type="hidden" name="return_module" value="Users">
			<input type="hidden" name="return_action" value="Login">
			<input type="hidden" id="cant_login" name="cant_login" value="">
			<input type="hidden" name="login_module" value="<?php if (isset($_GET['login_module'])) echo $_GET['login_module']; ?>">
			<input type="hidden" name="login_action" value="<?php if (isset($_GET['login_action'])) echo $_GET['login_action']; ?>">
			<input type="hidden" name="login_record" value="<?php if (isset($_GET['login_record'])) echo $_GET['login_record']; ?>">
<?php

if(isset($login_error) && $login_error != "") {
?>		  
		  
		  
		  
		  
          <tr>
            <td colspan="2"><div align="center" class="style9"><?php echo $current_module_strings['LBL_ERROR'].": ".$login_error ?></div></td>
          </tr>
		  
<?php
} else {
?>
		  
          <tr>
            <td>&nbsp;</td>
            <td>          
          </tr>
          <tr>

<?php
} // end if(isset($login_error) ....

if (isset($_REQUEST['ck_login_language_20'])) {
	$display_language = $_REQUEST['ck_login_language_20'];
} else {
	$display_language = $sugar_config['default_language'];
}

if (isset($_REQUEST['ck_login_theme_20'])) {
	$display_theme = $_REQUEST['ck_login_theme_20'];
} else {
	$display_theme = $sugar_config['default_theme'];
}
?>		  
		  
            <td width="44%"><span class="style11"><?php echo $current_module_strings['LBL_USER_NAME'] ?></span></td>
          <td width="56%"><input name="user_name" type="text" id="user_name" size="10" maxlength="20" value=<?php echo "\"$login_user_name\"/>"; if (!empty($sugar_config['default_user_name'])) echo " ({$sugar_config['default_user_name']})"; ?></td>          </tr>
          <tr>
            <td><span class="style11"><?php echo $current_module_strings['LBL_PASSWORD'] ?></span></td>
          <td><input name="user_password" type="password" id="user_password" size="10" maxlength="20" value=<?php echo "\"$login_password\"/>"; if (!empty($sugar_config['default_password'])) echo " ({$sugar_config['default_password']})"; ?></td>          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input title="<?php echo $current_module_strings['LBL_LOGIN_BUTTON_TITLE'] ?>" accessKey="<?php echo $current_module_strings['LBL_LOGIN_BUTTON_TITLE'] ?>" class="button" type="submit" id="login_button" name="Login" tabindex="3" value="  <?php echo $current_module_strings['LBL_LOGIN_BUTTON_LABEL'] ?>  "></td>
          </tr>
        </table>
        </form>
<!--End of login form-->
	</div>
	<div class="netfusion"></div>
	<div class="login_footer">
		<div class="netfusion_copyrights"><a href="http://www.blumango.com" target="_blank">BluMango Technologies Inc.</a> &copy; 2005-2008 All Rights Reserved.</div>
	</div>
</div>
    </td>
  </tr>
</table>
</body>
</html>