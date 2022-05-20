<?php
/**
 * Plugin Name: SLiMS OAuth
 * Plugin URI: -
 * Description: -
 * Version: 1.0.0
 * Author: Drajat Hasan
 * Author URI: https://github.com/drajathasan
 */

// get plugin instance
$plugin = \SLiMS\Plugins::getInstance();

// registering menus or hook
// Force page member to use this plugin
$plugin->registerMenu("opac", "member", __DIR__ . "/pages/member.inc.php");
// Admin config
$plugin->registerMenu("system", "OAuth", __DIR__ . "/pages/admin.inc.php");
