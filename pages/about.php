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
$title = 'About';
include(INCLUDES . 'header.php');
?>
<div id="main">
	<h1>SolusVMController v<?php echo SVMC_VERSION; ?></h1>
	<p>
		<?php echo SOLUSVMCONTROLLER_IS_FREE_WEB_BASED_APPLICATION_TO_CONTROL; ?>
	</p>
	<p>
		<?php echo IF_YOU_FOUND_ANY_ERRORS_OR_BUGS_IN_THIS_APPLICATION; ?>
	</p>
	<p>
		<?php echo IF_YOU_FEEL_THIS_APPLICATION_HELPS_YOU; ?>
	</p>
	<p>&nbsp;</p>
	<h1><?php echo CREDITS; ?></h1>
	<p>
		<?php echo SOLUSVMCONTROLLER_GUI_IS_MODIFIED_FROM_TEMPLATE; ?>
	</p>
	<p>&nbsp;</p>
</div>
<?php include(INCLUDES . 'footer.php'); ?>