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
if(!isset($_SESSION['admin_id'])) die('Access is denied.');

$userId = (isset($_GET['id'])) ? $_GET['id'] : '';
$action = (isset($_GET['action'])) ? $_GET['action'] : '';

$db->connect();

if($userId){
	// Get user information by Id
	$rows = $db->select('user', '*', 'user_id=\'' . $db->escape($userId) . '\'');
}

if($action == 'revoke'){
	// Get administrator information
	$rows = $db->select('user', '*', 'user_id=\'' . $db->escape($_SESSION['admin_id']) . '\'');
}

if($db->affectedRows() == 0) die(header('Location: /404'));

foreach($rows[0] as $key=>$value) $user[$key] = $value;

$_SESSION['user_id'] = $user['user_id'];
$_SESSION['name'] = $user['name'];
$_SESSION['language'] = $user['language'];
$_SESSION['status'] = json_encode(array('vm'=>''));

die(header('Location: ?q=' . (($action) ? 'user' : 'vm')));
?>