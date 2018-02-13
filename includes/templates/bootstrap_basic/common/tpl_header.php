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

    <div class="<?php echo BOOTSTRAP_BASIC_CONTAINER; ?>" id="topHeader">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="topHeaderLogo">
                <a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>">
                    <img src="<?php echo $template->get_template_dir('logo.png', DIR_WS_TEMPLATE, $current_page_base, 'images') . '/logo.png'; ?>"
                         alt="<?php echo HEADER_TITLE_CATALOG; ?>">
                </a>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="topHeaderTagline">
                <?php echo HEADER_SALES_TEXT; ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="topHeaderPhone">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="tel:<?php echo STORE_TELEPHONE_CUSTSERVICE; ?>"><?php echo STORE_TELEPHONE_CUSTSERVICE; ?></a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="<?php echo zen_href_link(FILENAME_CONTACT_US); ?>">
                        Contact Us
                    </a>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="topHeaderSearch">
                <form action="<?php echo zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', $request_type, false); ?>"
                      class="form-inline">
                    <div class="form-group">
                        <?php
                        echo zen_draw_hidden_field('main_page', FILENAME_ADVANCED_SEARCH_RESULT);
                        echo zen_draw_hidden_field('search_in_description', '1') . zen_hide_session_id();
                        ?>
                        <input name="keyword" type="text" class="form-control"
                               placeholder="<?php echo BOX_HEADING_SEARCH; ?>">
                    </div>
                    <button type="submit" class="btn btn-default"><?php echo BOX_HEADING_SEARCH; ?></button>
                </form>
            </div>


        </div>
    </div>
<?php
require($template->get_template_dir('tpl_top_navbar.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_top_navbar.php');

