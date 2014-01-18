<?php
/**
 * Plugin Name: google-destination-url
 * Plugin URI: https://bitbucket.org/aubreypwd/google-destination-url
 * Description: GDU is a plugin that saves you from having to open another tab, perform a Google Search, copy the link, close the tab, paste (whew~).
 * Version: 1.0
 * Author: Aubrey Portwood
 * Author URI: http://profiles.wordpress.org/aubreypwd/
 * License: GPL2
 */

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Fix symlinked plugins.
require_once('__FILE__-fix.php');

// Google API Stuff
require_once('google-desination-url-googapi.php');

// Primary Plugin
require_once('google-destination-url.php');

?>