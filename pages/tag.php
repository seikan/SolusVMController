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

$title = TAG;

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
				listTag("");
			}
		})
		.keypress(function(e){
			if(e.keyCode == 13){
				listTag($(this).val());
			}
		});

		$("#sort").change(function(){
			listTag(($("#keyword").val() == $("#keyword").attr("data")) ? "" : $("#keyword").val(), $(this).val());
		});

		listTag(($("#keyword").val() == $("#keyword").attr("data")) ? "" : $("#keyword").val());
	});

	function listTag(keyword, sort){
		sort = sort || "name";

		$("#tag-list").html("");
		$(".progress").show();

		$.post("?q=list-tag", { keyword: keyword, sort: sort }, function(data){
			$(".progress").hide();

			if(!data.length){
				$("#tag-list").html(\'<p class="red">' . THERE_ARE_NO_RESULTS_FOUND . '</p>\');
				return;
			}

			$.each(data, function(i, item){
				var li = $("<li />").html(\'<div>\' + item.tag_name + \'</div> <input type="text" value="\' + item.tag_name + \'" maxlength="100" /> <span title="\' + ("' . VM_TAGGED_WITH . '").replace("%total%", item.total).replace("%name%", item.tag_name) + \'" onclick="window.location.href=\\\'?q=vm&search=\' + escape(\'tag:\' + item.tag_name) + \'\\\';" style="cursor:pointer;">\' + item.total + \'</span> <a href="javascript:;">x</a>\');

				$("#tag-list").append(li);

				li.children("div").click(function(){
					var span = $("<span />").css({position:"absolute",top:"-999px",left:"-999px",fontSize:"1em"});
					$("body").append(span);

					var div = $(this);

					div.hide();

					li.children("input").css("width", div.css("width")).show().select()
					.keyup(function(e){
						span.html($(this).val());
						$(this).width(span.width()+10);

						if(e.keyCode == 13){
							$("html").focus();
						}
					})
					.blur(function(){
						var input = $(this);

						if(!input.val()) input.val($(div).html());

						$(div).html(input.val());

						$.post("?q=save-tag.json", {id: item.id, tagName: $(this).val()}, function(data){
							if(data.status != "ok"){
								$("#result").html(data.message);
								input.val($(div).html());
							}
						}, "json");

						span.remove();
						input.hide().unbind("keyup").unbind("blur");
						div.show();
					});
				});

				li.children("a").click(function(){
					var a = $(this);
					if(a.prev().html() > 0){
						if(!confirm("' . COMFIRM_TO_REMOVE_THIS_TAG . '")) return false;
					}

					$.post("?q=remove-tag.json", {id: item.id}, function(data){
						if(data.status != "ok"){
							$("#result").html(data.message);
							return false;
						}
						a.parent().remove();
					}, "json");
				});
			});
		}, "json");
	}

	function addTag(){
		$("#result").html("");
		$("#add-tag-result").html("");
		$("#dialog").modal({
			onClose:function(){
				$("#dialog form").find(":input").each(function(){
					$(this).val("");
				});

				$(".tagItem").remove();
			}
		});
	}

	function saveTag(){
		$("#add-tag-result").html("");
		$("#saving").show();

		$.post("?q=save-tag", $("#dialog form").serialize(), function(data){
			if(data.status == "ok"){
				window.location.href="?q=tag";
				return;
			}

			$("#saving").hide();
			$("#add-tag-result").html(data.message);
		}, "json");
	}

';

$sidebarItems = array(
	'<a href="javascript:;" onclick="addTag();"><img src="images/icons/tag-add.png" width="16" height="16" border="0" alt="' . ADD_TAG . '" title="' . ADD_TAG . '" align="absMiddle" /> ' . ADD_TAG . '</a>'
);

include(INCLUDES . 'header.php');
?>
	<div id="main">
		<h1><?php echo TAG_LIST; ?></h1>

		<p>
			<div class="left">
				<label for="sort" style="display:inline-block;width:60px;"><?php echo SORT_BY; ?></label>
				<select id="sort">
					<option value="name"> <?php echo TAG_NAME; ?></option>
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
			<ul id="tag-list"></ul>
		</p>
	</div>

	<div class="modal" id="dialog">
		<div>
			<h2><?php echo NEW_TAG; ?></h2>
			<div id="add-tag-result"></div>
			<div id="saving" style="display:none;text-align:center;"><div class="loading"></div> <?php echo SAVING; ?>...</div>
			<form onsubmit="return false;">
				<label for="tagName"><?php echo TAG_NAME; ?></label>
				<input type="text" name="tagName" id="tagName" value="" maxlength="100" class="text" style="width:355px;" /> <span class="red">*</span>
			</form>

			<p align="center">
				<input class="button" type="button" value="<?php echo ADD_TAG; ?>" onclick="saveTag();" />
			</p>
		</div>
	</div>
<?php
include(INCLUDES . 'footer.php');
?>