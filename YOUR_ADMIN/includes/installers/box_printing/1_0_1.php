<?php
/**
 *  1_0_1.php
 *
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/15/2016 4:00 PM Modified in box_printing
 */


global $sniffer;
if (!$sniffer->field_exists(TABLE_PRODUCTS, 'product_size')) $db->Execute("ALTER TABLE " . TABLE_PRODUCTS . " ADD product_size varchar(32) NOT NULL DEFAULT NULL;");

