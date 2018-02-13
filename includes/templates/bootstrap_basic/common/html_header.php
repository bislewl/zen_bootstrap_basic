<?php
/**
 *  html_header.php
 *
 * @package
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  4/10/2016 9:38 PM Modified in zen_bootstrap_basic
 */


$zco_notifier->notify('NOTIFY_HTML_HEAD_START', $current_page_base, $template_dir);

// Prevent clickjacking risks by setting X-Frame-Options:SAMEORIGIN
header('X-Frame-Options:SAMEORIGIN');

/**
 * load the module for generating page meta-tags
 */
require(DIR_WS_MODULES . zen_get_module_directory('meta_tags.php'));
/**
 * output main page HEAD tag and related headers/meta-tags, etc
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo META_TAG_TITLE; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>"/>
    <meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>"/>
    <meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>"/>
    <meta http-equiv="imagetoolbar" content="no"/>
    <meta name="author" content="<?php echo STORE_NAME ?>"/>
    <link rel="dns-prefetch" href="https://maxcdn.bootstrapcdn.com"/>
    <link rel="dns-prefetch" href="https://code.jquery.com"/>
    <?php if (defined('ROBOTS_PAGES_TO_SKIP') && in_array($current_page_base, explode(",", constant('ROBOTS_PAGES_TO_SKIP'))) || $current_page_base == 'down_for_maintenance' || $robotsNoIndex === true) { ?>
        <meta name="robots" content="noindex, nofollow"/>
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>

    <?php if (defined('FAVICON')) { ?>
        <link rel="icon" href="<?php echo FAVICON; ?>" type="image/x-icon"/>
        <link rel="shortcut icon" href="<?php echo FAVICON; ?>" type="image/x-icon"/>
    <?php } //endif FAVICON ?>

    <base
        href="<?php echo(($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG); ?>"/>
    <?php if (isset($canonicalLink) && $canonicalLink != '') { ?>
        <link rel="canonical" href="<?php echo $canonicalLink; ?>"/>
    <?php }

    // BOF hreflang for multilingual sites
    if (!isset($lng) || (isset($lng) && !is_object($lng))) {
        $lng = new language;
    }
    reset($lng->catalog_languages);
    while (list($key, $value) = each($lng->catalog_languages)) {
        if ($value['id'] == $_SESSION['languages_id']) continue;
        echo '<link rel="alternate" href="' . ($this_is_home_page ? zen_href_link(FILENAME_DEFAULT, 'language=' . $key, $request_type) : $canonicalLink . '&amp;language=' . $key) . '" hreflang="' . $key . '" />' . "\n";
    }
    // EOF hreflang for multilingual sites
    ?>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"/>
    <?php
    /**
     * load all template-specific stylesheets, named like "style*.css", alphabetically
     */
    $directory_array = $template->get_template_part($template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css'), '/^style/', '.css');
    while (list ($key, $value) = each($directory_array)) {
        echo '<link rel="stylesheet" type="text/css" href="' . $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $value . '" />' . "\n";
    }
    /**
     * load stylesheets on a per-page/per-language/per-product/per-manufacturer/per-category basis. Concept by Juxi Zoza.
     */
    $manufacturers_id = (isset($_GET['manufacturers_id'])) ? $_GET['manufacturers_id'] : '';
    $tmp_products_id = (isset($_GET['products_id'])) ? (int)$_GET['products_id'] : '';
    $tmp_pagename = ($this_is_home_page) ? 'index_home' : $current_page_base;
    if ($current_page_base == 'page' && isset($ezpage_id)) $tmp_pagename = $current_page_base . (int)$ezpage_id;
    $sheets_array = array('/' . $_SESSION['language'] . '_stylesheet',
        '/' . $tmp_pagename,
        '/' . $_SESSION['language'] . '_' . $tmp_pagename,
        '/c_' . $cPath,
        '/' . $_SESSION['language'] . '_c_' . $cPath,
        '/m_' . $manufacturers_id,
        '/' . $_SESSION['language'] . '_m_' . (int)$manufacturers_id,
        '/p_' . $tmp_products_id,
        '/' . $_SESSION['language'] . '_p_' . $tmp_products_id
    );
    while (list ($key, $value) = each($sheets_array)) {
        //echo "<!--looking for: $value-->\n";
        $perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . $value . '.css';
        if (file_exists($perpagefile)) echo '<link rel="stylesheet" type="text/css" href="' . $perpagefile . '" />' . "\n";
    }

    /**
     *  custom category handling for a parent and all its children ... works for any c_XX_XX_children.css  where XX_XX is any parent category
     */
    $tmp_cats = explode('_', $cPath);
    $value = '';
    foreach ($tmp_cats as $val) {
        $value .= $val;
        $perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/c_' . $value . '_children.css';
        if (file_exists($perpagefile)) echo '<link rel="stylesheet" type="text/css" href="' . $perpagefile . '" />' . "\n";
        $perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $_SESSION['language'] . '_c_' . $value . '_children.css';
        if (file_exists($perpagefile)) echo '<link rel="stylesheet" type="text/css" href="' . $perpagefile . '" />' . "\n";
        $value .= '_';
    }

    /**
     * load printer-friendly stylesheets -- named like "print*.css", alphabetically
     */
    $directory_array = $template->get_template_part($template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css'), '/^print/', '.css');
    sort($directory_array);
    while (list ($key, $value) = each($directory_array)) {
        echo '<link rel="stylesheet" type="text/css" media="print" href="' . $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $value . '" />' . "\n";
    }

    /** CDN for jQuery & bootstrap **/
    ?>

    <?php
    // DEBUG: echo '<!-- I SEE cat: ' . $current_category_id . ' || vs cpath: ' . $cPath . ' || page: ' . $current_page . ' || template: ' . $current_template . ' || main = ' . ($this_is_home_page ? 'YES' : 'NO') . ' -->';
    $zco_notifier->notify('NOTIFY_HTML_HEAD_END', $current_page_base);
    ?>

</head>
<?php
// NOTE: Blank line following is intended: