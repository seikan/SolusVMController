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

if(!isset($_SESSION['admin_id'])) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . ACCESS_DENIED . '</p>')));
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] != $_SESSION['user_id']) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . ACCESS_DENIED . '</p>')));

$userId = $form->post('userId');
$status = $form->post('status');
$name = $form->post('name');
$emailAddress = $form->post('emailAddress', '', 'strtolower');
$password = $form->post('password');
$language = $form->post('language');

if(defined('DEMO') && $userId == 1) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">Feature disabled in demo.</p>')));

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

if(empty($name)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . NAME_CANNOT_BE_BLANK . '</p>')));
elseif(mb_strlen($name) > 50) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . NAME_SHOULD_NOT_LONGER_THAN_50_CHARACTERS . '</p>')));

if(!isValidEmail($emailAddress)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . INVALID_EMAIL_ADDRESS . '</p>')));

$db->connect();

$db->select('user', '*', 'email_address=\'' . $db->escape($emailAddress) . '\'' . (($userId) ? ' AND user_id != \'' . $db->escape($userId) . '\'' : ''));

if($db->affectedRows() == 1) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . THIS_EMAIL_ADDRESS_ALREADY_IN_USE . '</p>')));

// For existing user
if($userId){
	if($password && !preg_match('/^[0-9a-zA-Z!@#\$%\^&*\(\)<>:;\-_=\+]{6,20}$/', $password)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . PASSWORD_MUST_CONTAIN_ONLY_ALPHANUMERIC_CHARACTERS . '</p>')));
}
// For new user
else{
	if(!preg_match('/^[0-9a-zA-Z!@#\$%\^&*\(\)<>:;\-_=\+]{6,20}$/', $password)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . PASSWORD_MUST_CONTAIN_ONLY_ALPHANUMERIC_CHARACTERS . '</p>')));
}

if(!in_array($language, array_keys($languages))) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . INVALID_LANGUAGE_SELECTED . '</p>')));

$data['is_active'] = ($status) ? 1 : 0;
$data['name'] = $name;
$data['email_address'] = $emailAddress;
$data['language'] = $language;
$data['login_attempt'] = 0; // Reset login attempts

// Edit existing user
if($userId){
	if($userId == $_SESSION['user_id']) $_SESSION['name'] = $name;

	if($password) $data['password'] = hashed($password);
	$db->update('user', $data, 'user_id=\'' . $db->escape($userId) . '\'');
	echo json_encode(array('status'=>'ok', 'message'=>''));
}
// Add new user
else{
	$data['password'] = hashed($password);
	$data['date_created'] = date('Y-m-d H:i:s');

	$db->insert('user', $data);

	$_SESSION['result'] = '<p class="green">' . str_replace('%name%', $name, USER_IS_ADDED) . '</p>';

	echo json_encode(array('status'=>'ok', 'message'=>''));
}
?>