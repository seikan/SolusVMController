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

unset($_SESSION['admin_id']);
unset($_SESSION['user_id']);
unset($_SESSION['name']);
unset($_SESSION['language']);
unset($_SESSION['status']);

$title = LOG_OUT;
$metaRedirect = '?q=log-in';
include(INCLUDES . 'header.php');
?>
<div id="main">
	<h1><?php echo LOG_OUT; ?></h1>
	<p class="green">
		<?php echo YOU_ARE_LOGGING_OUT . ' ...'; ?>
	</p>
	<p>&nbsp;</p>
</div>
<?php include(INCLUDES . 'footer.php'); ?>