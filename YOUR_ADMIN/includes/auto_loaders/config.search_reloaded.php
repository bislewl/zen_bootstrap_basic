<?php
/**
 *  config.search_reloaded.php
 *
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  1/11/2018 12:30 PM Modified in yogalifestyle
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

$autoLoadConfig[999][] = array(
    'autoType' => 'init_script',
    'loadFile' => 'init_search_reloaded.php'
);
