<?php
/**
 *  1_0_1.php
 *
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  1/11/2018 12:44 PM Modified in yogalifestyle
 */

$db->Execute("INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('','Product Exact Name Weight','RELOADED_SEARCH_NAME_EXACT_WEIGHT','90','Enter a number. Default=90', '" . $configuration_group_id . "', '6',NULL,now(),NULL,NULL)");
$db->Execute("INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('','Product Name Weight','RELOADED_SEARCH_PRODUCT_NAME_WEIGHT','60','Enter a number. Default=60', '" . $configuration_group_id . "', '6',NULL,now(),NULL,NULL)");