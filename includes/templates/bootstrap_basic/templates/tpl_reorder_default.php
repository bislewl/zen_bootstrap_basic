<?php
/**
 * @package page template
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Define Generator v0.1 $
 */


?>
<!-- bof tpl_reorder_default.php -->
<div class='centerColumn' id='reorder'>

    <h1 class="back"><?php echo HEADING_TITLE; ?></h1>
    <div class="alert forward" id="required-information"><?php echo FORM_REQUIRED_INFORMATION; ?></div>

    <?php
    if (DEFINE_CONTACT_US_STATUS >= '1' and DEFINE_CONTACT_US_STATUS <= '2') {
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            require($define_page);
            ?>
        </div>
        <?php
    }
    ?>

    <?php echo zen_draw_form('reorder', zen_href_link(FILENAME_REORDER, 'action=send'), 'post', ' enctype="multipart/form-data" '); ?>

    <?php
    if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
        ?>
        <!--
            /*
             *  Code changed on: May 26, 2014;
             * 	Fixed issue: Layout for success message;
            */
         -->
        <div id="contact-form-wrapper" class="back">
            <p><?php echo TEXT_SUCCESS; ?></p>
            <div
                class="buttonRow"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>
        </div><!--EOF #contact-form-wrapper-->

        <!--
            /*
             *  End Code changed on: May 26, 2014;
            */
        -->

        <?php
    } else {
        ?>


        <?php if ($messageStack->size('reorder') > 0) {

            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                echo $messageStack->output('reorder');
                ?>
            </div>
            <?php
        }
        ?>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="inputLabel" for="orderName">Company/Individual the order is under</label>
                <?php echo zen_draw_input_field('orderName', $order_name, ' size="30" id="orderName" class="form-control"'); ?>
            </div>

            <div class="form-group">
                <label class="inputLabel"
                       for="contactName">Contact
                    Name<?php echo '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
                <?php echo zen_draw_input_field('contactName', $name, ' size="30" id="contactName" class="form-control"'); ?>
            </div>

            <div class="form-group">
                <label class="inputLabel"
                       for="contactName">Previous order number (if known): </label>
                <?php echo zen_draw_input_field('prevOrder', $prev_order, ' size="10" id="prevOrder" class="form-control"'); ?>
            </div>

            <div class="form-group">
                <label class="inputLabel"
                       for="email-address">Contact
                    Email<?php echo '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
                <?php echo zen_draw_input_field('email', ($email_address), ' size="30" id="email-address" class="form-control"'); ?>
            </div>

            <div class="form-group">
                <label class="inputLabel" for="phoneNumber">Phone Number: </label>
                <?php echo zen_draw_input_field('phoneNumber', $phone_number, ' size="20" id="phoneNumber" class="form-control"', 'tel'); ?>
            </div>

            <div class="form-group">

                <label class="inputLabel" for="goodTimeToCall">Good Time to Call: </label>
                <?php echo zen_draw_input_field('goodTimeToCall', $good_time_call, ' size="20" id="goodTimeToCall" class="form-control"'); ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="enquiry">Additional Information</label>
                <?php echo zen_draw_textarea_field('enquiry', '50', '12', $enquiry, 'id="enquiry" class="form-control"'); ?>
                <?php echo zen_draw_input_field('should_be_empty', '', ' size="40" id="CUAS" style="visibility:hidden; display:none;" autocomplete="off"'); ?>
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </div>

        <?php
    }
    ?>


    </form>


</div>
<!-- eof tpl_reorder_default.php -->