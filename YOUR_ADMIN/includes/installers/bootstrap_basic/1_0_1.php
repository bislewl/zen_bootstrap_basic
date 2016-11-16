<?php
/**
 *  1_0_1.php
 *
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  11/16/2016 3:17 PM Modified in zen_bootstrap_basic
 */

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOOTSTRAP_BASIC_CATEGORIES_FOOTER_COUNT', 'Categories in footer', '5', 'Categories in Footer', 105);");