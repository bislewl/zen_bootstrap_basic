<?php
/**
 *  tpl_index_default.php
 *
 * @package
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  4/10/2016 9:39 PM Modified in zen_bootstrap_basic
 */

?>
<div class="centerColumn" id="indexDefault">
    <h1 id="indexDefaultHeading"></h1>
    <?php if (DEFINE_MAIN_PAGE_STATUS >= 1 and DEFINE_MAIN_PAGE_STATUS <= 2) { ?>
        <?php
        /**
         * get the Define Main Page Text
         */
        ?>
        <div id="indexDefaultMainContent" class="content"><?php require($define_page); ?></div>
    <?php } ?>

    <?php
    $show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_MAIN);
    while (!$show_display_category->EOF) {
        ?>

        <?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MAIN_FEATURED_PRODUCTS') { ?>
            <?php
            /**
             * display the Featured Products Center Box
             */
            ?>
            <?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
        <?php } ?>

        <?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MAIN_SPECIALS_PRODUCTS') { ?>
            <?php
            /**
             * display the Special Products Center Box
             */
            ?>
            <?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
        <?php } ?>

        <?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MAIN_NEW_PRODUCTS') { ?>
            <?php
            /**
             * display the New Products Center Box
             */
            ?>
            <?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
        <?php } ?>

        <?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MAIN_UPCOMING') { ?>
            <?php
            /**
             * display the Upcoming Products Center Box
             */
            ?>
            <?php include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS)); ?><?php } ?>


        <?php
        $show_display_category->MoveNext();
    } // !EOF
    ?>
</div>
