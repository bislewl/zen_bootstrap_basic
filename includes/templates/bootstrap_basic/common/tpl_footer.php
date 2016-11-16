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
    $order_by = " order by c.sort_order, cd.categories_name ";

    $categories_footer_links_query = "select c.categories_id, cd.categories_name from " .
        TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                          where c.categories_id=cd.categories_id and c.parent_id= '0' and cd.language_id='" . (int)$_SESSION['languages_id'] . "' and c.categories_status='1'" .
        $order_by.' LIMIT '.(int)BOOTSTRAP_BASIC_CATEGORIES_FOOTER_COUNT;
    $categories_footer_links = $db->Execute($categories_footer_links_query);

    $links_list = array();
    while (!$categories_footer_links->EOF) {

        // currently selected category
        if ((int)$cPath == $categories_footer_links->fields['categories_id']) {
            $new_style = 'category-top';
            $categories_footer_links_current = '<span class="category-subs-selected">' . $categories_footer_links->fields['categories_name'] . '</span>';
        } else {
            $new_style = 'category-top';
            $categories_footer_links_current = $categories_footer_links->fields['categories_name'];
        }

        // create link to top level category
        $links_list[] = '<a class="' . $new_style . '" href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . (int)$categories_footer_links->fields['categories_id']) . '">' . $categories_footer_links_current . '</a> ';
        $categories_footer_links->MoveNext();
    }

    ?>
    <!--bof-navigation display -->
    <div id="footerRow">
        <div class="container">
            <nav class="navbar navbar-default navbar-bottom" role="navigation">
                <ul class="nav navbar-nav footerNav">
                    <li><?php echo BOX_HEADING_CATEGORIES; ?>
                        <ul>
                            <?php
                            foreach ($links_list as $category_link){
                                ?>
                                <li><?php echo $category_link; ?></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <li>Customer Service
                        <ul>
                            <li><a href="<?php echo zen_href_link(FILENAME_CONTACT_US); ?>"><i class="fa fa-phone"></i> <?php echo BOX_INFORMATION_CONTACT; ?></a></li>
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
                            <li><a href="<?php echo zen_href_link(FILENAME_SHIPPING)?>"><i class="fa fa-refresh"></i> <?php echo BOX_INFORMATION_SHIPPING; ?></a></li>
                            <li><a href="<?php echo zen_href_link(FILENAME_PRIVACY); ?>"><i class="fa fa-shield"></i> <?php echo BOX_INFORMATION_PRIVACY; ?></a></li>
                            <li><a href="<?php echo zen_href_link(FILENAME_CONDITIONS); ?>"><i class="fa fa-book"></i> <?php echo BOX_INFORMATION_CONDITIONS; ?></a></li>
                            <li><a href="<?php echo zen_href_link(FILENAME_SITE_MAP); ?>"><i class="fa fa-map-marker"></i> <?php echo BOX_INFORMATION_SITE_MAP; ?></a></li>
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
