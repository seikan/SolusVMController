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

defined('INDEX') or die('Access is denied.');

$version = '3.2 Beta';

// Get selected language
$_SESSION['language'] = (isset($_GET['language'])) ? $_GET['language'] : ((isset($_SESSION['language'])) ? $_SESSION['language'] : 'en-us');

require_once(file_exists(LANGUAGES . $_SESSION['language'] . '.php') ? LANGUAGES . $_SESSION['language'] . '.php' : LANGUAGES . 'en-us.php');

$out = '';
$step = (isset($_GET['step'])) ? $_GET['step'] : 0;

switch($step){
	case '1':
		$out .= '<h1>' . SOLUSVMCONTROLLER_INSTALLATION . ' (' . STEP_1_OF_3 . ')</h1>';
		$error = 0;

		$out .= '<p>' . PERFORM_PERMISSION_CHECKS . ' ...</p>';

		if(is_writable(ROOT . 'configuration.php')){
			$out .= '<p class="green">' . CHECK_PERMISSION_OF . ' ' . ROOT . 'configuration.php ' . str_repeat('.', 10) . ' [' . PASS . ']</p>';
		}
		else{
			$error = 1;
			$out .= '<p class="red">' . CHECK_PERMISSION_OF . ' ' . ROOT . 'configuration.php ' . str_repeat('.', 10) . ' [' . FAIL . ']</p>';
		}

		$out .= '<p>' . PERFORM_COMPATIBILITIES_CHECK . ' ...</p>';

		if(version_compare(PHP_VERSION, '5.2.0') >= 0){
			$out .= '<p class="green">' . CHECK_PHP_VERSION . ' ' . str_repeat('.', 100) . ' [' . PASS . ']</p>';
		}
		else{
			$error = 1;
			$out .= '<p class="red">' . CHECK_PHP_VERSION . ' ' . str_repeat('.', 100) . ' [' . FAIL . ']</p>';
		}


		if(function_exists('mysql_connect')){
			$out .= '<p class="green">' . CHECK_IF_MYSQL_INSTALLED . ' ' . str_repeat('.', 100) . ' [' . PASS . ']</p>';
		}
		else{
			$error = 1;
			$out .= '<p class="red">' . CHECK_IF_MYSQL_INSTALLED . ' ' . str_repeat('.', 100) . ' [' . FAIL . ']</p>';
		}

		$out .= '<p align="right">';

		if($error){
			$out .= '<input type="button" value="' . RE_CHECK . '" class="button" onclick="window.location.href=\'?step=1\';" />';
		}
		else{
			$_SESSION['setup_step'] = 1;
			$out .= ' <input type="button" value="' . NEXT . ' &raquo;" class="button" onclick="window.location.href=\'?step=2\';"/>';
		}
		$out .= '</p>';
	break;

	case '2':
		// Make sure not skipping the setup steps
		if(!isset($_SESSION['setup_step']) || $_SESSION['setup_step'] != 1) die(header('Location: ?step=1'));

		$status = '';
		$dbHost = $form->post('dbHost', ((isset($config['dbHost'])) ? $config['dbHost'] : ''), 'strtolower');
		$dbUser = $form->post('dbUser', ((isset($config['dbUser'])) ? $config['dbUser'] : ''));
		$dbPass = $form->post('dbPass', ((isset($config['dbPass'])) ? $config['dbPass'] : ''));
		$dbName = $form->post('dbName', ((isset($config['dbName'])) ? $config['dbName'] : ''));

		if($form->isPost()){
			if(!@mysql_connect($dbHost, $dbUser, $dbPass)){
				$status = '<p class="red">' . UNABLE_TO_CONNECT_MYSQL_SERVER . '</p>';
			}

			if(!@mysql_select_db($dbName)){
				$status .= '<p class="red">' . str_replace('%name%', $dbName, DATABASE_NOT_EXISTS) . '</p>';
			}

			if(!$status){
				$_SESSION['db'] = json_encode(array('dbHost'=>$dbHost, 'dbUser'=>$dbUser, 'dbPass'=>$dbPass, 'dbName'=>$dbName));

				if(defined('UPGRADE')){
					$_SESSION['setup_step'] = 3;
					die(header('Location: ?step=4'));
				}

				$_SESSION['setup_step'] = 2;
				die(header('Location: ?step=3'));
			}
		}

		$out .= '<h1>' . SOLUSVMCONTROLLER_INSTALLATION . ' (' . STEP_2_OF_3 . ')</h1>

		<p><b>' . MYSQL_SETTINGS . '</b></p>

		<form action="?step=2" method="post">
			' . $status . '
			<label for="dbHost">' . HOST . '</label>
			<input type="text" name="dbHost" id="dbHost" value="' . $dbHost . '" maxlength="100" class="text" /> <span class="red">*</span>

			<label for="dbUser">' . USER . '</label>
			<input type="text" name="dbUser" id="dbUser" value="' . $dbUser . '" maxlength="16" class="text" /> <span class="red">*</span>

			<label for="dbPass">' . PASSWORD . '</label>
			<input type="text" name="dbPass" id="dbPass" value="' . $dbPass . '" maxlength="20" class="text" /> <span class="red">*</span>

			<label for="dbName">' . DATABASE_NAME . '</label>
			<input type="text" name="dbName" id="dbName" value="' . $dbName . '" maxlength="50" class="text" /> <span class="red">*</span>

			<br /><br />

			<input class="button" type="submit" value="' . NEXT . ' &raquo;" />
		</form>';
	break;

	case '3':
		// Make sure not skipping the setup steps
		if(!isset($_SESSION['setup_step']) || $_SESSION['setup_step'] != 2) die(header('Location: ?step=1'));

		$status = '';
		$name = $form->post('name');
		$emailAddress = $form->post('emailAddress', '', 'strtolower');

		if($form->isPost()){
			if(empty($name)){
				$status .= '<p class="red">' . NAME_CANNOT_BE_BLANK . '</p>';
			}
			elseif(mb_strlen($name) > 50){
				$status .= '<p class="red">' . NAME_SHOULD_NOT_LONGER_THAN_50_CHARACTERS . '</p>';
			}

			if(!isValidEmail($emailAddress)){
				$status .= '<p class="red">' . INVALID_EMAIL_ADDRESS . '</p>';
			}

			if(!$status){
				$_SESSION['setup_step'] = 3;
				$_SESSION['name'] = $name;
				$_SESSION['email_address'] = $emailAddress;
				$_SESSION['password'] = random(rand(8, 20));

				die(header('Location: ?step=4'));
			}
		}

		$out .= '<h1>' . SOLUSVMCONTROLLER_INSTALLATION . ' (' . STEP_3_OF_3 . ')</h1>

		<p><b>' . SETTINGS . '</b></p>

		<form action="?step=3" method="post">
			' . $status . '

			<label for="name">' . NAME . '</label>
			<input type="text" name="name" id="name" value="' . $name . '" maxlength="50" class="text" /> <span class="red">*</span>

			<label for="emailAddress">' . EMAIL_ADDRESS . '</label>
			<input type="text" name="emailAddress" id="emailAddress" value="' . $emailAddress . '" maxlength="100" class="text" /> <span class="red">*</span>

			<br /><br />

			<input class="button" type="submit" value="' . NEXT . ' &raquo;" />
		</form>';
	break;

	case '4':
		// Make sure not skipping the setup steps
		if($_SESSION['setup_step'] != 3) die(header('Location: ?step=1'));

		if(!isset($_SESSION['db']) || is_null($data = json_decode($_SESSION['db']))) die(header('Location: ?step=1'));

		// Initial database connection
				$db = new MySQL($data->dbHost, $data->dbUser, $data->dbPass, $data->dbName);

				$db->connect();

				// Create required tables
				$sql = 'CREATE TABLE `tag` (
	`tag_id` INT(10) NOT NULL AUTO_INCREMENT,
	`tag_name` VARCHAR(100) NOT NULL COLLATE \'utf8_bin\',
	`user_id` INT(11) NOT NULL,
	PRIMARY KEY (`tag_id`),
	INDEX `idx_tag_name` (`tag_name`),
	INDEX `idx_user_id` (`user_id`)
)
COLLATE=\'utf8_bin\'
ENGINE=MyISAM;

