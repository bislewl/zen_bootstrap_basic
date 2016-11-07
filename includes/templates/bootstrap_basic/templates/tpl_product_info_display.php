<?php
/**
 *  tpl_product_info_display.php
 *
 * @package
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  4/10/2016 9:41 PM Modified in zen_bootstrap_basic
 */
?>
<div class="centerColumn" id="productGeneral">
    <!--bof Form start-->
    <?php echo zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('action')) . 'action=add_product', $request_type), 'post', 'enctype="multipart/form-data"') . "\n"; ?>
    <!--eof Form start-->
    <!--bof Product Name-->
    <h1 id="productName" class="productGeneral"><?php echo $products_name; ?></h1>
    <!--eof Product Name-->
    <div class="container-fluid">
        <!--bof Product Images-->
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
            <!--bof Main Product Image -->
            <?php
            if (zen_not_null($products_image)) {
                ?>
                <?php
                /**
                 * display the main product image
                 */
                require($template->get_template_dir('/tpl_modules_main_product_image.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_main_product_image.php'); ?>
                <?php
            }
            ?>
            <!--eof Main Product Image-->
            <!--bof Additional Product Images -->
            <?php
            /**
             * display the products additional images
             */
            require($template->get_template_dir('/tpl_modules_additional_images.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_additional_images.php'); ?>
            <!--eof Additional Product Images -->
            <!--bof Product Description-->
            <div id="productDescription" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3 id="productDescriptionHeadline">Product Details</h3>
                <div id="productDescriptionDetails" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo stripslashes($products_description); ?>
                </div>

            </div>
            <!--bof Product Description-->
        </div>
        <!--eof Product Images-->
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <!--bof Product Price block -->
            <h2 id="productPrices" class="productGeneral">
                <?php
                // base price
                if ($show_onetime_charges_description == 'true') {
                    $one_time = '<span >' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</span><br />';
                } else {
                    $one_time = '';
                }
                echo $one_time . ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . zen_get_products_display_price((int)$_GET['products_id']);
                ?></h2>
            <!--eof Product Price block -->


            <br/>

            <br/>
            <!--bof Attributes Module -->
            <?php
            if ($pr_attr->fields['total'] > 0) {
                ?>
                <?php
                /**
                 * display the product atributes
                 */
                require($template->get_template_dir('/tpl_modules_attributes.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_attributes.php'); ?>
                <?php
            }
            ?>
            <!--eof Attributes Module -->

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-right">
    <!--bof Add to Cart Box -->
    <?php
    if (CUSTOMERS_APPROVAL == 3 and TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM == '') {
        // do nothing
    } else {
        ?>
        <?php
        $display_qty = (($flag_show_product_info_in_cart_qty == 1 and $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p>' . PRODUCTS_ORDER_QTY_TEXT_IN_CART . $_SESSION['cart']->get_quantity($_GET['products_id']) . '</p>' : '');
        if ($products_qty_box_status == 0 or $products_quantity_order_max == 1) {
            // hide the quantity box and default to 1
            $the_button = '<input type="hidden" name="cart_quantity" value="1" />' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
        } else {
            // show the quantity box
            $the_button = PRODUCTS_ORDER_QTY_TEXT . '<input readonly="readonly"  type="text" name="cart_quantity" value="' . (zen_get_buy_now_qty($_GET['products_id'])) . '" maxlength="6" size="4" /><br />' . zen_get_products_quantity_min_units_display((int)$_GET['products_id']) . '<br />' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
        }
        $display_button = zen_get_buy_now_button($_GET['products_id'], $the_button);
        ?>
        <?php if ($display_qty != '' or $display_button != '') { ?>
            <div id="cartAdd">
                <?php
                echo $display_qty;
                echo $the_button;
                ?>
                    <button type="submit" class="btn btn-success btn-lg">Add to Cart</button>
            </div>
        <?php } // display qty and button ?>
    <?php } // CUSTOMERS_APPROVAL == 3 ?>
    <!--eof Add to Cart Box-->
</div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <!--bof Reviews button and count-->
            <?php
            if ($flag_show_product_info_reviews == 1) {
                // if more than 0 reviews, then show reviews button; otherwise, show the "write review" button
                if ($reviews->fields['count'] > 0) { ?>
                    <div id="productReviewLink"
                         class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params()) . '">' . zen_image_button(BUTTON_IMAGE_REVIEWS, BUTTON_REVIEWS_ALT) . '</a>'; ?></div>
                    <br class="clearBoth"/>
                    <p class="reviewCount"><?php echo($flag_show_product_info_reviews_count == 1 ? TEXT_CURRENT_REVIEWS . ' ' . $reviews->fields['count'] : ''); ?></p>
                <?php } else { ?>
                    <div id="productReviewLink"
                         class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, zen_get_all_get_params(array())) . '">' . zen_image_button(BUTTON_IMAGE_WRITE_REVIEW, BUTTON_WRITE_REVIEW_ALT) . '</a>'; ?></div>
                    <br class="clearBoth"/>
                    <?php
                }
            }
            ?>
            <!--eof Reviews button and count -->
        </div>
    </div>
    <!--bof Form end-->
    <?php echo '</form>'; ?>
    <!--eof Form end-->
</div>