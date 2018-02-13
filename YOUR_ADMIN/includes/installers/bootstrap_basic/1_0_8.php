<?php
/**
 *  1_0_8.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/25/2017 4:38 PM Modified in  everbrite_coatings
 */


if (!$sniffer->field_exists(TABLE_BOOTSTRAP_BASIC_MENU, 'parent_item')) $db->Execute("ALTER TABLE " . TABLE_BOOTSTRAP_BASIC_MENU . " ADD parent_item int(1) NOT NULL DEFAULT 0");
