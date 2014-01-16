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

$keyword = strtolower($form->post('keyword'));
$sort = $form->post('sort');

$db->connect();

switch($sort){
	case 'email':
		$order = 'u.email_address';
	break;

	case 'language':
		$order = 'u.language';
	break;

	case 'vm':
		$order = 'total_vm DESC';
	break;

	default:
		$order = 'u.name';
	break;
}

$rows = $db->execute('SELECT *,(SELECT COUNT(*) FROM vm WHERE user_id=u.user_id) AS total_vm FROM user u WHERE ' . ((preg_match('/^\d+$/', $keyword)) ? 'user_id=\'' . $db->escape($keyword) . '\'' : 'LOWER(name) LIKE \'%' . $db->escape($keyword) . '%\' OR email_address LIKE \'%' . $keyword . '%\'') . ' ORDER BY ' . $order);

if($db->affectedRows() == 0) die(json_encode(array()));

foreach($rows as $row){
	$users[] = array('id'=>$row['user_id'], 'name'=>$row['name'], 'email_address'=>$row['email_address'], 'is_admin'=>$row['is_admin'], 'is_active'=>$row['is_active'], 'language'=>$row['language'], 'total_vm'=>$row['total_vm']);
}

echo json_encode($users);
?>