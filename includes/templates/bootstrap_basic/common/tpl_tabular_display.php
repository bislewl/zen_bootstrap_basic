<?php
/**
 *  tpl_tabular_display.php
 *
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/15/2016 3:00 PM Modified in box_printing
 */
?>
<div class="table">
    <table id="<?php echo 'cat' . $cPath . 'Table'; ?>" class="tabTable table table-striped">
        <?php
        for ($row = 0; $row < sizeof($list_box_contents); $row++) {
            $r_params = "";
            $c_params = "";
            if (isset($list_box_contents[$row]['params'])) $r_params .= ' ' . $list_box_contents[$row]['params'];
            ?>
            <tr <?php echo $r_params; ?>>
                <?php
                for ($col = 0; $col < sizeof($list_box_contents[$row]); $col++) {
                    $c_params = "";
                    if($row ==0){
                        $c_params = ' scope="row"';
                    }
                    $cell_type = ($row == 0) ? 'th' : 'td';
                    if (isset($list_box_contents[$row][$col]['params'])) $c_params .= ' ' . $list_box_contents[$row][$col]['params'];
                    if (isset($list_box_contents[$row][$col]['align']) && $list_box_contents[$row][$col]['align'] != '') $c_params .= ' align="' . $list_box_contents[$row][$col]['align'] . '"';
                    if ($cell_type == 'th') $c_params .= ' scope="' . $cell_scope . '" id="' . $cell_title . 'Cell' . $row . '-' . $col . '"';
                    if (isset($list_box_contents[$row][$col]['text'])) {
                        ?>
                        <?php echo '<' . $cell_type . $c_params . '>'; ?><?php echo $list_box_contents[$row][$col]['text'] ?><?php echo '</' . $cell_type . '>' . "\n"; ?>
                        <?php
                    }
                }
                ?>
            </tr>
            <?php
        }
        ?>
    </table>
</div>