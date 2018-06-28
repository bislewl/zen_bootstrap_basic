<?php
/**
 * Created by PhpStorm.
 * User: bislewl
 * Date: 6/25/2018
 * Time: 12:23 PM
 */


// move bootstrap defines to bootstrap options
$sql = array();
$sql[] = "INSERT INTO " . TABLE_BOOTSTRAP_BASIC_OPTIONS . "(`options_name`, `options_define`, `options_group`, `options_input_type`, `options_value_default`, `options_value`) VALUES ('Blogger Link','BOOTSTRAP_BASIC_BLOGGER_LINK','main','text','https://blogger.com','" . BOOTSTRAP_BASIC_BLOGGER_LINK . "')";
$sql[] = "INSERT INTO " . TABLE_BOOTSTRAP_BASIC_OPTIONS . "(`options_name`, `options_define`, `options_group`, `options_input_type`, `options_value_default`, `options_value`) VALUES ('Facebook Link','BOOTSTRAP_BASIC_FACEBOOK_LINK','main','text','https://facebook.com','" . BOOTSTRAP_BASIC_FACEBOOK_LINK . "')";
$sql[] = "INSERT INTO " . TABLE_BOOTSTRAP_BASIC_OPTIONS . "(`options_name`, `options_define`, `options_group`, `options_input_type`, `options_value_default`, `options_value`) VALUES ('Facebook App ID','BOOTSTRAP_BASIC_FACEBOOK_APP_ID','main','text','','" . BOOTSTRAP_BASIC_FACEBOOK_APP_ID . "')";
$sql[] = "INSERT INTO " . TABLE_BOOTSTRAP_BASIC_OPTIONS . "(`options_name`, `options_define`, `options_group`, `options_input_type`, `options_value_default`, `options_value`) VALUES ('Instagram Link','BOOTSTRAP_BASIC_INSTAGRAM_LINK','main','text','https://instagram.com','" . BOOTSTRAP_BASIC_INSTAGRAM_LINK . "')";
$sql[] = "INSERT INTO " . TABLE_BOOTSTRAP_BASIC_OPTIONS . "(`options_name`, `options_define`, `options_group`, `options_input_type`, `options_value_default`, `options_value`) VALUES ('LinkedIn Link','BOOTSTRAP_BASIC_LINKEDIN_LINK','main','text','https://linkedin.com','" . BOOTSTRAP_BASIC_LINKEDIN_LINK . "')";
$sql[] = "INSERT INTO " . TABLE_BOOTSTRAP_BASIC_OPTIONS . "(`options_name`, `options_define`, `options_group`, `options_input_type`, `options_value_default`, `options_value`) VALUES ('Pintrest Link','BOOTSTRAP_BASIC_PINTEREST_LINK','main','text','https://pinterest.com','" . BOOTSTRAP_BASIC_PINTEREST_LINK . "')";
$sql[] = "INSERT INTO " . TABLE_BOOTSTRAP_BASIC_OPTIONS . "(`options_name`, `options_define`, `options_group`, `options_input_type`, `options_value_default`, `options_value`) VALUES ('Twitter Link','BOOTSTRAP_BASIC_TWITTER_LINK','main','text','https://twitter.com','" . BOOTSTRAP_BASIC_TWITTER_LINK . "')";
$sql[] = "INSERT INTO " . TABLE_BOOTSTRAP_BASIC_OPTIONS . "(`options_name`, `options_define`, `options_group`, `options_input_type`, `options_value_default`, `options_value`) VALUES ('YouTube Link','BOOTSTRAP_BASIC_YOUTUBE_LINK','main','text','https://youtube.com','" . BOOTSTRAP_BASIC_YOUTUBE_LINK . "')";
$sql[] = "INSERT INTO " . TABLE_BOOTSTRAP_BASIC_OPTIONS . "(`options_name`, `options_define`, `options_group`, `options_input_type`, `options_value_default`, `options_value`) VALUES ('Number of Categories in Footer','BOOTSTRAP_BASIC_CATEGORIES_FOOTER_COUNT','main','text','5','" . BOOTSTRAP_BASIC_CATEGORIES_FOOTER_COUNT . "')";

// delete old bootstrap defines
$sql[] = "DELETE FROM `configuration` WHERE configuration_key = 'BOOTSTRAP_BASIC_BLOGGER_LINK'";
$sql[] = "DELETE FROM `configuration` WHERE configuration_key = 'BOOTSTRAP_BASIC_FACEBOOK_LINK'";
$sql[] = "DELETE FROM `configuration` WHERE configuration_key = 'BOOTSTRAP_BASIC_FACEBOOK_APP_ID'";
$sql[] = "DELETE FROM `configuration` WHERE configuration_key = 'BOOTSTRAP_BASIC_INSTAGRAM_LINK'";
$sql[] = "DELETE FROM `configuration` WHERE configuration_key = 'BOOTSTRAP_BASIC_PINTEREST_LINK'";
$sql[] = "DELETE FROM `configuration` WHERE configuration_key = 'BOOTSTRAP_BASIC_LINKEDIN_LINK'";
$sql[] = "DELETE FROM `configuration` WHERE configuration_key = 'BOOTSTRAP_BASIC_TWITTER_LINK'";
$sql[] = "DELETE FROM `configuration` WHERE configuration_key = 'BOOTSTRAP_BASIC_YOUTUBE_LINK'";
$sql[] = "DELETE FROM `configuration` WHERE configuration_key = 'BOOTSTRAP_BASIC_CATEGORIES_FOOTER_COUNT'";

foreach($sql as $sql_item){
	$db->Execute($sql_item);
}
