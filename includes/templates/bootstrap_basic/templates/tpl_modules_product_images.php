<?php
/**
 *  tpl_product_images.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/7/2017 11:18 AM Modified in zen_bootstrap_basic
 */

require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE));
require(DIR_WS_MODULES . zen_get_module_directory('additional_images.php'));
?>
<div id="productPhotosBox">
    <ul id="productPhotos" class="cS-hidden">
        <?php
        if (zen_not_null($products_image)) {
            ?>
            <li data-thumb="<?php echo $products_image_medium; ?>" alt="<?php echo $products_name; ?>">
                <img src="<?php echo $products_image_medium; ?>" alt="<?php echo $products_name; ?>"/>
            </li>
            <?php
        }
        ?>
        <?php
        if ($flag_show_product_info_additional_images != 0 && $num_images > 0) {

            foreach ($product_additional_images as $product_additional_image) {
                if ($product_additional_image['large'] != '') {
                    ?>
                    <li data-thumb="<?php echo $product_additional_image['large']; ?>"
                        alt="<?php echo $products_name; ?>">
                        <img src="<?php echo $product_additional_image['large']; ?>"
                             alt="<?php echo $products_name; ?>"/>
                    </li>
                    <?php
                }
            }
        }
        ?>
    </ul>
</div>
