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
if(isset($_SESSION['user_id'])){
	die(header('Location: ?q=vm'));
}

$status = '';
$emailAddress = $form->post('emailAddress', '', 'strtolower');
$password = $form->post('password');

// Proceed log in whenever valid email address and password provided
if($form->isPost() && isValidEmail($emailAddress) && !empty($password)){
	$db->connect();

	// Get user information by email address
	$rows = $db->select('user', '*', 'email_address=\'' . $db->escape($emailAddress) . '\'');

	if($db->affectedRows() == 1){
		foreach($rows[0] as $key=>$value) $user[$key] = $value;

		// Validate password by MD5 hash
		if(hashed($password) == $user['password']){
			// Enable log in session if user is active
			if($user['is_active']){
				// Reset log in attempt
				$db->update('user', 'login_attempt=0', 'user_id=\'' . $db->escape($user['user_id']) . '\'');

				if($user['is_admin']) $_SESSION['admin_id'] = $user['user_id'];
				$_SESSION['user_id'] = $user['user_id'];
				$_SESSION['name'] = $user['name'];
				$_SESSION['language'] = $user['language'];
				$_SESSION['status'] = json_encode(array('vm'=>''));

				die(header('Location: ?q=vm'));
			}

			// Account disabled
			$status = '<p class="red">' . YOUR_ACCOUNT_HAS_BEEN_DISABLED . '</p>';
		}
		else{
			// Increase log in attempts for log in failure
			if($user['login_attempt'] < 5){
				$status = '<p class="red">' . INVALID_USERNAME_OR_PASSWORD . '</p>';
				$db->update('user', 'login_attempt=login_attempt+1', 'user_id=\'' . $db->escape($user['user_id']) . '\'');
			}
			else{
				// Disable the account after 5 log in attempts
				$db->update('user', 'is_active=0', 'email_address=\'' . $db->escape($emailAddress) . '\'');
				$status = '<p class="red">' . TOO_MANY_LOG_IN_ATTEMPTS . '</p>';

				// For administrator account, send a reset email

			}
		}
	}
	else{
		$status = '<p class="red">' . INVALID_USERNAME_OR_PASSWORD . '</p>';
	}
}

$title = ADMINISTRATOR_PAGE;
include(INCLUDES . 'header.php');
?>
	<div id="main">
		<h1><?php echo ADMINISTRATOR_PAGE; ?></h1>
		<form action="?q=log-in" method="post">
			<?php echo $status; ?>
			<label for="emailAddress"><?php echo EMAIL_ADDRESS; ?></label>
			<input type="text" name="emailAddress" id="emailAddress" value="<?php echo $emailAddress; ?>" maxlength="100" class="text" />
			<label for="password"><?php echo PASSWORD; ?></label>
			<input type="password" name="password" id="password" value="" maxlength="20" class="text" />
			<br />
			<input class="button" type="submit" value="<?php echo LOG_IN; ?>" />
		</form>
		<p>&nbsp;</p>
	</div>
<?php include(INCLUDES . 'footer.php'); ?>