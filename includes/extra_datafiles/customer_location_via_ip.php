<?php
/**
 *  progressive_printing.php
 *
 * @package
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  8/11/2016 12:28 PM Modified in zen_bootstrap_basic
 */
function customer_location_via_ip($field = ''){
    $url = 'http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR'];
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    if($field == ''){
        return $data;
    }
    else{
        return $data[$field];
    }
}