<?php
/**
 *  1_0_6.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/8/2017 9:52 AM Modified in  everbrite_coatings
 */

if (!defined(TABLE_BOOTSTRAP_BASIC_CONFIG)) define('TABLE_BOOTSTRAP_BASIC_CONFIG', DB_PREFIX . 'bootstrap_basic_config');

global $sniffer;
if ($sniffer->table_exists(TABLE_BOOTSTRAP_BASIC_CONFIG)) {
    $db->Execute("CREATE TABLE IF NOT EXISTS " . TABLE_BOOTSTRAP_BASIC_OPTIONS . " (
	`bootstrap_basic_options_id` int(11) NOT NULL AUTO_INCREMENT,
	`options_name` varchar(125) NOT NULL,
    `options_define` varchar(125) NOT NULL,
    `options_group` varchar(76) NOT NULL default 'main',
    `options_input_type` varchar(76) NOT NULL default 'text',
    `options_value_default` varchar(125) NOT NULL,
	`options_value` text NOT NULL,
	PRIMARY KEY ( `bootstrap_basic_options_id` ));");

    $new_table_data = $db->Execute("SELECT * FROM " . TABLE_BOOTSTRAP_BASIC_OPTIONS);
    if ($new_table_data->RecordCount() == false) {
        $old_table_data = $db->Execute("SELECT * FROM " . TABLE_BOOTSTRAP_BASIC_CONFIG);
        if ($old_table_data->RecordCount() > 0) {
            while (!$old_table_data->EOF) {
                $db->Execute("INSERT INTO " . TABLE_BOOTSTRAP_BASIC_OPTIONS . "(`bootstrap_basic_options_id`, `options_name`, `options_define`, `options_group`, `options_input_type`, `options_value_default`, `options_value`) 
                          VALUES ('" . $old_table_data->fields['bootstrap_basic_config_id'] . "','" . $old_table_data->fields['config_name'] . "','" . $old_table_data->fields['config_define'] . "','" . $old_table_data->fields['config_group'] . "','" . $old_table_data->fields['config_input_type'] . "','" . $old_table_data->fields['config_value_default'] . "','" . $old_table_data->fields['config_value'] . "')");
                $old_table_data->MoveNext();
            }
        }
    }

    $db->Execute("DROP TABLE " . TABLE_BOOTSTRAP_BASIC_CONFIG);

    $messageStack->add('Added Bootstrap Basic Options Table', 'success');
}
