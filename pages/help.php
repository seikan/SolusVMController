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
$title = HELP;
include(INCLUDES . 'header.php');
?>
<div id="main">
	<a name="top"></a>
	<h1><?php echo HELP; ?></h1>
	<p>
		<ol>
			<li><a href="#1"><?php echo HOW_DO_I_GET_MY_API_KEY_AND_API_HASH; ?></a></li>
			<li><a href="#2"><?php echo WHAT_IS_MY_HOST; ?></a></li>
		</ol>
	</p>
	<p>&nbsp;</p>
	<p>
		<a name="1"><h3><?php echo HOW_DO_I_GET_MY_API_KEY_AND_API_HASH; ?></h3></a>
		<?php echo ANSWER1; ?>
		<div style="float:right"><a href="#top"><?php echo BACK_TO_TOP; ?></a></div>
	</p>
	<p>
		<a name="2"><h3><?php echo WHAT_IS_MY_HOST; ?></h3></a>
		<?php echo ANSWER2; ?>
		<div style="float:right"><a href="#top"><?php echo BACK_TO_TOP; ?></a></div>
	</p>
	<p>&nbsp;</p>
</div>
<?php include(INCLUDES . 'footer.php'); ?>