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

$vmId = $form->post('vmId');
$label = $form->post('label');
$vzId = $form->post('vzId');
$isHttps = $form->post('isHttps');
$host = $form->post('host', '', 'strtolower');
$port = $form->post('port');
$key = $form->post('key');
$hash = $form->post('hash');
$tags = $form->post('tags');

if(empty($label)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . PLEASE_PROVIDE_A_LABEL . '</p>')));

if(strlen($label) > 100) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . LABEL_SHOULD_NOT_LONGER_THAN_100_CHARACTERS . '</p>')));

if($vzId == 0) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . PLEASE_SELECT_A_VIRTUALIZATION . '</p>')));

if(!preg_match('/^([a-z0-9\-]+\.)?[a-z0-9\-]+\.[a-z]{2,4}|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $host)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . YOU_MUST_PROVIDE_A_VALID_HOST . '</p>')));

if(!empty($port) && !preg_match('/[0-9]+/', $port)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . str_replace('%port%', $port, IS_NOT_A_VALID_PORT) . '</p>')));

if(!preg_match('/^[0-9A-Z]{5}\-[0-9A-Z]{5}\-[0-9A-Z]{5}$/', $key)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . A_VALID_API_KEY_SHOULD_LOOK_LIKE . '</p>')));

if(!preg_match('/^[a-f0-9]{40}$/', $hash)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . A_VALID_API_HASH_SHOULD_BE_40_CHARACTERS_IN_LENGTH . '</p>')));

$db->connect();

// Make sure virtualization is valid
if(!getVz($vzId)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . INVALID_VIRTUALIZATION_SELECTED . '</p>')));

// Check if key exists
$db->select('vm', '*', 'key=\'' . $db->escape($key) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\'' . (($vmId) ? ' AND vm_id != \'' . $db->escape($vmId) . '\'' : ''));

if($db->affectedRows() == 1) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . API_KEY_ALREADY_EXISTS . '</p>')));

// Try to access the API for validation
require_once(LIBRARIES . 'solusvm.class.php');

$svm = new SolusVM();
$svm->setProtocol(($isHttps) ? 'https' : 'http');
$svm->setHost($host);
$svm->setPort($port);
$svm->setKey($key);
$svm->setHash($hash);

$result = $svm->getStatus();

if($result['status'] != 'success') die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . UNABLE_TO_ACCESS_SOLUSVM_API . '</p>')));

$data = array(
	'label'=>$label,
	'vz_id'=>$vzId,
	'is_https'=>($isHttps) ? 1 : 0,
	'host'=>$host,
	'port'=>((empty($port)) ? (($isHttps) ? '443' : '80') : $port),
	'key'=>$key,
	'hash'=>$hash,
	'user_id'=>$_SESSION['user_id'],
);

// Edit existing VM
if($vmId){
	$db->update('vm', $data, 'vm_id=\'' . $db->escape($vmId) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');

	// Remove existing tags
	$db->delete('tag_linker', 'vm_id=\'' . $db->escape($vmId) . '\'');

	// Add new tags
	if(!empty($tags)){
		$tags = explode(',', $tags . ',');

		foreach($tags as $tag){
			if(empty($tag)) continue;

			// Check if tag exists
			$rows = $db->select('tag', '*', 'tag_name=\'' . $db->escape($tag) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');

			// Tag existed, assign the tag to vm
			if($db->affectedRows() == 1){
				$db->insert('tag_linker', array('vm_id'=>$vmId, 'tag_id'=>$rows[0]['tag_id']));
				continue;
			}

			// New tag, add to database and assign it to vm
			$db->insert('tag', array('tag_name'=>$tag, 'user_id'=>$_SESSION['user_id']));
			$db->insert('tag_linker', array('vm_id'=>$vmId, 'tag_id'=>$db->getLastId()));
		}
	}

	$_SESSION['result'] = '<p class="green">' . str_replace('%name%', $label, VM_IS_UPDATED) . '</p>';
}
// Add new VM
else{
	$db->insert('vm', $data);

	$vmId = $db->getLastId();

	// Add tags
	if(!empty($tags)){
		$tags = explode(',', $tags . ',');

		foreach($tags as $tag){
			if(empty($tag)) continue;

			// Check if tag exists
			$rows = $db->select('tag', '*', 'tag_name=\'' . $db->escape($tag) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');

			// Tag existed, assign the tag to vm
			if($db->affectedRows() == 1){
				$db->insert('tag_linker', array('vm_id'=>$vmId, 'tag_id'=>$rows[0]['tag_id']));
				continue;
			}

			// New tag, add to database and assign it to vm
			$db->insert('tag', array('tag_name'=>$tag, 'user_id'=>$_SESSION['user_id']));
			$db->insert('tag_linker', array('vm_id'=>$vmId, 'tag_id'=>$db->getLastId()));
		}
	}

	$_SESSION['result'] = '<p class="green">' . str_replace('%name%', $label, VM_IS_ADDED) . '</p>';
}

$status = get_object_vars(json_decode($_SESSION['status']));
$status['vm-' . $vmId] = $result['vmstat'];
$_SESSION['status'] = json_encode($status);

echo json_encode(array('status'=>'ok', 'message'=>''));
?>