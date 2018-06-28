<?php
/**
 *  zcAdditionalImagesUploader.php
 *
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  2/19/2018 12:28 PM Modified in zencart_additional_images_uploader
 *
 */

class zcAdditionalImagesUploader extends base
{

    function __construct()
    {

    }

    function getProductMainImage($product_id)
    {
        global $db;
        $product_image = $db->Execute("SELECT products_image FROM " . TABLE_PRODUCTS . " WHERE products_id='" . (int)$product_id . "'");
        if ($product_image->RecordCount() > 0) {
            $products_image = $product_image->fields['products_image'];
            if ($products_image == '') {
                $error = 'Error: Image Required';
            }
        } else {
            $error = 'Error: Invalid Product Selected';
        }
        if (isset($error)) {
            return $error;
        } else {
            return $products_image;
        }

    }

    function getAdditionalImages()
    {
        $product_id = (int)zen_db_prepare_input($_POST['product_id']);
        $result['products_id'] = $product_id;
        $products_image = $this->getProductMainImage($product_id);
        $result['products_image'] = DIR_WS_IMAGES . $products_image;

        // prepare image name
        $products_image_extension = substr($products_image, strrpos($products_image, '.'));
        $products_image_base = str_replace($products_image_extension, '', $products_image);

        $images_array = array();

        if (strrpos($products_image, '/')) {
            $products_image_match = substr($products_image, strrpos($products_image, '/') + 1);
            $products_image_match = str_replace($products_image_extension, '', $products_image_match);
            $products_image_base = $products_image_match;
        }

        $products_image_directory = str_replace($products_image, '', substr($products_image, strrpos($products_image, '/')));
        if ($products_image_directory != '') {
            $products_image_directory = DIR_WS_IMAGES . str_replace($products_image_directory, '', $products_image) . "/";
        } else {
            $products_image_directory = DIR_WS_IMAGES;
        }
        $image_count = 1;
        $search_directory = DIR_FS_CATALOG . $products_image_directory;
        $glob_search = $search_directory . $products_image_base . '_[0-9][0-9]' . $products_image_extension;
        $files = glob($glob_search);
        $result['glob_search'] = $glob_search;
        $result['image_base'] = $products_image_base;
        $result['extension'] = $products_image_extension;
        $result['search_dir'] = $search_directory;
        $images_array[] = array('filename' => HTTPS_CATALOG_SERVER . DIR_WS_HTTPS_CATALOG . $products_image_directory . $products_image_base . $products_image_extension);
        $result['files'] = $files;
        if (count($files > 0)) {
            foreach ($files as $file) {
                $image_count++;
                $image_suffix_number = str_replace($search_directory . $products_image_base . '_', '', $file);
                $image_suffix_number = str_replace($products_image_extension, '', $image_suffix_number);
                $images_array[] = array(
                    'filename' => str_replace(DIR_FS_CATALOG, HTTPS_CATALOG_SERVER . DIR_WS_HTTPS_CATALOG, $file),
                    'count' => $image_count,
                    'suffix_number' => $image_suffix_number
                );
            }
        }
        $result['last_image_suffix'] = (int)$image_suffix_number;
        $next_image_suffix = (int)$image_suffix_number + 1;
        $text_image_suffix = str_pad($next_image_suffix, 2, '0', STR_PAD_LEFT);
        $new_img_dir = str_replace(DIR_WS_IMAGES, '', $products_image_directory);
        $result['new_filename'] = $products_image_base . '_' . $text_image_suffix . $products_image_extension;
        $result['destination'] = $new_img_dir;
        $result['next_image_number'] = $image_count;
        $result['success'] = 'Success: Found Images';
        $result['images'] = $images_array;

        return $result;
    }

    function uploadAdditionalImage()
    {
        $result = array();
        $product_id = (int)zen_db_prepare_input($_POST['product_id']);
        $new_filename = zen_db_prepare_input($_POST['new_filename']);
        $new_destination = zen_db_prepare_input($_POST['destination']);
        $result['image_target'] = $new_filename;
        $addtl_image = new upload('additional_image_file');
        $addtl_image->set_destination(DIR_FS_CATALOG_IMAGES . $new_destination);
        if ($addtl_image->parse() == false) {
            $result['error'] = 'Error: unable to parse';
        }
//        $addtl_image->set_filename($new_filename);
        if ($addtl_image->save() == false) {
            $result['error'] = 'Error: unable to save';
        }

        if (!isset($result['error'])) {
            $result['success'] = 'Success: Image Uploaded';

            copy(DIR_FS_CATALOG_IMAGES . $new_destination . $addtl_image->filename, DIR_FS_CATALOG_IMAGES .  $new_destination . $new_filename);
            $result['image_name'] = HTTPS_CATALOG_SERVER . DIR_WS_HTTPS_CATALOG . DIR_WS_IMAGES . $new_filename . ' was ' . zen_db_prepare_input($addtl_image->filename);
        }
        $return['result'] = $result;
        return $return;
    }

    function searchProducts()
    {
        global $db;
        $products = array();
        $search = zen_db_prepare_input($_POST['search']);
        $return['query'] = $search;
        $products_query_raw = $db->Execute("SELECT p.products_id, pd.products_name,  p.products_price,
                                       p.products_model, p.product_is_free, p.products_sort_order, p.master_categories_id
                                FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                                WHERE p.products_id = pd.products_id
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and (p.products_id = p2c.products_id
                                and p.master_categories_id = p2c.categories_id)
                                and (
                                pd.products_name like '%" . $search . "%'
                                or pd.products_description like '%" . $search . "%'
                                or p.products_id = '" . $search . "'
                                or p.products_model like '%" . $search . "%')" .
            ' ORDER BY p.products_sort_order ASC');
        while (!$products_query_raw->EOF) {
            $category = '';
            $cpath = zen_get_product_path((int)$products_query_raw->fields['products_id']);
            $cpath_array = explode('_', $cpath);
            foreach ($cpath_array as $cat_id) {
                $category .= ' / ' . zen_get_category_name((int)$cat_id, 1);
            }
            $products[] = array(
                'products_id' => $products_query_raw->fields['products_id'],
                'products_name' => $products_query_raw->fields['products_name'],
                'products_model' => $products_query_raw->fields['products_model'],
                'products_category' => $category,
            );
            $products_query_raw->MoveNext();
        }
        $return['products'] = $products;
        return $return;
    }

    function checkProductID()
    {
        global $db;
        $products_id = (int)zen_db_prepare_input($_POST['product_id']);
        $products_query = $db->Execute("SELECT p.products_id, pd.products_name, p.products_image FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd 
        WHERE p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' AND p.products_id='" . $products_id . "'");
        if ($products_query->RecordCount() > 0) {
            $result['products'] = array(
                'product_id' => $products_query->fields['products_id'],
                'product_name' => $products_query->fields['products_name'],
                'product_image' => $products_query->fields['products_image']
            );
        } else {
            $result['error'] = 'invalid';
        }
        return $result;
    }
}