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

/* LANGUAGE: 簡體中文 */

define('ALL_VMS_UNDER_ONE_ROOF', 'All VMs under one roof');


/* setup.php */
	define('SOLUSVMCONTROLLER_INSTALLATION', '安裝 SolusVMController');
	define('STEP_1_OF_3', '步驟1之3');
	define('STEP_2_OF_3', '步驟2之3');
	define('STEP_3_OF_3', '步驟3之3');

	define('THANK_YOU_FOR_CHOOSING_SOLUSVMCONTROLLER', '謝謝您選用SolusVMController。請點擊“下一步”開始安裝。');
	define('NEXT', '下一步');
	define('PERFORM_PERMISSION_CHECKING', '進行權限檢查');
	define('CHECK_PERMISSION_OF', '查看權限：');
	define('PERFORM_COMPABILITIES_CHECK', '進行相容性檢查');
	define('CHECK_PHP_VERSION', '檢查是否安裝了 PHP 5.2 或以上版本');
	define('CHECK_IF_MYSQL_INSTALLED', '檢查是否安裝了 MySQL');
	define('PASS', '通過');
	define('FAIL', '失敗');
	define('RE_CHECK', '重新檢查');
	define('MYSQL_SETTINGS', 'MySQL設置');
	define('DATABASE_NAME', '數據庫名字');
	define('UNABLE_TO_CONNECT_MYSQL_SERVER', '無法連接MySQL服務器。');
	define('DATABASE_NOT_EXISTS', '數據庫 "%name%" 不存在。');
	define('INSTALLTION_COMPLETED', '安裝完成！');
	define('YOU_CAN_NOW_LOGIN', '您現在將可以以用戶 <b>%emailAddress%</b> 以及密碼 <b>%password%</b> 登錄系統。');
	define('FINISH', '完成');
	define('SAVE', '保存');
	define('SYSTEM_UPGRADE', '系統升級');
	define('UPGRADE_COMPLETED', '升級完畢');
	define('SOLUSVM_CONTROLLER_HAS_BEEN_UPGRADED', 'SolusVM Controller 已經成功升級至 <b>%version%</b> 版本。');


/* header.php */
	define('USER', '用戶');
	define('VM', 'VM');
	define('TAG', '標簽');
	define('SETTINGS', '設置');
	define('HELP', '幫助');
	define('ABOUT', '關于');
	define('LOG_OUT', '登出');
	define('WELCOME', '歡迎');
	define('LOGGED_IN_AS', '已登錄爲');
	define('REVOKE_ACCESS', '取消資格');


/* 404.php */
	define('ERROR_404_PAGE_NOT_FOUND', '錯誤 404： 網頁不存在');
	define('PAGE_NOT_FOUND', '網頁不存在');
	define('OPS_THE_PAGE', '很抱歉！您所浏覽的網頁並沒有列在我們的系統當中。');


/* log-in.php */
	define('ADMINISTRATOR_PAGE', '管理主頁');
	define('EMAIL_ADDRESS', '電子信箱');
	define('PASSWORD', '密碼');
	define('LOG_IN', '登錄');
	define('INVALID_USERNAME_OR_PASSWORD', '帳戶名字或用戶密碼不正確。');
	define('YOUR_ACCOUNT_HAS_BEEN_DISABLED', '這個帳戶已經被凍結了。');
	define('TOO_MANY_LOG_IN_ATTEMPTS', '太多登錄嘗試，這個帳戶已被凍結。');


/* log-out.php */
	define('YOU_ARE_LOGGING_OUT', '登出中');


/* user.php */
	define('USER_LIST', '用戶名單');
	define('ADD_USER', '新增用戶');
	define('EDIT_USER', '編輯用戶');
	define('NEW_USER', '新用戶');
	define('ACCESS_DENIED', '訪問被拒絕。');
	define('ACCESS_USER_ACCOUNT', '接管用戶帳戶');
	define('NOT_ABLE_TO_EDIT_SELECTED_USER', '無法編輯用戶。');
	define('ACTIVE', '活躍');
	define('DISABLED', '停用');
	define('GENERATE_PASSWORD', '産生密碼');
	define('VM_ASSIGNED', 'VM');
	define('LOG_IN_TO_USER_ACCOUNT', '登錄用戶帳戶');


