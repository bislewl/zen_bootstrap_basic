<?php
// use $configuration_group_id where needed

// For Admin Pages

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150) { // continue Zen Cart 1.5.0
    $admin_page = 'configBoxPrinting';
  // delete configuration menu
  $db->Execute("DELETE FROM ".TABLE_ADMIN_PAGES." WHERE page_key = '".$admin_page."' LIMIT 1;");
  // add configuration menu
  if (!zen_page_key_exists($admin_page)) {
    if ((int)$configuration_group_id > 0) {
      zen_register_admin_page($admin_page,
                              'BOX_CONFIGURATION_BOOTSTRAP_BASIC',
                              'FILENAME_CONFIGURATION',
                              'gID=' . $configuration_group_id, 
                              'configuration', 
                              'Y',
                              $configuration_group_id);
        
      $messageStack->add('Enabled Bootstrap Basic Configuration Menu.', 'success');
    }
  }
}


$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOOTSTRAP_BASIC_FACEBOOK_LINK', 'Facebook Link', 'https://facebook.com', 'Link to Facebook', 101);");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOOTSTRAP_BASIC_TWITTER_LINK', 'Twitter Link', 'https://twitter.com', 'Link to twitter', 102);");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOOTSTRAP_BASIC_PINTEREST_LINK', 'Pinterest Link', 'https://pinterest.com', 'Link to Pinterest', 103);");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order) VALUES (" . (int) $configuration_group_id . ", 'BOOTSTRAP_BASIC_YOUTUBE_LINK', 'YouTube Link', 'https://youtube.com', 'Link to Youtube', 104);");