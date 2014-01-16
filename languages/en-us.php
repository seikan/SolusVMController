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

/* LANGUAGE: English */

define('ALL_VMS_UNDER_ONE_ROOF', 'All VMs under one roof');


/* setup.php */
	define('SOLUSVMCONTROLLER_INSTALLATION', 'SolusVMController Installation');
	define('STEP_1_OF_3', 'Step 1 of 3');
	define('STEP_2_OF_3', 'Step 2 of 3');
	define('STEP_3_OF_3', 'Step 3 of 3');

	define('THANK_YOU_FOR_CHOOSING_SOLUSVMCONTROLLER', 'Thank you for choosing SolusVMController. Please click the next button to start installation.');
	define('NEXT', 'Next');
	define('PERFORM_PERMISSION_CHECKS', 'Perform permission checks');
	define('CHECK_PERMISSION_OF', 'Check permission of');
	define('PERFORM_COMPATIBILITIES_CHECK', 'Perform compatibilities checks');
	define('CHECK_PHP_VERSION', 'Check if PHP 5.2 or above installed');
	define('CHECK_IF_MYSQL_INSTALLED', 'Check if MySQL installed');
	define('PASS', 'pass');
	define('FAIL', 'fail');
	define('RE_CHECK', 'Re-check');
	define('MYSQL_SETTINGS', 'MySQL Settings');
	define('DATABASE_NAME', 'Database Name');
	define('UNABLE_TO_CONNECT_MYSQL_SERVER', 'Unable to connect MySQL server.');
	define('DATABASE_NOT_EXISTS', 'Database "%name%" not exists.');
	define('INSTALLTION_COMPLETED', 'Installtion completed!');
	define('YOU_CAN_NOW_LOG_IN', 'You can now log-in with username <b>%emailAddress%</b> and password <b>%password%</b>.');
	define('FINISH', 'Finish');
	define('SAVE', 'Save');
	define('SYSTEM_UPGRADE', 'System Upgrade');
	define('UPGRADE_COMPLETED', 'Upgrade Completed');
	define('SOLUSVM_CONTROLLER_HAS_BEEN_UPGRADED', 'SolusVM Controller has been upgraded to version <b>%version%</b>.');


/* header.php */
	define('USER', 'User');
	define('VM', 'VM');
	define('TAG', 'Tag');
	define('SETTINGS', 'Settings');
	define('HELP', 'Help');
	define('ABOUT', 'About');
	define('LOG_OUT', 'Log Out');
	define('WELCOME', 'Welcome');
	define('LOGGED_IN_AS', 'Logged in as');
	define('REVOKE_ACCESS', 'Revoke Access');


/* 404.php */
	define('ERROR_404_PAGE_NOT_FOUND', 'Error 404: Page not found');
	define('PAGE_NOT_FOUND', 'Page not found');
	define('OPS_THE_PAGE', 'Ops! The page you are trying to access cannot be found in our system.');


/* log-in.php */
	define('ADMINISTRATOR_PAGE', 'Administrator Page');
	define('EMAIL_ADDRESS', 'Email Address');
	define('PASSWORD', 'Password');
	define('LOG_IN', 'Log in');
	define('INVALID_USERNAME_OR_PASSWORD', 'Invalid username or password.');
	define('YOUR_ACCOUNT_HAS_BEEN_DISABLED', 'Your account has been disabled.');
	define('TOO_MANY_LOG_IN_ATTEMPTS', 'Too many log-in attempts. Your account has been disabled.');


/* log-out.php */
	define('YOU_ARE_LOGGING_OUT', 'You are logging out');


/* user.php */
	define('USER_LIST', 'User List');
	define('ADD_USER', 'Add User');
	define('EDIT_USER', 'Edit User');
	define('NEW_USER', 'New User');
	define('ACCESS_DENIED', 'Access denied.');
	define('ACCESS_USER_ACCOUNT', 'Access user account.');
	define('NOT_ABLE_TO_EDIT_SELECTED_USER', 'Not able to edit selected user.');
	define('ACTIVE', 'Active');
	define('DISABLED', 'Disabled');
	define('GENERATE_PASSWORD', 'Generate Password');
	define('VM_ASSIGNED', 'VM assigned');
	define('LOG_IN_TO_USER_ACCOUNT', 'Log in to user account');