/* remove-user.php */
	define('USER_NOT_FOUND', '用戶不存在。');
	define('USER_HAS_BEEN_REMOVED', '用戶 "%name%" 已被刪除了。');


/* save-user.php */
	define('USER_IS_ADDED', '添加了新用戶 "%name%"。');


/* vm.php */
	define('ADD_VM', '新增VM');
	define('REFRESH_STATUS', '刷新狀態');
	define('VM_LIST', 'VM名單');
	define('SEARCH', '搜索');
	define('NEW_VM', '新VM');
	define('SAVING', '保存中');
	define('LABEL', '名字');
	define('VIRTUALIZATION', '虛擬環境');
	define('HOST', '主機');
	define('PORT', '端口');
	define('API_KEY', 'API Key');
	define('API_HASH', 'API Hash');
	define('TAGS', '標簽');
	define('THERE_ARE_NO_RESULTS_FOUND', '沒有任何結果。');
	define('BOOT', '啓動');
	define('REBOOT', '重啓');
	define('SHUTDOWN', '關機');
	define('SORT_BY', '排序方式');

/* view-vm.php */
	define('EDIT_VM', '編輯主機');
	define('REMOVE_VM', '刪除主機');
	define('VM_NOT_FOUND', '找不到主機');
	define('THE_VM_WITH_THIS_ID', '在您的帳戶裏找不到這台VM。');
	define('CONFORM_TO_REMOVE_THIS_VM', '確定刪除這台VM嗎？');
	define('STATUS', '狀態');
	define('HOSTNAME', '主機名字');
	define('IP_ADDRESS', 'IP地址');
	define('DISK_SPACE', '硬碟空間');
	define('MEMORY', '內存容量');
	define('BANDWIDTH', '網絡流量');
	define('ONLINE', '上線');
	define('OFFLINE', '離線');


/* save-vm.php */
	define('SESSION_EXPIRED', '請再重新登錄。');
	define('PLEASE_PROVIDE_A_LABEL', '請提供VM名字。');
	define('LABEL_SHOULD_NOT_LONGER_THAN_100_CHARACTERS', 'VM名字不能超過100字節。');
	define('PLEASE_SELECT_A_VIRTUALIZATION', '請選擇虛擬環境。');
	define('INVALID_VIRTUALIZATION_SELECTED', '不合法的虛擬環境。');
	define('A_VALID_API_KEY_SHOULD_LOOK_LIKE', '正確的的API key是“ABCDE-FGHIJ-KLMNO”格式的。');
	define('A_VALID_API_HASH_SHOULD_BE_40_CHARACTERS_IN_LENGTH', '正確的API hash應有40字節的長度。');
	define('YOU_MUST_PROVIDE_A_VALID_HOST', '請提供有效的主機地址。');
	define('IS_NOT_A_VALID_PORT', '“%port%”不是有效的端口。');
	define('UNABLE_TO_ACCESS_SOLUSVM_API', '無法訪問 SolusVM API。');
	define('VM_IS_ADDED', '新增了VM "%name%"。');
	define('API_KEY_ALREADY_EXISTS', 'API key 已經存在了。');
	define('VM_IS_UPDATED', 'VM "%name%" 已被更新。');


/* remove-vm.php */
	define('VM_HAS_BEEN_REMOVED', 'VM "%name%" 已被刪除了。');


/* status.php */
	define('CONNECTION_ERROR_WHEN_ACCESSING', '無法連接API。請稍候再試。');


/* control.php */
	define('INVALID_ACTION', '不合法的行動。');
	define('VM_HAS_BEEN_BOOTED', 'VM "%name%" 已經啓動。');
	define('VM_HAS_BEEN_REBOOTED', 'VM "%name%" 已經重啓。');
	define('VM_HAS_BEEN_SHUTDOWN', 'VM "%name%" 已經關機。');


/* tag.php */
	define('ADD_TAG', '新增標簽。');
	define('TAG_LIST', '標簽名單');
	define('NEW_TAG', '新標簽');
	define('TAG_NAME', '標簽名字');
	define('VM_TAGGED_WITH', '一共 %total% 台 VM 被標上 &quot;%name%&quot;');


