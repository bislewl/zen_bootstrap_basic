<?php
/**
 *  box_printing.php
 *
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/15/2016 5:47 PM Modified in box_printing
 */

function product_qty_discounts($products_id)
{
    global $db, $currencies;
    $product_info = $db->Execute("SELECT products_discount_type, products_discount_type_from, products_quantity_order_min FROM " . TABLE_PRODUCTS . " WHERE products_id='" . (int)$products_id . "'");
    $products_discount_type = $product_info->fields['products_discount_type'];
    $products_discount_type_from = $product_info->fields['products_discount_type_from'];
    // find out the minimum quantity for this product
    $products_quantity_order_min = $product_info->fields['products_quantity_order_min'];

// retrieve the list of discount levels for this product
    $products_discounts_query = $db->Execute("select * from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id='" . (int)$products_id . "' and discount_qty !=0 " . " order by discount_qty");


    $discount_col_cnt = DISCOUNT_QUANTITY_PRICES_COLUMN;

    $display_price = zen_get_products_base_price($products_id);
    $display_specials_price = zen_get_products_special_price($products_id, false);

    switch (true) {
        case ($products_discounts_query->fields['discount_qty'] <= 2):
            $show_qty = '1';
            break;
        case ($products_quantity_order_min == ($products_discounts_query->fields['discount_qty'] - 1) || $products_quantity_order_min == ($products_discounts_query->fields['discount_qty'])):
            $show_qty = $products_quantity_order_min;
            break;
        default:
            $show_qty = $products_quantity_order_min . '-' . number_format($products_discounts_query->fields['discount_qty'] - 1);
            break;
    }

    $disc_cnt = 1;
    $quantityDiscounts = array();
    $quantityDiscounts[0]['discounted_price'] = $display_price;
    $quantityDiscounts[0]['show_qty'] = $show_qty;

    $columnCount = 1;
    while (!$products_discounts_query->EOF) {
        $disc_cnt++;
        switch ($products_discount_type) {
            // none
            case '0':
                $quantityDiscounts[$columnCount]['discounted_price'] = 0;
                break;
            // percentage discount
            case '1':
                if ($products_discount_type_from == '0') {
                    $quantityDiscounts[$columnCount]['discounted_price'] = $display_price - ($display_price * ($products_discounts_query->fields['discount_price'] / 100));
                } else {
                    if (!$display_specials_price) {
                        $quantityDiscounts[$columnCount]['discounted_price'] = $display_price - ($display_price * ($products_discounts_query->fields['discount_price'] / 100));
                    } else {
                        $quantityDiscounts[$columnCount]['discounted_price'] = $display_specials_price - ($display_specials_price * ($products_discounts_query->fields['discount_price'] / 100));
                    }
                }
                break;
            // actual price
            case '2':
                if ($products_discount_type_from == '0') {
                    $quantityDiscounts[$columnCount]['discounted_price'] = $products_discounts_query->fields['discount_price'];
                } else {
                    $quantityDiscounts[$columnCount]['discounted_price'] = $products_discounts_query->fields['discount_price'];
                }
                break;
            // amount offprice
            case '3':
                if ($products_discount_type_from == '0') {
                    $quantityDiscounts[$columnCount]['discounted_price'] = $display_price - $products_discounts_query->fields['discount_price'];
                } else {
                    if (!$display_specials_price) {
                        $quantityDiscounts[$columnCount]['discounted_price'] = $display_price - $products_discounts_query->fields['discount_price'];
                    } else {
                        $quantityDiscounts[$columnCount]['discounted_price'] = $display_specials_price - $products_discounts_query->fields['discount_price'];
                    }
                }
                break;
        }

        $quantityDiscounts[$columnCount]['show_qty'] = number_format($products_discounts_query->fields['discount_qty']);
        $products_discounts_query->MoveNext();
        if ($products_discounts_query->EOF) {
            $quantityDiscounts[$columnCount]['show_qty'] .= '+';
        } else {
            if (($products_discounts_query->fields['discount_qty'] - 1) != $show_qty) {
                if ($quantityDiscounts[$columnCount]['show_qty'] < $products_discounts_query->fields['discount_qty'] - 1) {
                    $quantityDiscounts[$columnCount]['show_qty'] .= '-' . number_format($products_discounts_query->fields['discount_qty'] - 1);
                }
            }
        }
        $disc_cnt = 0;
        $columnCount++;
    }
    return $quantityDiscounts;
}

function box_printing_price_matrix($products_id)
{
    global $db;
    $discount_box_price = array(
        '1' => 0.00,
        '50' => 0.00,
        '100' => 0.00,
        '250' => 0.00,
        '500' => 0.00,
        '1000' => 0.00,
    );
    $products_attributes = $db->Execute("SELECT * FROM " . TABLE_PRODUCTS_ATTRIBUTES . " WHERE options_id='3' AND products_id='" . (int)zen_db_prepare_input($products_id) . "'");
    if ($products_attributes->RecordCount() > 0) {
        while (!$products_attributes->EOF) {
            switch ($products_attributes->fields['options_values_id']) {
                case '17':
                    $discount_box_price['1'] = $products_attributes->fields['options_values_price'];
                    break;
                case '10':
                    $discount_box_price['50'] = $products_attributes->fields['options_values_price'];
                    break;
                case '11':
                    $discount_box_price['100'] = $products_attributes->fields['options_values_price'];
                    break;
                case '13':
                    $discount_box_price['250'] = $products_attributes->fields['options_values_price'];
                    break;
                case '14':
                    $discount_box_price['500'] = $products_attributes->fields['options_values_price'];
                    break;
                case '15':
                    $discount_box_price['1000'] = $products_attributes->fields['options_values_price'];
                    break;
            }
            $products_attributes->MoveNext();
        }
    }
    $per_box_price = array();
    $per_box_price[0] = number_format($discount_box_price['1'],2);
    $per_box_price[1] = number_format(($discount_box_price['50'] / 50),2);
    $per_box_price[2] = number_format(($discount_box_price['100'] / 100),2);
    $per_box_price[3] = number_format(($discount_box_price['250'] / 250),2);
    $per_box_price[4] = number_format(($discount_box_price['500'] / 500),2);
    $per_box_price[5] = number_format(($discount_box_price['1000'] / 1000),2);
    return $per_box_price;
}