/* remove-user.php */
	define('USER_NOT_FOUND', 'User not found.');
	define('USER_HAS_BEEN_REMOVED', 'User "%name%" has been removed.');


/* save-user.php */
	define('USER_IS_ADDED', 'User "%name%" is added.');


/* vm.php */
	define('ADD_VM', 'Add VM');
	define('REFRESH_STATUS', 'Refresh Status');
	define('VM_LIST', 'VM List');
	define('SEARCH', 'Search');
	define('NEW_VM', 'New VM');
	define('SAVING', 'Saving');
	define('LABEL', 'Label');
	define('VIRTUALIZATION', 'Virtualization');
	define('HOST', 'Host');
	define('PORT', 'Port');
	define('API_KEY', 'API Key');
	define('API_HASH', 'API Hash');
	define('TAGS', 'Tags');
	define('THERE_ARE_NO_RESULTS_FOUND', 'There are no results found.');
	define('BOOT', 'Boot');
	define('REBOOT', 'Reboot');
	define('SHUTDOWN', 'Shutdown');
	define('SORT_BY', 'Sort By');

/* view-vm.php */
	define('EDIT_VM', 'Edit VM');
	define('REMOVE_VM', 'Remove VM');
	define('VM_NOT_FOUND', 'VM Not Found');
	define('THE_VM_WITH_THIS_ID', 'The VM with this ID is not found in your account. Please make sure you have followed a correct link.');
	define('CONFORM_TO_REMOVE_THIS_VM', 'Confirm to remove this VM?');
	define('STATUS', 'Status');
	define('HOSTNAME', 'Hostname');
	define('IP_ADDRESS', 'IP Address');
	define('DISK_SPACE', 'Disk Space');
	define('MEMORY', 'Memory');
	define('BANDWIDTH', 'Bandwidth');
	define('ONLINE', 'Online');
	define('OFFLINE', 'Offline');


/* save-vm.php */
	define('SESSION_EXPIRED', 'Session expired. Please log-in again to continue.');
	define('PLEASE_PROVIDE_A_LABEL', 'Please provide a label.');
	define('LABEL_SHOULD_NOT_LONGER_THAN_100_CHARACTERS', 'Label should not longer than 100 characters in length.');
	define('PLEASE_SELECT_A_VIRTUALIZATION', 'Please select a virtualization.');
	define('INVALID_VIRTUALIZATION_SELECTED', 'Invalid virtualization selected.');
	define('A_VALID_API_KEY_SHOULD_LOOK_LIKE', 'A valid API key should look like "ABCDE-FGHIJ-KLMNO".');
	define('A_VALID_API_HASH_SHOULD_BE_40_CHARACTERS_IN_LENGTH', 'A valid API hash should be 40 characters in length.');
	define('YOU_MUST_PROVIDE_A_VALID_HOST', 'You must provide a valid host.');
	define('IS_NOT_A_VALID_PORT', '"%port%" is not a valid port number.');
	define('UNABLE_TO_ACCESS_SOLUSVM_API', 'Unable to access SolusVM API.');
	define('VM_IS_ADDED', 'VM "%name%" is addded.');
	define('API_KEY_ALREADY_EXISTS', 'API key already exists.');
	define('VM_IS_UPDATED', 'VM "%name%" is updated.');


/* remove-vm.php */
	define('VM_HAS_BEEN_REMOVED', 'VM "%name%" has been removed.');


/* status.php */
	define('CONNECTION_ERROR_WHEN_ACCESSING', 'Connection error when accessing API. Please try again later.');


/* control.php */
	define('INVALID_ACTION', 'Invalid action.');
	define('VM_HAS_BEEN_BOOTED', 'VM "%name%" has been booted.');
	define('VM_HAS_BEEN_REBOOTED', 'VM "%name%" has been rebooted.');
	define('VM_HAS_BEEN_SHUTDOWN', 'VM "%name%" has been shutdown.');


/* tag.php */
	define('ADD_TAG', 'Add Tag');
	define('TAG_LIST', 'Tag List');
	define('NEW_TAG', 'New Tag');
	define('TAG_NAME', 'Tag Name');
	define('VM_TAGGED_WITH', '%total% VM tagged with &quot;%name%&quot;');


