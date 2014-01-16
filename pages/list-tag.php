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

$keyword = $form->post('keyword');
$sort = $form->post('sort');

$db->connect();

$order = ($sort == 'name') ? 'LOWER(t.tag_name)' : 'total DESC';

$rows = $db->execute('SELECT *,(SELECT COUNT(*) FROM tag_linker WHERE tag_id=t.tag_id) AS total FROM tag t WHERE user_id=\'' . $db->escape($_SESSION['user_id']) . '\' AND LOWER(t.tag_name) LIKE \'%' . $db->escape(strtolower($keyword)) . '%\' ORDER BY ' . $order);

if($db->affectedRows() == 0) die(json_encode(array()));

foreach($rows as $row){
	$tags[] = array('id'=>$row['tag_id'], 'tag_name'=>$row['tag_name'], 'total'=>$row['total']);
}

echo json_encode($tags);
?>