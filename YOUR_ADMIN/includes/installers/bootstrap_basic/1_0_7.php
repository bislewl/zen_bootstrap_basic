<?php
/**
 *  1_0_7.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/11/2017 9:12 AM Modified in  everbrite_coatings
 */

$db->Execute("CREATE TABLE IF NOT EXISTS " . TABLE_BOOTSTRAP_BASIC_ADMIN_ACCESS . " (
	`bootstrap_basic_admin_access_id` int(11) NOT NULL AUTO_INCREMENT,
	`admin_profile` int(5) NOT NULL,
    `tab_defines` varchar(76) NOT NULL,
    `tab_options` varchar(76) NOT NULL,
    `tab_menu` varchar(76) NOT NULL,
	PRIMARY KEY ( `bootstrap_basic_admin_access_id` ));");