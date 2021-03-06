<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: admin_header.php
| Author: PHP-Fusion Development Team
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

define("ADMIN_PANEL", TRUE);
if (fusion_get_settings("maintenance") == "1" && ((iMEMBER && fusion_get_settings("maintenance_level") == USER_LEVEL_MEMBER && $userdata['user_id'] != "1") || (fusion_get_settings("maintenance_level") < $userdata['user_level']))) {
	redirect(BASEDIR."maintenance.php");
}

require_once INCLUDES."breadcrumbs.php";
require_once INCLUDES."header_includes.php";
require_once THEMES."templates/render_functions.php";
$settings = fusion_get_settings();
if (preg_match("/^([a-z0-9_-]){2,50}$/i", $settings['admin_theme']) && file_exists(THEMES."admin_themes/".$settings['admin_theme']."/acp_theme.php")) {
	require_once THEMES."admin_themes/".$settings['admin_theme']."/acp_theme.php";
} else {
	die('WARNING: Invalid Admin Panel Theme'); // TODO: improve this
}

if (iMEMBER) {
	$result = dbquery("UPDATE ".DB_USERS." SET user_lastvisit='".time()."', user_ip='".USER_IP."', user_ip_type='".USER_IP_TYPE."' WHERE user_id='".$userdata['user_id']."'");
}

$bootstrap_theme_css_src = '';
// Load bootstrap
if ($settings['bootstrap']) {
	define('BOOTSTRAPPED', TRUE);
	$bootstrap_theme_css_src = INCLUDES."bootstrap/bootstrap.css";
	add_to_footer("<script type='text/javascript' src='".INCLUDES."bootstrap/bootstrap.min.js'></script>");
	add_to_footer("<script type='text/javascript' src='".INCLUDES."bootstrap/holder.js'></script>");
}

require_once THEMES."templates/panels.php";
ob_start();

require_once ADMIN."admin.php";
$admin = new \PHPFusion\Admin();

// Use infusion_db file to modify admin properties
$infusion_folder = makefilelist(INFUSIONS, ".|..|", "", "folders");
if (!empty($infusion_folder)) {
	foreach($infusion_folder as $folder) {
		if (file_exists(INFUSIONS.$folder."/infusion_db.php")) {
			require_once INFUSIONS.$folder."/infusion_db.php";
		}
	}
}
// If the user is not logged in as admin then don't parse the administration page
// otherwise it could result in bypass of the admin password and one could do
// changes to the system settings without even being logged into Admin Panel.
// After relogin the user can simply click back in browser and their input will
// still be there so nothing is lost
if (!check_admin_pass('')) {
	require_once "footer.php";
	exit;
}