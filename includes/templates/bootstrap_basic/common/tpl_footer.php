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
    <div id="footerRow">
        <div class="container">

            <nav class="navbar navbar-default navbar-bottom" role="navigation">
                <ul class="nav navbar-nav footerNav">
                    <li>Products
                        <ul>
                            <li><a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath=1'); ?>"><i class="fa fa-square"></i> Category 1</a></li>
                            <li><a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath=2'); ?>"><i class="fa fa-square"></i> Category 2</a></li>
                            <li><a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath=3'); ?>"><i class="fa fa-square"></i> Category 3</a></li>
                        </ul>
                    </li>
                    <li>Customer Service
                        <ul>
                            <li><a href="<?php echo zen_href_link(FILENAME_CONTACT_US); ?>"><i class="fa fa-phone"></i> Contact Us</a></li>
                            <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT); ?>"><i class="fa fa-user"></i> My Account</a></li>
                        </ul>
                    </li>
                    <li>Payment
                        <ul>
                            <li><i class="fa fa-cc-visa"></i>
                            <i class="fa fa-cc-mastercard"></i>
                            <i class="fa fa-cc-amex"></i>
                            <i class="fa fa-cc-paypal"></i></li>
                        </ul>
                    </li>
                    <li>Policies & Privacy
                        <ul>
                            <li><a href="<?php echo zen_href_link(FILENAME_SHIPPING)?>"><i class="fa fa-refresh"></i> Shipping & Returns</a></li>
                            <li><a href="<?php echo zen_href_link(FILENAME_PRIVACY); ?>"><i class="fa fa-shield"></i> Privacy</a></li>
                            <li><a href="<?php echo zen_href_link(FILENAME_FREQUENTLY_ASKED_QUESTIONS); ?>"><i class="fa fa-question-circle"></i> FAQ</a></li>
                            <li><a href="<?php echo zen_href_link(FILENAME_CONDITIONS); ?>"><i class="fa fa-book"></i> Conditions of Use</a></li>
                            <li><a href="<?php echo zen_href_link(FILENAME_SITE_MAP); ?>"><i class="fa fa-map-marker"></i> Site Map</a></li>
                        </ul>
                    </li>
                    <li>Social Media
                        <ul>
                            <li><a href="<?php echo BOOTSTRAP_BASIC_FACEBOOK_LINK; ?>" target="_blank"><i class="fa fa-facebook"></i> Facebook</a></li>
                            <li><a href="<?php echo BOOTSTRAP_BASIC_TWITTER_LINK; ?>" target="_blank"><i class="fa fa-twitter"></i> Twitter</a></li>
                            <li><a href="<?php echo BOOTSTRAP_BASIC_PINTEREST_LINK; ?>" target="_blank"><i class="fa fa-pinterest"></i> Pinterest</a></li>
                            <li><a href="<?php echo BOOTSTRAP_BASIC_YOUTUBE_LINK; ?>" target="_blank"><i class="fa fa-youtube"></i> YouTube</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!--eof-navigation display -->
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

    <div class="container-fluid" id="footerCopyright">
        <div class="container">

            <!--bof- site copyright display -->
            <div id="siteinfoLegal" class="legalCopyright col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php echo FOOTER_TEXT_BODY; ?>
            </div>
            <!--eof- site copyright display -->
        </div>
    </div>
    <?php
}
