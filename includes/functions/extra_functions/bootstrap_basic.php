<?php
/**
 *  bootstrap_basic.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/8/2017 8:50 PM Modified in  everbrite_coatings
 */


function getBootstrapBasicMenu($id = false)
{
    $parent_id = 0;
    $menu_array = getBootstrapBasicSubMenu($parent_id);
    return $menu_array;
}

function getBootstrapBasicSubMenu($parent_id)
{
    global $db;
    $menu_array = array();
    $menu_items = $db->Execute("SELECT * FROM " . TABLE_BOOTSTRAP_BASIC_MENU . " WHERE parent_id='" . $parent_id . "' ORDER BY sort_order ASC, display_name ASC");
    if ($menu_items->RecordCount() > 0) {
        while (!$menu_items->EOF) {
            $menu_id = $menu_items->fields['bootstrap_basic_menu_id'];
            $submenus = getBootstrapBasicSubMenu($menu_id);
            $menu_array[] = array(
                'menu_id' => $menu_id,
                'parent_id' => $menu_items->fields['parent_id'],
                'display_name' => $menu_items->fields['display_name'],
                'sort_order' => $menu_items->fields['sort_order'],
                'item_type' => $menu_items->fields['item_type'],
                'has_children' => $submenus
            );
            $menu_items->MoveNext();
        }
        return $menu_array;
    } else {
        return false;
    }
}

function get_categories_header_image($categories_id)
{
    global $db;
    $categories_query = $db->Execute("SELECT categories_header_image FROM " . TABLE_CATEGORIES . " WHERE categories_id='" . (int)$categories_id . "'");
    $return = $categories_query->fields['categories_header_image'];
    return $return;
}
