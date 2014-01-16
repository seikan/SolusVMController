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

/* LANGUAGE: 简体中文 */

define('ALL_VMS_UNDER_ONE_ROOF', 'All VMs under one roof');


/* setup.php */
	define('SOLUSVMCONTROLLER_INSTALLATION', '安装 SolusVMController');
	define('STEP_1_OF_3', '步骤1之3');
	define('STEP_2_OF_3', '步骤2之3');
	define('STEP_3_OF_3', '步骤3之3');

	define('THANK_YOU_FOR_CHOOSING_SOLUSVMCONTROLLER', '谢谢您选用SolusVMController。请点击“下一步”开始安装。');
	define('NEXT', '下一步');
	define('PERFORM_PERMISSION_CHECKING', '进行权限检查');
	define('CHECK_PERMISSION_OF', '查看权限：');
	define('PERFORM_COMPABILITIES_CHECK', '进行相容性检查');
	define('CHECK_PHP_VERSION', '检查是否安装了 PHP 5.2 或以上版本');
	define('CHECK_IF_MYSQL_INSTALLED', '检查是否安装了 MySQL');
	define('PASS', '通过');
	define('FAIL', '失败');
	define('RE_CHECK', '重新检查');
	define('MYSQL_SETTINGS', 'MySQL设置');
	define('DATABASE_NAME', '数据库名字');
	define('UNABLE_TO_CONNECT_MYSQL_SERVER', '无法连接MySQL服务器。');
	define('DATABASE_NOT_EXISTS', '数据库 "%name%" 不存在。');
	define('INSTALLTION_COMPLETED', '安装完成！');
	define('YOU_CAN_NOW_LOGIN', '您现在将可以以用户 <b>%emailAddress%</b> 以及密码 <b>%password%</b> 登录系统。');
	define('FINISH', '完成');
	define('SAVE', '保存');
	define('SYSTEM_UPGRADE', '系统升级');
	define('UPGRADE_COMPLETED', '升级完毕');
	define('SOLUSVM_CONTROLLER_HAS_BEEN_UPGRADED', 'SolusVM Controller 已经成功升级至 <b>%version%</b> 版本。');


/* header.php */
	define('USER', '用户');
	define('VM', 'VM');
	define('TAG', '标签');
	define('SETTINGS', '设置');
	define('HELP', '帮助');
	define('ABOUT', '关于');
	define('LOG_OUT', '登出');
	define('WELCOME', '欢迎');
	define('LOGGED_IN_AS', '已登录为');
	define('REVOKE_ACCESS', '取消资格');


/* 404.php */
	define('ERROR_404_PAGE_NOT_FOUND', '错误 404： 网页不存在');
	define('PAGE_NOT_FOUND', '网页不存在');
	define('OPS_THE_PAGE', '很抱歉！您所浏览的网页并没有列在我们的系统当中。');


/* log-in.php */
	define('ADMINISTRATOR_PAGE', '管理主页');
	define('EMAIL_ADDRESS', '电子信箱');
	define('PASSWORD', '密码');
	define('LOG_IN', '登录');
	define('INVALID_USERNAME_OR_PASSWORD', '帐户名字或用户密码不正确。');
	define('YOUR_ACCOUNT_HAS_BEEN_DISABLED', '这个帐户已经被冻结了。');
	define('TOO_MANY_LOG_IN_ATTEMPTS', '太多登录尝试，这个帐户已被冻结。');


/* log-out.php */
	define('YOU_ARE_LOGGING_OUT', '登出中');


/* user.php */
	define('USER_LIST', '用户名单');
	define('ADD_USER', '新增用户');
	define('EDIT_USER', '编辑用户');
	define('NEW_USER', '新用户');
	define('ACCESS_DENIED', '访问被拒绝。');
	define('ACCESS_USER_ACCOUNT', '接管用户帐户');
	define('NOT_ABLE_TO_EDIT_SELECTED_USER', '无法编辑用户。');
	define('ACTIVE', '活跃');
	define('DISABLED', '停用');
	define('GENERATE_PASSWORD', '产生密码');
	define('VM_ASSIGNED', 'VM');
	define('LOG_IN_TO_USER_ACCOUNT', '登录用户帐户');


