<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link REL="SHORTCUT ICON" HREF="images/glint.ico">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>NeTFUSION QuickEnroll<?php //echo $title; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link title="color:sugar" type="text/css" rel="stylesheet" href="css/colors.sugar.css?s=4.5.1g&c=" />
<link title="color:blue" type="text/css" rel="alternate stylesheet" href="css/colors.blue.css?s=4.5.1g&c="/>
<link title="color:green" type="text/css" rel="alternate stylesheet" href="css/colors.green.css?s=4.5.1g&c="/>
<link title="color:purple" type="text/css" rel="alternate stylesheet" href="css/colors.purple.css?s=4.5.1g&c="/>
<link title="color:ocher" type="text/css" rel="alternate stylesheet" href="css/colors.ocher.css?s=4.5.1g&c="/>
<link type="text/css" rel="stylesheet" href="css/fonts.normal.css" />
<link type="text/css" rel="stylesheet" href="css/message.css" />

<script src="javascript/menu.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/validate.js" type="text/javascript"></script>
<script src="javascript/cpd.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/style.js?s=4.5.1g&c=" type="text/javascript"></script>
<script src="javascript/cookie.js" type="text/javascript"></script>
<script src="javascript/jquery-1.2.6.js" type="text/javascript"></script>
<script src="javascript/validate.js" type="text/javascript"></script>
<!--<script src="javascript/json.js" type="text/javascript"></script>-->
<script language="javascript">
// set base url
var base_url = <?php echo "'".base_url()."';"; ?>

// set from cookie
SUGAR.themes.changeColor(Get_Cookie('Sugar_color_style'));
</script>
</head>

<body>
<!--start of header-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="headerBg">
    	  <tbody>
	      <tr>
	        <td rowspan="2" class="logo" width="70%"><img border="0" src="images/quickenroll_logo.gif"/></td>
	        <td>
				<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
			        <td class="welcome" width="80%" nowrap="nowrap" style="border-left: 1px solid rgb(221,221,221);" valign="top">Welcome <?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?></td>
			        <td class="myArea" nowrap="nowrap" style="padding-right: 8px;">
			        	<!--start of globals-->
						<ul class="subTabs">
						<li><a href="index.php?information">My Account</a></li>
<!--						<li><a href="index.php?admin">Admin</a></li>-->
						<li><a href="index.php?login">Logout</a></li>
						<li><a href="index.php?about">About</a></li>
						</ul>
						<!--end of globals-->
					</td>
					<td id="colorpicker" class="welcome" nowrap="nowrap">
						<ul class="colorpicker">
						<li onclick="SUGAR.themes.changeColor('sugar');"><img border="0" style="margin: 0pt 3px;" alt="sugar" src="images/colors.sugar.icon.gif"/></li>
						<li onclick="SUGAR.themes.changeColor('blue');"><img border="0" style="margin: 0pt 3px;" alt="blue" src="images/colors.blue.icon.gif"/></li>
						<li onclick="SUGAR.themes.changeColor('green');"><img border="0" style="margin: 0pt 3px;" alt="green" src="images/colors.green.icon.gif"/></li>
						<li onclick="SUGAR.themes.changeColor('ocher');"><img border="0" style="margin: 0pt 3px;" alt="ocher" src="images/colors.ocher.icon.gif"/></li>
						</ul>
					</td>
			    </tr>
			    </tbody>
			    </table>
			</td>
	      </tr>
	      <tr>
	        <td valign="top" nowrap="" align="right" style="padding: 15px 10px 5px; font-size: 12px;" colspan="2">
	        <br>
	        </td>
	      </tr>
	      </tbody>
	    </table>
    </td>
  </tr>
  <tr>
    <td>
    	<!--start of tabs-->
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td class="otherTabRight" style="padding-left: 14px;">&nbsp;</td>
				<?php
				if (is_array($modules)) {
					foreach($modules as $key=>$module) {
						echo '
							<td>
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody>
								<tr>';
						if ($this->uri->segment(1)==$key) {
							echo '	
									<td class="currentTabLeft"><img width="5" height="25" border="0" src="images/blank.gif"/></td>
									<td class="currentTab" nowrap="nowrap"><a class="currentTabLink" href="index.php?' .$key. '">' .$module. '</a></td>
									<td class="currentTabRight"><img width="5" height="25" border="0" src="images/blank.gif"/></td>';
						} else {
							echo '	
									<td class="otherTabLeft"><img width="5" height="25" border="0" src="images/blank.gif"/></td>
									<td class="otherTab" nowrap="nowrap"><a class="otherTabLink" href="index.php?' .$key. '">' .$module. '</a></td>
									<td class="otherTabRight"><img width="5" height="25" border="0" src="images/blank.gif"/></td>';
						}
						echo '
								</tr>
								</tbody>
								</table>
							</td>';
					}
				}
				?>
				<td class="tabRow" width="100%">
					<img width="1" height="1" border="0" src="../images/blank.gif" alt=""/>
				</td>
			</tr>
			<tr>
				<td id="subtabs" colspan="20" style="padding-left: 14px;"></td>
			</tr>
		</tbody>
		</table>
		<!--end of tabs-->
	</td>
  </tr>
  <tr>
    <td height="7"></td>
  </tr>
</table>
<!--end of header-->


<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<!--start of shortcut menu-->
		<td valign="top" style="width: 8px;">
			<img id="HideHandle" style="cursor: pointer;" name="HideHandle" src="images/hide.gif" alt="" onclick="hideLeftCol('leftCol');closeMenus();" onmouseover="showSubMenu('leftCol')"/>
		</td>
		<td id="left" class="leftColumn" valign="top" style="width: 160px;">
			<div id="leftCol" style="display: inline;">
			<table width="160" cellspacing="0" cellpadding="0" border="0">
			<tbody>
			<tr>
				<td>
					<table class="leftColumnModuleHead" width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<th class="leftColumnModuleName" width="100%">Shortcuts</th>
						</tr>
					</tbody>
					</table>
					<div id="div_shortcuts">
						<ul id="subMenu" class="subMenu">
						<?php
						if (is_array($menu)) {
							$ctr=0;
							foreach ($menu as $shortcut) {
								echo '<li id="'.$ctr.'_lv"><a href="' .$shortcut['url']. '"><img width="16" height="16" border="0" align="absmiddle" alt="' .$shortcut['name']. '" src="images/' .$shortcut['image']. '.gif"/>&nbsp;' .$shortcut['name']. '</a></li>';
								$ctr++;
							}
						}
						
						?>
						</ul>
					</div>
				</td>
			</tr>
			</tbody>
			</table>
			</div>
		</td>
		<!--end of shortcut menu-->
		
		<!--start of body-->
		<td width="100%" style="padding-right: 10px; padding-left: 8px; vertical-align: top; padding-bottom: 5px;">