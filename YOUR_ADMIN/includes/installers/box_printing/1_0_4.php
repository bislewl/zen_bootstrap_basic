<?php
/**
 *  1_0_4.php
 *
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  10/28/2016 11:53 AM Modified in box_printing
 */

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOX_PRINTING_YOUTUBE_LINK', 'YouTube Link', 'https://youtube.com', 'Link to Youtube', 104);");