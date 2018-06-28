<?php
/**
 * Created by PhpStorm.
 * User: bislewl
 * Date: 2/28/2018
 * Time: 12:06 AM
 */


if (!$sniffer->field_exists(TABLE_CATEGORIES, 'categories_header_image')) $db->Execute("ALTER TABLE " . TABLE_CATEGORIES . " ADD categories_header_image varchar(125) NOT NULL;");
if (!$sniffer->field_exists(TABLE_PRODUCTS_DESCRIPTION, 'products_image_alt')) $db->Execute("ALTER TABLE " . TABLE_PRODUCTS_DESCRIPTION . " ADD products_image_alt varchar(245) NULL default '';");
if (!$sniffer->field_exists(TABLE_BANNERS, 'slider_button_text')) $db->Execute("ALTER TABLE " . TABLE_BANNERS . " ADD slider_button_text varchar(245) NULL default '';");