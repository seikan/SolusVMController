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

$id = $form->post('id');
$action = $form->post('action');

if(!in_array($action, array('boot', 'reboot', 'shutdown'))) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . INVALID_ACTION . '</p>')));

$db->connect();

$rows = $db->select('vm', '*', 'vm_id=\'' . $db->escape($id) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\' LIMIT 1');

if($db->affectedRows() == 0) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . VM_NOT_FOUND . '</p>')));

foreach($rows[0] as $key=>$value) $vm[$key] = $value;

foreach($rows as $row){
	require_once(LIBRARIES . 'solusvm.class.php');

	$svm = new SolusVM();
	$svm->setProtocol(($vm['is_https']) ? 'https' : 'http');
	$svm->setHost($vm['host']);
	$svm->setPort($vm['port']);
	$svm->setKey($vm['key']);
	$svm->setHash($vm['hash']);

	switch($action){
		case 'boot':
			$result = $svm->boot();
			$message = str_replace('%name%', $vm['label'], VM_HAS_BEEN_BOOTED);
		break;

		case 'reboot':
			$result = $svm->reboot();
			$message = str_replace('%name%', $vm['label'], VM_HAS_BEEN_REBOOTED);
		break;

		case 'shutdown':
			$result = $svm->shutdown();
			$message = str_replace('%name%', $vm['label'], VM_HAS_BEEN_SHUTDOWN);
		break;
	}

	if(!$result || $result['status'] != 'success') die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . CONNECTION_ERROR_WHEN_ACCESSING . '</p>')));

	die(json_encode(array('status'=>'ok', 'message'=>'<p class="green">' . $message . '</p>')));
}
?>