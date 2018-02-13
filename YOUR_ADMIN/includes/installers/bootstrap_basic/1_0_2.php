<?php
/**
 *  1_0_2.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  8/15/2017 10:02 PM Modified in hazmat
 */

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOOTSTRAP_BASIC_LINKEDIN_LINK', 'LinkedIn Link', 'https://linkedin.com', 'Link to LinkedIn', 104);");