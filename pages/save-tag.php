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
$tagName = $form->post('tagName');

if(empty($tagName)) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . TAG_NAME_CANNOT_BE_BLANK . '</p>')));

if(mb_strlen($tagName) > 100) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . TAG_NAME_SHOULD_NOT_LONGER_THAN_100_CHARACTERS . '</p>')));

$db->connect();

// Check for duplicated tag name
$db->select('tag', '*', 'LOWER(tag_name)=\'' . $db->escape(strtolower($tagName)) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\'' . (($id) ? ' AND tag_id != \'' . $db->escape($id) . '\'' : ''));

if($db->affectedRows() > 0) die(json_encode(array('status'=>'error', 'message'=>'<p class="red">' . str_replace('%name%', $tagName, TAG_NAME_ALREADY_EXISTS) . '</p>')));

// Edit existing tag
if($id){
	$db->update('tag', array('tag_name'=>$tagName), 'tag_id=\'' . $db->escape($id) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');
	echo json_encode(array('status'=>'ok', 'message'=>''));
}
// Add new tag
else{
	$_SESSION['result'] = '<p class="green">' . str_replace('%name%', $tagName, TAG_IS_ADDED) . '</p>';
	$db->insert('tag', array('tag_name'=>$tagName, 'user_id'=>$_SESSION['user_id']));
	echo json_encode(array('status'=>'ok', 'message'=>''));
}
?>