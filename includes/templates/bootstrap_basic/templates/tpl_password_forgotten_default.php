<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_password_forgotten_default.php 3712 2006-06-05 20:54:13Z drbyte $
 */
?>
<div class="centerColumn" id="passwordForgotten">
    <?php echo zen_draw_form('password_forgotten', zen_href_link(FILENAME_PASSWORD_FORGOTTEN, 'action=process', 'SSL')); ?>

    <?php if ($messageStack->size('password_forgotten') > 0) echo $messageStack->output('password_forgotten'); ?>

    <h2><?php echo HEADING_TITLE; ?></h2>
    <div id="passwordForgottenMainContent" class="content"><?php echo TEXT_MAIN; ?></div>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <div class="form-group">
            <label for="email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
            <?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="email-address"  class="form-control"'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo zen_back_link(); ?>
            <button class="btn btn-primary btn-lg ">Back</button>
            </a>
            <button type="submit" class="btn btn-success btn-lg ">Request Password Reset</button>
        </div>
    </div>
    </form>
</div>