<?php
/**
 *  1_0_2.php
 *
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  1/18/2018 11:48 PM Modified in yogalifestyle
 */

$db->Execute("UPDATE " . TABLE_CONFIGURATION . " set configuration_title = 'Product Exact Name Weight' WHERE configuration_key='RELOADED_SEARCH_NAME_EXACT_WEIGHT'");
$db->Execute("UPDATE " . TABLE_CONFIGURATION . " set configuration_title = 'Product Name Weight' WHERE configuration_key='RELOADED_SEARCH_PRODUCT_NAME_WEIGHT'");