CREATE TABLE `tag_linker` (
	`tag_id` INT(10) NOT NULL,
	`vm_id` INT(10) NOT NULL,
	PRIMARY KEY (`tag_id`, `vm_id`)
)
COLLATE=\'utf8_bin\'
ENGINE=MyISAM;

CREATE TABLE `user` (
	`user_id` INT(10) NOT NULL AUTO_INCREMENT,
	`is_admin` CHAR(1) NOT NULL DEFAULT \'0\' COLLATE \'utf8_bin\',
	`is_active` CHAR(1) NOT NULL DEFAULT \'0\' COLLATE \'utf8_bin\',
	`name` VARCHAR(50) NOT NULL COLLATE \'utf8_bin\',
	`email_address` VARCHAR(100) NOT NULL COLLATE \'utf8_bin\',
	`password` VARCHAR(40) NOT NULL COLLATE \'utf8_bin\',
	`login_attempt` INT(11) NOT NULL DEFAULT \'0\',
	`language` CHAR(5) NOT NULL DEFAULT \'en-us\' COLLATE \'utf8_bin\',
	`date_created` DATETIME NOT NULL,
	PRIMARY KEY (`user_id`),
	INDEX `idx_email_address` (`email_address`),
	INDEX `idx_name` (`name`),
	INDEX `idx_language` (`language`),
	INDEX `idx_date_created` (`date_created`)
)
COLLATE=\'utf8_bin\'
ENGINE=MyISAM;

