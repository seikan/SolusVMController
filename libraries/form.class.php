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

class Form {
	private $_POST, $_GET;

	public function __construct($prg=false){
		// Clean up GET and POST values to prevent XSS
		$this->_GET = $this->strip($_GET);
		$this->_POST = $this->strip($_POST);

		// Convert POST into SESSION for Post/Redirect/Get pattern (PRG)
		if($prg){
			// Start session
			if(!session_id()) session_start();

			$uid = ($this->isPost()) ? md5(serialize($this->_POST)) : $this->get('__form_uid');

			if(!empty($this->_POST)){
				$_SESSION[$uid . '_POST'] = $this->_POST;
				die(header('Location: ' . $this->getURL() . ((parse_url($this->getURL(), PHP_URL_QUERY)) ? '&' : '?') . '__form_uid=' . $uid));
			}

			if(isset($_SESSION[$uid . '_POST'])){
				$this->_POST = $_SESSION[$uid . '_POST'];
				unset($_SESSION[$uid . '_POST']);
			}
		}
	}

	public function __destruct(){}

	public function isPost(){
		return (empty($this->_POST)) ? false : true;
	}

	public function post($name, $default='', $callback=null){
		return (isset($this->_POST[$name])) ? ((function_exists($callback)) ? $callback($this->_POST[$name]) : $this->_POST[$name]) : $default;
	}

	public function get($name, $default='', $callback=null){
		return (isset($this->_GET[$name])) ? ((function_exists($callback)) ? $callback($this->_GET[$name]) : $this->_GET[$name]) : $default;
	}

	private function strip($s){
		return (is_array($s)) ? array_map(array($this, 'strip'), $s) : htmlspecialchars((get_magic_quotes_gpc()) ? stripslashes($s) : $s, ENT_COMPAT, 'UTF-8');
	}

	private function getURL(){
		$s = empty($_SERVER['HTTPS']) ? '' : ($_SERVER['HTTPS'] == 'on') ? 's' : '';
		$protocol = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0, strpos(strtolower($_SERVER['SERVER_PROTOCOL']), '/')) . $s;
		$port = ($_SERVER['SERVER_PORT'] == '80') ? '' : (':' . $_SERVER['SERVER_PORT']);
		return $protocol . '://' . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	}
}
?>