/* save-tag.php */
	define('TAG_NAME_CANNOT_BE_BLANK', '標簽名字不可以留白。');
	define('TAG_NAME_SHOULD_NOT_LONGER_THAN_100_CHARACTERS', '標簽名字不能超過100字節。');
	define('TAG_NAME_ALREADY_EXISTS', '標簽名字 "%name%" 已經存在。');
	define('COMFIRM_TO_REMOVE_THIS_TAG', '確定刪除這個標簽嗎？\\n這個標簽已經被標在VM上了。');
	define('TAG_IS_ADDED', '標簽 "%name%" 已經被刪除了。.');


/* settings.php */
	define('NAME', '名字');
	define('CONFIRM_PASSWORD', '確認密碼');
	define('LANGUAGE', '語言');

	define('NAME_CANNOT_BE_BLANK', '名字不可以留白。');
	define('NAME_SHOULD_NOT_LONGER_THAN_50_CHARACTERS', '名字不能超過50字節。');
	define('INVALID_EMAIL_ADDRESS', '電子信箱不合法。');
	define('THIS_EMAIL_ADDRESS_ALREADY_IN_USE', '這個電子信箱已被使用了。');
	define('PASSWORD_MUST_CONTAIN_ONLY_ALPHANUMERIC_CHARACTERS', '密碼必須是6至20字節的英文字母。');
	define('CONFIRM_PASSWORD_IS_NOT_MATCHED', '確認密碼不相符。');
	define('INVALID_LANGUAGE_SELECTED', '語言選擇不合法。');
	define('SETTINGS_IS_UPDATED', '設置已被更新了。');
	define('SAVE_SETTINGS', '保存設置');



/* help.php */
	define('BACK_TO_TOP', '回到頂端');
	define('HOW_DO_I_GET_MY_API_KEY_AND_API_HASH', '如何獲取我的API key和API hash？');
	define('WHAT_IS_MY_HOST', '我的主機名字是什麽？');
	define('ANSWER1', '1. 登錄您的SolusVM管理界面。<br />
	2. 從您的VM列表中，點擊“Manage”。<br />
	<img src="images/screenshot001.jpg" width="335" height="172" border="0" class="screenshot" /><br /><br />
	3. 在左邊菜單中選擇“API Settings”。<br />
	<img src="images/screenshot002.jpg" width="372" height="264" border="0" class="screenshot" /><br /><br />
	4. 點擊“Generate”按鈕。<br />
	<img src="images/screenshot003.jpg" width="455" height="234" border="0" class="screenshot" /><br /><br />
	5. 您的API key以及API hash已經生成了。<br />
	<img src="images/screenshot004.jpg" width="497" height="254" border="0" class="screenshot" /><br /><br />');
	define('ANSWER2', '這裏指的不是您的VM主機名字，而是您的SolusVM管理界面的主機名字。如果您的SolusVM登錄網址是<a href="#">https://yourvmprovider.com:5656/log-in.php</a>, 那您的主機名字就是<b>yourvmprovider.com</b>而端口則是<b>5656</b>。<br />');


/* about.php */
	define('SOLUSVMCONTROLLER_IS_FREE_WEB_BASED_APPLICATION_TO_CONTROL', 'SolusVMController爲一個免費的VM控制系統。它可以操控SolusVM運行的任何VM主機。這系統只是單純地使用<a href="http://solusvm.com" target="_blank">Soluslabs</a>所提供的API操作。在使用本系統前，請確認您的VM供應商給予您API的權限。');
	define('IF_YOU_FOUND_ANY_ERRORS_OR_BUGS_IN_THIS_APPLICATION', '如果您發現任何錯誤，歡迎點擊<a href="http://solusvmcontroller.com/contact" target="_blank">這裏</a>與我們聯系。最新版本的SolusVMController可在<a href="http://solusvmcontroller.com">http://solusvmcontroller.com</a>找到。');
	define('IF_YOU_FEEL_THIS_APPLICATION_HELPS_YOU', '如果您覺得這個系統給您獲益良多，請點擊<a href="http://goo.gl/hMiiq" target="_blank">這裏</a>捐助這項工程。');
	define('CREDITS', '感謝');
	define('SOLUSVMCONTROLLER_GUI_IS_MODIFIED_FROM_TEMPLATE', 'SolusVMController的操作界面更改自<a href="http://styleshout.com" target="_blank">Styleshout</a>所提供的免費模板。系統圖標改自<a href="http://led24.de/iconset/" target="_blank">LED圖標包</a>。');
?>