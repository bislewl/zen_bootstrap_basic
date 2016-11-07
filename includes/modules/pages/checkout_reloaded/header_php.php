<?php

/*
 * 
 * @package checkout_reloaded
 * @copyright Copyright 2003-2015 ZenCart.Codes a Pro-Webs Company
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @filename header.php
 * @file created 2015-01-17 12:42:23 AM
 * 
 */
if(CHECKOUT_RELOADED_SHOW_LEFTSIDE == 'false') $flag_disable_left = true;
if(CHECKOUT_RELOADED_SHOW_RIGHTSIDE == 'false') $flag_disable_right = true;
if(CHECKOUT_RELOADED_SHOW_HEADER == 'false') $flag_disable_header = true;
if(CHECKOUT_RELOADED_SHOW_FOOTER == 'false') $flag_disable_footer = true;
$_SESSION['navigation']->remove_current_page();