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
if(!isset($_SESSION['user_id'])) die(header('Location: ?q=log-in'));

$db->connect();
$rows = $db->select('user', '*', 'user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');

if($db->affectedRows() == 0) die(header('Location: ?q=log-out'));

foreach($rows[0] as $key=>$value) $user[$key] = $value;

$status = '';
$name = $form->post('name', $user['name']);
$emailAddress = $form->post('emailAddress', $user['email_address'], 'strtolower');
$password = $form->post('password');
$confirmPassword = $form->post('confirmPassword');
$language = $form->post('language', $user['language']);

$languages = array();
if($handle = opendir(LANGUAGES)){
	while(false !== ($file = readdir($handle))){
		if(strpos($file, '.php')){
			$content = file_get_contents(LANGUAGES . $file);

			if(preg_match('/LANGUAGE:([^\*]+)/s', $content, $matches)){
				$languages[str_replace('.php' , '', $file)] = trim($matches[1]);
			}
		}
	}
	closedir($handle);
}

if($form->isPost()){
	if(empty($name)){
		$status .= '<p class="red">' . NAME_CANNOT_BE_BLANK . '</p>';
	}
	elseif(mb_strlen($name) > 50){
		$status .= '<p class="red">' . NAME_SHOULD_NOT_LONGER_THAN_50_CHARACTERS . '</p>';
	}

	if(isset($_SESSION['admin_id'])){
		if(!isValidEmail($emailAddress)){
			$status .= '<p class="red">' . INVALID_EMAIL_ADDRESS . '</p>';
		}
		else{
			// Make sure email address not using by other user
			$db->select('user', '*', 'email_address=\'' . $db->escape($emailAddress) . '\' AND user_id != \'' . $db->escape($_SESSION['user_id']) . '\'');

			if($db->affectedRows() == 1){
				$status .= '<p class="red">' . THIS_EMAIL_ADDRESS_ALREADY_IN_USE . '</p>';
			}
		}
	}

	if($password){
		if(!preg_match('/^[0-9a-zA-Z!@#\$%\^&*\(\)<>:;\-_=\+]{6,20}$/', $password)){
			$status .= '<p class="red">' . PASSWORD_MUST_CONTAIN_ONLY_ALPHANUMERIC_CHARACTERS . '</p>';
		}
		if($password != $confirmPassword){
			$status .= '<p class="red">' . CONFIRM_PASSWORD_IS_NOT_MATCHED . '</p>';
		}
	}

	if(!in_array($language, array_keys($languages))){
		$status .= '<p class="red">' . INVALID_LANGUAGE_SELECTED . '</p>';
	}

	if(!$status){
		$data['name'] = $name;
		if($password) $data['password'] = hashed($password);
		if(isset($_SESSION['admin_id'])) $data['email_address'] = $emailAddress;
		$data['language'] = $language;

		if(!defined('DEMO')){
			$db->update('user', $data, 'user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');
			$_SESSION['name'] = $name;
			$_SESSION['language'] = $language;
		}

		$status .= '<p class="green">' . SETTINGS_IS_UPDATED . '</p>';
	}
}

$title = SETTINGS;

include(INCLUDES . 'header.php');
?>
	<div id="main">
		<h1><?php echo SETTINGS; ?></h1>

		<form action="?q=settings" method="post">
			<?php echo $status; ?>

			<label for="name"><?php echo NAME; ?></label>
			<input type="text" name="name" id="name" value="<?php echo $name; ?>" maxlength="50" class="text" /> <span class="red">*</span>

			<label for="emailAddress"><?php echo EMAIL_ADDRESS; ?></label>

			<?php
			// Only administrator can update their email address
			if(isset($_SESSION['admin_id'])){
				echo '<input type="text" name="emailAddress" id="emailAddress" value="' . $emailAddress . '" class="text" /> <span class="red">*</span>';
			}
			else{
				echo '<input type="text" name="emailAddress" id="emailAddress" value="' . $user['email_address'] . '" class="text" readonly />';
			}
			?>

			<label for="password"><?php echo PASSWORD; ?></label>
			<input type="password" name="password" id="password" value="<?php echo $password?>" maxlength="20" class="text" />

			<label for="confirmPassword"><?php echo CONFIRM_PASSWORD; ?></label>
			<input type="password" name="confirmPassword" id="confirmPassword" value="<?php echo $confirmPassword; ?>" maxlength="20" class="text" />

			<label for="language"><?php echo LANGUAGE; ?></label>
			<select name="language" id="language">
			<?php
			foreach($languages as $code=>$value){
				echo '<option value="' . $code . '"' . (($code == $language) ? ' selected' : '') . '> ' . $value . '</option>';
			}
			?>
			</select>

			<br /><br />
			<input class="button" type="submit" value="<?php echo SAVE_SETTINGS; ?>" />
		</form>

		<p>&nbsp;</p>
	</div>
<?php
include(INCLUDES . 'footer.php');
?>