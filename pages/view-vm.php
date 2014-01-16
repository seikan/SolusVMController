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
if(!isset($_SESSION['user_id'])) die(header('Location: ?q=log-in'));

$referer = (isset($_GET['ref'])) ? $_GET['ref'] : '?q=vm';

// Get VM information by Id
$vmId = $form->get('id');
$db->connect();
$rows = $db->execute('SELECT * FROM vm WHERE vm_id=\'' . $db->escape($vmId) . '\' AND user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');

// VM is not found
if($db->affectedRows() != 1){
	$title = VM_NOT_FOUND;

	require_once(INCLUDES . 'header.php');

	echo '
	<div id="main">
		<h1>' . VM_NOT_FOUND . '</h1>

		<p>' . THE_VM_WITH_THIS_ID . '</p>
	</div>';

	require_once(INCLUDES . 'footer.php');
	die;
}

// Assign VM information into an array
foreach($rows[0] as $key=>$value){
	$vm[$key] = $value;
}

// Get virtualization
$vz = getVz($vm['vz_id']);

// Get available tags
$tags = array();
$rows = $db->select('tag', '*', 'user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');

if($db->affectedRows() > 0){
	foreach($rows as $row){
		$tags[] = addslashes($row['tag_name']);
	}
}

// Get tags assigned to the VM
$presetTags = array();
$rows = $db->execute('SELECT t.tag_name FROM tag t JOIN tag_linker tl ON t.tag_id=tl.tag_id JOIN vm v ON v.vm_id=tl.vm_id WHERE v.vm_id=\'' . $db->escape($vm['vm_id']) . '\' AND v.user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');

if($db->affectedRows() > 0){
	foreach($rows as $row){
		$presetTags[] = addslashes($row['tag_name']);
	}
}

$styles = '
	#main{width:610px;float:right;}';

$title = htmlspecialchars($vm['label']);

$js[] = 'includes/js/modal.js';
$js[] = 'includes/js/tagfield.js';

$css[] = 'includes/css/modal.css';
$css[] = 'includes/css/tagfield.css';

