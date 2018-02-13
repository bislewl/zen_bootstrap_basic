<?php
/**
 *  tpl_box_default_right.php
 *
 * @package
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  4/10/2016 10:12 PM Modified in zen_bootstrap_basic
 */

// choose box images based on box position
if ($title_link) {
    $title = '<a href="' . zen_href_link($title_link) . '">' . $title . BOX_HEADING_LINKS . '</a>';
}
$box_div_id = str_replace('_', '-', $box_id);
//
?>
<!--// bof: <?php echo $box_id; ?> //-->

<div class="rightBoxContainer row" id="<?php echo $box_div_id; ?>" style="width: <?php echo $column_width; ?>">
    <h3 class="rightBoxHeading col-xs-12 col-sm-12 col-md-12 col-lg-12" id="<?php echo $box_div_id . 'Heading'; ?>">
        <?php echo $title; ?>
    </h3>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php echo $content; ?>
    </div>
</div>
<!--// eof: <?php echo $box_id; ?> //-->
