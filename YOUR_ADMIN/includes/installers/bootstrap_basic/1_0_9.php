<?php
/**
 *  1_0_9.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  10/6/2017 10:16 PM Modified in yogalifestyle
 */


$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOOTSTRAP_BASIC_BLOGGER_LINK', 'Blogger Link', 'https://blogger.com', 'Link to Blogger.com', 105);");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOOTSTRAP_BASIC_INSTAGRAM_LINK', 'Instagram Link', 'https://instagram.com', 'Link to Instagram', 106);");