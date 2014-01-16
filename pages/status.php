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

if(!isset($_SESSION['user_id'])) die(json_encode(array('status'=>'connect-unknown', 'message'=>'<p class="red">' . SESSION_EXPIRED . '</p>', 'hostname'=>'', 'main_ip'=>'', 'ip_list'=>'', 'hdd_total'=>0, 'hdd_used'=>0, 'hdd_free'=>0, 'hdd_percent'=>0, 'mem_total'=>0, 'mem_used'=>0, 'meme_free'=>0, 'mem_percent'=>0, 'bw_total'=>0, 'bw_used'=>0, 'bw_free'=>0, 'bw_percent'=>0)));

$vmId = $form->post('id');

$db->connect();

$rows = $db->select('vm', '*', 'vm_id=\'' . $db->escape($vmId) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\' LIMIT 1');

$status = get_object_vars(json_decode($_SESSION['status']));

if($db->affectedRows() == 0){
	$status['vm-' . $vmId] = 'connect-unknown';
	$_SESSION['status'] = json_encode($status);

	die(json_encode(array('status'=>'connect-unknown', 'message'=>'<p class="red">' . VM_NOT_FOUND . '</p>', 'hostname'=>'', 'main_ip'=>'', 'ip_list'=>'', 'hdd_total'=>0, 'hdd_used'=>0, 'hdd_free'=>0, 'hdd_percent'=>0, 'mem_total'=>0, 'mem_used'=>0, 'meme_free'=>0, 'mem_percent'=>0, 'bw_total'=>0, 'bw_used'=>0, 'bw_free'=>0, 'bw_percent'=>0)));
}

foreach($rows as $row){
	require_once(LIBRARIES . 'solusvm.class.php');

	$svm = new SolusVM();
	$svm->setProtocol(($row['is_https']) ? 'https' : 'http');
	$svm->setHost($row['host']);
	$svm->setPort($row['port']);
	$svm->setKey($row['key']);
	$svm->setHash($row['hash']);

	$result = $svm->getStatus();

	if(!$result){
		$status['vm-' . $vmId] = 'connect-error';
		$_SESSION['status'] = json_encode($status);

		die(json_encode(array('status'=>'connect-error', 'message'=>'<p class="red">' . CONNECTION_ERROR_WHEN_ACCESSING . '</p>', 'hostname'=>'', 'main_ip'=>'', 'ips'=>array(), 'hdd_total'=>0, 'hdd_used'=>0, 'hdd_free'=>0, 'hdd_percent'=>0, 'mem_total'=>0, 'mem_used'=>0, 'meme_free'=>0, 'mem_percent'=>0, 'bw_total'=>0, 'bw_used'=>0, 'bw_free'=>0, 'bw_percent'=>0)));
	}

	list($hddTotal, $hddUsed, $hddFree, $hddPercent) = explode(',', (strpos($result['hdd'], ',')) ? $result['hdd'] : '0,0,0,0');
	list($memTotal, $memUsed, $memFree, $memPercent) = explode(',', (strpos($result['mem'], ',')) ? $result['mem'] : '0,0,0,0');
	list($bwTotal, $bwUsed, $bwFree, $bwPercent) = explode(',', (strpos($result['bw'], ',')) ? $result['bw'] : '0,0,0,0');

	$ipList = array();

	$ips = explode(',', $result['ipaddr'] . ',');

	foreach($ips as $ip){
		if(!$ip) continue;
		$ipList[] = $ip;
	}

	if($result['status'] != 'success'){
		$status['vm-' . $vmId] = 'connect-error';
		$_SESSION['status'] = json_encode($status);

		die(json_encode(array('status'=>'connect-error', 'message'=>'<p class="red">' . CONNECTION_ERROR_WHEN_ACCESSING . '</p>', 'hostname'=>$result['hostname'], 'main_ip'=>$result['ipaddress'], 'ips'=>$ipList, 'hdd_total'=>displayBytes($hddTotal), 'hdd_used'=>displayBytes($hddUsed), 'hdd_free'=>displayBytes($hddFree), 'hdd_percent'=>$hddPercent, 'mem_total'=>displayBytes($memTotal), 'mem_used'=>displayBytes($memUsed), 'meme_free'=>displayBytes($memFree), 'mem_percent'=>$memPercent, 'bw_total'=>displayBytes($bwTotal), 'bw_used'=>displayBytes($bwUsed), 'bw_free'=>displayBytes($bwFree), 'bw_percent'=>$bwPercent)));
	}

	$status['vm-' . $vmId] = ($result['vmstat'] == 'online') ? 'online' : 'offline';
	$_SESSION['status'] = json_encode($status);

	die(json_encode(array('status'=>(($result['vmstat'] == 'online') ? 'online' : 'offline'), 'hostname'=>$result['hostname'], 'main_ip'=>$result['ipaddress'], 'ips'=>$ipList, 'hdd_total'=>displayBytes($hddTotal), 'hdd_used'=>displayBytes($hddUsed), 'hdd_free'=>displayBytes($hddFree), 'hdd_percent'=>$hddPercent, 'mem_total'=>displayBytes($memTotal), 'mem_used'=>displayBytes($memUsed), 'meme_free'=>displayBytes($memFree), 'mem_percent'=>$memPercent, 'bw_total'=>displayBytes($bwTotal), 'bw_used'=>displayBytes($bwUsed), 'bw_free'=>displayBytes($bwFree), 'bw_percent'=>$bwPercent)));
}
?>