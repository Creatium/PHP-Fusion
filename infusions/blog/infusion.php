<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: J.Falk (Domi)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

include LOCALE.LOCALESET."setup.php";

// Infusion general information
$inf_title = $locale['blog']['title'];
$inf_description = $locale['blog']['description'];
$inf_version = "1.00";
$inf_developer = "PHP Fusion Development Team";
$inf_email = "";
$inf_weburl = "https://www.php-fusion.co.uk";
$inf_folder = "blog";

// Multilanguage table for Administration
$inf_mlt[1] = array(
"title" => $locale['blog']['title'], 
"rights" => "BL",
);

// Create tables
$inf_newtable[1] = DB_BLOG." (
	blog_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	blog_subject VARCHAR(200) NOT NULL DEFAULT '',
	blog_image VARCHAR(100) NOT NULL DEFAULT '',
	blog_image_t1 VARCHAR(100) NOT NULL DEFAULT '',
	blog_image_t2 VARCHAR(100) NOT NULL DEFAULT '',
	blog_ialign VARCHAR(15) NOT NULL DEFAULT '',
	blog_cat MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
	blog_blog TEXT NOT NULL,
	blog_extended TEXT NOT NULL,
	blog_keywords VARCHAR(250) NOT NULL DEFAULT '',
	blog_breaks CHAR(1) NOT NULL DEFAULT '',
	blog_name MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '1',
	blog_datestamp INT(10) UNSIGNED NOT NULL DEFAULT '0',
	blog_start INT(10) UNSIGNED NOT NULL DEFAULT '0',
	blog_end INT(10) UNSIGNED NOT NULL DEFAULT '0',
	blog_visibility TINYINT(4) NOT NULL DEFAULT '0',
	blog_reads INT(10) UNSIGNED NOT NULL DEFAULT '0',
	blog_draft TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	blog_sticky TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	blog_allow_comments TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
	blog_allow_ratings TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
	blog_language VARCHAR(50) NOT NULL DEFAULT '".LANGUAGE."',
	PRIMARY KEY (blog_id),
	KEY blog_datestamp (blog_datestamp),
	KEY blog_reads (blog_reads)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COLLATE=utf8_unicode_ci";

$inf_newtable[2] = DB_BLOG_CATS." (
	blog_cat_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	blog_cat_parent MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
	blog_cat_name VARCHAR(100) NOT NULL DEFAULT '',
	blog_cat_image VARCHAR(100) NOT NULL DEFAULT '',
	blog_cat_language VARCHAR(50) NOT NULL DEFAULT '".LANGUAGE."',
	PRIMARY KEY (blog_cat_id)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COLLATE=utf8_unicode_ci";

// Automatic enable of the latest articles panel
$inf_insertdbrow[1] = DB_PANELS." (panel_name, panel_filename, panel_content, panel_side, panel_order, panel_type, panel_access, panel_display, panel_status, panel_url_list, panel_restriction) VALUES('Blog archive panel', 'blog_archive_panel', '', '1', '5', 'file', '0', '0', '1', '', '')";

// Position these links under Content Administration
$inf_insertdbrow[2] = DB_ADMIN." (admin_rights, admin_image, admin_title, admin_link, admin_page) VALUES('BLC', 'blog_cats.gif', '".$locale['setup_3054']."', '".INFUSIONS."blog/blog_cats_admin.php', '1')";
$inf_insertdbrow[3] = DB_ADMIN." (admin_rights, admin_image, admin_title, admin_link, admin_page) VALUES('BLOG', 'blog.png', '".$locale['setup_3055']."', '".INFUSIONS."blog/blog_admin.php', '1')";
$inf_insertdbrow[4] = DB_ADMIN." (admin_rights, admin_image, admin_title, admin_link, admin_page) VALUES('S13', 'settings_blog.gif', '".$locale['setup_3055']."', '".INFUSIONS."blog/settings_blog.php', '4')";

// Create a link for all installed languages
if (!empty($settings['enabled_languages'])) {
$enabled_languages = explode('.', $settings['enabled_languages']);
$k = 5;
	for ($i = 0; $i < count($enabled_languages); $i++) {
	include LOCALE."".$enabled_languages[$i]."/setup.php";
		$inf_insertdbrow[$k] = DB_SITE_LINKS." (link_name, link_url, link_visibility, link_position, link_window, link_order, link_language) VALUES('".$locale['setup_3055']."', 'infusions/blog/blog.php', '0', '2', '0', '2', '".$enabled_languages[$i]."')";
		$k++;
	}
} else {
		$inf_insertdbrow[5] = DB_SITE_LINKS." (link_name, link_url, link_visibility, link_position, link_window, link_order, link_language) VALUES('".$locale['setup_3055']."', 'infusions/blog/blog.php', '0', '2', '0', '2', '".LANGUAGE."')";
}

// Reset locale
include LOCALE.LOCALESET."setup.php";

if (!empty($settings['enabled_languages'])) {
	for ($i=0;$i<sizeof($enabled_languages );$i++) {
	include LOCALE."".$enabled_languages[$i]."/setup.php";
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3500']."', 'bugs.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3501']."', 'downloads.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3502']."', 'games.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3503']."', 'graphics.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3504']."', 'hardware.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3505']."', 'journal.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3506']."', 'members.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3507']."', 'mods.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3508']."', 'movies.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3509']."', 'network.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3511']."', 'php-fusion.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3512']."', 'security.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3513']."', 'software.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3514']."', 'themes.gif', '".$enabled_languages[$i]."')");
		$result = dbquery("INSERT INTO ".$db_prefix."blog_cats (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3515']."', 'windows.gif', '".$enabled_languages[$i]."')");
	}
}

// Defuse cleaning	
$inf_droptable[1] = DB_BLOG;
$inf_droptable[2] = DB_BLOG_CATS;
$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='Blog archive panel'";
$inf_deldbrow[2] = DB_ADMIN." WHERE admin_rights='BLOG'";
$inf_deldbrow[3] = DB_ADMIN." WHERE admin_rights='BLC'";
$inf_deldbrow[4] = DB_ADMIN." WHERE admin_rights='S13'";
$inf_deldbrow[5] = DB_SITE_LINKS." WHERE link_url='infusions/blog/blog.php'";
$inf_deldbrow[6] = DB_SITE_LINKS." WHERE link_url='submit.php?stype=b'";
