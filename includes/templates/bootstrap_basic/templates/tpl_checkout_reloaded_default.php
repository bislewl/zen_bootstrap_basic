<?php
/*
 * 
 * @package checkout_reloaded
 * @copyright Copyright 2003-2015 ZenCart.Codes a Pro-Webs Company
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @filename checkout_reloaded.php
 * @file created 2015-01-17 12:42:23 AM
 * 
 */
?>
<?php if (isset($flag_disable_header) || $flag_disable_header) { ?>
<?php if (DEFINE_BREADCRUMB_STATUS == '1' || (DEFINE_BREADCRUMB_STATUS == '2' && !$this_is_home_page) ) { ?>
<div class="breadCrumbWrapper"><div id="navBreadCrumb" class="container"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HEADER_TITLE_CATALOG.'</a>'; ?></div></div>
<?php } ?>
<?php } ?>
<div class="centerColumn" id="checkoutReloaded">
    <div style="height:1000px"></div> 
</div>