<?php
###########################################################################
#                                                                         #
#  SolusVMController                                                      #
#                                                                         #
#  Copyright (C) 2012 SolusVMController                                   #
#                                                                         #
#  This program is free software: you can redistribute it and/or modify   #
#  it under the terms of the GNU General Public License as published by   #
#  the Free Software Foundation, either version 3 of the License, or      #
#  (at your option) any later version.                                    #
#                                                                         #
#  This program is distributed in the hope that it will be useful,        #
#  but WITHOUT ANY WARRANTY; without even the implied warranty of         #
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          #
#  GNU General Public License for more details.                           #
#                                                                         #
#  You should have received a copy of the GNU General Public License      #
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.  #
#                                                                         #
###########################################################################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta name="robots" content="all">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php if(isset($metaRedirect)) echo '<meta http-equiv="refresh" content="2;url=' . $metaRedirect . '">';  ?>
	<title><?php echo (isset($title) ? $title : ''); ?> | SolusVMController <?php echo SVMC_VERSION; ?></title>
	<link href="includes/css/style.css" rel="stylesheet" type="text/css" />
	<script language="javascript" src="includes/js/jquery.js"></script>

	<?php
	if(isset($css) && is_array($css)) foreach($css as $c) echo '<link href="' . $c . '" rel="stylesheet" type="text/css" media="screen" />' . "\n";
	if(isset($js) && is_array($js)) foreach($js as $j) echo '<script src="' . $j . '" type="text/javascript"></script>' . "\n";

	if(isset($styles)){
		echo '
	<style type="text/css">
	<!--
	' . $styles . '
	//-->
	</style>';
	}

	if(isset($scripts)){
		echo '
	<script language="javascript">
	<!--
	' . $scripts . '
	//-->
	</script>
		';
	}
	?>
<head>

<body>
	<?php
	if(isset($_SESSION['admin_id']) && isset($_SESSION['user_id']) && $_SESSION['admin_id'] != $_SESSION['user_id']){
		echo '
		<div class="user-access">
			' . LOGGED_IN_AS . ' <b>' . $_SESSION['name'] . '</b>
			<input class="button" type="button" value="' . REVOKE_ACCESS . '" onclick="window.location.href=\'?q=access&action=revoke\';" />
		</div>';
	}
	?>
	<div id="wrap">
		<div id="header">
			<span id="slogan"> <?php echo ALL_VMS_UNDER_ONE_ROOF; ?></span>
			<ul>
			<?php if($showMenu){
				if(!isset($_SESSION['user_id'])){
					echo '
					<li' . ($q == 'log-in' ? ' id="current"' : '') . '><a href="?q=log-in"><span>' . LOG_IN . '</span></a></li>';
				}

				if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == $_SESSION['user_id']){
					echo '
					<li' . ($q == 'user' ? ' id="current"' : '') . '><a href="?q=user"><span>' . USER . '</span></a></li>';
				}

				if(isset($_SESSION['user_id'])){
					echo '
					<li' . ($q == 'vm' ? ' id="current"' : '') . '><a href="?q=vm"><span>' . VM . '</span></a></li>
					<li' . ($q == 'tag' ? ' id="current"' : '') . '><a href="?q=tag"><span>' . TAG . '</span></a></li>
					<li' . ($q == 'settings' ? ' id="current"' : '') . '><a href="?q=settings"><span>' . SETTINGS . '</span></a></li>';
				}

				echo '<li' . ($q == 'help' ? ' id="current"' : '') . '><a href="?q=help"><span>' . HELP . '</span></a></li>
				<li' . ($q == 'about' ? ' id="current"' : '') . '><a href="?q=about"><span>' . ABOUT . '</span></a></li>';
			}
			?>
			</ul>
		</div>

		<div id="header-logo">
			<div id="logo"><a href="?q=vm"><img src="images/svmcontroller_logo.png" width="85" height="85" border="0" /></a></div>
			<div id="title">SolusVM<span class="red">Controller</span><span style="font-size:10px;color:#666666;"><?php echo ((defined('SVMC_VERSION')) ? SVMC_VERSION : $version); ?></span></div>
			<?php if(isset($_SESSION['name'])) echo '<div style="float:right;margin-top:10px;">' . WELCOME . ', ' . $_SESSION['name'] . '! | <a href="?q=log-out">' . LOG_OUT . '</a></div>'; ?>
		</div>