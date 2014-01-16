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

$styles = '
	#main{width:610px;float:right;}';

$title = VM_LIST;
$js[] = 'includes/js/modal.js';
$js[] = 'includes/js/tagfield.js';

$css[] = 'includes/css/modal.css';
$css[] = 'includes/css/tagfield.css';

$tags = array();
$db->connect();
$rows = $db->select('tag', '*', 'user_id=\'' . $db->escape($_SESSION['user_id']) . '\'');

if($db->affectedRows() > 0){
	foreach($rows as $row){
		$tags[] = addslashes($row['tag_name']);
	}
}

$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'label';

$scripts = '
	$(function(){
		var tags = [\'' . implode('\',\'', $tags) . '\'];
		$("#tags").tagField({ caseSensitive:false, tags:tags });

		$("#keyword").val(\'' . ((isset($_GET['search'])) ? $_GET['search'] : SEARCH) . '\').attr({data: "' . SEARCH . '"}).addClass("fade")
		.focus(function(){
			if($(this).val() == $(this).attr("data")) $(this).val("").removeClass("fade");
		})
		.blur(function(){
			if(!$(this).val()){
				$(this).val($(this).attr("data")).addClass("fade");
				listVM("");
			}
		})
		.keypress(function(e){
			if(e.keyCode == 13){
				window.location.href="?q=vm&search=" + escape($(this).val());
			}
		});

		$("#sort").change(function(){
			window.location.href = "?q=vm&search=" + (($("#keyword").val() == $("#keyword").attr("data")) ? "" : $("#keyword").val()) + "&sort=" + $(this).val();
		});

		listVM(($("#keyword").val() == $("#keyword").attr("data")) ? "" : $("#keyword").val(), $("#sort").val());
	});

	function listVM(keyword, sort){
		sort = sort || "label";

		$("#vm-list").html("");
		$(".progress").show();

		$.post("?q=list-vm.json", {keyword: keyword, sort: sort }, function(data){
			$(".progress").hide();

			if(!data.length){
				$("#vm-list").html(\'<p class="red">' . THERE_ARE_NO_RESULTS_FOUND . '</p>\');
				return;
			}

			$.each(data, function(i, item){
				var li = $("<li />").html(\'<span></span><ul><li style="width:18px;"><img src="images/icons/\' + item.status + \'.png" class="icon" /></li><li style="width:18px;display:none;"><div class="loading" style="margin:10px 0 0 0;"></div><li><li style="width:295px;" onclick="window.location.href=\\\'?q=view-vm&id=\' + item.id + \'&ref=' . rawurlencode(getPageURL()) . '\\\';">\' + item.label + \'</li><li style="width:40px;"><span class="\' + item.vz + \'">\' + item.vz + \'</span></li><li><button class="boot">' . BOOT . '</button> <button class="reboot">' . REBOOT . '</button> <button class="shutdown">' . SHUTDOWN . '</button></li><li style="display:none;"><div class="loading" style="margin:10px 0 0 100px;"></div><li></ul><div style="clear:both;"></div>\').attr("data-field", item.id);

				$("#vm-list").append(li);

				li.find(".icon").click(function(){
					var img = $(this);
					var p = img.parent();
					var n = p.next();

					p.hide();
					n.show();

					$.post("?q=status.json", {id: item.id}, function(data){
						$(img).attr("src", "images/icons/" + data.status + ".png");
						p.show();
						n.hide();
					}, "json");
				});

				li.find(".boot,.reboot,.shutdown").each(function(i, btn){
					var c = $(btn).attr("class");
					var p = $(btn).parent();
					var n = p.next();

					$(btn).click(function(){
						var img = $(this).parent().parent().find(".icon");
						var label = img.parent().next().next().next().html();

						p.hide();
						n.show();

						$.post("?q=control.json", {id: item.id, action: c}, function(data){
							p.show();
							n.hide();

							$("#result").html(data.message);
						}, "json");
					});
				});
			});
		}, "json");
	}

	function refreshStatus(){
		$("#result").html("");
		$("#vm-list .icon").each(function(i, img){
			var m = $(img).parent().parent().parent();
			var p = $(img).parent();
			var n = p.next();
			var id = m.attr("data-field");

			p.hide();
			n.show();

			$.post("?q=status.json", {id: id}, function(data){
				$(img).attr("src", "images/icons/" + data.status + ".png");
				p.show();
				n.hide();

				$("#result").html(data.message);
			}, "json");
		});
	}

	function addVM(){
		$("#result").html("");
		$("#add-vm-result").html("");
		$("#dialog").modal({
			onClose:function(){
				$("#dialog form").find(":input").each(function(){
					$(this).val("");
				});

				$(".tagItem").remove();
			}
		});
	}

	function saveVM(){
		$("#add-vm-result").html("");
		$("#saving").show();

		$.post("?q=save-vm.json", $("#dialog form").serialize(), function(data){
			if(data.status == "ok"){
				window.location.href="?q=vm";
				return;
			}

			$("#saving").hide();
			$("#add-vm-result").html(data.message);
		}, "json");
	}

';

$sidebarItems = array(
	'<a href="javascript:;" onclick="addVM();"><img src="images/icons/computer-add.png" width="16" height="16" border="0" alt="' . ADD_VM . '" title="' . ADD_VM . '" align="absMiddle" /> ' . ADD_VM . '</a>',
	'<a href="javascript:;" onclick="refreshStatus();"><img src="images/icons/refresh.png" width="16" height="16" border="0" alt="' . REFRESH_STATUS . '" title="' . REFRESH_STATUS . '" align="absMiddle" /> ' . REFRESH_STATUS . '</a>'
);

include(INCLUDES . 'header.php');
?>
	<div id="main">
		<h1><?php echo VM_LIST; ?></h1>

		<p>
			<div class="left">
				<label for="sort" style="display:inline-block;width:60px;"><?php echo SORT_BY; ?></label>
				<select id="sort">
					<option value="label"<?php if($sort=='label') echo ' selected'; ?>> <?php echo LABEL; ?></option>
					<option value="vz"<?php if($sort=='vz') echo ' selected'; ?>> <?php echo VIRTUALIZATION; ?></option>
				</select>
			</div>

			<div class="right">
				<input type="text" name="keyword" id="keyword" value="" />
			</div>
		</p>

		<div class="clear"></div>

		<p>
			<div id="result"><?php if(isset($_SESSION['result'])){ echo $_SESSION['result']; unset($_SESSION['result']); } ?></div>
			<div class="progress"></div>
			<ul id="vm-list"></ul>
		</p>
	</div>

	<div class="modal" id="dialog">
		<div>
			<h2><?php echo NEW_VM; ?></h2>
			<div id="add-vm-result"></div>
			<div id="saving" style="display:none;text-align:center;"><div class="loading"></div> <?php echo SAVING; ?>...</div>
			<form>
				<label for="label"><?php echo LABEL; ?></label>
				<input type="text" name="label" id="label" value="" maxlength="100" class="text" style="width:355px;" /> <span class="red">*</span>

				<label for="vzTypeId"><?php echo VIRTUALIZATION; ?></label>
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
							<option value="0"> http://</option>
							<option value="1"> https://</option>
						</select>
					</li>
					<li>
						<input type="text" name="host" id="host" value="" maxlength="255" class="text" style="width:203px;" /> <span class="red">*</span>
					</li>
					<li>&nbsp;</li>
					<li>
						<input type="text" name="port" id="port" value="" maxlength="5" class="text" style="width:40px;" />
					</li>
				</ul>
				<div style="clear:both;"></div>

				<label for="key"><?php echo API_KEY; ?></label>
				<input type="text" name="key" id="key" value="" maxlength="17" class="text" style="width:355px;" /> <span class="red">*</span>

				<label for="hash"><?php echo API_HASH; ?></label>
				<input type="text" name="hash" id="hash" value="" maxlength="40" class="text" style="width:355px;" /> <span class="red">*</span>

				<label for="tags"><?php echo TAGS; ?></label>
				<input type="text" name="tags" id="tags" value="" class="text" style="width:355px;" />
			</form>

			<p align="center">
				<input class="button" type="button" value="<?php echo ADD_VM; ?>" onclick="saveVM();" />
			</p>
		</div>
	</div>
<?php
include(INCLUDES . 'footer.php');
?>