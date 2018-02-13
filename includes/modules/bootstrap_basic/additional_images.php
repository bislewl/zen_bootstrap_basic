<?php
/**
 *  additional_images.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/7/2017 11:32 AM Modified in zen_bootstrap_basic
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
$zco_notifier->notify('NOTIFY_MODULES_ADDITIONAL_PRODUCT_IMAGES_START');

if (!defined('IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE')) define('IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE', 'Yes');
$images_array = array();

// do not check for additional images when turned off
if ($products_image != '' && $flag_show_product_info_additional_images != 0) {
    // prepare image name
    $products_image_extension = substr($products_image, strrpos($products_image, '.'));
    $products_image_base = str_replace($products_image_extension, '', $products_image);

    // if in a subdirectory
    if (strrpos($products_image, '/')) {
        $products_image_match = substr($products_image, strrpos($products_image, '/') + 1);
        //echo 'TEST 1: I match ' . $products_image_match . ' - ' . $file . ' -  base ' . $products_image_base . '<br>';
        $products_image_match = str_replace($products_image_extension, '', $products_image_match) . '_';
        $products_image_base = $products_image_match;
    }

    $products_image_directory = str_replace($products_image, '', substr($products_image, strrpos($products_image, '/')));
    if ($products_image_directory != '') {
        $products_image_directory = DIR_WS_IMAGES . str_replace($products_image_directory, '', $products_image) . "/";
    } else {
        $products_image_directory = DIR_WS_IMAGES;
    }

    // Check for additional matching images
    $file_extension = $products_image_extension;
    $products_image_match_array = array();
    if ($dir = @dir($products_image_directory)) {
        while ($file = $dir->read()) {
            if (!is_dir($products_image_directory . $file)) {
                if (substr($file, strrpos($file, '.')) == $file_extension) {
                    if (preg_match('/\Q' . $products_image_base . '\E/i', $file) == 1) {
                        if ($file != $products_image) {
                            if ($products_image_base . str_replace($products_image_base, '', $file) == $file) {
                                //  echo 'I AM A MATCH ' . $file . '<br>';
                                $images_array[] = $file;
                            } else {
                                //  echo 'I AM NOT A MATCH ' . $file . '<br>';
                            }
                        }
                    }
                }
            }
        }
        if (sizeof($images_array)) {
            sort($images_array);
        }
        $dir->close();
    }
}

$zco_notifier->notify('NOTIFY_MODULES_ADDITIONAL_PRODUCT_IMAGES_LIST', NULL, $images_array);

// Build output based on images found
$num_images = sizeof($images_array);
$list_box_contents = array();
$title = '';

if ($num_images) {
    $product_additional_images = array();

    for ($i = 0, $n = $num_images; $i < $n; $i++) {
        $file = $images_array[$i];
        $products_image_large = str_replace(DIR_WS_IMAGES, DIR_WS_IMAGES . 'large/', $products_image_directory) . str_replace($products_image_extension, '', $file) . IMAGE_SUFFIX_LARGE . $products_image_extension;
        $flag_has_large = file_exists($products_image_large);
        $products_image_large = ($flag_has_large ? $products_image_large : $products_image_directory . $file);
        $flag_display_large = (IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE == 'Yes' || $flag_has_large);
        $base_image = $products_image_directory . $file;

        if ($flag_display_large) {
            $product_additional_images[]['base'] = $base_image;
            $product_additional_images[]['large'] = $products_image_large;
            $product_additional_images[]['alt'] = $products_name;

        }
    } // end for loop
} // endif

$zco_notifier->notify('NOTIFY_MODULES_ADDITIONAL_PRODUCT_IMAGES_END');
