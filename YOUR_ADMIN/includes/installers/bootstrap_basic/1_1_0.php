<?php
/**
 *  1_1_0.php
 *
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  1/22/2018 12:00 AM Modified in yogalifestyle
 */

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOOTSTRAP_BASIC_FACEBOOK_APP_ID', 'Facebook App ID ', '', 'App ID from Facebook', 104);");