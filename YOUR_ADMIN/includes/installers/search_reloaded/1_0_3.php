<?php
/**
 *  1_0_3.php
 *
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  1/30/2018 11:31 PM Modified in yogalifestyle
 */

$db->Execute("INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('','No Weight Words','RELOADED_SEARCH_NO_WEIGHT_WORDS','the,of,with,at,a','Words that should not be given weight: The, of, with, at','" . $configuration_group_id . "', '8',NULL,now(),NULL,NULL)");