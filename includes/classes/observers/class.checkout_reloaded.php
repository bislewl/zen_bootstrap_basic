<?php

/*
 * 
 * @package checkout_reloaded
 * @copyright Copyright 2003-2015 ZenCart.Codes a Pro-Webs Company
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @filename class.checkout_reloaded.php
 * @file created 2015-02-08 12:15:28 PM
 * 
 */

class CheckoutReloadedObserver extends base {

    function CheckoutReloadedObserver() {
        global $zco_notifier;
        $zco_notifier->attach($this, array('NOTIFY_HEADER_START_CHECKOUT_SHIPPING'));
    }

    function update(&$class, $eventID, $paramsArray) {
        global $messageStack;
        $checkout_ajax_post = zen_db_prepare_input($_POST['checkout_reloaded_post']);
        if (CHECKOUT_RELOADED_STATUS == true && $checkout_ajax_post != 1 && $_SESSION['noscript_active'] != 1) {
            zen_redirect(zen_href_link(FILENAME_CHECKOUT_RELOADED, '', 'SSL'));
        }
    }

}
