<?php
/**
 *  tpl_header.php
 *
 * @package
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  4/10/2016 9:37 PM Modified in zen_bootstrap_basic
 */

?>
<nav class="navbar navbar-default">
    <a href="<?php echo zen_href_link(FILENAME_DEFAULT); ?>" class="hidden-md hidden-lg">
        <img src="images/logo.gif" alt="logo">
    </a>
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".topNavigation"
            aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <div class="container">
        <div class="collapse navbar-collapse navbar-left col-xs-12 col-sm-12 col-md-6 col-lg-6 topNavigation">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo zen_href_link(FILENAME_DEFAULT); ?>">Home</a></li>
                <li><a href="<?php echo zen_href_link(FILENAME_PRODUCTS_ALL); ?>">All Products</a></li>
                <li><a href="<?php echo zen_href_link(FILENAME_REVIEWS); ?>"><?php echo BOX_HEADING_REVIEWS; ?></a></li>
                <li><a href="<?php echo zen_href_link(FILENAME_CONTACT_US); ?>"><?php echo BOX_INFORMATION_CONTACT; ?></a></a></li>
            </ul>
        </div>
        <div class="collapse navbar-collapse navbar-right col-xs-12 col-sm-12 col-md-6 col-lg-6 topNavigation">
            <ul class="nav navbar-nav">
                <?php if ($_SESSION['customer_id']) { ?>
                    <li><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>">Logoff</a></li>&nbsp;
                    <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>">My Account</a></li>&nbsp;
                    <?php
                } else {
                    ?>
                    <li><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>" title="Login">Login – My
                            Account</a></li>
                    <?php
                }
                ?>
                <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT); ?>">Order Status</a></li>
            </ul>
        </div>
    </div>
    <div class="container-fluid headerMiddleContainer">
        <div class="container">
            <div
                class="collapse navbar-collapse navbar-left col-xs-12 col-sm-12 col-md-12 col-lg-12 topNavigation headerMiddleWideRow">
                <ul class="nav navbar-nav headerMiddleWideRow">
                    <li class="hidden-xs hidden-sm" id="headerMiddleLogo">
                        <a href="<?php echo zen_href_link(FILENAME_DEFAULT); ?>">
                            <img src="images/logo.gif" alt="logo">
                        </a>
                    </li>
                    <li class="hidden-xs hidden-sm" id="headerMiddlePhone">
                        <a href="tel:<?php echo STORE_TELEPHONE_CUSTSERVICE; ?>"><?php echo STORE_TELEPHONE_CUSTSERVICE; ?></a>
                    </li>
                    <li class="headerMiddleRight hidden-xs hidden-sm">
                        <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART); ?>"><i
                                class="fa fa-shopping-cart"></i><?php echo BOX_HEADING_SHOPPING_CART; ?> <?php echo $_SESSION['cart']->count_contents(); ?> Items</a>
                    </li>
                    <li class="headerMiddleRight hidden-xs hidden-sm" id="headerMiddleSearch">
                        <div>
                            <form class="navbar-form navbar-right"
                                  action="<?php echo zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', $request_type, false); ?>">
                                <div class="form-group">
                                    <?php
                                    echo zen_draw_hidden_field('main_page', FILENAME_ADVANCED_SEARCH_RESULT);
                                    echo zen_draw_hidden_field('search_in_description', '1') . zen_hide_session_id();
                                    ?>
                                    <input name="keyword" type="text" class="form-control" placeholder="<?php echo BOX_HEADING_SEARCH; ?>">
                                </div>
                                <button type="submit" class="btn btn-default"><?php echo BOX_HEADING_SEARCH; ?></button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="lowerNavigationMenu"
             class="collapse navbar-collapse navbar-left col-xs-12 col-sm-12 col-md-12 col-lg-12 topNavigation">
            <ul class="nav navbar-nav">

                <!--bof-optional categories tabs navigation display-->
                <?php require($template->get_template_dir('tpl_modules_categories_tabs.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_categories_tabs.php'); ?>
                <!--eof-optional categories tabs navigation display-->
            </ul>
        </div>
    </div>
</nav>