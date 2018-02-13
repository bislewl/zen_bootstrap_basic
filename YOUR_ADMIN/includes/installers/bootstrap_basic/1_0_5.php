<?php
/**
 *  1_0_5.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/8/2017 9:00 AM Modified in  everbrite_coatings
 */


$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150) { // continue Zen Cart 1.5.0
    $old_admin_page = 'hiddenBootBasicAjax';
    $old_file_defines = 'FILENAME_BOOTSTRAP_BASIC_AJAX';
    $old_pages = $db->Execute("SELECT * FROM ".TABLE_ADMIN_PAGES. " WHERE page_key='".$old_admin_page."' OR main_page='".$old_file_defines."'");
    // delete configuration menu
    if($old_pages->RecordCount() > 0) {
        while (!$old_pages->EOF) {
            $db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $old_pages->fields['page_key'] . "' LIMIT 1;");
            $db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES_TO_PROFILES . " WHERE page_key = '" . $old_pages->fields['page_key'] . "' LIMIT 1;");
            $old_pages->MoveNext();
        }
        $messageStack->add('Removed Bootstrap Basic Ajax Files', 'success');
    }
    // add configuration menu
    $admin_page = FILENAME_AJAX;
    $admin_file_defines = 'FILENAME_AJAX';
    if (!zen_page_key_exists($admin_page)) {
        if ((int)$configuration_group_id > 0) {
            zen_register_admin_page($admin_page,
                'BOX_HIDDEN_AJAX',
                'FILENAME_AJAX',
                '',
                'ajax',
                'N',
                $configuration_group_id);

            $messageStack->add('Enabled Ajax Page Registration', 'success');
        }
    }
}