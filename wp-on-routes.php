<?php
/*
Plugin Name: WordPress on Routes
Description: Add API-like functionality to your WordPress instance.
Version: 0.2.0
Plugin URI: https://github.com/markzero/wp-on-routes
Author: Marko Jakic
Author URI: http://markojakic.net/
Network: True
License: GPL v3

Copyright (C) 2013, Marko Jakic - hi@markojakic.net

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('ABSPATH')) {
    return;
}

if (defined('WP_INSTALLING') && WP_INSTALLING) {
    return;
}


define('WOR_VERSION', '0.2.0');
define('WOR_PATH', dirname(__FILE__));

if (version_compare(PHP_VERSION, "5.3", "<")) {
  require_once(WOR_PATH . '/admin/notices.php');
  add_action('admin_notices', 'wor_phpversion');
  return;
}

// For common use, Underscore.php provides much of the Underscore.js functionality
// Goal is to write less ifs and fors
// Edite by me: 1) add 'static' keywords to avoid notices
// 2) Renamed __ to _u because WP already has __
require_once 'underscore.php';

// Define main entry point
require_once 'boot.php';

if (defined('ABSPATH') && defined('WPINC')) {
  wor_init();
}
