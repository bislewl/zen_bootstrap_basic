<?php

/* 
 * 
 * @package checkout_reloaded
 * @copyright Copyright 2003-2015 ZenCart.Codes a Pro-Webs Company
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @filename config.chaeckout_reloaded.php
 * @file created 2015-02-08 12:31:47 PM
 * 
 */

  $autoLoadConfig[90][] = array('autoType'=>'class',
                              'loadFile'=>'observers/class.checkout_reloaded.php');
  $autoLoadConfig[90][] = array('autoType'=>'classInstantiate',
                              'className'=>'CheckoutReloadedObserver',
                              'objectName'=>'CheckoutReloadedObserver');
  