<?php

// use $configuration_group_id where needed

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150) { // continue Zen Cart 1.5.0
    $admin_page = 'configCOWOA';
    // delete configuration menu
    $db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $admin_page . "' LIMIT 1;");
    // add configuration menu
    if (!zen_page_key_exists($admin_page)) {
        if ((int) $configuration_group_id > 0) {
            zen_register_admin_page($admin_page, 'BOX_CONFIGURATION_COWOA', 'FILENAME_CONFIGURATION', 'gID=' . $configuration_group_id, 'configuration', 'Y', $configuration_group_id);

            $messageStack->add('Enabled COWOA Configuration Menu.', 'success');
        }
    }
}
global $sniffer;
if (!$sniffer->field_exists(TABLE_ORDERS, 'COWOA_order'))
    $db->Execute("ALTER TABLE " . TABLE_ORDERS . " ADD COWOA_order tinyint(1) NOT NULL default 0;");
if (!$sniffer->field_exists(TABLE_CUSTOMERS, 'COWOA_account'))
    $db->Execute("ALTER TABLE " . TABLE_CUSTOMERS . " ADD COWOA_account tinyint(1) NOT NULL default 0;");

$config_array = array();

$config_array[] = array('key' => 'COWOA_STATUS',
                        'value' => 'true',
                        'title' => 'Enable Checkout Without Account',
                        'desc' => 'Enable Checkout Without Account',
                        );
$config_array[] = array('key' => 'COWOA_MERGE',
                        'value' => 'true',
                        'title' => 'Merge COWOA Accounts',
                        'desc' => 'This will combine COWOA accounts',
                        );
$config_array[] = array('key' => 'COWOA_ONLY',
                        'value' => 'false',
                        'title' => 'Checkout Without Account Only',
                        'desc' => 'Force Checkout Without Account',
                        );
$config_array[] = array('key' => 'COWOA_FORCE_LOGOFF',
                        'value' => 'false',
                        'title' => 'Force COWOA Logoff',
                        'desc' => 'Force those checking out without account to logoff on success',
                        );
$config_array[] = array('key' => 'SHOPWCONF_BOX',
                        'value' => 'true',
                        'title' => 'Show Shop With Confidence Box',
                        'desc' => 'Show the shop with confidence box, on checkout',
                        );
$config_array[] = array('key' => 'COWOA_SHOW_LEFTSIDE',
                        'value' => 'false',
                        'title' => 'Show LEFT column',
                        'desc' => 'Show Left column during checkout',
                        );
$config_array[] = array('key' => 'COWOA_SHOW_RIGHTSIDE',
                        'value' => 'false',
                        'title' => 'Show RIGHT column',
                        'desc' => 'Show Right column during checkout',
                        );
$config_array[] = array('key' => 'COWOA_SHOW_HEADER',
                        'value' => 'true',
                        'title' => 'Show Header',
                        'desc' => 'Show header during checkout',
                        );
$config_array[] = array('key' => 'COWOA_SHOW_FOOTER',
                        'value' => 'true',
                        'title' => 'Show Footer',
                        'desc' => 'Show footer during checkout',
                        );

foreach($config_array as $config){
    $db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) "
        . "VALUES (" . (int) $configuration_group_id . ", '".$config['key']."', '".$config['title']."', '".$config['value']."', '".$config['desc']."', 'zen_cfg_select_option(array(\'true\', \'false\'),');");

}
unset($config_array);