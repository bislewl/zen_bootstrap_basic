<?php
/**
 *  tpl_main_page.php
 *
 * @package
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  4/10/2016 9:38 PM Modified in zen_bootstrap_basic
 */

/** bof DESIGNER TESTING ONLY: */
// $messageStack->add('header', 'this is a sample error message', 'error');
// $messageStack->add('header', 'this is a sample caution message', 'caution');
// $messageStack->add('header', 'this is a sample success message', 'success');
// $messageStack->add('main', 'this is a sample error message', 'error');
// $messageStack->add('main', 'this is a sample caution message', 'caution');
// $messageStack->add('main', 'this is a sample success message', 'success');
/** eof DESIGNER TESTING ONLY */


// the following IF statement can be duplicated/modified as needed to set additional flags
if (in_array($current_page_base, explode(",", 'list_pages_to_skip_all_right_sideboxes_on_here,separated_by_commas,and_no_spaces'))) {
    $flag_disable_right = true;
}


$header_template = 'tpl_header.php';
$footer_template = 'tpl_footer.php';
$left_column_file = 'column_left.php';
$right_column_file = 'column_right.php';
$body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);
?>
<body id="<?php echo $body_id . 'Body'; ?>"<?php if ($zv_onload != '') echo ' onload="' . $zv_onload . '"'; ?>>
<?php
if (SHOW_BANNERS_GROUP_SET1 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET1)) {
    if ($banner->RecordCount() > 0) {
        ?>
        <div class="<?php echo BOOTSTRAP_BASIC_CONTAINER; ?>">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div id="bannerOne" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<?php
/**
 * prepares and displays header output
 *
 */
if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_HEADER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
    $flag_disable_header = true;
}
?>
<?php require($template->get_template_dir('tpl_header.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_header.php'); ?>

<!-- bof  breadcrumb -->
<?php if (DEFINE_BREADCRUMB_STATUS == '1' || (DEFINE_BREADCRUMB_STATUS == '2' && !$this_is_home_page)) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div id="navBreadCrumb"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- eof breadcrumb -->

<div id="mainWrapper" class="<?php echo BOOTSTRAP_BASIC_CONTAINER; ?>">
    <div class="row">
        <?php
        if (COLUMN_LEFT_STATUS == 0 || (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == '') || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_LEFT_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == ''))) {
            // global disable of column_left
            $flag_disable_left = true;
        }
        if (!isset($flag_disable_left) || !$flag_disable_left) {
            ?>
            <div class="<?php echo BOOTSTRAP_BASIC_COL_ONE_CLASS; ?> pull-left">
                <?php
                /**
                 * prepares and displays left column sideboxes
                 *
                 */
                ?>
                <div id="navColumnOneWrapper" style="width: <?php echo BOX_WIDTH_LEFT; ?>">
                    <?php require(DIR_WS_MODULES . zen_get_module_directory('column_left.php')); ?>
                </div>
            </div>
            <?php
        }

        ?>

        <div class="<?php echo BOOTSTRAP_BASIC_COL_TWO_CLASS; ?>">
            <?php
            if (SHOW_BANNERS_GROUP_SET3 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET3)) {
                if ($banner->RecordCount() > 0) {
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div id="bannerThree" class="banners">
                                <?php echo zen_display_banner('static', $banner); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

            <!-- bof upload alerts -->
            <?php
            if ($messageStack->size('upload') > 0) {
                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $messageStack->output('upload'); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <!-- eof upload alerts -->

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php
                    /**
                     * prepares and displays center column
                     *
                     */
                    require($body_code); ?>
                </div>
            </div>

            <?php
            if (SHOW_BANNERS_GROUP_SET4 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET4)) {
                if ($banner->RecordCount() > 0) {
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div id="bannerThree" class="banners">
                                <div id="bannerFour" class="banners">
                                    <?php echo zen_display_banner('static', $banner); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php

        if (COLUMN_RIGHT_STATUS == 0 || (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == '') || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_RIGHT_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == ''))) {
            // global disable of column_right
            $flag_disable_right = true;
        }
        if (!isset($flag_disable_right) || !$flag_disable_right) {
            ?>
            <div class="<?php echo BOOTSTRAP_BASIC_COL_THREE_CLASS; ?> pull-right">
                <?php
                /**
                 * prepares and displays right column sideboxes
                 *
                 */
                ?>
                <div id="navColumnTwoWrapper" style="width: <?php echo BOX_WIDTH_RIGHT; ?>">
                    <?php require(DIR_WS_MODULES . zen_get_module_directory('column_right.php')); ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    /**
     * prepares and displays footer output
     *
     */
    if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_FOOTER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
        $flag_disable_footer = true;
    }
    ?>
</div>
<?php require($template->get_template_dir('tpl_footer.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_footer.php'); ?>
<!--bof- parse time display -->
<?php
if (DISPLAY_PAGE_PARSE_TIME == 'true') {
    ?>
    <div class="<?php echo BOOTSTRAP_BASIC_CONTAINER; ?>">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="smallText center">Parse Time: <?php echo $parse_time; ?> - Number of
                    Queries: <?php echo $db->queryCount(); ?> - Query Time: <?php echo $db->queryTime(); ?></div>
            </div>
        </div>
    </div>
    <?php
}
?>
<!--eof- parse time display -->
<!--bof- banner #6 display -->
<?php
if (SHOW_BANNERS_GROUP_SET6 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET6)) {
    if ($banner->RecordCount() > 0) {
        ?>
        <div class="<?php echo BOOTSTRAP_BASIC_CONTAINER; ?>">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div id="bannerSix" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<!--eof- banner #6 display -->

<?php /* add any end-of-page code via an observer class */
$zco_notifier->notify('NOTIFY_FOOTER_END', $current_page);
?>

</body>
