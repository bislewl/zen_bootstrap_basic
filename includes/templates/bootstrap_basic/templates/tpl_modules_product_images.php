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
    <ul id="productPhotos">
        <?php
        if (zen_not_null($products_image)) {
            ?>
            <li>
                <a href="<?php echo DIR_WS_IMAGES . $products_image; ?>" data-thumb="<?php echo DIR_WS_IMAGES . $products_image; ?>" alt="<?php echo $products_image_alt; ?>" data-fancybox="productImages" data-caption="<?php echo $products_image_alt; ?>">
                    <img src="<?php echo DIR_WS_IMAGES . $products_image; ?>" alt="<?php echo $products_image_alt; ?>"/>
                </a>
            </li>
            <?php
        }
        ?>
        <?php
        if ($flag_show_product_info_additional_images != 0 && $num_images > 0) {

            foreach ($product_additional_images as $product_additional_image) {
                if ($product_additional_image['large'] != '') {
                    ?>
                    <li>
                        <a href="<?php echo DIR_WS_IMAGES . $product_additional_image['large']; ?>" data-thumb="<?php echo DIR_WS_IMAGES . $product_additional_image['large']; ?>"
                           alt="<?php echo $products_image_alt; ?>" data-fancybox="productImages" data-caption="<?php echo $products_image_alt; ?>">
                            <img src="<?php echo DIR_WS_IMAGES . $product_additional_image['large']; ?>"
                                 alt="<?php echo $products_image_alt; ?>"/>
                        </a>
                    </li>
                    <?php
                }
            }
        }
        ?>
    </ul>
</div>
