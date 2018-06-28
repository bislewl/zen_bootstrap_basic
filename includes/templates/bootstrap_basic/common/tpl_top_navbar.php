<?php
/**
 *  tpl_top_navbar.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/6/2017 11:10 PM Modified in zen_bootstrap_basic
 */

?>
<nav class="navbar navbar-default" role="navigation">
    <div class="<?php echo BOOTSTRAP_BASIC_CONTAINER; ?>">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>">
                <?php echo HEADER_TITLE_CATALOG; ?>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-left">
                <!--bof categories tabs navigation display-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php require($template->get_template_dir('tpl_modules_categories_tabs.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_categories_tabs.php'); ?>
                    </ul>
                </li>
	            <?php
	            echo $bootstrap_basic->getMenuDropdown();
	            ?>
                <!--eof categories tabs navigation display-->
                <?php if ($_SESSION['customer_id']) { ?>
                    <li><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>">Logoff</a></li>&nbsp;
                    <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>">My Account</a></li>&nbsp;
                    <?php
                } else {
                    ?>
                    <li><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>" title="Login">
                            Customer Login
                        </a>
                    </li>
                    <?php
                }
                ?>
                <?php
                if ($_SESSION['cart']->count_contents() != 0) {
                    ?>
                    <li>
                        <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART); ?>">
                            <i class="fa fa-shopping-cart"></i> Shopping Cart
                            <span class="badge">
                                <?php echo $_SESSION['cart']->count_contents(); ?>
                            </span>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div>
</nav>