/* remove-user.php */
	define('USER_NOT_FOUND', '用户不存在。');
	define('USER_HAS_BEEN_REMOVED', '用户 "%name%" 已被删除了。');


/* save-user.php */
	define('USER_IS_ADDED', '添加了新用户 "%name%"。');


/* vm.php */
	define('ADD_VM', '新增VM');
	define('REFRESH_STATUS', '刷新状态');
	define('VM_LIST', 'VM名单');
	define('SEARCH', '搜索');
	define('NEW_VM', '新VM');
	define('SAVING', '保存中');
	define('LABEL', '名字');
	define('VIRTUALIZATION', '虚拟环境');
	define('HOST', '主机');
	define('PORT', '端口');
	define('API_KEY', 'API Key');
	define('API_HASH', 'API Hash');
	define('TAGS', '标签');
	define('THERE_ARE_NO_RESULTS_FOUND', '没有任何结果。');
	define('BOOT', '启动');
	define('REBOOT', '重启');
	define('SHUTDOWN', '关机');
	define('SORT_BY', '排序方式');

/* view-vm.php */
	define('EDIT_VM', '编辑主机');
	define('REMOVE_VM', '删除主机');
	define('VM_NOT_FOUND', '找不到主机');
	define('THE_VM_WITH_THIS_ID', '在您的帐户里找不到这台VM。');
	define('CONFORM_TO_REMOVE_THIS_VM', '确定删除这台VM吗？');
	define('STATUS', '状态');
	define('HOSTNAME', '主机名字');
	define('IP_ADDRESS', 'IP地址');
	define('DISK_SPACE', '硬碟空间');
	define('MEMORY', '内存容量');
	define('BANDWIDTH', '网络流量');
	define('ONLINE', '上线');
	define('OFFLINE', '离线');


/* save-vm.php */
	define('SESSION_EXPIRED', '请再重新登录。');
	define('PLEASE_PROVIDE_A_LABEL', '请提供VM名字。');
	define('LABEL_SHOULD_NOT_LONGER_THAN_100_CHARACTERS', 'VM名字不能超过100字节。');
	define('PLEASE_SELECT_A_VIRTUALIZATION', '请选择虚拟环境。');
	define('INVALID_VIRTUALIZATION_SELECTED', '不合法的虚拟环境。');
	define('A_VALID_API_KEY_SHOULD_LOOK_LIKE', '正确的的API key是“ABCDE-FGHIJ-KLMNO”格式的。');
	define('A_VALID_API_HASH_SHOULD_BE_40_CHARACTERS_IN_LENGTH', '正确的API hash应有40字节的长度。');
	define('YOU_MUST_PROVIDE_A_VALID_HOST', '请提供有效的主机地址。');
	define('IS_NOT_A_VALID_PORT', '“%port%”不是有效的端口。');
	define('UNABLE_TO_ACCESS_SOLUSVM_API', '无法访问 SolusVM API。');
	define('VM_IS_ADDED', '新增了VM "%name%"。');
	define('API_KEY_ALREADY_EXISTS', 'API key 已经存在了。');
	define('VM_IS_UPDATED', 'VM "%name%" 已被更新。');


/* remove-vm.php */
	define('VM_HAS_BEEN_REMOVED', 'VM "%name%" 已被删除了。');


/* status.php */
	define('CONNECTION_ERROR_WHEN_ACCESSING', '无法连接API。请稍候再试。');


/* control.php */
	define('INVALID_ACTION', '不合法的行动。');
	define('VM_HAS_BEEN_BOOTED', 'VM "%name%" 已经启动。');
	define('VM_HAS_BEEN_REBOOTED', 'VM "%name%" 已经重启。');
	define('VM_HAS_BEEN_SHUTDOWN', 'VM "%name%" 已经关机。');


/* tag.php */
	define('ADD_TAG', '新增标签。');
	define('TAG_LIST', '标签名单');
	define('NEW_TAG', '新标签');
	define('TAG_NAME', '标签名字');
	define('VM_TAGGED_WITH', '一共 %total% 台 VM 被标上 &quot;%name%&quot;');


