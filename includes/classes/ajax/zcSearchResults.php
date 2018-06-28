<?php

/**
 * Created by PhpStorm.
 * User: bislewl
 * Date: 6/7/2017
 * Time: 1:11 AM
 */

class zcSearchResults extends base
{
    public function getResults()
    {
        global $messageStack, $template, $breadcrumb, $template_dir_select, $template_dir, $language_page_directory, $currencies, $order, $zco_notifier, $db, $current_page_base, $order_total_modules, $credit_covers;

        header('Content-Type: application/json');

        $_POST['keyword'] = trim(urldecode($_POST['keyword']));

        if (!isset($_GET['search_in_description'])) {
            if (RELOADED_SEARCH_PRODUCT_DESCRIPTION_WEIGHT > 0) {
                $search_in_description = 1;
            } else {
                $search_in_description = 0;
            }
        } else {
            $search_in_description = (int)$_GET['search_in_description'];
        }


        if ((isset($_POST['keyword']) && (empty($_POST['keyword']) || $_POST['keyword'] == HEADER_SEARCH_DEFAULT_TEXT || $_POST['keyword'] == KEYWORD_FORMAT_STRING)) &&
            (isset($_GET['dfrom']) && (empty($_GET['dfrom']) || ($_GET['dfrom'] == DOB_FORMAT_STRING))) &&
            (isset($_GET['dto']) && (empty($_GET['dto']) || ($_GET['dto'] == DOB_FORMAT_STRING))) &&
            (isset($_GET['pfrom']) && !is_numeric($_GET['pfrom'])) &&
            (isset($_GET['pto']) && !is_numeric($_GET['pto']))
        ) {
            $error = true;
            $missing_one_input = true;
            $messageStack->add_session('search', ERROR_AT_LEAST_ONE_INPUT);
        } else {
            $dfrom = '';
            $dto = '';
            $pfrom = '';
            $pto = '';
            $keywords = '';

            if (isset($_GET['dfrom'])) {
                $dfrom = (($_GET['dfrom'] == DOB_FORMAT_STRING) ? '' : $_GET['dfrom']);
            }

            if (isset($_GET['dto'])) {
                $dto = (($_GET['dto'] == DOB_FORMAT_STRING) ? '' : $_GET['dto']);
            }

            if (isset($_GET['pfrom'])) {
                $pfrom = $_GET['pfrom'];
            }

            if (isset($_GET['pto'])) {
                $pto = $_GET['pto'];
            }

            if (isset($_POST['keyword']) && $_POST['keyword'] != HEADER_SEARCH_DEFAULT_TEXT && $_POST['keyword'] != KEYWORD_FORMAT_STRING) {
                $keywords = $_POST['keyword'];
            }

            $date_check_error = false;
            if (zen_not_null($dfrom)) {
                if (!zen_checkdate($dfrom, DOB_FORMAT_STRING, $dfrom_array)) {
                    $error = true;
                    $date_check_error = true;

                    $messageStack->add_session('search', ERROR_INVALID_FROM_DATE);
                }
            }

            if (zen_not_null($dto)) {
                if (!zen_checkdate($dto, DOB_FORMAT_STRING, $dto_array)) {
                    $error = true;
                    $date_check_error = true;

                    $messageStack->add_session('search', ERROR_INVALID_TO_DATE);
                }
            }

            if (($date_check_error == false) && zen_not_null($dfrom) && zen_not_null($dto)) {
                if (mktime(0, 0, 0, $dfrom_array[1], $dfrom_array[2], $dfrom_array[0]) > mktime(0, 0, 0, $dto_array[1], $dto_array[2], $dto_array[0])) {
                    $error = true;

                    $messageStack->add_session('search', ERROR_TO_DATE_LESS_THAN_FROM_DATE);
                }
            }

            $price_check_error = false;
            if (zen_not_null($pfrom)) {
                if (!settype($pfrom, 'float')) {
                    $error = true;
                    $price_check_error = true;

                    $messageStack->add_session('search', ERROR_PRICE_FROM_MUST_BE_NUM);
                }
            }

            if (zen_not_null($pto)) {
                if (!settype($pto, 'float')) {
                    $error = true;
                    $price_check_error = true;

                    $messageStack->add_session('search', ERROR_PRICE_TO_MUST_BE_NUM);
                }
            }

            if (($price_check_error == false) && is_float($pfrom) && is_float($pto)) {
                if ($pfrom > $pto) {
                    $error = true;

                    $messageStack->add_session('search', ERROR_PRICE_TO_LESS_THAN_PRICE_FROM);
                }
            }

            if (zen_not_null($keywords)) {
                if (!zen_parse_search_string(stripslashes($keywords), $search_keywords)) {
                    $error = true;

                    $messageStack->add_session('search', ERROR_INVALID_KEYWORDS);
                }
            }
        }

        if (empty($dfrom) && empty($dto) && empty($pfrom) && empty($pto) && empty($keywords)) {
            $error = true;
            // redundant should be able to remove this
            if (!$missing_one_input) {
                $messageStack->add_session('search', ERROR_AT_LEAST_ONE_INPUT);
            }
        }

        if ($error == true) {

            zen_redirect(zen_href_link(FILENAME_ADVANCED_SEARCH, zen_get_all_get_params(), 'NONSSL', true, false));
        }


        $define_list = array(
            'PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
            'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
            'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
            'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
            'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
            'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
            'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE
        );

        asort($define_list);

        $column_list = array();
        reset($define_list);
        while (list($column, $value) = each($define_list)) {
            if ($value) $column_list[] = $column;
        }

        $select_column_list = '';

        for ($col = 0, $n = sizeof($column_list); $col < $n; $col++) {
            if (($column_list[$col] == 'PRODUCT_LIST_NAME') || ($column_list[$col] == 'PRODUCT_LIST_PRICE')) {
                continue;
            }

            if (zen_not_null($select_column_list)) {
                $select_column_list .= ', ';
            }

            switch ($column_list[$col]) {
                case 'PRODUCT_LIST_MODEL':
                    $select_column_list .= 'p.products_model';
                    break;
                case 'PRODUCT_LIST_MANUFACTURER':
                    $select_column_list .= 'm.manufacturers_name';
                    break;
                case 'PRODUCT_LIST_QUANTITY':
                    $select_column_list .= 'p.products_quantity';
                    break;
                case 'PRODUCT_LIST_IMAGE':
                    $select_column_list .= 'p.products_image';
                    break;
                case 'PRODUCT_LIST_WEIGHT':
                    $select_column_list .= 'p.products_weight';
                    break;
            }
        }


// always add quantity regardless of whether or not it is in the listing for add to cart buttons
        if (PRODUCT_LIST_QUANTITY < 1) {
            if (empty($select_column_list)) {
                $select_column_list .= ' p.products_quantity ';
            } else {
                $select_column_list .= ', p.products_quantity ';
            }
        }

        if (zen_not_null($select_column_list)) {
            $select_column_list .= ', ';
        }

// Notifier Point
        $zco_notifier->notify('NOTIFY_SEARCH_COLUMNLIST_STRING');

        $select_str = "SELECT DISTINCT " . $select_column_list .
            " m.manufacturers_id, p.products_id, pd.products_name, pd.products_description, pd.products_image_alt, p.products_price, p.products_tax_class_id, p.product_is_always_free_shipping, p.products_price_sorter, p.products_qty_box_status, p.master_categories_id, p.products_quantity_order_min, p.products_quantity_order_max ";

//Weighted Search BOF
        $keywords = $db->prepare_input($keywords);
        $keyword_array = explode(' ', $keywords);

        $saxon = '';
        foreach ($keyword_array as $word) {
            $saxon .= ' ' . reloaded_singular($word) . '* ' . reloaded_plural($word) . '*';
        }
        $saxon = trim($saxon);
        $boolean_keywords = $saxon;
        $keywords = str_replace('*', '', $saxon);

        unset($saxon);
        unset($keyword_array);

//Get standard deviation of products viewed
        $products_std_dev = $db->Execute("SELECT STD(products_viewed) as deviation FROM " . TABLE_PRODUCTS_DESCRIPTION, 1, true, 30);
        $products_std_deo = $db->Execute("SELECT STD(products_ordered) as deviation FROM " . TABLE_PRODUCTS, 1, true, 30);
        $init_search_string = trim(trim(zen_db_prepare_input($_REQUEST['keyword']), '%20'));

        $search_string_length = strlen($init_search_string);
        $search_string = $init_search_string;
        $return_array['no_weight']['config_values'] = explode(',', RELOADED_SEARCH_NO_WEIGHT_WORDS);
        $return_array['no_weight']['search_string'] = $init_search_string;
        foreach (explode(',', RELOADED_SEARCH_NO_WEIGHT_WORDS) as $no_weight_word) {
            $no_weight_word = strtolower($no_weight_word);
            $no_weight_word = trim($no_weight_word, '%20');
            $no_weight_word_length = strlen($no_weight_word);
            $search_string = str_replace('%20' . $no_weight_word . '%20', '', $search_string);
            $search_pos_string = '|' . $search_string;
            $infront = strpos(strtolower($search_pos_string), $no_weight_word . '%20');
            $in_string_pos = strpos(strtolower($search_string), '%20' . $no_weight_word);
            $search_string = ($in_string_pos == ($search_string_length - $no_weight_word_length - 3)) ? substr($search_string, 0, 0 - ($no_weight_word_length + 3)) : $search_string;
            $search_string = ($infront == 1) ? substr($search_string, $no_weight_word_length + 3) : $search_string;
            $return_array['no_weight']['words'][] = array(
                'word' => $no_weight_word,
                'word_length' => $no_weight_word_length,
                'infront' => $infront,
                'instring' => $in_string_pos
            );
        }
        $search_string = (strlen($search_string) == 0) ? $init_search_string : $search_string;
        $search_words = explode(" ", $search_string);
        $return_array['no_weight']['ending_search_string'] = $search_string;
//        $search_words = array_diff($search_words, );
        $array_lookups = array();
//        $array_lookups[] = array('columns' => 'pd.products_name', 'weight' => RELOADED_SEARCH_NAME_EXACT_WEIGHT);

        $array_lookups[] = array('columns' => 'pd.products_name', 'weight' => RELOADED_SEARCH_PRODUCT_NAME_WEIGHT);
        $array_lookups[] = array('columns' => 'pd.products_description', 'weight' => RELOADED_SEARCH_PRODUCT_DESCRIPTION_WEIGHT);
        $array_lookups[] = array('columns' => 'm.manufacturers_name', 'weight' => RELOADED_SEARCH_PRODUCT_MANUFACTURER_WEIGHT);
        $array_lookups[] = array('columns' => 'p.products_model', 'weight' => RELOADED_SEARCH_PRODUCT_MODEL_WEIGHT);
        $array_lookups[] = array('columns' => 'mtpd.metatags_keywords, mtpd.metatags_description', 'weight' => RELOADED_SEARCH_PRODUCT_META_KEYWORD_WEIGHT);
        $select_str .= ', (';
        $columns_search_array = array();
        foreach ($array_lookups as $lookup) {
            $keyword_select_array = array();
            foreach ($search_words as $search_word) {
                $where_match_array[] = "MATCH(" . $lookup['columns'] . ") AGAINST(\"" . $search_word . "\" IN BOOLEAN MODE),";
                $keyword_select_string = ' (';
                $keyword_select_string .= "IF( ";
                $keyword_select_string .= "MATCH(" . $lookup['columns'] . ") AGAINST(\"" . $search_word . "\" IN BOOLEAN MODE),";
                $keyword_select_string .= "MATCH(" . $lookup['columns'] . ") AGAINST(\"" . $search_word . "\" IN BOOLEAN MODE), 0";
                $keyword_select_string .= ") ";
                $keyword_select_array[] = $keyword_select_string;
            }
            $columns_search_array[] = " (" . implode(" + ", $keyword_select_array) . ") * " . $lookup['weight'] . " )";
        }

        $select_str .= " " . implode(" + ", $columns_search_array);
        $select_str .= " + (pd.products_viewed / " . $products_std_dev->fields['deviation'] * RELOADED_SEARCH_PRODUCT_VIEWED_WEIGHT . ") ";
        $select_str .= " + (p.products_ordered / " . " IF(" . $products_std_deo->fields['deviation'] . " > 0, " . $products_std_deo->fields['deviation'] . ", 1 ) * " . (int)RELOADED_SEARCH_PRODUCT_SALES_WEIGHT . ")";
        $select_str .= ") as weight ";

//        $select_str .= '(descriptionWeight + descriptionWeight) as weight ';
//        $select_str .= ", IF( pd.products_name LIKE \"" . $db->prepare_input($_REQUEST['keyword']) . "\", " . RELOADED_SEARCH_NAME_EXACT_WEIGHT . " , ";
//        $select_str .= " (";
//        $select_str .= " IF( pd.products_name LIKE \"" . $db->prepare_input($_REQUEST['keyword']) . "%\", " . RELOADED_SEARCH_PRODUCT_NAME_WEIGHT . ", 0 ) as nameWeight";
//        $select_str .= " + IF( MATCH(pd.products_name" . (($search_in_description == 1) ? ", pd.products_description" : "") . ") AGAINST(\"" . $keywords . "\"),MATCH(pd.products_name" . (($search_in_description == 1) ? ", pd.products_description" : "") . ") AGAINST(\"" . $keywords . "\") * " . RELOADED_SEARCH_PRODUCT_DESCRIPTION_WEIGHT . ", 0) ";
//        $select_str .= " + IF( MATCH(m.manufacturers_name) AGAINST(\"" . $keywords . "\"), MATCH(m.manufacturers_name) AGAINST(\"" . $keywords . "\") * " . RELOADED_SEARCH_PRODUCT_MANUFACTURER_WEIGHT . ", 0 )";
//        $select_str .= " + IF( MATCH(p.products_model) AGAINST(\"" . $keywords . "\"), MATCH(p.products_model) AGAINST(\"" . $keywords . "\") * " . RELOADED_SEARCH_PRODUCT_MODEL_WEIGHT . ", 0)";
//        $select_str .= " + IF( MATCH(mtpd.metatags_keywords, mtpd.metatags_description) AGAINST(\"" . $keywords . "\"), MATCH(mtpd.metatags_keywords, mtpd.metatags_description) AGAINST(\"" . $keywords . "\")* " . RELOADED_SEARCH_PRODUCT_META_KEYWORD_WEIGHT . ", 0)";
//        $select_str .= " + (p.products_ordered / " . $products_std_deo->fields['deviation'] * RELOADED_SEARCH_PRODUCT_SALES_WEIGHT . ")";
//        $select_str .= " + (pd.products_viewed / " . $products_std_dev->fields['deviation'] * RELOADED_SEARCH_PRODUCT_VIEWED_WEIGHT . ") ";
//        $select_str .= "))";
//        $select_str .= " as weight ";

//Weighted Search EOF

        if ((DISPLAY_PRICE_WITH_TAX == 'true') && ((isset($_GET['pfrom']) && zen_not_null($_GET['pfrom'])) || (isset($_GET['pto']) && zen_not_null($_GET['pto'])))) {
            $select_str .= ", SUM(tr.tax_rate) AS tax_rate ";
        }

// Notifier Point
        $zco_notifier->notify('NOTIFY_SEARCH_SELECT_STRING');


//  $from_str = "from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m using(manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c";
        $from_str = "FROM (" . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_MANUFACTURERS . " m";
        $from_str .= " USING(manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c )";
        $from_str .= " LEFT JOIN " . TABLE_META_TAGS_PRODUCTS_DESCRIPTION . " mtpd ON mtpd.products_id= p2c.products_id AND mtpd.language_id = :languagesID";

        $from_str = $db->bindVars($from_str, ':languagesID', $_SESSION['languages_id'], 'integer');

        if ((DISPLAY_PRICE_WITH_TAX == 'true') && ((isset($_GET['pfrom']) && zen_not_null($_GET['pfrom'])) || (isset($_GET['pto']) && zen_not_null($_GET['pto'])))) {
            if (!$_SESSION['customer_country_id']) {
                $_SESSION['customer_country_id'] = STORE_COUNTRY;
                $_SESSION['customer_zone_id'] = STORE_ZONE;
            }
            $from_str .= " LEFT JOIN " . TABLE_TAX_RATES . " tr ON p.products_tax_class_id = tr.tax_class_id LEFT JOIN " . TABLE_ZONES_TO_GEO_ZONES . " gz";
            $from_str .= " ON tr.tax_zone_id = gz.geo_zone_id";
            $from_str .= " AND (gz.zone_country_id IS null OR gz.zone_country_id = 0 OR gz.zone_country_id = :zoneCountryID)";
            $from_str .= " AND (gz.zone_id IS null OR gz.zone_id = 0 OR gz.zone_id = :zoneID)";

            $from_str = $db->bindVars($from_str, ':zoneCountryID', $_SESSION['customer_country_id'], 'integer');
            $from_str = $db->bindVars($from_str, ':zoneID', $_SESSION['customer_zone_id'], 'integer');
        }

// Notifier Point
        $zco_notifier->notify('NOTIFY_SEARCH_FROM_STRING');

        $where_str = " WHERE (p.products_status = 1 AND p.products_id = pd.products_id AND pd.language_id = :languagesID AND p.products_id = p2c.products_id AND p2c.categories_id = c.categories_id ";

        $where_str = $db->bindVars($where_str, ':languagesID', $_SESSION['languages_id'], 'integer');

// reset previous selection
        if (!isset($_GET['inc_subcat'])) {
            $_GET['inc_subcat'] = '0';
        }

        if (isset($_GET['categories_id']) && zen_not_null($_GET['categories_id'])) {
            if ($_GET['inc_subcat'] == '1') {
                $subcategories_array = array();
                zen_get_subcategories($subcategories_array, $_GET['categories_id']);
                $where_str .= " AND p2c.products_id = p.products_id AND p2c.products_id = pd.products_id AND (p2c.categories_id = :categoriesID";

                $where_str = $db->bindVars($where_str, ':categoriesID', $_GET['categories_id'], 'integer');

                if (sizeof($subcategories_array) > 0) {
                    $where_str .= " OR p2c.categories_id in (";
                    for ($i = 0, $n = sizeof($subcategories_array); $i < $n; $i++) {
                        $where_str .= " :categoriesID";
                        if ($i + 1 < $n) $where_str .= ",";
                        $where_str = $db->bindVars($where_str, ':categoriesID', $subcategories_array[$i], 'integer');
                    }
                    $where_str .= ")";
                }
                $where_str .= ")";
            } else {
                $where_str .= " AND p2c.products_id = p.products_id AND p2c.products_id = pd.products_id AND pd.language_id = :languagesID AND p2c.categories_id = :categoriesID";

                $where_str = $db->bindVars($where_str, ':categoriesID', $_GET['categories_id'], 'integer');
                $where_str = $db->bindVars($where_str, ':languagesID', $_SESSION['languages_id'], 'integer');
            }
        }

        if (isset($_GET['manufacturers_id']) && zen_not_null($_GET['manufacturers_id'])) {
            $where_str .= " AND m.manufacturers_id = :manufacturersID";
            $where_str = $db->bindVars($where_str, ':manufacturersID', $_GET['manufacturers_id'], 'integer');
        }

//Custom Search BOF
        if (isset($_REQUEST['keyword'])) {
            $where_str .= " AND ( MATCH (pd.products_name" . (($search_in_description == 1) ? ", pd.products_description" : "") . ") AGAINST(\"" . $boolean_keywords . "\" IN BOOLEAN MODE)";
            $where_str .= " OR MATCH(p.products_model) AGAINST(\"" . $boolean_keywords . "\" IN BOOLEAN MODE)";
            $where_str .= " OR MATCH(m.manufacturers_name) AGAINST(\"" . $boolean_keywords . "\" IN BOOLEAN MODE)";
            $where_str .= " OR MATCH(mtpd.metatags_keywords, mtpd.metatags_description) AGAINST(\"" . $boolean_keywords . "\" IN BOOLEAN MODE)) ";
        }
//Custom Search EOF

        if (!isset($keywords) || $keywords == "") {
            $where_str .= ')';
        }
        if (isset($_GET['alpha_filter_id']) && (int)$_GET['alpha_filter_id'] > 0) {
            $alpha_sort = " and (pd.products_name LIKE '" . chr((int)$_GET['alpha_filter_id']) . "%') ";
            $where_str .= $alpha_sort;
        } else {
            $alpha_sort = '';
            $where_str .= $alpha_sort;
        }

        if (isset($_GET['dfrom']) && zen_not_null($_GET['dfrom']) && ($_GET['dfrom'] != DOB_FORMAT_STRING)) {
            $where_str .= " AND p.products_date_added >= :dateAdded";
            $where_str = $db->bindVars($where_str, ':dateAdded', zen_date_raw($dfrom), 'date');
        }

        if (isset($_GET['dto']) && zen_not_null($_GET['dto']) && ($_GET['dto'] != DOB_FORMAT_STRING)) {
            $where_str .= " and p.products_date_added <= :dateAdded";
            $where_str = $db->bindVars($where_str, ':dateAdded', zen_date_raw($dto), 'date');
        }

        $rate = $currencies->get_value($_SESSION['currency']);
        if ($rate) {
            $pfrom = $_GET['pfrom'] / $rate;
            $pto = $_GET['pto'] / $rate;
        }

        if (DISPLAY_PRICE_WITH_TAX == 'true') {
            if ($pfrom) {
                $where_str .= " AND (p.products_price_sorter * IF(gz.geo_zone_id IS null, 1, 1 + (tr.tax_rate / 100)) >= :price)";
                $where_str = $db->bindVars($where_str, ':price', $pfrom, 'float');
            }
            if ($pto) {
                $where_str .= " AND (p.products_price_sorter * IF(gz.geo_zone_id IS null, 1, 1 + (tr.tax_rate / 100)) <= :price)";
                $where_str = $db->bindVars($where_str, ':price', $pto, 'float');
            }
        } else {
            if ($pfrom) {
                $where_str .= " and (p.products_price_sorter >= :price)";
                $where_str = $db->bindVars($where_str, ':price', $pfrom, 'float');
            }
            if ($pto) {
                $where_str .= " and (p.products_price_sorter <= :price)";
                $where_str = $db->bindVars($where_str, ':price', $pto, 'float');
            }
        }


// Notifier Point
        $zco_notifier->notify('NOTIFY_SEARCH_WHERE_STRING');


        if ((DISPLAY_PRICE_WITH_TAX == 'true') && ((isset($_GET['pfrom']) && zen_not_null($_GET['pfrom'])) || (isset($_GET['pto']) && zen_not_null($_GET['pto'])))) {
            $where_str .= " group by p.products_id, tr.tax_priority";
        }
        $where_str .= ')';
// sort by
        $order_str = ' ORDER BY ';
        switch ($_GET['sortby']) {
            default:
                $order_str .= 'weight DESC, p.products_ordered desc, pd.products_name';
                break;
            case '2':
                $order_str .= 'p.products_ordered desc, pd.products_name';
                break;
            case '1':
                $order_str .= 'p.products_date_added desc, pd.products_name';
                break;
            case '3':
                $order_str .= 'p.products_price_sorter desc, pd.products_name';
                break;
            case '4':
                $order_str .= 'p.products_price_sorter asc, pd.products_name';
                break;
            case '5':
                $order_str .= 'pd.products_name asc, pd.products_name';
                break;
            case '6':
                $order_str .= 'pd.products_name desc, pd.products_name';
                break;
        }
        if (!isset($_POST['limit'])) {
            $limit_number = 50;
            $limit_str = " LIMIT " . $limit_number . ' ';
        } else {
            $limit_number = (int)$_POST['limit'];
            $limit_str = " LIMIT " . $limit_number . ' ';
        }
        if (!isset($_POST['offset']) || $_POST['offset'] == 0) {
            $offset_number = 0;
        } else {
            $offset_number = (int)$_POST['offset'];
            $limit_str .= " OFFSET " . $offset_number;
        }
        if ($limit_number == 0) {
            $limit_str = '';
        }
        $listing_sql = $select_str . $from_str . $where_str . $order_str . $limit_str;
//        $return_array['listing_sql'] = $listing_sql;
        $listing_query = $db->Execute($listing_sql);
        $listing_count = 0;
        while (!$listing_query->EOF) {
            if ($listing_query->fields['products_image'] == '') {
                $product['products_image'] = DIR_WS_HTTPS_CATALOG . DIR_WS_IMAGES . 'no_picture.gif';
            } else {
                $product['products_image'] = DIR_WS_HTTPS_CATALOG . DIR_WS_IMAGES . $listing_query->fields['products_image'];
            }
            $product['bisn_text'] = '';
            if (BACK_IN_STOCK_ENABLE == "true" && $listing_query->fields['products_quantity'] <= 0) {
                $product['bisn_text'] = '<a class="back-in-stock-listing-popup-link" href="#back-in-stock-popup-wrapper" onclick="searchReloadedBISNClick(' . $listing_query->fields['products_id'] . ')">' . BACK_IN_STOCK_LINK . '</a>';
                $product['bisn_text'] .= zen_draw_hidden_field('bis-product-id', (int)$listing_query->fields['products_id'], 'class="bis-product-id"');
            }
            $product['products_id'] = $listing_query->fields['products_id'];
            $product['products_image_alt'] = ($listing_query->fields['products_image_alt'] != '') ? $listing_query->fields['products_image_alt'] : $listing_query->fields['products_name'];
            $product['products_quantity'] = $listing_query->fields['products_quantity'];
            $product['products_name'] = $listing_query->fields['products_name'];
            $product['products_price'] = number_format($listing_query->fields['products_price_sorter'], 2);
            $product['products_description'] = $listing_query->fields['products_description'];
            $product['products_title'] = str_replace(array("\r", "\n"), '', strip_tags($listing_query->fields['products_description']));
            $product['products_price_sorter'] = number_format($listing_query->fields['products_price_sorter'], 2);
            $product['products_minimum'] = $listing_query->fields['products_quantity_order_min'];
            $product['products_maximum'] = $listing_query->fields['products_quantity_order_max'];
            $product['products_units'] = zen_get_products_quantity_min_units_display($listing_query->fields['products_id']);
            $product['products_free_ship'] = $listing_query->fields['product_is_always_free_shipping'];
            $product['products_shipping_text'] = ($listing_query->fields['product_is_always_free_shipping'] == 1) ? 'Free Shipping' : '';
            $product['products_link'] = zen_href_link(zen_get_info_page($listing_query->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($listing_query->fields['master_categories_id']) . '&products_id=' . $listing_query->fields['products_id']);

            $listing_count++;
            $clear_fix_class = 'clearfix visible-xs ';
            if ($listing_count % 3 == 0) $clear_fix_class .= 'visible-sm ';
            if ($listing_count % 3 == 0) $clear_fix_class .= 'visible-md ';
            if ($listing_count % 4 == 0) $clear_fix_class .= 'visible-lg ';
            $product['clear_fix'] = $clear_fix_class;

            $return_array['products'][] = $product;
            $listing_query->MoveNext();
        }
        if (isset($_GET['only_products']) && $_GET['only_products'] == 'y') {
            return $return_array['products'];
        } else {
            $listing_count_sql = $select_str . $from_str . $where_str;
            $count_query = $db->Execute($listing_count_sql);
            $return_array['listing_sql'] = $listing_sql;
            $count_records = $count_query->RecordCount();
            $return_array['total_count'] = $count_records;
            if (isset($_POST['offset']) && $offset_number > 0) {
                $return_array['pageBack']['status'] = 1;
                $return_array['pageBack']['max'] = $limit_number;
                $return_array['pageBack']['offset'] = $offset_number - $limit_number;
            } else {
                $return_array['pageBack']['status'] = 0;
            }
            if ($count_records > ($offset_number + $limit_number) && $limit_number != 0) {
                $return_array['pageNext']['status'] = 1;
                $return_array['pageNext']['max'] = $limit_number;
                $return_array['pageNext']['offset'] = $offset_number + $limit_number;
            } else {
                $return_array['pageNext']['status'] = 0;
            }
            $return_array['search_string'] = $_POST['keyword'];
            return $return_array;

        }
    }
}