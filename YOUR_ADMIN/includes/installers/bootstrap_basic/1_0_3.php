<?php
/**
 *  1_0_3.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/6/2017 9:28 PM Modified in zen_bootstrap_basic
 */


$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order, date_added, use_function, set_function) VALUES (" . (int)$configuration_group_id . ", 'BOOTSTRAP_BASIC_CONTAINER', 'Site Width', 'container-fluid', 'Site Width, container is standard width, container-fluid is full width', 11, NOW(), NULL, 'zen_cfg_select_option(array(\"container-fluid\", \"container\"),')");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int)$configuration_group_id . ", 'BOOTSTRAP_BASIC_COL_ONE_CLASS', 'Left Column Class', 'col-xs-3 col-sm-3 col-md-3 col-lg-3', 'Left Column Class via Bootstrap', 12);");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int)$configuration_group_id . ", 'BOOTSTRAP_BASIC_COL_TWO_CLASS', 'Center Column Class', 'col-xs-6 col-sm-6 col-md-6 col-lg-6', 'Center Column Class via Bootstrap',13);");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int)$configuration_group_id . ", 'BOOTSTRAP_BASIC_COL_THREE_CLASS', 'Right Column Class', 'col-xs-3 col-sm-3 col-md-3 col-lg-3', 'Right Column Class via Bootstrap', 14);");
