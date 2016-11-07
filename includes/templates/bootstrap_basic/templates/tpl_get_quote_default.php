<?php
/**
 * @package page template
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Define Generator v0.1 $
 */

// THIS FILE IS SAFE TO EDIT! This is the template page for your new page 

?>
<!-- bof tpl_get_quote_default.php -->
<div class='centerColumn' id='get_quote'>

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

    <?php echo zen_draw_form('contact_us', zen_href_link(FILENAME_DEFINE_GET_QUOTE, 'action=send'), 'post', ' enctype="multipart/form-data" '); ?>

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

        <?php if ($messageStack->size('contact') > 0) echo $messageStack->output('contact'); ?>

        <!--
<?php
        // show dropdown if set
        if (CONTACT_US_LIST != '') {
            ?>
<label class="inputLabel" for="send-to"><?php echo SEND_TO_TEXT; ?></label>
<?php echo zen_draw_pull_down_menu('send_to', $send_to_array, 0, 'id="send-to"') . '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?>
<br class="clearBoth" />
<?php
        }
        ?>
-->

        <div id="contact-form-wrapper" class="back">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="inputLabel"
                           for="contactname">Contact
                        Name: <?php echo '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
                    <?php echo zen_draw_input_field('contactname', $name, ' size="30" id="contactname" class="form-control"\''); ?>
                </div>
                <div class="form-group">
                    <label class="inputLabel"
                           for="email-address"><?php echo ENTRY_EMAIL; ?><?php echo '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
                    <?php echo zen_draw_input_field('email', ($email_address), ' size="30" id="email-address" class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label class="inputLabel" for="phoneNumber">Phone Number: </label>
                    <?php echo zen_draw_input_field('phoneNumber', $phone_number, ' size="20" id="phoneNumber" class="form-control"', 'tel'); ?>
                </div>
                <div class="form-group">
                    <label class="inputLabel" for="productType">Product: </label>
                    <?php
                    echo zen_draw_pull_down_menu('productType', $product_type_values, $product_type_default, 'id="productType" class="form-control"', $required = false)
                    ?>
                </div>
                <div class="form-group">
                    <label class="inputLabel" for="productOther">Other: </label>
                    <?php echo zen_draw_input_field('productOther', $paper_other, ' size="20" id="productOther" class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label class="inputLabel" for="finishedSize">Finished Size: </label>
                    <?php echo zen_draw_input_field('finishedSize', $finished_size, ' size="30" id="finishedSize" placeholder="Length X Width X Height" class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label class="inputLabel" for="imprintedPanels">Imprinted Panels: </label>
                    <?php
                    echo zen_draw_pull_down_menu('imprintedPanels', $imprinted_panels_values, $imprinted_panels_default, 'id="imprintedPanels" class="form-control"', $required = false)
                    ?>
                </div>
                <div class="form-group">
                    <label class="inputLabel" for="inkColor">Ink Color: </label>
                    <?php echo zen_draw_input_field('inkColor', $ink_color, ' size="15" id="inkColor" class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label class="inputLabel" for="quoteQty">Quantity: </label>
                    <?php echo zen_draw_input_field('quoteQty', $quote_qty, ' size="15" id="quoteQty" class="form-control"'); ?>
                </div>
                <div class="form-group">

                    <label class="inputLabel" for="zipCode">Zipcode: </label>
                    <?php echo zen_draw_input_field('zipCode', $zipcode, ' size="15" id="zipCode" class="form-control"'); ?>
                </div>
            </div><!--EOF #contact-col-left-->

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label
                        for="enquiry"><?php echo ENTRY_ENQUIRY . ' <span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
                    <?php echo zen_draw_textarea_field('enquiry', '30', '7', $enquiry, 'id="enquiry" class="form-control"'); ?>
                    <?php echo zen_draw_input_field('should_be_empty', '', ' size="40" id="CUAS" style="visibility:hidden; display:none;" autocomplete="off"'); ?>
                </div>

                <label class="inputLabel"
                       for="quote_file"><?php echo ENTRY_UPLOAD_FILE; ?><?php echo '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
                <?php echo zen_draw_file_field('quote_file'); ?>

                <button type="submit" class="btn btn-primary btn-lg ">Request a Quote</button>
            </div>



        </div><!--EOF #contact-form-wrapper-->

        <?php
    }
    ?>
    </form>


</div>
<!-- eof tpl_get_quote_default.php -->
