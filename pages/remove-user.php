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

$userId = $form->post('id');

// Cannot remove myself
if($_SESSION['admin_id'] == $userId) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . ACCESS_DENIED . '</p>')));

$db->connect();

// Check if user exist
$rows = $db->select('user', '*', 'user_id=\'' . $db->escape($userId) . '\'');

if($db->affectedRows() == 0) die(json_encode(array('status'=>'error', 'message'=>USER_NOT_FOUND)));

// Remove user
$db->delete('user', 'user_id=\'' . $db->escape($userId) . '\'');

// Remove user created VMs
$db->delete('vm', 'user_id=\'' . $db->escape($userId) . '\'');

// Remove user created tags
$tags = $db->select('tag', '*', 'user_id=\'' . $db->escape($userId) . '\'');

if($db->affectedRows() > 0){
	$db->delete('tag', 'user_id=\'' . $db->escape($userId) . '\'');

	// Remove associated tags
	foreach($tags as $row){
		$db->delete('tag_linker', 'tag_id=\'' . $db->escape($row['tag_id']) . '\'');
	}
}

echo json_encode(array('status'=>'ok', 'message'=>'<p class="green">' . str_replace('%name%', $rows[0]['name'], USER_HAS_BEEN_REMOVED) . '</p>'));
?>