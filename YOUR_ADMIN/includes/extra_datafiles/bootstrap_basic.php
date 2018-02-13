<?php
/**
 *  bootstrap_basic.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/8/2017 1:09 AM Modified in  everbrite_coatings
 */

// Filename Defines
if(!defined('FILENAME_AJAX')){
    define('FILENAME_AJAX', 'ajax');
}
define('FILENAME_BOOTSTRAP_BASIC', 'bootstrap_basic');

// Box Defines
if(!defined('BOX_HIDDEN_AJAX')){
    define('BOX_HIDDEN_AJAX', 'ajax');
}
define('BOX_CONFIGURATION_BOOTSTRAP_BASIC', "Bootstrap Basic Configuration");
define('BOX_TOOLS_BOOTSTRAP_BASIC', 'Bootstrap Basic Dashboard');

// DB Tables
define('TABLE_BOOTSTRAP_BASIC_OPTIONS', DB_PREFIX . 'bootstrap_basic_options');
define('TABLE_BOOTSTRAP_BASIC_DEFINES', DB_PREFIX . 'bootstrap_basic_defines');
define('TABLE_BOOTSTRAP_BASIC_MENU', DB_PREFIX . 'bootstrap_basic_menu');
define('TABLE_BOOTSTRAP_BASIC_ADMIN_ACCESS', DB_PREFIX . 'bootstrap_basic_admin_access');