CREATE TABLE `vm` (
	`vm_id` INT(10) NOT NULL AUTO_INCREMENT,
	`vz_id` INT(10) NOT NULL DEFAULT \'0\',
	`label` VARCHAR(100) NOT NULL COLLATE \'utf8_bin\',
	`is_https` CHAR(1) NOT NULL DEFAULT \'1\' COLLATE \'utf8_bin\',
	`host` VARCHAR(255) NOT NULL COLLATE \'utf8_bin\',
	`port` VARCHAR(5) NOT NULL COLLATE \'utf8_bin\',
	`key` CHAR(17) NOT NULL COLLATE \'utf8_bin\',
	`hash` CHAR(40) NOT NULL COLLATE \'utf8_bin\',
	`user_id` INT(10) NOT NULL,
	PRIMARY KEY (`vm_id`),
	INDEX `idx_user_id` (`user_id`),
	INDEX `idx_label` (`label`),
	INDEX `idx_key` (`key`),
	INDEX `idx_vz_id` (`vz_id`)
)
COLLATE=\'utf8_bin\'
ENGINE=MyISAM;';

		if(defined('UPGRADE')){
			$sql = 'ALTER TABLE `vm`
	ADD COLUMN `vz_id` INT(10) NOT NULL DEFAULT \'0\' AFTER `vm_id`,
	ADD INDEX `idx_vz_id` (`vz_id`);

ALTER TABLE `user`
	ADD INDEX `idx_name` (`name`),
	ADD INDEX `idx_language` (`language`),
	ADD INDEX `idx_date_created` (`date_created`);';
		}

		$db->executeSQL($sql);

		// Create administrator
		if(!defined('UPGRADE')) $db->insert('user', array('is_admin'=>1, 'is_active'=>1, 'name'=>$_SESSION['name'], 'email_address'=>$_SESSION['email_address'], 'password'=>hashed($_SESSION['password']), 'language'=>$_SESSION['language'], 'date_created'=>date('Y-m-d H:i:s')));

		$configurations = '<?php
define(\'INSTALLED\', 1);
define(\'SVMC_VERSION\', \'' . $version . '\');

$config[\'dbHost\'] = \'' . $data->dbHost . '\';
$config[\'dbUser\'] = \'' . $data->dbUser . '\';
$config[\'dbPass\'] = \'' . $data->dbPass . '\';
$config[\'dbName\'] = \'' . $data->dbName . '\';
$config[\'language\'] = \'' . $_SESSION['language'] . '\';
?>';

		file_put_contents(ROOT . 'configuration.php', $configurations);

		if(defined('UPGRADE')){
			$out .= '<h1>' . UPGRADE_COMPLETED . '</h1>

			<p>' . str_replace('%version%', $version, SOLUSVM_CONTROLLER_HAS_BEEN_UPGRADED) . '</p>

			<p><input class="button" type="button" value="' . FINISH . '" onclick="window.location.href=\'?q=log-in\';" /></p>';
		}
		else{
			$out .= '<h1>' . INSTALLTION_COMPLETED . '</h1>

			<p>' . str_replace(array('%emailAddress%', '%password%'), array($_SESSION['email_address'], $_SESSION['password']), YOU_CAN_NOW_LOG_IN) . '</p>

			<p><input class="button" type="button" value="' . FINISH . '" onclick="window.location.href=\'?q=log-in\';" /></p>';
		}
	break;

	default:
		unset($_SESSION['admin_id']);
		unset($_SESSION['user_id']);
		unset($_SESSION['name']);
		unset($_SESSION['status']);

		$_SESSION['setup_step'] = 0;

		$options = '<select name="language" id="language" onchange="window.location.href=\'?q=setup&language=\' + $(this).val();">';

		if($handle = opendir(LANGUAGES)){
			while(false !== ($file = readdir($handle))){
				if(strpos($file, '.php')){
					$content = file_get_contents(LANGUAGES . $file);

					if(preg_match('/LANGUAGE:([^\*]+)/s', $content, $matches)){
						$value = str_replace('.php' , '', $file);
						$options .= "\t" . '<option value="' . $value . '"' . ($value==$_SESSION['language'] ? ' selected' : '') . '> ' . trim($matches[1]) . '</option>' . "\n";
					}
				}
			}
			closedir($handle);
		}
		$options .= '</select>';

		$out .= '<h1>' . SOLUSVMCONTROLLER_INSTALLATION . ((defined('UPGRADE')) ? ' (' . SYSTEM_UPGRADE . ': ' . $version . ')' : '') . '</h1>
		<div align="right">
			<b>' . LANGUAGE . '</b>
			' . $options . '
		</div>
		<p class="clear">&nbsp;</p>
		<p>' . THANK_YOU_FOR_CHOOSING_SOLUSVMCONTROLLER . '</p>
		<p align="right">
			<input type="button" value="' . NEXT . ' &raquo;" class="button" onclick="window.location.href=\'?step=1\';" />
		</p>';
	break;
}

$showMenu = 0;
$showSidebar = 0;
$title = SOLUSVMCONTROLLER_INSTALLATION;

require_once(INCLUDES . 'header.php');

echo $out;

require_once(INCLUDES . 'footer.php');
?>