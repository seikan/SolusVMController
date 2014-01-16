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
if(!isset($_SESSION['user_id'])) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . SESSION_EXPIRED . '</p>')));

$vmId = $form->post('id');

$db->connect();

// Check for permission
$rows = $db->select('vm', '*', 'vm_id=\'' . $db->escape($vmId) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');

if($db->affectedRows() == 0) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . ACCESS_DENIED . '</p>')));

// Remove the VM
$db->delete('vm', 'vm_id=\'' . $db->escape($vmId) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');

// Remove associated tags
$db->delete('tag_linker', 'vm_id=\'' . $db->escape($vmId) . '\'');

$_SESSION['result'] = '<p class="green">' . str_replace('%name%', $rows[0]['label'], VM_HAS_BEEN_REMOVED) . '</p>';

echo json_encode(array('status'=>'ok', 'message'=>''));
?>