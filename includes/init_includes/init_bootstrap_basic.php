<?php
/**
 *  init_bootstrap_basic.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/11/2017 3:20 PM Modified in  everbrite_coatings
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

require('includes/classes/class.bootstrap_basic.php');
$bootstrap_basic = new bootstrap_basic();
