<?php
/**
 *  tpl_footer.php
 *
 * @package
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  4/10/2016 9:38 PM Modified in zen_bootstrap_basic
 */
require(DIR_WS_MODULES . zen_get_module_directory('footer.php'));

if (!isset($flag_disable_footer) || !$flag_disable_footer) {
    ?>
    <!--bof-navigation display -->
    <div class="row">
        <div id="navSuppWrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="navSupp">
                <ul>
                    <li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><?php echo HEADER_TITLE_CATALOG; ?></a></li>
                    <?php if (EZPAGES_STATUS_FOOTER == '1' or (EZPAGES_STATUS_FOOTER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
                        <li><?php require($template->get_template_dir('tpl_ezpages_bar_footer.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_ezpages_bar_footer.php'); ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <!--eof-navigation display -->

    <!--bof-ip address display -->
    <?php
    if (SHOW_FOOTER_IP == '1') {
        ?>
        <div class="row">
            <div id="siteinfoIP" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php echo TEXT_YOUR_IP_ADDRESS . '  ' . $_SERVER['REMOTE_ADDR']; ?>
            </div>
        </div>

        <?php
    }
    ?>
    <!--eof-ip address display -->
    <!--bof-banner #5 display -->
    <?php
    if (SHOW_BANNERS_GROUP_SET5 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET5)) {
        if ($banner->RecordCount() > 0) {
            ?>
            <div class="row">
                <div id="bannerFive" class="banners col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo zen_display_banner('static', $banner); ?>
                </div>

            </div>
            <?php
        }
    }
    ?>
    <!--eof-banner #5 display -->

    <div class="row">
        <!--bof- site copyright display -->
        <div id="siteinfoLegal" class="legalCopyright col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo FOOTER_TEXT_BODY; ?>
        </div>
        <!--eof- site copyright display -->
    </div>
    <?php
}
