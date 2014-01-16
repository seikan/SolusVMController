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

if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] != $_SESSION['user_id']) die(header('Location: ?q=404'));

$styles = '
	#main{width:610px;float:right;}';

$title = USER_LIST;

$js[] = 'includes/js/modal.js';
$css[] = 'includes/css/modal.css';


$scripts = '
	$(function(){
		$("#keyword").val("' . SEARCH . '").attr({data: "' . SEARCH . '"}).addClass("fade")
		.focus(function(){
			if($(this).val() == $(this).attr("data")) $(this).val("").removeClass("fade");
		})
		.blur(function(){
			if(!$(this).val()){
				$(this).val($(this).attr("data")).addClass("fade");
				listUser("");
			}
		})
		.keypress(function(e){
			if(e.keyCode == 13){
				listUser($(this).val());
			}
		});

		$("#sort").change(function(){
			listUser(($("#keyword").val() == $("#keyword").attr("data")) ? "" : $("#keyword").val(), $(this).val());
		});

		listUser(($("#keyword").val() == $("#keyword").attr("data")) ? "" : $("#keyword").val());
	});

	function listUser(keyword, sort){
		sort = sort || "name";

		$("#user-list").html("");
		$(".progress").show();

		$.post("?q=list-user.json", {keyword: keyword, sort: sort}, function(data){
			$(".progress").hide();

			if(!data.length){
				$("#user-list").html(\'<p class="red">' . THERE_ARE_NO_RESULTS_FOUND . '</p>\');
				return;
			}

			$.each(data, function(i, item){
				var li = $("<li />").html(\'<span></span><ul><li style="width:16px;"><img src="images/icons/user-\' + ((item.is_active == 1) ? \'active\' : \'disabled\') + \'.png" class="icon" /></li><li style="width:140px;" onclick="editUser(\' + item.id + \');">\' + item.name + \'</li><li style="width:200px;" onclick="editUser(\' + item.id + \');">\' + item.email_address + \'</li><li style="width:100px;" onclick="editUser(\' + item.id + \');">\' + $("#language option[value=\'" + item.language + "\']").text() + \'</li><li style="width:60px;" onclick="editUser(\' + item.id + \');"><span title="\' + item.total_vm + \' ' . VM_ASSIGNED . '" class="vm-total">\' + item.total_vm + \'</span></li><li style="width:20px;"><a href="?q=access&id=\' + item.id + \'"><img src="images/icons/lock.png" class="icon" title="' . LOG_IN_TO_USER_ACCOUNT . '" alt="' . LOG_IN_TO_USER_ACCOUNT . '" /></a></li><li style="width:18px;visibility:hidden;"><img src="images/icons/remove.png" class="icon" /></li></ul><div style="clear:both;"></div>\').attr("data-field", item.id);

				$("#user-list").append(li);

				li.mouseover(function(){
					li.find("ul li:last").css("visibility", "visible");
				})
				.mouseout(function(){
					li.find("ul li:last").css("visibility", "hidden");
				})
				.find(".icon").click(function(){
					$.post("?q=remove-user.json", {id: item.id}, function(data){
						if(data.status == "ok"){
							li.remove();
						}

						$("#result").html(data.message);
					}, "json");
				});
			});
		}, "json");
	}

	function editUser(id){
		$("#result").html("");
		$("#add-user-result").html("");
		$(".progress").show();

		$.post("?q=list-user.json", {keyword: id}, function(data){
			if(data.length){
				$(".progress").hide();

				$("#edit-field").show();

				$("#dialog").modal({
					onStart:function(){
						$("#dialog").find("h2").html("' . EDIT_USER . '");

						$("#userId").val(data[0].id);
						$("#name").val(data[0].name);
						$("#emailAddress").val(data[0].email_address);
						$("#language").val(data[0].language);
						$("#status").val(data[0].is_active);
					},
					onClose:function(){
						$("#dialog form").find(":input").each(function(){
							$(this).val("");
						});
					}
				});

				return;
			}

			$(".progress").hide();
			$("#result").html("' . NOT_ABLE_TO_EDIT_SELECTED_USER . '");

		}, "json");
	}

	function addUser(){
		$("#result").html("");
		$("#add-user-result").html("");
		$("#edit-field").hide();
		$("#dialog").modal({
			onStart:function(){
				$("#dialog").find("h2").html("' . NEW_USER . '");
			},
			onClose:function(){
				$("#dialog form").find(":input").each(function(){
					$(this).val("");
				});
			}
		});
	}

	function saveUser(){
		$("#add-user-result").html("");
		$("#saving").show();

		$.post("?q=save-user.json", $("#dialog form").serialize(), function(data){
			if(data.status == "ok"){
				window.location.href="?q=user";
				return;
			}

			$("#saving").hide();
			$("#add-user-result").html(data.message);
		}, "json");
	}

	function generatePassword(length){
		length = length || getRandomInt(6, 20);

		var password = "";

		var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()<>:;-_=+";

		var list = chars.split("");

		for(var i=0; i<length; i++){
			var index = Math.floor(Math.random() * list.length);
			password += list[index];
		}
		return password;
	}

	function getRandomInt(min, max){
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}
';

$sidebarItems = array(
	'<a href="javascript:;" onclick="addUser();"><img src="images/icons/user-add.png" width="16" height="16" border="0" alt="' . ADD_USER . '" title="' . ADD_USER . '" align="absMiddle" /> ' . ADD_USER . '</a>'
);

include(INCLUDES . 'header.php');
?>
	<div id="main">
		<h1><?php echo USER_LIST; ?></h1>

		<p>
			<div class="left">
				<label for="sort" style="display:inline-block;width:60px;"><?php echo SORT_BY; ?></label>
				<select id="sort">
					<option value="name"> <?php echo NAME; ?></option>
					<option value="email"> <?php echo EMAIL_ADDRESS; ?></option>
					<option value="language"> <?php echo LANGUAGE; ?></option>
					<option value="vm"> <?php echo VM_ASSIGNED; ?></option>
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
			<ul id="user-list"></ul>
		</p>
	</div>

	<div class="modal" id="dialog">
		<div>
			<h2><?php echo NEW_USER; ?></h2>
			<div id="add-user-result"></div>
			<div id="saving" style="display:none;text-align:center;"><div class="loading"></div> <?php echo SAVING; ?>...</div>
			<form>
				<input type="hidden" name="userId" id="userId" />

				<div id="edit-field" style="display:none;">
					<label for="status"><?php echo STATUS; ?></label>

					<select name="status" id="status">
						<option value="1"> <?php echo ACTIVE; ?></option>
						<option value="0"> <?php echo DISABLED; ?></option>
					</select>
				</div>

				<label for="label"><?php echo NAME; ?></label>
				<input type="text" name="name" id="name" value="" maxlength="50" class="text" style="width:355px;" /> <span class="red">*</span>

				<label for="emailAddress"><?php echo EMAIL_ADDRESS; ?></label>
				<input type="text" name="emailAddress" id="emailAddress" value="" maxlength="100" class="text" style="width:355px;" /> <span class="red">*</span>

				<label for="password"><?php echo PASSWORD; ?></label>
				<input type="text" name="password" id="password" value="" maxlength="20" class="text" style="width:355px;" /> <span class="red">*</span>
				<div style="margin:0 0 5px 0;"><a href="javascript:;" onclick="$('#password').val(generatePassword());"><img src="images/icons/refresh.png" class="icon" /> <?php echo GENERATE_PASSWORD; ?></a></div>

				<label for="language"><?php echo LANGUAGE; ?></label>
				<select name="language" id="language">
				<?php
				if($handle = opendir(LANGUAGES)){
					while(false !== ($file = readdir($handle))){
						if(strpos($file, '.php')){
							$content = file_get_contents(LANGUAGES . $file);

							if(preg_match('/LANGUAGE:([^\*]+)/s', $content, $matches)){
								echo '<option value="' . (str_replace('.php' , '', $file)) . '"> ' . trim($matches[1]) . '</option>';
							}
						}
					}
					closedir($handle);
				}
				?>
				</select>
			</form>

			<p align="center">
				<input class="button" type="button" value="<?php echo SAVE; ?>" onclick="saveUser();" />
			</p>
		</div>
	</div>
<?php
include(INCLUDES . 'footer.php');
?>