/* save-tag.php */
	define('TAG_NAME_CANNOT_BE_BLANK', 'Tag name cannot be blank.');
	define('TAG_NAME_SHOULD_NOT_LONGER_THAN_100_CHARACTERS', 'Tag name should not longer than 100 characters in length.');
	define('TAG_NAME_ALREADY_EXISTS', 'Tag name "%name%" already exists.');
	define('COMFIRM_TO_REMOVE_THIS_TAG', 'Confirm to remove this tag?\\nThis tag already associated with a VM.');
	define('TAG_IS_ADDED', 'Tag "%name%" is added.');


/* settings.php */
	define('NAME', 'Name');
	define('CONFIRM_PASSWORD', 'Confirm Password');
	define('LANGUAGE', 'Language');

	define('NAME_CANNOT_BE_BLANK', 'Name cannot be blank.');
	define('NAME_SHOULD_NOT_LONGER_THAN_50_CHARACTERS', 'Name should not longer than 50 characters in length.');
	define('INVALID_EMAIL_ADDRESS', 'Invalid email address.');
	define('THIS_EMAIL_ADDRESS_ALREADY_IN_USE', 'This email address already in use.');
	define('PASSWORD_MUST_CONTAIN_ONLY_ALPHANUMERIC_CHARACTERS', 'Password must contain only alphanumeric characters with 6-20 long.');
	define('CONFIRM_PASSWORD_IS_NOT_MATCHED', 'Confirm password is not matched.');
	define('INVALID_LANGUAGE_SELECTED', 'Invalid language selected.');
	define('SETTINGS_IS_UPDATED', 'Settings is updated.');
	define('SAVE_SETTINGS', 'Save Settings');



/* help.php */
	define('BACK_TO_TOP', 'Back to top');
	define('HOW_DO_I_GET_MY_API_KEY_AND_API_HASH', 'How do I get my API key and API hash?');
	define('WHAT_IS_MY_HOST', 'What is my host?');
	define('ANSWER1', '1. Log in to your SolusVM contorl panel.<br />
	2. From you VM list, click "Manage".<br />
	<img src="images/screenshot001.jpg" width="335" height="172" border="0" class="screenshot" /><br /><br />
	3. Choose "API Settings" from left menu.<br />
	<img src="images/screenshot002.jpg" width="372" height="264" border="0" class="screenshot" /><br /><br />
	4. Press "Generate" button.<br />
	<img src="images/screenshot003.jpg" width="455" height="234" border="0" class="screenshot" /><br /><br />
	5. Your API key and API hash is now generated.<br />
	<img src="images/screenshot004.jpg" width="497" height="254" border="0" class="screenshot" /><br /><br />');
	define('ANSWER2', 'Please note that host is not hostname of your VM. It is the hostname of your SolusVM control panel. If your URL to log-in SolusVM is <a href="#">https://yourvmprovider.com:5656/log-in.php</a>, your host will be <b>yourvmprovider.com</b> and port is <b>5656</b>.<br />');


/* about.php */
	define('SOLUSVMCONTROLLER_IS_FREE_WEB_BASED_APPLICATION_TO_CONTROL', 'SolusVMController is free web based application to control all your SolusVM based VMs under one interface. This application access your VM using API provided by <a href="http://solusvm.com" target="_blank">Soluslabs</a>.
	Please make sure your VM provider has enabled API access in order to use this application.');
	define('IF_YOU_FOUND_ANY_ERRORS_OR_BUGS_IN_THIS_APPLICATION', 'If you found any errors or bugs in this application, feel free to contact us at <a href="http://solusvmcontroller.com/contact" target="_blank">here</a>. Latest version of SolusVMController is available at <a href="http://solusvmcontroller.com">http://solusvmcontroller.com</a>.');
	define('IF_YOU_FEEL_THIS_APPLICATION_HELPS_YOU', 'If you feel this application helps you, you may consider to send me donation <a href="http://goo.gl/hMiiq" target="_blank">here</a>.');
	define('CREDITS', 'Credits');
	define('SOLUSVMCONTROLLER_GUI_IS_MODIFIED_FROM_TEMPLATE', 'SolusVMController GUI is modified from template provided by <a href="http://styleshout.com" target="_blank">Styleshout</a>. All icons are modified from <a href="http://led24.de/iconset/" target="_blank">LED icon set</a>.');
?>