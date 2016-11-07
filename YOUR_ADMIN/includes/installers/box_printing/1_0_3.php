<?php
/**
 *  1_0_3.php
 *
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  10/20/2016 4:15 PM Modified in box_printing
 */

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOX_PRINTING_FACEBOOK_LINK', 'Facebook Link', 'https://facebook.com', 'Link to Facebook', 101);");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOX_PRINTING_TWITTER_LINK', 'Twitter Link', 'https://twitter.com', 'Link to twitter', 102);");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOX_PRINTING_PINTEREST_LINK', 'Pinterest Link', 'https://pinterest.com', 'Link to Pinterest', 103);");