$scripts = '
	$(function(){
		var tags = [\'' . implode('\',\'', $tags) . '\'];
		var presets = [\'' . implode('\',\'', $presetTags) . '\'];

		$("#tags").tagField({ caseSensitive:false, tags:tags' . (($presetTags) ? ',preset: presets' : '') . ' });

		getDetails();

		$(".boot,.reboot,.shutdown").each(function(i, btn){
			$(btn).click(function(){
				var c = $(btn).attr("class");
				var p = $(btn).parent();
				var v = p.prev("div");

				p.hide();
				v.show();

				$.post("?q=control.json", {id: ' . $vm['vm_id'] . ', action: c}, function(data){
					p.show();
					v.hide();

					$("#result").html(data.message);
				}, "json");
			});
		});
	});

	function getDetails(){
		$("#vm-details").hide();
		$(".progress").show();
		$("#result").html("");
		$("#ip").html("");

		$.post("?q=status.json", {id: ' . $vm['vm_id'] . '}, function(data){
			if(data.status != "connect-error"){
				$("#vm-details").show();
				$(".progress").hide();
				$("#mem-field").show();

				$("#vm-status").html((data.status == "online") ? \'<img src="images/icons/online.png" class="icon"> ' . ONLINE . '\' : \'<img src="images/icons/offline.png" class="icon"> ' . OFFLINE . '\');
				$("#hostname").html(data.hostname);
				$("#main-address").html(data.main_ip + \' <img src="images/icons/plus.png" class="icon" />\');

				$.each(data.ips, function(i, ip){
					if(i == 0) $("#ip-address").html(ip + \' <img src="images/icons/minus.png" class="icon" />\');
					else{
						$("#ip").append(\'<div class="label">&nbsp;</div><div>\' + ip + \'</div>\');
					}
				});

				$("#hdd-percent").css("width", data.hdd_percent + "%");
				$("#hdd").html(data.hdd_used + " / " + data.hdd_total + " (" + data.hdd_percent + "%)");

				if(data.mem_total == "0 B"){
					$("#mem-field").hide();
				}

				$("#mem-percent").css("width", data.mem_percent + "%");
				$("#mem").html(data.mem_used + " / " + data.mem_total + " (" + data.mem_percent + "%)");

				$("#bw-percent").css("width", data.bw_percent + "%");
				$("#bw").html(data.bw_used + " / " + data.bw_total + " (" + data.bw_percent + "%)");

				return;
			}

			$(".progress").hide();
			$("#result").html(data.message);
		}, "json");
	}

	function editVM(){
		$("#result").html("");
		$("#edit-vm-result").html("");
		$("#dialog").modal();
	}

	function saveVM(){
		$("#edit-vm-result").html("");
		$("#saving").show();

		$.post("?q=save-vm.json", $("#dialog form").serialize(), function(data){
			if(data.status == "ok"){
				window.location.href="?q=view-vm&id=' . $vm['vm_id'] . '&ref=' . rawurlencode($referer) . '";
				return;
			}

			$("#saving").hide();
			$("#edit-vm-result").html(data.message);
		}, "json");
	}

	function removeVM(){
		$("#result").html("");

		if(confirm("' . CONFORM_TO_REMOVE_THIS_VM . '")){
			$.post("?q=remove-vm.json", {id: ' . $vm['vm_id'] . '}, function(data){
				if(data.status == "ok"){
					window.location.href="?q=vm";
					return;
				}

				$("#edit-vm-result").html(data.message);
			}, "json");
		}
	}
';

$sidebarItems = array(
'<a href="javascript:;" onclick="getDetails();"><img src="images/icons/refresh.png" width="16" height="16" border="0" alt="' . REFRESH_STATUS . '" title="' . REFRESH_STATUS . '" align="absMiddle" /> ' . REFRESH_STATUS . '</a>',
	'<a href="javascript:;" onclick="editVM();"><img src="images/icons/computer-edit.png" width="16" height="16" border="0" alt="' . EDIT_VM . '" title="' . EDIT_VM . '" align="absMiddle" /> ' . EDIT_VM . '</a>',
	'<a href="javascript:;" onclick="removeVM();"><img src="images/icons/computer-remove.png" width="16" height="16" border="0" alt="' . REMOVE_VM . '" title="' . REMOVE_VM . '" align="absMiddle" /> ' . REMOVE_VM . '</a>'
);

include(INCLUDES . 'header.php');
?>
	<div id="main">
		<h1><?php echo '<a href="' . $referer . '">' . VM_LIST . '</a> &raquo; ' . htmlspecialchars($vm['label']); ?></h1>
		<p>
			<div id="result"><?php if(isset($_SESSION['result'])){ echo $_SESSION['result']; unset($_SESSION['result']); } ?></div>
			<div class="progress"></div>
			<div id="vm-details">
				<div>
					<p>
						<div class="label"><?php echo LABEL; ?></div>
						<div><?php echo $vm['label']; ?></div>
					</p>
					<p>
						<div class="label"><?php echo VIRTUALIZATION; ?></div>
						<div><?php echo '<span id="' . $vz['code'] . '">' . $vz['name'] . '</span>'; ?></div>
					</p>
					<p>
						<div class="label"><?php echo STATUS; ?></div>
						<div id="vm-status">-</div>
					</p>
					<p>
						<div class="label"><?php echo HOSTNAME; ?></div>
						<div id="hostname">-</div>
					</p>

					<div id="main-ip">
						<p>
							<div class="label"><?php echo IP_ADDRESS; ?></div>
							<div id="main-address" onclick="$('#main-ip').hide();$('#ip-list').show();" style="cursor:pointer;">-</div>
						</p>
					</div>

					<div id="ip-list" style="display:none;">
						<p>
							<div class="label"><?php echo IP_ADDRESS; ?></div>
							<div id="ip-address" onclick="$('#ip-list').hide();$('#main-ip').show();" style="cursor:pointer;">-</div>
							<span id="ip"></span>
						</p>
					</div>

					<p>
						<div class="label"><?php echo DISK_SPACE; ?></div>
						<div>
							<div class="percentage">
								<div id="hdd-percent" style="width:0%"></div>
							</div>
							<div style="clear:both;"></div>
						</div>
					</p>
					<p style="padding:0;">
						<div class="label">&nbsp;</div>
						<div id="hdd">-</div>
					</p>

					<span id="mem-field">
						<p>
							<div class="label"><?php echo MEMORY; ?></div>
							<div>
								<div class="percentage">
									<div id="mem-percent" style="width:0%"></div>
								</div>
								<div style="clear:both;"></div>
							</div>
						</p>
						<p style="padding:0;">
							<div class="label">&nbsp;</div>
							<div id="mem">-</div>
						</p>
					</span>

					<p>
						<div class="label"><?php echo BANDWIDTH; ?></div>
						<div>
							<div class="percentage">
								<div id="bw-percent" style="width:0%"></div>
							</div>
							<div style="clear:both;"></div>
						</div>
					</p>
					<p style="padding:0;">
						<div class="label">&nbsp;</div>
						<div id="bw">-</div>
					</p>

					<p>
						<div class="label"><?php echo TAGS; ?></div>
						<ul id="tag-list">
							<?php
							if(count($presetTags) > 0){
								foreach($presetTags as $tagName){
									echo '<li onclick="window.location.href=\'?q=vm&search=' . rawurlencode('tag:' . $tagName) . '\';" style="cursor:pointer;">' . $tagName . '</li>';
								}
							}
							?>
						</ul>
					</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<div class="loading" style="margin:0 0 0 300px;display:none;"></div>

					<p align="center">
						<button class="boot">Boot</button>
						<button class="reboot">Reboot</button>
						<button class="shutdown">Shutdown</button>
					</p>
				</div>
			</div>
		</p>
	</div>

	<div class="modal" id="dialog">
		<div>
			<h2><?php echo EDIT_VM; ?></h2>
			<div id="edit-vm-result"></div>
			<div id="saving" style="display:none;text-align:center;"><div class="loading"></div> <?php echo SAVING; ?>...</div>
			<form>
				<input type="hidden" name="vmId" id="vmId" value="<?php echo $vm['vm_id']; ?>" />
				<label for="label"><?php echo LABEL; ?></label>
				<input type="text" name="label" id="label" value="<?php echo $vm['label']; ?>" maxlength="100" class="text" style="width:355px;" /> <span class="red">*</span>

				<label for="vzId"><?php echo VIRTUALIZATION; ?></label>
				<select name="vzId" id="vzId" class="vz">
					<option value="0"> </option>
					<?php
					$vzTypes = getVz();

					foreach($vzTypes as $vzType){
						echo '<option value="' . $vzType['id'] . '" class="' . $vzType['code'] . '"' . (($vm['vz_id'] == $vzType['id']) ? ' selected' : '') . '> ' . $vzType['name'] . '</option>';
					}
					?>
				</select> <span class="red">*</span>

				<ul class="same-row">
					<li><label for="host"><?php echo HOST; ?></label></li>
					<li style="width:276px;">&nbsp;</li>
					<li><label for="port"><?php echo PORT; ?></label></li>
				</ul>

				<div style="clear:both;"></div>

				<ul class="same-row">
					<li>
						<select name="isHttps" id="isHttps">
							<option value="0"<?php if(!$vm['is_https']) echo ' selected'; ?>> http://</option>
							<option value="1"<?php if($vm['is_https']) echo ' selected'; ?>> https://</option>
						</select>
					</li>
					<li>
						<input type="text" name="host" id="host" value="<?php echo $vm['host']; ?>" maxlength="255" class="text" style="width:203px;" /> <span class="red">*</span>
					</li>
					<li>&nbsp;</li>
					<li>
						<input type="text" name="port" id="port" value="<?php echo $vm['port']; ?>" maxlength="5" class="text" style="width:40px;" />
					</li>
				</ul>
				<div style="clear:both;"></div>

				<label for="key"><?php echo API_KEY; ?></label>
				<input type="text" name="key" id="key" value="<?php echo $vm['key']; ?>" maxlength="17" class="text" style="width:355px;" /> <span class="red">*</span>

				<label for="hash"><?php echo API_HASH; ?></label>
				<input type="text" name="hash" id="hash" value="<?php echo $vm['hash']; ?>" maxlength="40" class="text" style="width:355px;" /> <span class="red">*</span>

				<label for="tags"><?php echo TAGS; ?></label>
				<input type="text" name="tags" id="tags" value="" class="text" style="width:355px;" />
			</form>

			<p align="center">
				<input class="button" type="button" value="<?php echo SAVE; ?>" onclick="saveVM();" />
			</p>
		</div>
	</div>
<?php
include(INCLUDES . 'footer.php');
?>