/* save-tag.php */
	define('TAG_NAME_CANNOT_BE_BLANK', '标签名字不可以留白。');
	define('TAG_NAME_SHOULD_NOT_LONGER_THAN_100_CHARACTERS', '标签名字不能超过100字节。');
	define('TAG_NAME_ALREADY_EXISTS', '标签名字 "%name%" 已经存在。');
	define('COMFIRM_TO_REMOVE_THIS_TAG', '确定删除这个标签吗？\\n这个标签已经被标在VM上了。');
	define('TAG_IS_ADDED', '标签 "%name%" 已经被删除了。.');


/* settings.php */
	define('NAME', '名字');
	define('CONFIRM_PASSWORD', '确认密码');
	define('LANGUAGE', '语言');

	define('NAME_CANNOT_BE_BLANK', '名字不可以留白。');
	define('NAME_SHOULD_NOT_LONGER_THAN_50_CHARACTERS', '名字不能超过50字节。');
	define('INVALID_EMAIL_ADDRESS', '电子信箱不合法。');
	define('THIS_EMAIL_ADDRESS_ALREADY_IN_USE', '这个电子信箱已被使用了。');
	define('PASSWORD_MUST_CONTAIN_ONLY_ALPHANUMERIC_CHARACTERS', '密码必须是6至20字节的英文字母。');
	define('CONFIRM_PASSWORD_IS_NOT_MATCHED', '确认密码不相符。');
	define('INVALID_LANGUAGE_SELECTED', '语言选择不合法。');
	define('SETTINGS_IS_UPDATED', '设置已被更新了。');
	define('SAVE_SETTINGS', '保存设置');



/* help.php */
	define('BACK_TO_TOP', '回到顶端');
	define('HOW_DO_I_GET_MY_API_KEY_AND_API_HASH', '如何获取我的API key和API hash？');
	define('WHAT_IS_MY_HOST', '我的主机名字是什么？');
	define('ANSWER1', '1. 登录您的SolusVM管理界面。<br />
	2. 从您的VM列表中，点击“Manage”。<br />
	<img src="images/screenshot001.jpg" width="335" height="172" border="0" class="screenshot" /><br /><br />
	3. 在左边菜单中选择“API Settings”。<br />
	<img src="images/screenshot002.jpg" width="372" height="264" border="0" class="screenshot" /><br /><br />
	4. 点击“Generate”按钮。<br />
	<img src="images/screenshot003.jpg" width="455" height="234" border="0" class="screenshot" /><br /><br />
	5. 您的API key以及API hash已经生成了。<br />
	<img src="images/screenshot004.jpg" width="497" height="254" border="0" class="screenshot" /><br /><br />');
	define('ANSWER2', '这里指的不是您的VM主机名字，而是您的SolusVM管理界面的主机名字。如果您的SolusVM登录网址是<a href="#">https://yourvmprovider.com:5656/log-in.php</a>, 那您的主机名字就是<b>yourvmprovider.com</b>而端口则是<b>5656</b>。<br />');


/* about.php */
	define('SOLUSVMCONTROLLER_IS_FREE_WEB_BASED_APPLICATION_TO_CONTROL', 'SolusVMController为一个免费的VM控制系统。它可以操控SolusVM运行的任何VM主机。这系统只是单纯地使用<a href="http://solusvm.com" target="_blank">Soluslabs</a>所提供的API操作。在使用本系统前，请确认您的VM供应商给予您API的权限。');
	define('IF_YOU_FOUND_ANY_ERRORS_OR_BUGS_IN_THIS_APPLICATION', '如果您发现任何错误，欢迎点击<a href="http://solusvmcontroller.com/contact" target="_blank">这里</a>与我们联系。最新版本的SolusVMController可在<a href="http://solusvmcontroller.com">http://solusvmcontroller.com</a>找到。');
	define('IF_YOU_FEEL_THIS_APPLICATION_HELPS_YOU', '如果您觉得这个系统给您获益良多，请点击<a href="http://goo.gl/hMiiq" target="_blank">这里</a>捐助这项工程。');
	define('CREDITS', '感谢');
	define('SOLUSVMCONTROLLER_GUI_IS_MODIFIED_FROM_TEMPLATE', 'SolusVMController的操作界面更改自<a href="http://styleshout.com" target="_blank">Styleshout</a>所提供的免费模板。系统图标改自<a href="http://led24.de/iconset/" target="_blank">LED图标包</a>。');
?>