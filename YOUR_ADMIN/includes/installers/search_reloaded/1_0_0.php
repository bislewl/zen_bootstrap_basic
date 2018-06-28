<?php
/**
 *  1_0_0.php
 *
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  1/11/2018 12:27 PM Modified in yogalifestyle
 */

global $db;

$db->Execute("ALTER TABLE " . TABLE_PRODUCTS_DESCRIPTION . " ENGINE = MYISAM;");
$db->Execute("ALTER TABLE " . TABLE_MANUFACTURERS . " ENGINE = MYISAM;");
$db->Execute("ALTER TABLE " . TABLE_PRODUCTS . " ENGINE = MYISAM;");
$db->Execute("ALTER TABLE " . TABLE_META_TAGS_PRODUCTS_DESCRIPTION . " ENGINE = MYISAM;");

//Check indexes
$check_index = array(
    array(
        'check_query' => "SHOW INDEX FROM " . TABLE_PRODUCTS_DESCRIPTION,
        'Key_name' => 'idx_reloaded_products_name_description',
        'create_query' => "CREATE FULLTEXT INDEX idx_reloaded_products_name_description ON " . TABLE_PRODUCTS_DESCRIPTION . " (products_name, products_description)"
    ),
    array(
        'check_query' => "SHOW INDEX FROM " . TABLE_PRODUCTS_DESCRIPTION,
        'Key_name' => 'idx_reloaded_products_name',
        'create_query' => "CREATE FULLTEXT INDEX idx_reloaded_products_name ON " . TABLE_PRODUCTS_DESCRIPTION . " (products_name)"
    ),
    array(
        'check_query' => "SHOW INDEX FROM " . TABLE_MANUFACTURERS,
        'Key_name' => 'idx_reloaded_manufacturer_name',
        'create_query' => "CREATE FULLTEXT INDEX idx_reloaded_manufacturer_name ON " . TABLE_MANUFACTURERS . " (manufacturers_name)"
    ),
    array(
        'check_query' => "SHOW INDEX FROM " . TABLE_PRODUCTS,
        'Key_name' => 'idx_reloaded_products_model',
        'create_query' => "CREATE FULLTEXT INDEX idx_reloaded_products_model ON " . TABLE_PRODUCTS . " (products_model)"
    ),
    array(
        'check_query' => "SHOW INDEX FROM " . TABLE_META_TAGS_PRODUCTS_DESCRIPTION,
        'Key_name' => 'idx_reloaded_metatags_keywords_description',
        'create_query' => "CREATE FULLTEXT INDEX idx_reloaded_metatags_keywords_description ON " . TABLE_META_TAGS_PRODUCTS_DESCRIPTION . "(metatags_keywords, metatags_description)"
    )
);

foreach ($check_index as $index) {
    $pd_index = $db->Execute($index['check_query']);

    if ($pd_index->RecordCount() > 0) {

        $column_index = FALSE;

        while (!$pd_index->EOF) {

            if ($pd_index->fields['Key_name'] == $index['Key_name'])
                $column_index = TRUE;

            $pd_index->MoveNext();
        }

        if ($column_index == FALSE) {
            echo $column_index;
            $db->Execute($index['create_query']);
        }
        unset($column_index);
    }
}

//Install new configuration settings
$db->Execute("INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('','Product Model Search Weight','RELOADED_SEARCH_PRODUCT_MODEL_WEIGHT','50','Enter a number. Default=50', '" . $configuration_group_id . "', '1',NULL,now(),NULL,NULL)");
$db->Execute("INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('','Product Description Search Weight','RELOADED_SEARCH_PRODUCT_DESCRIPTION_WEIGHT','40','Enter a number. Default=40', '" . $configuration_group_id . "', '2',NULL,now(),NULL,NULL)");
$db->Execute("INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('','Product Category Search Weight','RELOADED_SEARCH_PRODUCT_CATEGORY_WEIGHT','20','Enter a number. Default=20', '" . $configuration_group_id . "', '3',NULL,now(),NULL,NULL)");
$db->Execute("INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('','Product Meta Tags Search Weight','RELOADED_SEARCH_PRODUCT_META_KEYWORD_WEIGHT','15','Enter a number. Default=10', '" . $configuration_group_id . "', '4',NULL,now(),NULL,NULL)");
$db->Execute("INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('','Product Manufacturer Search Weight','RELOADED_SEARCH_PRODUCT_MANUFACTURER_WEIGHT','20','Enter a number. Default=20', '" . $configuration_group_id . "', '5',NULL,now(),NULL,NULL)");
$db->Execute("INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('','Product Viewed Search Weight','RELOADED_SEARCH_PRODUCT_VIEWED_WEIGHT','10','Enter a number. Default=10', '" . $configuration_group_id . "', '6',NULL,now(),NULL,NULL)");

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150) { // continue Zen Cart 1.5.0
    $admin_page = 'configReloadedSearch';
    // delete configuration menu
    $db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $admin_page . "' LIMIT 1;");
    // add configuration menu
    if (!zen_page_key_exists($admin_page)) {
        if ((int)$configuration_group_id > 0) {
            zen_register_admin_page($admin_page,
                'BOX_TOOLS_RELOADED_SEARCH',
                'FILENAME_CONFIGURATION',
                'gID=' . $configuration_group_id,
                'configuration',
                'Y',
                $configuration_group_id);

            $messageStack->add('Enabled Reloaded Search Config page', 'success');
        }
    }
}