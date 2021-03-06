<?php
/**
 *  tpl_contact_us_default.php
 *
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/30/2016 1:26 PM Modified in zen_bootstrap_basic
 */
?>
<div class="centerColumn" id="contactUsDefault">

    <?php echo zen_draw_form('contact_us', zen_href_link(FILENAME_CONTACT_US, 'action=send', 'SSL')); ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


        <?php if (CONTACT_US_STORE_NAME_ADDRESS == '1') { ?>
            <address><?php echo nl2br(STORE_NAME_ADDRESS); ?></address>
        <?php } ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php
        if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
            ?>

            <div class="mainContent success"><?php echo TEXT_SUCCESS; ?></div>

            <div
                class="buttonRow"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>

            <?php
        } else {
        ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php if (DEFINE_CONTACT_US_STATUS >= '1' and DEFINE_CONTACT_US_STATUS <= '2') { ?>
            <div id="contactUsNoticeContent" class="content">
                <?php
                /**
                 * require html_define for the contact_us page
                 */
                require($define_page);
                ?>
            </div>
        <?php } ?>

        <?php if ($messageStack->size('contact') > 0) echo $messageStack->output('contact'); ?>
    </div>
    <h2><?php echo HEADING_TITLE; ?></h2>
    <div class="alert forward"><?php echo FORM_REQUIRED_INFORMATION; ?></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contact-form-wrapper">


        <?php
        // show dropdown if set
        if (CONTACT_US_LIST != '') {
            ?>
            <div class="form-group">
                <label class="inputLabel" for="send-to"><?php echo SEND_TO_TEXT. '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
                <?php echo zen_draw_pull_down_menu('send_to', $send_to_array, 0, 'id="send-to" class="form-control"'); ?>
            </div>
            <?php
        }
        ?>

        <div class="form-group">
            <label class="inputLabel" for="contactname"><?php echo ENTRY_NAME. '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
            <?php echo zen_draw_input_field('contactname', $name, ' size="40" id="contactname" class="form-control"'); ?>
        </div>

        <div class="form-group">
            <label class="inputLabel" for="email-address"><?php echo ENTRY_EMAIL. '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
            <?php echo zen_draw_input_field('email', ($email_address), ' size="40" id="email-address" class="form-control"') ; ?>
        </div>

        <div class="form-group">
            <label
                for="enquiry"><?php echo ENTRY_ENQUIRY . '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
            <?php echo zen_draw_textarea_field('enquiry', '30', '7', $enquiry, 'id="enquiry" class="form-control"'); ?>
        </div>

        <?php echo zen_draw_input_field('should_be_empty', '', ' size="40" id="CUAS" style="visibility:hidden; display:none;" autocomplete="off"'); ?>

        <button type="submit" class="btn btn-primary btn-lg ">Contact Us</button>
    </div>
<?php
}
?>
    </form>
</div>