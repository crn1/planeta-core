<?php
/**
 *Plugin Name: Planeta Core
 *Description: Core functionality for Planeta Theme
 *Version: 1.0.0
 *Author: Đorđe G.
 *Author URI: https://github.com/crn1
 *Text Domain: planeta-core
**/

//Planeta Welcome Menu
require_once(dirname(plugin_basename(__FILE__)) . '/welcome.php');
function planeta_register_welcome_page() {
  // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page(
		'Planeta',
		'Planeta',
		'manage_options',
		'planeta_welcome',
		'planeta_get_welcome_page',
		'dashicons-admin-site-alt', 2);

	add_submenu_page(
		'planeta_welcome',
		'Welcome',
		'Welcome',
		'manage_options',
		'planeta_welcome',
		'planeta_get_welcome_page', 0);
}

add_action('admin_menu', 'planeta_register_welcome_page');
//Register Custom Post Types
include_once get_theme_file_path('inc/post-types/testimonial.php');
include_once get_theme_file_path('inc/post-types/project.php');
include_once get_theme_file_path('inc/post-types/client.php');
include_once get_theme_file_path('inc/post-types/tech.php');
include_once get_theme_file_path('inc/post-types/service.php');
include_once get_theme_file_path('inc/post-types/team.php');
include_once get_theme_file_path('inc/post-types/number.php');
include_once get_theme_file_path('inc/post-types/price.php');
include_once get_theme_file_path('inc/post-types/generic.php');

//Internationalization
add_action('init', 'planeta_core_i18n_setup');
function planeta_core_i18n_setup()
{
	load_plugin_textdomain('planeta', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

?>
