<?php
/**
 *  1_0_3.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/7/2017 8:15 PM Modified in  everbrite_coatings
 */

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150) { // continue Zen Cart 1.5.0
    $admin_page = 'toolsBootBasicCfg';
    // delete configuration menu
    $db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $admin_page . "' LIMIT 1;");
    // add configuration menu
    if (!zen_page_key_exists($admin_page)) {
        if ((int)$configuration_group_id > 0) {
            zen_register_admin_page($admin_page,
                'BOX_TOOLS_BOOTSTRAP_BASIC',
                'FILENAME_BOOTSTRAP_BASIC',
                '',
                'tools',
                'Y',
                $configuration_group_id);

            $messageStack->add('Enabled Bootstrap Basic Configuration - Tools Menu.', 'success');
        }
    }
}

$db->Execute("CREATE TABLE IF NOT EXISTS " . TABLE_BOOTSTRAP_BASIC_OPTIONS . " (
	`bootstrap_basic_options_id` int(11) NOT NULL AUTO_INCREMENT,
	`options_name` varchar(125) NOT NULL,
    `options_define` varchar(125) NOT NULL,
    `options_group` varchar(76) NOT NULL default 'main',
    `options_input_type` varchar(76) NOT NULL default 'text',
    `options_value_default` varchar(125) NOT NULL,
	`options_value` text NOT NULL,
	PRIMARY KEY ( `bootstrap_basic_options_id` ));");


$db->Execute("CREATE TABLE IF NOT EXISTS " . TABLE_BOOTSTRAP_BASIC_DEFINES . " (
	`bootstrap_basic_defines_id` int(11) NOT NULL AUTO_INCREMENT,
	`languages_id` int(11) NOT NULL default 1,
	`defines_title` varchar(76) NOT NULL,
    `defines_group` varchar(76) NOT NULL default 'main',
	`defines_define` varchar(76) NOT NULL,
    `defines_input_type` varchar(76) NOT NULL default 'text',
	`defines_value` text NOT NULL,
	PRIMARY KEY ( `bootstrap_basic_defines_id` ));"
);


$db->Execute("CREATE TABLE IF NOT EXISTS " . TABLE_BOOTSTRAP_BASIC_MENU . " (
	`bootstrap_basic_menu_id` int(11) NOT NULL AUTO_INCREMENT,
	`parent_id` int(11) NOT NULL default 0,
    `sort_order` int(11) NOT NULL default 0,
	`display_name` varchar(125) NOT NULL,
    `item_type` varchar(125) NOT NULL default 'Category',
	`menu_link` varchar(125) NOT NULL,
	PRIMARY KEY ( `bootstrap_basic_menu_id` ));"
);

$messageStack->add('Added Bootstrap Basic Tables', 'success');

