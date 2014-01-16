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

// Preset PHP settings
error_reporting(E_ALL);
ini_set('display_errors', 0);
date_default_timezone_set('UTC');

// Define this as parent file
define('INDEX', 1);

// Define root directory
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);

// Define folders directory
define('INCLUDES', ROOT . 'includes' . DS);
define('LANGUAGES', ROOT . 'languages' . DS);
define('LIBRARIES', ROOT . 'libraries' . DS);
define('PAGES', ROOT . 'pages' . DS);

// Configuration
file_exists(ROOT . 'configuration.php') or die('Cannot find "configuration.php".');
require_once(ROOT . 'configuration.php');

// Common functions
require_once(INCLUDES . 'functions.php');

// Error handler
require_once(INCLUDES . 'error-handler.php');

// Form class
require_once(LIBRARIES . 'form.class.php');
$form = new Form(true);

// MySQL class
require_once(LIBRARIES . 'mysql.class.php');

// Start session
if(!session_id()) session_start();

// Check installation status
if(!defined('INSTALLED')){
	file_exists(ROOT . 'setup.php') or die('Cannot find "setup.php". Installation aborted.');
	require_once(ROOT . 'setup.php');
	die;
}

// Check for upgrade
if(file_exists(ROOT . 'setup.php')){
	if(defined('SVMC_VERSION')){
		// Get setup version
		$setup = file_get_contents(ROOT . 'setup.php');

		if(preg_match('/version = \'([^\']+)/', $setup, $matches)){
			if($matches[1] > SVMC_VERSION){
				define('UPGRADE', 1);

				require_once(ROOT . 'setup.php');
				die;
			}
		}
	}
	die('Please remove setup.php for sucurity reason.');
}

$db = new MySQL($config['dbHost'], $config['dbUser'], $config['dbPass'], $config['dbName']);

// Include language file
$languageCode = (isset($_SESSION['language'])) ? $_SESSION['language'] : $config['language'];
if(!file_exists(LANGUAGES . $languageCode . '.php')) die('Language file not found.');
require_once(LANGUAGES . $languageCode . '.php');

// Get requested page
$q = isset($_GET['q']) ? $_GET['q'] : 'log-in';
if(strpos($q, '.')) $q = substr($q, 0, strrpos($q, '.'));
$q = ($q == 'index') ? 'log-in' : $q;

$showMenu = 1;

// Validate pages to prevent file inclusion vulnerability
$pages = array();

if($handle = opendir(PAGES)){
	while(($entry = readdir($handle)) !== false){
		if(substr($entry, strrpos($entry, '.') + 1) != 'php') continue;
		$pages[] = $entry;
    }
    closedir($handle);
}

// Display requested page
require_once(PAGES . ((in_array($q . '.php', $pages)) ? ($q . '.php') : '404.php'));
?>