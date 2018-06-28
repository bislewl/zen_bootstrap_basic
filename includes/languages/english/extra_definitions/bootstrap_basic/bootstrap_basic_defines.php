<?php
/**
 *  bootstrap_basic_defines.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/12/2017 10:04 PM Modified in  everbrite_coatings
 */

$bootstrap_basic_vars = array();
$bootstrap_basic_defines = $db->Execute("SELECT * FROM " . TABLE_BOOTSTRAP_BASIC_DEFINES);
if ($bootstrap_basic_defines->RecordCount() > 0) {
    while (!$bootstrap_basic_defines->EOF) {
        define($bootstrap_basic_defines->fields['defines_define'], $bootstrap_basic_defines->fields['defines_value']);
        $bootstrap_basic_vars[$bootstrap_basic_defines->fields['defines_define']] = $bootstrap_basic_defines->fields['defines_value'];
        $bootstrap_basic_defines->MoveNext();
    }
}
