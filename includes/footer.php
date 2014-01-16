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
?>
		<?php
		if(isset($sidebarItems) && is_array($sidebarItems)){
			echo '
			<div id="sidebar">
				<h1></h1>
				<div class="left-box">
					<ul class="sidemenu">';

			foreach($sidebarItems as $item) echo '
				<li>' . $item . '</li>';

			echo '
					</ul>
				</div>
			</div>
			';
		}
		?>
	</div>

	<div class="footer">
		<p>
			<a href="http://solusvmcontroller.com">SolusVMController</a> is Free Software released under the GNU/GPL License.
			SolusVM is registered trademark of <a href="http://www.solusvm.com/">Soluslabs</a> Ltd.
		</p>
	</div>
</body>
</html>
