<?php
/**
 *  class.bootstrap_basic.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/11/2017 2:10 PM Modified in  everbrite_coatings
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

class bootstrap_basic extends base
{
    var $menu_tiers, $max_tiers, $dropdown;

    function __construct()
    {
        $this->menu_tiers = array();
        $this->parent_start = 0;
        $this->dropdown = false;
    }

    function getMenuDropdown($parent = 0, $max_tiers = 99)
    {
        $this->max_tiers = $max_tiers;
        $this->parent_start = $parent;
        $this->dropdown = true;
        $html = $this->getMenuItemList($parent);
        return $html;
    }

    function getMenuColumnList($parent = 0, $max_tiers = 99)
    {
        $this->max_tiers = $max_tiers;
        $this->parent_start = $parent;
        $this->dropdown = false;
        $html = $this->getMenuItemList($parent);
        return $html;
    }

    function getMenuItemDetails($item_id)
    {
        global $db;
        $item_detail = $db->Execute("SELECT * FROM " . TABLE_BOOTSTRAP_BASIC_MENU . " WHERE bootstrap_basic_menu_id='" . (int)$item_id . "'");
        $display_name = $item_detail->fields['display_name'];
        $class_li = '';
        $params_li = '';
        $class_a = '';
        $params_a = '';
        $href = '';
        $html = '';
        $item_type = $item_detail->fields['item_type'];
        $parent = ($item_detail->fields['parent_item'] == '1') ? true : false;

        switch ($item_type) {
            case 'link':
                $href = $item_detail->fields['menu_link'];
                break;
            case 'text':
                $href = '#';
//                $class_li = 'dropdown';
//                $params_a = 'data-toggle="dropdown"';
//                if ($item_detail->fields['parent_id'] == 0) {
//                    $display_name = $display_name . ' ' . '<i class="fa fa-chevron-down"></i>';
//                }
//                if ($item_detail->fields['parent_id'] != 0) {
//                    $class_li .= ' dropdown-submenu';
//                    $params_a .= 'tabindex="-1" ';
////                    $display_name = $display_name . ' ' . '<i class="fa fa-chevron-right"></i>';
//                }
                break;
            case 'divider':
                $class_li = 'divider';
                $display_name = '';
                break;
            case 'product':
                $products_id = $item_detail->fields['menu_link'];
                $href = zen_href_link(zen_get_info_page($products_id), 'cPath=' . (zen_get_generated_category_path_rev(zen_get_products_category_id($products_id))) . '&products_id=' . $products_id);
                break;
            case 'category':
                $cPath = zen_get_generated_category_path_rev($item_detail->fields['menu_link']);
                $href = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cPath);
                break;
            case 'ez_page':
                $href = zen_href_link(FILENAME_EZPAGES, 'id=' . (int)$item_detail->fields['menu_link']);
                break;
            case 'define_page':
                $href = zen_href_link($item_detail->fields['menu_link']);
                break;
            case 'cat_dropdown':
                $category_id = $item_detail->fields['menu_link'];

                break;
            default:
                break;
        }
        if ($item_type == 'cat_dropdown') {
            $yogalifestyle = new yogalifestyle();
            $html = $yogalifestyle->categoryDropdownMenu($category_id);
        } elseif ($parent == true && $this->dropdown == true) {
            $class_li = 'dropdown';
            $params_a = 'data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"';
            if ($item_detail->fields['parent_id'] == $this->parent_start) {
//                $display_name = $display_name . ' ' . '<i class="fa fa-chevron-down"></i>';
            }
            if ($item_detail->fields['parent_id'] != $this->parent_start) {
                $class_li .= ' dropdown-submenu';
                $params_a .= 'tabindex="-1" ';
//                    $display_name = $display_name . ' ' . '<i class="fa fa-chevron-right"></i>';
            }
            if ($item_type != 'text' && $item_type != 'divider') {
                $class_a = "clickParentLinkLoad";
            }
            if ($this->menu_tiers[$item_detail->fields['parent_id']] > 1) {
                $params_a = '';
                $class_a = '';
            }
            $html .= '<li class="' . $class_li . ' " ' . $params_li . '>';
            if ($href != '') {
                $html .= '<a href="' . $href . '" class="' . $class_a . '" ' . $params_a . '>' . $display_name . '</a>';
            }
            if ($parent) {
                $html .= $this->getMenuItemList($item_id);
            }
            $html .= '</li>';
        } elseif ($this->dropdown == false) {
            if ($parent == true) {
                $class_a = '';
                $params_a = '';
                $html .= '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">';
                if ($href != '') {
                    $html .= '<a href="' . $href . '" class="' . $class_a . '" ' . $params_a . '>' . $display_name . '</a>';
                }
                $html .= '<ul class="columnMenuList">';
                $html .= $this->getMenuItemList($item_id);
                $html .= '</ul>';
                $html .= '</div>';
            } else {
                $html .= '<li class="' . $class_li . ' " ' . $params_li . '>';
                if ($href != '') {
                    $html .= '<a href="' . $href . '" class="' . $class_a . '" ' . $params_a . '>' . $display_name . '</a>';
                }
                if ($parent) {
                    $html .= $this->getMenuItemList($item_id);
                }
                $html .= '</li>';
            }
        } elseif ($parent == false) {
            $html .= '<li class="' . $class_li . ' " ' . $params_li . '>';
            if ($href != '') {
                $html .= '<a href="' . $href . '" class="' . $class_a . '" ' . $params_a . '>' . $display_name . '</a>';
            }
            $html .= '</li>';
        }
        return $html;
    }

    function getMenuItemList($parent)
    {
        global $db;
        if ($this->dropdown) {
            if ($parent == $this->parent_start) {
                $html = '';
                $this->menu_tiers[$parent] = 1;
            }
            if ($this->menu_tiers[$parent] == 2) {
                $html = '<ul class="dropdown-menu multi-level dropdown-menu-tier-2" role="menu" aria-labelledby="dropdownMenu" id="bbMenuParent-' . $parent . '">';
            }
            if ($this->menu_tiers[$parent] > 2) {
                $tier = $this->menu_tiers[$parent];
                $html = '<ul class="dropdown-menu-tier-' . $tier . '" id="bbMenuParent-' . $parent . '">';
            }
        }
        $parental_list = $db->Execute("SELECT bootstrap_basic_menu_id FROM " . TABLE_BOOTSTRAP_BASIC_MENU . " WHERE parent_id='" . $parent . "' ORDER BY sort_order ASC");
        while (!$parental_list->EOF) {
            $menu_id = $parental_list->fields['bootstrap_basic_menu_id'];
            $this->menu_tiers[$menu_id] = $this->menu_tiers[$parent] + 1;
            $next_tier = $this->menu_tiers[$parent] + 1;
            if ($next_tier > $this->max_tiers) {
                break;
            } else {
                $html .= $this->getMenuItemDetails($menu_id);
            }
            $parental_list->MoveNext();
        }
        if ($this->dropdown) {
            if ($this->menu_tiers[$parent] > 1) {
                $html .= '</ul>';
            }
        }
        return $html;
    }

    function getCategoryDropdown($cat_id)
    {
        global $db;
        $main_cPath = zen_get_generated_category_path_rev((int)$cat_id);
        $cat_lookup = $db->Execute("SELECT c.categories_id, cd.categories_name, c.categories_image, c.parent_id FROM " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd 
        WHERE c.categories_id = cd.categories_id AND c.categories_id='" . (int)$cat_id . "'");
        $categories_query = "SELECT c.categories_id, cd.categories_name, c.categories_image, c.parent_id FROM " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd 
        WHERE c.categories_id = cd.categories_id  AND c.categories_status=1  AND cd.language_id = '" . (int)$_SESSION['languages_id'] . "' AND parent_id='" . (int)$cat_id . "'" .
            " ORDER BY c.parent_id, c.sort_order, cd.categories_name";
        $categories = $db->Execute($categories_query);
        $dropdown = '<li class="dropdown">';
        $dropdown .= '<a href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $main_cPath) . '" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">';
        $dropdown .= $cat_lookup->fields['categories_name'];
        $dropdown_cats = '';
        if ($categories->RecordCount() > 0) {
            while (!$categories->EOF) {
                $ci_cpath = $main_cPath . '_' . $categories->fields['categories_id'];
                $cat_li = '<li>';
                $cat_li .= '<a href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $ci_cpath) . '" >';
                $cat_li .= $categories->fields['categories_name'];
                $cat_li .= '</a>';
                $cat_li .= '</li>';
                $dropdown_cats .= $cat_li;
                $categories->MoveNext();
            }

        } else {
//            $dropdown .= $categories_query;
        }
        if ($dropdown_cats != '') {
            $dropdown .= '<span class="mobileDropDownClosed mobileDropDownChevron"><i class="fa fa-chevron-right"></i></span>';
            $dropdown .= '<span class="mobileDropDownOpened mobileDropDownChevron"><i class="fa fa-chevron-down"></i></span>';
            $dropdown .= '</a>';
            $dropdown .= '<div class="dropdown-menu multi-level" role="menu">';
            $dropdown .= '<ul>';
            $dropdown .= $dropdown_cats;
            $dropdown .= '</ul>';
            $dropdown .= '</div>';
        } else {
            $dropdown .= '</a>';
        }
        $dropdown .= '</li>';
        return $dropdown;
    }

    function getColumnClasses($bb_disable_left, $bb_disable_right)
    {
        $width_array = array(
            'xs' => explode(',', BOOTSTRAP_BASIC_WIDTH_XS),
            'sm' => explode(',', BOOTSTRAP_BASIC_WIDTH_SM),
            'md' => explode(',', BOOTSTRAP_BASIC_WIDTH_MD),
            'lg' => explode(',', BOOTSTRAP_BASIC_WIDTH_LG),
        );
        $col_class = array(0 => '', 1 => '', 2 => '');
        foreach ($width_array as $w_key => $width) {
            if ($bb_disable_left) $width[0] = 0;
            if ($bb_disable_right) $width[2] = 0;
            if (array_sum($width) != 12) {
                $width[1] = (12 - $width[0] - $width[2]);
            }
            $col_class[0] .= ($width[0] == 0) ? ' hidden-' . $w_key : ' col-' . $w_key . '-' . $width[0];
            $col_class[1] .= ($width[1] == 0) ? ' hidden-' . $w_key : ' col-' . $w_key . '-' . $width[1];
            $col_class[2] .= ($width[2] == 0) ? ' hidden-' . $w_key : ' col-' . $w_key . '-' . $width[2];
        }
        return $col_class;
    }

}