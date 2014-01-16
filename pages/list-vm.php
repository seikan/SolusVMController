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
if(!isset($_SESSION['user_id'])) die('Access is denied.');
if(!isset($_SESSION['user_id'])) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . SESSION_EXPIRED . '</p>')));

$keyword = strtolower($form->post('keyword'));
$sort = $form->post('sort');

$db->connect();

$order = ($sort == 'vz') ? 'v.vz_id,LOWER(v.label)' : 'LOWER(v.label)';

if(substr($keyword,0, 4) == 'tag:'){
	$rows = $db->execute('SELECT v.vm_id,v.label,v.vz_id FROM vm v LEFT JOIN tag_linker tl ON v.vm_id=tl.vm_id LEFT JOIN tag t ON t.tag_id=tl.tag_id WHERE v.user_id=\'' . $db->escape($_SESSION['user_id']) . '\' AND LOWER(t.tag_name)=\'' . $db->escape(substr($keyword, 4)) . '\' GROUP BY v.vm_id ORDER BY ' . $order);
}
else{
	$rows = $db->execute('SELECT v.vm_id,v.label,v.vz_id FROM vm v LEFT JOIN tag_linker tl ON v.vm_id=tl.vm_id LEFT JOIN tag t ON t.tag_id=tl.tag_id WHERE v.user_id=\'' . $db->escape($_SESSION['user_id']) . '\'' . (($keyword) ? ' AND (LOWER(v.label) LIKE \'%' . $db->escape($keyword) . '%\' OR LOWER(v.host) LIKE \'%' . $db->escape($keyword) . '%\' OR LOWER(t.tag_name) LIKE \'%' . $db->escape($keyword) . '%\')' : '') . ' GROUP BY v.vm_id ORDER BY ' . $order);
}

if($db->affectedRows() == 0) die(json_encode(array()));

if(isset($_SESSION['status'])) $status = get_object_vars(json_decode($_SESSION['status']));

foreach($rows as $row){
	$vz = getVz($row['vz_id']);
	$vzCode = (substr($vz['code'], 0, 3) == 'xen') ? 'xen' : $vz['code'];
	$servers[] = array('id'=>$row['vm_id'], 'status'=>((isset($status['vm-' . $row['vm_id']])) ? $status['vm-' . $row['vm_id']] : 'connect-unknown'), 'label'=>$row['label'], 'vz'=>(($vzCode) ? $vzCode : ''));
}

echo json_encode($servers);
?>