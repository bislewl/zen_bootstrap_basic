<?php
/**
 *  bootstrap_basic_functions.php
 *
 * @package
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  4/10/2016 10:29 PM Modified in zen_bootstrap_basic
 */

function bsbt_col_class($col,$page = 'index'){
    switch($col){
        case 'left':
            $class_array = array(
                'xs' => 2,
                'sm' => 2,
                'md' => 2,
                'lg' => 2
            );
        break;
        case 'right':
            $class_array = array(
                'xs' => 2,
                'sm' => 2,
                'md' => 2,
                'lg' => 2
            );
            break;
        case 'center':
            $class_array = array(
                'xs' => 8,
                'sm' => 8,
                'md' => 8,
                'lg' => 8
            );
            break;
    }
    $class = '';
    foreach($class_array as $col_class_key => $col_class_value){
        $class .= 'col-'.$col_class_key.'-'.$col_class_value;
    }
    $class = trim($class);
    return $class;
}